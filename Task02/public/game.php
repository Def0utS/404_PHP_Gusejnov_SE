<?php
$db = new PDO('sqlite:' . __DIR__ . '/../db/progression.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS games (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    player_name    TEXT    NOT NULL,
    played_at      TEXT    NOT NULL,
    result         TEXT    NOT NULL,
    progression    TEXT    NOT NULL,
    hidden_number  INTEGER NOT NULL,
    player_answer  INTEGER NOT NULL
)");

function generateProgression(): array
{
    $start = random_int(1, 50);
    $step  = random_int(2, 15);
    $prog  = [];
    for ($i = 0; $i < 10; $i++) {
        $prog[] = $start + $step * $i;
    }
    return $prog;
}

$isAnswer    = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer']);
$playerName  = htmlspecialchars(trim($_POST['player_name'] ?? 'Игрок'));

if ($isAnswer):
    $progression  = json_decode($_POST['progression'], true);
    $hiddenIndex  = (int)$_POST['hidden_index'];
    $hiddenNumber = (int)$_POST['hidden_number'];
    $playerAnswer = (int)$_POST['answer'];
    $correct      = ($playerAnswer === $hiddenNumber);
    $result       = $correct ? 'win' : 'lose';

    $stmt = $db->prepare(
        "INSERT INTO games (player_name, played_at, result, progression, hidden_number, player_answer)
         VALUES (?, datetime('now','localtime'), ?, ?, ?, ?)"
    );
    $stmt->execute([$playerName, $result, implode(',', $progression), $hiddenNumber, $playerAnswer]);
else:
    $progression  = generateProgression();
    $hiddenIndex  = random_int(0, 9);
    $hiddenNumber = $progression[$hiddenIndex];
    $correct      = null;
endif;

// Строка прогрессии для отображения
$displayItems = [];
foreach ($progression as $idx => $val):
    $displayItems[] = ($idx === $hiddenIndex && !$isAnswer) ? '<strong style="color:#e74c3c">...</strong>' : $val;
endforeach;
$displayStr = implode(', ', $displayItems);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Игра — Арифметическая прогрессия</title>
<style>
  body        { font-family: sans-serif; max-width: 680px; margin: 40px auto; padding: 0 16px; }
  h1          { color: #333; }
  .prog       { font-size: 1.4em; letter-spacing: 2px; margin: 24px 0; padding: 16px; background: #f7f7f7; border-radius: 8px; }
  .win        { color: #27ae60; font-weight: bold; font-size: 1.1em; }
  .lose       { color: #e74c3c; font-weight: bold; font-size: 1.1em; }
  input[type=number] { font-size: 1em; padding: 6px 10px; width: 100px; }
  button      { font-size: 1em; padding: 8px 18px; cursor: pointer; background: #4a90e2; color: #fff; border: none; border-radius: 4px; margin-top: 8px; }
  button:hover{ background: #357abd; }
  .nav        { margin-bottom: 20px; color: #666; }
  a           { color: #4a90e2; }
</style>
</head>
<body>
<h1>🎮 Арифметическая прогрессия</h1>
<p class="nav">
  Игрок: <strong><?= $playerName ?></strong> &nbsp;|&nbsp;
  <a href="index.php">На главную</a> &nbsp;|&nbsp;
  <a href="history.php">История игр</a>
</p>

<?php if ($isAnswer): ?>

  <p>Полная прогрессия:</p>
  <div class="prog"><?= implode(', ', $progression) ?></div>

  <?php if ($correct): ?>
    <p class="win">✅ Правильно! Пропущенное число: <?= $hiddenNumber ?></p>
  <?php else: ?>
    <p class="lose">
      ❌ Неправильно. Ваш ответ: <?= $playerAnswer ?>.
      Правильное число: <?= $hiddenNumber ?>
    </p>
  <?php endif; ?>

  <form action="game.php" method="post">
    <input type="hidden" name="player_name" value="<?= $playerName ?>">
    <button type="submit">🔄 Сыграть ещё раз</button>
  </form>

<?php else: ?>

  <p>Найдите пропущенное число в прогрессии:</p>
  <div class="prog"><?= $displayStr ?></div>

  <form action="game.php" method="post">
    <input type="hidden" name="player_name"   value="<?= $playerName ?>">
    <input type="hidden" name="progression"   value="<?= htmlspecialchars(json_encode($progression)) ?>">
    <input type="hidden" name="hidden_index"  value="<?= $hiddenIndex ?>">
    <input type="hidden" name="hidden_number" value="<?= $hiddenNumber ?>">
    <label>
      Ваш ответ:
      <input type="number" name="answer" required autofocus>
    </label>
    <button type="submit">Проверить</button>
  </form>

<?php endif; ?>
</body>
</html>
