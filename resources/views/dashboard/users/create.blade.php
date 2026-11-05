@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<form action="{{ route('users.store') }}" method="post">
    @csrf

    @include('dashboard.users._form', ['user' => null])
</form>
@endsection
