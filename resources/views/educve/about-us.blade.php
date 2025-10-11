@extends('layouts.app')

@section('title', 'About Us')

@section('content')
  <!-- Page heading -->
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
           data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">About Us</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">About Us</li>
        </ol>
      </div>
    </div>
    <div class="td_page_heading_shape_1 position-absolute td_hover_layer_3"></div>
    <div class="td_page_heading_shape_2 position-absolute td_hover_layer_5"></div>
    <div class="td_page_heading_shape_3 position-absolute"><img src="{{ asset('assets/img/others/page_heading_shape_3.svg') }}" alt=""></div>
    <div class="td_page_heading_shape_4 position-absolute"><img src="{{ asset('assets/img/others/page_heading_shape_4.svg') }}" alt=""></div>
    <div class="td_page_heading_shape_5 position-absolute"><img src="{{ asset('assets/img/others/page_heading_shape_5.svg') }}" alt=""></div>
    <div class="td_page_heading_shape_6 position-absolute td_hover_layer_3"></div>
  </section>

  <!-- About -->
  <section>
    <div class="td_height_120 td_height_lg_80"></div>
    <div class="td_about td_style_1">
      <div class="container">
        <div class="row align-items-center td_gap_y_40">
          <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.25s">
            <div class="td_about_thumb_wrap">
              <div class="td_about_year text-uppercase td_fs_64 td_bold">EST 1995</div>
              <div class="td_about_thumb_1">
                <img src="{{ asset('assets/img/home_1/about_img_1.jpg') }}" alt="">
              </div>
              <div class="td_about_thumb_2">
                <img src="{{ asset('assets/img/home_1/about_img_2.jpg') }}" alt="">
              </div>
              <a href="https://www.youtube.com/embed/rRid6GCJtgc" class="td_circle_text td_center td_video_open">
                <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.086 8.63792C14.6603 9.03557 14.6603 9.88459 14.086 10.2822L2.54766 18.2711C1.88444 18.7303 0.978418 18.2557 0.978418 17.449L0.978418 1.47118C0.978418 0.664496 1.88444 0.189811 2.54767 0.649016L14.086 8.63792Z" fill="white"/></svg>
                <img src="{{ asset('assets/img/home_1/about_circle_text.svg') }}" alt="">
              </a>
              <div class="td_circle_shape"></div>
            </div>
          </div>

          <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
            <div class="td_section_heading td_style_1 td_mb_30">
              <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">About us</p>
              <h2 class="td_section_title td_fs_48 mb-0">The largest & Most Diverse Universities in the United Emirates</h2>
              <p class="td_section_subtitle td_fs_18 mb-0">Far far away, behind the word mountains, far from the Consonantia, there live the blind texts. Separated they marks grove right at the coast of the Semantics a large language ocean</p>
            </div>

            <div class="td_mb_40">
              <ul class="td_list td_style_5 td_mp_0">
                <li><h3 class="td_fs_24 td_mb_8">Graduate Program</h3><p class="td_fs_18 mb-0">Browse the Undergraduate Degrees</p></li>
                <li><h3 class="td_fs_24 td_mb_8">Undergraduate  Program</h3><p class="td_fs_18 mb-0">Browse the Undergraduate Degrees</p></li>
              </ul>
            </div>

            <a href="{{ url('courses-grid-view') }}" class="td_btn td_style_1 td_radius_10 td_medium">
              <span class="td_btn_in td_white_color td_accent_bg">
                <span>More About</span>
                <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="td_height_120 td_height_lg_80"></div>
  </section>

  <!-- ACCREDITATIONS — Mosaic + Table Accordion -->
  <section style="padding:100px 0;background:linear-gradient(180deg,#890c25 0%,#6e081e 100%);">
    <div class="container">

      <!-- Head -->
      <div style="margin-bottom:24px;">
        <p style="margin:0 0 6px;font-size:18px;letter-spacing:.08em;text-transform:uppercase;color:#fff;font-weight:600;">Accreditation</p>
        <h2 style="margin:0 0 6px;font-size:40px;line-height:1.2;color:#fff;font-weight:800;">Recognitions &amp; Partnerships</h2>
        <p style="margin:0;color:#fff;opacity:.85;font-size:18px;">Our international recognitions and training partners.</p>
      </div>

      <div class="row g-4 align-items-stretch">
        <!-- LEFT: logo mosaic -->
        <div class="col-lg-6">
          @if($accreditations->count())
            <div style="display:grid;gap:14px;grid-template-columns:repeat(3,minmax(0,1fr));">
              @foreach($accreditations->take(6) as $lg)
                <div style="min-height:110px;border-radius:14px;border:1px solid rgba(255,255,255,.22);background:rgba(255,255,255,.12);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;transition:transform .2s,box-shadow .2s,background .2s;">
                  <img src="{{ $lg->imageUrl ?: asset('assets/img/others/faq_bg_1.jpg') }}"
                       alt="{{ $lg->name ?? 'Accreditation' }}"
                       style="max-height:64px;width:auto;object-fit:contain;filter:drop-shadow(0 2px 6px rgba(0,0,0,.15));">
                </div>
              @endforeach
            </div>
          @else
            <div style="color:#fff;opacity:.75">No accreditation data.</div>
          @endif
        </div>

        <!-- RIGHT: compact table accordion -->
        <div class="col-lg-6">
          @if($accreditations->count())
            <div id="accTable"
                 style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(17,24,39,.12);">

              <!-- table head -->
              <div style="display:grid;grid-template-columns:72px 1fr 120px 46px;align-items:center;background:#f8fafc;border-bottom:1px solid #e5e7eb;font-weight:700;color:#111;">
                <div style="padding:12px 14px;">Logo</div>
                <div style="padding:12px 14px;">Accreditation</div>
                <div style="padding:12px 14px;">Date</div>
                <div style="padding:12px 14px;"></div>
              </div>

              @foreach($accreditations as $i => $a)
                <div data-acc-row {{ $i===0 ? 'data-open=1' : '' }}
                     style="display:grid;grid-template-columns:72px 1fr 120px 46px;align-items:center;border-bottom:1px solid #f1f5f9;background:#fff;cursor:pointer;">
                  <!-- logo -->
                  <div style="padding:12px 14px;">
                    <div style="width:44px;height:44px;border-radius:10px;border:1px solid #ececec;background:#fff;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                      <img src="{{ $a->imageUrl ?: asset('assets/img/others/faq_bg_1.jpg') }}"
                           alt="{{ $a->name ?? 'Accreditation' }}"
                           style="max-width:100%;max-height:100%;object-fit:contain;">
                    </div>
                  </div>
                  <!-- title -->
                  <div style="padding:12px 14px;">
                    <div style="font-weight:700;color:#111">{{ $a->name ?? 'Accreditation' }}</div>
                  </div>
                  <!-- date -->
                  <div style="padding:12px 14px;color:#6b7280;font-size:14px;">
                    {{ optional($a->created_at)->format('M d, Y') }}
                  </div>
                  <!-- toggle -->
                  <div style="padding:12px 14px;">
                    <button type="button" data-acc-toggle
                            style="width:32px;height:32px;border:0;border-radius:8px;background:#f3f4f6;display:grid;place-items:center;cursor:pointer;">
                      <svg data-acc-icon width="14" height="14" viewBox="0 0 24 24" fill="none"
                           stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           style="transition:transform .2s; {{ $i===0 ? 'transform:rotate(90deg);' : '' }}"><path d="M9 18l6-6-6-6"/></svg>
                    </button>
                  </div>
                  <!-- description -->
                  <div data-acc-desc
                       style="grid-column:1 / -1;border-top:1px dashed #e5e7eb;max-height:{{ $i===0 ? '400px' : '0' }};overflow:hidden;transition:max-height .25s ease;">
                    <div data-acc-inner style="padding:14px 18px 18px 18px;color:#374151;line-height:1.65;">
                      {!! $a->description && trim(strip_tags($a->description)) !== '' ? $a->description : '<em style="color:#6b7280;">No description provided yet.</em>' !!}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:20px;text-align:center;color:#6b7280;">
              No accreditation records yet.
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- WHO WE ARE + MISSION / VISION -->
  <section style="padding:100px 0;">
    <div class="container">
      <div class="td_section_heading td_style_1 text-center">
        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">Who we are?</p>
        <h2 class="td_section_title td_fs_40 mb-0">HSE.AZ LLC</h2>
      </div>
      <div class="td_height_40"></div>

      <div class="row td_gap_y_24">
        <div class="col-lg-12">
          <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:24px;box-shadow:0 4px 14px rgba(0,0,0,.04);">
            <p class="td_fs_18 mb-0">{{ $whoWeAre }}</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:24px;height:100%;box-shadow:0 4px 14px rgba(0,0,0,.04);">
            <h3 class="td_accent_color mb-2" style="font-size:22px;">Vision</h3>
            <p class="td_fs_18 mb-0">{{ $missionVision['vision'] }}</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:24px;height:100%;box-shadow:0 4px 14px rgba(0,0,0,.04);">
            <h3 class="td_accent_color mb-2" style="font-size:22px;">Mission</h3>
            <p class="td_fs_18 mb-0">{{ $missionVision['mission'] }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services – titles only -->
  <section class="td_accent_bg td_shape_section_1" style="padding:100px 0;">
    <div class="container">
      <div class="row td_gap_y_20">
        <div class="col-lg-5">
          <div class="td_section_heading td_style_1">
            <h2 class="td_section_title td_fs_40 mb-2 td_white_color">Our Services</h2>
            <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
              Browse our training & awareness services. Click an item to view details.
            </p>
          </div>
        </div>
        <div class="col-lg-7">
          @if($services->count())
            @foreach($services as $svc)
              <a href="{{ route('service-details', $svc->id) }}"
                 class="td_white_color td_fs_18 d-flex align-items-center"
                 style="gap:10px;padding:10px 0;border-bottom:1px dashed rgba(255,255,255,.25);text-decoration:none;">
                <i class="fa-regular fa-square-check"></i>
                <span>{{ $svc->name }}</span>
              </a>
            @endforeach
          @else
            <div class="td_white_color">No services yet.</div>
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Blog & Articles – Courses -->
  <section>
    <div class="td_height_112 td_height_lg_75"></div>
    <div class="container">
      <div class="td_section_heading td_style_1 text-center">
        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">BLOG & ARTICLES</p>
        <h2 class="td_section_title td_fs_48 mb-0">Take A Look At The Latest <br>Articles</h2>
      </div>
      <div class="td_height_50 td_height_lg_40"></div>

      <div class="row td_gap_y_30">
        @forelse($courses as $course)
          <div class="col-lg-4">
            <div class="td_post td_style_1">
              <a href="{{ route('course-details', $course) }}" class="td_post_thumb d-block">
                <img src="{{ $course->imageUrl ?: asset('assets/img/home_1/post_1.jpg') }}" alt="">
                <i class="fa-solid fa-link"></i>
              </a>
              <div class="td_post_info">
                <div class="td_post_meta td_fs_14 td_medium td_mb_20">
                  <span><img src="{{ asset('assets/img/icons/calendar.svg') }}" alt="">{{ optional($course->created_at)->format('M d , Y') }}</span>
                  <span><img src="{{ asset('assets/img/icons/user.svg') }}" alt="">HSE.AZ</span>
                </div>
                <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                  <a href="{{ route('course-details', $course) }}">{{ $course->name }}</a>
                </h2>
                <p class="td_post_subtitle td_mb_24 td_heading_color td_opacity_7">{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 120) }}</p>
                <a href="{{ route('course-details', $course) }}" class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                  <span class="td_btn_in td_accent_color"><span>Read More</span></span>
                </a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">No courses found.</div>
        @endforelse
      </div>
    </div>
    <div class="td_height_120 td_height_lg_80"></div>
  </section>
@endsection

@push('scripts')
<script>
  // Accreditation table-accordion (more robust)
  (function(){
    const table = document.getElementById('accTable');
    if(!table) return;

    // Helper to open a row
    function openRow(row){
      const desc = row.querySelector('[data-acc-desc]');
      const inner = row.querySelector('[data-acc-inner]');
      const icon = row.querySelector('[data-acc-icon]');
      if(!desc || !inner) return;

      row.setAttribute('data-open','1');
      // measure by inner content height
      desc.style.maxHeight = (inner.scrollHeight + 24) + 'px';
      if(icon) icon.style.transform = 'rotate(90deg)';
    }

    // Helper to close a row
    function closeRow(row){
      const desc = row.querySelector('[data-acc-desc]');
      const icon = row.querySelector('[data-acc-icon]');
      if(!desc) return;

      row.removeAttribute('data-open');
      desc.style.maxHeight = '0';
      if(icon) icon.style.transform = 'rotate(0deg)';
    }

    // On load: size any default-open rows
    table.querySelectorAll('[data-acc-row][data-open]').forEach(openRow);

    // Click anywhere on row (except links) OR on toggle button
    table.addEventListener('click', function(e){
      const isToggleBtn = !!e.target.closest('[data-acc-toggle]');
      const row = isToggleBtn
        ? e.target.closest('[data-acc-row]')
        : (e.target.closest('a') ? null : e.target.closest('[data-acc-row]'));

      if(!row) return;

      // If you want "only one open at a time", uncomment this block:
      /*
      table.querySelectorAll('[data-acc-row][data-open]').forEach(function(r){
        if(r !== row) closeRow(r);
      });
      */

      if(row.hasAttribute('data-open')) closeRow(row);
      else openRow(row);
    });

    // Re-measure on window resize (for responsive images / fonts)
    window.addEventListener('resize', function(){
      table.querySelectorAll('[data-acc-row][data-open]').forEach(function(row){
        const desc = row.querySelector('[data-acc-desc]');
        const inner = row.querySelector('[data-acc-inner]');
        if(desc && inner) desc.style.maxHeight = (inner.scrollHeight + 24) + 'px';
      });
    });
  })();
</script>
@endpush
