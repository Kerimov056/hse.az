@extends('layouts.admin')
@section('title','Topics')

@section('content')
<style>
  .thumb{width:56px;height:40px;object-fit:cover;border-radius:.35rem}
  .thumb-lg{width:84px;height:56px;object-fit:cover;border-radius:.5rem}
  .views-badge{display:inline-flex;align-items:center;gap:.4rem;padding:.25rem .5rem;border-radius:999px;background:rgba(13,110,253,.12);color:#0d6efd;font-weight:600;font-size:.85rem}
  .line-1{display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:1;overflow:hidden}
  .line-2{display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden}
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
  <h1 class="mb-0 fw-semibold">Topics</h1>
  <form action="{{ route('admin.topices.index') }}" method="GET" class="flex-grow-1" style="max-width:540px">
    <div class="input-group">
      <input type="search" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Axtar…">
      @if(!empty($q)) <a href="{{ route('admin.topices.index') }}" class="btn btn-outline-secondary">Təmizlə</a> @endif
      <button class="btn btn-primary" type="submit">Axtar</button>
    </div>
  </form>
  <a class="btn btn-success" href="{{ route('admin.topices.create') }}"><i class="bi bi-plus-lg me-1"></i> Yeni Topic</a>
</div>

@if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table mb-0 align-middle table-hover">
      <thead>
        <tr>
          <th style="width:70px">#</th>
          <th>Ad / Açıqlama</th>
          <th style="width:140px">Views</th>
          <th class="d-none d-md-table-cell text-center" style="width:120px">Preview</th>
          <th class="text-end" style="width:210px">Əməliyyat</th>
        </tr>
      </thead>
      <tbody>
        @forelse($topics as $c)
          <tr>
            <td class="fw-semibold">{{ $c->id }}</td>
            <td>
              <div class="d-flex align-items-start gap-3">
                @if($c->imageUrl)<img src="{{ $c->imageUrl }}" class="thumb d-none d-sm-block">@endif
                <div class="min-w-0">
                  <a href="{{ route('admin.topices.show',$c) }}" class="fw-semibold text-decoration-none d-block line-1">{{ $c->name }}</a>
                  @if(!empty($c->description)) <div class="small text-muted line-2">{{ strip_tags($c->description) }}</div> @endif
                  @if($c->courseUrl)
                    <a href="{{ $c->courseUrl }}" target="_blank" rel="noopener" class="small text-decoration-none"><i class="bi bi-box-arrow-up-right"></i> aç</a>
                  @endif
                </div>
              </div>
            </td>
            <td><span class="views-badge">{{ number_format($c->views) }}</span></td>
            <td class="d-none d-md-table-cell text-center">@if($c->imageUrl)<img src="{{ $c->imageUrl }}" class="thumb-lg">@endif</td>
            <td class="text-end">
              <div class="btn-group">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('topices-details',$c) }}" target="_blank"><i class="bi bi-eye"></i> Gör</a>
                <a class="btn btn-sm btn-secondary" href="{{ route('admin.topices.edit',$c) }}"><i class="bi bi-pencil"></i> Edit</a>
                <form action="{{ route('admin.topices.destroy',$c) }}" method="post" onsubmit="return confirm('Silinsin?')" class="d-inline">@csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Sil</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-4">Hələ topic yoxdur.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $topics->links() }}</div>
@endsection
