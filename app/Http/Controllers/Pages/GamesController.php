<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Game;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index(Request $request): View
    {
        $query = Game::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $games = $query->paginate(12)->withQueryString();

        $categories = Category::all();

        return view('pages.game.games', compact('games', 'categories'));
    }

    public function show(int $id): View
    {
        $game = Game::with(['creator', 'company'])->findOrFail($id);
        $comment = Comment::where('game_id', $id)->get();
        return view('pages.details.detail', compact('game', 'comment'));
    }
}
