<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Game;
use Illuminate\Contracts\View\View;

class GamesController extends Controller
{
    public function index(): View
    {
        $games = Game::paginate(21);
        return view('pages.game.games', compact('games'));
    }

    public function show(int $id): View
    {
        $game = Game::with(['creator', 'company'])->findOrFail($id);
        $comment = Comment::where('game_id', $id)->get();
        return view('pages.details.detail', compact('game', 'comment'));
    }
}
