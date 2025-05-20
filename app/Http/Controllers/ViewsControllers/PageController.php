<?php

namespace App\Http\Controllers\ViewsControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $category_id = $request->get('category_id');

        $categories = Category::with(['games' => function ($query) use ($category_id) {

            if ($category_id) {
                $query->where('category_id', $category_id);
            }

            $query->paginate(6);
        }])->get();

        return view('pages.home.main', compact('categories', 'category_id'));
    }

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

    /**
     * Summary of creator
     * @return View
     */
    public function creator(): View
    {
        $creators = Creator::paginate(14);

        return view('pages.creator.creators', compact('creators'));
    }

    /**
     * Summary of store
     * @return View
     */
    public function store(): View
    {

        return view('pages.store.stores');
    }

    /**
     * Summary of game
     * @return View
     */
    public function game(): View
    {

        $games = Game::paginate(21);

        return view('pages.game.games', compact('games'));
    }

    /**
     * Summary of details
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {

        $game = Game::find($id);

        return view('pages.details.detail', compact('game'));
    }
}
