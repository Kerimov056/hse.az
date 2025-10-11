@extends('layouts.admin')
@section('title','Topic redaktə et')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div>
    <h1 class="mb-1">Topic redaktə et</h1>
    <div class="text-muted">#{{ $topic->id }}</div>
  </div>
  <a href="{{ route('admin.topices.index') }}" class="btn btn-outline-secondary">← Siyahıya qayıt</a>
</div>

@if ($errors->any())
  <div class="alert alert-danger">
    <div class="fw-semibold mb-1">Formada xətalar var:</div>
    <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
  </div>
@endif

<form action="{{ route('admin.topices.update', $topic) }}" method="post" enctype="multipart/form-data">
  @method('PUT')
  @include('admin.topices._form', ['topic'=>$topic, 'btn' => 'Yadda saxla'])
</form>
@endsection
