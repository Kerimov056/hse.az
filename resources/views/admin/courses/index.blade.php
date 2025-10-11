@extends('layouts.admin')
@section('title','Courses')

@section('content')
{{-- ===== Styles (yalnız bu səhifə üçün) ===== --}}
<style>
  /* ümumi */
  .page-actions{gap:.75rem}
  /* search input içində ikon */
  .search-wrap{position:relative}
  .search-wrap .bi-search{
    position:absolute; left:.75rem; top:50%; transform:translateY(-50%);
    pointer-events:none; opacity:.6
  }
  .search-wrap input{
    padding-left:2.3rem
  }

  /* thumbnail */
  .thumb{
    width:56px; height:40px; object-fit:cover; border-radius:.35rem
  }
  .thumb-lg{
    width:84px; height:56px; object-fit:cover; border-radius:.5rem
  }

  /* views badge */
  .views-badge{
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.25rem .5rem; border-radius:999px;
    background:rgba(13,110,253,.12); color:#0d6efd; font-weight:600; font-size:.85rem
  }
  .views-badge svg{width:16px;height:16px}

  /* name+desc truncation */
  .line-1{display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:1;overflow:hidden}
  .line-2{display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden}

  /* table header yapışqan (daha rahat scroll) */
  .table-sticky thead th{
    position: sticky; top: 0; z-index: 5; background: var(--bs-body-bg)
  }

  /* mobil görünüş: əməliyyatları dropdown-a salırıq */
  @media (max-width: 575.98px){
    .actions-wide{display:none !important;}
  }
  @media (min-width: 576px){
    .actions-compact{display:none !important;}
  }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-actions mb-3">
  <h1 class="mb-0 fw-semibold">Courses</h1>

  {{-- Search --}}
  <form action="{{ route('admin.courses.index') }}" method="GET" class="flex-grow-1" style="max-width:540px">
    <div class="input-group">
      <div class="search-wrap w-100">
        <i class="bi bi-search"></i>
        <input
          type="search"
          name="q"
          value="{{ $q ?? '' }}"
          class="form-control"
          placeholder="Ada və ya açıqlamaya görə axtar…"
          aria-label="Search courses"
        >
      </div>
      @if(!empty($q))
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Təmizlə</a>
      @endif
      <button class="btn btn-primary" type="submit">Axtar</button>
    </div>
  </form>

  <a class="btn btn-success" href="{{ route('admin.courses.create') }}">
    <i class="bi bi-plus-lg me-1"></i> Yeni Kurs
  </a>
</div>

@if(session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

{{-- Search info --}}
@if(!empty($q))
  <div class="alert alert-info py-2">
    Axtarış: <strong>{{ $q }}</strong> — <span class="text-muted">{{ $courses->total() }} nəticə</span>
  </div>
@endif

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table mb-0 align-middle table-hover table-sticky">
      <thead>
        <tr>
          <th style="width:70px">#</th>
          <th>Ad / Açıqlama</th>
          <th class="text-nowrap" style="width:140px">Views</th>
          <th class="d-none d-md-table-cell text-center" style="width:120px">Preview</th>
          <th class="text-end" style="width:210px">Əməliyyat</th>
        </tr>
      </thead>
      <tbody>
        @forelse($courses as $c)
          <tr>
            <td class="fw-semibold">{{ $c->id }}</td>

            {{-- Name + Desc + tiny thumb (mobil üçün daha səliqəli görünür) --}}
            <td>
              <div class="d-flex align-items-start gap-3">
                @if($c->imageUrl)
                  <img src="{{ $c->imageUrl }}" alt="" class="thumb d-none d-sm-block">
                @endif
                <div class="min-w-0">
                  <a href="{{ route('admin.courses.show',$c) }}" class="fw-semibold text-decoration-none d-block line-1">
                    {{ $c->name }}
                  </a>
                  @if(!empty($c->description))
                    <div class="small text-muted line-2">
                      {{ strip_tags($c->description) }}
                    </div>
                  @endif
                  {{-- External link (əgər varsa) --}}
                  @if($c->courseUrl)
                    <a href="{{ $c->courseUrl }}" target="_blank" rel="noopener" class="small text-decoration-none">
                      <i class="bi bi-box-arrow-up-right"></i> aç
                    </a>
                  @endif
                </div>
              </div>
            </td>

            <td>
              <span class="views-badge">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.4"/>
                </svg>
                {{ number_format($c->views) }}
              </span>
            </td>

            {{-- larger preview only md+ --}}
            <td class="d-none d-md-table-cell text-center">
              @if($c->imageUrl)
                <img src="{{ $c->imageUrl }}" alt="" class="thumb-lg">
              @endif
            </td>

            <td class="text-end">
              {{-- geniş ekran üçün düymələr --}}
              <div class="actions-wide btn-group" role="group" aria-label="Actions">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('course-details',$c) }}" target="_blank">
                  <i class="bi bi-eye"></i> Gör
                </a>
                <a class="btn btn-sm btn-secondary" href="{{ route('admin.courses.edit',$c) }}">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('admin.courses.destroy',$c) }}" method="post" class="d-inline"
                      onsubmit="return confirm('Silinsin?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Sil</button>
                </form>
              </div>

              {{-- mobil üçün kompakt dropdown --}}
              <div class="actions-compact dropdown">
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="{{ route('course-details',$c) }}" target="_blank">
                    <i class="bi bi-eye me-2"></i>Gör
                  </a></li>
                  <li><a class="dropdown-item" href="{{ route('admin.courses.edit',$c) }}">
                    <i class="bi bi-pencil me-2"></i>Edit
                  </a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="{{ route('admin.courses.destroy',$c) }}" method="post"
                          onsubmit="return confirm('Silinsin?')">
                      @csrf @method('DELETE')
                      <button class="dropdown-item text-danger">
                        <i class="bi bi-trash me-2"></i>Sil
                      </button>
                    </form>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted py-4">
              @if(!empty($q))
                “{{ $q }}” üzrə heç nə tapılmadı.
              @else
                Hələ kurs yoxdur.
              @endif
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">
  {{ $courses->links() }}
</div>
@endsection
