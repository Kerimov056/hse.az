@extends('layouts.admin')
@section('title', $resource->name)

@section('content')
  <h1 class="mb-3">{{ $resource->name }}</h1>
  <div class="card mb-3"><div class="card-body">
    <p><b>Tip:</b> {{ $resource->type?->name ?? '—' }}</p>
    <p><b>Holding:</b> {{ $resource->holdingName ?: '—' }}</p>
    <p><b>İl:</b> {{ $resource->year ?: '—' }}</p>
    <p><b>MIME:</b> {{ $resource->mime ?: '—' }}</p>
    <p><b>URL:</b> <a href="{{ $resource->resourceUrl }}" target="_blank" rel="noopener">{{ $resource->resourceUrl }}</a></p>
    <a class="btn btn-success" href="{{ $resource->resourceUrl }}" download>Yüklə</a>
  </div></div>
  <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-secondary">← Siyahı</a>
@endsection
