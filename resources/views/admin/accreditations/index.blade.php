@extends('layouts.admin')

@section('title', 'Accreditations')

@push('styles')
    <style>
        .table thead th {
            position: sticky;
            top: 0;
            background: #0f172a;
            z-index: 1;
        }

        .thumb {
            width: 110px;
            height: 64px;
            object-fit: cover;
            border-radius: .5rem;
            border: 1px solid rgba(148, 163, 184, .25)
        }

        .empty-state {
            border: 1px dashed rgba(148, 163, 184, .35);
            border-radius: .75rem;
            padding: 2rem;
            text-align: center;
        }

        .kbd {
            border: 1px solid rgba(148, 163, 184, .3);
            border-bottom-width: 2px;
            padding: .15rem .35rem;
            border-radius: .35rem;
            font-size: .8rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <h1 class="h3 m-0">Accreditations</h1>
                @if ($items->total())
                    <span class="badge text-bg-success">{{ $items->total() }}</span>
                @endif
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.accreditations.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Yeni əlavə et
                </a>
            </div>
        </div>

        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control" name="q" value="{{ $q }}"
                        placeholder="Açıqlama üzrə axtar…">
                    @if (!empty($q))
                        <a href="{{ route('admin.accreditations.index') }}" class="btn btn-outline-secondary"><i
                                class="bi bi-x-lg"></i></a>
                    @endif
                </div>
            </div>
            <div style="border: 1px solid #0f172a" class="col-md-2">
                <button style="color: #0f172a" class="btn btn-outline-light w-100"><i class="bi bi-funnel me-1"></i> Axtar</button>
            </div>
        </form>

        @if ($items->count())
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:56px" class="text-muted">#</th>
                                <th style="width:140px">Şəkil</th>
                                <th>Açıqlama</th>
                                <th style="width:180px">Yaradıldı</th>
                                <th style="width:120px" class="text-end">Əməliyyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $i => $it)
                                <tr>
                                    <td class="text-muted">{{ $items->firstItem() + $i }}</td>
                                    <td>
                                        @if ($it->imageUrl)
                                            <img src="{{ $it->imageUrl }}" alt="" class="thumb">
                                        @else
                                            <div class="d-inline-flex align-items-center gap-2 text-muted">
                                                <i class="bi bi-image"></i> —
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @php($plain = strip_tags($it->description ?? ''))
                                        <div class="fw-semibold mb-1">{!! \Illuminate\Support\Str::limit($plain, 120) !!}</div>
                                        @if (strlen($plain) > 120)
                                            <a href="{{ route('admin.accreditations.show', $it) }}"
                                                class="link-light link-underline-opacity-25 link-underline-opacity-100-hover small">davamını
                                                oxu</a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small text-muted">{{ optional($it->created_at)->diffForHumans() }}</div>
                                        <div>{{ optional($it->created_at)->format('d.m.Y H:i') }}</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.accreditations.edit', $it) }}"
                                                class="btn btn-sm btn-outline-primary" title="Redaktə">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.accreditations.show', $it) }}"
                                                class="btn btn-sm btn-outline-secondary" title="Bax">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.accreditations.destroy', $it) }}" method="POST"
                                                onsubmit="return confirm('Silmək istəyirsiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Sil"><i
                                                        class="bi bi-trash"></i></button>
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
                <div>
                    {{ $items->appends(['q' => $q])->links() }}
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="fs-5 mb-2"><i class="bi bi-inboxes me-2"></i>Məlumat yoxdur</div>
                <div class="text-muted mb-3">Yeni akkreditasiya əlavə etməklə başlayın.</div>
                <a href="{{ route('admin.accreditations.create') }}" class="btn btn-success"><i
                        class="bi bi-plus-lg me-1"></i> Yeni əlavə et</a>
                <div class="mt-3 small text-muted">Qısa yol: <span class="kbd">N</span> — yeni yarat</div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            // Klaviatura qısayolu: N -> create
            document.addEventListener('keydown', (e) => {
                if (e.key.toLowerCase() === 'n' && !e.target.matches('input, textarea')) {
                    window.location.href = @json(route('admin.accreditations.create'));
                }
            });
        </script>
    @endpush
@endsection
