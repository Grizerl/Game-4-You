@extends('layouts.admin')

@section('title', 'News')

@section('content')
<div class="toolbar">
    <a href="{{ route('news.create') }}" class="btn">+ Add article</a>

    <form method="get" action="{{ route('news.index') }}" class="search">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by title">
        <button class="btn">Search</button>
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Cover</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Published</th>
            <th>Tags</th>
            <th width="260">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($articles as $item)
            @php($status = $item->status())
            <tr>
                <td>{{ $item->id }}</td>
                <td><img src="{{ $item->cover_thumb_url }}" alt="" width="72" height="40" class="thumb"></td>
                <td>
                    <strong>UA:</strong> {{ $item->getTranslation('title', 'uk', false) }} <br>
                    <strong>EN:</strong> {{ $item->getTranslation('title', 'en', false) }}
                </td>
                <td>{{ $item->slug }}</td>
                <td><span class="status status-{{ $status }}">{{ ucfirst($status) }}</span></td>
                <td>{{ $item->published_at?->format('Y-m-d H:i') ?? '—' }}</td>
                <td>{{ $item->tags_count }}</td>

                <td>
                    <a href="{{ route('news.show.page', $item) }}" target="_blank" rel="noopener" class="edit">View</a>
                    <a href="{{ route('news.edit', $item) }}" class="edit">Edit</a>
                    <form action="{{ route('news.destroy', $item) }}" method="POST" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button class="delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="empty"><i class="fa-regular fa-folder-open"></i>No articles found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pager">{{ $articles->links() }}</div>

@push('styles')
    @vite('resources/scss/admin/list-news.scss')
@endpush
@endsection