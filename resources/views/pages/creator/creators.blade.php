@extends('layouts.app')

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
                            <img src="{{$creator->images}}" alt="{{$creator->name}}" loading="lazy">
                        </div>
                        <div class="creator-card-bottom">
                            <h4 class="creator-name">{{$creator->name}}</h4>
                            <ul class="info-list">
                                <li class="info-item">Games Count: <span>{{$creator->games_count}}</span></li>
                                <li class="info-item">Position: <span>{{$creator->position}}</span></li>
                                <li class="info-item">Games: <span>{{$creator->games}}</span></li>
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