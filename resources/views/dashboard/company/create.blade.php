@extends('layouts.admin')

@section('title', 'Create Company')

@section('content')
<form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Company Name</label>
        <input type="text" name="name" placeholder="Enter company name">
        @error('name')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>About Company</label>
        <textarea name="description" placeholder="Enter description"></textarea>
        @error('description')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Country</label>
        <input type="text" name="country" placeholder="Enter country">
        @error('country')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label>Company Logo</label>
        <input type="file" name="logo_path">
        @error('logo_path')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <br>

    <button type="submit" class="btn">Create Company</button>
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
    }

    input:focus, textarea:focus {
        border-color: #3b82f6;
    }

    input[type="file"] {
        padding: 10px;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
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