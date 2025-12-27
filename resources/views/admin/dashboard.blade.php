@extends('layouts.admin')
@section('title', 'Dashboard')

@push('styles')
    <style>
        :root {
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e5e7eb;
            --card: #ffffff;
            --bg: #0b1120;
        }

        .dashboard-wrap {
            background: radial-gradient(circle at top left, #1e293b, #020617);
            min-height: calc(100vh - 56px);
            padding: 1.5rem;
            color: #e5e7eb;
        }

        .dashboard-header {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: .9rem;
        }

        .user-avatar {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            background: linear-gradient(135deg, #22c55e, #0ea5e9);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #0b1120;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .8);
        }

        .user-meta h1 {
            font-size: 1.35rem;
            font-weight: 600;
            margin: 0;
        }

        .user-meta .muted {
            font-size: .9rem;
            color: #9ca3af;
        }

        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .25rem .65rem;
            border-radius: 999px;
            background: rgba(148, 163, 184, .12);
            border: 1px solid rgba(148, 163, 184, .3);
            font-size: .8rem;
            color: #e5e7eb;
        }

        .role-pill i {
            font-size: .9rem;
        }

        .dash-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .dash-actions .btn-outline-light {
            border-color: rgba(148, 163, 184, .4);
            color: #e5e7eb;
        }

        .dash-actions .btn-outline-light:hover {
            background: rgba(148, 163, 184, .06);
        }

        /* Stat cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 1199.98px) {
            .stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .dashboard-wrap {
                padding: 1rem;
            }

            .stat-grid {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            background: radial-gradient(circle at top left, rgba(56, 189, 248, .12), rgba(15, 23, 42, 1));
            border: 1px solid rgba(148, 163, 184, .25);
            padding: 1rem 1.1rem;
            box-shadow: 0 20px 35px rgba(15, 23, 42, .8);
        }

        .stat-card:nth-child(2) {
            background: radial-gradient(circle at top left, rgba(52, 211, 153, .12), rgba(15, 23, 42, 1));
        }

        .stat-card:nth-child(3) {
            background: radial-gradient(circle at top left, rgba(251, 191, 36, .14), rgba(15, 23, 42, 1));
        }

        .stat-card:nth-child(4) {
            background: radial-gradient(circle at top left, rgba(239, 68, 68, .16), rgba(15, 23, 42, 1));
        }

        .stat-label {
            font-size: .9rem;
            color: #9ca3af;
            margin-bottom: .4rem;
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #f9fafb;
        }

        .stat-meta {
            font-size: .8rem;
            color: #9ca3af;
            margin-top: .25rem;
        }

        .stat-icon {
            position: absolute;
            right: .85rem;
            top: .9rem;
            width: 34px;
            height: 34px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, .7);
            border: 1px solid rgba(148, 163, 184, .35);
            color: #e5e7eb;
        }

        .trend-pill {
            display: inline-flex;
            align-items: center;
            gap: .25rem;
            padding: .12rem .45rem;
            border-radius: 999px;
            font-size: .75rem;
            margin-left: .4rem;
        }

        .trend-up {
            background: rgba(34, 197, 94, .14);
            color: #4ade80;
        }

        .trend-neutral {
            background: rgba(148, 163, 184, .16);
            color: #e5e7eb;
        }

        /* Lower layout */
        .dash-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1.2fr);
            gap: 1rem;
        }

        @media (max-width: 991.98px) {
            .dash-main-grid {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        .card-dark {
            background: rgba(15, 23, 42, .96);
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, .25);
            box-shadow: 0 18px 45px rgba(15, 23, 42, .9);
            overflow: hidden;
        }

        .card-dark-header {
            padding: .75rem 1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
        }

        .card-dark-header h2 {
            font-size: .95rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .card-dark-header .muted {
            font-size: .8rem;
            color: #9ca3af;
        }

        .card-dark-body {
            padding: .8rem 1rem 1rem;
        }

        /* Tables */
        .table-dashboard {
            margin-bottom: 0;
            color: #e5e7eb;
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(15, 23, 42, .9);
            --bs-table-hover-bg: rgba(30, 64, 175, .32);
            --bs-table-border-color: rgba(31, 41, 55, 1);
        }

        .table-dashboard thead th {
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #9ca3af;
            border-bottom-width: 1px;
            border-color: rgba(31, 41, 55, 1);
        }

        .table-dashboard tbody td {
            font-size: .86rem;
            vertical-align: middle;
            border-color: rgba(31, 41, 55, 1);
        }

        .badge-soft {
            border-radius: 999px;
            padding: .15rem .5rem;
            font-size: .75rem;
            border: 1px solid rgba(148, 163, 184, .4);
            color: #e5e7eb;
        }

        .badge-soft.green {
            border-color: rgba(34, 197, 94, .5);
            color: #6ee7b7;
            background: rgba(21, 128, 61, .28);
        }

        .badge-soft.blue {
            border-color: rgba(59, 130, 246, .5);
            color: #bfdbfe;
            background: rgba(30, 64, 175, .35);
        }

        .badge-soft.amber {
            border-color: rgba(245, 158, 11, .65);
            color: #fed7aa;
            background: rgba(180, 83, 9, .4);
        }

        .views-chip {
            display: inline-flex;
            align-items: center;
            gap: .25rem;
            padding: .15rem .45rem;
            border-radius: 999px;
            background: rgba(15, 23, 42, .9);
            border: 1px solid rgba(148, 163, 184, .4);
            font-size: .75rem;
            color: #e5e7eb;
        }

        .views-chip i {
            font-size: .85rem;
        }

        .link-subtle {
            text-decoration: none;
            color: #e5e7eb;
        }

        .link-subtle:hover {
            color: #bfdbfe;
        }

        .text-muted-soft {
            color: #9ca3af;
            font-size: .8rem;
        }

        /* Quick cards */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
        }

        @media (max-width: 575.98px) {
            .quick-grid {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        .quick-card {
            border-radius: .9rem;
            padding: .7rem .8rem;
            border: 1px solid rgba(55, 65, 81, .9);
            background: radial-gradient(circle at top left, rgba(30, 64, 175, .55), rgba(15, 23, 42, 1));
        }

        .quick-card:nth-child(2) {
            background: radial-gradient(circle at top left, rgba(22, 163, 74, .55), rgba(15, 23, 42, 1));
        }

        .quick-card-title {
            font-size: .86rem;
            font-weight: 600;
            margin-bottom: .2rem;
        }

        .quick-card ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .quick-card li+li {
            margin-top: .25rem;
        }

        .quick-card a {
            font-size: .8rem;
            text-decoration: none;
            color: #e5e7eb;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .quick-card a i {
            font-size: .85rem;
            opacity: .85;
        }

        .empty-small {
            padding: .8rem;
            border-radius: .6rem;
            background: rgba(15, 23, 42, .85);
            border: 1px dashed rgba(75, 85, 99, .9);
            font-size: .8rem;
            text-align: center;
            color: #9ca3af;
        }
    </style>
@endpush

@section('content')
    @php
        $totals = $totals ?? [];
        $totalViews = $totalViews ?? null;
        $today = now();
        $initials = collect(explode(' ', $who->name ?? 'Admin'))
            ->filter(fn($p) => strlen($p) > 0)
            ->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)))
            ->take(2)
            ->implode('');
    @endphp

    <div class="dashboard-wrap">
        {{-- Header --}}
        <div class="dashboard-header">
            <div class="user-pill">
                <div class="user-avatar">
                    {{ $initials }}
                </div>
                <div class="user-meta">
                    <h1>
                        Salam, {{ $who->name ?? 'Admin' }}
                        <span class="role-pill">
                            <i class="bi bi-shield-lock"></i>
                            {{ ucfirst($who->role ?? 'admin') }}
                        </span>
                    </h1>
                    <div class="muted">
                        İdarə panelinə xoş gəldin.
                        <span class="d-none d-sm-inline">Əsas məlumatlar bir yerdə toplanıb.</span>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <div class="muted">{{ $today->translatedFormat('d F Y, l') }}</div>
                <div class="dash-actions mt-1">
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-plus-lg me-1"></i> Yeni kurs
                    </a>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-megaphone me-1"></i> Yeni xəbər
                    </a>
                    <a href="{{ route('admin.vacancies.create') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-briefcase me-1"></i> Vakansiya əlavə et
                    </a>
                </div>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-easel"></i>
                </div>
                <div class="stat-label">
                    Kurslar
                    <span class="trend-pill trend-up">
                        <i class="bi bi-arrow-up-right"></i> son həftə
                    </span>
                </div>
                <div class="stat-value">{{ number_format($totals['courses'] ?? 0) }}</div>
                <div class="stat-meta">
                    Aktiv kursların ümumi sayı.
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-newspaper"></i>
                </div>
                <div class="stat-label">
                    Xəbərlər
                    <span class="trend-pill trend-neutral">
                        <i class="bi bi-clock-history"></i> yenilənib
                    </span>
                </div>
                <div class="stat-value">{{ number_format($totals['news'] ?? 0) }}</div>
                <div class="stat-meta">
                    Saytda dərc olunmuş xəbərlər.
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-briefcase"></i>
                </div>
                <div class="stat-label">
                    Vakansiyalar
                </div>
                <div class="stat-value">{{ number_format($totals['vacancies'] ?? 0) }}</div>
                <div class="stat-meta">
                    Açıq vakansiya sayı.
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <div class="stat-label">
                    Ümumi baxışlar
                </div>
                <div class="stat-value">
                    {{ $totalViews !== null ? number_format($totalViews) : '—' }}
                </div>
                <div class="stat-meta">
                    Kurs, xəbər, xidmət və digər səhifələrin baxışlarının cəmi.
                </div>
            </div>
        </div>

        {{-- Main content --}}
        <div class="dash-main-grid">
            {{-- Left: tables --}}
            <div class="card-dark">
                <div class="card-dark-header">
                    <div>
                        <h2>
                            Son yenilənən kontent
                            <span class="muted d-none d-sm-inline">Xəbərlər, vakansiyalar, kurslar</span>
                        </h2>
                    </div>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-light">
                        Hamısına bax
                    </a>
                </div>
                <div class="card-dark-body">
                    <ul class="nav nav-tabs nav-tabs-dark small mb-3" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-news" type="button">
                                <i class="bi bi-newspaper me-1"></i> Xəbərlər
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-vacancies" type="button">
                                <i class="bi bi-briefcase me-1"></i> Vakansiyalar
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-courses" type="button">
                                <i class="bi bi-easel me-1"></i> Kurslar
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{-- News --}}
                        <div class="tab-pane fade show active" id="tab-news">
                            @isset($latestNews)
                                @if ($latestNews->count())
                                    <div class="table-responsive">
                                        <table class="table table-dashboard table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Başlıq</th>
                                                    <th style="width:110px">Baxış</th>
                                                    <th style="width:140px">Tarix</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestNews as $n)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('admin.news.edit', $n) }}" class="link-subtle">
                                                                {{ $n->name }}
                                                            </a>
                                                            @if (!empty($n->description))
                                                                <div class="text-muted-soft">
                                                                    {{ \Illuminate\Support\Str::limit(strip_tags($n->description), 80) }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="views-chip">
                                                                <i class="bi bi-eye"></i>
                                                                {{ number_format($n->views ?? 0) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="text-muted-soft">
                                                                {{ optional($n->created_at)->diffForHumans() }}
                                                            </div>
                                                            <div style="font-size:.78rem;">
                                                                {{ optional($n->created_at)->format('d.m.Y H:i') }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty-small">Hələ xəbər yoxdur.</div>
                                @endif
                            @else
                                <div class="empty-small">Xəbər məlumatı ötürülməyib.</div>
                            @endisset
                        </div>

                        {{-- Vacancies --}}
                        <div class="tab-pane fade" id="tab-vacancies">
                            @isset($latestVacancies)
                                @if ($latestVacancies->count())
                                    <div class="table-responsive">
                                        <table class="table table-dashboard table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Vakansiya</th>
                                                    <th style="width:110px">Baxış</th>
                                                    <th style="width:140px">Tarix</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestVacancies as $v)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('admin.vacancies.edit', $v) }}"
                                                                class="link-subtle">
                                                                {{ $v->name }}
                                                            </a>
                                                            @if (!empty($v->description))
                                                                <div class="text-muted-soft">
                                                                    {{ \Illuminate\Support\Str::limit(strip_tags($v->description), 80) }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="views-chip">
                                                                <i class="bi bi-eye"></i>
                                                                {{ number_format($v->views ?? 0) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="text-muted-soft">
                                                                {{ optional($v->created_at)->diffForHumans() }}
                                                            </div>
                                                            <div style="font-size:.78rem;">
                                                                {{ optional($v->created_at)->format('d.m.Y H:i') }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty-small">Hələ vakansiya yoxdur.</div>
                                @endif
                            @else
                                <div class="empty-small">Vakansiya məlumatı ötürülməyib.</div>
                            @endisset
                        </div>

                        {{-- Courses --}}
                        <div class="tab-pane fade" id="tab-courses">
                            @isset($latestCourses)
                                @if ($latestCourses->count())
                                    <div class="table-responsive">
                                        <table class="table table-dashboard table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Kurs</th>
                                                    <th style="width:110px">Baxış</th>
                                                    <th style="width:140px">Tarix</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestCourses as $c)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('admin.courses.edit', $c) }}"
                                                                class="link-subtle">
                                                                {{ $c->name }}
                                                            </a>
                                                            @if (!empty($c->description))
                                                                <div class="text-muted-soft">
                                                                    {{ \Illuminate\Support\Str::limit(strip_tags($c->description), 80) }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="views-chip">
                                                                <i class="bi bi-eye"></i>
                                                                {{ number_format($c->views ?? 0) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="text-muted-soft">
                                                                {{ optional($c->created_at)->diffForHumans() }}
                                                            </div>
                                                            <div style="font-size:.78rem;">
                                                                {{ optional($c->created_at)->format('d.m.Y H:i') }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="empty-small">Hələ kurs yoxdur.</div>
                                @endif
                            @else
                                <div class="empty-small">Kurs məlumatı ötürülməyib.</div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: quick overview --}}
            <div class="card-dark">
                <div class="card-dark-header">
                    <h2>
                        Ümumi xülasə
                        <span class="muted d-none d-sm-inline">Resurslar, komanda və FAQ</span>
                    </h2>
                </div>
                <div class="card-dark-body">
                    <div class="mb-3">
                        <div class="quick-grid">
                            <div class="quick-card">
                                <div class="quick-card-title">
                                    Kontent
                                    <span class="badge-soft blue ms-1">
                                        {{ number_format(($totals['resources'] ?? 0) + ($totals['resource_types'] ?? 0) + ($totals['topics'] ?? 0)) }}
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <a href="{{ route('admin.resources.index') }}">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Resurslar: {{ number_format($totals['resources'] ?? 0) }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.resource-types.index') }}">
                                            <i class="bi bi-tags"></i>
                                            Resurs tipləri: {{ number_format($totals['resource_types'] ?? 0) }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.topices.index') }}">
                                            <i class="bi bi-collection"></i>
                                            Topics: {{ number_format($totals['topics'] ?? 0) }}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="quick-card">
                                <div class="quick-card-title">
                                    İnsanlar və yardım
                                    <span class="badge-soft green ms-1">
                                        {{ number_format(($totals['teams'] ?? 0) + ($totals['faqs'] ?? 0)) }}
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <a href="{{ route('admin.teams.index') }}">
                                            <i class="bi bi-people"></i>
                                            Komanda: {{ number_format($totals['teams'] ?? 0) }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.faqs.index') }}">
                                            <i class="bi bi-question-circle"></i>
                                            FAQ-lar: {{ number_format($totals['faqs'] ?? 0) }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.services.index') }}">
                                            <i class="bi bi-puzzle"></i>
                                            Servislər: {{ number_format($totals['services'] ?? 0) }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Latest resources small table --}}
                    <div class="mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="text-muted-soft">
                                Son resurslar
                            </div>
                            <a href="{{ route('admin.resources.index') }}"
                                class="small text-decoration-none text-muted-soft">
                                Hamısı
                                <i class="bi bi-chevron-right ms-1" style="font-size:.7rem;"></i>
                            </a>
                        </div>

                        @isset($latestResources)
                            @if ($latestResources->count())
                                <div class="table-responsive">
                                    <table class="table table-sm table-dashboard align-middle">
                                        <thead>
                                            <tr>
                                                <th>Ad</th>
                                                <th style="width:90px">İl</th>
                                                <th style="width:120px">Tip</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($latestResources as $r)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('admin.resources.show', $r) }}"
                                                            class="link-subtle">
                                                            {{ \Illuminate\Support\Str::limit($r->name, 26) }}
                                                        </a>
                                                        @if (!empty($r->mime))
                                                            <div class="text-muted-soft">
                                                                {{ $r->mime }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $r->year ?: '—' }}</td>
                                                    <td>
                                                        <span class="badge-soft amber">
                                                            {{ $r->type->name ?? '—' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty-small">Hələ resurs yoxdur.</div>
                            @endif
                        @else
                            <div class="empty-small">Resurs məlumatı ötürülməyib.</div>
                        @endisset
                    </div>

                    {{-- Gallery and accreditations --}}
                    <div class="mt-3">
                        <div class="text-muted-soft mb-1">
                            Media və akkreditasiyalar
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-sm btn-outline-light">
                                <i class="bi bi-image me-1"></i>
                                Qalereya
                                <span class="badge-soft ms-1">
                                    {{ number_format($totals['gallery_images'] ?? 0) }}
                                </span>
                            </a>
                            <a href="{{ route('admin.accreditations.index') }}" class="btn btn-sm btn-outline-light">
                                <i class="bi bi-patch-check me-1"></i>
                                Akkreditasiyalar
                                <span class="badge-soft ms-1">
                                    {{ number_format($totals['accreditations'] ?? 0) }}
                                </span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
