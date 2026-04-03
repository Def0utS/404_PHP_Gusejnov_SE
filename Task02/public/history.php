<?php
$db = new PDO('sqlite:' . __DIR__ . '/../db/progression.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Таблица могла ещё не существовать при первом открытии history.php
$db->exec("CREATE TABLE IF NOT EXISTS games (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    player_name    TEXT    NOT NULL,
    played_at      TEXT    NOT NULL,
    result         TEXT    NOT NULL,
    progression    TEXT    NOT NULL,
    hidden_number  INTEGER NOT NULL,
    player_answer  INTEGER NOT NULL
)");

$games = $db->query("SELECT * FROM games ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>История игр</title>
<style>
  body  { font-family: sans-serif; max-width: 960px; margin: 40px auto; padding: 0 16px; }
  h1    { color: #333; }
  table { border-collapse: collapse; width: 100%; margin-top: 20px; }
  th, td{ border: 1px solid #ddd; padding: 10px 14px; text-align: left; }
  th    { background: #f0f4f8; font-weight: 600; }
  tr:hover td { background: #fafafa; }
  .win  { color: #27ae60; font-weight: bold; }
  .lose { color: #e74c3c; font-weight: bold; }
  a     { color: #4a90e2; }
</style>
</head>
<body>
<h1>📋 История игр</h1>
<p><a href="index.php">← На главную</a></p>

<?php if (empty($games)): ?>
  <p>Игр ещё не было. <a href="index.php">Сыграть!</a></p>
<?php else: ?>
  <p>Всего игр: <?= count($games) ?></p>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Игрок</th>
        <th>Дата и время</th>
        <th>Прогрессия</th>
        <th>Пропущенное число</th>
        <th>Ответ игрока</th>
        <th>Результат</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($games as $g): ?>
      <tr>
        <td><?= $g['id'] ?></td>
        <td><?= htmlspecialchars($g['player_name']) ?></td>
        <td><?= $g['played_at'] ?></td>
        <td><?= htmlspecialchars($g['progression']) ?></td>
        <td><?= $g['hidden_number'] ?></td>
        <td><?= $g['player_answer'] ?></td>
        <td class="<?= $g['result'] ?>">
          <?= $g['result'] === 'win' ? '✅ Победа' : '❌ Поражение' ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
</body>
</html>
