<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private const TRENDING_LIMIT = 6;

    private const COMPANIES_LIMIT = 16;

    private const CREATORS_LIMIT = 4;

    private const COMMENTS_LIMIT = 6;

    public function index(Request $request): View|RedirectResponse
    {
        // Старий фільтр жанрів на головній тепер живе в каталозі ігор.
        $legacyCategory = $request->query('category_id');

        if (is_string($legacyCategory) && ctype_digit($legacyCategory)) {
            return redirect()->route('games.page', ['category' => (int) $legacyCategory], 301);
        }

        $stats = [
            'games' => Game::count(),
            'companies' => Company::count(),
            'creators' => Creator::count(),
        ];

        $newGames = Game::query()
            ->with('category')
            ->sortedBy('new')
            ->limit(self::TRENDING_LIMIT)
            ->get();

        $topGames = Game::query()
            ->with('category')
            ->sortedBy('rating')
            ->limit(self::TRENDING_LIMIT)
            ->get();

        $spotlight = $this->spotlight();

        $genres = Category::query()
            ->withCount('games')
            ->having('games_count', '>', 0)
            ->orderByDesc('games_count')
            ->get();

        $companies = Company::query()->latest('id')->limit(self::COMPANIES_LIMIT)->get();

        $creators = Creator::query()
            ->withCount('games')
            ->whereHas('games')
            ->orderByDesc('games_count')
            ->orderBy('first_name')
            ->limit(self::CREATORS_LIMIT)
            ->get();

        $comments = Comment::query()
            ->whereHas('game')
            ->with('game')
            ->latest()
            ->orderByDesc('id')
            ->limit(self::COMMENTS_LIMIT)
            ->get();

        return view('pages.home.index', compact(
            'stats', 'newGames', 'topGames', 'spotlight', 'genres', 'companies', 'creators', 'comments'
        ));
    }

    /**
     * Гра у фокусі: нова з трейлером → нова за рейтингом → найвищий рейтинг.
     */
    private function spotlight(): ?Game
    {
        $ranked = fn () => Game::query()->with('category')->orderByDesc('rating')->orderByDesc('id');

        return $ranked()->where('isNew', true)->whereNotNull('trailer_url')->get()
            ->first(fn (Game $game): bool => $game->trailerId() !== null)
            ?? $ranked()->where('isNew', true)->first()
            ?? $ranked()->first();
    }
}
