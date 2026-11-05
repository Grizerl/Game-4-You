<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\CommentRequest;
use App\Models\Comment;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(CommentRequest $request): RedirectResponse
    {
        $game = Game::findOrFail($request->validated('game_id'));
        $back = route('games.show.page', $game).'#comments';

        // Приховане поле-пастка: люди його не бачать, боти заповнюють. Тихо ігноруємо.
        if (filled($request->input('website'))) {
            return redirect($back);
        }

        Comment::create($request->safe()->only(['name', 'content', 'game_id']));

        return redirect($back)->with('comment_status', __('game.comment_sent'));
    }
}
