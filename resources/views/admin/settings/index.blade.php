@extends('layouts.admin')
@section('title', 'Settings – Overview')


@push('styles')
    <style>
        .table-sticky thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            background: #fff;
            border-bottom: 1px solid #e5e7eb
        }

        .kv-key {
            font-weight: 600
        }

        .kv-val pre {
            white-space: pre-wrap;
            margin-bottom: 0
        }

        .copy-btn {
            --bs-btn-padding-y: .25rem;
            --bs-btn-padding-x: .5rem
        }

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
    </style>
@endpush


@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <h1 class="h4 mb-0">Settings – Overview</h1>
                @if ($settings->count())
                    <span class="badge text-bg-success">{{ $settings->count() }}</span>
                @endif
            </div>
            <a href="{{ route('admin.settings.edit') }}" class="btn btn-primary"><i class="bi bi-sliders me-1"></i> Edit
                Settings</a>
        </div>


        <div class="card shadow-sm">
            <div class="card-body border-bottom">
                <form method="GET" class="row g-2">
                    <div class="col-md-6">
                        <div class="search-wrap">
                            <i class="bi bi-search"></i>
                            <input type="search" name="q" value="{{ $q ?? '' }}" class="form-control"
                                placeholder="Açar sözlə axtar (key və ya value)…">
                        </div>
                    </div>
                    <div class="col-md-2 d-grid d-md-block">
                        <button class="btn btn-outline-secondary w-100"><i class="bi bi-funnel me-1"></i>Axtar</button>
                    </div>
                    @if (!empty($q))
                        <div class="col-md-2 d-grid d-md-block">
                            <a class="btn btn-outline-dark w-100" href="{{ route('admin.settings.index') }}"><i
                                    class="bi bi-x-lg me-1"></i>Təmizlə</a>
                        </div>
                    @endif
                </form>
            </div>


            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0 table-sticky">
                    <thead>
                        <tr>
                            <th style="width:32%">Key</th>
                            <th>Value</th>
                            <th style="width:70px" class="text-end">Kopyala</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $item)
                            @php
                                $val = $item->value;
                                $isArray = is_array($val) || is_object($val);
                                $pretty = $isArray
                                    ? json_encode($val, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
                                    : (string) $val;
                            @endphp
                            <tr>
                                <td class="kv-key">{{ $item->key }}</td>
                                <td class="kv-val">
                                    @if ($isArray)
                                        <details>
                                            <summary class="small text-muted">JSON obyektini göstər</summary>
                                            <pre class="mt-2">{{ $pretty }}</pre>
                                        </details>
                                    @else
                                        <span>{{ $pretty }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary copy-btn"
                                        data-copy="{{ e($isArray ? $pretty : $pretty) }}" title="Kopyala">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted">Heç bir qeyd yoxdur.</td>
                            </tr>
                        @endforelse
                    </tbody>
                @endsection
