@extends('layouts.admin')

@section('title', 'Edit Company')

@section('content')
<form action="{{ route('companies.update', $company->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="form-group">
        <label>Company Name (UA)</label>
        <input 
            type="text" 
            name="name[uk]" 
            value="{{ old('name.uk', $company->getTranslation('name', 'uk')) }}"
            class="@error('name.uk') error-input @enderror"
        >

        @error('name.uk')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Company Name (EN)</label>
        <input 
            type="text" 
            name="name[en]" 
            value="{{ old('name.en', $company->getTranslation('name', 'en')) }}"
            class="@error('name.en') error-input @enderror"
        >

        @error('name.en')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Description (UA)</label>
        <textarea 
            name="description[uk]"
            class="@error('description.uk') error-input @enderror"
        >{{ old('description.uk', $company->getTranslation('description', 'uk')) }}</textarea>

        @error('description.uk')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Description (EN)</label>
        <textarea 
            name="description[en]"
            class="@error('description.en') error-input @enderror"
        >{{ old('description.en', $company->getTranslation('description', 'en')) }}</textarea>

        @error('description.en')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Country</label>
        <input type="text" name="country" value="{{ old('country', $company->country) }}" placeholder="Enter country">
        @error('country')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Current Logo</label><br>
        @if($company->logo_path)
            <img src="{{ asset($company->logo_path) }}" width="90" class="logo-preview">
        @else
            <span class="no-logo">No logo uploaded</span>
        @endif
    </div>

    <div class="form-group">
        <label>Change Logo</label>
        <input type="file" name="logo_path">
        @error('logo_path')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <br>

    <button type="submit" class="btn">Update Company</button>
</form>

<style>
    .page-title {
        margin-bottom: 20px;
        color: #e2e8f0;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #94a3b8;
        font-size: 13px;
    }

    input, textarea {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(15, 23, 42, 0.6);
        color: #e2e8f0;
        outline: none;
        transition: 0.2s;
    }

    input:focus, textarea:focus {
        border-color: #3b82f6;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    .logo-preview {
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.25);
    }

    .no-logo {
        color: #64748b;
        font-size: 13px;
    }

    .error {
        color: #f87171;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }

    .btn {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: #fff;
        padding: 12px 18px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn:hover {
        transform: translateY(-1px);
    }
</style>
@endsection