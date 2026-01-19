@extends('layouts.admin')
@section('title', $service->name)

@section('content')
<h1 class="mb-3">{{ $service->name }}</h1>

<div class="card mb-3">
  <div class="card-body">
    <div class="row">
      <div class="col-md-8">
        <p><strong>Views:</strong> {{ $service->views }}</p>

        @if(!empty($service->courseHoldingName))
          <p><strong>Holding:</strong> {{ $service->courseHoldingName }}</p>
        @endif

        <p><strong>Service URL:</strong>
          @if($service->courseUrl)
            <a href="{{ $service->courseUrl }}" target="_blank" rel="noopener">{{ $service->courseUrl }}</a>
          @else
            <span class="text-muted">—</span>
          @endif
        </p>

        <p class="mb-1"><strong>Təsvir:</strong></p>
        <div class="border rounded p-3">{!! $service->description !!}</div>

        @if(!empty($service->info))
          <p class="mt-3 mb-1"><strong>Əlavə info:</strong></p>
          <div class="border rounded p-3">{{ $service->info }}</div>
        @endif
      </div>

      <div class="col-md-4">
        @if($service->imageUrl)
          <img src="{{ $service->imageUrl }}" alt="" class="img-fluid rounded">
        @endif
      </div>
    </div>
  </div>
</div>

@if($service->socialLink)
  <div class="card">
    <div class="card-body">
      <h5 class="mb-3">Sosial</h5>
      <ul class="mb-0">
        @foreach(['twitterurl'=>'Twitter','facebookurl'=>'Facebook','linkedinurl'=>'LinkedIn','emailurl'=>'Email','whatsappurl'=>'WhatsApp'] as $k=>$label)
          @if($service->socialLink->$k)
            <li><strong>{{ $label }}:</strong> <a href="{{ $service->socialLink->$k }}" target="_blank" rel="noopener">{{ $service->socialLink->$k }}</a></li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
@endif
@endsection
