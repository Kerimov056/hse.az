@extends('layouts.admin')

@section('title', 'Hero Buttons')

@section('content')
<div class="container-fluid py-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Hero Buttons</h1>
    <a href="{{ route('admin.hero-buttons.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> Yeni əlavə et</a>
  </div>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <div class="card">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Text</th>
            <th>URL</th>
            <th>Order</th>
            <th class="text-end">Əməliyyat</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $i => $it)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $it->text }}</td>
              <td><a href="{{ $it->url }}" target="_blank">{{ $it->url }}</a></td>
              <td>{{ $it->order }}</td>
              <td class="text-end">
                <a href="{{ route('admin.hero-buttons.edit', $it) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.hero-buttons.destroy', $it) }}" method="POST" style="display:inline" onsubmit="return confirm('Silmək istəyirsiniz?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted py-3">Heç bir button yoxdur.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
