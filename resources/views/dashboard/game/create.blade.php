@extends('layouts.admin')

@section('title', 'Create Game')

@section('content')
<form action="{{ route('game.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    @include('dashboard.game._form', ['game' => null])
</form>
@endsection
