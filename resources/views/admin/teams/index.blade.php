@extends('layouts.admin')
@section('title', 'Teams')

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

        /* avatar */
        .avatar {
            width: 48px;
            height: 64px;
            object-fit: cover;
            border-radius: .5rem;
            border: 1px solid #e5e7eb;
            background: #f8fafc
        }

        .avatar-fallback {
            width: 48px;
            height: 64px;
            border-radius: .5rem;
            border: 1px solid #e5e7eb;
            background: #e2e8f0;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700
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

        /* pills */
        .pill {
            padding: .2rem .55rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: .85rem;
            white-space: nowrap
        }

        .pill-blue {
            background: rgba(59, 130, 246, .12);
            color: #2563eb
        }

        .pill-pink {
            background: rgba(236, 72, 153, .12);
            color: #db2777
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
                <h1 class="h3 m-0">Komanda</h1>
                @if ($teams->total())
                    <span class="badge text-bg-success">{{ $teams->total() }}</span>
                @endif
            </div>
            <a href="{{ route('admin.teams.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Yeni əlavə
                et</a>
        </div>

        @if (session('ok'))
            <div class="alert alert-success">{{ session('ok') }}</div>
        @endif

        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <div class="input-group">
                    <div class="search-wrap w-100">
                        <i class="bi bi-search"></i>
                        <input type="search" class="form-control" name="q" value="{{ $q ?? '' }}"
                            placeholder="Ad və ya vəzifə üzrə axtar…">
                    </div>
                    @if (!empty($q) || !empty($gender))
                        <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary" title="Təmizlə"><i
                                class="bi bi-x-lg"></i></a>
                    @endif
                    <button class="btn btn-primary">Axtar</button>
                </div>
            </div>
            <div class="col-md-3">
                <select name="gender" class="form-select">
                    <option value="" @selected(($gender ?? '') === '')>Bütün cinslər</option>
                    <option value="male" @selected(($gender ?? '') === 'male')>Kişi</option>
                    <option value="female" @selected(($gender ?? '') === 'female')>Qadın</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="ms-md-auto small text-muted">Səhifə: {{ $teams->currentPage() }} / {{ $teams->lastPage() }}
                </div>
            </div>
        </form>

        @php
            $defaultMaleUrl =
                'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
            $defaultFemaleUrl =
                'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';
        @endphp

        @if ($teams->count())
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover table-sticky">
                        <thead>
                            <tr>
                                <th style="width:70px">#</th>
                                <th style="width:90px">Şəkil</th>
                                <th>Ad Soyad</th>
                                <th style="width:220px">Vəzifə</th>
                                <th style="width:120px">Cins</th>
                                <th style="width:180px">Yaradıldı</th>
                                <th class="text-end" style="width:210px">Əməliyyat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as $i => $t)
                                @php
                                    $thumb =
                                        $t->imageUrl ?: ($t->gender === 'female' ? $defaultFemaleUrl : $defaultMaleUrl);
                                    $fallback = $t->gender === 'female' ? $defaultFemaleUrl : $defaultMaleUrl;
                                    $initials = collect(explode(' ', $t->full_name))
                                        ->filter(fn($p) => strlen($p) > 0)
                                        ->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
                                        ->take(2)
                                        ->implode('');
                                @endphp
                                <tr>
                                    <td class="text-muted">{{ $teams->firstItem() + $i }}</td>
                                    <td>
                                        @if ($thumb)
                                            <img src="{{ $thumb }}" alt="{{ $t->full_name }}" class="avatar"
                                                loading="lazy"
                                                onerror="this.onerror=null; this.replaceWith(document.getElementById('f{{ $t->id }}').content.cloneNode(true));">
                                            <template id="f{{ $t->id }}">
                                                <div class="avatar-fallback">{{ $initials }}</div>
                                            </template>
                                        @else
                                            <div class="avatar-fallback">{{ $initials }}</div>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $t->full_name }}</td>
                                    <td>{{ $t->position ?: '—' }}</td>
                                    <td>
                                        @if ($t->gender === 'female')
                                            <span class="pill pill-pink">Qadın</span>
                                        @else
                                            <span class="pill pill-blue">Kişi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small text-muted">{{ optional($t->created_at)->diffForHumans() }}</div>
                                        <div>{{ optional($t->created_at)->format('d.m.Y H:i') }}</div>
                                    </td>
                                    <td class="text-end">
                                        <div class="actions-wide btn-group" role="group">
                                            <a href="{{ route('admin.teams.show', $t) }}"
                                                class="btn btn-sm btn-outline-secondary" title="Bax"><i
                                                    class="bi bi-eye"></i></a>
                                            <a href="{{ route('admin.teams.edit', $t) }}"
                                                class="btn btn-sm btn-outline-primary" title="Redaktə"><i
                                                    class="bi bi-pencil"></i></a>
                                            <form action="{{ route('admin.teams.destroy', $t) }}" method="POST"
                                                onsubmit="return confirm('Silmək istəyirsiniz?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Sil"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                        <div class="actions-compact dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ route('admin.teams.show', $t) }}"><i
                                                            class="bi bi-eye me-2"></i>Bax</a></li>
                                                <li><a class="dropdown-item" href="{{ route('admin.teams.edit', $t) }}"><i
                                                            class="bi bi-pencil me-2"></i>Redaktə</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.teams.destroy', $t) }}" method="POST"
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
                <div class="small text-muted">Səhifə: {{ $teams->currentPage() }} / {{ $teams->lastPage() }}</div>
                <div>{{ $teams->appends(['q' => $q ?? null, 'gender' => $gender ?? null])->links() }}</div>
            </div>
        @else
            <div class="border rounded p-4 text-center text-muted">
                Məlumat yoxdur.
            </div>
        @endif
    </div>
@endsection
