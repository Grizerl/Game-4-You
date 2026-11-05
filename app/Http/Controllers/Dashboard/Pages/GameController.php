<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Game\StoreRequest;
use App\Http\Requests\Admin\Game\UpdateRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Services\TelegramService;
use App\Support\ImageVariants;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GameController extends Controller
{
    private const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $game = Game::query()
            ->with(['category', 'company'])
            ->withCount('comments')
            ->search(is_string($search) ? $search : null)
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('dashboard.game.index', compact('game'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.game.create', $this->formData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, TelegramService $telegram): RedirectResponse
    {
        $game = new Game($this->payload($request->validated()));

        $game->cover_image = $request->file('cover_image')->store('games', 'public');
        ImageVariants::generate($game->cover_image);
        $game->screenshots = $this->storeScreenshots($request->file('screenshots', []), []) ?: null;

        $game->save();

        // Збій Telegram не повинен блокувати збереження гри.
        try {
            $telegram->sendNewGame($game->load(['category', 'creator', 'company']));
        } catch (Throwable $e) {
            report($e);
        }

        return redirect()->route('game.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game): View
    {
        return view('dashboard.game.edit', ['game' => $game] + $this->formData());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Game $game): RedirectResponse
    {
        $game->fill($this->payload($request->validated()));

        if ($request->hasFile('cover_image')) {
            $this->deleteFile($game->cover_image);
            $game->cover_image = $request->file('cover_image')->store('games', 'public');
            ImageVariants::generate($game->cover_image);
        }

        $existing = $game->screenshots ?? [];
        $remove = array_intersect($existing, (array) $request->input('remove_screenshots', []));

        foreach ($remove as $path) {
            $this->deleteFile($path);
        }

        $kept = array_values(array_diff($existing, $remove));
        $game->screenshots = $this->storeScreenshots($request->file('screenshots', []), $kept) ?: null;

        $game->save();

        return redirect()->route('game.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game): RedirectResponse
    {
        $this->deleteFile($game->cover_image);

        foreach ($game->screenshots ?? [] as $path) {
            $this->deleteFile($path);
        }

        $game->comments()->delete();
        $game->delete();

        return redirect()->route('game.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(): array
    {
        return [
            'categories' => Category::select('id', 'title')->get(),
            'creators' => Creator::select('id', 'first_name', 'last_name')->get(),
            'companies' => Company::select('id', 'name')->get(),
        ];
    }

    /**
     * Порожні переклади не зберігаються; порожній slug означає «згенерувати» (створення)
     * або «лишити чинний» (редагування). Файли обробляються окремо.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        unset($data['cover_image'], $data['screenshots'], $data['remove_screenshots']);

        foreach (['name', 'description'] as $key) {
            $data[$key] = array_filter($data[$key] ?? [], 'filled');
        }

        if (blank($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        return $data;
    }

    /**
     * @param  array<int, UploadedFile>  $files
     * @param  list<string>  $kept
     * @return list<string>
     */
    private function storeScreenshots(array $files, array $kept): array
    {
        foreach ($files as $file) {
            $kept[] = $file->store('games/screenshots', 'public');
        }

        return $kept;
    }

    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
