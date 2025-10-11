@extends('layouts.app')

@section('title', 'Faqs')

@section('content')
  <!-- Start Page Heading Section -->
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
           data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">Faqs</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">Faqs</li>
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

  <!-- Start Accordion Section -->
  {{-- Yuxarı boşluğu verən spacer silindi --}}

  {{-- Column 1 --}}
  <div class="td_faq_1 td_style_1 td_type_1">
    <div class="td_faq_1_left">
      <div class="td_faq_1_img td_bg_filed" data-src="{{ asset('assets/img/others/faq_bg_1.jpg') }}"></div>
    </div>

    <div class="td_faq_1_right">
      <div class="td_section_heading td_style_1">
        <p class="td_section_subtitle_up td_fs_18 td_medium td_spacing_1 td_mb_10 td_accent_color">Faqs 01</p>
      </div>

      <div class="td_accordians td_style_1 td_type_2 td_mb_40">
        @forelse($faqsCol1 ?? collect() as $faq)
          <div class="td_accordian {{ $loop->first ? 'active' : '' }}">
            <div class="td_accordian_head">
              <h2 class="td_accordian_title td_fs_24">{{ $faq->question }}</h2>
              <span class="td_accordian_toggle"></span>
            </div>
            <div class="td_accordian_body td_fs_18">
              <p>{!! nl2br(e($faq->answer)) !!}</p>
            </div>
          </div><!-- .td_accordian -->
        @empty
          <p class="text-muted">Məlumat yoxdur.</p>
        @endforelse
      </div>

      <a href="{{ url('/contact') }}" class="td_btn td_style_2 td_type_2 td_heading_color td_medium">
        Get In Touch
        <i>
          <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
        </i>
      </a>
    </div>
  </div>

  <div class="td_height_80 td_height_lg_60"></div>

  {{-- Column 2 --}}
  <div class="td_faq_1 td_style_1">
    <div class="td_faq_1_right">
      <div class="td_section_heading td_style_1">
        <p class="td_section_subtitle_up td_fs_18 td_medium td_spacing_1 td_mb_10 td_accent_color">Faqs 02</p>
      </div>

      <div class="td_accordians td_style_1 td_type_2 td_mb_40">
        @foreach($faqsCol2 ?? collect() as $faq)
          <div class="td_accordian {{ $loop->first ? 'active' : '' }}">
            <div class="td_accordian_head">
              <h2 class="td_accordian_title td_fs_24">{{ $faq->question }}</h2>
              <span class="td_accordian_toggle"></span>
            </div>
            <div class="td_accordian_body td_fs_18">
              <p>{!! nl2br(e($faq->answer)) !!}</p>
            </div>
          </div><!-- .td_accordian -->
        @endforeach
      </div>

      <a href="{{ url('/contact') }}" class="td_btn td_style_2 td_type_2 td_heading_color td_medium">
        Get In Touch
        <i>
          <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
        </i>
      </a>
    </div>

    <div class="td_faq_1_left">
      <div class="td_faq_1_img td_bg_filed" data-src="{{ asset('assets/img/others/faq_bg_2.jpg') }}"></div>
    </div>
  </div>
  <!-- End Accordion Section -->

  {{-- Blog bölməsi (istəsəniz saxlayın) --}}
  @includeWhen(view()->exists('educvce._blog-snippet'), 'educvce._blog-snippet')
@endsection
