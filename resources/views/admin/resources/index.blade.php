@extends('layouts.admin')
@section('title','Resources')

@push('styles')
<style>
  .thumb{width:70px;height:50px;object-fit:cover;border-radius:6px}
  .pill{padding:.25rem .5rem;border-radius:999px;background:rgba(13,110,253,.12);color:#0d6efd;font-weight:600;font-size:.85rem}
</style>
@endpush

@section('content')
  <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Resources</h1>
    <a class="btn btn-success" href="{{ route('admin.resources.create') }}"><i class="bi bi-plus-lg me-1"></i>Yeni</a>
  </div>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-5">
      <input type="search" name="q" value="{{ $q }}" class="form-control" placeholder="Ad, il, mime ilə axtar…">
    </div>
    <div class="col-md-4">
      <select name="type_id" class="form-select">
        <option value="0">Bütün tiplər</option>
        @foreach($types as $t)
          <option value="{{ $t->id }}" @selected($type_id==$t->id)>{{ $t->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
      <button class="btn btn-primary">Axtar</button>
      <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-secondary">Təmizlə</a>
    </div>
  </form>

  <div class="card">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead><tr>
          <th>#</th><th>Ad</th><th>Tip</th><th>İl</th><th>Preview</th><th class="text-end" style="width:220px">Əməliyyat</th>
        </tr></thead>
        <tbody>
        @forelse($resources as $r)
          <tr>
            <td>{{ $r->id }}</td>
            <td class="fw-semibold">{{ $r->name }}</td>
            <td><span class="pill">{{ $r->type?->name ?? '—' }}</span></td>
            <td>{{ $r->year ?: '—' }}</td>
            <td>
              <button class="btn btn-sm btn-outline-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#previewModal"
                      data-url="{{ $r->resourceUrl }}"
                      data-mime="{{ $r->mime ?? '' }}">
                Bax
              </button>
            </td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.resources.show',$r) }}">Gör</a>
              <a class="btn btn-sm btn-secondary" href="{{ route('admin.resources.edit',$r) }}">Redaktə</a>
              <a class="btn btn-sm btn-success" href="{{ $r->resourceUrl }}" target="_blank" download>Yüklə</a>
              <form action="{{ route('admin.resources.destroy',$r) }}" method="post" class="d-inline" onsubmit="return confirm('Silinsin?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Sil</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-4">Hələ resurs yoxdur.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    {{ $resources->links() }}
  </div>

  {{-- Preview Modal --}}
  <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Preview</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="previewWrap" class="ratio ratio-16x9 border rounded d-flex align-items-center justify-content-center">
            <span class="text-muted">Yüklənir…</span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
(function(){
  const modal = document.getElementById('previewModal');
  const wrap  = document.getElementById('previewWrap');

  modal.addEventListener('show.bs.modal', function (e) {
    const btn  = e.relatedTarget;
    const url  = btn.getAttribute('data-url');
    const mime = (btn.getAttribute('data-mime') || '').toLowerCase();

    wrap.innerHTML = '<span class="text-muted">Yüklənir…</span>';

    const ext = url.split('.').pop().toLowerCase();
    const isImg  = ['jpg','jpeg','png','gif','webp'].includes(ext) || mime.startsWith('image/');
    const isPdf  = ext === 'pdf' || mime === 'application/pdf';
    const isVid  = ['mp4','mov','webm','mkv','avi'].includes(ext) || mime.startsWith('video/');
    const isAudio= ['mp3','wav','ogg'].includes(ext) || mime.startsWith('audio/');

    if (isImg) {
      wrap.innerHTML = `<img src="${url}" alt="" style="width:100%;height:100%;object-fit:contain;border-radius:6px">`;
    } else if (isPdf) {
      wrap.innerHTML = `<iframe src="${url}" style="width:100%;height:100%;border:0;border-radius:6px"></iframe>`;
    } else if (isVid) {
      wrap.innerHTML = `<video src="${url}" controls style="width:100%;height:100%;border-radius:6px;object-fit:contain"></video>`;
    } else if (isAudio) {
      wrap.innerHTML = `<audio src="${url}" controls style="width:100%"></audio>`;
    } else {
      wrap.innerHTML = `<a class="btn btn-primary" href="${url}" download>Faylı yüklə</a>`;
    }
  });

  modal.addEventListener('hidden.bs.modal', () => wrap.innerHTML = '');
})();
</script>
@endpush
