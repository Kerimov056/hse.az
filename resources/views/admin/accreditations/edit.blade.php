@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h1 class="h3 mb-3">Accreditation — Redaktə et</h1>

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.accreditations.update', $item) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.accreditations._form', ['item' => $item])
      </form>
    </div>
  </div>
</div>
@endsection
