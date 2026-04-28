@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="cards">
        <div class="card">
            <h3>Total Category</h3>
            <p>{{ $categories ?? 0 }}</p>
        </div>

        <div class="card">
            <h3>Total Companies</h3>
            <p>{{ $companies ?? 0 }}</p>
        </div>

        <div class="card">
            <h3>Total Creators</h3>
        <p>{{ $creators ?? 0 }}</p>
        </div>

        <div class="card">
            <h3>Total Games</h3>
            <p>{{ $games ?? 0 }}</p>
        </div>
    </div>

    <div class="hero">
        <h2>🚀 Welcome to your control center</h2>
        <p> Тут ти керуєш всім: категоріями, компаніями, авторами та іграми. Швидко. Чітко. Без зайвого шуму.</p>
    </div>
@endsection