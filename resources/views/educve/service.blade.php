@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $q = $q ?? request('q');
@endphp

@push('styles')
<style>
  /* ==== PAGE SCOPE ==== */
  .services-page{
    --thumb-h: 260px;           /* desktop üçün kart şəkil hündürlüyü */
    --thumb-h-sm: 220px;        /* mobil/tablet üçün */
    --card-min-h: 520px;        /* kartın minimum hündürlüyü (vizual balans üçün) */
    --reveal-distance: 22px;
    --reveal-duration: .72s;
    --reveal-stagger: 80ms;
  }
  @media (max-width: 991.98px){
    .services-page{
      --thumb-h: var(--thumb-h-sm);
      --reveal-distance: 16px;
    }
  }

  /* ==== AXTARIŞ ZOLAĞI (yalnız UI) ==== */
  .services-page .ui-search {
    max-width: 820px; margin: 0 auto 10px auto;
    border-radius: 14px;
    background: linear-gradient(180deg, rgba(255,255,255,.75), rgba(255,255,255,.6));
    backdrop-filter: blur(6px);
    box-shadow: 0 10px 28px rgba(15,23,42,.10);
    padding: 10px;
  }
  .services-page .ui-search .input-group{
    border: 1px solid rgba(2,6,23,.08);
    border-radius: 12px; overflow: hidden;
    background: #fff;
  }
  .services-page .ui-search .form-control{
    border: none; padding: 14px 16px; font-size: 16px;
  }
  .services-page .ui-search .btn{ border: none; height: 48px; display: inline-flex; align-items:center; gap:8px; }
  .services-page .ui-search .btn.btn-primary{
    background: linear-gradient(135deg,#7c3aed 0%,#2563eb 50%,#22c55e 100%);
  }
  .services-page .ui-search .btn.btn-outline-secondary{
    background: #f8fafc; border-left: 1px solid rgba(2,6,23,.06);
  }

  /* ==== KARTLAR: ÖLÇÜLƏRİN STANDARTLAŞDIRILMASI ==== */
  /* Kartın özünü tam hündürlükdə saxlayırıq ki, sütunlarda eyni olsun */
  .services-page .td_card{ display:flex; flex-direction:column; min-height: var(--card-min-h); height: 100%; }
  /* Thumb sahəsi sabit hündürlükdə — bütün kartlarda eyni kəsim */
  .services-page .td_card .td_card_thumb img{
    width:100%;
    height: var(--thumb-h);
    object-fit: cover;
  }
  /* Başlıq-mətn hissəsi kart daxilində qalan sahəni tutsun */
  .services-page .td_card .td_card_info{ display:flex; flex-direction:column; flex: 1; }
  .services-page .td_card .td_card_info_in{ display:flex; flex-direction:column; height:100%; }
  /* Mətni daha səliqəli bərabərləşdirmək üçün clamp (istəsən silə bilərsən) */
  .services-page .td_card .td_card_title{ display:-webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow:hidden; }
  .services-page .td_card p{ display:-webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow:hidden; }

  /* ==== KARTLAR: ANİMASİYA ==== */
  .services-page .td_card{
    opacity: 0;
    transform: translateY(var(--reveal-distance));
    will-change: transform, opacity;
  }
  /* “.play” sinfi əlavə olunanda animasiyanı işə salırıq */
  .services-page.play .td_card{
    animation: revealIn var(--reveal-duration) cubic-bezier(.2,.65,.2,1) forwards;
    animation-delay: var(--reveal-delay, 0ms);
  }
  @keyframes revealIn{
    from{ opacity: 0; transform: translateY(var(--reveal-distance)); }
    to  { opacity: 1; transform: translateY(0); }
  }
</style>
@endpush

@section('content')
<div class="services-page" id="services-page">
  <!-- Page Heading -->
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
           data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">Services</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Services</li>
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
  <!-- End Page Heading -->

  <!-- Services List -->
  <section>
    <div class="td_height_120 td_height_lg_80"></div>
    <div class="container">

      {{-- Search --}}
      <div class="td_mb_30 ui-search" role="search" aria-label="Service search wrapper">
        <form action="{{ route('services') }}" method="GET" role="search" aria-label="Service search">
          <div class="input-group">
            <input
              type="text"
              name="q"
              class="form-control"
              placeholder="Search services by name or description..."
              value="{{ $q }}"
              autocomplete="off"
              aria-label="Search services"
            >
            @if($q)
              <a href="{{ route('services') }}" class="btn btn-outline-secondary" aria-label="Clear search">
                <i class="fa-solid fa-xmark"></i><span class="d-none d-md-inline"> Clear</span>
              </a>
            @endif
            <button class="btn btn-primary" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
              <span class="d-none d-md-inline">Search</span>
            </button>
          </div>
        </form>
        @if($q !== null && $q !== '')
          <div class="text-center td_mt_10 td_opacity_8">
            Showing <b>{{ method_exists($services,'total') ? $services->total() : $services->count() }}</b> result(s) for “{{ $q }}”
          </div>
        @endif
      </div>

      @if($services->count() > 0)
        <div class="row td_gap_y_30 js-cards">
          @foreach($services as $idx => $svc)
            <div class="col-lg-6 d-flex"><!-- d-flex ki, kart h-100 olsun -->
              <div class="td_card td_style_1 td_radius_5 w-100 h-100" style="--reveal-delay: {{ $idx * 80 }}ms">
                <a href="{{ route('service-details', $svc->id) }}" class="td_card_thumb td_mb_30 d-block position-relative">
                  <img
                    src="{{ $svc->imageUrl ?: asset('assets/img/placeholder/placeholder-800x500.jpg') }}"
                    alt="{{ $svc->name }}"
                  >
                  <i class="fa-solid fa-arrow-up-right-from-square"></i>

                  {{-- small chip --}}
                  <span class="td_card_location td_medium td_white_color td_fs_18">
                    <svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.0004 0.5C3.86669 0.5 0.554996 3.86526 0.500458 7.98242C0.48345 9.42271 0.942105 10.7046 1.56397 11.8232C2.76977 13.9928 4.04435 16.8182 5.32856 19.4639C5.9286 20.7002 6.89863 21.5052 8.0004 21.5C9.10217 21.4948 10.0665 20.6836 10.6575 19.4404C11.9197 16.7856 13.1685 13.9496 14.4223 11.835C15.1136 10.6691 15.4653 9.3606 15.4974 8.01758C15.5966 3.86772 12.1342 0.5 8.0004 0.5ZM8.0004 2.00586C11.3235 2.00586 14.0821 4.6775 14.0033 7.97363C13.9749 9.08002 13.6796 10.1416 13.1273 11.0732C11.7992 13.3133 10.5449 16.1706 9.2954 18.7988C8.85773 19.7191 8.35538 19.9924 7.98864 19.9941C7.62183 19.9959 7.12572 19.7246 6.68204 18.8105C5.41121 16.1923 4.12648 13.3534 2.87056 11.0938C2.32971 10.121 1.9798 9.11653 1.9946 8.00586C2.03995 4.67555 4.67723 2.00586 8.0004 2.00586ZM8.0004 4.25C5.94024 4.25 4.25034 5.94266 4.25034 8.00586C4.25034 10.0691 5.94024 11.75 8.0004 11.75C10.0605 11.75 11.7503 10.0691 11.7503 8.00586C11.7503 5.94266 10.0605 4.25 8.0004 4.25ZM8.0004 5.74414C9.25065 5.74414 10.2446 6.75372 10.2446 8.00586C10.2446 9.258 9.25065 10.2559 8.0004 10.2559C6.7501 10.2559 5.75331 9.258 5.75331 8.00586C5.75331 6.75372 6.7501 5.74414 8.0004 5.74414Z" fill="currentColor"/>
                    </svg>
                    {{ $svc->category->name ?? ($svc->category ?? 'Service') }}
                  </span>
                </a>

                <div class="td_card_info">
                  <div class="td_card_info_in">
                    <div class="td_mb_30">
                      <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                        <li>
                          {{-- Updated date --}}
                          <svg class="td_accent_color" width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.3308 11.7869H19.0049C19.3833 11.7869 19.6913 11.479 19.6913 11.1005V9.42642C19.6913 9.04795 19.3833 8.74003 19.0049 8.74003H17.3308C16.9523 8.74003 16.6444 9.04795 16.6444 9.42642V11.1005C16.6444 11.479 16.9523 11.7869 17.3308 11.7869ZM17.3475 9.44316H18.9881V11.0838H17.3475V9.44316ZM17.3308 16.24H19.0049C19.3833 16.24 19.6913 15.9321 19.6913 15.5536V13.8795C19.6913 13.5011 19.3833 13.1932 19.0049 13.1932H17.3308C16.9523 13.1932 16.6444 13.5011 16.6444 13.8795V15.5536C16.6444 15.9321 16.9523 16.24 17.3308 16.24ZM17.3475 13.8963H18.9881V15.5369H17.3475V13.8963ZM12.5535 11.7869H14.2276C14.606 11.7869 14.914 11.479 14.914 11.1005V9.42642C14.914 9.04795 14.606 8.74003 14.2276 8.74003H12.5535C12.175 8.74003 11.8671 9.04795 11.8671 9.42642V11.1005C11.8671 11.479 12.175 11.7869 12.5535 11.7869ZM12.5702 9.44316H14.2108V11.0838H12.5702V9.44316Z" fill="currentColor"/>
                          </svg>
                          <span>{{ optional($svc->updated_at)->format('M d, Y') }}</span>
                        </li>
                        <li>
                          {{-- Views --}}
                          <svg class="td_accent_color" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>
                          </svg>
                          <span>{{ number_format($svc->views ?? 0) }} views</span>
                        </li>
                      </ul>
                    </div>

                    <h2 class="td_card_title td_fs_32 td_semibold td_mb_20">
                      <a href="{{ route('service-details', $svc->id) }}">{{ $svc->name }}</a>
                    </h2>

                    @php $desc = strip_tags($svc->description ?? ''); @endphp
                    <p class="td_mb_30 td_fs_18">
                      {{ $desc ? Str::limit($desc, 180) : ' ' }}
                    </p>

                    <div class="mt-auto d-flex gap-2">
                      <a href="{{ route('service-details', $svc->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                        <span class="td_btn_in td_white_color td_accent_bg">
                          <span>Learn More</span>
                          <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                          </svg>
                        </span>
                      </a>

                      @if(!empty($svc->courseUrl))
                        <a href="{{ $svc->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
                          <span class="td_btn_in td_heading_color td_white_bg"><span>Visit</span></span>
                        </a>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
            </div>
          @endforeach
        </div>

        {{-- Pagination --}}
        @if(method_exists($services,'links'))
          <div class="td_height_60 td_height_lg_40"></div>
          <div class="text-center">
            {{ $services->appends(['q' => $q])->links() }}
          </div>
        @endif

      @else
        {{-- Empty state --}}
        <div class="text-center td_opacity_8">
          @if($q)
            No services found for “{{ $q }}”.
            <div class="td_height_10"></div>
            <a href="{{ route('services') }}" class="td_btn td_style_2 td_radius_10 td_medium">
              <span class="td_btn_in td_heading_color td_white_bg"><span>Show All</span></span>
            </a>
          @else
            No services added yet.
          @endif
        </div>
      @endif

    </div>
    <div class="td_height_120 td_height_lg_80"></div>
  </section>
  <!-- End Services List -->
</div>
@endsection

@push('scripts')
<script>
  // Səhifə yüklənəndə kart animasiyasını MÜTLƏQ göstər
  document.addEventListener('DOMContentLoaded', function(){
    const host = document.getElementById('services-page');
    if(!host) return;

    // Kiçik gecikmə ilə .play sinfini veririk (paint-dən sonra)
    setTimeout(() => {
      host.classList.add('play');
    }, 50);
  });
</script>
@endpush
