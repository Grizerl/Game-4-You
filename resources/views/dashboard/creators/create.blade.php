@extends('layouts.admin')

@section('title', 'Create Creator')

@section('content')

<form method="post" action="{{ route('creator.store') }}" enctype="multipart/form-data">
    @csrf

    @include('dashboard.creators._form', ['creator' => null])
</form>
@endsection
