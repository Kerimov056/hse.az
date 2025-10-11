@extends('layouts.app')

@php
  use Illuminate\Support\Str;
  $q = $q ?? request('q');
@endphp

@push('styles')
<style>
  .vc_card{height:100%; border-radius:14px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,.06); background:#fff}
  .vc_thumb{position:relative; display:block; overflow:hidden}
  .vc_thumb::before{content:""; display:block; padding-top:62.5%}
  .vc_thumb>img{position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform .35s ease}
  .vc_thumb:hover>img{transform:scale(1.04)}
  .vc_overlay_top{position:absolute; top:10px; left:10px; right:10px; display:flex; justify-content:space-between; gap:8px; z-index:2;}
  .pill{background:rgba(0,0,0,.65); color:#fff; border-radius:999px; padding:6px 10px; font-weight:700; font-size:12px; line-height:1; display:flex; align-items:center; gap:6px}
  .pill--light{background:rgba(255,255,255,.92); color:#111}
  .vc_overlay_gradient{position:absolute; inset:0; background:linear-gradient(180deg, rgba(0,0,0,0) 45%, rgba(0,0,0,.55) 100%); opacity:0; transition:opacity .25s ease;}
  .vc_thumb:hover .vc_overlay_gradient{opacity:1}
  .vc_overlay_actions{position:absolute; left:0; right:0; bottom:12px; display:flex; justify-content:center; gap:10px; z-index:2; transform:translateY(8px); opacity:0; transition:all .25s ease;}
  .vc_thumb:hover .vc_overlay_actions{transform:translateY(0); opacity:1}
  .vc_body{display:flex; flex-direction:column; height:100%; padding:16px}
  .vc_title{font-size:1.1rem; font-weight:800; margin:0 0 6px}
  .vc_desc{opacity:.8; margin:0 0 10px}
  .vc_actions{margin-top:auto; display:flex; gap:.5rem}
  .vc_search_wrap{display:flex; justify-content:center}
  .vc_search{display:flex; gap:.6rem; width:100%; max-width:760px}
  .vc_search input[type="text"]{flex:1; min-width:0; border:1px solid var(--td-border,#e8e8e8); border-radius:999px; padding:.85rem 1rem; font-size:1rem;}
  .vc_search button{border:none; border-radius:999px; padding:.85rem 1rem; font-weight:700;}
  @media (max-width:575.98px){ .vc_search{flex-direction:column} .vc_search button{width:100%} }
  .empty-state{max-width:560px; margin:40px auto 0; text-align:center}
  .empty-title{font-size:1.4rem; font-weight:800; margin-bottom:.25rem}
  .empty-desc{opacity:.75}
</style>
@endpush

@section('content')
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
           data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">Vacancies</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Vacancies</li>
        </ol>
      </div>
    </div>
  </section>

  <section>
    <div class="td_height_120 td_height_lg_80"></div>
    <div class="container">

      <div class="vc_search_wrap">
        <form class="vc_search" action="{{ route('vacancies') }}" method="GET" role="search" aria-label="Vacancy search">
          <input type="text" name="q" value="{{ $q }}" placeholder="Search vacancies by name or description..." autocomplete="off" />
          <button class="td_btn td_style_1 td_medium" type="submit">
            <span class="td_btn_in td_white_color td_accent_bg"><span>Search</span></span>
          </button>
          @if($q)
            <a href="{{ route('vacancies') }}" class="td_btn td_style_2 td_medium" title="Clear search">
              <span class="td_btn_in td_heading_color td_white_bg"><span>Clear</span></span>
            </a>
          @endif
        </form>
      </div>

      <div class="td_height_40 td_height_lg_30"></div>

      <div class="td_section_head_2">
        <div class="td_section_head_2_left">
          <span class="td_heading_color td_medium">
            @if(method_exists($vacancies,'total'))
              @if(($q ?? '') !== '')
                {{ $vacancies->total() }} result(s) for “{{ $q }}”
              @else
                Showing {{ $vacancies->count() }} Vacancies of {{ $vacancies->total() }}
              @endif
            @else
              {{ $q ? "Result for “{$q}”: " . count($vacancies) . " vacancy(ies)" : "Showing " . count($vacancies) . " Vacancies" }}
            @endif
          </span>
        </div>
        <div class="td_section_head_2_right">
          <div class="td_section_head_select td_fs_20">
            <b class="td_semibold td_heading_color">Sort By: </b>
            <select class="td_form_field td_medium" disabled><option value="0">Featured</option></select>
          </div>
        </div>
      </div>

      <div class="td_height_40 td_height_lg_30"></div>

      @if($vacancies->count() > 0)
        <div class="row td_gap_y_30 td_row_gap_30">
          @foreach($vacancies as $vc)
            <div class="col-lg-4 col-md-6">
              <div class="vc_card">
                <a href="{{ route('vacancies-details', $vc->id) }}" class="vc_thumb">
                  @if(!empty($vc->imageUrl))
                    <img src="{{ $vc->imageUrl }}" alt="{{ $vc->name }}">
                  @else
                    <img src="{{ asset('assets/img/placeholder/placeholder-800x500.jpg') }}" alt="{{ $vc->name }}">
                  @endif

                  <div class="vc_overlay_top">
                    <span class="pill pill--light">{{ $vc->category->name ?? ($vc->category ?? 'Vacancy') }}</span>
                    <span class="pill" title="Views">
                      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
                      </svg>
                      {{ number_format($vc->views ?? 0) }}
                    </span>
                  </div>

                  <div class="vc_overlay_gradient"></div>

                  <div class="vc_overlay_actions">
                    <a href="{{ route('vacancies-details', $vc->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                      <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                    </a>
                    @if(!empty($vc->courseUrl))
                      <a href="{{ $vc->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
                        <span class="td_btn_in td_heading_color td_white_bg"><span>Apply</span></span>
                      </a>
                    @endif
                  </div>
                </a>

                <div class="vc_body">
                  <h2 class="vc_title">
                    <a href="{{ route('vacancies-details', $vc->id) }}">{{ $vc->name }}</a>
                  </h2>

                  @php $desc = strip_tags($vc->description ?? ''); @endphp
                  @if($desc)
                    <p class="vc_desc td_heading_color td_opacity_7">{{ Str::limit($desc, 140) }}</p>
                  @endif

                  <div class="vc_actions">
                    <a href="{{ route('vacancies-details', $vc->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                      <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                    </a>
                    @if(!empty($vc->courseUrl))
                      <a href="{{ $vc->courseUrl }}" target="_blank" rel="noopener"
                         class="td_btn td_style_2 td_radius_10 td_medium">
                        <span class="td_btn_in td_heading_color td_white_bg"><span>Apply</span></span>
                      </a>
                    @endif
                  </div>
                </div>

              </div>
            </div>
          @endforeach
        </div>

        @if(method_exists($vacancies, 'links'))
          <div class="td_height_60 td_height_lg_40"></div>
          <div class="d-flex justify-content-center">
            {{ $vacancies->appends(['q' => $q])->links() }}
          </div>
        @endif

      @else
        <div class="empty-state">
          <div class="empty-title">{{ ($q ?? '') !== '' ? 'Axtardığınız üzrə nəticə tapılmadı' : 'Hələ vakansiya əlavə edilməyib' }}</div>
          <div class="empty-desc">
            @if(($q ?? '') !== '')
              “{{ $q }}” üçün uyğun vakansiya tapılmadı. Başqa açar sözlə yoxlayın.
            @else
              Tezliklə yeni vakansiyalar burada görünəcək.
            @endif
          </div>
          @if(($q ?? '') !== '')
          <div class="td_height_20"></div>
          <a href="{{ route('vacancies') }}" class="td_btn td_style_2 td_radius_10 td_medium">
            <span class="td_btn_in td_heading_color td_white_bg"><span>Hamısını göstər</span></span>
          </a>
          @endif
        </div>
      @endif

      <div class="td_height_60 td_height_lg_40"></div>
    </div>
    <div class="td_height_120 td_height_lg_80"></div>
  </section>
@endsection
