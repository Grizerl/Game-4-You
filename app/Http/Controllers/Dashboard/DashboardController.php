<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            ['label' => 'Games', 'count' => Game::count(), 'icon' => 'fa-gamepad', 'tone' => 'blue', 'route' => 'game.index'],
            ['label' => 'Categories', 'count' => Category::count(), 'icon' => 'fa-layer-group', 'tone' => 'violet', 'route' => 'category.index'],
            ['label' => 'Creators', 'count' => Creator::count(), 'icon' => 'fa-user-pen', 'tone' => 'pink', 'route' => 'creator.index'],
            ['label' => 'Companies', 'count' => Company::count(), 'icon' => 'fa-building', 'tone' => 'amber', 'route' => 'companies.index'],
            ['label' => 'News', 'count' => Article::count(), 'icon' => 'fa-newspaper', 'tone' => 'green', 'route' => 'news.index'],
            ['label' => 'Users', 'count' => User::count(), 'icon' => 'fa-users', 'tone' => 'cyan', 'route' => 'users.index'],
        ];

        return view('dashboard.index', compact('stats'));
    }
}
