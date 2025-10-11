@extends('layouts.app')

@section('content')
   

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
             data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
      <div class="container">
        <div class="td_page_heading_in">
          <h1 class="td_white_color td_fs_48 td_mb_10">{{ $tab === 'register' ? 'Signup' : 'Signin' }}</h1>
          <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $tab === 'register' ? 'Signup' : 'Signin' }}</li>
          </ol>
        </div>
      </div>
      <div class="td_page_heading_shape_1 position-absolute td_hover_layer_3"></div>
      <div class="td_page_heading_shape_2 position-absolute td_hover_layer_5"></div>
      <div class="td_page_heading_shape_3 position-absolute">
        <img src="{{ asset('assets/img/others/page_heading_shape_3.svg') }}" alt="Shape 3">
      </div>
      <div class="td_page_heading_shape_4 position-absolute">
        <img src="{{ asset('assets/img/others/page_heading_shape_4.svg') }}" alt="Shape 4">
      </div>
      <div class="td_page_heading_shape_5 position-absolute">
        <img src="{{ asset('assets/img/others/page_heading_shape_5.svg') }}" alt="Shape 5">
      </div>
      <div class="td_page_heading_shape_6 position-absolute td_hover_layer_3"></div>
    </section>
    <!-- End Page Heading Section -->

    <!-- Start Auth (Login/Register) Section -->
    <section>
      <div class="td_height_120 td_height_lg_80"></div>
      <div class="container">

        {{-- Tab switcher --}}
        <div class="td_center td_mb_40">
          <a href="{{ route('auth.show','login') }}"
             class="td_btn td_style_1 td_radius_10 td_medium"
             style="margin-right:10px; {{ $tab==='login' ? '' : 'opacity:.6' }}">
            <span class="td_btn_in td_white_color {{ $tab==='login' ? 'td_accent_bg' : 'td_heading_bg' }}">
              <span>Sign In</span>
            </span>
          </a>

          <a href="{{ route('auth.show','register') }}"
             class="td_btn td_style_1 td_radius_10 td_medium"
             style="{{ $tab==='register' ? '' : 'opacity:.6' }}">
            <span class="td_btn_in td_white_color {{ $tab==='register' ? 'td_accent_bg' : 'td_heading_bg' }}">
              <span>Sign Up</span>
            </span>
          </a>
        </div>

        <div class="row td_gap_y_40 align-items-center">
          <div class="col-lg-6">
            <div class="td_form_card td_style_1 td_radius_10 td_gray_bg_5">
              <div class="td_form_card_in">

                {{-- REGISTER FORM --}}
                @if($tab === 'register')
                  <h2 class="td_fs_36 td_mb_20">SIGN UP</h2>
                  <hr>
                  <div class="td_height_30 td_height_lg_30"></div>

                  <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <input type="text" name="name" value="{{ old('name') }}"
                           class="td_form_field td_mb_20 td_medium td_white_bg"
                           placeholder="Full Name *">
                    @error('name')<div class="text-danger td_mb_10">{{ $message }}</div>@enderror

                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="td_form_field td_mb_20 td_medium td_white_bg"
                           placeholder="Phone">
                    @error('phone')<div class="text-danger td_mb_10">{{ $message }}</div>@enderror

                    <input type="email" name="email" value="{{ old('email') }}"
                           class="td_form_field td_mb_20 td_medium td_white_bg"
                           placeholder="Email *">
                    @error('email')<div class="text-danger td_mb_10">{{ $message }}</div>@enderror

                    <input type="password" name="password"
                           class="td_form_field td_mb_20 td_medium td_white_bg"
                           placeholder="Password *">
                    @error('password')<div class="text-danger td_mb_10">{{ $message }}</div>@enderror

                    <input type="password" name="password_confirmation"
                           class="td_form_field td_mb_30 td_medium td_white_bg"
                           placeholder="Confirm Password *">

                    <div class="td_form_card_bottom td_mb_25 d-flex align-items-center gap-3">
                      <button type="submit" class="td_btn td_style_1 td_radius_10 td_medium">
                        <span class="td_btn_in td_white_color td_accent_bg">
                          <span>Sign Up</span>
                        </span>
                      </button>

                      <p class="td_fs_18 mb-0 td_medium td_heading_color">or sign up with</p>
                      <div class="td_form_social td_fs_20">
                        <a href="#" class="td_center"><i class="fa-brands fa-apple"></i></a>
                        <a href="#" class="td_center"><i class="fa-brands fa-google"></i></a>
                        <a href="#" class="td_center"><i class="fa-brands fa-facebook-f"></i></a>
                      </div>
                    </div>

                    <p class="td_form_card_text td_fs_18 td_medium td_heading_color mb-0">
                      Already have an account?
                      <a href="{{ route('auth.show','login') }}">Sign in</a>
                    </p>
                  </form>
                @endif

                {{-- LOGIN FORM --}}
                @if($tab === 'login')
                  <h2 class="td_fs_36 td_mb_20">SIGN IN</h2>
                  <hr>
                  <div class="td_height_30 td_height_lg_30"></div>

                  <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <input type="email" name="email" value="{{ old('email') }}"
                           class="td_form_field td_mb_20 td_medium td_white_bg"
                           placeholder="Email *">
                    @error('email')<div class="text-danger td_mb_10">{{ $message }}</div>@enderror

                    <input type="password" name="password"
                           class="td_form_field td_mb_20 td_medium td_white_bg"
                           placeholder="Password *">
                    @error('password')<div class="text-danger td_mb_10">{{ $message }}</div>@enderror

                    <label class="d-flex align-items-center gap-2 td_mb_30">
                      <input type="checkbox" name="remember" value="1">
                      <span class="td_fs_16">Remember me</span>
                    </label>

                    <div class="td_form_card_bottom td_mb_25 d-flex align-items-center gap-3">
                      <button type="submit" class="td_btn td_style_1 td_radius_10 td_medium">
                        <span class="td_btn_in td_white_color td_accent_bg">
                          <span>Sign In</span>
                        </span>
                      </button>

                      <p class="td_fs_18 mb-0 td_medium td_heading_color">or sign in with</p>
                      <div class="td_form_social td_fs_20">
                        <a href="#" class="td_center"><i class="fa-brands fa-apple"></i></a>
                        <a href="#" class="td_center"><i class="fa-brands fa-google"></i></a>
                        <a href="#" class="td_center"><i class="fa-brands fa-facebook-f"></i></a>
                      </div>
                    </div>

                    <p class="td_form_card_text td_fs_18 td_medium td_heading_color mb-0">
                      Don’t have an account?
                      <a href="{{ route('auth.show','register') }}">Sign up</a>
                    </p>
                  </form>
                @endif

              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="td_sign_thumb">
              <img src="{{ asset('assets/img/others/login.jpg') }}" alt="Login" class="w-100 td_radius_10">
            </div>
          </div>
        </div>
      </div>
      <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Auth Section -->
@endsection
