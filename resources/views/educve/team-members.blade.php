@extends('layouts.app')

@php
  $q = $q ?? request('q');
  $female = 'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';
  $male   = 'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
@endphp

@section('content')
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
           data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">Team Members</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Team Members</li>
        </ol>
      </div>
    </div>
    <div class="td_page_heading_shape_1 position-absolute td_hover_layer_3"></div>
    <div class="td_page_heading_shape_2 position-absolute td_hover_layer_5"></div>
    <div class="td_page_heading_shape_3 position-absolute">
      <img src="{{ asset('assets/img/others/page_heading_shape_3.svg') }}" alt="">
    </div>
    <div class="td_page_heading_shape_4 position-absolute">
      <img src="{{ asset('assets/img/others/page_heading_shape_4.svg') }}" alt="">
    </div>
    <div class="td_page_heading_shape_5 position-absolute">
      <img src="{{ asset('assets/img/others/page_heading_shape_5.svg') }}" alt="">
    </div>
    <div class="td_page_heading_shape_6 position-absolute td_hover_layer_3"></div>
  </section>

  <section>
    <div class="td_height_120 td_height_lg_80"></div>
    <div class="container">

      <form method="GET" class="row g-2 mb-4">
        <div class="col-md-6">
          <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="Ad / vəzifə üzrə axtar…">
        </div>
        <div class="col-md-4">
          <select name="gender" class="form-select">
            <option value="">Bütün cinslər</option>
            <option value="male"   @selected(($gender??'')==='male')>Kişi</option>
            <option value="female" @selected(($gender??'')==='female')>Qadın</option>
          </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button class="btn btn-primary w-100">Axtar</button>
          <a href="{{ route('team') }}" class="btn btn-outline-secondary">Təmizlə</a>
        </div>
      </form>

      @if($teams->count())
        <div class="row td_gap_y_30">
          @foreach($teams as $t)
            @php
              $thumb = $t->imageUrl ?: ($t->gender === 'female' ? $female : $male);
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="td_team td_style_3 text-center position-relative">
                <div class="td_team_thumb_wrap td_mb_20">
                  <div class="td_team_thumb">
                    <a href="{{ route('team-details', $t) }}">
                      <img src="{{ $thumb }}" alt="{{ $t->full_name }}" class="w-100 td_radius_10" style="height:300px;object-fit:cover">
                    </a>
                  </div>
                  <img class="td_team_thumb_shape" src="{{ asset('assets/img/home_4/team_shape.png') }}" alt="">
                </div>
                <div class="td_team_info td_white_bg">
                  <h3 class="td_team_member_title td_fs_24 td_semibold mb-0">
                    <a href="{{ route('team-details', $t) }}">{{ $t->full_name }}</a>
                  </h3>
                  <p class="td_team_member_designation mb-0 td_fs_18 td_opacity_7 td_heading_color">
                    {{ $t->position ?: '—' }}
                  </p>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="td_height_60 td_height_lg_40"></div>
        <div class="d-flex justify-content-center">
          {{ $teams->links() }}
        </div>
      @else
        <div class="text-center text-muted">Məlumat tapılmadı.</div>
      @endif
    </div>
    <div class="td_height_120 td_height_lg_80"></div>
  </section>
@endsection
