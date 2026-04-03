@extends('game.layout')

@section('title', 'Результат')

@section('content')
<h2>Результат</h2>

@if($correct)
    <div class="win">✅ Правильно! Пропущенное число: {{ $game->hidden_number }}</div>
@else
    <div class="lose">
        ❌ Неправильно. Ваш ответ: {{ $answer }}.
        Правильное число: {{ $game->hidden_number }}
    </div>
@endif

<p>Полная прогрессия:</p>
<div class="progression">{{ implode(', ', $prog) }}</div>

<div class="actions">
    <a href="{{ url('/') }}" class="btn btn-primary">🔄 Сыграть ещё раз</a>
    <a href="{{ url('/history') }}" class="btn btn-secondary">📋 История игр</a>
</div>
@endsection
