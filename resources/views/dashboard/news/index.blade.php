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
                <td><img src="{{ $item->cover_url }}" alt="" width="72" height="40" class="thumb"></td>
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
                    <form action="{{ route('news.destroy', $item) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No articles found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pager">{{ $articles->links() }}</div>

<style>
    .status {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.04em;
    }

    .status-published {
        background: rgba(34, 197, 94, 0.18);
        color: #4ade80;
    }

    .status-draft {
        background: rgba(148, 163, 184, 0.2);
        color: #cbd5e1;
    }

    .status-scheduled {
        background: rgba(250, 204, 21, 0.18);
        color: #facc15;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .search {
        display: flex;
        gap: 8px;
    }

    .search input {
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(15, 23, 42, 0.6);
        color: #e2e8f0;
    }

    .search .btn {
        border: none;
        cursor: pointer;
    }

    .thumb {
        object-fit: cover;
        border-radius: 10px;
    }

    .pager {
        margin-top: 20px;
        color: #94a3b8;
        font-size: 13px;
    }

    .pager nav > div:first-child {
        display: none;
    }

    .pager .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        list-style: none;
    }

    .pager .page-link {
        display: block;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.1);
        color: #e2e8f0;
        text-decoration: none;
    }

    .pager .active .page-link {
        background: #3b82f6;
        border-color: #3b82f6;
    }

    .pager .disabled .page-link {
        opacity: 0.4;
    }

    .btn {
        display: inline-block;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: #fff;
        padding: 10px 15px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        box-shadow: 0 10px 20px rgba(59,130,246,0.25);
        transition: 0.2s;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.05);
        color: #e2e8f0;
    }

    .table thead {
        background: rgba(30, 41, 59, 0.8);
    }

    .table th {
        text-align: left;
        padding: 14px;
        font-size: 13px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 14px;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    .table tbody tr {
        transition: 0.2s;
    }

    .table tbody tr:hover {
        background: rgba(59,130,246,0.08);
    }

    .edit {
        color: #60a5fa;
        margin-right: 12px;
        text-decoration: none;
    }

    .edit:hover {
        text-decoration: underline;
    }

    .delete {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.4);
        padding: 6px 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.2s;
    }

    .delete:hover {
        background: rgba(239, 68, 68, 0.35);
    }
</style>
@endsection