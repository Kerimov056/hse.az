@extends('layouts.admin')
@section('title','Resource Types')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Resource Types</h1>
  </div>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="card mb-3">
    <div class="card-body">
      <form action="{{ route('admin.resource-types.store') }}" method="post" class="row g-2">
        @csrf
        <div class="col-md-8">
          <input type="text" name="name" required class="form-control" placeholder="Yeni tip adı…">
        </div>
        <div class="col-md-4">
          <button class="btn btn-primary">Əlavə et</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead><tr><th>#</th><th>Ad</th><th class="text-end">Əməliyyat</th></tr></thead>
        <tbody>
        @forelse($types as $t)
          <tr>
            <td>{{ $t->id }}</td>
            <td><a href="{{ route('admin.resource-types.show', $t) }}">{{ $t->name }}</a></td>
            <td class="text-end">
              <form action="{{ route('admin.resource-types.destroy',$t) }}" method="post" onsubmit="return confirm('Silinsin?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Sil</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center text-muted py-4">Tip yoxdur.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
