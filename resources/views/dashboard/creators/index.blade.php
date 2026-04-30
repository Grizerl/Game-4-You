@extends('layouts.admin')

@section('title', 'Creators')

@section('content')
<a href="{{ route('creator.create') }}" class="btn">+ Add creator</a>
<br><br>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Bio</th>
            <th>Company</th>
            <th width="200">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($creator as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->first_name }}</td>
                <td>{{ $item->last_name }}</td>
                <td>
                    <strong>UA:</strong> {{ $item->getTranslation('bio', 'uk') ?? '-' }} <br>
                    <strong>EN:</strong> {{ $item->getTranslation('bio', 'en') ?? '-' }}
                </td>
                <td>{{ $item->company->name ?? '-' }}</td>

                <td>
                    <a href="{{ route('creator.edit', $item->id) }}" class="edit">Edit</a>
                    <form action="{{ route('creator.destroy', $item->id) }}" method="POST" style="display:inline;">
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