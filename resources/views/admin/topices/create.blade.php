@extends('layouts.admin')
@section('title','Yeni Topic')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <h1 class="mb-0">Yeni Topic</h1>
  <a href="{{ route('admin.topices.index') }}" class="btn btn-outline-secondary">← Siyahıya qayıt</a>
</div>

@if ($errors->any())
  <div class="alert alert-danger">
    <div class="fw-semibold mb-1">Formada xətalar var:</div>
    <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
  </div>
@endif

<form action="{{ route('admin.topices.store') }}" method="post" enctype="multipart/form-data">
  @include('admin.topices._form', ['btn' => 'Yarat'])
</form>
@endsection
