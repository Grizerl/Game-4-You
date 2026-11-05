<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImageSizesRequest;
use App\Jobs\RegenerateImageConversions;
use App\Support\ImageSizes;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ImageSettingsController extends Controller
{
    public function edit(): View
    {
        $sizes = ImageSizes::all();

        $values = collect(ImageSizesRequest::FIELDS)
            ->map(fn (string $key): int => $sizes[$key])
            ->all();

        return view('dashboard.settings.images', [
            'values' => $values,
            'min' => ImageSizes::MIN,
            'max' => ImageSizes::MAX,
        ]);
    }

    public function update(ImageSizesRequest $request): RedirectResponse
    {
        $new = $request->sizes();
        $changed = $new !== ImageSizes::all();

        ImageSizes::save($new);

        if ($changed) {
            RegenerateImageConversions::dispatch();
        }

        return redirect()
            ->route('settings.images')
            ->with('status', $changed
                ? 'Розміри збережено. Перегенерація наявних зображень запущена в черзі.'
                : 'Розміри не змінились.');
    }

    public function regenerate(): RedirectResponse
    {
        RegenerateImageConversions::dispatch();

        return redirect()
            ->route('settings.images')
            ->with('status', 'Перегенерацію всіх зображень поставлено в чергу.');
    }
}
