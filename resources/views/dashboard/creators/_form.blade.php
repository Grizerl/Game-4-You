{{-- Спільні поля форм створення й редагування творця. $creator — null при створенні. --}}
@php
    $c = $creator ?? null;
    $translated = fn (string $attribute, string $locale): ?string => $c ? $c->getTranslation($attribute, $locale, false) : null;
    $locales = ['uk' => 'UA', 'en' => 'EN'];
    $socialLabels = ['website' => 'Website', 'x' => 'X (Twitter)', 'youtube' => 'YouTube', 'twitch' => 'Twitch', 'instagram' => 'Instagram'];
@endphp

<div class="form-group">
    <label>First Name</label>
    <input type="text" name="first_name" value="{{ old('first_name', $c?->first_name) }}" class="@error('first_name') error-input @enderror" placeholder="Enter first name">
    @error('first_name')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Last Name</label>
    <input type="text" name="last_name" value="{{ old('last_name', $c?->last_name) }}" class="@error('last_name') error-input @enderror" placeholder="Enter last name">
    @error('last_name')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Slug (URL)</label>
    <input type="text" name="slug" value="{{ old('slug', $c?->slug) }}" class="@error('slug') error-input @enderror" placeholder="ivan-petrenko" autocomplete="off">
    <div class="hint">
        Latin letters, digits and hyphens. {{ $c ? 'Leave empty to keep the current one.' : 'Leave empty to generate from the name.' }}
    </div>
    @error('slug')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>Company</label>
    <select name="company_id" class="@error('company_id') error-input @enderror">
        <option value="">-- Select Company --</option>
        @foreach ($companies as $company)
            <option value="{{ $company->id }}" @selected((string) old('company_id', $c?->company_id) === (string) $company->id)>
                {{ $company->name }}
            </option>
        @endforeach
    </select>
    @error('company_id')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Role ({{ $label }})</label>
        <input type="text" name="role[{{ $locale }}]" value="{{ old("role.$locale", $translated('role', $locale)) }}"
               class="@error("role.$locale") error-input @enderror"
               placeholder="{{ $locale === 'uk' ? 'Role in Ukrainian (separate several with commas)' : 'Role in English (separate several with commas)' }}">
        @error("role.$locale")
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
    <label>Career start (year)</label>
    <input type="number" name="career_start" value="{{ old('career_start', $c?->career_start) }}" min="1950" max="{{ now()->year }}"
           class="@error('career_start') error-input @enderror" placeholder="{{ now()->year - 10 }}">
    @error('career_start')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

@foreach ($locales as $locale => $label)
    <div class="form-group">
        <label>Bio ({{ $label }})</label>
        <textarea name="bio[{{ $locale }}]" class="@error("bio.$locale") error-input @enderror"
                  placeholder="{{ $locale === 'uk' ? 'Biography in Ukrainian' : 'Biography in English' }}">{{ old("bio.$locale", $translated('bio', $locale)) }}</textarea>
        @error("bio.$locale")
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
@endforeach

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
    <label>Avatar</label>

    <div class="avatar-preview">
        <img data-avatar-preview src="{{ $c?->hasImage() ? $c->avatar_thumb_url : '' }}" alt="Avatar preview" width="100" height="100" @if (! $c?->avatar) hidden @endif>
    </div>

    <input type="file" name="avatar" accept="image/*" data-avatar-input class="@error('avatar') error-input @enderror">
    <div class="hint">JPG, PNG or WebP, up to 2 MB. Optional.</div>
    @error('avatar')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<br>

<div class="form-actions">
    <button class="btn">{{ $c ? 'Update Creator' : 'Create Creator' }}</button>
    <a href="{{ route('creator.index') }}" class="btn btn-secondary">Cancel</a>
</div>

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

@push('styles')
    @vite('resources/scss/admin/form-creator.scss')
@endpush
