@extends('layouts.app')

@section('media_content')
 <div style="background-color: var(--clr-violet-dark-active); padding: 60px 0px;">
    <div>
        <div class="container">
            <div>
                <h3 class="store-title">all <span>games</span></h3>
                <div class="line sc-games"></div>
            </div>
            <div class="sc-fsfFfa">
                <div class="card-list">
                    @foreach ($games as $game)
                        <div class="sc-ktwOfi card">
                        <div class="card-top">
                            <img src="{{$game->images}}" alt="{{$game->name}}" loading="lazy">
                            <div class="card-rating">
                                {{$game->cursing}}
                                <svg height="1.3em" width="1.3em" stroke="currentColor" fill="currentColor" strole-width="0" viewBox="0 0 512 512" class="st-1" xmlns="http://www.w3.org/2000/svg">
                                    <g data-name="1" id="_1">
                                    <path d="M370.24,425.59a14.89,14.89,0,0,1-7-1.72L257,368,150.74,423.87A15,15,0,0,1,129,408.06l20.3-118.32-86-83.8a15,15,0,0,1,8.31-25.59l118.81-17.26L243.55,55.43a15,15,0,0,1,26.9,0l53.13,107.66,118.8,17.26a15,15,0,0,1,8.32,25.59l-86,83.8L385,408.06a15,15,0,0,1-14.78,17.53ZM106,205.67l69.85,68.09A15,15,0,0,1,180.17,287l-16.49,96.14L250,337.78a15,15,0,0,1,14,0l86.34,45.39L333.83,287a15,15,0,0,1,4.31-13.27L408,205.67l-96.53-14a15,15,0,0,1-11.29-8.2L257,96l-43.17,87.47a15,15,0,0,1-11.3,8.2Z"/>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="card-bottom">
                            <h4 class="card-title">{{$game->name}}</h4>
                            <div class="group-detaile">
                                <div>
                                    <div class="detaile-item">
                                        <p class="detaile-name">Release Date:</p>
                                        <p class="detaile-value">{{$game->release_date}}</p>
                                    </div>
                                    <div class="detaile-item">
                                        <p class="detaile-name">Updated:</p>
                                        <p class="detaile-value">{{$game->updated}}</p>
                                    </div>
                                </div>
                                    <a href="{{route('detail',$game->id)}}" class="detaile-btn-custom">See More</a>
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