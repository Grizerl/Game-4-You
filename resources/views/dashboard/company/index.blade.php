@extends('layouts.admin')

@section('title', 'Companies')

@section('content')
<div class="toolbar">
    <a href="{{ route('companies.create') }}" class="btn">+ Add New Company</a>

    <form method="get" action="{{ route('companies.index') }}" class="search">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by name">
        <button class="btn">Search</button>
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Logo</th>
            <th>Company</th>
            <th>Slug</th>
            <th>Country</th>
            <th>Games</th>
            <th>Creators</th>
            <th width="260">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($company as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td><img src="{{ $item->logo_thumb_url }}" alt="" width="44" height="44" class="thumb"></td>
                <td>
                    <strong>UA:</strong> {{ $item->getTranslation('name', 'uk', false) }} <br>
                    <strong>EN:</strong> {{ $item->getTranslation('name', 'en', false) }}
                </td>
                <td>{{ $item->slug }}</td>
                <td>
                    <strong>UA:</strong> {{ $item->getTranslation('country', 'uk', false) }} <br>
                    <strong>EN:</strong> {{ $item->getTranslation('country', 'en', false) }}
                </td>
                <td>{{ $item->games_count }}</td>
                <td>{{ $item->creators_count }}</td>

                <td>
                    <a href="{{ route('company.show.page', $item) }}" target="_blank" rel="noopener" class="edit">View</a>
                    <a href="{{ route('companies.edit', $item->id) }}" class="edit">Edit</a>
                    <form action="{{ route('companies.destroy', $item->id) }}" method="POST" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button class="delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No companies found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pager">{{ $company->links() }}</div>

@push('styles')
    @vite('resources/scss/admin/list.scss')
@endpush
@endsection