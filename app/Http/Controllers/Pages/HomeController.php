<?php

namespace App\Http\Controllers\Pages;

use App\Models\Category;
use App\Models\Game;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $category_id = $request->get('category_id');

        $categories = Category::all();

        $gamesQuery = Game::latest();

        if ($category_id) {
            $gamesQuery->where('category_id', $category_id);
        }

        $games = $gamesQuery->paginate(6); 

        $storeGame = Game::where('isNew', 1)->get();

        return view('pages.home.index', compact('categories', 'category_id', 'games', 'storeGame'));
    }
}
