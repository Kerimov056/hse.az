@extends('layouts.admin')
@section('title', $news->name)

@section('content')
<h1 class="mb-3">{{ $news->name }}</h1>

<div class="card mb-3">
  <div class="card-body">
    <div class="row">
      <div class="col-md-8">
        <p><strong>Views:</strong> {{ $news->views }}</p>
        <p><strong>Link:</strong>
          @if($news->courseUrl)
            <a href="{{ $news->courseUrl }}" target="_blank" rel="noopener">
              {{ $news->courseUrl }}
            </a>
          @endif
        </p>
        <p class="mb-1"><strong>Mətn:</strong></p>
        <div class="border rounded p-3">
          {!! $news->description !!}
        </div>
      </div>
      <div class="col-md-4">
        @if($news->imageUrl)
          <img src="{{ $news->imageUrl }}" alt="" class="img-fluid rounded">
        @endif
      </div>
    </div>
  </div>
</div>

@if($news->socialLink)
  <div class="card">
    <div class="card-body">
      <h5 class="mb-3">Sosial</h5>
      <ul class="mb-0">
        @foreach(['twitterurl'=>'Twitter','facebookurl'=>'Facebook','linkedinurl'=>'LinkedIn','emailurl'=>'Email','whatsappurl'=>'WhatsApp'] as $k=>$label)
          @if($news->socialLink->$k)
            <li>
              <strong>{{ $label }}:</strong>
              <a href="{{ $news->socialLink->$k }}" target="_blank" rel="noopener">
                {{ $news->socialLink->$k }}
              </a>
            </li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
@endif
@endsection
