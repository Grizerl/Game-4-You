@extends('layouts.admin')

@section('title', 'Create Creator')

@section('content')

<form method="post" action="{{ route('creator.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>First Name</label>
        <input  type="text" name="first_name" value="{{ old('first_name') }}" class="@error('first_name') error-input @enderror" placeholder="Enter first name">
        @error('first_name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name" value="{{ old('last_name') }}" class="@error('last_name') error-input @enderror" placeholder="Enter last name">
        @error('last_name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Bio (UA)</label>
        <textarea 
            name="bio[uk]" 
            class="@error('bio.uk') error-input @enderror"
            placeholder="Біографія українською"
        >{{ old('bio.uk') }}</textarea>

        @error('bio.uk')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Bio (EN)</label>
        <textarea 
            name="bio[en]" 
            class="@error('bio.en') error-input @enderror"
            placeholder="Biography in English"
        >{{ old('bio.en') }}</textarea>

        @error('bio.en')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Avatar</label>
        <input type="file" name="avatar" accept="image/*" class="@error('avatar') error-input @enderror">
        @error('avatar')
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
                    {{ (string) old('company_id') === (string) $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
        @error('company_id')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Games Count</label>
        <input type="number" name="games_count" value="{{ old('games_count') }}" class="@error('games_count') error-input @enderror" placeholder="Enter games count">
        @error('games_count')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

   <div class="form-group">
        <label>Role (UA)</label>
        <input 
            type="text" 
            name="role[uk]" 
            value="{{ old('role.uk') }}" 
            class="@error('role.uk') error-input @enderror"
            placeholder="Роль українською"
        >
        @error('role.uk')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Role (EN)</label>
        <input 
            type="text" 
            name="role[en]" 
            value="{{ old('role.en') }}" 
            class="@error('role.en') error-input @enderror"
            placeholder="Role in English"
        >
        @error('role.en')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <button class="btn">Create Creator</button>
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
        outline: none;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #3b82f6;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
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
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    select {
        color: #e2e8f0;
    }

    select option {
        background: #0f172a;
        color: #e2e8f0;
    }
</style>
@endsection