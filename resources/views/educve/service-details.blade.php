@extends('layouts.app')

@php
  use Illuminate\Support\Str;

  // Social links (safe access)
  $sl       = $service->socialLink ?? null;
  $twitter  = $sl->twitterurl  ?? null;
  $facebook = $sl->facebookurl ?? null;
  $linkedin = $sl->linkedinurl ?? null;
  $emailLink= $sl->emailurl    ?? null;
  $waLink   = $sl->whatsappurl ?? null;
@endphp

@push('styles')
<style>
/* ==== SOCIAL CARD (sidebar) ==== */
.sd-card{border-radius:14px;overflow:hidden;box-shadow:0 10px 28px rgba(15,23,42,.08)}
.sd-card .td_card_info_in{padding:22px}

/* gradient border wrapper */
.gradient-border{
  position:relative;border-radius:14px;padding:1px;background:
  linear-gradient(135deg,#7c3aed 0%,#2563eb 35%,#22c55e 70%,#f59e0b 100%);
}
.gradient-border > .gb-in{
  border-radius:13px;background:#fff;
}

/* --- SOCIAL BUTTONS --- */
.social-btns{display:flex;flex-wrap:wrap;gap:.6rem}
.social-btn{
  --ring: rgba(16,24,40,.06);
  display:inline-flex;align-items:center;gap:.6rem;
  height:42px;padding:0 14px;border-radius:999px;border:0;
  font-weight:800;font-size:.95rem;line-height:1;cursor:pointer;
  background:#fff;color:#0f172a;box-shadow:0 8px 18px var(--ring);
  position:relative;overflow:hidden;text-decoration:none;
  transition:transform .18s ease, box-shadow .18s ease, background .18s ease;
  isolation:isolate;
}
.social-btn .ico{
  width:20px;height:20px;display:inline-grid;place-items:center;
  border-radius:50%;background:#0f172a0a;
}
.social-btn:hover{transform:translateY(-2px);box-shadow:0 16px 30px rgba(16,24,40,.16)}
.social-btn:active{transform:translateY(0) scale(.98)}

/* sheen sweep */
.social-btn::after{
  content:"";position:absolute;inset:-120% -40%;transform:rotate(18deg);
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.6),transparent);
  transition:transform .6s ease;opacity:.6;z-index:-1;
}
.social-btn:hover::after{transform:translateX(60%) rotate(18deg)}

/* brand variants */
.btn-x      {background:#0a0a0a;color:#fff}
.btn-x .ico {background:#ffffff1a}
.btn-fb     {background:#1877F2;color:#fff}
.btn-li     {background:#0A66C2;color:#fff}
.btn-mail   {background:#F1F5F9;color:#0f172a}
.btn-wa     {background:#25D366;color:#063b22}
.btn-outline{background:#fff;border:1px solid #e7ecf3}

/* pulse ring */
.social-btn:hover .pulse{animation:pulse 1.2s ease-out forwards}
.pulse{
  position:absolute;inset:0;border-radius:inherit;pointer-events:none;
  box-shadow:0 0 0 0 rgba(99,102,241,.0);
}
@keyframes pulse{
  0%   {box-shadow:0 0 0 0 rgba(99,102,241,.22)}
  100% {box-shadow:0 0 0 12px rgba(99,102,241,0)}
}

/* icon-only on very small screens */
@media (max-width:420px){
  .social-btn span.label{display:none}
  .social-btn{padding:0 10px}
}
</style>
@endpush

@section('content')
  {{-- Heading --}}
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
           data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">{{ $service->name }}</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('services') }}">Services</a></li>
          <li class="breadcrumb-item active">{{ Str::limit($service->name, 40) }}</li>
        </ol>
      </div>
    </div>
  </section>

  <section>
    <div class="td_height_120 td_height_lg_80"></div>
    <div class="container">
      <div class="row td_gap_y_30">
        {{-- Main --}}
        <div class="col-lg-8">
          <div class="td_card td_style_1 td_radius_10">
            @if($service->imageUrl)
              <img src="{{ $service->imageUrl }}" alt="{{ $service->name }}"
                   class="w-100" style="border-radius:10px 10px 0 0;object-fit:cover;max-height:420px;">
            @endif
            <div class="td_card_info">
              <div class="td_card_info_in">
                <div class="d-flex align-items-center justify-content-between td_mb_20">
                  <span class="td_medium td_heading_color">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="vertical-align:-3px;">
                      <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                      <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
                    </svg>
                    <span class="ms-1">{{ number_format($service->views) }} views</span>
                  </span>

                  @if($service->courseUrl)
                    <a href="{{ $service->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
                      <span class="td_btn_in td_heading_color td_white_bg"><span>Visit</span></span>
                    </a>
                  @endif
                </div>

                <div class="td_content">
                  {!! $service->description !!}
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
          <div class="td_card td_style_1 td_radius_10">
            <div class="td_card_info">
              <div class="td_card_info_in">
                <h3 class="td_fs_24 td_mb_16">About this service</h3>
                <ul class="td_mp_0 td_fs_18 td_heading_color td_mb_0">
                  <li class="td_mb_10"><b>Category:</b> {{ $service->category->name ?? ($service->category ?? 'Service') }}</li>
                  <li><b>Updated:</b> {{ optional($service->updated_at)->format('d.m.Y H:i') }}</li>
                </ul>
              </div>
            </div>
          </div>

          {{-- Social links (styled buttons) --}}
          @php $hasSocial = $twitter || $facebook || $linkedin || $emailLink || $waLink; @endphp
          @if($hasSocial)
            <div class="td_height_20"></div>
            <div class="gradient-border">
              <div class="gb-in sd-card">
                <div class="td_card_info">
                  <div class="td_card_info_in">
                    <h3 class="td_fs_24 td_mb_16">Follow / Contact</h3>

                    <div class="social-btns">
                      @if($twitter)
                        <a class="social-btn btn-x" href="{{ $twitter }}" target="_blank" rel="noopener" aria-label="Twitter / X">
                          <span class="ico"><i class="fa-brands fa-x-twitter"></i></span>
                          <span class="label">Twitter</span>
                          <i class="pulse"></i>
                        </a>
                      @endif

                      @if($facebook)
                        <a class="social-btn btn-fb" href="{{ $facebook }}" target="_blank" rel="noopener" aria-label="Facebook">
                          <span class="ico"><i class="fa-brands fa-facebook-f"></i></span>
                          <span class="label">Facebook</span>
                          <i class="pulse"></i>
                        </a>
                      @endif

                      @if($linkedin)
                        <a class="social-btn btn-li" href="{{ $linkedin }}" target="_blank" rel="noopener" aria-label="LinkedIn">
                          <span class="ico"><i class="fa-brands fa-linkedin-in"></i></span>
                          <span class="label">LinkedIn</span>
                          <i class="pulse"></i>
                        </a>
                      @endif

                      @if($emailLink)
                        <a class="social-btn btn-mail btn-outline" href="{{ $emailLink }}" aria-label="Email">
                          <span class="ico"><i class="fa-solid fa-envelope"></i></span>
                          <span class="label">Email</span>
                          <i class="pulse"></i>
                        </a>
                      @endif

                      @if($waLink)
                        <a class="social-btn btn-wa" href="{{ $waLink }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                          <span class="ico"><i class="fa-brands fa-whatsapp"></i></span>
                          <span class="label">WhatsApp</span>
                          <i class="pulse"></i>
                        </a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>

      {{-- Related Services --}}
      @if($relatedServices->count())
        <div class="td_height_60 td_height_lg_40"></div>
        <h2 class="td_fs_36 td_mb_30">Related Services</h2>
        <div class="row td_gap_y_30 td_row_gap_30">
          @foreach($relatedServices as $rc)
            <div class="col-lg-4 col-md-6">
              <div class="td_card td_style_3 td_radius_10">
                <a href="{{ route('service-details', $rc->id) }}" class="td_card_thumb">
                  <img src="{{ $rc->imageUrl ?? asset('assets/img/placeholder/placeholder-800x500.jpg') }}"
                       alt="{{ $rc->name }}"
                       style="width:100%;height:220px;object-fit:cover;border-radius:10px 10px 0 0;">
                </a>
                <div class="td_card_info td_white_bg">
                  <div class="td_card_info_in">
                    <a href="{{ route('services') }}" class="td_card_category td_fs_14 td_bold td_heading_color td_mb_10">
                      <span>{{ $rc->category->name ?? ($rc->category ?? 'Service') }}</span>
                    </a>
                    <h3 class="td_card_title td_fs_22 td_mb_10">
                      <a href="{{ route('service-details', $rc->id) }}">{{ $rc->name }}</a>
                    </h3>
                    @php $rcd = strip_tags($rc->description ?? ''); @endphp
                    @if($rcd)
                      <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_16">{{ Str::limit($rcd, 120) }}</p>
                    @endif
                    <div class="d-flex gap-2">
                      <a href="{{ route('service-details', $rc->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                        <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                      </a>
                      @if($rc->courseUrl)
                        <a href="{{ $rc->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
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
      @endif

      <div class="td_height_120 td_height_lg_80"></div>
    </div>
  </section>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />
