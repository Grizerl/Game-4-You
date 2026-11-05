@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<form action="{{ route('users.update', $user) }}" method="post">
    @csrf
    @method('PUT')

    @include('dashboard.users._form', ['user' => $user])
</form>
@endsection
