@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h1 class="h3 mb-3">FAQ — Yeni</h1>

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.faqs.store') }}">
        @include('admin.faqs._form', ['faq' => $faq])
      </form>
    </div>
  </div>
</div>
@endsection
