@extends('layouts.app')
@section('title','Tapşırığı Redaktə Et')
@section('content')
<h1 class="h4 mb-3">Tapşırığı Redaktə Et</h1>
<form action="{{ route('tasks.update',$task) }}" method="post">
  @method('PUT')
  @include('tasks._form',['task'=>$task])
</form>
@endsection
