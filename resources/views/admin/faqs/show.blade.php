@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h1 class="h3 mb-3">FAQ — Bax</h1>

  <div class="card">
    <div class="card-body">
      <h5 class="mb-3">{{ $faq->question }}</h5>
      <div class="trix-content">
        {!! $faq->answer !!}
      </div>
      <div class="mt-3">
        Status:
        @if($faq->is_active)
          <span class="badge bg-success">Aktiv</span>
        @else
          <span class="badge bg-secondary">Passiv</span>
        @endif
      </div>
    </div>
  </div>

  <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-primary">Redaktə</a>
  <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Geri</a>
</div>
@endsection
