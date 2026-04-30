<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Models\Game;
use App\Models\Creator;
use App\Models\Category;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Game\StoreRequest;
use App\Http\Requests\Admin\Game\UpdateRequest;
use App\Services\TelegramService;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $game = Game::all();
        return view('dashboard.game.index', compact('game'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'title')->get();
        $creators = Creator::select('id', 'first_name')->get();
        $companies = Company::select('id', 'name')->get();
        return view('dashboard.game.create', compact('categories', 'creators', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, TelegramService $telegram)
    {
        $data = $request->validated();

        unset($data['name'], $data['description']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('games', 'public');
        }

        $game = new Game($data);

        $game->setTranslations('name', $request->input('name'));
        $game->setTranslations('description', $request->input('description'));

        $telegram->sendNewGame($game);
        $game->save();

        return redirect()->route('game.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $categories = Category::select('id', 'title')->get();
        $creators = Creator::select('id', 'first_name')->get();
        $companies = Company::select('id', 'name')->get();
        return view('dashboard.game.edit',compact('game', 'categories', 'creators', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Game $game)
    {
        $data = $request->validated();

        unset($data['name'], $data['description']);

        if ($request->hasFile('cover_image')) {
            if ($game->cover_image) {
                Storage::disk('public')->delete($game->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('games', 'public');
        }

        $game->update($data);

        $game->setTranslations('name', $request->input('name'));
        $game->setTranslations('description', $request->input('description'));

        $game->save();
        
        return redirect()->route('game.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        if ($game->cover_image && file_exists(public_path($game->cover_image))) {
            unlink(public_path($game->cover_image));
        }

        $game->delete();
        return redirect()->route('game.index');
    }
}
