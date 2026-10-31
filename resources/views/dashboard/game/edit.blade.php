@extends('layouts.admin')

@section('title', 'Edit Game')

@section('content')
<form action="{{ route('game.update', $game->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    @include('dashboard.game._form')
</form>
@endsection
