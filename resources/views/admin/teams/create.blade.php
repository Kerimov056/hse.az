@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h1 class="h3 mb-3">Komanda — Yeni</h1>

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.teams.store') }}" enctype="multipart/form-data">
        @csrf

        @include('admin.teams._form', ['team' => null])

        <div class="mt-3 d-flex gap-2">
          <button class="btn btn-primary">Yarat</button>
          <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">Geri</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
