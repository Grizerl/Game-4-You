@extends('layouts.main')

@section('media_content')
<div class="section-details">
    <div>
        <div class="container">
            <div class="category">
                <ul class="category-nav">
                    <li class="category-item">
                        <a class="category-link" href="{{route('home.page')}}">{{ __('game.home') }}/</a>
                    </li>
                    <li class="category-item">
                        <a class="category-link" href="{{route('games.page')}}">{{ __('game.games') }}/</a>
                    </li>
                    <li class="category-item">
                        <a class="category-link">{{$game->name}}</a>
                    </li>
                </ul>
            </div>

            <div class="details-container">
                <div>
                    <h3 class="details-title">{{$game->name}}</h3>
                </div>

                <div class="details-grid">
                    <div class="details-left">
                        <img src="{{$game->cover_image}}" alt="{{$game->name}}" loading="lazy">
                    </div>

                    <div class="details-right">
                        <h4 class="details-right-title">
                            <span>{{ __('game.game_details') }}</span>
                        </h4>

                        <p class="details-right-lead">
                            {{Str::limit($game->description, 355)}}
                        </p>

                        <div style="margin: 50px 0px;">
                            <ul class="details-right-navbar">
                                <li class="details-right-items">
                                   {{ __('game.release_date') }}:
                                    <span>{{$game->created_at}}</span>
                                </li>

                                <li class="details-right-items">
                                    {{ __('game.platforms') }}:
                                    <span>{{$game->platforms}}</span>
                                </li>

                                <li class="details-right-items">
                                    {{ __('game.creators') }}:
                                    <span>{{$game->creator?->first_name}} {{$game->creator?->last_name_name}}</span>
                                </li>

                                <li class="details-right-items">
                                    {{ __('game.company') }}:
                                    <span>{{$game->company?->name}}</span>
                                </li>
                            </ul>
                            <div>
                                <button id="open-comment-modal" class="btn-add-comment">
                                    {{ __('game.add_comment') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-bottom-btn-container">
                <div class="container">

                    <ul class="btn-navbar">
                        <li class="btn-items">
                            <a id="btn-description" class="btn-link active" href="javascript:void(0)">{{ __('game.description') }}</a>
                        </li>
                        <li class="btn-items">
                            <a id="btn-platform" class="btn-link" href="javascript:void(0)">{{ __('game.platforms') }}</a>
                        </li>
                        <li class="btn-items">
                            <a id="btn-comments" class="btn-link" href="javascript:void(0)"> {{ __('game.comments') }}</a>
                        </li>
                    </ul>

                    <div id="description-info" class="page-description show">
                        <h4 class="description-title">{{ __('game.game_description') }}</h4>
                        <div class="description-lead">
                            {{ $game->description }}
                        </div>
                    </div>

                    <div id="platform-info" class="page-platform">
                        <h4 class="platform-title">{{ __('game.game_platforms') }}</h4>

                        @php
                            $platforms = explode(', ', $game->platforms);
                            $chunks = array_chunk($platforms, 3);
                        @endphp

                        @foreach($chunks as $chunk)
                            <div class="chunk">
                                @foreach($chunk as $platform)
                                    <span>{{ $platform }}</span>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div id="comments-info" class="page-platform">
                        <h4 class="description-title">{{ __('game.comments') }}</h4>

                        <div class="comments-container">
                            @forelse($comment as $comments)
                                <div class="comment-card">
                                    
                                    <div class="comment-header">
                                        <div class="avatar">
                                            {{ strtoupper(substr($comments->name, 0, 1)) }}
                                        </div>

                                        <div class="user-info">
                                            <span class="username">{{ $comments->name }}</span>
                                            <span class="date">{{ $comments->created_at }}</span>
                                        </div>
                                    </div>

                                    <div class="comment-body">
                                        {{ $comments->content }}
                                    </div>

                                </div>
                            @empty
                                <p class="no-comments">{{ __('game.no_comments') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="comment-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>

        <h3 style="margin-bottom: 15px;">{{ __('game.add_comment') }}</h3>

        <form action="{{ route('comments.store') }}" method="POST">
            @csrf

            <input type="hidden" name="game_id" value="{{ $game->id }}">

            <div class="form-group">
                <input type="text" name="name" placeholder="{{ __('game.your_name') }}" required>
            </div>

            <div class="form-group">
                <textarea name="content" placeholder="{{ __('game.your_comment') }}" required></textarea>
            </div>
            
            <button type="submit" class="btn-submit">{{ __('game.submit') }}</button>
        </form>
    </div>
</div>
@endsection