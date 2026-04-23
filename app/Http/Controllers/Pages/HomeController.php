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

        $categories = Category::with(['games' => function ($query) use ($category_id) {
            if ($category_id) {
                $query->where('category_id', $category_id);
            }
            $query->limit(6);
        }])->get();

        $games = Game::latest()->take(20)->get();

        $game = $games->take(9); 
        $storeGame = $games->shuffle()->take(8); 

        return view('pages.home.index', compact('categories', 'category_id', 'game', 'storeGame'));
    }
}
