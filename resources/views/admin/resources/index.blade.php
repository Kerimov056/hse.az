@extends('layouts.admin')
@section('title', 'Resources')

@push('styles')
    <style>
        /* Light content look */
        .thumb {
            width: 72px;
            height: 52px;
            object-fit: cover;
            border-radius: .5rem
        }

        .pill {
            padding: .25rem .5rem;
            border-radius: 999px;
            background: rgba(13, 110, 253, .12);
            color: #0d6efd;
            font-weight: 600;
            font-size: .85rem
        }

        /* search + filters */
        .search-wrap {
            position: relative
        }

        .search-wrap .bi-search {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: .6;
            pointer-events: none
        }

        .search-wrap input {
            padding-left: 2.3rem
        }

        /* sticky white table head */
        .table-sticky thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb
        }

        .table {
            --bs-table-bg: #fff;
            --bs-table-striped-bg: #f8fafc;
            --bs-table-hover-bg: #f1f5f9;
            color: #0f172a
        }

        /* empty state */
        .empty-state {
            border: 1px dashed #d1d5db;
            border-radius: .75rem;
            padding: 2rem;
            text-align: center
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <h1 class="mb-0">Resources</h1>
            @if ($resources->total())
                <span class="badge text-bg-success">{{ $resources->total() }}</span>
            @endif
        </div>
        <a class="btn btn-success" href="{{ route('admin.resources.create') }}"><i class="bi bi-plus-lg me-1"></i>Yeni</a>
    </div>

    @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-5">
            <div class="input-group">
                <div class="search-wrap w-100">
                    <i class="bi bi-search"></i>
                    <input type="search" name="q" value="{{ $q }}" class="form-control"
                        placeholder="Ad, il, MIME ilə axtar…">
                </div>
                @if (!empty($q) || !empty($type_id))
                    <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-secondary" title="Təmizlə"><i
                            class="bi bi-x-lg"></i></a>
                @endif
                <button class="btn btn-primary">Axtar</button>
            </div>
        </div>
        <div class="col-md-4">
            <select name="type_id" class="form-select">
                <option value="0">Bütün tiplər</option>
                @foreach ($types as $t)
                    <option value="{{ $t->id }}" @selected($type_id == $t->id)>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-center">
            <div class="ms-md-auto small text-muted">Səhifə: {{ $resources->currentPage() }} / {{ $resources->lastPage() }}
            </div>
        </div>
    </form>

    @if ($resources->count())
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover table-sticky">
                    <thead>
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Ad</th>
                            <th style="width:180px">Tip</th>
                            <th style="width:100px">İl</th>
                            <th style="width:120px" class="text-center">Preview</th>
                            <th style="width:240px" class="text-end">Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resources as $r)
                            <tr>
                                <td class="fw-semibold">{{ $r->id }}</td>
                                <td>
                                    <div class="d-flex align-items-start gap-3">
                                        @if ($r->thumbUrl ?? null)
                                            <img src="{{ $r->thumbUrl }}" alt="" class="thumb d-none d-sm-block">
                                        @endif
                                        <div class="min-w-0">
                                            <div class="fw-semibold text-truncate">{{ $r->name }}</div>
                                            @if (!empty($r->mime))
                                                <div class="small text-muted text-truncate">{{ $r->mime }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="pill">{{ $r->type?->name ?? '—' }}</span>
                                </td>
                                <td>{{ $r->year ?: '—' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#previewModal" data-url="{{ $r->resourceUrl }}"
                                        data-mime="{{ $r->mime ?? '' }}">
                                        Bax
                                    </button>
                                </td>
                                <td class="text-end">
                                    <div class="d-none d-sm-inline-flex btn-group" role="group">
                                        <a class="btn btn-sm btn-outline-secondary"
                                            href="{{ route('admin.resources.show', $r) }}" title="Gör"><i
                                                class="bi bi-eye"></i></a>
                                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.resources.edit', $r) }}"
                                            title="Redaktə"><i class="bi bi-pencil"></i></a>
                                        <a class="btn btn-sm btn-success" href="{{ $r->resourceUrl }}" target="_blank"
                                            download title="Yüklə"><i class="bi bi-download"></i></a>
                                        <form action="{{ route('admin.resources.destroy', $r) }}" method="post"
                                            onsubmit="return confirm('Silinsin?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Sil"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>

                                    <div class="dropdown d-inline d-sm-none">
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown"><i
                                                class="bi bi-three-dots-vertical"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.resources.show', $r) }}"><i
                                                        class="bi bi-eye me-2"></i>Gör</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.resources.edit', $r) }}"><i
                                                        class="bi bi-pencil me-2"></i>Redaktə</a></li>
                                            <li><a class="dropdown-item" href="{{ $r->resourceUrl }}" target="_blank"
                                                    download><i class="bi bi-download me-2"></i>Yüklə</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.resources.destroy', $r) }}" method="post"
                                                    onsubmit="return confirm('Silinsin?')">
                                                    @csrf @method('DELETE')
                                                    <button class="dropdown-item text-danger"><i
                                                            class="bi bi-trash me-2"></i>Sil</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted">Səhifə: {{ $resources->currentPage() }} / {{ $resources->lastPage() }}</div>
            <div>{{ $resources->appends(['q' => $q, 'type_id' => $type_id])->links() }}</div>
        </div>
    @else
        <div class="empty-state">
            <div class="fs-5 mb-2"><i class="bi bi-inboxes me-2"></i>Hələ resurs yoxdur</div>
            <a class="btn btn-success" href="{{ route('admin.resources.create') }}"><i
                    class="bi bi-plus-lg me-1"></i>Yeni</a>
        </div>
    @endif

    {{-- Preview Modal --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="previewWrap"
                        class="ratio ratio-16x9 border rounded d-flex align-items-center justify-content-center">
                        <span class="text-muted">Yüklənir…</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const modal = document.getElementById('previewModal');
            const wrap = document.getElementById('previewWrap');

            modal.addEventListener('show.bs.modal', function(e) {
                const btn = e.relatedTarget;
                const url = btn.getAttribute('data-url');
                const mime = (btn.getAttribute('data-mime') || '').toLowerCase();

                wrap.innerHTML = '<span class="text-muted">Yüklənir…</span>';

                const ext = (url.split('.').pop() || '').toLowerCase();
                const isImg = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext) || mime.startsWith('image/');
                const isPdf = ext === 'pdf' || mime === 'application/pdf';
                const isVid = ['mp4', 'mov', 'webm', 'mkv', 'avi'].includes(ext) || mime.startsWith('video/');
                const isAudio = ['mp3', 'wav', 'ogg'].includes(ext) || mime.startsWith('audio/');

                if (isImg) {
                    wrap.innerHTML =
                        `<img src="${url}" alt="" style="width:100%;height:100%;object-fit:contain;border-radius:6px">`;
                } else if (isPdf) {
                    wrap.innerHTML =
                        `<iframe src="${url}" style="width:100%;height:100%;border:0;border-radius:6px"></iframe>`;
                } else if (isVid) {
                    wrap.innerHTML =
                        `<video src="${url}" controls style="width:100%;height:100%;border-radius:6px;object-fit:contain"></video>`;
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
