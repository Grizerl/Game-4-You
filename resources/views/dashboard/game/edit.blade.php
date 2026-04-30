@extends('layouts.admin')

@section('title', 'Edit Game')

@section('content')

<form action="{{ route('game.update', $game->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="form-group">
    <label>Name (UA)</label>
        <input 
            type="text" 
            name="name[uk]"
            value="{{ old('name.uk', $game->getTranslation('name', 'uk')) }}"
            class="@error('name.uk') error-input @enderror"
        >

        @error('name.uk')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Name (EN)</label>
        <input 
            type="text" 
            name="name[en]"
            value="{{ old('name.en', $game->getTranslation('name', 'en')) }}"
            class="@error('name.en') error-input @enderror"
        >

        @error('name.en')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Description (UA)</label>
        <textarea 
            name="description[uk]"
            class="@error('description.uk') error-input @enderror"
        >{{ old('description.uk', $game->getTranslation('description', 'uk')) }}</textarea>

        @error('description.uk')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Description (EN)</label>
        <textarea 
            name="description[en]"
            class="@error('description.en') error-input @enderror"
        >{{ old('description.en', $game->getTranslation('description', 'en')) }}</textarea>

        @error('description.en')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Cover Image</label>

        @if($game->cover_image)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('storage/' . $game->cover_image) }}" width="120" style="border-radius:10px;">
            </div>
        @endif

        <input 
            type="file" 
            name="cover_image"
            accept="image/*"
            class="@error('cover_image') error-input @enderror">

        @error('cover_image')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Rating</label>
        <input 
            type="number"
            name="rating"
            value="{{ old('rating', $game->rating) }}"
            class="@error('rating') error-input @enderror"
            placeholder="Enter rating">

        @error('rating')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Platforms</label>
        <input 
            type="text"
            name="platforms"
            value="{{ old('platforms', $game->platforms) }}"
            class="@error('platforms') error-input @enderror"
            placeholder="PC, PS5, Xbox">

        @error('platforms')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Category</label>
        <select name="category_id" class="@error('category_id') error-input @enderror">
            <option value="">-- Select Category --</option>
            @foreach($categories as $category)
                <option 
                    value="{{ $category->id }}"
                    {{ old('category_id', $game->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Creator</label>
        <select name="creator_id" class="@error('creator_id') error-input @enderror">
            <option value="">-- Select Creator --</option>
            @foreach($creators as $creator)
                <option 
                    value="{{ $creator->id }}"
                    {{ old('creator_id', $game->creator_id) == $creator->id ? 'selected' : '' }}>
                    {{ $creator->first_name }} {{ $creator->last_name }}
                </option>
            @endforeach
        </select>

        @error('creator_id')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Company</label>
        <select name="company_id" class="@error('company_id') error-input @enderror">
            <option value="">-- Select Company --</option>
            @foreach($companies as $company)
                <option 
                    value="{{ $company->id }}"
                    {{ old('company_id', $game->company_id) == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>

        @error('company_id')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
    <button class="btn">Update</button>
</form>

<style>
    .form-group {
        margin-bottom: 20px;
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
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(15, 23, 42, 0.7);
        color: #e2e8f0;
        outline: none;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #3b82f6;
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
        border-radius: 12px;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>
@endsection