@extends('layouts.admin')
@section('title','Yeni Resurs')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Yeni Resurs</h1>
    <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-secondary">← Siyahı</a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <div class="fw-semibold mb-1">Formada xətalar var:</div>
      <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('admin.resources.store') }}" method="post" enctype="multipart/form-data">
    @include('admin.resources._form', ['resource' => null, 'btn' => 'Yarat'])
  </form>
@endsection
