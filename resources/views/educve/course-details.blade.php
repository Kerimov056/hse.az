@extends('layouts.app')

@php
    use Illuminate\Support\Str;

    $title       = $course->name             ?? 'Course Title';
    $category    = $course->category->name   ?? ($course->category ?? 'General');
    $trainer     = $course->trainer->name    ?? ($course->trainer_name ?? 'Instructor');
    $updatedAt   = $course->updated_at       ?? now();
    $updatedTxt  = \Illuminate\Support\Carbon::parse($updatedAt)->format('d M, Y');
    $thumb       = $course->imageUrl         ?? asset('assets/img/placeholder/placeholder-800x500.jpg');
    $views       = $course->views            ?? 0;
    $videoUrl    = $course->video_url        ?? null;
    $description = $course->description      ?? 'No description provided yet.';

    // social links
    $sl = $course->socialLink ?? null;
    $twitter   = $sl?->twitterurl;
    $facebook  = $sl?->facebookurl;
    $linkedin  = $sl?->linkedinurl;

    $emailRaw  = $sl?->emailurl;
    $emailLink = $emailRaw
        ? (Str::startsWith($emailRaw, ['mailto:', 'http']) ? $emailRaw : 'mailto:'.$emailRaw)
        : null;

    $waRaw     = $sl?->whatsappurl;
    $waLink    = null;
    if ($waRaw) {
        $waLink = Str::startsWith($waRaw, ['http', 'https'])
            ? $waRaw
            : ('https://wa.me/'.preg_replace('/\D+/', '', $waRaw));
    }
@endphp

<style>
  .course-thumb{
    position: relative;
    border-radius: 10px;
    background:#f6f7f9;
    height: 520px;
    overflow: hidden;
  }
  @media (max-width: 991.98px){ .course-thumb{ height: 380px; } }
  @media (max-width: 575.98px){ .course-thumb{ height: 260px; } }

  .course-thumb img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
  }

  .course-thumb iframe{
    width: 100%;
    aspect-ratio: 16/9;
    height: auto;
    max-height: 100%;
    display: block;
  }

  .views-badge {
    position: absolute; top: 10px; left: 10px;
    background: rgba(0,0,0,0.6); color:#fff; font-weight:600;
    font-size:13px; line-height:1; padding:6px 10px; border-radius: 999px;
    display:inline-flex; align-items:center; gap:6px; z-index:2;
  }
  .views-badge svg{ width:16px; height:16px; }

  .social-btns{display:flex; flex-wrap:wrap; gap:.6rem;}
  .social-btns a{
    display:inline-flex; align-items:center; gap:.5rem;
    border-radius:999px; padding:.55rem .9rem; font-weight:600;
    text-decoration:none; border:1px solid var(--td-border, #e8e8e8);
  }

  .equal-card{display:flex;flex-direction:column;height:100%;}
  .equal-card .td_card_thumb{display:block;position:relative;overflow:hidden;border-radius:10px}
  .equal-card .td_card_info{flex:1;display:flex;flex-direction:column}
  .equal-card .td_card_info_in{flex:1;display:flex;flex-direction:column}
  .equal-card .td_card_title{min-height:56px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
  .equal-card .td_card_subtitle{min-height:72px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
  .equal-card .btn-row{margin-top:auto;display:flex;gap:.5rem;align-items:center}

  /* Register block */
  .register-box{
    border:1px solid rgba(0,0,0,.08);
    border-radius: 12px;
    padding: 18px;
    background: #fff;
  }
  .register-box .mini{
    opacity:.8;
    font-size: 14px;
    margin:0;
  }
</style>

<section style="margin-top: 50px">
  <div class="td_height_120 td_height_lg_80"></div>
  <div class="container">
    <div class="row td_gap_y_50">
      <div class="col-lg-10 mx-auto">
        <div class="td_course_details">

          <div class="course-thumb td_radius_10 td_mb_30">
            <span class="views-badge" title="Views">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
              </svg>
              {{ $views }}
            </span>

            @if($videoUrl)
              <iframe class="embed-responsive-item" src="{{ $videoUrl }}" allowfullscreen></iframe>
            @else
              <img src="{{ $thumb }}" alt="{{ $title }}">
            @endif
          </div>

          <span class="td_course_label td_mb_10">{{ $category }}</span>
          <h2 class="td_fs_48 td_mb_10">{{ $title }}</h2>

          <div class="d-flex flex-wrap align-items-center gap-3 td_mb_30">
            <div class="d-flex align-items-center gap-2">
              <img src="{{ $course->trainer->avatar ?? asset('assets/img/others/author_1.jpg') }}" alt="" style="width:40px;height:40px;border-radius:50%;object-fit:cover">
              <p class="td_heading_color mb-0 td_medium">
                <span class="td_accent_color">Trainer:</span> <a href="#">{{ $trainer }}</a>
              </p>
            </div>
            <div class="td_medium td_heading_color">
              <span class="td_accent_color">Last Update:</span> {{ $updatedTxt }}
            </div>
          </div>

          {{-- Description --}}
          <div class="td_mb_40">
            <h3 class="td_fs_36 td_mb_15">Description</h3>
            @if(!empty($course->description))
              {!! $description !!}
            @else
              <p class="mb-0">{{ $description }}</p>
            @endif
          </div>

          {{-- Social links --}}
          @if($twitter || $facebook || $linkedin || $emailLink || $waLink)
            <div class="td_mb_40">
              <h3 class="td_fs_24 td_semibold td_mb_15">Follow / Contact</h3>
              <div class="social-btns">
                @if($twitter)
                  <a href="{{ $twitter }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-x-twitter"></i> Twitter
                  </a>
                @endif
                @if($facebook)
                  <a href="{{ $facebook }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-facebook-f"></i> Facebook
                  </a>
                @endif
                @if($linkedin)
                  <a href="{{ $linkedin }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-linkedin-in"></i> LinkedIn
                  </a>
                @endif
                @if($emailLink)
                  <a href="{{ $emailLink }}">
                    <i class="fa-solid fa-envelope"></i> Email
                  </a>
                @endif
                @if($waLink)
                  <a href="{{ $waLink }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                  </a>
                @endif
              </div>
            </div>
          @endif

          {{-- ✅ Register block --}}
          @if(($course->type ?? null) === \App\Models\Course::TYPE_COURSE)
            <div class="td_mb_50">
              <div class="register-box">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                  <div>
                    <h3 class="td_fs_24 td_semibold mb-1">Registration</h3>
                    <p class="mini mb-0">Fill the form and submit your registration for this course.</p>
                  </div>

                  <a href="{{ route('courses.register', $course->id) }}"
                     class="td_btn td_style_1 td_radius_10 td_medium">
                    <span class="td_btn_in td_white_color td_accent_bg">
                      <span>Register</span>
                    </span>
                  </a>
                </div>
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</section>

{{-- Related Courses – max 3 card --}}
@php
  $rel = collect($relatedCourses ?? [])->take(3);
@endphp

<section>
  <div class="td_height_60 td_height_lg_60"></div>
  <div class="container">
    <h2 class="td_fs_48 td_mb_50">Courses you may like</h2>

    <div class="row td_gap_y_30 td_row_gap_30">
      @forelse($rel as $rc)
        <div class="col-lg-4 col-md-6 d-flex">
          <div class="td_card td_style_3 td_radius_10 equal-card w-100">
            <a href="{{ route('course-details', $rc->id) }}" class="td_card_thumb">
              <span class="views-badge" title="Views">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
                </svg>
                {{ $rc->views ?? 0 }}
              </span>
              <img src="{{ $rc->imageUrl ?? asset('assets/img/placeholder/placeholder-800x500.jpg') }}"
                   alt="{{ $rc->name ?? 'Course' }}"
                   style="width:100%;height:220px;object-fit:cover">
            </a>

            <div class="td_card_info td_white_bg">
              <div class="td_card_info_in">
                <a href="{{ route('courses-grid-view') }}" class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                  <span>{{ $rc->category->name ?? ($rc->category ?? 'General') }}</span>
                </a>

                <h2 class="td_card_title td_fs_24 td_mb_16">
                  <a href="{{ route('course-details', $rc->id) }}">{{ $rc->name ?? 'Course title' }}</a>
                </h2>

                @php $rcDesc = strip_tags($rc->description ?? ''); @endphp
                @if($rcDesc)
                  <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                    {{ Str::limit($rcDesc, 140) }}
                  </p>
                @else
                  <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20"> </p>
                @endif

                <div class="btn-row">
                  <a href="{{ route('course-details', $rc->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                    <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                  </a>

                  @if(!empty($rc->courseUrl))
                    <a href="{{ $rc->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
                      <span class="td_btn_in td_heading_color td_white_bg"><span>Visit</span></span>
                    </a>
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-light border text-center">No related courses yet.</div>
        </div>
      @endforelse
    </div>
  </div>
  <div class="td_height_120 td_height_lg_80"></div>
</section>

{{-- INFO TOAST – course üçün --}}
@include('partials.info-toast', ['text' => $course->info ?? null])

{{-- Success Toast (after registration) --}}
@if(session('ok'))
  <div id="regToastBackdrop" style="
      position:fixed; inset:0; background:rgba(0,0,0,.35);
      display:flex; align-items:center; justify-content:center;
      z-index:9999; padding:16px;
  ">
    <div id="regToast" style="
        width:min(520px, 100%);
        background:#fff; border-radius:14px;
        box-shadow:0 20px 70px rgba(0,0,0,.25);
        overflow:hidden;
        border:1px solid rgba(0,0,0,.08);
    ">
      <div style="padding:18px 18px 10px 18px; display:flex; gap:12px; align-items:flex-start;">
        <div style="
            width:42px; height:42px; border-radius:12px;
            background:#e9f7ef; display:flex; align-items:center; justify-content:center;
            flex:0 0 auto;
        ">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 6L9 17L4 12" stroke="#1e8e3e" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>

        <div style="flex:1 1 auto;">
          <div style="font-weight:900; font-size:18px; margin-bottom:4px;">Registration received</div>
          <div style="opacity:.8; font-size:14px; line-height:1.4;">
            {{ session('ok') }}
          </div>
        </div>

        <button type="button" id="regToastCloseBtn" aria-label="Close" style="
            border:0; background:transparent; font-size:22px; line-height:1;
            padding:0 4px; cursor:pointer; opacity:.65;
        ">×</button>
      </div>

      <div style="padding:0 18px 18px 18px; display:flex; gap:10px; justify-content:flex-end;">
        <button type="button" id="regToastOkBtn" class="td_btn td_style_1 td_radius_10 td_medium">
          <span class="td_btn_in td_white_color td_accent_bg">
            <span>OK</span>
          </span>
        </button>
      </div>
    </div>
  </div>

  <script>
    (function () {
      const backdrop = document.getElementById('regToastBackdrop');
      const closeBtn = document.getElementById('regToastCloseBtn');
      const okBtn = document.getElementById('regToastOkBtn');

      function closeToast() {
        if (!backdrop) return;
        backdrop.style.opacity = '0';
        backdrop.style.transition = 'opacity .18s ease';
        setTimeout(() => backdrop.remove(), 180);
      }

      // close by buttons
      if (closeBtn) closeBtn.addEventListener('click', closeToast);
      if (okBtn) okBtn.addEventListener('click', closeToast);

      // close by click outside
      if (backdrop) {
        backdrop.addEventListener('click', function (e) {
          if (e.target === backdrop) closeToast();
        });
      }

      // auto close after 4.5s
      setTimeout(closeToast, 4500);
    })();
  </script>
@endif
