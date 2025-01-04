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
        // Отримуємо параметр category_id з запиту
        $category_id = $request->get('category_id');
    
        // Завантажуємо категорії з іграми, пагінуючи ігри для кожної категорії
        $categories = Category::with(['games' => function($query) use ($category_id) {
            // Якщо категорія вибрана, фільтруємо по category_id, інакше виводимо всі ігри
            if ($category_id) {
                $query->where('category_id', $category_id);
            }
            // Пагінуємо ігри по 10 на сторінку
            $query->paginate(6);
        }])->get();
    
        return view('pages.home.main', compact('categories', 'category_id'));
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
