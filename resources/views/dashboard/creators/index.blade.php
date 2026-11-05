@extends('layouts.admin')

@section('title', 'Creators')

@section('content')
<div class="toolbar">
    <a href="{{ route('creator.create') }}" class="btn">+ Add creator</a>

    <form method="get" action="{{ route('creator.index') }}" class="search">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by name">
        <button class="btn">Search</button>
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Company</th>
            <th>Games</th>
            <th width="260">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($creators as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td><img src="{{ $item->avatar_thumb_url }}" alt="" width="44" height="44" class="thumb"></td>
                <td>{{ $item->full_name }}</td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->company->name ?? '-' }}</td>
                <td>{{ $item->games_count }}</td>

                <td>
                    <a href="{{ route('creator.show.page', $item) }}" target="_blank" rel="noopener" class="edit">View</a>
                    <a href="{{ route('creator.edit', $item->id) }}" class="edit">Edit</a>
                    <form action="{{ route('creator.destroy', $item->id) }}" method="POST" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button class="delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No creators found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pager">{{ $creators->links() }}</div>

@push('styles')
    @vite('resources/scss/admin/list.scss')
@endpush
@endsection