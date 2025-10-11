@extends('layouts.admin')
@section('title', $vacancy->name)

@section('content')
<h1 class="mb-3">{{ $vacancy->name }}</h1>
<div class="card mb-3"><div class="card-body">
  <div class="row">
    <div class="col-md-8">
      <p><strong>Views:</strong> {{ $vacancy->views }}</p>
      <p><strong>External URL:</strong>
        @if($vacancy->courseUrl)
          <a href="{{ $vacancy->courseUrl }}" target="_blank" rel="noopener">{{ $vacancy->courseUrl }}</a>
        @endif
      </p>
      <p class="mb-1"><strong>Təsvir:</strong></p>
      <div class="border rounded p-3">{!! $vacancy->description !!}</div>
    </div>
    <div class="col-md-4">
      @if($vacancy->imageUrl)
        <img src="{{ $vacancy->imageUrl }}" alt="" class="img-fluid rounded">
      @endif
    </div>
  </div>
</div></div>

@if($vacancy->socialLink)
<div class="card"><div class="card-body">
  <h5 class="mb-3">Sosial</h5>
  <ul class="mb-0">
    @foreach(['twitterurl'=>'Twitter','facebookurl'=>'Facebook','linkedinurl'=>'LinkedIn','emailurl'=>'Email','whatsappurl'=>'WhatsApp'] as $k=>$label)
      @if($vacancy->socialLink->$k)
        <li><strong>{{ $label }}:</strong> <a href="{{ $vacancy->socialLink->$k }}" target="_blank" rel="noopener">{{ $vacancy->socialLink->$k }}</a></li>
      @endif
    @endforeach
  </ul>
</div></div>
@endif
@endsection
