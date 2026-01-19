@extends('layouts.admin')
@section('title', $course->name)

@push('styles')
<style>
  .meta-row { display:flex; flex-wrap:wrap; gap:.5rem; }
  .meta-pill{
    display:inline-flex;align-items:center;gap:.4rem;
    padding:.25rem .6rem;border-radius:999px;
    background:#f1f5f9;color:#0f172a;font-size:.85rem;
    border:1px solid #e5e7eb;
    text-decoration:none;
  }
  .topic-chip { background:#eef2ff; border:1px solid #e0e7ff; padding:.2rem .5rem; border-radius:999px; color:#3730a3; font-size:.85rem }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
  <div>
    <h1 class="mb-2">{{ $course->name }}</h1>
    <div class="meta-row">
      <span class="meta-pill">Views: {{ number_format($course->views) }}</span>
      @if($course->courseHoldingName) <span class="meta-pill">Holding: {{ $course->courseHoldingName }}</span> @endif
      @if($course->duration) <span class="meta-pill">Müddət: {{ $course->duration }}</span> @endif
      @if($course->instructor) <span class="meta-pill">Instructor: {{ $course->instructor }}</span> @endif
      @if($course->price !== null) <span class="meta-pill">Qiymət: {{ number_format($course->price, 2) }} AZN</span> @endif
      @if($course->courseUrl)
        <a class="meta-pill" href="{{ $course->courseUrl }}" target="_blank" rel="noopener">
          Linki aç
        </a>
      @endif
    </div>
  </div>

  <div class="d-flex gap-2">
    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-secondary">Edit</a>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Geri</a>
  </div>
</div>

<div class="card mb-3 shadow-sm">
  <div class="card-body">
    <div class="row g-3">
      <div class="col-md-8">
        <div class="mb-3">
          <div class="fw-semibold mb-1">Təsvir</div>
          <div class="border rounded p-3">{!! $course->description !!}</div>
        </div>

        @if($course->info)
          <div class="mb-3">
            <div class="fw-semibold mb-1">Əlavə info</div>
            <div class="border rounded p-3">{{ $course->info }}</div>
          </div>
        @endif

        @if($course->relationLoaded('courseTopics') ? $course->courseTopics->count() : $course->courseTopics()->count())
          @php
            $topics = $course->relationLoaded('courseTopics') ? $course->courseTopics : $course->courseTopics;
          @endphp
          <div class="mb-2 fw-semibold">Course Topics</div>
          <div class="d-flex flex-wrap gap-2">
            @foreach($topics as $t)
              <span class="topic-chip">{{ $t->title }}</span>
            @endforeach
          </div>
        @endif
      </div>

      <div class="col-md-4">
        @if($course->imageUrl)
          <img src="{{ $course->imageUrl }}" alt="" class="img-fluid rounded border">
        @endif
      </div>
    </div>
  </div>
</div>

@if($course->socialLink)
<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="mb-3">Sosial</h5>
    <ul class="mb-0">
      @foreach(['twitterurl'=>'Twitter','facebookurl'=>'Facebook','linkedinurl'=>'LinkedIn','emailurl'=>'Email','whatsappurl'=>'WhatsApp'] as $k=>$label)
        @if($course->socialLink->$k)
          <li class="mb-1">
            <strong>{{ $label }}:</strong>
            <a href="{{ $course->socialLink->$k }}" target="_blank" rel="noopener">{{ $course->socialLink->$k }}</a>
          </li>
        @endif
      @endforeach
    </ul>
  </div>
</div>
@endif
@endsection
