@extends('layouts.app')

@php
  use Illuminate\Support\Str;

  $sl = $vacancy->socialLink;
  $twitter   = $sl->twitterurl  ?? null;
  $facebook  = $sl->facebookurl ?? null;
  $linkedin  = $sl->linkedinurl ?? null;
  $emailLink = $sl->emailurl    ?? null;
  $waLink    = $sl->whatsappurl ?? null;
@endphp

@push('styles')
<style>
  /* Hero / main card */
  .vac-hero{border-radius:14px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,.08)}
  .vac-hero img{width:100%; height:440px; object-fit:cover}

  .badge-views{
    display:inline-flex; align-items:center; gap:.4rem; padding:.35rem .6rem;
    border-radius:999px; background:rgba(13,110,253,.1); color:#0d6efd; font-weight:700
  }

  /* Sidebar card */
  .side-card{border-radius:14px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,.06)}
  .side-card .side-in{padding:18px 18px}

  /* Social buttons — animated/brand */
  .social-btns{display:flex; flex-wrap:wrap; gap:10px}
  .social-btn{
    --ring: 0 0 0 0 rgba(0,0,0,0);
    position:relative; display:inline-flex; align-items:center; gap:.6rem;
    padding:.75rem 1rem; border-radius:12px; font-weight:800; text-decoration:none; line-height:1;
    background:#0e132a; color:#fff; box-shadow:var(--ring), 0 8px 20px rgba(14,19,42,.18);
    transform:translateY(0); transition:transform .2s ease, box-shadow .25s ease, background .25s ease, color .25s ease;
  }
  .social-btn:focus-visible{outline:none; box-shadow:0 0 0 3px rgba(13,110,253,.4)}
  .social-btn:hover{ transform:translateY(-3px); box-shadow:0 12px 28px rgba(14,19,42,.22) }
  .social-btn i{font-size:1rem}

  .btn-x     {background:#0f172a}
  .btn-fb    {background:#1877F2}
  .btn-li    {background:#0A66C2}
  .btn-mail  {background:#ef4444}
  .btn-wa    {background:#25D366}

  .btn-x:hover{--ring:0 0 0 6px rgba(15,23,42,.12)}
  .btn-fb:hover{--ring:0 0 0 6px rgba(24,119,242,.18)}
  .btn-li:hover{--ring:0 0 0 6px rgba(10,102,194,.18)}
  .btn-mail:hover{--ring:0 0 0 6px rgba(239,68,68,.18)}
  .btn-wa:hover{--ring:0 0 0 6px rgba(37,211,102,.18)}

  .social-btn::after{
    content:""; position:absolute; inset:0; border-radius:12px;
    background:linear-gradient(120deg, transparent 30%, rgba(255,255,255,.25) 50%, transparent 70%);
    transform:translateX(-120%); transition:transform .6s ease;
  }
  .social-btn:hover::after{ transform:translateX(120%) }

  /* Content */
  .vacancy-content p{margin-bottom:1rem}
  .vacancy-content img{max-width:100%; height:auto; border-radius:10px}
</style>
@endpush

@section('content')
  {{-- Heading --}}
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
           data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">{{ $vacancy->name }}</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('vacancies') }}">Vacancies</a></li>
          <li class="breadcrumb-item active">{{ Str::limit($vacancy->name, 40) }}</li>
        </ol>
      </div>
    </div>
  </section>

  <section>
    <div class="td_height_120 td_height_lg_80"></div>
    <div class="container">
      <div class="row td_gap_y_30">
        {{-- MAIN --}}
        <div class="col-lg-8">
          <div class="vac-hero td_white_bg td_radius_10 td_mb_20">
            @if($vacancy->imageUrl)
              <img src="{{ $vacancy->imageUrl }}" alt="{{ $vacancy->name }}">
            @endif

            <div class="p-3 p-md-4">
              <div class="d-flex align-items-center justify-content-between td_mb_10">
                <span class="badge-views">
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>
                  </svg>
                  {{ number_format($vacancy->views) }}
                </span>

                @if($vacancy->courseUrl)
                  <a href="{{ $vacancy->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
                    <span class="td_btn_in td_heading_color td_white_bg"><span>Apply / Visit</span></span>
                  </a>
                @endif
              </div>

              <div class="vacancy-content td_content td_fs_18 td_heading_color td_opacity_9">
                {!! $vacancy->description !!}
              </div>
            </div>
          </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">
          {{-- About --}}
          <div class="side-card td_white_bg td_radius_10">
            <div class="side-in">
              <h3 class="td_fs_24 td_mb_16">About this vacancy</h3>
              <ul class="td_mp_0 td_fs_18 td_heading_color td_mb_0">
                <li class="td_mb_10"><b>Category:</b> {{ $vacancy->category->name ?? ($vacancy->category ?? 'Vacancy') }}</li>
                <li><b>Updated:</b> {{ optional($vacancy->updated_at)->format('d.m.Y H:i') }}</li>
              </ul>
            </div>
          </div>

          {{-- Social buttons (RIGHT SIDEBAR) --}}
          @if($twitter || $facebook || $linkedin || $emailLink || $waLink)
            <div class="td_height_30"></div>
            <div class="side-card td_white_bg td_radius_10">
              <div class="side-in">
                <h3 class="td_fs_24 td_mb_16">Follow / Contact</h3>
                <div class="social-btns">
                  @if($twitter)
                    <a href="{{ $twitter }}" target="_blank" rel="noopener" class="social-btn btn-x">
                      <i class="fa-brands fa-x-twitter"></i> <span>Twitter</span>
                    </a>
                  @endif
                  @if($facebook)
                    <a href="{{ $facebook }}" target="_blank" rel="noopener" class="social-btn btn-fb">
                      <i class="fa-brands fa-facebook-f"></i> <span>Facebook</span>
                    </a>
                  @endif
                  @if($linkedin)
                    <a href="{{ $linkedin }}" target="_blank" rel="noopener" class="social-btn btn-li">
                      <i class="fa-brands fa-linkedin-in"></i> <span>LinkedIn</span>
                    </a>
                  @endif
                  @if($emailLink)
                    <a href="{{ $emailLink }}" class="social-btn btn-mail">
                      <i class="fa-solid fa-envelope"></i> <span>Email</span>
                    </a>
                  @endif
                  @if($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="social-btn btn-wa">
                      <i class="fa-brands fa-whatsapp"></i> <span>WhatsApp</span>
                    </a>
                  @endif
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>

      {{-- Related Vacancies --}}
      @if($relatedVacancies->count())
        <div class="td_height_60 td_height_lg_40"></div>
        <h2 class="td_fs_36 td_mb_30">Related Vacancies</h2>
        <div class="row td_gap_y_30 td_row_gap_30">
          @foreach($relatedVacancies as $rc)
            <div class="col-lg-4 col-md-6">
              <div class="td_card td_style_3 td_radius_10">
                <a href="{{ route('vacancies-details', $rc->id) }}" class="td_card_thumb">
                  <img src="{{ $rc->imageUrl ?? asset('assets/img/placeholder/placeholder-800x500.jpg') }}"
                       alt="{{ $rc->name }}"
                       style="width:100%;height:220px;object-fit:cover;border-radius:10px 10px 0 0;">
                </a>
                <div class="td_card_info td_white_bg">
                  <div class="td_card_info_in">
                    <a href="{{ route('vacancies') }}" class="td_card_category td_fs_14 td_bold td_heading_color td_mb_10">
                      <span>{{ $rc->category->name ?? ($rc->category ?? 'Vacancy') }}</span>
                    </a>
                    <h3 class="td_card_title td_fs_22 td_mb_10">
                      <a href="{{ route('vacancies-details', $rc->id) }}">{{ $rc->name }}</a>
                    </h3>
                    @php $rcd = strip_tags($rc->description ?? ''); @endphp
                    @if($rcd)
                      <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_16">{{ Str::limit($rcd, 120) }}</p>
                    @endif
                    <div class="d-flex gap-2">
                      <a href="{{ route('vacancies-details', $rc->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                        <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                      </a>
                      @if($rc->courseUrl)
                        <a href="{{ $rc->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
                          <span class="td_btn_in td_heading_color td_white_bg"><span>Apply / Visit</span></span>
                        </a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <div class="td_height_120 td_height_lg_80"></div>
    </div>
  </section>
@endsection
