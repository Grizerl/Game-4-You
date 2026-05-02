@extends('layouts.main')

@section('media_content')
    <div class="sc-sdfTRf">
        <div class="sc-fgdThz">
            <div class="banner-content container w-100">
                <div class="banner-badge">{{ __('home.badge') }}</div>
                <h1 class="banner-title">{{ __('home.title') }}</h1>
                <p class="banner-lead">
                    {{ __('home.description') }}
                </p>
                <button class="btn-custom btn-1">
                    <span><svg enable-background="new 0 0 64 64" height="25" width="25" stroke="currentColor" fill="currentColor" stroke-width="0" id="Layer_1" version="1.1" viewBox="0 0 64 64" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M49.3,20.3c6.7,0,12.2,5.5,12.2,12.2c0,6.7-5.5,12.2-12.2,12.2c-4.8,0-9.1-2.8-11.1-7.2  c-0.4-0.9-1.3-1.5-2.3-1.5h-7.8c-1,0-1.9,0.6-2.3,1.5c-2,4.4-6.3,7.2-11.1,7.2C8,44.6,2.6,39.1,2.6,32.4c0-6.7,5.5-12.2,12.2-12.2  H49.3 M49.3,17.8H14.7c-8.1,0-14.7,6.6-14.7,14.7c0,8.1,6.6,14.7,14.7,14.7c5.9,0,11.1-3.5,13.4-8.6h7.8c2.3,5.1,7.4,8.6,13.4,8.6  c8.1,0,14.7-6.6,14.7-14.7C63.9,24.3,57.4,17.8,49.3,17.8L49.3,17.8z" fill="#20293B"/><circle cx="14.7" cy="32.4" fill="none" r="6.9" stroke="#20293B" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5"/><path d="M49.3,22.9c-5.2,0-9.5,4.3-9.5,9.5s4.3,9.5,9.5,9.5c5.2,0,9.5-4.3,9.5-9.5S54.5,22.9,49.3,22.9z M44.9,34.2  c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7s1.7,0.8,1.7,1.7S45.9,34.2,44.9,34.2z M49.3,38.5c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7  c1,0,1.7,0.8,1.7,1.7S50.2,38.5,49.3,38.5z M49.3,29.8c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7c1,0,1.7,0.8,1.7,1.7  S50.2,29.8,49.3,29.8z M53.6,34.2c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7s1.7,0.8,1.7,1.7S54.5,34.2,53.6,34.2z" fill="#20293B"/><polygon fill="#20293B" points="15.8,31.3 15.8,29 13.7,29 13.7,31.3 11.2,31.3 11.2,33.5 13.7,33.5 13.7,35.9 15.8,35.9 15.8,33.5   18.2,33.5 18.2,31.3 "/><path d="M32.2,33L32.2,33c-0.3-0.3-0.3-0.9,0-1.2l2.2-2.2c0.3-0.3,0.9-0.3,1.2,0v0c0.3,0.3,0.3,0.9,0,1.2L33.4,33  C33.1,33.4,32.5,33.4,32.2,33z" fill="#20293B"/><path d="M27.1,33L27.1,33c-0.3-0.3-0.3-0.9,0-1.2l2.2-2.2c0.3-0.3,0.9-0.3,1.2,0l0,0c0.3,0.3,0.3,0.9,0,1.2L28.3,33  C28,33.4,27.4,33.4,27.1,33z" fill="#20293B"/><path d="M21.6,16.9h-7.8c-1,0-1.7,0.8-1.7,1.7v0h11.2v0C23.4,17.7,22.6,16.9,21.6,16.9z" fill="#20293B"/><path d="M50.1,16.9h-7.8c-1,0-1.7,0.8-1.7,1.7v0h11.2v0C51.9,17.7,51.1,16.9,50.1,16.9z" fill="#20293B"/></svg></span>
                    <span>{{ __('home.play_now') }}</span>
                </button>
            </div>
        </div>
    </div>
<section>
    <div class="sc-sdsPFK">
        <div class="container">
            <div class="sc-sghRfa">
                <div class="upxXb">
                <h3>
                    {{ __('home.top_games') }} <span>{{ __('home.games') }}</span>
                </h3>
                <div class="line"></div>
            </div>
            <div class="sc-fsfFfa">
                <div class="card-list">
                    @foreach ($game as $games)
                         <div class="sc-ktwOfi card">
                        <div class="card-top">
                            <img src="{{ asset('storage/' . $games->cover_image) }}" alt="{{ $games->name }}">
                            <div class="card-rating">
                                {{ $games->rating }}
                                <svg height="1.3em" width="1.3em" stroke="currentColor" fill="currentColor" strole-width="0" viewBox="0 0 512 512" class="st-1" xmlns="http://www.w3.org/2000/svg">
                                    <g data-name="1" id="_1">
                                    <path d="M370.24,425.59a14.89,14.89,0,0,1-7-1.72L257,368,150.74,423.87A15,15,0,0,1,129,408.06l20.3-118.32-86-83.8a15,15,0,0,1,8.31-25.59l118.81-17.26L243.55,55.43a15,15,0,0,1,26.9,0l53.13,107.66,118.8,17.26a15,15,0,0,1,8.32,25.59l-86,83.8L385,408.06a15,15,0,0,1-14.78,17.53ZM106,205.67l69.85,68.09A15,15,0,0,1,180.17,287l-16.49,96.14L250,337.78a15,15,0,0,1,14,0l86.34,45.39L333.83,287a15,15,0,0,1,4.31-13.27L408,205.67l-96.53-14a15,15,0,0,1-11.29-8.2L257,96l-43.17,87.47a15,15,0,0,1-11.3,8.2Z"/>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="card-bottom">
                            <h4 class="card-title">{{ $games->name }}</h4>
                            <div class="group-detaile">
                                <div>
                                    <div class="detaile-item">
                                        <p class="detaile-name">{{ __('home.release_date') }}</p>
                                        <p class="detaile-value">{{ $games->created_at->format('Y-m-d') }}</p>
                                    </div>
                                    <div class="detaile-item">
                                        <p class="detaile-name">{{ __('home.updated') }}</p>
                                        <p class="detaile-value">{{ $games->updated_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                                    <a href="{{route('games.show.page', $games->id)}}" class="detaile-btn-custom">{{ __('home.see_more') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>  
                </div>
                <div style="display: flex; align-items: center; margin-top: 50px;">
                    <div class="container">
                        <a class="card-button btn-card" href="{{route('games.page')}}"><span>{{ __('home.see_more_games') }}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="sc-DdshD section">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_1-mc0Hy4Sp.png') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_2-RlRwE6th.jpg') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_3-VvERGk7i.jpg') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_4-YfdR9_hu.jpg') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_5-U2mFURCN.jpg') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_6-KOIDvTyl.jpg') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_7-S7uvxQ7h.jpg') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_8-KU12EZws.jpg') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_9-NlFxEIDi.jpg') }}" alt="slider-img" loading="lazy"></div>
            <div class="swiper-slide"><img src="{{ asset('assets/images/swiper/slider_img_10-lvYJu-HK.jpg') }}" alt="slider-img" loading="lazy"></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
<section>
    <div>
        <div class="sc-join" style="padding: 60px 0px; background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/images/join_image.png') }}') center center / cover no-repeat; ">
            <div class="container">
                <div class="join-container">
                    <h2 class="join-title">{{ __('home.join') }} <span>{{ __('home.community') }}</span></h2>
                    <p class="join-lead">
                        {{ __('home.join_text') }}
                    </p>
                    <button class="join-btn"><a href="https://discord.com/"> {{ __('home.join_discord') }}</a></button>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sc-genres">
    <div class="sc-sfFgg">
        <h3 class="genres-title">{{ __('home.top') }}<span>{{ __('home.genres') }}</span></h3>
        <div class="line"></div>
        <div class="sc-DfghF">
            <div class="container-genres">
            <div class="tabs-content">
            <div style="margin-top: 20px;">
            <button id="btn-category" class="burger">
                    <svg style="enable-background:new 0 0 24 24;" stroke="currentColor" fill="currentColor" stroke-width="0" height="32" width="32"  version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="info"/><g id="icons"><g id="menu">
                                <path d="M20,10H4c-1.1,0-2,0.9-2,2c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2C22,10.9,21.1,10,20,10z"/>
                                <path d="M4,8h12c1.1,0,2-0.9,2-2c0-1.1-0.9-2-2-2H4C2.9,4,2,4.9,2,6C2,7.1,2.9,8,4,8z"/>
                                <path d="M16,16H4c-1.1,0-2,0.9-2,2c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2C18,16.9,17.1,16,16,16z"/>
                            </g></g>
                        </svg>
                    </button>
                <div id="navbar-menu-category" class="burger-container">
                <ul class="list-genres">
                     @foreach ($categories as $category)
                        <li class="genres-item">
                            <a href="{{ route('home.page', ['category_id' => $category->id]) }}" class="category-link {{ $category->id == $category_id ? 'active-category' : '' }}">
                                {{ $category->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
            </div>
            <div class="tabs-body">
                <div class="sc-fsfFfa"> 
                    <div class="card-list" id="games-container">
                        @include('partials.games-list', ['games' => $categories->first()->games ?? []])
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="sc-store">
        <h3>
            {{ __('home.our') }} <span class="aside-title">{{ __('home.game_stores') }}</span>
        </h3>
        <div style="margin-bottom: 30px;" class="line"></div>
        <div class="container">
            <div class="sc-FgFhjg">
                @foreach ($storeGame as $storeGames)
                    <div class="card-store">
                    <div class="card-img">
                        <img src="{{ asset('storage/' . $storeGames->cover_image) }}" alt="{{ $storeGames->name }}" loading="lazy">
                    </div>
                    <div class="card-container">
                    <ul class="card-store-info">
                        <li>
                            <span class="text-white">{{ __('home.platforms') }}</span>
                            <a>{{ $storeGames->platforms }}</a>
                        </li>
                        <li>
                            <span class="text-white">{{ __('home.games_rating') }}</span>
                            <a>{{ $storeGames->rating }}</a>
                        </li>
                    </ul>
                    <p style="font-weight: 700; margin-bottom: 10px;" class="text-white">{{ __('home.games_label') }}</p>
                    <ul class="card-store-games">
                        <li>
                            <a class="game-name">Grand Theft Auto V</a>
                        </li>
                        <li>
                            <a class="game-name">The Witcher 3: Wild Hunt</a>
                        </li>
                        <li>
                            <a class="game-name">Portal 2</a>
                        </li>
                        <li>
                            <a class="game-name">Counter-Strike</a>
                        </li>
                        <li>
                            <a class="game-name">Tomb Raider (2013)</a>
                        </li>
                        <li>
                            <a class="game-name">Portal</a>
                        </li>
                    </ul>
                    </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $(document).on('click', '.category-link', function(e) {
        e.preventDefault(); 
        let categoryId = $(this).attr('href').split('category_id=')[1]; 
        $('.category-link').removeClass('active-category');
        $(this).addClass('active-category');
        $.ajax({
            url: "{{ route('games') }}",
            type: "GET",
            data: { category_id: categoryId },
           success: function(response) {
                $('#games-container').html(response);

                if (swiper) {
                    swiper.destroy(true, true);
                }

                initSwiper();
            },
            error: function(xhr) {
                console.error("Помилка AJAX:", xhr.responseText); 
            }
        });
    });
});
</script>
@endsection