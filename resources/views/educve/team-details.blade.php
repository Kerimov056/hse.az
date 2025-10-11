@extends('layouts.app')

@section('title', 'Team Member Details')

@php
  // Fallback şəkillər (gender-ə görə)
  $fallbackMale   = 'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
  $fallbackFemale = 'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';

  $photo = $team->imageUrl ?: ($team->gender === 'female' ? $fallbackFemale : $fallbackMale);

  // Skills – həm yeni (skills), həm də köhnə (skills_json) formatını oxu
  $skills = $team->skills;
  if (empty($skills)) {
      $skills = json_decode($team->skills_json ?? '[]', true) ?: [];
  }
@endphp

@section('content')
    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
             data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
      <div class="container">
        <div class="td_page_heading_in">
          <h1 class="td_white_color td_fs_48 td_mb_10">Team Member Details</h1>
          <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ \Illuminate\Support\Str::limit($team->full_name, 40) }}</li>
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
    <!-- End Page Heading Section -->

    <!-- Start Team Details Section -->
    <section>
      <div class="td_height_120 td_height_lg_80"></div>
      <div class="container">
        <div class="row td_gap_y_40">
          <div class="col-lg-5">
            <div class="td_team_details_left">
              <div class="td_team_details_thumb td_accent_bg text-center td_radius_10 td_mb_30">
                <img src="{{ $photo }}" alt="{{ $team->full_name }}" class="td_radius_10 w-100" style="object-fit:cover">
              </div>

              <div class="td_mb_30">
                <ul class="td_team_member_contact_list td_mp_0 td_fs_18 td_semibold td_heading_color">

                  @if($team->phone)
                  <li>
                    <i class="td_team_member_contact_icon td_center td_accent_color">
                      {{-- phone icon --}}
                      <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.1558 11.3568C14.7628 10.966 14.2889 10.7571 13.7865 10.7571C13.2882 10.7571 12.8102 10.9622 12.401 11.353L11.1209 12.5718C11.0155 12.5177 10.9102 12.4674 10.8089 12.4171C10.6631 12.3474 10.5253 12.2816 10.4079 12.212C9.20872 11.4845 8.11896 10.5365 7.07376 9.30995C6.56737 8.69858 6.22707 8.18396 5.97995 7.66159C6.31215 7.37139 6.62004 7.06958 6.91982 6.77937C7.03325 6.67103 7.14668 6.55882 7.26012 6.45048C8.11086 5.63791 8.11086 4.58544 7.26012 3.77287L6.15415 2.71653C6.02857 2.59658 5.89893 2.47276 5.7774 2.34894C5.53433 2.10904 5.27911 1.8614 5.01578 1.62923C4.62282 1.25777 4.15289 1.06043 3.65865 1.06043C3.16441 1.06043 2.68637 1.25777 2.28126 1.62923L0.89577 2.96417C0.37722 3.45945 0.08149 4.06307 0.01667 4.76343C-0.08056 5.89329 0.26784 6.94576 0.53522 7.6345C1.1915 9.32542 2.17188 10.8925 3.63434 12.5718C5.40874 14.5955 7.5437 16.1936 9.98248 17.3196C10.9142 17.7413 12.158 18.2405 13.5475 18.3256C14.7385 18.3333 15.5245 18.0122 16.1402 17.3737C16.3671 17.1106 16.6102 16.8901 16.8654 16.654C17.0396 16.4954 17.2178 16.329 17.392 16.1549C17.7931 15.7563 18.0038 15.292 18.0038 14.8161C18.0038 14.3363 17.789 13.8758 17.3799 13.4889L15.1558 11.3568Z" fill="currentColor"/></svg>
                    </i>
                    <a href="tel:{{ $team->phone }}">{{ $team->phone }}</a>
                  </li>
                  @endif

                  @if($team->email)
                  <li>
                    <i class="td_team_member_contact_icon td_center td_accent_color">
                      {{-- mail icon --}}
                      <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.1819 0.5H1.81817C0.814025 0.5 0 1.29282 0 2.27085V12.8959C0 13.8738 0.814025 14.6667 1.81817 14.6667H18.1818C19.186 14.6667 20 13.8738 20 12.8959V2.27085C20 1.29282 19.186 0.5 18.1819 0.5ZM1.81817 1.38543H18.1818C18.2857 1.38607 18.3887 1.40403 18.4864 1.43854L10.6182 9.10183C10.2803 9.43313 9.73057 9.43488 9.39041 9.10575C9.38908 9.10446 9.38771 9.10312 9.38639 9.10183L1.51364 1.43854C1.61129 1.40403 1.7143 1.38603 1.81817 1.38543ZM18.1819 13.7812H1.81817C1.7143 13.7806 1.61129 13.7626 1.51364 13.7281L7.18181 8.20758L8.74092 9.72608C9.43369 10.4034 10.559 10.4054 11.2544 9.73068C11.256 9.72916 11.2575 9.7276 11.2591 9.72608L12.8182 8.20758L18.4864 13.7281C18.3887 13.7626 18.2857 13.7806 18.1819 13.7812ZM19.0909 13.0508L13.4637 7.58333L19.0909 2.11589C19.0956 2.16745 19.0956 2.2193 19.0909 2.27085V12.8959C19.0956 12.9474 19.0956 12.9992 19.0909 13.0508Z" fill="currentColor"/></svg>
                    </i>
                    <a href="mailto:{{ $team->email }}">{{ $team->email }}</a>
                  </li>
                  @endif

                  @if($team->address ?? false)
                  <li>
                    <i class="td_team_member_contact_icon td_center td_accent_color">
                      {{-- location icon --}}
                      <svg width="17" height="21" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.66602.836c-2.122 0-4.156.843-5.657 2.343A7.99 7.99 0 0 0 .666 8.836c-.007 1.991.736 3.911 2.08 5.38l5.54 6.445a.8.8 0 0 0 1.2 0l5.54-6.445a7.98 7.98 0 0 0 2.08-5.38c0-2.122-.843-4.156-2.343-5.657A7.992 7.992 0 0 0 8.666.836Z" fill="currentColor"/></svg>
                    </i>
                    <span>{{ $team->address }}</span>
                  </li>
                  @endif

                </ul>
              </div>

              <div class="td_btns_group">
                @if($team->email)
                <a href="mailto:{{ $team->email }}" class="td_btn td_style_1 td_radius_10 td_medium">
                  <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Contact With Me</span>
                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </span>
                </a>
                @endif

                {{-- SHARE: URL-i kopi­yalayır və toast göstərir --}}
                <a href="javascript:void(0)" class="td_btn td_style_1 td_type_5 td_radius_10 td_medium js-share-copy"
                   data-url="{{ request()->fullUrl() }}">
                  <span class="td_btn_in td_accent_color">
                    <svg width="21" height="25" viewBox="0 0 21 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.5456 16.2357c-.495 0-.978.15-1.59.337-.512.223-.975.549-1.361.96L8.767 14.361c.375-1 .375-2.107 0-3.106l4.827-3.17c.676.711 1.57 1.158 2.53 1.265.961.107 1.927-.133 2.735-.678a4.41 4.41 0 0 0 1.691-2.31c.286-.95.243-1.972-.122-2.892-.366-.92-1.03-1.68-1.88-2.151-.85-.471-1.833-.623-2.78-.43a4.41 4.41 0 0 0-2.414 1.485c-.612.768-.947 1.739-.946 2.733.002.531.097 1.057.281 1.553L7.861 9.82c-.578-.611-1.32-1.031-2.131-1.206-.811-.175-1.654-.096-2.399.224-.961.321-1.618.87-2.081 1.576-.463.707-.71 1.54-.71 2.392 0 .852.247 1.685.71 2.392.463.707 1.12 1.256 2.081 1.577.745.32 1.588.399 2.399.224.811-.175 1.553-.595 2.131-1.206l4.8 3.17a4.59 4.59 0 0 0-.281 1.553c0 .847.244 1.675.702 2.38.458.705 1.109 1.254 1.87 1.578.761.324 1.599.41 2.407.244.808-.156 1.55-.564 2.132-1.164.582-.6.979-1.363 1.139-2.194.16-.831.078-1.713-.237-2.496a4.08 4.08 0 0 0-1.534-1.923c-.675-.47-1.48-.722-2.304-.722Z" fill="currentColor"/></svg>
                    <span>Share</span>
                  </span>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="td_team_details_content">
              <div class="td_section_heading td_style_2 td_mb_20">
                <h2 class="td_contact_info_title td_fs_36 mb-0">{{ $team->full_name }}</h2>
                <p class="td_medium mb-0 td_heading_color td_opacity_5">{{ $team->position ?: '—' }}</p>
              </div>

              @if($team->description)
                <div class="td_fs_18 td_mb_40 td_content">{!! $team->description !!}</div>
              @endif

              {{-- Always visible main heading --}}
              <div class="td_section_heading td_style_2 td_mb_10">
                <h2 class="td_contact_info_title td_fs_36 mb-0">My Expertise &amp; Skills</h2>
              </div>

              {{-- Short title under the main heading (optional) --}}
              @if(!empty($team->expertise_title))
                <p class="td_medium td_heading_color td_fs_20 td_mb_24">{{ $team->expertise_title }}</p>
              @endif

              {{-- Skills bars --}}
              @if(!empty($skills))
                <div class="td_mb_30">
                  @foreach($skills as $s)
                    @php
                      // {name,percent} və ya {title,value}
                      $label = $s['name']   ?? $s['title']  ?? '';
                      $val   = (int)($s['percent'] ?? $s['value'] ?? 0);
                      $val   = max(0, min(100, $val));
                    @endphp
                    @continue($label === '')
                    <div class="td_progress_wrap td_mb_24">
                      <h3 class="td_fs_16 td_semibold td_mb_5">{{ $label }}</h3>
                      <div class="td_progress" data-progress="{{ $val }}">
                        <div class="td_progress_in td_accent_bg" style="width: {{ $val }}%;">
                          <span class="td_accent_bg td_white_color td_fs_12 td_bold">{{ $val }}%</span>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

              {{-- Expertise intro text after skills --}}
              @if(!empty($team->expertise_intro))
                <p class="td_fs_18 td_mb_0">{{ $team->expertise_intro }}</p>
              @endif

              @if($team->about_bottom)
                <div class="td_fs_18 td_content td_mt_20">{!! $team->about_bottom !!}</div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Team Details Section -->

    {{-- Copy toast --}}
    <div id="copyToast" role="status" aria-live="polite" aria-atomic="true">
      <span class="copy-toast__msg">Link copied</span>
    </div>

    <style>
      #copyToast{
        position:fixed;left:50%;bottom:24px;transform:translateX(-50%) scale(.96);
        background:#111827;color:#fff;padding:10px 16px;border-radius:10px;
        box-shadow:0 10px 25px rgba(0,0,0,.15);opacity:0;pointer-events:none;
        transition:.25s ease;z-index:9999;font-weight:600
      }
      #copyToast.show{opacity:1;transform:translateX(-50%) scale(1)}
    </style>

    <script>
      (function () {
        function showToast(msg) {
          var toast = document.getElementById('copyToast');
          toast.querySelector('.copy-toast__msg').textContent = msg || 'Link copied';
          toast.classList.add('show');
          setTimeout(function(){ toast.classList.remove('show'); }, 1800);
        }

        document.addEventListener('click', function (e) {
          var btn = e.target.closest('.js-share-copy');
          if (!btn) return;
          e.preventDefault();

          var url = btn.dataset.url || window.location.href;

          if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(function () {
              showToast('Link copied to clipboard');
            }).catch(fallbackCopy);
          } else {
            fallbackCopy();
          }

          function fallbackCopy() {
            var ta = document.createElement('textarea');
            ta.value = url;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            try { document.execCommand('copy'); } catch(e){}
            document.body.removeChild(ta);
            showToast('Link copied to clipboard');
          }
        }, false);
      })();
    </script>
@endsection
