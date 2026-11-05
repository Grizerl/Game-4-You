@extends('layouts.admin')

@section('title', 'Create Article')

@section('content')
<form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    @include('dashboard.news._form', ['article' => null])
</form>
@endsection
