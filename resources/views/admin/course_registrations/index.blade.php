@extends('layouts.admin')

@section('title', 'Course Registrations')

@push('styles')
<style>
  .table thead th { position: sticky; top: 0; background: #0f172a; z-index: 1; }
  .empty-state { border: 1px dashed rgba(148,163,184,.35); border-radius: .75rem; padding: 2rem; text-align: center; }
  .kbd { border: 1px solid rgba(148,163,184,.3); border-bottom-width: 2px; padding: .15rem .35rem; border-radius: .35rem; font-size: .8rem; }
  .pill { display:inline-flex; align-items:center; gap:.4rem; border:1px solid rgba(148,163,184,.25); padding:.25rem .55rem; border-radius:999px; font-size:.82rem; }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
  <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-2">
      <h1 class="h3 m-0">Course Registrations</h1>
      @if($items->total())
        <span class="badge text-bg-success">{{ $items->total() }}</span>
      @endif
    </div>
  </div>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
        <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="Ad, email, telefon, ID… üzrə axtar">
        @if(!empty($q) || !empty($courseId))
          <a href="{{ route('admin.course-registrations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </div>

    <div class="col-md-4">
      <select class="form-select" name="course_id">
        <option value="">Bütün kurslar</option>
        @foreach($courses as $c)
          <option value="{{ $c->id }}" @selected((string)$courseId === (string)$c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-2">
      <button class="btn btn-outline-light w-100" style="border:1px solid #0f172a;color:#0f172a">
        <i class="bi bi-funnel me-1"></i> Axtar
      </button>
    </div>
  </form>

  @if($items->count())
    <div class="card">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th style="width:56px" class="text-muted">#</th>
              <th>İştirakçı</th>
              <th style="width:220px">Kurs</th>
              <th style="width:220px">Email</th>
              <th style="width:170px">Mobil</th>
              <th style="width:180px">Yaradıldı</th>
              <th style="width:140px" class="text-end">Əməliyyat</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $i => $it)
              @php
                $full = trim(($it->first_name ?? '').' '.($it->surname ?? ''));
              @endphp
              <tr>
                <td class="text-muted">{{ $items->firstItem() + $i }}</td>

                <td>
                  <div class="fw-semibold">{{ $full ?: '—' }}</div>
                  <div class="small text-muted">
                    ID: {{ $it->id_card_number ?? '—' }}
                    @if($it->gender) • {{ ucfirst($it->gender) }} @endif
                    @if($it->birth_date) • {{ optional($it->birth_date)->format('d.m.Y') }} @endif
                  </div>
                </td>

                <td>
                  <div class="fw-semibold">{{ $it->course?->name ?? '—' }}</div>
                  <div class="small text-muted">{{ $it->requested_product_service }}</div>
                </td>

                <td>
                  <div class="pill"><i class="bi bi-envelope"></i> {{ $it->business_email }}</div>
                </td>

                <td>
                  <div class="pill"><i class="bi bi-telephone"></i> {{ $it->mobile_phone }}</div>
                </td>

                <td>
                  <div class="small text-muted">{{ optional($it->created_at)->diffForHumans() }}</div>
                  <div>{{ optional($it->created_at)->format('d.m.Y H:i') }}</div>
                </td>

                <td class="text-end">
                  <div class="btn-group">
                    <a href="{{ route('admin.course-registrations.show', $it) }}"
                       class="btn btn-sm btn-outline-secondary" title="Bax">
                      <i class="bi bi-eye"></i>
                    </a>

                    <form action="{{ route('admin.course-registrations.destroy', $it) }}"
                          method="POST" onsubmit="return confirm('Silmək istəyirsiniz?')">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" title="Sil">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <div class="small text-muted">Səhifə: {{ $items->currentPage() }} / {{ $items->lastPage() }}</div>
      <div>{{ $items->links() }}</div>
    </div>
  @else
    <div class="empty-state">
      <div class="fs-5 mb-2"><i class="bi bi-inboxes me-2"></i>Məlumat yoxdur</div>
      <div class="text-muted mb-3">Hələ qeydiyyat gəlməyib.</div>
      <div class="mt-3 small text-muted">Qısa yol: <span class="kbd">/</span> — axtarışa fokus</div>
    </div>
  @endif
</div>

@push('scripts')
<script>
  // "/" -> search focus
  document.addEventListener('keydown', (e) => {
    if (e.key === '/' && !e.target.matches('input, textarea, select')) {
      e.preventDefault();
      const inp = document.querySelector('input[name="q"]');
      if (inp) inp.focus();
    }
  });
</script>
@endpush
@endsection
