@extends('layouts.admin')
@section('title', 'Courses')

@push('styles')
<style>
  .page-actions { gap: .75rem }
  .search-wrap { position: relative }
  .search-wrap .bi-search {
    position: absolute; left: .75rem; top: 50%;
    transform: translateY(-50%); pointer-events: none; opacity: .6
  }
  .search-wrap input { padding-left: 2.3rem }
  .thumb { width: 56px; height: 40px; object-fit: cover; border-radius: .35rem }
  .thumb-lg { width: 84px; height: 56px; object-fit: cover; border-radius: .5rem }

  .views-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .25rem .5rem; border-radius: 999px;
    background: rgba(13, 110, 253, .12); color: #0d6efd;
    font-weight: 600; font-size: .85rem
  }
  .views-badge svg { width: 16px; height: 16px }

  .line-1 { -webkit-line-clamp: 1 }
  .line-2 { -webkit-line-clamp: 2 }
  .line-1, .line-2 { display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden }

  .table-sticky thead th {
    position: sticky; top: 0; z-index: 5;
    background: #ffffff; border-bottom: 1px solid #e5e7eb
  }

  .table {
    --bs-table-bg: #fff;
    --bs-table-striped-bg: #f8fafc;
    --bs-table-hover-bg: #f1f5f9;
    color: #0f172a
  }

  .meta-mini { font-size: .85rem; color: #64748b; display:flex; flex-wrap:wrap; gap:.5rem; margin-top:.25rem }
  .meta-chip { background:#f1f5f9; border:1px solid #e5e7eb; padding:.15rem .45rem; border-radius:999px; color:#0f172a }
  .topic-chip { background:#eef2ff; border:1px solid #e0e7ff; padding:.15rem .45rem; border-radius:999px; color:#3730a3; font-size:.82rem }

  .holding-bar { display:flex; flex-wrap:wrap; gap:.5rem; }
  .holding-pill{
    display:inline-flex; align-items:center;
    padding:.25rem .6rem; border-radius:999px;
    border:1px solid #e5e7eb; background:#fff;
    text-decoration:none; color:#0f172a;
    font-weight:600; font-size:.85rem;
  }
  .holding-pill.active{
    background: rgba(13,110,253,.10);
    border-color: rgba(13,110,253,.35);
    color:#0d6efd;
  }

  @media (max-width:575.98px) { .actions-wide { display: none !important } }
  @media (min-width:576px) { .actions-compact { display: none !important } }
</style>
@endpush

@section('content')
@php
  // search / holding param-larini həmişə request-dən götür
  $q = $q ?? request('q');
  $activeHolding = request('holding', '');

  // ✅ HOLDING MAP: bu səhifədə olan $courses kolleksiyasından unikal holding-lər
  // Eyni holdingName-lər birləşsin və count çıxsın
  $holdings = $courses->getCollection()
    ->map(function($c) {
      $name = trim((string) ($c->courseHoldingName ?? ''));
      return $name === '' ? null : $name;
    })
    ->filter()
    ->countBy()
    ->sortKeys()
    ->map(function($count, $name){
      return ['name' => $name, 'count' => $count];
    })
    ->values()
    ->all();
@endphp

<div class="container-fluid py-3">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center page-actions mb-3">
    <div class="d-flex align-items-center gap-2">
      <h1 class="mb-0 fw-semibold">Courses</h1>
      @if ($courses->total())
        <span class="badge text-bg-success">{{ $courses->total() }}</span>
      @endif
    </div>

    <form action="{{ route('admin.courses.index') }}" method="GET" class="flex-grow-1" style="max-width:540px">
      <input type="hidden" name="holding" value="{{ $activeHolding }}">
      <div class="input-group">
        <div class="search-wrap w-100">
          <i class="bi bi-search"></i>
          <input type="search" name="q" value="{{ $q ?? '' }}" class="form-control"
                 placeholder="Ada, instructor-a, müddətə görə axtar…" aria-label="Search courses">
        </div>

        @if (!empty($q) || !empty($activeHolding))
          <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary" title="Təmizlə">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif

        <button class="btn btn-primary" type="submit">Axtar</button>
      </div>
    </form>

    <a class="btn btn-success" href="{{ route('admin.courses.create') }}">
      <i class="bi bi-plus-lg me-1"></i> Yeni Kurs
    </a>
  </div>

  @if (session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  {{-- ✅ Holding filter bar (bu səhifədə olan course-lara görə map olunur) --}}
  @if(count($holdings))
    <div class="card shadow-sm mb-3">
      <div class="card-body py-2">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
          <div class="small text-muted">Holding filter</div>
          @if(!empty($activeHolding))
            <a class="small text-decoration-none"
               href="{{ route('admin.courses.index', array_filter(['q'=>$q])) }}">
              Filteri sıfırla
            </a>
          @endif
        </div>

        <div class="holding-bar mt-2">
          <a class="holding-pill {{ empty($activeHolding) ? 'active' : '' }}"
             href="{{ route('admin.courses.index', array_filter(['q'=>$q])) }}">
            Hamısı
          </a>

          @foreach($holdings as $h)
            @php
              $hName = $h['name'] ?? '';
              $hCount = $h['count'] ?? null;
            @endphp

            @continue(empty($hName))

            <a class="holding-pill {{ $activeHolding === $hName ? 'active' : '' }}"
               href="{{ route('admin.courses.index', array_filter(['q'=>$q, 'holding'=>$hName])) }}">
              {{ $hName }}
              @if($hCount !== null)
                <span class="ms-1 text-muted">({{ $hCount }})</span>
              @endif
            </a>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  @if (!empty($q) || !empty($activeHolding))
    <div class="alert alert-info py-2">
      @if(!empty($q)) Axtarış: <strong>{{ $q }}</strong> @endif
      @if(!empty($activeHolding))
        <span class="ms-2">Holding: <strong>{{ $activeHolding }}</strong></span>
      @endif
      <span class="text-muted ms-2">{{ $courses->total() }} nəticə</span>
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
              <td>
                <div class="d-flex align-items-start gap-3">
                  @if ($c->imageUrl)
                    <img src="{{ $c->imageUrl }}" alt="" class="thumb d-none d-sm-block">
                  @endif

                  <div class="min-w-0 w-100">
                    <a href="{{ route('admin.courses.show', $c) }}"
                       class="fw-semibold text-decoration-none d-block line-1">{{ $c->name }}</a>

                    @if (!empty($c->description))
                      <div class="small text-muted line-2">{{ strip_tags($c->description) }}</div>
                    @endif

                    <div class="meta-mini">
                      @if($c->courseHoldingName)
                        <span class="meta-chip">Holding: {{ $c->courseHoldingName }}</span>
                      @endif
                      @if($c->duration) <span class="meta-chip">Müddət: {{ $c->duration }}</span> @endif
                      @if($c->instructor) <span class="meta-chip">Instructor: {{ $c->instructor }}</span> @endif
                      @if($c->price !== null) <span class="meta-chip">Qiymət: {{ number_format($c->price, 2) }} AZN</span> @endif
                      @if ($c->courseUrl)
                        <a href="{{ $c->courseUrl }}" target="_blank" rel="noopener" class="small text-decoration-none">
                          <i class="bi bi-box-arrow-up-right"></i> aç
                        </a>
                      @endif
                    </div>

                    @if($c->relationLoaded('courseTopics') && $c->courseTopics->count())
                      <div class="mt-2 d-flex flex-wrap gap-2">
                        @foreach($c->courseTopics->take(6) as $t)
                          <span class="topic-chip">{{ $t->title }}</span>
                        @endforeach
                        @if($c->courseTopics->count() > 6)
                          <span class="topic-chip">+{{ $c->courseTopics->count() - 6 }}</span>
                        @endif
                      </div>
                    @endif
                  </div>
                </div>
              </td>

              <td>
                <span class="views-badge">
                  <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"
                          stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.4" />
                  </svg>
                  {{ number_format($c->views) }}
                </span>
              </td>

              <td class="d-none d-md-table-cell text-center">
                @if ($c->imageUrl)
                  <img src="{{ $c->imageUrl }}" alt="" class="thumb-lg">
                @endif
              </td>

              <td class="text-end">
                <div class="actions-wide btn-group" role="group" aria-label="Actions">
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('course-details', $c) }}" target="_blank">
                    <i class="bi bi-eye"></i> Gör
                  </a>
                  <a class="btn btn-sm btn-secondary" href="{{ route('admin.courses.edit', $c) }}">
                    <i class="bi bi-pencil"></i> Edit
                  </a>
                  <form action="{{ route('admin.courses.destroy', $c) }}" method="post" class="d-inline"
                        onsubmit="return confirm('Silinsin?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Sil</button>
                  </form>
                </div>

                <div class="actions-compact dropdown">
                  <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('course-details', $c) }}" target="_blank"><i class="bi bi-eye me-2"></i>Gör</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.courses.edit', $c) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <form action="{{ route('admin.courses.destroy', $c) }}" method="post" onsubmit="return confirm('Silinsin?')">
                        @csrf @method('DELETE')
                        <button class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Sil</button>
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">
                @if (!empty($q) || !empty($activeHolding))
                  Heç nə tapılmadı.
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

  <div class="d-flex justify-content-between align-items-center mt-3">
    <div class="small text-muted">Səhifə: {{ $courses->currentPage() }} / {{ $courses->lastPage() }}</div>
    <div>{{ $courses->appends(['q' => $q, 'holding' => $activeHolding])->links() }}</div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('keydown', (e) => {
    if (e.key.toLowerCase() === 'n' && !e.target.matches('input,textarea')) {
      window.location.href = @json(route('admin.courses.create'));
    }
  });
</script>
@endpush
@endsection
