@extends('layouts.main')

@section('media_content')
    <div class="section-creators">
        <div>
            <div class="container">
                <div>
                    <h3 class="creators-title-page">our <span>creators</span></h3>
                    <div style="margin-bottom: 8rem;" class="line"></div>
                </div>
                <div class="creators-card">
                    @foreach ($creators as $creator)
                    <div class="sc-flex background-img">
                        <div class="creator-images">
                            <img src="{{$creator->avatar}}" alt="{{$creator->first_name}}" loading="lazy">
                        </div>
                        <div class="creator-card-bottom">
                            <h4 class="creator-name">{{$creator->first_name}} {{$creator->last_name}}</h4>
                            <p>Bio: {{$creator->bio}}</p>
                            <ul class="info-list">
                                <li class="info-item">Games Count: <span>{{$creator->games_count}}</span></li>
                                <li class="info-item">Company: <span>{{$creator->company?->name}}</span></li>
                                <li class="info-item">Position: <span>{{$creator->role}}</span></li>
                                <li class="info-item">Games: 
                                    @forelse($creator->games as $game)
                                        <span>{{ $game->name }}</span>
                                    @empty
                                        <span>No games</span>
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