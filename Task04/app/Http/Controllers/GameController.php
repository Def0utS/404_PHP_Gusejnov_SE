<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // GET / — главная страница
    public function index()
    {
        return view('game.index');
    }

    // POST /start — начало новой игры
    public function start(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:100',
        ]);

        $prog      = $this->generateProgression();
        $hiddenIdx = random_int(0, 9);
        $hiddenNum = $prog[$hiddenIdx];

        $game = Game::create([
            'player_name'   => $request->input('player_name'),
            'progression'   => implode(',', $prog),
            'hidden_number' => $hiddenNum,
        ]);

        return view('game.play', [
            'game'      => $game,
            'prog'      => $prog,
            'hiddenIdx' => $hiddenIdx,
            'hiddenNum' => $hiddenNum,
        ]);
    }

    // POST /answer/{game} — проверка ответа
    public function answer(Request $request, Game $game)
    {
        $request->validate([
            'answer' => 'required|integer',
        ]);

        $answer  = (int) $request->input('answer');
        $correct = $answer === (int) $game->hidden_number;

        $game->update([
            'player_answer' => $answer,
            'result'        => $correct ? 'win' : 'lose',
        ]);

        $prog = array_map('intval', explode(',', $game->progression));

        return view('game.result', [
            'game'    => $game,
            'prog'    => $prog,
            'answer'  => $answer,
            'correct' => $correct,
        ]);
    }

    // GET /history — история игр
    public function history()
    {
        $games = Game::orderByDesc('id')->get();
        return view('game.history', compact('games'));
    }

    // ── Вспомогательные методы ────────────────────────────────────────────

    private function generateProgression(): array
    {
        $start = random_int(1, 50);
        $step  = random_int(2, 15);
        $prog  = [];
        for ($i = 0; $i < 10; $i++) {
            $prog[] = $start + $step * $i;
        }
        return $prog;
    }
}
