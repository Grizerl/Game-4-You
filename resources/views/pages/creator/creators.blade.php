@extends('layouts.main')

@section('title', __('creators.meta_title'))

@push('styles')
    @include('pages.creator.partials.assets')
@endpush

@push('head')
    <meta name="description" content="{{ __('creators.meta_description_creators') }}">
    <link rel="canonical" href="{{ route('creator.page') }}">
    @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $locale)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, route('creator.page')) }}">
    @endforeach
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __('creators.meta_title') }}">
    <meta property="og:description" content="{{ __('creators.meta_description_creators') }}">
    <meta property="og:url" content="{{ route('creator.page') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/creators/creators.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="section-creators cr-page">
        <div class="container">
            <div>
                <h3 class="creators-title-page">{{ __('creators.title') }} <span>{{ __('creators.title_span') }}</span></h3>
                <div class="line cr-line"></div>
            </div>

            @if ($stars->isNotEmpty())
                <section class="cr-stars" aria-labelledby="cr-stars-title">
                    <h4 id="cr-stars-title" class="cr-section-title">⭐ {{ __('creators.stars_title') }}</h4>
                    <p class="cr-muted">{{ __('creators.stars_subtitle') }}</p>
                    <div class="cr-stars__grid">
                        @foreach ($stars as $creator)
                            @include('pages.creator.partials.mini', ['creator' => $creator])
                        @endforeach
                    </div>
                </section>
            @endif

            <form class="cr-filters" method="GET" action="{{ route('creator.page') }}" data-cr-filters>
                <label class="cr-field cr-field--search">
                    <span class="cr-field__label">{{ __('creators.search_label') }}</span>
                    <input type="search" name="q" value="{{ $filters['q'] }}" maxlength="100"
                           placeholder="{{ __('creators.search_placeholder') }}">
                </label>

                <label class="cr-field">
                    <span class="cr-field__label">{{ __('creators.company') }}</span>
                    <select name="company" data-cr-auto>
                        <option value="">{{ __('creators.all_companies') }}</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @selected($filters['company'] === $company->id)>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="cr-field">
                    <span class="cr-field__label">{{ __('creators.position') }}</span>
                    <select name="role" data-cr-auto>
                        <option value="">{{ __('creators.all_roles') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" @selected($filters['role'] === $role)>{{ $role }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="cr-field">
                    <span class="cr-field__label">{{ __('creators.sort_label') }}</span>
                    <select name="sort" data-cr-auto>
                        @foreach (\App\Models\Creator::SORTS as $sort)
                            <option value="{{ $sort }}" @selected($filters['sort'] === $sort)>{{ __('creators.sort_' . $sort) }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="cr-filters__actions">
                    <button type="submit" class="cr-btn">{{ __('creators.apply') }}</button>
                    @if ($filters['q'] !== '' || $filters['company'] || $filters['role'] || $filters['sort'] !== 'new')
                        <a class="cr-btn cr-btn--ghost" href="{{ route('creator.page') }}">{{ __('creators.reset') }}</a>
                    @endif
                </div>
            </form>

            @if ($creators->isEmpty())
                <div class="cr-empty">
                    <p class="cr-empty__title">{{ __('creators.nothing_found') }}</p>
                    <p class="cr-muted">{{ __('creators.nothing_found_hint') }}</p>
                    <a class="cr-btn" href="{{ route('creator.page') }}">{{ __('creators.reset') }}</a>
                </div>
            @else
                <div class="cr-grid">
                    @foreach ($creators as $creator)
                        @include('pages.creator.partials.card', ['creator' => $creator])
                    @endforeach
                </div>
            @endif

            {{ $creators->links() }}
        </div>
    </div>
@endsection
