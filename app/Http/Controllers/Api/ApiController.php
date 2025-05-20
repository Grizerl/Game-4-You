<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Summary of getGames
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getGames(Request $request): JsonResponse
    {
        $category_id = $request->get('category_id');

        $games = Game::when($category_id, function ($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        })->paginate(6);

        if ($games->isEmpty()) {
            return response()->json(['message' => 'No games found for this category'], 404);
        }

        return response()->json($games);
    }

    /**
     * Summary of creators
     * @return JsonResponse|mixed
     */
    public function creators(): JsonResponse
    {

        $creators = Creator::paginate(14);

        if ($creators->isEmpty()) {
            return response()->json(['message' => 'No creator found'], 404);
        }

        return response()->json($creators);
    }

    /**
     * Summary of games
     * @return JsonResponse|mixed
     */
    public function games(): JsonResponse
    {

        $game = Game::paginate(21);

        if ($game->isEmpty()) {
            return response()->json(['message' => 'No games found'], 404);
        }

        return response()->json($game);
    }

    /**
     * Summary of details
     * @param int $id
     * @return JsonResponse|mixed
     */
    public function details(int $id): JsonResponse
    {

        $GameDetails = Game::find($id);

        if (!$GameDetails) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        return response()->json($GameDetails);
    }
}
