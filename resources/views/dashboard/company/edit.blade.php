@extends('layouts.admin')

@section('title', 'Edit Company')

@section('content')
<form action="{{ route('companies.update', $company->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    @include('dashboard.company._form')
</form>
@endsection
