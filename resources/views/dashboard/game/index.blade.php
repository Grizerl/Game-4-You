@extends('layouts.admin')

@section('title', 'Games')

@section('content')
<div class="toolbar">
    <a href="{{ route('game.create') }}" class="btn">+ Add game</a>

    <form method="get" action="{{ route('game.index') }}" class="search">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by name">
        <button class="btn">Search</button>
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Cover</th>
            <th>Game Title</th>
            <th>Slug</th>
            <th>Score</th>
            <th>Category</th>
            <th>Company</th>
            <th>Comments</th>
            <th width="260">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($game as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td><img src="{{ $item->cover_thumb_url }}" alt="" width="44" height="66" class="thumb"></td>
                <td>
                    <strong>UA:</strong> {{ $item->getTranslation('name', 'uk', false) }} <br>
                    <strong>EN:</strong> {{ $item->getTranslation('name', 'en', false) }}
                </td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->rating }}</td>
                <td>{{ $item->category?->title }}</td>
                <td>{{ $item->company?->name }}</td>
                <td>{{ $item->comments_count }}</td>

                <td>
                    <a href="{{ route('games.show.page', $item) }}" target="_blank" rel="noopener" class="edit">View</a>
                    <a href="{{ route('game.edit', $item->id) }}" class="edit">Edit</a>
                    <form action="{{ route('game.destroy', $item->id) }}" method="POST" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button class="delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="empty"><i class="fa-regular fa-folder-open"></i>No games found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pager">{{ $game->links() }}</div>

@push('styles')
    @vite('resources/scss/admin/list.scss')
@endpush
@endsection