@extends('layouts.app')
    <!-- Header -->
    <header class="td_site_header td_style_1 td_type_2 td_sticky_header td_medium td_heading_color">
      <div class="td_top_header td_heading_bg td_white_color">
        <div class="container">
          <div class="td_top_header_in">
            <div class="td_top_header_left">
              <ul class="td_header_contact_list td_mp_0 td_normal">
                <li>
                  <img src="{{ asset('assets/img/icons/call.svg') }}" alt="">
                  <span>Call: <a href="tel:99066789768">990 66789 768</a></span>
                </li>
                <li>
                  <img src="{{ asset('assets/img/icons/envlop.svg') }}" alt="">
                  <span>Email: <a href="mailto:support@educat.com">support@educat.com</a></span>
                </li>
              </ul>
            </div>
            <div class="td_top_header_right">
              <span><a href="signin.html">Login</a>/<a href="signup.html">Register</a></span>
              <a href="#" class="td_btn td_style_1 td_medium">
                <span class="td_btn_in td_white_color td_accent_bg">
                  <span>Apply Now</span>
                  <svg width="19" height="20" viewBox="0 0 19 20" fill="none">
                    <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                      stroke-linecap="round" stroke-linejoin="round" />
                    <path
                      d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- main header simplified -->
    </header>

    <!-- Page Heading -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
      data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
      <div class="container">
        <div class="td_page_heading_in">
          <h1 class="td_white_color td_fs_48 td_mb_10">Faqs</h1>
          <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Faqs</li>
          </ol>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <div class="td_faq_1 td_style_1 td_type_1">
      <div class="td_faq_1_left">
        <div class="td_faq_1_img td_bg_filed" data-src="{{ asset('assets/img/others/faq_bg_1.jpg') }}"></div>
      </div>
      <div class="td_faq_1_right">
        <div class="td_section_heading td_style_1">
          <p class="td_section_subtitle_up td_fs_18 td_medium td_accent_color">Faqs 01</p>
        </div>
        <div class="td_accordians td_style_1 td_type_2">
          <div class="td_accordian">
            <div class="td_accordian_head">
              <h2 class="td_accordian_title td_fs_24">How this Educve works?</h2>
              <span class="td_accordian_toggle"></span>
            </div>
            <div class="td_accordian_body td_fs_18">
              <p>We want every employee and trade partner to feel that they are part of a common good and cohesive
                team.</p>
            </div>
          </div>
        </div>
        <a href="contact.html" class="td_btn td_style_2 td_type_2 td_heading_color td_medium">Get In Touch</a>
      </div>
    </div>

