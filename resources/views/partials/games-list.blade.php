@foreach ($games as $game)
    <div class="sc-ktwOf card">
        <div class="card-top">
            <img src="{{ $game->images }}" alt="{{ $game->name }}" loading="lazy">
            <div class="card-rating">{{ $game->rating }}</div>
        </div>
        <div class="card-bottom">
            <h4 class="card-title">{{ $game->name }}</h4>
            <div class="group-detaile sc-grasf">
                <div>
                    <div class="detaile-item">
                        <p class="detaile-name">Release Date:</p>
                        <p class="detaile-value">{{ $game->release_date }}</p>
                    </div>
                    <div class="detaile-item">
                        <p class="detaile-name">Updated:</p>
                        <p class="detaile-value">{{ $game->updated_at }}</p>
                    </div>
                </div>
                <a href="{{ route('detail', $game->id) }}" class="detaile-btn-custom sc-sfks">See More</a>
            </div>
        </div>
    </div>
@endforeach
