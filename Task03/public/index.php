<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// ── База данных ──────────────────────────────────────────────────────────────
function getDb(): PDO
{
    static $db = null;
    if ($db === null) {
        $db = new PDO('sqlite:' . __DIR__ . '/../db/progression.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->exec("CREATE TABLE IF NOT EXISTS games (
            id             INTEGER PRIMARY KEY AUTOINCREMENT,
            player_name    TEXT    NOT NULL,
            played_at      TEXT    NOT NULL,
            progression    TEXT    NOT NULL,
            hidden_number  INTEGER NOT NULL
        )");
        $db->exec("CREATE TABLE IF NOT EXISTS steps (
            id            INTEGER PRIMARY KEY AUTOINCREMENT,
            game_id       INTEGER NOT NULL,
            player_answer INTEGER NOT NULL,
            result        TEXT    NOT NULL,
            FOREIGN KEY (game_id) REFERENCES games(id)
        )");
    }
    return $db;
}

// ── Приложение ───────────────────────────────────────────────────────────────
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

// Вспомогательная функция: JSON-ответ
function jsonResponse(Response $res, mixed $data, int $status = 200): Response
{
    $res->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    return $res
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
}

// ── Корень: отдаём SPA ───────────────────────────────────────────────────────
$app->get('/', function (Request $req, Response $res): Response {
    $html = file_get_contents(__DIR__ . '/app.html');
    $res->getBody()->write($html);
    return $res->withHeader('Content-Type', 'text/html; charset=utf-8');
});

// ── GET /games — список всех игр ─────────────────────────────────────────────
$app->get('/games', function (Request $req, Response $res): Response {
    $games = getDb()->query("SELECT * FROM games ORDER BY id DESC")->fetchAll();
    return jsonResponse($res, $games);
});

// ── GET /games/{id} — игра + ходы ────────────────────────────────────────────
$app->get('/games/{id:[0-9]+}', function (Request $req, Response $res, array $args): Response {
    $db   = getDb();
    $id   = (int)$args['id'];

    $stmt = $db->prepare("SELECT * FROM games WHERE id = ?");
    $stmt->execute([$id]);
    $game = $stmt->fetch();

    if (!$game) {
        return jsonResponse($res, ['error' => 'Game not found'], 404);
    }

    $stmt = $db->prepare("SELECT * FROM steps WHERE game_id = ?");
    $stmt->execute([$id]);
    $steps = $stmt->fetchAll();

    return jsonResponse($res, ['game' => $game, 'steps' => $steps]);
});

// ── POST /games — создать новую игру ─────────────────────────────────────────
$app->post('/games', function (Request $req, Response $res): Response {
    $body = $req->getParsedBody() ?? [];

    $playerName  = (string)($body['player_name']  ?? 'Игрок');
    $progression = (string)($body['progression']   ?? '');
    $hiddenNum   = (int)($body['hidden_number']    ?? 0);

    $stmt = getDb()->prepare(
        "INSERT INTO games (player_name, played_at, progression, hidden_number)
         VALUES (?, datetime('now','localtime'), ?, ?)"
    );
    $stmt->execute([$playerName, $progression, $hiddenNum]);
    $id = (int)getDb()->lastInsertId();

    return jsonResponse($res, ['id' => $id], 201);
});

// ── POST /step/{id} — записать ход игры ──────────────────────────────────────
$app->post('/step/{id:[0-9]+}', function (Request $req, Response $res, array $args): Response {
    $body   = $req->getParsedBody() ?? [];
    $gameId = (int)$args['id'];

    $playerAnswer = (int)($body['player_answer'] ?? 0);
    $result       = in_array($body['result'] ?? '', ['win', 'lose'], true)
                    ? $body['result']
                    : 'lose';

    $stmt = getDb()->prepare(
        "INSERT INTO steps (game_id, player_answer, result) VALUES (?, ?, ?)"
    );
    $stmt->execute([$gameId, $playerAnswer, $result]);

    return jsonResponse($res, ['ok' => true]);
});

$app->run();
