@extends('layouts.admin')

@section('title', 'Games')

@section('content')

<a href="{{ route('game.create') }}" class="btn">+ Add game</a>

<br><br>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Game Title</th>
            <th>Overview</th>
            <th>Score</th>
            <th>Category</th>
            <th>Creator</th>
            <th>Company</th>
            <th width="200">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($game as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    <strong>UA:</strong> {{ $item->getTranslation('name', 'uk') }} <br>
                    <strong>EN:</strong> {{ $item->getTranslation('name', 'en') }}
                </td>

                <td>
                    <strong>UA:</strong> {{ Str::limit($item->getTranslation('description', 'uk'), 50) }} <br>
                    <strong>EN:</strong> {{ Str::limit($item->getTranslation('description', 'en'), 50) }}
                </td>

                <td>{{ $item?->rating }}</td>

                <td>
                    <strong>UA:</strong> {{ $item->category?->getTranslation('title', 'uk') }} <br>
                    <strong>EN:</strong> {{ $item->category?->getTranslation('title', 'en') }}
                </td>
                
                <td>{{ $item->creator?->first_name }}</td>
                
                <td>
                    <strong>UA:</strong> {{ $item->company?->getTranslation('name', 'uk') }} <br>
                    <strong>EN:</strong> {{ $item->company?->getTranslation('name', 'en') }}
                </td>

                <td>
                    <a href="{{ route('game.edit', $item->id) }}" class="edit">Edit</a>
                    <form action="{{ route('game.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="delete">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<style>
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