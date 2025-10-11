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
  /* STANDART ŞƏKİL VİTRİNİ (sabit hündürlük, şəkil contain ilə miqyaslanır) */
  .course-thumb{
    position: relative;
    border-radius: 10px;
    background:#f6f7f9;
    height: 520px;             /* Desktop üçün vitrin hündürlüyü */
    overflow: hidden;
  }
  @media (max-width: 991.98px){ .course-thumb{ height: 380px; } }  /* Tablet */
  @media (max-width: 575.98px){ .course-thumb{ height: 260px; } }  /* Mobil  */

  /* Şəkil kəsilmədən vitrinin içinə sığsın */
  .course-thumb img{
    width: 100%;
    height: 100%;
    object-fit: contain;       /* KƏSMƏDƏN sığdırır */
    display: block;
  }

  /* Video da vitrinə sığsın – maksimum hündürlük 100% */
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

  /* Sosial butonlar */
  .social-btns{display:flex; flex-wrap:wrap; gap:.6rem;}
  .social-btns a{
    display:inline-flex; align-items:center; gap:.5rem;
    border-radius:999px; padding:.55rem .9rem; font-weight:600;
    text-decoration:none; border:1px solid var(--td-border, #e8e8e8);
  }

  /* Related – eyni hündürlük */
  .equal-card{display:flex;flex-direction:column;height:100%;}
  .equal-card .td_card_thumb{display:block;position:relative;overflow:hidden;border-radius:10px}
  .equal-card .td_card_info{flex:1;display:flex;flex-direction:column}
  .equal-card .td_card_info_in{flex:1;display:flex;flex-direction:column}
  .equal-card .td_card_title{min-height:56px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
  .equal-card .td_card_subtitle{min-height:72px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
  .equal-card .btn-row{margin-top:auto;display:flex;gap:.5rem;align-items:center}
</style>

{{-- ====== HEADER, PAGE HEADING eynidir (sənəddə saxlanılıb) ====== --}}

<!-- Course Details -->
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
            <div class="td_mb_50">
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

          <h2 class="td_fs_36 td_mb_20">What you’ll learn</h2>
          <ul class="td_list td_style_2 td_type_2 td_fs_18 td_medium td_heading_color td_mp_0">
            @forelse(($course->bullets ?? []) as $bullet)
              <li>
                <svg class="td_accent_color" width="24" height="24"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="12" r="12" fill="currentColor"></circle>
                  <path d="M7.5 14.1136C7.5 14.1136 8.52273 14.1136 9.88636 16.5C9.88636 16.5 13.6765 10.25 17.0455 9" stroke="white" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                {{ $bullet }}
              </li>
            @empty
              <li>Practical, project-based learning</li>
              <li>Up-to-date tools and workflows</li>
              <li>Career-oriented guidance</li>
            @endforelse
          </ul>
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
