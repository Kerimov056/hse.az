@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h1 class="h3 mb-3">Accreditation — Yeni</h1>

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.accreditations.store') }}" enctype="multipart/form-data">
        @include('admin.accreditations._form', ['item' => $item])
      </form>
    </div>
  </div>
</div>
@endsection
