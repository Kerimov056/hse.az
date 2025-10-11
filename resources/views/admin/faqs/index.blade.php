@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">FAQ-lar</h1>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">Yeni əlavə et</a>
  </div>

  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-6">
      <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="Sual və ya cavab üzrə axtar…">
    </div>
    <div class="col-md-2">
      <button class="btn btn-outline-secondary w-100">Axtar</button>
    </div>
  </form>

  @if($faqs->count())
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Sual</th>
            <th>Status</th>
            <th>Yaradıldı</th>
            <th class="text-end">Əməliyyat</th>
          </tr>
        </thead>
        <tbody>
          @foreach($faqs as $i => $f)
            <tr>
              <td>{{ $faqs->firstItem() + $i }}</td>
              <td>{{ $f->question }}</td>
              <td>
                @if($f->is_active)
                  <span class="badge bg-success">Aktiv</span>
                @else
                  <span class="badge bg-secondary">Passiv</span>
                @endif
              </td>
              <td>{{ optional($f->created_at)->format('d.m.Y H:i') }}</td>
              <td class="text-end">
                <a href="{{ route('admin.faqs.show', $f) }}" class="btn btn-sm btn-outline-secondary">Bax</a>
                <a href="{{ route('admin.faqs.edit', $f) }}" class="btn btn-sm btn-outline-primary">Redaktə</a>
                <form action="{{ route('admin.faqs.destroy', $f) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Silmək istəyirsiniz?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Sil</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $faqs->links() }}
    </div>
  @else
    <div class="text-muted">Məlumat yoxdur.</div>
  @endif
</div>
@endsection
