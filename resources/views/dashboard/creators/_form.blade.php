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
               placeholder="{{ $locale === 'uk' ? 'Роль українською (кілька — через кому)' : 'Role in English (separate several with commas)' }}">
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
               placeholder="{{ $locale === 'uk' ? 'Країна українською' : 'Country in English' }}">
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
                  placeholder="{{ $locale === 'uk' ? 'Біографія українською' : 'Biography in English' }}">{{ old("bio.$locale", $translated('bio', $locale)) }}</textarea>
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
        <img data-avatar-preview src="{{ $c?->avatar ? $c->avatar_url : '' }}" alt="Avatar preview" width="100" height="100" @if (! $c?->avatar) hidden @endif>
    </div>

    <input type="file" name="avatar" accept="image/*" data-avatar-input class="@error('avatar') error-input @enderror">
    <div class="hint">JPG, PNG or WebP, up to 2 MB. Optional.</div>
    @error('avatar')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

<br>

<button class="btn">{{ $c ? 'Update Creator' : 'Create Creator' }}</button>

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

<style>
    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #94a3b8;
        font-size: 13px;
    }

    input, textarea, select {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(15, 23, 42, 0.6);
        color: #e2e8f0;
        outline: none;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #3b82f6;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    .error-input {
        border-color: #ef4444 !important;
    }

    .error-text {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
    }

    .hint {
        color: #64748b;
        font-size: 12px;
        margin-top: 6px;
    }

    .social-row {
        display: grid;
        grid-template-columns: 110px 1fr;
        gap: 12px;
        align-items: center;
        margin-bottom: 8px;
        color: #94a3b8;
        font-size: 13px;
    }

    .avatar-preview {
        margin-bottom: 10px;
    }

    .avatar-preview img {
        object-fit: cover;
        border-radius: 12px;
    }

    .btn {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: #fff;
        padding: 12px 18px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    select {
        color: #e2e8f0;
    }

    select option {
        background: #0f172a;
        color: #e2e8f0;
    }
</style>
