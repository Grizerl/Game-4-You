@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

<form method="post" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data">
    @csrf
    @method('put')

   <div class="form-group">
        <label>Category Title (UA)</label>
        <input 
            type="text" 
            name="title[uk]" 
            value="{{ old('title.uk', $category->getTranslation('title', 'uk')) }}" 
            class="@error('title.uk') error-input @enderror"
        >

        @error('title.uk')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Category Title (EN)</label>
        <input 
            type="text" 
            name="title[en]" 
            value="{{ old('title.en', $category->getTranslation('title', 'en')) }}" 
            class="@error('title.en') error-input @enderror"
        >

        @error('title.en')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
    <button class="btn">Update сategory</button>
</form>

@push('styles')
    @vite('resources/scss/admin/category-edit.scss')
@endpush
@endsection