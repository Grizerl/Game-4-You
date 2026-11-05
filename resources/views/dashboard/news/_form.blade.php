{{-- Спільні поля форм створення й редагування новини. $article — null при створенні. --}}
@php
    $a = $article ?? null;
    $translated = fn (string $attribute, string $locale): ?string => $a ? $a->getTranslation($attribute, $locale, false) : null;
    $locales = ['uk' => 'UA', 'en' => 'EN'];
    $selectedGames = array_map('intval', (array) old('games', $a ? $a->games->pluck('id')->all() : []));
    $selectedCompanies = array_map('intval', (array) old('companies', $a ? $a->companies->pluck('id')->all() : []));
    $tagsValue = old('tags', $a ? $a->tags->map(fn ($t) => $t->getTranslation('name', 'uk', false).'|'.$t->getTranslation('name', 'en', false))->implode(', ') : '');
@endphp

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Title ({{ $label }})</label>
        <input type="text" name="title[{{ $locale }}]" value="{{ old("title.$locale", $translated('title', $locale)) }}"
               class="@error("title.$locale") error-input @enderror">
        @error("title.$locale")
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
@endforeach

<div class="form-group">
    <label>Slug (URL)</label>
    <input type="text" name="slug" value="{{ old('slug', $a?->slug) }}" class="@error('slug') error-input @enderror" placeholder="big-announcement" autocomplete="off">
    <div class="hint">
        Latin letters, digits and hyphens. {{ $a ? 'Leave empty to keep the current one.' : 'Leave empty to generate from the title.' }} The word "feed" is reserved.
    </div>
    @error('slug')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Excerpt ({{ $label }}) — up to 300 characters</label>
        <textarea name="excerpt[{{ $locale }}]" maxlength="300" class="short @error("excerpt.$locale") error-input @enderror">{{ old("excerpt.$locale", $translated('excerpt', $locale)) }}</textarea>
        @error("excerpt.$locale")
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
@endforeach

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Body ({{ $label }}) — Markdown</label>
        <textarea name="body[{{ $locale }}]" class="tall @error("body.$locale") error-input @enderror" placeholder="## Heading&#10;&#10;Text with **bold**, lists and [links](https://example.com)">{{ old("body.$locale", $translated('body', $locale)) }}</textarea>
        @error("body.$locale")
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
@endforeach
<div class="hint md-hint">Markdown: <code>## Heading</code>, <code>**bold**</code>, <code>- list</code>, <code>&gt; quote</code>, <code>[text](url)</code>, <code>![alt](image-url)</code>. Raw HTML is ignored.</div>

<div class="form-group">
    <label>Cover Image</label>

    <div class="avatar-preview">
        <img data-avatar-preview src="{{ $a?->hasImage() ? $a->cover_thumb_url : '' }}" alt="Cover preview" width="220" height="124" @if (! $a?->cover_image) hidden @endif>
    </div>

    <input type="file" name="cover_image" accept="image/*" data-avatar-input class="@error('cover_image') error-input @enderror">
    <div class="hint">JPG, PNG or WebP, up to 4 MB. Optional (a placeholder is shown without it).</div>
    @error('cover_image')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Publication date</label>
    <input type="datetime-local" name="published_at" value="{{ old('published_at', $a?->published_at?->format('Y-m-d\TH:i')) }}" class="@error('published_at') error-input @enderror">
    <div class="hint">Leave empty to keep it as a draft. A future date schedules the publication.</div>
    @error('published_at')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Tags</label>
    <input type="text" name="tags" value="{{ $tagsValue }}" list="known-tags" class="@error('tags') error-input @enderror" placeholder="Огляди|Reviews, Новини|News" autocomplete="off">
    <datalist id="known-tags">
        @foreach ($knownTags as $knownTag)
            <option value="{{ $knownTag->getTranslation('name', 'uk', false) }}|{{ $knownTag->getTranslation('name', 'en', false) }}"></option>
        @endforeach
    </datalist>
    <div class="hint">Separate tags with commas. Format: <code>Назва|Name</code> (UA|EN) or a single name for both languages.</div>
    @error('tags')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Related games</label>
    <select name="games[]" multiple size="6" class="@error('games') error-input @enderror @error('games.*') error-input @enderror">
        @foreach ($games as $game)
            <option value="{{ $game->id }}" @selected(in_array($game->id, $selectedGames, true))>{{ $game->name }}</option>
        @endforeach
    </select>
    <div class="hint">Hold Ctrl (Cmd) to select several.</div>
    @error('games')
        <div class="error-text">{{ $message }}</div>
    @enderror
    @error('games.*')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Related studios</label>
    <select name="companies[]" multiple size="6" class="@error('companies') error-input @enderror @error('companies.*') error-input @enderror">
        @foreach ($companies as $company)
            <option value="{{ $company->id }}" @selected(in_array($company->id, $selectedCompanies, true))>{{ $company->name }}</option>
        @endforeach
    </select>
    @error('companies')
        <div class="error-text">{{ $message }}</div>
    @enderror
    @error('companies.*')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<br>

<div class="form-actions">
    <button class="btn">{{ $a ? 'Update Article' : 'Create Article' }}</button>
    <a href="{{ route('news.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@push('styles')
    @vite('resources/scss/admin/form-news.scss')
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

