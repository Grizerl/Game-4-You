<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Company\StoreRequest;
use App\Http\Requests\Admin\Company\UpdateRequest;
use App\Models\Company;
use App\Support\ImageVariants;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    private const PER_PAGE = 15;

    private const LOGO_DIR = 'uploads/company';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $company = Company::query()
            ->withCount(['games', 'creators'])
            ->search(is_string($search) ? $search : null)
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('dashboard.company.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $company = new Company($this->payload($request->validated()));

        if ($request->hasFile('logo_path')) {
            $company->logo_path = $this->storeLogo($request->file('logo_path'));
        }

        $company->save();

        return redirect()->route('companies.index');
    }

    public function edit(Company $company): View
    {
        return view('dashboard.company.edit', compact('company'));
    }

    public function update(UpdateRequest $request, Company $company): RedirectResponse
    {
        $company->fill($this->payload($request->validated()));

        if ($request->hasFile('logo_path')) {
            $this->deleteLogo($company->logo_path);
            $company->logo_path = $this->storeLogo($request->file('logo_path'));
        }

        $company->save();

        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): RedirectResponse
    {
        $this->deleteLogo($company->logo_path);

        $company->delete();

        return redirect()->route('companies.index');
    }

    /**
     * Порожні переклади не зберігаються; порожній slug означає «згенерувати» (створення)
     * або «лишити чинний» (редагування).
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        unset($data['logo_path']);

        foreach (['name', 'description', 'country'] as $key) {
            $data[$key] = array_filter($data[$key] ?? [], 'filled');
        }

        if (blank($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        return $data;
    }

    private function storeLogo(UploadedFile $file): string
    {
        $filename = time().'_'.Str::random(6).'.'.$file->extension();
        $file->move(public_path(self::LOGO_DIR), $filename);
        ImageVariants::generate(self::LOGO_DIR.'/'.$filename);

        return self::LOGO_DIR.'/'.$filename;
    }

    private function deleteLogo(?string $path): void
    {
        if ($path && Str::startsWith($path, self::LOGO_DIR.'/') && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
}
