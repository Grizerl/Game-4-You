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

<style>
    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #94a3b8;
        font-size: 13px;
    }

    input, textarea, select {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(15, 23, 42, 0.6);
        color: #e2e8f0;
    }

    .error-input {
        border-color: #ef4444 !important;
    }

    .error-text {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
    }

    .btn {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: #fff;
        padding: 12px 18px;
        border-radius: 10px;
        border: none;
    }
</style>
@endsection