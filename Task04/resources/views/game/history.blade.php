@extends('game.layout')

@section('title', 'История игр')

@section('content')
<h2>📋 История игр</h2>

@if($games->isEmpty())
    <p>Игр ещё не было. <a href="{{ url('/') }}" class="btn btn-primary" style="margin-top:12px">Сыграть!</a></p>
@else
    <p style="margin-bottom:12px">Всего игр: <strong>{{ $games->count() }}</strong></p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Игрок</th>
                <th>Дата и время</th>
                <th>Прогрессия</th>
                <th>Пропущенное</th>
                <th>Ответ</th>
                <th>Итог</th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $g)
            <tr>
                <td>{{ $g->id }}</td>
                <td>{{ $g->player_name }}</td>
                <td>{{ $g->created_at->format('d.m.Y H:i:s') }}</td>
                <td style="font-size:0.85em">{{ $g->progression }}</td>
                <td>{{ $g->hidden_number }}</td>
                <td>{{ $g->player_answer ?? '—' }}</td>
                <td>
                    @if($g->result === 'win')
                        <span style="color:#276749;font-weight:700">✅ Победа</span>
                    @elseif($g->result === 'lose')
                        <span style="color:#9b2c2c;font-weight:700">❌ Поражение</span>
                    @else
                        —
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
