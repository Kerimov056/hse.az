@extends('layouts.admin')
@section('title', 'FAQ-lar')

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

        /* search input icon */
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

        /* status pills */
        .pill {
            padding: .2rem .6rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: .85rem;
            white-space: nowrap
        }

        .pill-green {
            background: rgba(34, 197, 94, .16);
            color: #16a34a
        }

        .pill-gray {
            background: rgba(107, 114, 128, .18);
            color: #374151
        }

        /* mobile actions */
        @media (max-width:575.98px) {
            .actions-wide {
                display: none !important
            }
        }

        @media (min-width:576px) {
            .actions-compact {
                display: none !important
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <h1 class="h3 m-0">FAQ-lar</h1>
                @if ($faqs->total())
                    <span class="badge text-bg-success">{{ $faqs->total() }}</span>
                @endif
            </div>
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Yeni əlavə
                et</a>
        </div>

        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="search-wrap w-100">
                        <i class="bi bi-search"></i>
                        <input type="search" class="form-control" name="q" value="{{ $q }}"
                            placeholder="Sual və ya cavab üzrə axtar…">
                    </div>
                    @if (!empty($q))
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary" title="Təmizlə"><i
                                class="bi bi-x-lg"></i></a>
                    @endif
                    <button class="btn btn-primary">Axtar</button>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <div class="ms-md-auto small text-muted">Səhifə: {{ $faqs->currentPage() }} / {{ $faqs->lastPage() }}</div>
            </div>
        </form>

        @if ($faqs->count())
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover table-sticky">
                        <thead>
                            <tr>
                                <th style="width:70px">#</th>
                                <th>Sual</th>
                                <th style="width:140px">Status</th>
                                <th style="width:180px">Yaradıldı</th>
                                <th class="text-end" style="width:210px">Əməliyyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $i => $f)
                                <tr>
                                    <td class="text-muted">{{ $faqs->firstItem() + $i }}</td>
                                    <td class="fw-semibold text-truncate">{{ $f->question }}</td>
                                    <td>
                                        @if ($f->is_active)
                                            <span class="pill pill-green">Aktiv</span>
                                        @else
                                            <span class="pill pill-gray">Passiv</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small text-muted">{{ optional($f->created_at)->diffForHumans() }}</div>
                                        <div>{{ optional($f->created_at)->format('d.m.Y H:i') }}</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="actions-wide btn-group" role="group">
                                            <a href="{{ route('admin.faqs.show', $f) }}"
                                                class="btn btn-sm btn-outline-secondary" title="Bax"><i
                                                    class="bi bi-eye"></i></a>
                                            <a href="{{ route('admin.faqs.edit', $f) }}"
                                                class="btn btn-sm btn-outline-primary" title="Redaktə"><i
                                                    class="bi bi-pencil"></i></a>
                                            <form action="{{ route('admin.faqs.destroy', $f) }}" method="POST"
                                                onsubmit="return confirm('Silmək istəyirsiniz?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Sil"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                        <div class="actions-compact dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown"><i
                                                    class="bi bi-three-dots-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ route('admin.faqs.show', $f) }}"><i
                                                            class="bi bi-eye me-2"></i>Bax</a></li>
                                                <li><a class="dropdown-item" href="{{ route('admin.faqs.edit', $f) }}"><i
                                                            class="bi bi-pencil me-2"></i>Redaktə</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.faqs.destroy', $f) }}" method="POST"
                                                        onsubmit="return confirm('Silmək istəyirsiniz?')">
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
                <div class="small text-muted">Toplam: {{ $faqs->total() }}</div>
                <div>{{ $faqs->appends(['q' => $q])->links() }}</div>
            </div>
        @else
            <div class="border rounded p-4 text-center text-muted">Məlumat yoxdur.</div>
        @endif
    </div>
@endsection
