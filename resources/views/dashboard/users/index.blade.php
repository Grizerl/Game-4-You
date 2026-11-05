@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="toolbar">
    <a href="{{ route('users.create') }}" class="btn"><i class="fa-solid fa-plus"></i> Add user</a>

    <form method="get" action="{{ route('users.index') }}" class="search">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by name or email">
        <button class="btn">Search</button>
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Registered</th>
            <th width="200">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    {{ $item->name }}
                    @if ($item->is(auth()->user()))
                        <span class="status status-you">You</span>
                    @endif
                </td>
                <td>{{ $item->email }}</td>
                <td>
                    @if ($item->email_verified_at)
                        <span class="status status-verified">Verified</span>
                    @else
                        <span class="status status-unverified">Unverified</span>
                    @endif
                </td>
                <td>{{ $item->created_at?->format('Y-m-d H:i') ?? '—' }}</td>

                <td>
                    <a href="{{ route('users.edit', $item) }}" class="edit">Edit</a>
                    @unless ($item->is(auth()->user()))
                        <form action="{{ route('users.destroy', $item) }}" method="POST" class="inline-form"
                              onsubmit="return confirm('Delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button class="delete">Delete</button>
                        </form>
                    @endunless
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="empty"><i class="fa-regular fa-folder-open"></i>No users found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pager">{{ $users->links() }}</div>

@push('styles')
    @vite('resources/scss/admin/list-users.scss')
@endpush
@endsection
