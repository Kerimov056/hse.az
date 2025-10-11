@extends('layouts.admin')
@section('title', $topic->name)

@section('content')
<h1 class="mb-3">{{ $topic->name }}</h1>
<div class="card mb-3"><div class="card-body">
  <div class="row">
    <div class="col-md-8">
      <p><strong>Views:</strong> {{ $topic->views }}</p>
      <p><strong>External URL:</strong>
        @if($topic->courseUrl)
          <a href="{{ $topic->courseUrl }}" target="_blank" rel="noopener">{{ $topic->courseUrl }}</a>
        @endif
      </p>
      <p class="mb-1"><strong>Təsvir:</strong></p>
      <div class="border rounded p-3">{!! $topic->description !!}</div>
    </div>
    <div class="col-md-4">
      @if($topic->imageUrl)
        <img src="{{ $topic->imageUrl }}" alt="" class="img-fluid rounded">
      @endif
    </div>
  </div>
</div></div>

@if($topic->socialLink)
<div class="card"><div class="card-body">
  <h5 class="mb-3">Sosial</h5>
  <ul class="mb-0">
    @foreach(['twitterurl'=>'Twitter','facebookurl'=>'Facebook','linkedinurl'=>'LinkedIn','emailurl'=>'Email','whatsappurl'=>'WhatsApp'] as $k=>$label)
      @if($topic->socialLink->$k)
        <li><strong>{{ $label }}:</strong> <a href="{{ $topic->socialLink->$k }}" target="_blank" rel="noopener">{{ $topic->socialLink->$k }}</a></li>
      @endif
    @endforeach
  </ul>
</div></div>
@endif
@endsection
