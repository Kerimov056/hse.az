@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h1 class="h3 mb-3">Komanda — Redaktə</h1>

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.teams.update', $team) }}" enctype="multipart/form-data" id="teamEditForm">
        @method('PUT')
        @include('admin.teams._form', ['team' => $team])
      </form>
    </div>

    {{-- Footer: Geri və Yadda saxla --}}
    <div class="card-footer d-flex justify-content-between align-items-center">
      <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">
        ← Geri
      </a>
      <div class="d-flex gap-2">
        <button type="submit" form="teamEditForm" class="btn btn-primary">
          Yadda saxla
        </button>
      </div>
    </div>
  </div>
</div>
@endsection
