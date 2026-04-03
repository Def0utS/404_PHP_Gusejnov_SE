@extends('game.layout')

@section('title', 'Начать игру')

@section('content')
<h2>Добро пожаловать!</h2>
<p style="margin-bottom:20px">Введите ваше имя и нажмите «Начать» — вам будет предложена арифметическая прогрессия с одним пропущенным числом.</p>

<form action="{{ url('/start') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="player_name">Ваше имя:</label>
        <input type="text"
               id="player_name"
               name="player_name"
               value="{{ old('player_name') }}"
               placeholder="Введите имя"
               autofocus
               required>
        @error('player_name')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Начать игру →</button>
</form>
@endsection
