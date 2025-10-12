@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Settings – Overview</h1>
        <a href="{{ route('admin.settings.edit') }}" class="btn btn-primary">Edit Settings</a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead>
                        <tr><th style="width:32%">Key</th><th>Value</th></tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->key }}</td>
                                <td>
                                    @php
                                        $val = $item->value;
                                        $isArray = is_array($val) || is_object($val);
                                        $pretty = $isArray ? json_encode($val, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) : (string)$val;
                                    @endphp
                                    @if($isArray)
                                        <pre class="mb-0" style="white-space: pre-wrap">{{ $pretty }}</pre>
                                    @else
                                        <span>{{ $pretty }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-muted">Heç bir qeyd yoxdur.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
