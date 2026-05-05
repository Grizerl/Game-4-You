@extends('layouts.main')

@section('media_content')
<div style="background-color: var(--clr-violet-dark-active); padding: 60px 0px;">
    <div class="container">
        <h3 class="store-title">
            {{ __('games.all') }} <span>{{ __('games.games') }}</span>
        </h3>
        <div class="line sc-games"></div>

        <form action="{{ route('games.page') }}" method="get" class="filter-form">
            <select name="category">
                <option value="">{{ __('games.all_categories') ?? 'All categories' }}</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}>

                        {{ $category->title }}
                    </option>
                @endforeach
            </select>

            <button type="submit">
                {{ __('games.filter') ?? 'Filter' }}
            </button>
        </form>

        <div class="sc-fsfFfa">
            <div class="card-list">

                @forelse ($games as $game)
                    <div class="sc-ktwOfi card">

                        <div class="card-top">
                            <div class="game-image">
                                <img 
                                    src="{{ asset('storage/' . $game->cover_image) }}" 
                                    alt="{{ $game->name }}"
                                    loading="lazy"
                                >
                            </div>

                            <div class="card-rating">
                                {{ $game->rating }} ⭐
                            </div>
                        </div>

                        <div class="card-bottom">
                            <h4 class="card-title">{{ $game->name }}</h4>

                            <div class="group-detaile">
                                <div>
                                    <div class="detaile-item">
                                        <p class="detaile-name">{{ __('games.release_date') }}</p>
                                        <p class="detaile-value">
                                            {{ $game->created_at->format('Y-m-d') }}
                                        </p>
                                    </div>

                                    <div class="detaile-item">
                                        <p class="detaile-name">{{ __('games.updated') }}</p>
                                        <p class="detaile-value">
                                            {{ $game->updated_at->format('Y-m-d') }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('games.show.page', $game->id) }}"
                                   class="detaile-btn-custom">
                                    {{ __('games.see_more') }}
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <p style=" font-size: 5rem; color:#fff;">{{ __('games.no_found') }}</p>
                @endforelse

            </div>

            <div style="margin-top: 30px;">
                {{ $games->links() }}
            </div>
        </div>

    </div>
</div>
@endsection