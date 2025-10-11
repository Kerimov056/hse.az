@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h1 class="h3 mb-3">Accreditation — Bax</h1>

  <div class="card mb-3">
    <div class="card-body">
      @if($item->imageUrl)
        <div class="mb-3">
          <img src="{{ $item->imageUrl }}" alt="" style="max-width:320px;border-radius:10px">
        </div>
      @endif

      <div class="trix-content">
        {!! $item->description !!}
      </div>
    </div>
  </div>

  <a href="{{ route('admin.accreditations.edit', $item) }}" class="btn btn-primary">Redaktə</a>
  <a href="{{ route('admin.accreditations.index') }}" class="btn btn-outline-secondary">Geri</a>
</div>
@endsection
