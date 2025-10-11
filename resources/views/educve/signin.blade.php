@extends('layouts.app')

    <!-- Start Header Section -->
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
              <span>
                <a href="signin.html">Login</a> /
                <a href="signup.html">Register</a>
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
              <a class="td_site_branding td_accent_color" href="index.html">
                <svg width="142" height="50" viewBox="0 0 142 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <!-- SVG content skipped for brevity -->
                </svg>
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
                  <li><a href="courses-grid-view.html">Data Science</a></li>
                  <li><a href="courses-grid-view.html">Design</a></li>
                  <li><a href="courses-grid-with-sidebar.html">Development</a></li>
                  <li><a href="courses-grid-view.html">Architecture</a></li>
                  <li><a href="courses-grid-with-sidebar.html">Lifestyle</a></li>
                  <li><a href="courses-grid-with-sidebar.html">Marketing</a></li>
                  <li><a href="courses-grid-with-sidebar.html">Photography</a></li>
                  <li><a href="courses-grid-with-sidebar.html">Motivation</a></li>
                </ul>
              </div>
            </div>

            <div class="td_main_header_right">
              <nav class="td_nav">
                <ul class="td_nav_list">
                  <li><a href="index.html">Home</a></li>
                  <li><a href="about.html">About</a></li>
                  <li><a href="courses.html">Courses</a></li>
                  <li><a href="blog.html">Blog</a></li>
                  <li><a href="contact.html">Contact</a></li>
                </ul>
              </nav>
              <div class="td_hero_icon_btns position-relative">
                <button class="td_circle_btn td_center td_search_tobble_btn" type="button">
                  <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt="">
                </button>
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
    <!-- End Header Section -->

    <!-- Start Page Heading -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble" data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
      <div class="container">
        <div class="td_page_heading_in">
          <h1 class="td_white_color td_fs_48 td_mb_10">Signin</h1>
          <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Signin</li>
          </ol>
        </div>
      </div>
    </section>
    <!-- End Page Heading -->

    <!-- Start Signin Section -->
    <section>
      <div class="td_height_120 td_height_lg_80"></div>
      <div class="container">
        <div class="row td_gap_y_40">
          <div class="col-lg-6">
            <div class="td_form_card td_style_1 td_radius_10 td_gray_bg_5">
              <div class="td_form_card_in">
                <h2 class="td_fs_36 td_mb_20">SIGN IN</h2>
                <hr>
                <div class="td_height_30"></div>
                <input type="text" class="td_form_field td_mb_30" placeholder="Email *">
                <input type="password" class="td_form_field td_mb_10" placeholder="Password *">
                <div class="td_form_card_text_2 td_mb_50">
                  <a href="#" class="td_semibold td_accent_color">Forgot Password?</a>
                  <div class="td_custom_checkbox">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember me</label>
                  </div>
                </div>
                <button type="submit" class="td_btn td_style_1 td_radius_10 td_medium">
                  <span class="td_btn_in td_white_color td_accent_bg"><span>Sign In</span></span>
                </button>
                <p class="td_fs_20 td_medium td_heading_color mt-3">or sign up with</p>
                <div class="td_form_social td_fs_20">
                  <a href="#"><i class="fa-brands fa-apple"></i></a>
                  <a href="#"><i class="fa-brands fa-google"></i></a>
                  <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
                <p class="td_fs_20 td_medium td_heading_color mt-3">Don’t Have an Account? <a href="signup.html">Sign up</a></p>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="td_sign_thumb">
              <img src="{{ asset('assets/img/others/login.jpg') }}" alt="" class="w-100 td_radius_10">
            </div>
          </div>
        </div>
      </div>
      <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Signin Section -->
