<?php

namespace App\Http\Controllers\ViewsControllers;

use App\Http\Controllers\Controller;
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
        return view('pages.game.games');
    }
}
