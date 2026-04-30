@foreach ($games as $game)
    <div class="sc-ktwOf card">
        <div class="card-top">
            <img src="{{  asset('storage/' . $game->cover_image) }}" alt="{{ $game->name }}" loading="lazy">
            <div class="card-rating">{{ $game->rating }} ⭐</div>
        </div>
        <div class="card-bottom">
            <h4 class="card-title">{{ $game->name }}</h4>
            <div class="group-detaile sc-grasf">
                <div>
                    <div class="detaile-item">
                        <p class="detaile-name">{{ __('home.release_date') }}</p>
                        <p class="detaile-value">{{ $game->created_at }}</p>
                    </div>
                    <div class="detaile-item">
                        <p class="detaile-name">{{ __('home.updated') }}</p>
                        <p class="detaile-value">{{ $game->updated_at }}</p>
                    </div>
                </div>
                <a href="{{ route('games.show.page', $game->id) }}" class="detaile-btn-custom sc-sfks">{{ __('home.see_more') }}</a>
            </div>
        </div>
    </div>
@endforeach
