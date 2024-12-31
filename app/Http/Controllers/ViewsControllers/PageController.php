<?php

namespace App\Http\Controllers\ViewsControllers;

use App\Http\Controllers\Controller;
use App\Models\Games;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){    
        return view('pages.home.main');
    } 

    public function creator() {
        return view('pages.creator.creators');
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
