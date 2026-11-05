@extends('layouts.admin')

@section('title', 'Image sizes')

@section('content')

@if (session('status'))
    <div class="flash">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('settings.images.update') }}" class="size-form">
    @csrf
    @method('PUT')

    <h2 class="section-title">Обкладинки ігор і новин</h2>

    <div class="size-grid">
        <div></div>
        <div class="size-head">Десктоп, px</div>
        <div class="size-head">Мобільний (до 720 px), px</div>

        @foreach ([
            'thumb' => 'Мініатюра (постери, картки)',
            'large' => 'Великий банер (hero, новини)',
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

    <h2 class="section-title">Аватари й логотипи</h2>

    <div class="size-grid size-grid--single">
        <div></div>
        <div class="size-head">Ширина, px</div>

        @foreach ([
            'avatar_thumb' => 'Аватар творця',
            'logo_thumb' => 'Логотип компанії',
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

    <p class="hint">Ширина в пікселях ({{ $min }}–{{ $max }}); мобільна не може бути більшою за десктопну. Зображення не збільшуються понад оригінал.
        Мобільні версії отримують відвідувачі з вікном до 720 px. Після зміни наявні зображення перегенеровуються у фоні (потрібен queue worker).</p>

    <button class="btn">Зберегти</button>
</form>

<form method="POST" action="{{ route('settings.images.regenerate') }}" class="size-form size-form--regen">
    @csrf
    <button class="btn btn-secondary">Перегенерувати всі зображення</button>
</form>

@push('styles')
    @vite('resources/scss/admin/settings.scss')
@endpush
@endsection
