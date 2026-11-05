@extends('layouts.admin')

@section('title', 'Create Company')

@section('content')
<form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    @include('dashboard.company._form', ['company' => null])
</form>
@endsection
