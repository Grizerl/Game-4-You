@extends('layouts.admin')

@section('title', 'Edit Article')

@section('content')
<form action="{{ route('news.update', $article) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    @include('dashboard.news._form')
</form>
@endsection
