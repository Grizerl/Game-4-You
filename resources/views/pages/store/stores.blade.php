@extends('layouts.main')

@section('title', __('companies.all') . ' ' . __('companies.title_span') . ' — Games 4 You')

@push('styles')
    @include('pages.store.partials.assets')
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/creators/creators.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="section-creators cr-page">
        <div class="container">
            <div>
                <h3 class="creators-title-page">{{ __('companies.all') }} <span>{{ __('companies.title_span') }}</span></h3>
                <div class="line cr-line"></div>
            </div>

            @if ($top->isNotEmpty())
                <section class="cr-stars" aria-labelledby="co-top-title">
                    <h4 id="co-top-title" class="cr-section-title">🏆 {{ __('companies.top_title') }}</h4>
                    <p class="cr-muted">{{ __('companies.top_subtitle') }}</p>
                    <div class="cr-stars__grid">
                        @foreach ($top as $company)
                            @include('pages.store.partials.mini', ['company' => $company])
                        @endforeach
                    </div>
                </section>
            @endif

            <form class="cr-filters co-filters" method="GET" action="{{ route('company.page') }}" data-cr-filters>
                <label class="cr-field cr-field--search">
                    <span class="cr-field__label">{{ __('companies.search_label') }}</span>
                    <input type="search" name="q" value="{{ $filters['q'] }}" maxlength="100"
                           placeholder="{{ __('companies.search_placeholder') }}">
                </label>

                <label class="cr-field">
                    <span class="cr-field__label">{{ __('companies.country') }}</span>
                    <select name="country" data-cr-auto>
                        <option value="">{{ __('companies.all_countries') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}" @selected($filters['country'] === $country)>{{ $country }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="cr-field">
                    <span class="cr-field__label">{{ __('companies.sort_label') }}</span>
                    <select name="sort" data-cr-auto>
                        @foreach (\App\Models\Company::SORTS as $sort)
                            <option value="{{ $sort }}" @selected($filters['sort'] === $sort)>{{ __('companies.sort_' . $sort) }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="cr-filters__actions">
                    <button type="submit" class="cr-btn">{{ __('companies.apply') }}</button>
                    @if ($filters['q'] !== '' || $filters['country'] || $filters['sort'] !== 'new')
                        <a class="cr-btn cr-btn--ghost" href="{{ route('company.page') }}">{{ __('companies.reset') }}</a>
                    @endif
                </div>
            </form>

            @if ($companies->isEmpty())
                <div class="cr-empty">
                    <p class="cr-empty__title">{{ __('companies.nothing_found') }}</p>
                    <p class="cr-muted">{{ __('companies.nothing_found_hint') }}</p>
                    <a class="cr-btn" href="{{ route('company.page') }}">{{ __('companies.reset') }}</a>
                </div>
            @else
                <div class="cr-grid">
                    @foreach ($companies as $company)
                        @include('pages.store.partials.card', ['company' => $company])
                    @endforeach
                </div>
            @endif

            {{ $companies->links() }}
        </div>
    </div>
@endsection
