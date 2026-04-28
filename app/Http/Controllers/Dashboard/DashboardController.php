<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $games = Game::count();
        $companies = Company::count();
        $creators = Creator::count();
        $categories  = Category::count();
        return view('dashboard.index', compact('categories', 'companies', 'creators', 'games'));
    }
}
