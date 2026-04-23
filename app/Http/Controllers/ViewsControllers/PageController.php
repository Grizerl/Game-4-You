<?php

namespace App\Http\Controllers\ViewsControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment as ModelsComment;
use App\Models\Creator;
use App\Models\Game;
use Dom\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Summary of getGames
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function getGames(Request $request): string
    {
        $category_id = $request->get('category_id');

        $games = Game::when($category_id, function ($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        })->paginate(6);

        return view('partials.games-list', compact('games'))->render();
    }
}
