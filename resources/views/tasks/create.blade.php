@extends('layouts.app')
@section('title','Yeni Tapşırıq')
@section('content')
<h1 class="h4 mb-3">Yeni Tapşırıq</h1>
<form action="{{ route('tasks.store') }}" method="post">
  @include('tasks._form')
</form>
@endsection
