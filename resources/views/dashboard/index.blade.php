@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="cards">
        @foreach ($stats as $stat)
            <a href="{{ route($stat['route']) }}" class="card card-{{ $stat['tone'] }}">
                <span class="card-icon"><i class="fa-solid {{ $stat['icon'] }}"></i></span>
                <div>
                    <h3>{{ $stat['label'] }}</h3>
                    <p>{{ $stat['count'] }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <section class="hero">
        <div>
            <h2>Welcome to your control center</h2>
            <p>Manage games, categories, creators, companies, news and users in one place.</p>
        </div>
        <div class="quick-actions">
            <a href="{{ route('game.create') }}" class="btn btn-light"><i class="fa-solid fa-plus"></i> Game</a>
            <a href="{{ route('news.create') }}" class="btn btn-light"><i class="fa-solid fa-plus"></i> Article</a>
            <a href="{{ route('creator.create') }}" class="btn btn-light"><i class="fa-solid fa-plus"></i> Creator</a>
            <a href="{{ route('users.create') }}" class="btn btn-light"><i class="fa-solid fa-plus"></i> User</a>
        </div>
    </section>
@endsection
