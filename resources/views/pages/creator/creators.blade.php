@extends('layouts.main')

@section('media_content')
    <div class="section-creators">
        <div>
            <div class="container">
                <div>
                    <h3 class="creators-title-page">{{ __('creators.title') }} <span>{{ __('creators.title_span') }}</span></h3>
                    <div style="margin-bottom: 8rem;" class="line"></div>
                </div>
                <div class="creators-card">
                    @foreach ($creators as $creator)
                    <div class="sc-flex background-img">
                        <div class="creator-images">
                            <img src="{{ asset('storage/' . $creator->avatar) }}" alt="{{ $creator->first_name }}" loading="lazy">
                        </div>
                        <div class="creator-card-bottom">
                            <h4 class="creator-name">{{$creator->first_name}} {{$creator->last_name}}</h4>
                            <p>{{ __('creators.bio') }}: {{$creator->bio}}</p>
                            <ul class="info-list">
                                <li class="info-item">{{ __('creators.games_count') }}: <span>{{$creator->games_count}} 🎮</span></li>
                                <li class="info-item">{{ __('creators.company') }}: <span>{{$creator->company?->name}}</span></li>
                                <li class="info-item">{{ __('creators.position') }}: <span>{{$creator->role}}</span></li>
                                <li class="info-item">{{ __('creators.games') }}: 
                                    @forelse($creator->games as $game)
                                        <span>{{ $game->name }}</span>
                                    @empty
                                        <span>{{ __('creators.no_games') }}</span>
                                    @endforelse
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endforeach 
                </div>
               {{$creators->links()}}
            </div>
        </div>
    </div>
@endsection