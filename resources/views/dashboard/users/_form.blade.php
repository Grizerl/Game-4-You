{{-- Fields shared by the create and edit user forms. $user is null when creating. --}}
@php($u = $user ?? null)

<div class="form-row">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $u?->name) }}" autocomplete="name"
               class="@error('name') error-input @enderror">
        @error('name')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $u?->email) }}" autocomplete="off"
               class="@error('email') error-input @enderror">
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="password">{{ $u ? 'New password' : 'Password' }}</label>
        <input type="password" id="password" name="password" autocomplete="new-password"
               class="@error('password') error-input @enderror">
        @error('password')
            <div class="error-text">{{ $message }}</div>
        @enderror
        <div class="hint">{{ $u ? 'Leave empty to keep the current password. ' : '' }}At least 8 characters.</div>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
    </div>
</div>

<div class="form-actions">
    <button class="btn">{{ $u ? 'Update User' : 'Create User' }}</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
</div>

@push('styles')
    @vite('resources/scss/admin/form-user.scss')
@endpush
