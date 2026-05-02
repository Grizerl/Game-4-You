@extends('layouts.admin')

@section('title', 'Create Game')

@section('content')

<form method="post" action="{{ route('game.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>Game Name (UA)</label>
        <input 
            type="text" 
            name="name[uk]" 
            class="@error('name.uk') error-input @enderror"
        >
        @error('name.uk')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Game Name (EN)</label>
        <input 
            type="text" 
            name="name[en]" 
            class="@error('name.en') error-input @enderror"
        >
        @error('name.en')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <!-- DESCRIPTION -->
    <div class="form-group">
        <label>Description (UA)</label>
        <textarea 
            name="description[uk]" 
            class="@error('description.uk') error-input @enderror"
        ></textarea>

        @error('description.uk')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Description (EN)</label>
        <textarea 
            name="description[en]" 
            class="@error('description.en') error-input @enderror"
        ></textarea>

        @error('description.en')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Cover Image</label>
        <input type="file" name="cover_image" accept="image/*" class="@error('cover_image') error-input @enderror">
        @error('cover_image')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Rating</label>
        <input type="number" name="rating" class="@error('rating') error-input @enderror" placeholder="Enter rating">
        @error('rating')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Platforms</label>
        <input type="text" name="platforms" class="@error('platforms') error-input @enderror" placeholder="PC, PS5, Xbox">
        @error('platforms')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Is New</label>
        <select name="isNew" class="@error('isNew') error-input @enderror">
            <option value="0" {{ old('isNew') == 0 ? 'selected' : '' }}>No</option>
            <option value="1" {{ old('isNew') == 1 ? 'selected' : '' }}>Yes</option>
        </select>

        @error('isNew')
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
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    {{ old('creator_id') == $creator->id ? 'selected' : '' }}>
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
                    {{ old('company_id') == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
        @error('company_id')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
    <button class="btn">Create Game</button>
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
        transition: 0.2s;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
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
        font-weight: 600;
    }

    .btn:hover {
        opacity: 0.9;
    }
</style>
@endsection