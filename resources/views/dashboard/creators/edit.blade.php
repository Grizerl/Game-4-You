@extends('layouts.admin')

@section('title', 'Edit Creator')

@section('content')

<form action="{{ route('creator.update', $creator->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    @include('dashboard.creators._form')
</form>
@endsection
