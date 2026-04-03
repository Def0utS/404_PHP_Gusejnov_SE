@extends('game.layout')

@section('title', 'Игра')

@section('content')
<h2>Найдите пропущенное число</h2>
<p>Игрок: <strong>{{ $game->player_name }}</strong></p>

<div class="progression">
    @foreach($prog as $i => $val)
        @if($i === $hiddenIdx)
            <span class="gap">...</span>
        @else
            {{ $val }}
        @endif
        @if(!$loop->last), @endif
    @endforeach
</div>

<form action="{{ url('/answer/' . $game->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="answer">Ваш ответ:</label>
        <input type="number"
               id="answer"
               name="answer"
               placeholder="Введите число"
               autofocus
               required>
        @error('answer')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Проверить</button>
</form>
@endsection
