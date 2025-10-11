@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Accreditations</h1>
    <a href="{{ route('admin.accreditations.create') }}" class="btn btn-primary">Yeni əlavə et</a>
  </div>

  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-6">
      <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="Açıqlama üzrə axtar…">
    </div>
    <div class="col-md-2">
      <button class="btn btn-outline-secondary w-100">Axtar</button>
    </div>
  </form>

  @if($items->count())
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Şəkil</th>
            <th>Açıqlama</th>
            <th>Yaradıldı</th>
            <th class="text-end">Əməliyyat</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items as $i => $it)
            <tr>
              <td>{{ $items->firstItem() + $i }}</td>
              <td style="width:120px">
                @if($it->imageUrl)
                  <img src="{{ $it->imageUrl }}" alt="" style="width:100px;height:60px;object-fit:cover;border-radius:6px">
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td>{!! \Illuminate\Support\Str::limit(strip_tags($it->description ?? ''), 120) !!}</td>
              <td>{{ optional($it->created_at)->format('d.m.Y H:i') }}</td>
              <td class="text-end">
                <a href="{{ route('admin.accreditations.edit', $it) }}" class="btn btn-sm btn-outline-primary">Redaktə</a>
                <a href="{{ route('admin.accreditations.show', $it) }}" class="btn btn-sm btn-outline-secondary">Bax</a>
                <form action="{{ route('admin.accreditations.destroy', $it) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Silmək istəyirsiniz?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Sil</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $items->links() }}
    </div>
  @else
    <div class="text-muted">Məlumat yoxdur.</div>
  @endif
</div>
@endsection
