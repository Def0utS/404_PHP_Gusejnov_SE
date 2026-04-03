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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Арифметическая прогрессия</title>
<style>
  body  { font-family: sans-serif; max-width: 680px; margin: 40px auto; padding: 0 16px; }
  h1    { color: #333; }
  input { font-size: 1em; padding: 6px 10px; margin-top: 6px; }
  button{ font-size: 1em; padding: 8px 18px; cursor: pointer; background: #4a90e2; color: #fff; border: none; border-radius: 4px; }
  button:hover { background: #357abd; }
  a     { color: #4a90e2; }
</style>
</head>
<body>
<h1>🎮 Игра «Арифметическая прогрессия»</h1>
<p>Вам будет показан ряд из 10 чисел. Одно заменено точками — угадайте его!</p>
<p><a href="history.php">📋 История игр</a></p>
<form action="game.php" method="post">
  <label>
    Ваше имя:<br>
    <input type="text" name="player_name" required placeholder="Введите имя">
  </label><br><br>
  <button type="submit">Начать игру</button>
</form>
</body>
</html>
