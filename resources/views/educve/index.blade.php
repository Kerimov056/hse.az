@php use Illuminate\Support\Str; @endphp

@php
    $siteName = setting('site.name', 'Educve');
    $phone = setting('site.phone'); // "+23 (000) 68 603"
    $email = setting('site.email'); // "support@educat.com"
    $address = setting('site.address'); // "66 broklyn golden street, New York, USA"
    $tagline = setting(
        'site.tagline',
        'Far far away, behind the word mountains, far from the Consonantia, there live the blind texts.',
    );

    // 1) site.logo üstünlük; 2) branding.logo fallback
    $logoPath = setting('site.logo') ?: setting('branding.logo');

    $logoUrl = null;
    if ($logoPath) {
        $logoUrl = \Illuminate\Support\Str::startsWith($logoPath, ['http', '/storage', 'assets/'])
            ? asset($logoPath)
            : asset('storage/' . ltrim($logoPath, '/'));
    }

    // tel: üçün yalnız rəqəm və + saxla
    $telHref = $phone ? 'tel:' . preg_replace('/[^0-9\+]+/', '', $phone) : null;
@endphp
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="ThemeDox">

    <!-- Favicon Icon -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Site Title -->
    <title>Educve | Online Education Platform</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <!-- Start Preloader -->
    <div class="td_preloader">
        <div class="td_preloader_in">
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- End Preloader -->
    <!-- Start Header Section -->
    {{-- resources/views/partials/header.blade.php --}}
    <header class="td_site_header td_style_1 td_type_3 td_sticky_header td_medium td_heading_color">
        <div class="td_main_header">
            <div class="container-fluid">
                <div class="td_main_header_in">
                    {{-- Left: Logo + Socials --}}
                    <div class="td_main_header_left">
                        <a class="td_site_branding" href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo">
                        </a>
                        {{-- Header Social (settings-driven) --}}
                        @php
                            $fb = setting('social.facebook');
                            $tw = setting('social.twitter');
                            $ig = setting('social.instagram');
                            $pin = setting('social.pinterest'); // fallback üçün saxlayırıq
                            $wa = setting('social.whatsapp'); // tercihen wa.me/…
                            // LinkedIn: varsa onu götür, yoxdursa Pinterest URL-ni istifadə et
                            $li = setting('social.linkedin', $pin);

                            // Linkləri təhlükəsiz açmaq üçün atributlar
                            $attrs = 'target="_blank" rel="noopener noreferrer"';
                        @endphp

                        <div class="td_header_social_btns">
                            @if ($fb)
                                <a href="{{ $fb }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-facebook-f"></i></a>
                            @endif

                            @if ($tw)
                                <a href="{{ $tw }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-x-twitter"></i></a>
                            @endif

                            @if ($ig)
                                <a href="{{ $ig }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-instagram"></i></a>
                            @endif

                            {{-- Pinterest göstərilmir. Onun yerinə LinkedIn gəlir (Pinterest URL fallback kimi) --}}
                            @if ($li)
                                <a href="{{ $li }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-linkedin-in"></i></a>
                            @endif

                            @if ($wa)
                                <a href="{{ $wa }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-whatsapp"></i></a>
                            @endif
                        </div>

                    </div>

                    {{-- Center: Nav + center-logo --}}
                    <div class="td_main_header_center">
                        <nav class="td_nav">
                            <div class="td_nav_list_wrap">
                                <div class="td_nav_list_wrap_in">
                                    <ul class="td_nav_list">
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        <li><a href="{{ route('faqss') }}">Faqs</a></li>
                                        <li><a href="{{ route('about') }}">About Us</a></li>
                                        <li><a href="{{ route('resources') }}">Resources</a></li>
                                    </ul>
                                    <a class="td_site_branding" href="{{ route('home') }}">
                                        <img src="{{ $logoUrl }}" alt="Logo">
                                    </a>
                                    <ul class="td_nav_list">
                                        <li class="menu-item-has-children">
                                            <a href="{{ route('courses-grid-view') }}">Courses</a>
                                            <ul>
                                                <li><a href="{{ route('services') }}">Services</a></li>
                                                <li><a href="{{ route('topices') }}">Topices</a></li>
                                                <li><a href="{{ route('vacancies') }}">Vacancies</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('team') }}">Team</a></li>
                                        <li><a href="{{ route('contact') }}">Contact</a></li>
                                        @auth
                                            @if (auth()->user()->isAdmin())
                                                <a href="{{ route('admin.dashboard') }}"
                                                    class="td_btn td_style_1 td_medium">
                                                    <span
                                                        class="td_btn_in td_white_color td_accent_bg"><span>Admin</span></span>
                                                </a>
                                            @endif
                                        @endauth
                                        @auth
                                            <li class="menu-item-has-children">
                                                <a href="#">{{ Auth::user()->name }}</a>
                                                <ul>
                                                    {{-- Gərək olsa profil/linklər bura --}}
                                                    <li>
                                                        <form method="POST" action="{{ route('logout') }}"
                                                            class="px-3 py-2">
                                                            @csrf
                                                            <button type="submit"
                                                                class="td_btn td_style_1 td_medium w-100">
                                                                <span class="td_btn_in td_white_color td_accent_bg">
                                                                    <span>Logout</span>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>

                    {{-- Right: Language + Search + Auth quick controls + Hamburger --}}
                    <div class="td_main_header_right">
                        <div class="position-relative td_language_wrap">
                            <button class="td_header_dropdown_btn td_medium td_heading_color">
                                <span>English</span>
                                <img src="{{ asset('assets/img/icons/world.svg') }}" alt=""
                                    class="td_header_dropdown_btn_icon">
                            </button>
                            <ul class="td_header_dropdown_list td_mp_0">
                                <li><a href="#">English</a></li>
                                <li><a href="#">Spanish</a></li>
                                <li><a href="#">Russian</a></li>
                            </ul>
                        </div>

                        <div class="position-relative" id="globalSearch">
                            <button class="td_circle_btn td_center td_search_tobble_btn" type="button">
                                <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt="">
                            </button>
                            <div class="td_header_search_wrap">
                                <form action="javascript:void(0)" class="td_header_search" autocomplete="off">
                                    <input type="text" class="td_header_search_input" id="globalSearchInput"
                                        placeholder="Search For Anything">
                                    <button class="td_header_search_btn td_center" type="submit">
                                        <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt="">
                                    </button>
                                </form>

                                <!-- AJAX nəticələr burada çıxacaq -->
                                <div id="globalSearchResults" style="display:none;"></div>
                            </div>
                        </div>
                        <script>
                            (function() {
                                const root = document.getElementById('globalSearch');
                                if (!root) return;

                                const input = document.getElementById('globalSearchInput');
                                const box = document.getElementById('globalSearchResults');

                                let timer = null;

                                function render(html) {
                                    box.innerHTML = html || '';
                                    box.style.display = html ? 'block' : 'none';
                                }

                                function search(q) {
                                    if (!q || q.trim() === '') {
                                        render('');
                                        return;
                                    }
                                    fetch(`{{ route('search') }}?q=${encodeURIComponent(q)}`, {
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest'
                                            }
                                        })
                                        .then(r => r.json())
                                        .then(({
                                            html
                                        }) => render(html))
                                        .catch(() => render('<div class="gsearch-dropdown"><div class="gsearch-empty">Error.</div></div>'));
                                }

                                input.addEventListener('input', function() {
                                    clearTimeout(timer);
                                    timer = setTimeout(() => search(this.value), 280);
                                });

                                // submit enter -> axtarış işə düşsün
                                root.querySelector('form').addEventListener('submit', (e) => {
                                    e.preventDefault();
                                    search(input.value);
                                });

                                // çöldə klik -> bağla
                                document.addEventListener('click', (e) => {
                                    if (!root.contains(e.target)) render('');
                                });
                            })();
                        </script>

                        {{-- TOP-RIGHT Auth controls (compact) --}}
                        @guest
                            <div class="d-inline-flex align-items-center gap-2 ms-2">
                                <a href="{{ route('auth.show', 'login') }}" class="td_btn td_style_1 td_medium">
                                    <span class="td_btn_in td_white_color td_heading_bg"><span>Login</span></span>
                                </a>
                                <a href="{{ route('auth.show', 'register') }}" class="td_btn td_style_1 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg"><span>Register</span></span>
                                </a>
                            </div>
                        @endguest
                        <button class="td_hamburger_btn"></button>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="td_side_header">
        <button class="td_close"></button>
        <div class="td_side_header_overlay"></div>
        <div class="td_side_header_in">
            <div class="td_side_header_shape"></div>
            <a class="td_site_branding" href="index.html">
                <img src="{{ asset('assets/img/logo_black.svg') }}" alt="Logo">

            </a>
            <div class="td_side_header_box">
                <h2 class="td_side_header_heading">Do you have a project in your <br> mind? Keep connect us.</h2>
            </div>
            <div class="td_side_header_box">
                <h3 class="td_side_header_title td_heading_color">Contact Us</h3>
                <ul class="td_side_header_contact_info td_mp_0">
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <span><a href="tel:+444547800112">+44 454 7800 112</a></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <span><a href="mailto:example@gmail.com">example@gmail.com</a></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>50 Wall Street Suite, 44150 <br>Ohio, United States</span>
                    </li>
                </ul>
            </div>
            <div class="td_side_header_box">
                <h3 class="td_side_header_title td_heading_color">Subscribe</h3>
                <div class="td_newsletter td_style_1">
                    <form class="td_newsletter_form" action="{{ route('subscribe') }}" method="POST"
                        id="newsletterForm">
                        @csrf
                        <input type="email" name="email" class="td_newsletter_input" placeholder="Email address"
                            required>
                        <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                            <span class="td_btn_in td_white_color td_accent_bg"><span>Subscribe Now</span></span>
                        </button>
                    </form>

                    @if (session('sub_ok'))
                        <div class="alert alert-success mt-2">{{ session('sub_ok') }}</div>
                    @endif

                    <script>
                        // İstəsən AJAX:
                        document.getElementById('newsletterForm')?.addEventListener('submit', async function(e) {
                            if (!this.hasAttribute('data-ajax')) return; // istəsən attribute ilə aktiv et
                            e.preventDefault();
                            const formData = new FormData(this);
                            const res = await fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData
                            });
                            const json = await res.json().catch(() => ({}));
                            alert(json?.message || 'Subscribed.');
                            this.reset();
                        });
                    </script>

                </div>
            </div>
            <div class="td_side_header_box">
                <h3 class="td_side_header_title td_heading_color">Follow Us</h3>
                <div class="td_social_btns td_style_1 td_heading_color">
                    <a href="#" class="td_center">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="td_center">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="td_center">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="#" class="td_center">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Section -->
    <!-- Start Hero Section -->
    {{-- Home – Hero (settings-driven) --}}
    @php
        $hero = setting('home.hero', []);
        $kicker = data_get($hero, 'kicker', 'Knowledge is Power');
        $titleHtml = data_get($hero, 'title', '<span>Educve</span> - The Best Place to Invest in your Knowledge');
        $subtitle = data_get(
            $hero,
            'subtitle',
            'A university is a vibrant institution that serves as a hub for higher education and research. It provides a dynamic environment.',
        );
        $ctaText = data_get($hero, 'cta.text', 'View Our Program');
        $ctaUrl = data_get($hero, 'cta.url', 'courses-grid-view.html');

        // BG image: settings → fallback asset
        $bg = setting('home.hero.bg_image'); // opsional açar; yoxdursa default asset
        $bgUrl = $bg
            ? (Str::startsWith($bg, ['http', '/storage', 'assets/'])
                ? asset($bg)
                : asset('storage/' . ltrim($bg, '/')))
            : asset('assets/img/home_1/hero_bg_1.jpg');
    @endphp

    <section class="td_hero td_style_1 td_heading_bg td_center td_bg_filed" data-src="{{ $bgUrl }}">
        <div class="container">
            <div class="td_hero_text wow fadeInRight" data-wow-duration="0.9s" data-wow-delay="0.35s">
                @if ($kicker)
                    <p
                        class="td_hero_subtitle_up td_fs_18 td_white_color td_spacing_1 td_semibold text-uppercase td_mb_10 td_opacity_9">
                        {{ $kicker }}
                    </p>
                @endif

                <h1 class="td_hero_title td_fs_64 td_white_color td_mb_12">
                    {!! $titleHtml !!}
                </h1>

                @if ($subtitle)
                    <p class="td_hero_subtitle td_fs_18 td_white_color td_opacity_7 td_mb_30">
                        {{ $subtitle }}
                    </p>
                @endif

                @if ($ctaText && $ctaUrl)
                    <a href="{{ $ctaUrl }}" class="td_btn td_style_1 td_radius_10 td_medium">
                        <span class="td_btn_in td_white_color td_accent_bg">
                            <span>{{ $ctaText }}</span>
                            <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                @endif
            </div>
        </div>

        <div class="td_lines">
            <span></span><span></span><span></span><span></span>
        </div>
    </section>


    <div class="container">
        <div class="td_hero_btn_group">
            <a href="courses-grid-view.html" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Apply Now</span>
                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
            <a href="signup.html" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Request Info</span>
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.7945 12.2734H8.95703C8.74129 12.2734 8.56641 12.4484 8.56641 12.6641V14.768C8.56641 14.9837 8.74129 15.1587 8.95703 15.1587H10.7945C11.0102 15.1587 11.1851 14.9837 11.1851 14.768V12.6641C11.1851 12.4483 11.0102 12.2734 10.7945 12.2734ZM10.4038 14.3774H9.34766V13.0547H10.4038V14.3774Z"
                            fill="currentColor" />
                        <path
                            d="M13.0728 5.01978C12.7536 4.76443 12.3872 4.57568 11.9835 4.45861C10.202 3.94346 8.23896 4.61154 7.50396 6.33584C7.43154 6.5058 7.48806 6.7033 7.63951 6.80916L9.08424 7.81908C9.26111 7.94267 9.50451 7.89955 9.62814 7.72279C9.69381 7.62896 9.76912 7.5208 9.85353 7.39881C9.99142 7.19982 10.1816 7.0499 10.397 6.94576C10.489 6.90123 10.5962 6.87959 10.7247 6.87959C10.9277 6.87959 11.1021 6.93791 11.2577 7.05779C11.3854 7.15627 11.4423 7.28365 11.4423 7.47084C11.4423 7.60982 11.4012 7.72803 11.3129 7.84279C10.9575 8.30463 10.4116 8.55889 9.86623 8.85221C9.58689 9.00271 9.35529 9.17463 9.17787 9.36326C8.99771 9.55474 8.85728 9.76459 8.76064 9.9867C8.66752 10.2002 8.60357 10.4253 8.57072 10.6556C8.54017 10.8694 8.52466 11.0956 8.52466 11.3281C8.52466 11.5438 8.69955 11.7187 8.91529 11.7187H10.7668C10.9825 11.7187 11.1574 11.5438 11.1574 11.3281C11.1574 11.2158 11.1831 11.1262 11.2361 11.054C11.3113 10.9515 11.415 10.8558 11.5446 10.7694C11.971 10.485 12.1675 10.4474 12.6908 10.0988C13.1681 9.79709 13.5367 9.43678 13.7863 9.02787C14.043 8.60728 14.1732 8.0881 14.1732 7.48482C14.1732 6.92166 14.0697 6.42881 13.8654 6.01959C13.6629 5.61494 13.3962 5.27853 13.0728 5.01978ZM13.1195 8.62096C12.9324 8.92744 12.6465 9.2033 12.2698 9.44084C12.2104 9.47803 12.018 9.61357 11.7039 9.77424C11.4899 9.88385 11.2904 10 11.1112 10.1195C10.9053 10.2567 10.7354 10.4158 10.6062 10.592C10.5289 10.6973 10.471 10.8128 10.4325 10.9376H9.32384C9.38525 10.2872 9.62193 9.87127 10.2365 9.54021C10.8783 9.19498 11.4781 8.9092 11.9322 8.3192C12.1255 8.06775 12.2235 7.78236 12.2235 7.47092C12.2235 7.0426 12.0545 6.68584 11.7346 6.43908C11.4411 6.21303 11.1014 6.09842 10.7247 6.09842C10.479 6.09842 10.2543 6.14693 10.0567 6.24256C9.47986 6.52142 9.24478 6.91709 9.21091 6.95451L8.36205 6.36111C8.56916 5.99974 8.85256 5.71349 9.22185 5.49123C9.98404 5.03264 10.9217 4.9649 11.7661 5.20908C12.0706 5.29736 12.3461 5.43892 12.5847 5.62986C12.8193 5.81756 13.0152 6.06631 13.1666 6.36892C13.3161 6.66849 13.392 7.04396 13.392 7.4849C13.392 7.94252 13.3003 8.32474 13.1195 8.62096Z"
                            fill="currentColor" />
                        <path
                            d="M10.5 1.32812C5.75047 1.32812 1.90625 5.17172 1.90625 9.92188C1.90625 11.5843 2.37914 13.1897 3.27582 14.5779L2.08254 18.1577C1.98266 18.4573 2.26367 18.7482 2.56801 18.6546L6.39953 17.4756C7.65207 18.1565 9.06594 18.5156 10.5 18.5156C15.2495 18.5156 19.0938 14.672 19.0938 9.92184C19.0938 5.17238 15.2502 1.32812 10.5 1.32812ZM10.5 17.7343C9.14422 17.7343 7.80855 17.3815 6.63734 16.7139C6.54387 16.6606 6.4323 16.6481 6.32902 16.6799L3.06375 17.6846L4.07715 14.6444C4.11562 14.529 4.09812 14.4023 4.02984 14.3016C3.15168 13.007 2.6875 11.4925 2.6875 9.92188C2.6875 5.61406 6.19219 2.10938 10.5 2.10938C14.8078 2.10938 18.3125 5.61406 18.3125 9.92188C18.3125 14.2296 14.8078 17.7343 10.5 17.7343Z"
                            fill="currentColor" />
                    </svg>
                </span>
            </a>
            <a href="#" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Chat With Us</span>
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_34_1694)">
                            <path
                                d="M2.80635 15.5992C2.13805 15.5992 1.48514 15.4286 0.893423 15.0964C0.588974 14.9396 0.471056 14.5473 0.652933 14.2522C1.25723 13.2866 1.47544 12.1062 1.19876 10.9962C0.911987 9.84535 0.497046 8.87611 0.500016 7.65782C0.510313 3.38361 4.06791 -0.0814611 8.33776 0.0014578C12.4619 0.0845253 15.8608 3.55138 15.8609 7.67663C15.8609 13.0643 10.2146 16.8469 5.22991 14.7664C4.54285 15.3057 3.67925 15.5992 2.80635 15.5992ZM1.99429 14.2838C2.93328 14.5754 3.98934 14.3424 4.71344 13.6424C4.89185 13.4699 5.15872 13.4265 5.38258 13.5335C9.65016 15.5739 14.6728 12.3758 14.6727 7.67663C14.6727 4.17008 11.8201 1.2599 8.31385 1.1893C4.70047 1.11752 1.69682 4.04399 1.68811 7.66069C1.68529 8.81785 2.13676 9.74263 2.38349 10.8388C2.64343 11.994 2.50651 13.2155 1.99429 14.2838Z"
                                fill="currentColor" />
                            <path
                                d="M18.193 20.0027C17.3201 20.0027 16.4565 19.7092 15.7695 19.17C13.1186 20.2763 9.96528 19.7725 7.79172 17.8954C7.5434 17.6809 7.51598 17.3059 7.73038 17.0575C7.94483 16.8092 8.31992 16.7817 8.56823 16.9962C10.496 18.661 13.3193 19.0355 15.6168 17.9371C15.8406 17.83 16.1074 17.8735 16.2859 18.046C17.01 18.746 18.0661 18.9791 19.0051 18.6873C18.4008 17.427 18.3171 15.9831 18.7854 14.6464C18.7896 14.6344 18.7942 14.6225 18.7991 14.6108C19.1411 13.8046 19.3134 12.9478 19.3113 12.0642C19.3075 10.5065 18.7893 9.06544 17.8126 7.89691C17.6022 7.64513 17.6358 7.27053 17.8875 7.06014C18.1392 6.8497 18.5139 6.88326 18.7242 7.13499C19.8646 8.49937 20.495 10.2489 20.4994 12.0614C20.5019 13.0995 20.3005 14.107 19.9008 15.0563C19.4809 16.2718 19.674 17.5732 20.3464 18.6557C20.5284 18.9508 20.4104 19.3431 20.1058 19.5C19.5142 19.8321 18.8612 20.0027 18.193 20.0027Z"
                                fill="currentColor" />
                            <path
                                d="M8.18217 8.64459C8.7013 8.64459 9.12215 8.22397 9.12215 7.70511C9.12215 7.18625 8.7013 6.76562 8.18217 6.76562C7.66303 6.76562 7.24219 7.18625 7.24219 7.70511C7.24219 8.22397 7.66303 8.64459 8.18217 8.64459Z"
                                fill="currentColor" />
                            <path
                                d="M4.71732 8.64459C5.23646 8.64459 5.6573 8.22397 5.6573 7.70511C5.6573 7.18625 5.23646 6.76562 4.71732 6.76562C4.19819 6.76562 3.77734 7.18625 3.77734 7.70511C3.77734 8.22397 4.19819 8.64459 4.71732 8.64459Z"
                                fill="currentColor" />
                            <path
                                d="M11.6431 8.64459C12.1622 8.64459 12.5831 8.22397 12.5831 7.70511C12.5831 7.18625 12.1622 6.76562 11.6431 6.76562C11.124 6.76562 10.7031 7.18625 10.7031 7.70511C10.7031 8.22397 11.124 8.64459 11.6431 8.64459Z"
                                fill="currentColor" />
                        </g>
                        <defs>
                            <clipPath id="clip0_34_1694">
                                <rect width="20" height="20" fill="currentColor"
                                    transform="translate(0.5)" />
                            </clipPath>
                        </defs>
                    </svg>
                </span>
            </a>
        </div>
    </div>
    <!-- End Hero Section -->

    {{-- About Section (settings-driven) --}}
    @php

        $est = setting('home.about.est_year', 'EST 1995');
        $kicker = setting('home.about.kicker', 'About us');
        $title = setting('home.about.title', 'The largest & Most Diverse Universities in the United Emirates');
        $subtitle = setting('home.about.subtitle', 'Far far away, behind the word mountains...');

        $items = setting('home.about.items', [
            ['title' => 'Graduate Program', 'text' => 'Browse the Undergraduate Degrees'],
            ['title' => 'Undergraduate Program', 'text' => 'Browse the Undergraduate Degrees'],
        ]);

        $img1 = setting('home.about.image_1');
        $img2 = setting('home.about.image_2');
        $circle = setting('home.about.circle_img');
        $video = setting('home.about.video_url', 'https://www.youtube.com/embed/rRid6GCJtgc');

        $img1Url = $img1
            ? (Str::startsWith($img1, ['http', '/storage', 'assets/'])
                ? asset($img1)
                : asset('storage/' . $img1))
            : asset('assets/img/home_1/about_img_1.jpg');
        $img2Url = $img2
            ? (Str::startsWith($img2, ['http', '/storage', 'assets/'])
                ? asset($img2)
                : asset('storage/' . $img2))
            : asset('assets/img/home_1/about_img_2.jpg');
        $circleUrl = $circle
            ? (Str::startsWith($circle, ['http', '/storage', 'assets/'])
                ? asset($circle)
                : asset('storage/' . $circle))
            : asset('assets/img/home_1/about_circle_text.svg');

        $cta = setting('home.about.cta', ['text' => 'More About', 'url' => 'courses-grid-view.html']);
    @endphp

    <section>
        <div class="td_height_120 td_height_lg_80"></div>
        <div class="td_about td_style_1">
            <div class="container">
                <div class="row align-items-center td_gap_y_40">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.25s">
                        <div class="td_about_thumb_wrap">
                            <div class="td_about_year text-uppercase td_fs_64 td_bold">{{ $est }}</div>
                            <div class="td_about_thumb_1"><img src="{{ $img1Url }}" alt=""></div>
                            <div class="td_about_thumb_2"><img src="{{ $img2Url }}" alt=""></div>
                            <a href="{{ $video }}" class="td_circle_text td_center td_video_open">
                                <svg width="15" height="19" viewBox="0 0 15 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.086 8.63792C14.6603 9.03557 14.6603 9.88459 14.086 10.2822L2.54766 18.2711C1.88444 18.7303 0.978418 18.2557 0.978418 17.449L0.978418 1.47118C0.978418 0.664496 1.88444 0.189811 2.54767 0.649016L14.086 8.63792Z"
                                        fill="white" />
                                </svg>
                                <img src="{{ $circleUrl }}" alt="">
                            </a>
                            <div class="td_circle_shape"></div>
                        </div>
                    </div>

                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                        <div class="td_section_heading td_style_1 td_mb_30">
                            <p
                                class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                                {{ $kicker }}</p>
                            <h2 class="td_section_title td_fs_48 mb-0">{{ $title }}</h2>
                            <p class="td_section_subtitle td_fs_18 mb-0">{{ $subtitle }}</p>
                        </div>

                        <div class="td_mb_40">
                            <ul class="td_list td_style_5 td_mp_0">
                                @foreach ($items as $it)
                                    <li>
                                        <h3 class="td_fs_24 td_mb_8">{{ data_get($it, 'title') }}</h3>
                                        <p class="td_fs_18 mb-0">{{ data_get($it, 'text') }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <a href="{{ data_get($cta, 'url', '') }}" class="td_btn td_style_1 td_radius_10 td_medium">
                            <span class="td_btn_in td_white_color td_accent_bg">
                                <span>{{ data_get($cta, 'text', 'More About') }}</span>
                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>




    <!-- Start Popular Courses -->
    <section class="td_gray_bg_3">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.15s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    Popular Courses</p>
                <h2 class="td_section_title td_fs_48 mb-0">Academic Courses</h2>
            </div>
            <div class="td_height_30 td_height_lg_30"></div>
            <div class="td_tabs">
                <ul class="td_tab_links td_style_1 td_mp_0 td_fs_20 td_medium td_heading_color wow fadeInUp"
                    data-wow-duration="1s" data-wow-delay="0.2s">
                    <li class="active"><a href="#tab_1">Courses</a></li>
                    <li><a href="#tab_2">Services</a></li>
                    <li><a href="#tab_3">Topics</a></li>
                    <li><a href="#tab_4">Vacancies</a></li>
                </ul>
                <div class="td_height_50 td_height_lg_50"></div>
                <style>
                    /* --- Uniform card/grid fixes --- */
                    .td_card.td_style_3 {
                        display: flex;
                        flex-direction: column;
                        height: 100%;
                    }

                    .td_card.td_style_3 .td_card_thumb {
                        position: relative;
                        width: 100%;
                        /* 16:9 sabit nisbət (istəsən 4:3/3:2 edə bilərsən) */
                        aspect-ratio: 16 / 9;
                        overflow: hidden;
                        border-top-left-radius: 10px;
                        border-top-right-radius: 10px;
                    }

                    .td_card.td_style_3 .td_card_thumb img {
                        position: absolute;
                        inset: 0;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }

                    /* Məlumat hissəsi bütün qalan hündürlüyü tutsun */
                    .td_card.td_style_3 .td_card_info {
                        flex: 1;
                        display: flex;
                    }

                    .td_card.td_style_3 .td_card_info_in {
                        display: flex;
                        flex-direction: column;
                        width: 100%;
                    }

                    /* Başlıq və təsvir üçün səliqəli clamp – kart boyları eyni qalsın */
                    .td_card.td_style_3 .td_card_title {
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        min-height: 3.2em;
                        /* 2 sətirlik yer */
                    }

                    .td_card.td_style_3 .td_card_subtitle {
                        display: -webkit-box;
                        -webkit-line-clamp: 3;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        min-height: 3.9em;
                        /* 3 sətirlik yer */
                    }

                    /* Düymə həmişə altda qalsın */
                    .td_card.td_style_3 .td_card_btn {
                        margin-top: auto;
                    }
                </style>

                <div class="td_tab_body">
                    <!-- tab_1: COURSES -->
                    <div class="td_tab active" id="tab_1">
                        <div class="row td_gap_y_24">
                            @forelse($courses as $it)
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="0.1s">
                                    <div class="td_card td_style_3 d-block td_radius_10">
                                        <a href="{{ route('course-details', $it) }}" class="td_card_thumb">
                                            <img src="{{ $it->imageUrl ?: asset('assets/img/home_1/course_thumb_1.jpg') }}"
                                                alt="{{ $it->name }}">
                                        </a>
                                        <div class="td_card_info td_white_bg">
                                            <div class="td_card_info_in">
                                                <a href="{{ route('courses-grid-view') }}"
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                    <span>Course</span>
                                                </a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16">
                                                    <a
                                                        href="{{ route('course-details', $it) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}
                                                </p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('course-details', $it) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span class="td_btn_in td_white_color td_accent_bg"><span>View
                                                                Details</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">No courses yet.</div>
                            @endforelse
                        </div>
                    </div>



                    <!-- tab_2: SERVICES -->
                    <div class="td_tab" id="tab_2">
                        <div class="row td_gap_y_24">
                            @forelse($services as $it)
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="0.1s">
                                    <div class="td_card td_style_3 d-block td_radius_10">
                                        <a href="{{ route('service-details', $it->id) }}" class="td_card_thumb">
                                            <img src="{{ $it->imageUrl ?: asset('assets/img/home_1/course_thumb_3.jpg') }}"
                                                alt="{{ $it->name }}">
                                        </a>
                                        <div class="td_card_info td_white_bg">
                                            <div class="td_card_info_in">
                                                <a href="{{ route('services') }}"
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                    <span>Service</span>
                                                </a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16">
                                                    <a
                                                        href="{{ route('service-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}
                                                </p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('service-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span class="td_btn_in td_white_color td_accent_bg"><span>View
                                                                Details</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">No services yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- tab_3: TOPICS -->
                    <div class="td_tab" id="tab_3">
                        <div class="row td_gap_y_24">
                            @forelse($topics as $it)
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="0.1s">
                                    <div class="td_card td_style_3 d-block td_radius_10">
                                        <a href="{{ route('topices-details', $it->id) }}" class="td_card_thumb">
                                            <img src="{{ $it->imageUrl ?: asset('assets/img/home_1/course_thumb_4.jpg') }}"
                                                alt="{{ $it->name }}">
                                        </a>
                                        <div class="td_card_info td_white_bg">
                                            <div class="td_card_info_in">
                                                <a href="{{ route('topices') }}"
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                    <span>Topic</span>
                                                </a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16">
                                                    <a
                                                        href="{{ route('topices-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}
                                                </p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('topices-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span class="td_btn_in td_white_color td_accent_bg"><span>View
                                                                Details</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">No topics yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- tab_4: VACANCIES -->
                    <div class="td_tab" id="tab_4">
                        <div class="row td_gap_y_24">
                            @forelse($vacancies as $it)
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="0.1s">
                                    <div class="td_card td_style_3 d-block td_radius_10">
                                        <a href="{{ route('vacancies-details', $it->id) }}" class="td_card_thumb">
                                            <img src="{{ $it->imageUrl ?: asset('assets/img/home_1/course_thumb_6.jpg') }}"
                                                alt="{{ $it->name }}">
                                        </a>
                                        <div class="td_card_info td_white_bg">
                                            <div class="td_card_info_in">
                                                <a href="{{ route('vacancies') }}"
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                    <span>Vacancy</span>
                                                </a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16">
                                                    <a
                                                        href="{{ route('vacancies-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}
                                                </p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('vacancies-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span class="td_btn_in td_white_color td_accent_bg"><span>View
                                                                Details</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">No vacancies yet.</div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Popular Courses -->


    {{-- Start Feature Section (settings-driven) --}}
    @php
        $kicker = setting('home.features.kicker', 'CAMPUS');
        $title = setting('home.features.title', 'Campus is your Dream Lifestyle');

        $img = setting('home.features.image');
        $imgUrl = $img
            ? (Str::startsWith($img, ['http', '/storage', 'assets/'])
                ? asset($img)
                : asset('storage/' . $img))
            : asset('assets/img/home_1/feature_img.jpg');

        $list = array_slice(setting('home.features.list', []), 0, 4);
    @endphp

    <section>
        <div class="td_height_120 td_height_lg_80"></div>
        <div class="container">
            <div class="td_features td_style_1 td_hobble">

                <div class="td_features_thumb">
                    <img src="{{ $imgUrl }}" alt="" class="td_radius_10 wow fadeInUp"
                        data-wow-duration="1s" data-wow-delay="0.2s">
                </div>

                <div class="td_features_content td_white_bg td_radius_10 wow fadeInRight" data-wow-duration="1s"
                    data-wow-delay="0.25s">
                    <div class="td_section_heading td_style_1">
                        <p
                            class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                            {{ $kicker }}</p>
                        <h2 class="td_section_title td_fs_48 mb-0">{{ $title }}</h2>
                    </div>

                    <div class="td_height_50 td_height_lg_50"></div>

                    <ul class="td_feature_list td_mp_0">
                        @foreach ($list as $it)
                            @php
                                $icon = data_get($it, 'icon');
                                $iconUrl = $icon
                                    ? (Str::startsWith($icon, ['http', '/storage', 'assets/'])
                                        ? asset($icon)
                                        : asset('storage/' . $icon))
                                    : null;
                            @endphp
                            <li>
                                <div class="td_feature_icon td_center">
                                    @if ($iconUrl)
                                        <img src="{{ $iconUrl }}" alt=""
                                            style="width:60px;height:60px;object-fit:contain;">
                                    @endif
                                </div>
                                <div class="td_feature_info">
                                    <h3 class="td_fs_32 td_semibold td_mb_15">{{ data_get($it, 'title') }}</h3>
                                    @if (data_get($it, 'text'))
                                        <p class="td_fs_14 td_heading_color td_opacity_7 mb-0">
                                            {{ data_get($it, 'text') }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- shape-lər eyni qalsın --}}
                <div class="td_features_shape_1 position-absolute td_accent_color td_hover_layer_3">
                    <svg><!-- ... --></svg>
                </div>
                <div class="td_features_shape_2 position-absolute td_accent_color td_hover_layer_5">
                    <svg><!-- ... --></svg>
                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    {{-- End Feature Section --}}



    {{-- Start Campus Life (settings-driven, fixed) --}}
    @php
        $campus = setting('home.campus', []);
        $title = data_get($campus, 'title', 'Navigate');
        $subtitle = data_get($campus, 'subtitle', null);
        $ctaText = data_get($campus, 'cta.text');
        $ctaUrl = data_get($campus, 'cta.url', '#');

        // 4 kartla məhdudlaşdır
        $cards = array_values(array_slice(data_get($campus, 'cards', []), 0, 4));

        // Yalnız URL qaytaran helper (HTML çıxarmır!)
        $toUrl = function (?string $path, ?string $fallback = null) {
            if (!$path && $fallback) {
                return asset($fallback);
            }
            if (!$path) {
                return '';
            }
            return Str::startsWith($path, ['http', '/storage', 'assets/'])
                ? asset($path)
                : asset('storage/' . ltrim($path, '/'));
        };
    @endphp

    <section class="td_accent_bg td_shape_section_1">
        <div class="td_shape_position_4 td_accent_color position-absolute">
            {{-- dekorativ svg-lər eyni qalır --}}
            <svg width="37" height="40" viewBox="0 0 37 40" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.4">
                    <rect y="12.3906" width="23.6182" height="31.0709" rx="1"
                        transform="rotate(-30.4551 0 12.3906)" fill="white" />
                    <rect x="4" y="14.8125" width="18.5361" height="2.62207" rx="1.31104"
                        transform="rotate(-30.4551 4 14.8125)" fill="currentColor" />
                    <rect x="7" y="19.8125" width="18.5361" height="2.62207" rx="1.31104"
                        transform="rotate(-30.4551 7 19.8125)" fill="currentColor" />
                </g>
            </svg>
        </div>

        <div class="td_height_120 td_height_lg_80"></div>
        <div class="container">
            <div class="row td_gap_y_40">
                {{-- Sol: başlıq + altmətn + CTA --}}
                <div class="col-lg-5 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_height_57 td_height_lg_0"></div>
                    <div class="td_section_heading td_style_1">
                        <h2 class="td_section_title td_fs_48 mb-0 td_white_color">{{ $title }}</h2>
                        @if ($subtitle)
                            <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
                                {{ $subtitle }}
                            </p>
                        @endif
                    </div>

                    @if ($ctaText)
                        <div class="td_btn_box">
                            {{-- dekorativ svg eyni qalır --}}
                            <svg width="299" height="315" viewBox="0 0 299 315" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.75" clip-path="url(#clip0_34_2222)">
                                    <path d="M242.757 275.771C242.505 275.771..." fill="white" />
                                    <path d="M299.002 275.455C271.709 283.305..." fill="white" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_34_2222">
                                        <rect width="299" height="314" fill="white"
                                            transform="translate(0 0.421875)" />
                                    </clipPath>
                                </defs>
                            </svg>

                            <div class="td_btn_box_in">
                                <a href="{{ $ctaUrl ?: '#' }}"
                                    class="td_btn td_style_1 td_radius_10 td_medium td_fs_18">
                                    <span class="td_btn_in td_heading_color td_white_bg">
                                        <span>{{ $ctaText }}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sağ: kart grid (0,2 sol sütun; 1,3 sağ sütun) --}}
                <div class="col-lg-6 offset-lg-1">
                    <div class="row">
                        {{-- Sol sütun --}}
                        <div class="col-sm-6">
                            @if (isset($cards[0]))
                                @php
                                    $c0 = $cards[0];
                                    $c0Title = data_get($c0, 'title', '');
                                    $c0Url = data_get($c0, 'url', '#');
                                    $c0Img = $toUrl(data_get($c0, 'image'));
                                @endphp
                                <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="0.2s">
                                    <a href="{{ $c0Url }}" class="td_card_thumb d-block">
                                        <img src="{{ $c0Img }}" alt="{{ $c0Title }}" class="w-100">
                                    </a>
                                    <div class="td_card_info">
                                        <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                            <a href="{{ $c0Url }}">{{ $c0Title }}</a>
                                        </h2>
                                        <a href="{{ $c0Url }}" class="td_card_btn"></a>
                                    </div>
                                </div>
                                <div class="td_height_40 td_height_lg_30"></div>
                            @endif

                            @if (isset($cards[2]))
                                @php
                                    $c2 = $cards[2];
                                    $c2Title = data_get($c2, 'title', '');
                                    $c2Url = data_get($c2, 'url', '#');
                                    $c2Img = $toUrl(data_get($c2, 'image'));
                                @endphp
                                <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="0.3s">
                                    <a href="{{ $c2Url }}" class="td_card_thumb d-block">
                                        <img src="{{ $c2Img }}" alt="{{ $c2Title }}" class="w-100">
                                    </a>
                                    <div class="td_card_info">
                                        <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                            <a href="{{ $c2Url }}">{{ $c2Title }}</a>
                                        </h2>
                                        <a href="{{ $c2Url }}" class="td_card_btn"></a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Sağ sütun --}}
                        <div class="col-sm-6">
                            <div class="td_height_50 td_height_lg_30"></div>

                            @if (isset($cards[1]))
                                @php
                                    $c1 = $cards[1];
                                    $c1Title = data_get($c1, 'title', '');
                                    $c1Url = data_get($c1, 'url', '#');
                                    $c1Img = $toUrl(data_get($c1, 'image'));
                                @endphp
                                <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="0.25s">
                                    <a href="{{ $c1Url }}" class="td_card_thumb d-block">
                                        <img src="{{ $c1Img }}" alt="{{ $c1Title }}" class="w-100">
                                    </a>
                                    <div class="td_card_info">
                                        <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                            <a href="{{ $c1Url }}">{{ $c1Title }}</a>
                                        </h2>
                                        <a href="{{ $c1Url }}" class="td_card_btn"></a>
                                    </div>
                                </div>
                                <div class="td_height_40 td_height_lg_30"></div>
                            @endif

                            @if (isset($cards[3]))
                                @php
                                    $c3 = $cards[3];
                                    $c3Title = data_get($c3, 'title', '');
                                    $c3Url = data_get($c3, 'url', '#');
                                    $c3Img = $toUrl(data_get($c3, 'image'));
                                @endphp
                                <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="0.3s">
                                    <a href="{{ $c3Url }}" class="td_card_thumb d-block">
                                        <img src="{{ $c3Img }}" alt="{{ $c3Title }}" class="w-100">
                                    </a>
                                    <div class="td_card_info">
                                        <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                            <a href="{{ $c3Url }}">{{ $c3Title }}</a>
                                        </h2>
                                        <a href="{{ $c3Url }}" class="td_card_btn"></a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="td_height_112 td_height_lg_75"></div>
    </section>
    {{-- End Campus Life --}}



    @php
        // MIME yoxlamaları
        function resIsPdf($mimeOrUrl)
        {
            $s = strtolower((string) $mimeOrUrl);
            return str_contains($s, 'application/pdf') || str_ends_with($s, '.pdf');
        }
        function resIsImage($mimeOrUrl)
        {
            $s = strtolower((string) $mimeOrUrl);
            return str_contains($s, 'image/') || preg_match('/\.(png|jpe?g|gif|webp|bmp|svg)$/', $s);
        }
        function resIsVideo($mimeOrUrl)
        {
            $s = strtolower((string) $mimeOrUrl);
            return str_contains($s, 'video/') || preg_match('/\.(mp4|webm|ogg|mov|m4v)$/', $s);
        }
        // fallback ikonları
        function resIcon($mime)
        {
            $m = strtolower((string) $mime);
            if (str_contains($m, 'pdf')) {
                return asset('assets/img/icons/file-pdf.svg');
            }
            if (str_contains($m, 'video')) {
                return asset('assets/img/icons/file-video.svg');
            }
            if (str_contains($m, 'image')) {
                return asset('assets/img/icons/file-img.svg');
            }
            return asset('assets/img/icons/file.svg');
        }
    @endphp

    <section>
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center">
                <h2 class="td_section_title td_fs_48 mb-0">Fresh Learning Materials & Downloads</h2>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>

            @if (isset($resources) && $resources->count())
                @php $hero = $resources->first(); @endphp

                <div class="row td_gap_y_30">
                    <!-- FEATURED -->
                    <div class="col-lg-6">
                        <div class="td_card td_style_1 td_radius_5">
                            <a href="{{ route('resources-details', $hero->id) }}"
                                class="td_card_thumb td_mb_30 d-block res-thumb"
                                style="display:flex;align-items:center;justify-content:center;background:#0b1324;aspect-ratio:16/9;border-radius:8px;overflow:hidden;"
                                data-src="{{ $hero->resourceUrl }}" data-mime="{{ $hero->mime ?? '' }}">
                                {{-- IMG default (icon və ya real şəkil) --}}
                                <img class="res-thumb-img" alt="Resource"
                                    src="{{ resIsImage($hero->resourceUrl ?: $hero->mime) ? $hero->resourceUrl : resIcon($hero->mime) }}"
                                    style="max-width:100%;max-height:100%;object-fit:contain;display:block;">
                                {{-- Canvas (PDF/video üçün) --}}
                                <canvas class="res-thumb-canvas"
                                    style="display:none;width:100%;height:100%;"></canvas>
                            </a>

                            <div class="td_card_info">
                                <div class="td_card_info_in">
                                    <div class="td_mb_20">
                                        <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                            <li><span>{{ optional($hero->created_at)->format('M d , Y') }}</span></li>
                                            <li><span>{{ $hero->mime ?: 'file' }}</span></li>
                                        </ul>
                                    </div>
                                    <h2 class="td_card_title td_fs_32 td_semibold td_mb_16">
                                        <a
                                            href="{{ route('resources-details', $hero->id) }}">{{ $hero->name }}</a>
                                    </h2>
                                    <p class="td_mb_24 td_fs_18">
                                        {{ $hero->type?->name ?? 'Resource' }} @if ($hero->year)
                                            • {{ $hero->year }}
                                        @endif
                                        @if ($hero->mime)
                                            • {{ $hero->mime }}
                                        @endif
                                    </p>
                                    <div class="td_card_btn">
                                        <a href="{{ route('resources-details', $hero->id) }}"
                                            class="td_btn td_style_1 td_radius_10 td_medium">
                                            <span class="td_btn_in td_white_color td_accent_bg"><span>View /
                                                    Download</span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3 SMALL CARDS -->
                    <div class="col-lg-6 td_gap_y_30 flex-wrap d-flex">
                        @foreach ($resources->skip(1) as $res)
                            <div class="td_card td_style_1 td_type_1" style="flex:1 1 100%;max-width:100%;">
                                <a href="{{ route('resources-details', $res->id) }}"
                                    class="td_card_thumb d-block res-thumb"
                                    style="display:flex;align-items:center;justify-content:center;background:#0b1324;aspect-ratio:16/9;border-radius:8px;overflow:hidden;"
                                    data-src="{{ $res->resourceUrl }}" data-mime="{{ $res->mime ?? '' }}">
                                    <img class="res-thumb-img" alt="Resource"
                                        src="{{ resIsImage($res->resourceUrl ?: $res->mime) ? $res->resourceUrl : resIcon($res->mime) }}"
                                        style="max-width:100%;max-height:100%;object-fit:contain;display:block;">
                                    <canvas class="res-thumb-canvas"
                                        style="display:none;width:100%;height:100%;"></canvas>
                                </a>
                                <div class="td_card_info">
                                    <div class="td_card_info_in">
                                        <a href="{{ route('resources') }}"
                                            class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                            <span>{{ $res->type?->name ?? 'Resource' }}</span>
                                        </a>
                                        <h3 class="td_card_title td_fs_22 td_semibold td_mb_12">
                                            <a
                                                href="{{ route('resources-details', $res->id) }}">{{ $res->name }}</a>
                                        </h3>
                                        <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_16">
                                            @if ($res->year)
                                                {{ $res->year }} •
                                            @endif {{ $res->mime ?: 'file' }}
                                        </p>
                                        <a href="{{ route('resources-details', $res->id) }}"
                                            class="td_btn td_style_1 td_radius_10 td_medium">
                                            <span
                                                class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center text-muted">No resources yet.</div>
            @endif
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>


    {{-- Start Video Section (settings-driven) --}}
    @php

        $video = setting('home.video', []);
        $bgPath = data_get($video, 'bg_image', 'assets/img/home_1/video_bg.jpg');
        $heading = data_get($video, 'heading', 'Take a Video Tour to Learn <br>Intro of Campus');
        $youtube = data_get($video, 'youtube_url', 'https://www.youtube.com/embed/rRid6GCJtgc');

        $emailLabel = data_get($video, 'contact.email_label', 'Get In Touch:');
        $email = data_get($video, 'contact.email', 'info@eduon.com');

        $phoneLabel = data_get($video, 'contact.phone_label', 'Get In Touch:');
        $phone = data_get($video, 'contact.phone', '+01 998 7698 870');

        // URL builder: storage & asset & absolute
        $toUrl = function (?string $path, ?string $fallback = null) {
            if (!$path && $fallback) {
                return asset($fallback);
            }
            if (!$path) {
                return '';
            }
            return Str::startsWith($path, ['http', '/storage', 'assets/'])
                ? asset($path)
                : asset('storage/' . ltrim($path, '/'));
        };

        $bgUrl = $toUrl($bgPath, 'assets/img/home_1/video_bg.jpg');

        // tel: href üçün yalnız rəqəm və + saxla
        $telHref = $phone ? 'tel:' . preg_replace('/[^0-9\+]+/', '', $phone) : '#';
    @endphp

    <section>
        <div class="td_video_block td_style_1 td_accent_bg td_bg_filed td_center text-center"
            data-src="{{ $bgUrl }}">
            <div class="container">
                @if ($youtube)
                    <a href="{{ $youtube }}" class="td_player_btn_wrap_2 td_video_open wow zoomIn"
                        data-wow-duration="1s" data-wow-delay="0.2s">
                        <span class="td_player_btn td_center">
                            <span></span>
                        </span>
                    </a>
                @endif

                <div class="td_height_70 td_height_lg_50"></div>

                @if ($heading)
                    <h2 class="td_fs_48 td_white_color mb-0 wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay="0.2s">
                        {!! $heading !!}
                    </h2>
                @endif
            </div>
        </div>

        <div class="container wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
            <div class="td_contact_box td_style_1 td_accent_bg td_radius_10">
                <div class="td_contact_box_left">
                    <p class="td_fs_18 td_light td_white_color td_mb_4">{{ $emailLabel }}</p>
                    <h3 class="td_fs_36 mb-0 td_white_color">
                        @if ($email)
                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </h3>
                </div>

                <div class="td_contact_box_or td_fs_24 td_medium td_white_bg td_center rounded-circle td_accent_color">
                    or
                </div>

                <div class="td_contact_box_right">
                    <p class="td_fs_18 td_light td_white_color td_mb_4">{{ $phoneLabel }}</p>
                    <h3 class="td_fs_36 mb-0 td_white_color">
                        @if ($phone)
                            <a href="{{ $telHref }}">{{ $phone }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </h3>
                </div>
            </div>
        </div>
    </section>
    {{-- End Video Section --}}



    <!-- Start Accreditation Showcase (replaces Event Schedule) -->
    <section>
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">

            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    Accreditations
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Recognitions & Partnerships</h2>
            </div>

            <div class="td_height_50 td_height_lg_50"></div>

            @if (isset($accreds) && $accreds->count())
                @php
                    $hero = $accreds->first();
                @endphp

                <div class="row td_gap_y_30">
                    <!-- Left: Featured accreditation -->
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="td_card td_style_1 td_radius_5">
                            <a href="{{ route('about') }}#accreditations" class="td_card_thumb td_mb_30 d-block">
                                <img src="{{ $hero->imageUrl ?: asset('assets/img/others/faq_bg_1.jpg') }}"
                                    alt="Accreditation">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                <span class="td_card_location td_medium td_white_color td_fs_18">
                                    <svg width="16" height="22" viewBox="0 0 16 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.0004 0.5C3.86669 0.5..." fill="currentColor" />
                                    </svg>
                                    {{ optional($hero->created_at)->format('M d, Y') }}
                                </span>
                            </a>

                            <div class="td_card_info">
                                <div class="td_card_info_in">
                                    <div class="td_mb_20">
                                        <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                            <li>
                                                <svg class="td_accent_color" width="22" height="24"
                                                    viewBox="0 0 22 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.3308 11.7869H19.0049..." fill="currentColor" />
                                                </svg>
                                                <span>{{ optional($hero->created_at)->format('M d , Y') }}</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <h2 class="td_card_title td_fs_32 td_semibold td_mb_16">
                                        <a href="{{ route('about') }}#accreditations">Featured Accreditation</a>
                                    </h2>

                                    <p class="td_mb_24 td_fs_18">
                                        {{ Str::limit(strip_tags($hero->description ?? ''), 180) ?: 'International recognition and partnership highlight.' }}
                                    </p>

                                    <a href="{{ route('about') }}#accreditations"
                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                        <span class="td_btn_in td_white_color td_accent_bg">
                                            <span>Learn More</span>
                                            <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: 3 compact cards -->
                    <div class="col-lg-6 td_gap_y_30 flex-wrap d-flex wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay="0.3s">
                        @foreach ($accreds->skip(1) as $a)
                            <div class="td_card td_style_1 td_type_1" style="flex:1 1 100%; max-width:100%;">
                                <a href="{{ route('about') }}#accreditations" class="td_card_thumb d-block">
                                    <img src="{{ $a->imageUrl ?: asset('assets/img/others/faq_bg_1.jpg') }}"
                                        alt="Accreditation">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                                <div class="td_card_info">
                                    <div class="td_card_info_in">
                                        <h3 class="td_fs_22 td_semibold td_mb_10">
                                            <a href="{{ route('about') }}#accreditations">Accreditation</a>
                                        </h3>
                                        <p class="td_fs_16 td_heading_color td_opacity_8 td_mb_16">
                                            {{ Str::limit(strip_tags($a->description ?? ''), 110) ?: 'Recognition / partnership details.' }}
                                        </p>
                                        <a href="{{ route('about') }}#accreditations"
                                            class="td_btn td_style_1 td_radius_10 td_medium">
                                            <span class="td_btn_in td_white_color td_accent_bg">
                                                <span>Details</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Fallback: əgər akkreditasiya yoxdursa, köhnə event blokunu göstərə bilərsən (istəsən buranı sil) --}}
                <div class="text-center text-muted">No accreditations yet.</div>
            @endif

        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Accreditation Showcase -->


    <!-- Start Team Highlight (replaces Testimonial) -->
    <section class="td_heading_bg td_hobble">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <h2 class="td_section_title td_fs_48 mb-0 td_white_color">Start your journey With Us</h2>
                <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
                    Meet our featured expert from HSE.AZ
                </p>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>

            @if ($heroTeam)
                @php
                    $maleDefault =
                        'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
                    $femaleDefault =
                        'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';
                    $thumb = $heroTeam->imageUrl ?: ($heroTeam->gender === 'female' ? $femaleDefault : $maleDefault);
                @endphp

                <div class="row align-items-center td_gap_y_40">
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="td_testimonial_img_wrap">
                            <img src="{{ $thumb }}" alt="{{ $heroTeam->full_name }}"
                                class="td_testimonial_img"
                                style="object-fit:cover;border-radius:18px;aspect-ratio:4/3;width:100%;height:auto;">
                            <span class="td_testimonial_img_shape_1"><span></span></span>
                            <span class="td_testimonial_img_shape_2 td_accent_color td_hover_layer_3">
                                <!-- dekorativ svg qalır -->
                                <svg width="145" height="165" viewBox="0 0 145 165" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="34" cy="150" r="15" fill="currentColor" />
                                    <circle cx="15" cy="137" r="15" fill="currentColor" />
                                    <circle cx="24" cy="144" r="15" fill="white" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="td_white_bg td_radius_5"
                            style="border-radius:14px;border:1px solid #eef2f7;padding:26px 24px;">
                            <div class="d-flex align-items-center gap-3 td_mb_20">
                                <div
                                    style="width:58px;height:58px;border-radius:50%;overflow:hidden;border:1px solid #eee;">
                                    <img src="{{ $thumb }}" alt="{{ $heroTeam->full_name }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div>
                                    <h3 class="td_fs_24 td_semibold td_mb_2">{{ $heroTeam->full_name }}</h3>
                                    <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">
                                        {{ $heroTeam->position ?: 'Team Member' }}</p>
                                </div>
                            </div>

                            <blockquote class="td_fs_18 td_heading_color td_opacity_9" style="line-height:1.7;">
                                {!! \Illuminate\Support\Str::limit(strip_tags($heroTeam->description ?? ''), 320) ?: '—' !!}
                            </blockquote>

                            @php
                                $skills = (array) ($heroTeam->skills ?? []);
                                $skills = array_values(array_filter($skills, fn($s) => !empty($s['name'])));
                            @endphp

                            @if (count($skills))
                                <div class="td_height_10"></div>
                                @foreach (array_slice($skills, 0, 3) as $s)
                                    @php $p = (int)($s['percent'] ?? 0); @endphp
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between td_medium">
                                            <span>{{ $s['name'] }}</span><span>{{ $p }}%</span>
                                        </div>
                                        <div class="progress" style="height:8px;background:#f1f5f9;">
                                            <div class="progress-bar td_accent_bg" role="progressbar"
                                                style="width: {{ $p }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="d-flex gap-2 td_mt_20">
                                <a href="{{ route('team-details', $heroTeam) }}"
                                    class="td_btn td_style_1 td_radius_10 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg"><span>View
                                            Profile</span></span>
                                </a>
                                @if ($heroTeam->email)
                                    <a href="mailto:{{ $heroTeam->email }}"
                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                        <span class="td_btn_in td_accent_color td_white_bg"><span>Email</span></span>
                                    </a>
                                @endif
                                @if ($heroTeam->phone)
                                    <a href="tel:{{ preg_replace('/\s+/', '', $heroTeam->phone) }}"
                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                        <span class="td_btn_in td_accent_color td_white_bg"><span>Call</span></span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Team Highlight -->

    {{-- Start Departments Section (settings-driven) --}}
    @php

        $deps = setting('home.departments', []);
        $kicker = data_get($deps, 'kicker', 'Departments');
        $title = data_get($deps, 'title', 'Popular Departments');
        $subtitle = data_get($deps, 'subtitle', null);
        $list = array_values(array_slice(data_get($deps, 'list', []), 0, 8));

        // URL builder: http|/storage|assets -> asset(); qalanı storage/..
        $toUrl = function (?string $path): string {
            if (!$path) {
                return '';
            }
            return Str::startsWith($path, ['http', '/storage', 'assets/'])
                ? asset($path)
                : asset('storage/' . ltrim($path, '/'));
        };
    @endphp

    <section>
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                @if ($kicker)
                    <p
                        class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                        {{ $kicker }}
                    </p>
                @endif

                <h2 class="td_section_title td_fs_48 mb-0">{{ $title }}</h2>

                @if ($subtitle)
                    <p class="td_section_subtitle td_fs_18 mb-0">{!! $subtitle !!}</p>
                @endif
            </div>

            <div class="td_height_50 td_height_lg_50"></div>

            <div class="td_iconbox_1_wrap">
                @foreach ($list as $i => $it)
                    @php
                        $itTitle = data_get($it, 'title', '');
                        $icon = $toUrl(data_get($it, 'icon'));
                        // 0.2s, 0.3s, 0.4s ... artan gecikmə
                        $delay = number_format(0.2 + $i * 0.1, 2) . 's';
                    @endphp

                    <div class="td_iconbox td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay="{{ $delay }}">
                        <div class="td_iconbox_icon td_accent_color td_mb_10">
                            @if ($icon)
                                <img src="{{ $icon }}" alt="{{ $itTitle }}" width="100"
                                    height="100" style="width:100px;height:100px;object-fit:contain;">
                            @endif
                        </div>
                        <p style="font-size: 24px" class="td_iconbox_title mb-0 td_medium td_fs_36">
                            {{ $itTitle }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    {{-- End Departments Section --}}




    <!-- Start Footer Section -->
    <footer class="td_footer td_style_1">
        <div class="container">
            <div class="td_footer_row">
                <div class="td_footer_col">
                    {{-- Footer – Site (settings-driven, with site.logo + fallback to branding.logo) --}}


                    <div class="td_footer_widget">
                        <div class="td_footer_text_widget td_fs_18">
                            @if ($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $siteName }}"
                                    style="max-height:64px; width:auto;">
                            @else
                                {{-- Logo yoxdursa sənin SVG fallback-ı göstərilir --}}
                                <svg width="241" height="64" viewBox="0 0 241 64" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    {{-- ... SVG path-ların burda qalır ... --}}
                                </svg>
                            @endif

                            {{-- Tagline settings-dən (site.tagline) gəlir, yoxdursa default mətn --}}
                            <p>{{ $tagline }}</p>
                        </div>

                        <ul class="td_footer_address_widget td_medium td_mp_0">
                            @if ($phone && $telHref)
                                <li>
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <a href="{{ $telHref }}">{{ $phone }}</a>
                                </li>
                            @endif

                            @if ($email)
                                <li>
                                    <i class="fa-solid fa-envelope"></i>
                                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                                </li>
                            @endif

                            @if ($address)
                                <li>
                                    <i class="fa-solid fa-location-dot"></i>
                                    {!! nl2br(e($address)) !!}
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Navigate</h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('faqss') }}">Faqs</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('resources') }}">Resources</a></li>
                            <li><a href="{{ route('team') }}">Team</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Courses</h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="{{ route('courses-grid-view') }}">Courses</a></li>
                            <li><a href="{{ route('services') }}">Services</a></li>
                            <li><a href="{{ route('topices') }}">Topices</a></li>
                            <li><a href="{{ route('vacancies') }}">Vacancies</a></li>
                        </ul>
                    </div>
                </div>
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Subscribe Now
                        </h2>
                        <div class="td_newsletter td_style_1">
                            <p class="td_mb_20 td_opacity_7">Far far away, behind the word mountains, far from the
                                Consonantia.</p>
                            <form class="td_newsletter_form" action="{{ route('subscribe') }}" method="POST"
                                id="newsletterForm">
                                @csrf
                                <input type="email" name="email" class="td_newsletter_input"
                                    placeholder="Email address" required>
                                <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg"><span>Subscribe
                                            Now</span></span>
                                </button>
                            </form>

                            @if (session('sub_ok'))
                                <div class="alert alert-success mt-2">{{ session('sub_ok') }}</div>
                            @endif

                            <script>
                                // İstəsən AJAX:
                                document.getElementById('newsletterForm')?.addEventListener('submit', async function(e) {
                                    if (!this.hasAttribute('data-ajax')) return; // istəsən attribute ilə aktiv et
                                    e.preventDefault();
                                    const formData = new FormData(this);
                                    const res = await fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        body: formData
                                    });
                                    const json = await res.json().catch(() => ({}));
                                    alert(json?.message || 'Subscribed.');
                                    this.reset();
                                });
                            </script>

                        </div>
                        <div class="td_footer_social_btns td_fs_20">
                            @if ($fb)
                                <a href="{{ $fb }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-facebook-f"></i></a>
                            @endif

                            @if ($tw)
                                <a href="{{ $tw }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-x-twitter"></i></a>
                            @endif

                            @if ($ig)
                                <a href="{{ $ig }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-instagram"></i></a>
                            @endif

                            {{-- Pinterest göstərilmir. Onun yerinə LinkedIn gəlir (Pinterest URL fallback kimi) --}}
                            @if ($li)
                                <a href="{{ $li }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-linkedin-in"></i></a>
                            @endif

                            @if ($wa)
                                <a href="{{ $wa }}" class="td_center" {!! $attrs !!}><i
                                        class="fa-brands fa-whatsapp"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_footer_bottom td_fs_18">
            <div class="container">
                <div class="td_footer_bottom_in">
                    <p class="td_copyright mb-0">Copyright ©educve | All Right Reserved</p>
                    <ul class="td_footer_widget_menu">
                        <li><a href="#"> Terms & Conditions</a></li>
                        <li><a href="#">Privacy & Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- End Footer Section -->
    <!-- Start Scroll Up Button -->
    <div class="td_scrollup">
        <i class="fa-solid fa-arrow-up"></i>
    </div>
    <!-- End Scroll Up Button -->
    <!-- Script -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/odometer.js') }}"></script>
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
