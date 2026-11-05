@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="toolbar">
    <a href="{{ route('category.create') }}" class="btn"><i class="fa-solid fa-plus"></i> Add category</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th width="200">Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($category as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    {{ $item->getTranslation('title', 'uk') }}
                    <span class="sep">/</span>
                    {{ $item->getTranslation('title', 'en') }}
                </td>

                <td>
                    <a href="{{ route('category.edit', $item->id) }}" class="edit">Edit</a>
                    <form action="{{ route('category.destroy', $item->id) }}" method="post" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button class="delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="empty"><i class="fa-regular fa-folder-open"></i>No categories found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@push('styles')
    @vite('resources/scss/admin/list-category.scss')
@endpush
@endsection
