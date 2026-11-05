{{-- Спільні поля форм створення й редагування гри. $game — null при створенні. --}}
@php
    $g = $game ?? null;
    $translated = fn (string $attribute, string $locale): ?string => $g ? $g->getTranslation($attribute, $locale, false) : null;
    $locales = ['uk' => 'UA', 'en' => 'EN'];
    $shots = $g?->screenshots ?? [];
@endphp

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Game Title ({{ $label }})</label>
        <input type="text" name="name[{{ $locale }}]" value="{{ old("name.$locale", $translated('name', $locale)) }}"
               class="@error("name.$locale") error-input @enderror">
        @error("name.$locale")
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
@endforeach

<div class="form-group">
    <label>Slug (URL)</label>
    <input type="text" name="slug" value="{{ old('slug', $g?->slug) }}" class="@error('slug') error-input @enderror" placeholder="cyber-quest" autocomplete="off">
    <div class="hint">
        Latin letters, digits and hyphens. {{ $g ? 'Leave empty to keep the current one.' : 'Leave empty to generate from the name.' }}
    </div>
    @error('slug')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Description ({{ $label }})</label>
        <textarea name="description[{{ $locale }}]" class="@error("description.$locale") error-input @enderror">{{ old("description.$locale", $translated('description', $locale)) }}</textarea>
        @error("description.$locale")
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
@endforeach

<div class="form-group">
    <label>Cover Image</label>

    <div class="avatar-preview">
        <img data-avatar-preview src="{{ $g?->hasImage() ? $g->cover_thumb_url : '' }}" alt="Cover preview" width="100" height="150" @if (! $g?->cover_image) hidden @endif>
    </div>

    <input type="file" name="cover_image" accept="image/*" data-avatar-input class="@error('cover_image') error-input @enderror">
    <div class="hint">JPG, PNG or WebP, up to 4 MB. {{ $g ? 'Leave empty to keep the current one.' : 'Required.' }}</div>
    @error('cover_image')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Rating</label>
    <input type="number" step="any" min="0" name="rating" value="{{ old('rating', $g?->rating) }}" class="@error('rating') error-input @enderror" placeholder="Enter rating">
    @error('rating')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Platforms</label>
    <input type="text" name="platforms" value="{{ old('platforms', $g?->platforms) }}" class="@error('platforms') error-input @enderror" placeholder="PC, PS5, Xbox">
    <div class="hint">Separate several platforms with commas.</div>
    @error('platforms')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Release date</label>
    <input type="date" name="released_at" value="{{ old('released_at', $g?->released_at?->format('Y-m-d')) }}" class="@error('released_at') error-input @enderror">
    @error('released_at')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Trailer (YouTube link)</label>
    <input type="url" name="trailer_url" value="{{ old('trailer_url', $g?->trailer_url) }}" class="@error('trailer_url') error-input @enderror" placeholder="https://www.youtube.com/watch?v=...">
    @error('trailer_url')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Screenshots</label>

    @if ($shots)
        <ul class="shot-list">
            @foreach ($shots as $path)
                <li>
                    <img src="{{ \App\Support\PublicImage::url($path) }}" alt="" width="120" height="68">
                    <label class="remove"><input type="checkbox" name="remove_screenshots[]" value="{{ $path }}"> Remove</label>
                </li>
            @endforeach
        </ul>
    @endif

    <input type="file" name="screenshots[]" accept="image/*" multiple class="@error('screenshots') error-input @enderror @error('screenshots.*') error-input @enderror">
    <div class="hint">Up to {{ \App\Models\Game::MAX_SCREENSHOTS }} images in total, JPG, PNG or WebP, up to 2 MB each. New files are added to the existing ones.</div>
    @error('screenshots')
        <div class="error-text">{{ $message }}</div>
    @enderror
    @error('screenshots.*')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Is New</label>
    <select name="isNew" class="@error('isNew') error-input @enderror">
        <option value="0" @selected((string) old('isNew', $g?->isNew ? 1 : 0) === '0')>No</option>
        <option value="1" @selected((string) old('isNew', $g?->isNew ? 1 : 0) === '1')>Yes</option>
    </select>
    @error('isNew')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Category</label>
    <select name="category_id" class="@error('category_id') error-input @enderror">
        <option value="">-- Select Category --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected((string) old('category_id', $g?->category_id) === (string) $category->id)>{{ $category->title }}</option>
        @endforeach
    </select>
    @error('category_id')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Creator</label>
    <select name="creator_id" class="@error('creator_id') error-input @enderror">
        <option value="">-- Select Creator --</option>
        @foreach ($creators as $creator)
            <option value="{{ $creator->id }}" @selected((string) old('creator_id', $g?->creator_id) === (string) $creator->id)>{{ $creator->full_name }}</option>
        @endforeach
    </select>
    @error('creator_id')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Company</label>
    <select name="company_id" class="@error('company_id') error-input @enderror">
        <option value="">-- Select Company --</option>
        @foreach ($companies as $company)
            <option value="{{ $company->id }}" @selected((string) old('company_id', $g?->company_id) === (string) $company->id)>{{ $company->name }}</option>
        @endforeach
    </select>
    @error('company_id')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<br>

<div class="form-actions">
    <button class="btn">{{ $g ? 'Update Game' : 'Create Game' }}</button>
    <a href="{{ route('game.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@push('styles')
    @vite('resources/scss/admin/form-game.scss')
@endpush

<script>
    document.querySelector('[data-avatar-input]')?.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const preview = document.querySelector('[data-avatar-preview]');

        if (file && preview) {
            preview.src = URL.createObjectURL(file);
            preview.hidden = false;
        }
    });
</script>

