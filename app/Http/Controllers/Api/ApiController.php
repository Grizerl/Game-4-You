<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Creators;
use App\Models\Games;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getGames(Request $request)
    {
        $category_id = $request->get('category_id');

        $games = Games::when($category_id, function ($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        })->paginate(6);

        if ($games->isEmpty()) {
            return response()->json(['message' => 'No games found for this category'], 404); 
        }

        return response()->json($games);
    }

    public function creators() {

        $creators=Creators::paginate(14);

        if ($creators->isEmpty()) {
            return response()->json(['message' => 'No creator found'], 404); 
        }

        return response()->json($creators);
    }

    public function games() {

        $game=Games::paginate(21);

        if ($game->isEmpty()) {
            return response()->json(['message' => 'No games found'], 404); 
        }

        return response()->json($game);
    }

    public function details($id) {

        $GameDetails=Games::find($id);

        if(!$GameDetails) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        return response()->json($GameDetails);
    }
}
