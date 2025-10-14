@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@push('styles')
    <style>
        /* ===== Vacancies — Table View ===== */
        .jobs-table-wrap {
            --jt-radius: 12px;
            --jt-border: #e5e7eb;
            --jt-bg: #ffffff;
            --jt-head-bg: #f43f5e;
            /* qırmızı başlıq */
            --jt-head-color: #fff;
            --jt-row-hover: #fff7f7;
            --jt-shadow: 0 10px 28px rgba(2, 6, 23, .08);
        }

        .jobs-card {
            background: var(--jt-bg);
            border: 1px solid var(--jt-border);
            border-radius: var(--jt-radius);
            box-shadow: var(--jt-shadow);
            overflow: hidden
        }

        .jobs-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0
        }

        .jobs-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: var(--jt-head-bg);
            color: var(--jt-head-color);
            font-weight: 700;
            letter-spacing: .2px;
            padding: 14px 16px;
            text-align: left
        }

        .jobs-table thead th:first-child {
            padding-left: 24px
        }

        .jobs-table tbody td:first-child {
            padding-left: 24px
        }

        .jobs-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--jt-border);
            vertical-align: middle;
            color: #0f172a
        }

        .jobs-table tbody tr {
            background: #fff;
            transition: background .15s ease, transform .15s ease
        }

        .jobs-table tbody tr:nth-child(odd) {
            background: #fcfcff
        }

        .jobs-table tbody tr:hover {
            background: var(--jt-row-hover)
        }

        .job-title {
            font-weight: 800;
            color: #111827;
            text-decoration: none
        }

        .job-title:hover {
            text-decoration: underline;
            text-underline-offset: 2px
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .28rem .55rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: .85rem;
            border: 1px solid #fecaca;
            background: #fff1f2;
            color: #b91c1c;
            white-space: nowrap
        }

        .chip.muted {
            border-color: #e5e7eb;
            background: #f8fafc;
            color: #475569;
            font-weight: 600
        }

        .posted {
            color: #0f172a;
            font-weight: 600
        }

        .posted small {
            display: block;
            color: #64748b;
            font-weight: 500
        }

        .jobs-table tbody tr[role="link"] {
            cursor: pointer
        }

        .jobs-table tbody tr[role="link"]:active {
            transform: translateY(1px)
        }

        @media (max-width:640px) {
            .jobs-table thead {
                display: none
            }

            .jobs-table,
            .jobs-table tbody,
            .jobs-table tr,
            .jobs-table td {
                display: block;
                width: 100%
            }

            .jobs-table tbody tr {
                border: 1px solid var(--jt-border);
                border-radius: 12px;
                overflow: hidden;
                margin-bottom: 12px;
                box-shadow: 0 6px 18px rgba(2, 6, 23, .06)
            }

            .jobs-table tbody td {
                border: 0;
                display: flex;
                justify-content: space-between;
                gap: 12px;
                padding: 12px 14px
            }

            .jobs-table tbody td::before {
                content: attr(data-label);
                color: #6b7280;
                font-weight: 600
            }

            .jobs-table tbody td:first-child {
                display: block;
                padding: 14px 14px 6px
            }
        }
    </style>
@endpush

@section('content')
    {{-- Coach-mark üçün 1 dənə selector kifayətdir: #vacancy-hero --}}
    <section id="vacancy-hero" class="td_page_heading td_center td_bg_filed td_heading_bg text-center"
        data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Vacancies</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Vacancies</li>
                </ol>
            </div>
        </div>
    </section>

    <div class="td_height_100 td_height_lg_70"></div>

    <div class="container jobs-table-wrap">
        <div class="jobs-card">
            <table class="jobs-table">
                <thead>
                    <tr>
                        <th style="width:60%">Vacancy</th>
                        <th style="width:20%">Salary</th>
                        <th style="width:20%">Posted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vacancies as $v)
                        @php
                            $href = route('vacancies-details', $v->id);
                            $title = $v->name;
                            $salary = trim($v->salary ?? '');
                            $isNA = $salary === '' || Str::upper($salary) === 'N / A' || Str::upper($salary) === 'N/A';
                            $date = optional($v->created_at)->format('d F Y');
                            $diff = optional($v->created_at)->diffForHumans();
                        @endphp
                        <tr tabindex="0" role="link" onclick="window.location='{{ $href }}'"
                            onkeypress="if(event.key==='Enter'){window.location='{{ $href }}'}">
                            <td data-label="Vacancy">
                                <a class="job-title" href="{{ $href }}">{{ $title }}</a>
                                @if (!empty($v->city) || !empty($v->type))
                                    <div class="mt-1" style="color:#64748b">
                                        {{ $v->city ?? '' }} @if (!empty($v->city) && !empty($v->type))
                                            ·
                                        @endif {{ $v->type ?? '' }}
                                    </div>
                                @endif
                            </td>
                            <td data-label="Salary">
                                @if ($isNA)
                                    <span class="chip muted">N / A</span>
                                @else
                                    <span class="chip"><i
                                            class="fa-solid fa-money-bill-wave"></i>{{ $salary }}</span>
                                @endif
                            </td>
                            <td data-label="Posted">
                                <div class="posted">{{ $date }}</div>
                                <small>{{ $diff }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4" style="color:#64748b">Hələ vakansiya yoxdur.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($vacancies, 'links'))
            <div class="td_height_40"></div>
            <div class="d-flex justify-content-center">
                {{ $vacancies->links() }}
            </div>
        @endif
    </div>

    <div class="td_height_120 td_height_lg_80"></div>

    {{-- Coach-mark komponenti --}}
    <x-section-guide page="vacancy" />
@endsection
