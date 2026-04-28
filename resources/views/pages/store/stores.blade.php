@extends('layouts.main')

@section('media_content')
<div class="store-section">
    <div class="container">

        <h3 class="store-title">
            {{ __('companies.all') }} <span>{{ __('companies.title_span') }}</span>
        </h3>
        <div class="line"></div>

        <div class="company-grid">

            @foreach ($company as $companies)
                <div class="company-card">

                    <div class="company-image">
                        <img src="{{ asset('storage/' . $companies->logo_path) }}" alt="{{ $companies->name }}" loading="lazy">
                    </div>

                    <div class="company-content">

                        <h4 class="company-title">
                            {{ $companies->name }}
                        </h4>

                        <p class="company-text">
                            {{ Str::limit($companies->description, 100) }}
                        </p>

                        <div class="company-footer">
                            <span class="company-country">
                                🌍 {{ $companies->country }}
                            </span>
                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
</div>
@endsection