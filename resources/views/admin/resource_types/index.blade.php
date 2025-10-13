@extends('layouts.admin')
@section('title', 'Resource Types')

@push('styles')
    <style>
        /* Light table look + sticky head */
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

        /* Input with icon */
        .with-icon {
            position: relative
        }

        .with-icon .bi-tag {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: .6;
            pointer-events: none
        }

        .with-icon input {
            padding-left: 2.3rem
        }

        /* Empty state */
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
            <h1 class="mb-0">Resource Types</h1>
            @if ($types->count())
                <span class="badge text-bg-success">{{ $types->count() }}</span>
            @endif
        </div>
    </div>

    @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.resource-types.store') }}" method="post" class="row g-2 align-items-center">
                @csrf
                <div class="col-md-9">
                    <div class="with-icon">
                        <i class="bi bi-tag"></i>
                        <input type="text" name="name" required class="form-control" placeholder="Yeni tip adı…"
                            value="{{ old('name') }}" autofocus>
                    </div>
                </div>
                <div class="col-md-3 d-grid d-md-block">
                    <button class="btn btn-primary w-100 w-md-auto"><i class="bi bi-plus-lg me-1"></i> Əlavə et</button>
                </div>
            </form>
            <div class="small text-muted mt-2">Qısa yol: <kbd>N</kbd> — fokus adı daxil etməyə</div>
        </div>
    </div>

    @if ($types->count())
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover table-sticky">
                    <thead>
                        <tr>
                            <th style="width:90px">#</th>
                            <th>Ad</th>
                            <th style="width:140px" class="text-end">Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $t)
                            <tr>
                                <td class="fw-semibold">{{ $t->id }}</td>
                                <td>
                                    <a href="{{ route('admin.resource-types.show', $t) }}"
                                        class="text-decoration-none">{{ $t->name }}</a>
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.resource-types.destroy', $t) }}" method="post"
                                        class="d-inline" onsubmit="return confirm('Silinsin?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Sil"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="fs-5 mb-2"><i class="bi bi-inboxes me-2"></i>Tip yoxdur</div>
            <div class="text-muted">Yuxarıdakı formdan yeni tip əlavə edin.</div>
        </div>
    @endif

    @push('scripts')
        <script>
            // Qısayol: N -> fokus input
            document.addEventListener('keydown', (e) => {
                if (e.key.toLowerCase() === 'n' && !e.target.matches('input,textarea')) {
                    const el = document.querySelector('input[name="name"]');
                    if (el) {
                        el.focus();
                        el.select();
                    }
                }
            });
        </script>
    @endpush
@endsection
