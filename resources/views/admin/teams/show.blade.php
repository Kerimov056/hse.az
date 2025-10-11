@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h1 class="h3 mb-3">Komanda — Bax</h1>

  @php
    // Gender-ə uyğun 3×4 default avatar URL-ləri (istədiyin URL-lərlə)
    $defaultMaleUrl   = 'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
    $defaultFemaleUrl = 'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';

    // Real şəkil varsa onu götür, yoxdursa gender-ə uyğun default-u seç
    $thumb = $team->imageUrl
      ? $team->imageUrl
      : ($team->gender === 'female' ? $defaultFemaleUrl : $defaultMaleUrl);
  @endphp

  <div class="card">
    <div class="card-body d-flex gap-4 align-items-start">
      {{-- onerror: real şəkil görünməsə gender defaultuna düşəcək --}}
      <img
        src="{{ $thumb }}"
        alt="{{ $team->full_name }}"
        loading="lazy"
        style="width:140px;height:186px;object-fit:cover;border-radius:12px;border:1px solid #eee"
        onerror="this.onerror=null; this.src='{{ $team->gender==='female' ? $defaultFemaleUrl : $defaultMaleUrl }}';"
      >

      <div>
        <h5 class="mb-2">{{ $team->full_name }}</h5>
        <div class="text-muted mb-1">{{ $team->position ?: '—' }}</div>
        <div class="text-muted mb-2">
          Cins: {{ $team->gender === 'female' ? 'Qadın' : 'Kişi' }}
        </div>
        <div class="small text-muted">
          Yaradıldı: {{ optional($team->created_at)->format('d.m.Y H:i') }}
        </div>
      </div>
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-primary">Redaktə</a>
    <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">Geri</a>
  </div>
</div>

@if($team->phone || $team->email)
  <div class="mb-2">
    @if($team->phone)<div class="text-muted">📞 {{ $team->phone }}</div>@endif
    @if($team->email)<div class="text-muted">✉️ {{ $team->email }}</div>@endif
  </div>
@endif

@if($team->expertise_title || $team->skills)
  <h5 class="mt-3 mb-2">{{ $team->expertise_title ?? 'My Expertise & Skills' }}</h5>
  @if($team->expertise_intro)
    <div class="text-muted mb-2">{{ $team->expertise_intro }}</div>
  @endif
  @foreach(($team->skills ?? []) as $s)
    <div class="mb-2">
      <div class="d-flex justify-content-between">
        <strong>{{ $s['name'] ?? '' }}</strong>
        <span>{{ (int)($s['percent'] ?? 0) }}%</span>
      </div>
      <div class="progress" style="height:8px">
        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ (int)($s['percent'] ?? 0) }}%"></div>
      </div>
    </div>
  @endforeach
@endif

@endsection
