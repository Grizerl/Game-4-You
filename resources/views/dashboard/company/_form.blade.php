{{-- Спільні поля форм створення й редагування студії. $company — null при створенні. --}}
@php
    $c = $company ?? null;
    $translated = fn (string $attribute, string $locale): ?string => $c ? $c->getTranslation($attribute, $locale, false) : null;
    $locales = ['uk' => 'UA', 'en' => 'EN'];
    $socialLabels = ['website' => 'Website', 'x' => 'X (Twitter)', 'youtube' => 'YouTube', 'twitch' => 'Twitch', 'instagram' => 'Instagram'];
@endphp

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Company Name ({{ $label }})</label>
        <input type="text" name="name[{{ $locale }}]" value="{{ old("name.$locale", $translated('name', $locale)) }}"
               class="@error("name.$locale") error-input @enderror">
        @error("name.$locale")
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
@endforeach

<div class="form-group">
    <label>Slug (URL)</label>
    <input type="text" name="slug" value="{{ old('slug', $c?->slug) }}" class="@error('slug') error-input @enderror" placeholder="big-studio" autocomplete="off">
    <div class="hint">
        Latin letters, digits and hyphens. {{ $c ? 'Leave empty to keep the current one.' : 'Leave empty to generate from the name.' }}
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

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Country ({{ $label }})</label>
        <input type="text" name="country[{{ $locale }}]" value="{{ old("country.$locale", $translated('country', $locale)) }}"
               class="@error("country.$locale") error-input @enderror"
               placeholder="{{ $locale === 'uk' ? 'Country in Ukrainian' : 'Country in English' }}">
        @error("country.$locale")
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
@endforeach

<div class="form-group">
    <label>Founded (year)</label>
    <input type="number" name="founded_year" value="{{ old('founded_year', $c?->founded_year) }}" min="1970" max="{{ now()->year }}"
           class="@error('founded_year') error-input @enderror" placeholder="{{ now()->year - 20 }}">
    @error('founded_year')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Social links</label>
    @foreach ($socialLabels as $key => $label)
        <div class="social-row">
            <span>{{ $label }}</span>
            <input type="url" name="socials[{{ $key }}]" value="{{ old("socials.$key", $c?->socials[$key] ?? null) }}"
                   class="@error("socials.$key") error-input @enderror" placeholder="https://">
        </div>
        @error("socials.$key")
            <div class="error-text">{{ $message }}</div>
        @enderror
    @endforeach
    @error('socials')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Logo</label>

    <div class="logo-preview">
        <img data-logo-preview src="{{ $c?->hasImage() ? $c->logo_thumb_url : '' }}" alt="Logo preview" width="100" height="100" @if (! $c?->logo_path) hidden @endif>
    </div>

    <input type="file" name="logo_path" accept="image/*" data-avatar-input class="@error('logo_path') error-input @enderror">
    <div class="hint">JPG, PNG or WebP, up to 2 MB. Optional.</div>
    @error('logo_path')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<br>

<div class="form-actions">
    <button class="btn">{{ $c ? 'Update Company' : 'Create Company' }}</button>
    <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
</div>

<script>
    document.querySelector('[data-avatar-input]')?.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const preview = document.querySelector('[data-logo-preview]');

        if (file && preview) {
            preview.src = URL.createObjectURL(file);
            preview.hidden = false;
        }
    });
</script>

@push('styles')
    @vite('resources/scss/admin/form-company.scss')
@endpush
