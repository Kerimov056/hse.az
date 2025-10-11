@extends('layouts.admin')
@section('title', $resource_type->name)

@section('content')
  <h1 class="mb-2">{{ $resource_type->name }}</h1>
  <p class="text-muted mb-4">Resurs sayı: <b>{{ $resource_type->resources_count }}</b></p>
  <a href="{{ route('admin.resource-types.index') }}" class="btn btn-outline-secondary">← Siyahı</a>
@endsection
