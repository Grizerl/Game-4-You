@extends('layouts.admin')

@section('title', 'Image sizes')

@section('content')

<form method="POST" action="{{ route('settings.images.update') }}" class="size-form">
    @csrf
    @method('PUT')

    <h2 class="section-title">Game and news covers</h2>

    <div class="size-grid">
        <div></div>
        <div class="size-head">Desktop, px</div>
        <div class="size-head">Mobile (up to 720 px), px</div>

        @foreach ([
            'thumb' => 'Thumbnail (posters, cards)',
            'large' => 'Large banner (hero, news)',
        ] as $kind => $label)
            <div class="size-label">{{ $label }}</div>
            @foreach (['desktop', 'mobile'] as $device)
                @php($field = "cover_{$kind}_{$device}")
                <div>
                    <input type="number" name="{{ $field }}" value="{{ old($field, $values[$field]) }}"
                           min="{{ $min }}" max="{{ $max }}" step="10" class="@error($field) error-input @enderror">
                    @error($field)
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
        @endforeach
    </div>

    <h2 class="section-title">Avatars and logos</h2>

    <div class="size-grid size-grid--single">
        <div></div>
        <div class="size-head">Width, px</div>

        @foreach ([
            'avatar_thumb' => 'Creator avatar',
            'logo_thumb' => 'Company logo',
        ] as $field => $label)
            <div class="size-label">{{ $label }}</div>
            <div>
                <input type="number" name="{{ $field }}" value="{{ old($field, $values[$field]) }}"
                       min="{{ $min }}" max="{{ $max }}" step="10" class="@error($field) error-input @enderror">
                @error($field)
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>
        @endforeach
    </div>

    <p class="hint">Width in pixels ({{ $min }}–{{ $max }}); the mobile width cannot exceed the desktop width. Images are never enlarged beyond the original.
        Mobile versions are served to visitors with a viewport up to 720 px. After a change, existing images are regenerated in the background (a queue worker is required).</p>

    <div class="form-actions"><button class="btn">Save</button></div>
</form>

<form method="POST" action="{{ route('settings.images.regenerate') }}" class="size-form size-form--regen">
    @csrf
    <button class="btn btn-secondary">Regenerate all images</button>
</form>

@push('styles')
    @vite('resources/scss/admin/settings.scss')
@endpush
@endsection
