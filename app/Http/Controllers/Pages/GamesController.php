<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\GamesIndexRequest;
use App\Models\Category;
use App\Models\Game;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    private const PER_PAGE = 12;

    private const STRIP_LIMIT = 6;

    private const COMMENTS_PER_PAGE = 4;

    public function index(GamesIndexRequest $request): View
    {
        $games = Game::query()
            ->with('category')
            ->search($request->search())
            ->inCategory($request->categoryId())
            ->onPlatform($request->platform())
            ->sortedBy($request->sort())
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $categories = Category::query()
            ->withCount('games')
            ->having('games_count', '>', 0)
            ->get()
            ->sortBy(fn (Category $category): string => mb_strtolower((string) $category->title))
            ->values();

        $platforms = Game::platformOptions();
        $total = Game::count();

        $filters = [
            'q' => $request->search(),
            'category' => $request->categoryId(),
            'platform' => $request->platform(),
            'sort' => $request->sort(),
        ];

        return view('pages.game.games', compact('games', 'categories', 'platforms', 'filters', 'total'));
    }

    public function show(Request $request, Game $game): View|RedirectResponse
    {
        // Старі адреси `/games/{id}` ведуть на канонічний slug.
        if ($request->route()->originalParameter('game') !== $game->slug) {
            return redirect()->route('games.show.page', $game, 301);
        }

        $game->load(['category', 'creator', 'company']);

        $comments = $game->comments()
            ->latest()
            ->orderByDesc('id')
            ->paginate(self::COMMENTS_PER_PAGE, pageName: 'comments_page')
            ->withQueryString()
            ->fragment('comments');

        // Номер сторінки коментарів за межами діапазону веде на останню наявну.
        if ($comments->isEmpty() && $comments->currentPage() > 1) {
            return redirect()->to(
                route('games.show.page', ['game' => $game, 'comments_page' => $comments->lastPage()]).'#comments'
            );
        }

        $similar = Game::query()
            ->with('category')
            ->where('category_id', $game->category_id)
            ->whereKeyNot($game->id)
            ->orderByDesc('rating')
            ->orderByDesc('id')
            ->limit(self::STRIP_LIMIT)
            ->get();

        $more = Game::query()
            ->with('category')
            ->whereKeyNot($game->id)
            ->where(fn ($query) => $query
                ->where('company_id', $game->company_id)
                ->orWhere('creator_id', $game->creator_id))
            ->orderByDesc('rating')
            ->orderByDesc('id')
            ->limit(self::STRIP_LIMIT)
            ->get();

        $trailerId = $game->trailerId();
        $screenshots = $game->screenshotUrls();
        $platforms = $game->platformList();

        $structuredData = array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'VideoGame',
            'name' => (string) $game->name,
            'url' => route('games.show.page', $game),
            'image' => $game->cover_url,
            'description' => $game->description ?: null,
            'genre' => $game->category ? (string) $game->category->title : null,
            'gamePlatform' => $platforms ?: null,
            'datePublished' => $game->released_at?->toDateString(),
            'publisher' => $game->company
                ? ['@type' => 'Organization', 'name' => (string) $game->company->name]
                : null,
            'author' => $game->creator
                ? ['@type' => 'Person', 'name' => $game->creator->full_name]
                : null,
        ]);

        return view('pages.details.detail', compact(
            'game', 'comments', 'similar', 'more', 'trailerId', 'screenshots', 'platforms', 'structuredData'
        ));
    }
}
