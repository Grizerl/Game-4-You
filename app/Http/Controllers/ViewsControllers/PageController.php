<?php

namespace App\Http\Controllers\ViewsControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Creators;
use App\Models\Games;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->get('category_id');

        $categories = Category::with(['games' => function($query) use ($category_id) {

        if ($category_id) {$query->where('category_id', $category_id);}
        
        $query->paginate(6);}])->get();
    
        return view('pages.home.main', compact('categories', 'category_id'));
    }

    public function getGames(Request $request)
    {
        $category_id = $request->get('category_id');

        $games = Games::when($category_id, function ($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        })->paginate(6); 
        
        return view('partials.games-list', compact('games'))->render();
    }
    
    public function creator() {

        $creators=Creators::paginate(14);

        return view('pages.creator.creators',compact('creators'));
    }

    public function store() {

        return view('pages.store.stores');
    }

    public function game() {

        $games=Games::paginate(21);

        return view('pages.game.games',compact('games'));
    }

    public function details($id) {

        $game=Games::find($id);

        return view('pages.details.detail',compact('game'));
    }
}
