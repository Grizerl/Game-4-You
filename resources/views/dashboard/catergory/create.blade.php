@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')

<form method="post" action="{{ route('category.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>Category Title (UA)</label>
        <input type="text" name="title[uk]" value="{{ old('title.uk') }}" class="@error('title.uk') error-input @enderror">

        @error('title.uk')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Category Title (EN)</label>
        <input type="text" name="title[en]" value="{{ old('title.en') }}" class="@error('title.en') error-input @enderror">

        @error('title.en')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-actions">
        <button class="btn">Create category</button>
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

@push('styles')
    @vite('resources/scss/admin/category-create.scss')
@endpush
@endsection
