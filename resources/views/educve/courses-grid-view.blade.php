@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $q = $q ?? request('q');
@endphp

<style>
  /* --- Cards & Media --- */
  .td_card_thumb.fixed-ratio{position:relative; display:block; overflow:hidden; border-radius:14px}
  .td_card_thumb.fixed-ratio::before{content:""; display:block; padding-top:62.5%}
  .td_card_thumb.fixed-ratio img{position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform .35s ease}

  /* overlay actions */
  .thumb-overlay{
    position:absolute; inset:0; display:flex; flex-direction:column; justify-content:flex-end;
    background:linear-gradient(180deg, rgba(0,0,0,0) 45%, rgba(0,0,0,.55) 100%);
    opacity:0; transition:opacity .25s ease; padding:14px;
  }
  .td_card_thumb.fixed-ratio:hover img{transform:scale(1.04)}
  .td_card_thumb.fixed-ratio:hover .thumb-overlay{opacity:1}

  .overlay-top{
    position:absolute; top:10px; left:10px; right:10px; display:flex; justify-content:space-between; gap:8px;
  }
  .pill{background:rgba(255,255,255,.9); border-radius:999px; padding:6px 10px; font-weight:700; font-size:12px; line-height:1; display:flex; align-items:center; gap:6px}
  .pill-dark{background:rgba(0,0,0,.6); color:#fff}

  .overlay-actions{display:flex; gap:8px; justify-content:center}
  .overlay-actions .td_btn{transform:translateY(8px); opacity:0; transition:all .25s ease}
  .td_card_thumb.fixed-ratio:hover .overlay-actions .td_btn{transform:translateY(0); opacity:1}

  /* equalize card body */
  .td_card.td_style_3{height:100%; border-radius:14px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,.06)}
  .td_card.td_style_3 .td_card_info{display:flex; height:100%}
  .td_card.td_style_3 .td_card_info_in{display:flex; flex-direction:column; gap:.5rem; width:100%}
  .td_card_actions{margin-top:auto; display:flex; gap:.5rem}

  /* centered search bar */
  .courses-search-wrap{display:flex; justify-content:center}
  .courses-search{display:flex; gap:.6rem; width:100%; max-width:760px}
  .courses-search input[type="text"]{
    flex:1; min-width:0; border:1px solid var(--td-border, #e8e8e8);
    border-radius:999px; padding:.8rem 1rem; font-size:1rem;
  }
  .courses-search button{
    border:none; border-radius:999px; padding:.8rem 1rem; font-weight:700;
  }
  @media (max-width:575.98px){ .courses-search{flex-direction:column} .courses-search button{width:100%} }

  /* empty state */
  .empty-state{max-width:560px; margin:40px auto 0; text-align:center}
  .empty-icon{width:70px; height:70px; margin:0 auto 14px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#f5f7fb}
  .empty-title{font-size:1.4rem; font-weight:800; margin-bottom:.25rem}
  .empty-desc{opacity:.75}
</style>

<!-- Header -->
<header class="td_site_header td_style_1 td_type_2 td_sticky_header td_medium td_heading_color">
  <div class="td_top_header td_heading_bg td_white_color">
    <div class="container">
      <div class="td_top_header_in">
        <div class="td_top_header_left">
          <ul class="td_header_contact_list td_mp_0 td_normal">
            <li>
              <img src="{{ asset('assets/img/icons/call.svg') }}" alt="">
              <span> Call: <a href="tel:99066789768">990 66789 768</a> </span>
            </li>
            <li>
              <img src="{{ asset('assets/img/icons/envlop.svg') }}" alt="">
              <span> Email: <a href="mailto:support@educat.com">support@educat.com</a> </span>
            </li>
          </ul>
        </div>
        <div class="td_top_header_right">
          <span>
            <a href="{{ route('auth.show','login') }}">Login</a> /
            <a href="{{ route('auth.show','register') }}">Register</a>
          </span>
          <a href="#" class="td_btn td_style_1 td_medium">
            <span class="td_btn_in td_white_color td_accent_bg">
              <span>Apply Now</span>
              <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="td_main_header">
    <div class="container">
      <div class="td_main_header_in">
        <div class="td_main_header_left">
          <a class="td_site_branding td_accent_color" href="{{ route('home') }}">
            <!-- SVG logo -->
          </a>
          <div class="td_header_category_wrap position-relative">
            <button class="td_header_dropdown_btn td_medium td_heading_color">
              <img src="{{ asset('assets/img/icons/menu-square.svg') }}" alt="" class="td_header_dropdown_btn_icon">
              <span>All Category</span>
              <span class="td_header_dropdown_btn_tobble_icon td_center">
                <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 4.99997C9 4.99997 6.05404 1.00001 4.99997 1C3.94589 0.999991 1 5 1 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </button>
            <ul class="td_header_dropdown_list td_mp_0">
              <li><a href="{{ route('courses-grid-view') }}">Data Science</a></li>
              <li><a href="{{ route('courses-grid-view') }}">Design</a></li>
              <li><a href="{{ route('courses-grid-view') }}">Development</a></li>
              <li><a href="{{ route('courses-grid-view') }}">Architecture</a></li>
              <li><a href="{{ route('courses-grid-view') }}">Life Style</a></li>
              <li><a href="{{ route('courses-grid-view') }}">Marketing</a></li>
              <li><a href="{{ route('courses-grid-view') }}">Photography</a></li>
              <li><a href="{{ route('courses-grid-view') }}">Motivation</a></li>
            </ul>
          </div>
        </div>

        <div class="td_main_header_right">
          <nav class="td_nav">
            <div class="td_nav_list_wrap">
              <div class="td_nav_list_wrap_in">
                <ul class="td_nav_list">
                  <li><a href="{{ route('home') }}">Home</a></li>
                  <li class="menu-item-has-children">
                    <a href="#">Courses</a>
                    <ul>
                      <li><a href="{{ route('courses-grid-view') }}">Courses Grid View</a></li>
                    </ul>
                  </li>
                  <li><a href="{{ route('about') }}">About</a></li>
                  <li class="menu-item-has-children"><a href="#">Pages</a></li>
                  <li class="menu-item-has-children"><a href="#">Blogs</a></li>
                  <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
              </div>
            </div>
          </nav>

          <div class="td_hero_icon_btns position-relative">
            <div class="position-relative">
              <button class="td_circle_btn td_center td_search_tobble_btn" type="button">
                <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt="">
              </button>
              <div class="td_header_search_wrap">
                <form action="#" class="td_header_search">
                  <input type="text" class="td_header_search_input" placeholder="Search For Anything">
                  <button class="td_header_search_btn td_center">
                    <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt="">
                  </button>
                </form>
              </div>
            </div>
            <button class="td_circle_btn td_center td_wishlist_btn" type="button">
              <img src="{{ asset('assets/img/icons/love.svg') }}" alt="">
              <span class="td_circle_btn_label">0</span>
            </button>
            <button class="td_circle_btn td_center" type="button">
              <img src="{{ asset('assets/img/icons/cart.svg') }}" alt="">
              <span class="td_circle_btn_label">0</span>
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
</header>
<!-- End Header -->

<!-- Page Heading -->
<section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
         data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
  <div class="container">
    <div class="td_page_heading_in">
      <h1 class="td_white_color td_fs_48 td_mb_10">Courses Grid View</h1>
      <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Courses Grid View</li>
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

<!-- Courses Grid View -->
<section>
  <div class="td_height_120 td_height_lg_80"></div>
  <div class="container">

    {{-- Search (centered & responsive) --}}
    <div class="courses-search-wrap">
      <form class="courses-search" action="{{ route('courses-grid-view') }}" method="GET" role="search" aria-label="Course search">
        <input type="text"
               name="q"
               value="{{ $q }}"
               placeholder="Search by name or description..."
               autocomplete="off" />
        <button class="td_btn td_style_1 td_medium" type="submit">
          <span class="td_btn_in td_white_color td_accent_bg">
            <span>Search</span>
            <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </button>

        @if($q)
          <a href="{{ route('courses-grid-view') }}" class="td_btn td_style_2 td_medium" title="Clear search">
            <span class="td_btn_in td_heading_color td_white_bg"><span>Clear</span></span>
          </a>
        @endif
      </form>
    </div>

    <div class="td_height_40 td_height_lg_30"></div>

    {{-- Header (counts + query) --}}
    <div class="td_section_head_2">
      <div class="td_section_head_2_left">
        <span class="td_heading_color td_medium">
          @if(method_exists($courses,'total'))
            @if(($q ?? '') !== '')
              {{ $courses->total() }} result(s) for “{{ $q }}”
            @else
              Showing {{ $courses->count() }} Courses of {{ $courses->total() }}
            @endif
          @else
            {{ $q ? "Result for “{$q}”: " . count($courses) . " course(s)" : "Showing " . count($courses) . " Courses" }}
          @endif
        </span>
      </div>
    </div>

    <div class="td_height_40 td_height_lg_30"></div>

    {{-- Results --}}
    @if($courses->count() > 0)
      <div class="row td_gap_y_30 td_row_gap_30">
        @foreach($courses as $course)
          <div class="col-lg-4 col-md-6">
            <div class="td_card td_style_3 d-block td_white_bg">

              {{-- Thumbnail + overlay --}}
              <a href="{{ route('course-details', $course->id) }}" class="td_card_thumb fixed-ratio">
                @if(!empty($course->imageUrl))
                  <img src="{{ $course->imageUrl }}" alt="{{ $course->name }}">
                @else
                  <img src="{{ asset('assets/img/placeholder/placeholder-800x500.jpg') }}" alt="{{ $course->name }}">
                @endif

                <div class="overlay-top">
                  <span class="pill">
                    {{ $course->category->name ?? ($course->category ?? 'General') }}
                  </span>
                  <span class="pill pill-dark" title="Views">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                      <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
                    </svg>
                    {{ number_format($course->views ?? 0) }}
                  </span>
                </div>

                <div class="thumb-overlay">
                  <div class="overlay-actions">
                    <a href="{{ route('course-details', $course->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                      <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                    </a>

                    @if(!empty($course->courseUrl))
                      <a href="{{ $course->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
                        <span class="td_btn_in td_heading_color td_white_bg"><span>Visit</span></span>
                      </a>
                    @endif
                  </div>
                </div>
              </a>

              {{-- Body --}}
              <div class="td_card_info">
                <div class="td_card_info_in">
                  <h2 class="td_card_title td_fs_24 td_mb_8">
                    <a href="{{ route('course-details', $course->id) }}">{{ $course->name }}</a>
                  </h2>

                  @php $desc = strip_tags($course->description ?? ''); @endphp
                  @if($desc)
                    <p class="td_card_subtitle td_heading_color td_opacity_7">
                      {{ Str::limit($desc, 140) }}
                    </p>
                  @endif

                  <div class="td_card_actions">
                    <a href="{{ route('course-details', $course->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                      <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                    </a>
                    @if(!empty($course->courseUrl))
                      <a href="{{ $course->courseUrl }}" target="_blank" rel="noopener"
                         class="td_btn td_style_2 td_radius_10 td_medium">
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

      @if(method_exists($courses, 'links'))
        <div class="td_height_60 td_height_lg_40"></div>
        <div class="d-flex justify-content-center">
          {{ $courses->appends(['q' => $q])->links() }}
        </div>
      @endif
    @else
      {{-- Empty state for search results --}}
      @if(($q ?? '') !== '')
        <div class="empty-state">
          <div class="empty-icon">
            <svg viewBox="0 0 24 24" width="30" height="30" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.6"/>
              <path d="M20 20L17 17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
          </div>
          <div class="empty-title">Axtardığınız üzrə nəticə tapılmadı</div>
          <div class="empty-desc">“{{ $q }}” üçün uyğun kurs tapılmadı. Başqa açar sözlə yoxlayın.</div>
          <div class="td_height_20"></div>
          <a href="{{ route('courses-grid-view') }}" class="td_btn td_style_2 td_radius_10 td_medium">
            <span class="td_btn_in td_heading_color td_white_bg"><span>Hamısını göstər</span></span>
          </a>
        </div>
      @else
        <div class="empty-state">
          <div class="empty-title">Hələ kurs əlavə edilməyib</div>
          <div class="empty-desc">Tezliklə yeni kurslar burada görünəcək.</div>
        </div>
      @endif
    @endif

    <div class="td_height_60 td_height_lg_40"></div>
  </div>
  <div class="td_height_120 td_height_lg_80"></div>
</section>
