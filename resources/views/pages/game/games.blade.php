@extends('layouts.main')

@section('media_content')
    <div style="background-color: var(--clr-violet-dark-active); padding: 60px 0px;">
        <div>
            <div class="container">
                <div>
                    <h3 class="store-title">
                        {{ __('games.all') }} <span>{{ __('games.games') }}</span>
                    </h3>
                    <div class="line sc-games"></div>
                </div>
                <div class="sc-fsfFfa">
                    <div class="card-list">
                        @foreach ($games as $game)
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
                                        {{$game->rating}} ⭐
                                    </div>
                                </div>
                                <div class="card-bottom">
                                    <h4 class="card-title">{{$game->name}}</h4>
                                    <div class="group-detaile">
                                        <div>
                                            <div class="detaile-item">
                                                <p class="detaile-name">{{ __('games.release_date') }}</p>
                                                <p class="detaile-value">{{$game->created_at->format('Y-m-d')}}</p>
                                            </div>
                                            <div class="detaile-item">
                                                <p class="detaile-name">{{ __('games.updated') }}</p>
                                                <p class="detaile-value">{{$game->updated_at->format('Y-m-d')}}</p>
                                            </div>
                                        </div>
                                        <a href="{{route('games.show.page',$game->id)}}" class="detaile-btn-custom">{{ __('games.see_more') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach  
                    </div>  
                    {{ $games->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection