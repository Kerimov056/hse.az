@extends('layouts.admin')
@section('title', $course->name)

@section('content')
<h1 class="mb-3">{{ $course->name }}</h1>
<div class="card mb-3"><div class="card-body">
  <div class="row">
    <div class="col-md-8">
      <p><strong>Views:</strong> {{ $course->views }}</p>
      <p><strong>Course URL:</strong>
        @if($course->courseUrl)
          <a href="{{ $course->courseUrl }}" target="_blank" rel="noopener">{{ $course->courseUrl }}</a>
        @endif
      </p>
      <p class="mb-1"><strong>Təsvir:</strong></p>
      <div class="border rounded p-3">{!! $course->description !!}</div>
    </div>
    <div class="col-md-4">
      @if($course->imageUrl)
        <img src="{{ $course->imageUrl }}" alt="" class="img-fluid rounded">
      @endif
    </div>
  </div>
</div></div>

@if($course->socialLink)
<div class="card"><div class="card-body">
  <h5 class="mb-3">Sosial</h5>
  <ul class="mb-0">
    @foreach(['twitterurl'=>'Twitter','facebookurl'=>'Facebook','linkedinurl'=>'LinkedIn','emailurl'=>'Email','whatsappurl'=>'WhatsApp'] as $k=>$label)
      @if($course->socialLink->$k)
        <li><strong>{{ $label }}:</strong> <a href="{{ $course->socialLink->$k }}" target="_blank" rel="noopener">{{ $course->socialLink->$k }}</a></li>
      @endif
    @endforeach
  </ul>
</div></div>
@endif
@endsection
