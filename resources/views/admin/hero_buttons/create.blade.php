@extends('layouts.admin')

@section('title', 'Yeni Button')

@section('content')
<div class="container py-3">
  <h1 class="h3 mb-3">Yeni Button əlavə et</h1>

  <form method="POST" action="{{ route('admin.hero-buttons.store') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Button text</label>
      <input type="text" name="text" class="form-control" value="{{ old('text') }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">URL</label>
      <input type="text" name="url" class="form-control" value="{{ old('url') }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Order</label>
      <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
    </div>

    <button class="btn btn-success">Yadda saxla</button>
  </form>
</div>
@endsection
