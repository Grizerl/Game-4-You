<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Creator\StoreRequest;
use App\Http\Requests\Admin\Creator\UpdateRequest;
use App\Models\Company;
use App\Models\Creator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreatorController extends Controller
{
    private const PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $creators = Creator::query()
            ->with('company')
            ->withCount('games')
            ->search(is_string($search) ? $search : null)
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('dashboard.creators.index', compact('creators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::select('id', 'name')->get();

        return view('dashboard.creators.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $creator = new Creator($this->payload($request->validated()));

        $creator->save();

        if ($request->hasFile('avatar')) {
            $creator->replaceImageFromRequest('avatar');
        }

        return redirect()->route('creator.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Creator $creator): View
    {
        $companies = Company::all();

        return view('dashboard.creators.edit', compact('creator', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Creator $creator): RedirectResponse
    {
        $creator->fill($this->payload($request->validated()));

        $creator->save();

        if ($request->hasFile('avatar')) {
            $creator->replaceImageFromRequest('avatar');
        }

        return redirect()->route('creator.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Creator $creator): RedirectResponse
    {
        if ($creator->avatar) {
            Storage::disk('public')->delete($creator->avatar);
        }

        $creator->delete();

        return redirect()->route('creator.index');
    }

    /**
     * Приводить перевірені дані до вигляду для моделі: порожні переклади не зберігаються,
     * порожній slug означає «згенерувати» (створення) або «лишити чинний» (редагування).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        unset($data['avatar']);

        foreach (['bio', 'role', 'country'] as $key) {
            $data[$key] = array_filter($data[$key] ?? [], 'filled');
        }

        if (blank($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        return $data;
    }
}
