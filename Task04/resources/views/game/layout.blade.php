<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Арифметическая прогрессия')</title>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Segoe UI', system-ui, sans-serif;
    background: #f0f4f8;
    color: #2d3748;
    min-height: 100vh;
    padding: 30px 16px;
  }
  .container { max-width: 720px; margin: 0 auto; }
  .card {
    background: #fff;
    border-radius: 12px;
    padding: 28px 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
  }
  h1 { font-size: 1.8em; margin-bottom: 6px; color: #2c3e50; }
  h2 { font-size: 1.3em; margin-bottom: 16px; color: #34495e; }
  .nav { display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
  .btn {
    display: inline-block;
    padding: 9px 20px;
    border: none;
    border-radius: 8px;
    font-size: 1em;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s;
  }
  .btn-primary   { background: #4a90e2; color: #fff; }
  .btn-primary:hover { background: #357abd; }
  .btn-secondary { background: #e2e8f0; color: #2d3748; }
  .btn-secondary:hover { background: #cbd5e0; }
  .progression {
    font-size: 1.4em;
    letter-spacing: 2px;
    background: #f7fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 18px 22px;
    margin: 20px 0;
    word-break: break-word;
  }
  .gap { color: #e74c3c; font-weight: 700; }
  .win  { color: #276749; background: #f0fff4; border: 2px solid #68d391; padding: 14px 20px; border-radius: 8px; font-weight: 600; margin: 16px 0; }
  .lose { color: #9b2c2c; background: #fff5f5; border: 2px solid #fc8181; padding: 14px 20px; border-radius: 8px; font-weight: 600; margin: 16px 0; }
  label  { display: block; margin-bottom: 6px; font-weight: 500; }
  input[type=text], input[type=number] {
    padding: 8px 12px; font-size: 1em; border: 2px solid #e2e8f0;
    border-radius: 8px; outline: none; width: 100%; max-width: 320px;
    transition: border-color 0.2s;
  }
  input:focus { border-color: #4a90e2; }
  .form-group { margin-bottom: 16px; }
  table { width: 100%; border-collapse: collapse; margin-top: 12px; }
  th, td { border: 1px solid #e2e8f0; padding: 10px 14px; text-align: left; font-size: 0.95em; }
  th { background: #f7fafc; font-weight: 600; }
  tr:hover td { background: #fafafa; }
  .subtitle { color: #718096; margin-bottom: 20px; }
  .actions { display: flex; gap: 10px; margin-top: 16px; flex-wrap: wrap; }
  .error { color: #e53e3e; font-size: 0.9em; margin-top: 4px; }
</style>
</head>
<body>
<div class="container">
  <h1>🎮 Арифметическая прогрессия</h1>
  <p class="subtitle">Угадайте пропущенное число в прогрессии из 10 чисел</p>
  <nav class="nav">
    <a href="{{ url('/') }}" class="btn btn-primary">🎮 Играть</a>
    <a href="{{ url('/history') }}" class="btn btn-secondary">📋 История</a>
  </nav>

  <div class="card">
    @yield('content')
  </div>
</div>
</body>
</html>
