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
        <style>
            .container {
                max-width: 100%;
                padding-left: 100px;
                padding-right: 100px;
            }

            .td_top_header_in {
                display: flex;
                align-items: center;
                gap: 16px;
                width: 100%;
            }

            .td_top_header_left {
                flex: 1 1 auto;
                max-width: calc(100% - 220px);
                overflow: hidden;
                white-space: nowrap;
            }

            .typed-text {
                font-weight: 950;
                font-size: 14px;
                color: #fff;
                white-space: pre;
                display: inline-block;
            }

            .td_top_header_right {
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                gap: 12px;
                white-space: nowrap;
            }

            /* MAIN HEADER */
            .td_main_header_in {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }

            /* Left block now holds logo + primary nav in a single row */
            .td_header_bar_left {
                display: flex;
                align-items: center;
                gap: 28px;
                flex: 1 1 auto;
                min-width: 0;
            }

            .td_site_branding {
                display: inline-flex;
                align-items: center;
            }

            .td_site_branding img {
                height: 48px;
                width: auto;
                display: block;
            }

            /* Nav sits directly to the right of the logo */
            .td_nav {
                flex: 1 1 auto;
            }

            .td_nav_list_wrap {
                overflow: visible;
            }

            .td_nav_list_wrap_in {
                display: block;
            }

            .td_nav_list {
                display: inline-flex;
                align-items: center;
                gap: 20px;
                margin: 0;
                padding: 0;
                list-style: none;
                white-space: nowrap;
            }

            .td_nav_list>li {
                position: relative;
            }

            .td_nav_list>li>a {
                display: inline-block;
                padding: 12px 6px;
            }

            /* Dropdowns */
            .td_nav_list>li.menu-item-has-children>ul {
                position: absolute;
                top: 100%;
                left: 0;
                background: #fff;
                min-width: 220px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
                padding: 8px 0;
                margin: 0;
                list-style: none;
                display: none;
                z-index: 50;
            }

            .td_nav_list>li.menu-item-has-children:hover>ul {
                display: block;
            }

            .td_nav_list>li.menu-item-has-children>ul>li>a {
                display: block;
                padding: 10px 14px;
            }

            /* Right controls area */
            .td_main_header_right {
                display: flex;
                align-items: center;
                gap: 12px;
                flex: 0 0 auto;
            }

            /* Optional: collapse nav spacing a bit on narrower widths */
            @media (max-width: 1200px) {
                .td_nav_list {
                    gap: 14px;
                }

                .container {
                    padding-left: 24px;
                    padding-right: 24px;
                }
            }

            /* Very small screens—let your theme’s hamburger takeover */
            @media (max-width: 992px) {
                .td_nav {
                    display: none;
                }
            }


            /* --- Right cluster layout tweaks --- */
            .td_main_header_right {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            /* Language & Search keep their spacing consistent */
            .td_language_wrap {
                margin-right: 4px;
            }

            /* --- Social buttons --- */
            .td_header_social_btns {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .td_social_btn {
                --btn-bg: rgba(15, 23, 42, .06);
                /* default soft bg */
                --btn-icon: #0f172a;
                /* default icon */
                --btn-ring: rgba(15, 23, 42, .25);

                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                border-radius: 999px;
                background: var(--btn-bg);
                color: var(--btn-icon);
                border: 1px solid rgba(15, 23, 42, .06);
                box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
                transition: background .2s ease, color .2s ease, transform .15s ease, box-shadow .2s ease, border-color .2s ease;
            }

            .td_social_btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 18px rgba(15, 23, 42, .10);
                border-color: rgba(15, 23, 42, .10);
            }

            /* Focus for keyboard users */
            .td_social_btn:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px var(--btn-ring);
            }

            /* Brand hover accents (icon turns white, bg turns brand) */
            .td_social_btn--fb:hover {
                background: #1877F2;
                color: #fff;
            }

            .td_social_btn--tw:hover {
                background: #111;
                color: #fff;
            }

            /* X */
            .td_social_btn--ig:hover {
                background: radial-gradient(120% 120% at 0% 100%, #feda75, #d62976 50%, #962fbf 75%, #4f5bd5);
                color: #fff;
            }

            .td_social_btn--li:hover {
                background: #0A66C2;
                color: #fff;
            }

            .td_social_btn--wa:hover {
                background: #25D366;
                color: #fff;
            }

            /* Dark mode friendly defaults */
            @media (prefers-color-scheme: dark) {
                .td_social_btn {
                    --btn-bg: rgba(255, 255, 255, .06);
                    --btn-icon: #e5e7eb;
                    --btn-ring: rgba(255, 255, 255, .35);
                    border-color: rgba(255, 255, 255, .08);
                    box-shadow: 0 2px 8px rgba(0, 0, 0, .35);
                }
            }

            /* Reduce motion support */
            @media (prefers-reduced-motion: reduce) {

                .td_social_btn,
                .td_social_btn:hover {
                    transition: none;
                    transform: none;
                }
            }

            /* Optional: make the search button visually match pills */
            .td_circle_btn {
                width: 36px;
                height: 36px;
                border-radius: 999px;
                background: rgba(15, 23, 42, .06);
                border: 1px solid rgba(15, 23, 42, .06);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .td_circle_btn:hover {
                background: rgba(15, 23, 42, .10);
            }
        </style>

        <!-- TOP STRIP -->
        <div class="td_top_header td_heading_bg td_white_color">
            <div class="container">
                <div class="td_top_header_in">
                    <div class="td_top_header_left">
                        <div class="typed-text" id="typedText"></div>
                    </div>

                    <div class="td_top_header_right">
                        @guest
                            <span>
                                <a href="{{ route('auth.show', 'login') }}">{{ __('Sign in') }}</a> /
                                <a href="{{ route('auth.show', 'register') }}">{{ __('Sign up') }}</a>
                            </span>
                        @endguest

                        @auth
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="td_btn td_style_1 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg"><span>Admin Panel</span></span>
                                </a>
                            @endif

                            <div class="d-inline-flex align-items-center gap-3">
                                <span class="td_medium">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="td_btn td_style_1 td_medium">
                                        <span class="td_btn_in td_white_color td_accent_bg">
                                            <span>{{ __('Log out') }}</span>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function() {
                const text =
                    "Welcome to the first health, safety, environmental web portal of Azerbaijan.The Constitution of the Republic of Azerbaijan, Article 35/VI Everyone has right to work in safe and healthy workplace....";
                const typedText = document.getElementById('typedText');
                if (!typedText) return;
                let i = 0;

                function tick() {
                    if (i < text.length) {
                        typedText.innerHTML += text.charAt(i++);
                        setTimeout(tick, 50);
                    }
                }
                window.addEventListener('load', tick);
            })();
        </script>


        <!-- MAIN HEADER -->
        <div class="td_main_header">
            <div class="container-fluid">
                <div class="td_main_header_in">

                    <!-- LEFT: Logo + Main Nav (side-by-side) -->
                    <div class="td_header_bar_left">
                        <a class="td_site_branding" href="{{ route('home') }}" aria-label="Logo">
                            <img src="{{ $logoUrl }}" alt="Logo">
                        </a>

                        <!-- PRIMARY NAVIGATION -->
                        <nav class="td_nav" aria-label="Primary">
                            <div class="td_nav_list_wrap">
                                <div class="td_nav_list_wrap_in">
                                    <ul class="td_nav_list">
                                        <!-- 1) Home -->
                                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>

                                        <!-- 2) About Us (dropdown) -->
                                        <li class="menu-item-has-children">
                                            <a href="{{ route('about') }}">{{ __('About Us') }}</a>
                                            <ul>
                                                <li><a href="{{ route('about') }}">{{ __('Who we are') }}</a>
                                                </li>
                                                <li><a href="{{ route('about') }}">{{ __('Vision & Mission') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('about') }}">{{ __('Licenses & Accreditations') }}</a>
                                                </li>
                                                <li><a href="{{ route('team') }}">{{ __('Team') }}</a></li>
                                                <li><a href="{{ route('faqss') }}">{{ __('FAQ') }}</a></li>
                                            </ul>
                                        </li>

                                        <!-- 3) Contact -->
                                        <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                                        <!-- 4) Services (dropdown) -->
                                        <li class="menu-item-has-children">
                                            <a href="{{ route('services') }}">{{ __('Services') }}</a>
                                            <ul>
                                                <li><a
                                                        href="{{ route('services') }}?q=Training">{{ __('Training') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('services') }}?q=Consultancy">{{ __('Consultancy') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('services') }}?q=Evacuation%20Map">{{ __('Evacuation Map') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('services') }}?q=Instruction%20Books">{{ __('Instruction Books') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('services') }}?q=Safety%20Signs">{{ __('Safety Signs') }}</a>
                                                </li>
                                            </ul>
                                        </li>


                                        <!-- 5) Training (dropdown) -->
                                        <li class="menu-item-has-children">
                                            <a href="{{ route('courses-grid-view') }}">{{ __('Training') }}</a>
                                            <ul>
                                                <li><a
                                                        href="{{ route('courses-grid-view') }}?q=IOSH">{{ __('IOSH') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('courses-grid-view') }}?q=NEBOSH">{{ __('NEBOSH') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('courses-grid-view') }}?q=CIEH">{{ __('CIEH') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('courses-grid-view') }}?q=IIRSM">{{ __('IIRSM') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('courses-grid-view') }}?q=NSC">{{ __('NSC') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('courses-grid-view') }}?q=Local%20Training">{{ __('Local Training') }}</a>
                                                </li>
                                                <li><a
                                                        href="{{ route('courses-grid-view') }}?q=E-learning">{{ __('E-learning') }}</a>
                                                </li>
                                            </ul>
                                        </li>


                                        <!-- 6) Resources -->
                                        <li><a href="{{ route('resources') }}">{{ __('Resources') }}</a></li>

                                        <!-- 7) Topics -->
                                        <li><a href="{{ route('topices') }}">{{ __('Topics') }}</a></li>

                                        <!-- 8) Vacancies -->
                                        <li><a href="{{ route('vacancies') }}">{{ __('Vacancies') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <!-- RIGHT: Language + Search + Socials + Hamburger -->
                    <div class="td_main_header_right">
                        @php
                            $labels = ['en' => __('English'), 'az' => __('Azerbaijani'), 'ru' => __('Russian')];
                            $currentLocale = app()->getLocale();
                        @endphp

                        <div class="position-relative td_language_wrap">
                            <button class="td_header_dropdown_btn td_medium td_heading_color" type="button">
                                <span
                                    data-current-lang-label>{{ $labels[$currentLocale] ?? strtoupper($currentLocale) }}</span>
                                <img src="{{ asset('assets/img/icons/world.svg') }}" alt=""
                                    class="td_header_dropdown_btn_icon">
                            </button>
                            <ul class="td_header_dropdown_list td_mp_0">
                                @foreach ($labels as $code => $label)
                                    <li>
                                        {{-- data-lang → JS instant switch; href → istəsən URL-lə də keçid etsin --}}
                                        <a href="{{ url($code) }}" data-lang="{{ $code }}"
                                            hreflang="{{ $code }}" rel="alternate">{{ $label }}</a>
                                    </li>
                                @endforeach
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
                                <div id="globalSearchResults" style="display:none;"></div>
                            </div>
                        </div>

                        @php
                            $fb = setting('social.facebook');
                            $tw = setting('social.twitter');
                            $ig = setting('social.instagram');
                            $pin = setting('social.pinterest');
                            $wa = setting('social.whatsapp');
                            $li = setting('social.linkedin', $pin);
                            $attrs = 'target="_blank" rel="noopener noreferrer"';
                        @endphp

                        <div class="td_header_social_btns" aria-label="Social links">
                            @if ($fb)
                                <a href="{{ $fb }}" class="td_social_btn td_social_btn--fb"
                                    {!! $attrs !!} aria-label="Facebook" title="Facebook">
                                    <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($tw)
                                <a href="{{ $tw }}" class="td_social_btn td_social_btn--tw"
                                    {!! $attrs !!} aria-label="X (Twitter)" title="X (Twitter)">
                                    <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($ig)
                                <a href="{{ $ig }}" class="td_social_btn td_social_btn--ig"
                                    {!! $attrs !!} aria-label="Instagram" title="Instagram">
                                    <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($li)
                                <a href="{{ $li }}" class="td_social_btn td_social_btn--li"
                                    {!! $attrs !!} aria-label="LinkedIn" title="LinkedIn">
                                    <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($wa)
                                <a href="{{ $wa }}" class="td_social_btn td_social_btn--wa"
                                    {!! $attrs !!} aria-label="WhatsApp" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>


                        <button class="td_hamburger_btn" type="button"></button>
                    </div>
                </div>
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

                root.querySelector('form').addEventListener('submit', (e) => {
                    e.preventDefault();
                    search(input.value);
                });

                document.addEventListener('click', (e) => {
                    if (!root.contains(e.target)) render('');
                });
            })();
        </script>
    </header>


    <div class="td_side_header">
        <button class="td_close"></button>
        <div class="td_side_header_overlay"></div>
        <div class="td_side_header_in">
            <div class="td_side_header_shape"></div>
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $siteName }}" style="max-height:64px; width:auto;">
            @else
                {{-- Logo yoxdursa sənin SVG fallback-ı göstərilir --}}
                <svg width="241" height="64" viewBox="0 0 241 64" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    {{-- ... SVG path-ların burda qalır ... --}}
                </svg>
            @endif
            <div class="td_side_header_box">
                <h2 class="td_side_header_heading">Do you have a project in your <br> mind? Keep connect us.</h2>
            </div>
            <div class="td_side_header_box">
                <h3 class="td_side_header_title td_heading_color">Contact Us</h3>
                <ul class="td_side_header_contact_info td_mp_0">
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <span>
                            @if ($phone && $telHref)
                    <li>
                        <i class="fa-solid fa-phone-volume"></i>
                        <a href="{{ $telHref }}">{{ $phone }}</a>
                    </li>
                    @endif
                    </span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <span>
                            @if ($email)
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:{{ $email }}">{{ $email }}</a>
                    </li>
                    @endif
                    </span>
                    </li>
                    @if ($address)
                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            {!! nl2br(e($address)) !!}
                        </li>
                    @endif
                </ul>
            </div>
            <div class="td_side_header_box">
                <h3 class="td_side_header_title td_heading_color">{{ __('Subscribe') }}</h3>
                <div class="td_newsletter td_style_1">
                    <form class="td_newsletter_form" action="{{ route('subscribe') }}" method="POST"
                        id="newsletterForm">
                        @csrf
                        <input type="email" name="email" class="td_newsletter_input" placeholder="Email address"
                            required>
                        <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                            <span
                                class="td_btn_in td_white_color td_accent_bg"><span>{{ __('Subscribe now') }}</span></span>
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
    <!-- End Header Section -->
    <!-- Start Hero Section -->
    {{-- Home – Hero (settings-driven) --}}
    @php

        // Mövcud hero mətnləri (dəyişmir)
        $hero = setting('home.hero', []);
        $kicker = data_get($hero, 'kicker', 'Knowledge is Power');
        $titleHtml = data_get($hero, 'title', '<span>Educve</span> - The Best Place to Invest in your Knowledge');
        $subtitle = data_get(
            $hero,
            'subtitle',
            'A university is a vibrant institution that serves as a hub for higher education and research. It provides a dynamic environment.',
        );
        $ctaText = data_get($hero, 'cta.text', 'View Our Program');
        $ctaUrl = data_get($hero, 'cta.url', '/');

        // Köhnə tək BG məntiqini saxlayırıq (fallback üçün)
        $bg = setting('home.hero.bg_image');
        $bgUrl = $bg
            ? (Str::startsWith($bg, ['http', '/storage', 'assets/'])
                ? asset($bg)
                : asset('storage/' . ltrim($bg, '/')))
            : asset('assets/img/home_1/hero_bg_1.jpg');

        // YENİ: Home hero slider şəkilləri (0–12, opsional)
        $homeSlides = (array) setting('pages.heroes.home.images', []);
        $homeSlides = array_values(array_filter($homeSlides, fn($v) => is_string($v) && trim($v) !== ''));

        // Heç şəkil verilməyibsə: köhnə $bgUrl-i slayt kimi istifadə et
        if (count($homeSlides) === 0) {
            $homeSlides = [$bgUrl];
        }
    @endphp

    <section id="home-hero" class="td_hero td_style_1 td_heading_bg td_center">
        <style>
            /* ===== HOME HERO SLIDER ===== */
            #home-hero {
                position: relative;
                overflow: hidden;
            }

            #home-hero .hero-slider {
                position: absolute;
                inset: 0;
                z-index: 0;
            }

            #home-hero .hero-slide {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                opacity: 0;
                transition: opacity .8s ease-in-out;
                will-change: opacity;
            }

            #home-hero .hero-slide.is-active {
                opacity: 1;
            }

            #home-hero .hero-overlay {
                position: absolute;
                inset: 0;
                z-index: 1;
                background: linear-gradient(180deg, rgba(15, 23, 42, .25) 0%, rgba(15, 23, 42, .55) 100%);
            }

            #home-hero .td_hero_text {
                position: relative;
                z-index: 2;
            }

            #home-hero .td_lines {
                position: relative;
                z-index: 2;
            }
        </style>

        {{-- Arxa fon slaytları --}}
        <div class="hero-slider" aria-hidden="true">
            @foreach ($homeSlides as $i => $src)
                <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}"
                    style="background-image:url('{{ $src }}')"></div>
            @endforeach
            <div class="hero-overlay"></div>
        </div>

        <div class="container">
            <div class="td_hero_text wow fadeInRight" data-wow-duration="0.9s" data-wow-delay="0.35s">
                @if ($kicker)
                    <p
                        class="td_hero_subtitle_up td_fs_18 td_white_color td_spacing_1 td_semibold text-uppercase td_mb_10 td_opacity_9">
                        {{ $kicker }}
                    </p>
                @endif

                <h1 class="td_hero_title td_fs_64 td_white_color td_mb_12">{!! $titleHtml !!}</h1>

                @if ($subtitle)
                    <p class="td_hero_subtitle td_fs_18 td_white_color td_opacity_7 td_mb_30">{{ $subtitle }}</p>
                @endif

                @if ($ctaText && $ctaUrl)
                    <a href="{{ 'en/courses' }}" class="td_btn td_style_1 td_radius_10 td_medium">
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

    {{-- Slider JS: 2s interval; hover/tab gizlənəndə pauza --}}
    <script>
        (function() {
            const root = document.querySelector('#home-hero .hero-slider');
            if (!root) return;

            const slides = Array.from(root.querySelectorAll('.hero-slide'));
            if (slides.length <= 1) return;

            let idx = 0,
                timer = null;
            const INTERVAL = 2000;

            function show(i) {
                slides.forEach((s, k) => s.classList.toggle('is-active', k === i));
            }

            function next() {
                idx = (idx + 1) % slides.length;
                show(idx);
            }

            function start() {
                if (!timer) timer = setInterval(next, INTERVAL);
            }

            function stop() {
                if (timer) {
                    clearInterval(timer);
                    timer = null;
                }
            }

            start();

            const sec = document.getElementById('home-hero');
            sec.addEventListener('mouseenter', stop);
            sec.addEventListener('mouseleave', start);

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) stop();
                else start();
            });
        })();
    </script>



    <div class="container">
        <div class="td_hero_btn_group">
            <a href="#apply" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>{{ __('Subscribe now') }}</span>
                </span>
            </a>

            <a href="#request-info" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.45s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>{{ __('Request info') }}</span>
                </span>
            </a>

            <a href="#chat" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.55s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>{{ __('Chat With Us') }}</span>
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

        $cta = setting('home.about.cta', ['text' => 'More About', 'url' => '/']);
    @endphp

    <section id="home-about">
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

                        <a href="{{ data_get($cta, '', '') }}" class="td_btn td_style_1 td_radius_10 td_medium">
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
    <section id="home-courses" class="td_gray_bg_3">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.15s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    {{ __('Popular Courses') }}
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">{{ __('Academic Courses') }}</h2>
            </div>

            <div class="td_height_30 td_height_lg_30"></div>

            <div class="td_tabs">
                <ul class="td_tab_links td_style_1 td_mp_0 td_fs_20 td_medium td_heading_color wow fadeInUp"
                    data-wow-duration="1s" data-wow-delay="0.2s">
                    {{-- NOTE: clicking Courses opens the modal (see JS). It is not the active tab. --}}
                    <li><a href="#tab_1" id="openCoursesModal">{{ __('Courses') }}</a></li>
                    <li><a href="#tab_2">{{ __('Services') }}</a></li>
                    <li class="active"><a href="#tab_3" id="topicsTabLink">{{ __('Topics') }}</a></li>
                    <li><a href="#tab_4">{{ __('Vacancies') }}</a></li>
                </ul>

                <div class="td_height_50 td_height_lg_50"></div>

                <style>
                    /* --- Uniform card/grid fixes (used by Services/Topics/Vacancies) --- */
                    .td_card.td_style_3 {
                        display: flex;
                        flex-direction: column;
                        height: 100%
                    }

                    .td_card.td_style_3 .td_card_thumb {
                        position: relative;
                        width: 100%;
                        aspect-ratio: 16/9;
                        overflow: hidden;
                        border-top-left-radius: 10px;
                        border-top-right-radius: 10px
                    }

                    .td_card.td_style_3 .td_card_thumb img {
                        position: absolute;
                        inset: 0;
                        width: 100%;
                        height: 100%;
                        object-fit: cover
                    }

                    .td_card.td_style_3 .td_card_info {
                        flex: 1;
                        display: flex
                    }

                    .td_card.td_style_3 .td_card_info_in {
                        display: flex;
                        flex-direction: column;
                        width: 100%
                    }

                    .td_card.td_style_3 .td_card_title {
                        -webkit-line-clamp: 2;
                        display: -webkit-box;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        min-height: 3.2em
                    }

                    .td_card.td_style_3 .td_card_subtitle {
                        -webkit-line-clamp: 3;
                        display: -webkit-box;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        min-height: 3.9em
                    }

                    .td_card.td_style_3 .td_card_btn {
                        margin-top: auto
                    }

                    /* --- Courses Modal (slide-up drawer) --- */
                    .courses-modal_backdrop {
                        position: fixed;
                        inset: 0;
                        background: rgba(2, 6, 23, .45);
                        backdrop-filter: saturate(1.2) blur(2px);
                        display: none;
                        z-index: 9998;
                    }

                    .courses-modal {
                        position: fixed;
                        left: 50%;
                        bottom: -100%;
                        transform: translateX(-50%);
                        width: min(920px, 94vw);
                        background: #fff;
                        border-radius: 20px 20px 0 0;
                        box-shadow: 0 30px 60px rgba(2, 6, 23, .25);
                        z-index: 9999;
                        transition: bottom .28s ease;
                    }

                    .courses-modal_header {
                        padding: 18px 20px;
                        border-bottom: 1px solid #e5e7eb;
                        display: flex;
                        align-items: center;
                        justify-content: space-between
                    }

                    .courses-modal_title {
                        font-size: 22px;
                        font-weight: 800;
                        margin: 0
                    }

                    .courses-modal_close {
                        width: 36px;
                        height: 36px;
                        border-radius: 10px;
                        border: 1px solid #e5e7eb;
                        background: #fff;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .courses-modal_body {
                        padding: 18px 18px 2px
                    }

                    .chip-grid {
                        display: grid;
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                        gap: 10px
                    }

                    @media (min-width:576px) {
                        .chip-grid {
                            grid-template-columns: repeat(3, minmax(0, 1fr))
                        }
                    }

                    @media (min-width:768px) {
                        .chip-grid {
                            grid-template-columns: repeat(4, minmax(0, 1fr))
                        }
                    }

                    .chip {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 12px 14px;
                        border: 1px solid #e5e7eb;
                        border-radius: 12px;
                        background: #fff;
                        transition: transform .05s ease, box-shadow .15s ease, border-color .15s ease;
                        text-decoration: none;
                        color: #0f172a;
                        font-weight: 700
                    }

                    .chip:hover {
                        border-color: #fecaca;
                        box-shadow: 0 8px 22px rgba(2, 6, 23, .06)
                    }

                    .chip:active {
                        transform: translateY(1px)
                    }

                    .chip .dot {
                        width: 10px;
                        height: 10px;
                        border-radius: 9999px;
                        background: #e31b23;
                        box-shadow: 0 0 0 4px rgba(227, 27, 35, .08)
                    }

                    .courses-modal_footer {
                        padding: 14px 18px 18px;
                        display: flex;
                        gap: 10px;
                        justify-content: flex-end
                    }

                    .btn-outline {
                        border: 1px solid #e5e7eb;
                        background: #fff;
                        border-radius: 10px;
                        padding: 10px 14px;
                        font-weight: 700
                    }

                    .btn-primary {
                        border: 1px solid #e31b23;
                        background: #e31b23;
                        color: #fff;
                        border-radius: 10px;
                        padding: 10px 14px;
                        font-weight: 700
                    }

                    .courses-modal_backdrop.show {
                        display: block
                    }

                    .courses-modal.show {
                        bottom: 0
                    }
                </style>

                <div class="td_tab_body">
                    {{-- tab_1 is intentionally empty; clicking its tab opens the modal --}}
                    <div class="td_tab" id="tab_1" aria-hidden="true"></div>

                    {{-- tab_2: SERVICES --}}
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
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>{{ __('Service') }}</span></a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                        href="{{ route('service-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}</p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('service-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span
                                                            class="td_btn_in td_white_color td_accent_bg"><span>{{ __('View Details') }}</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">{{ __('No services yet.') }}</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- tab_3: TOPICS (DEFAULT ACTIVE ON LOAD) --}}
                    <div class="td_tab active" id="tab_3">
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
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>{{ __('Topic') }}</span></a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                        href="{{ route('topices-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}</p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('topices-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span
                                                            class="td_btn_in td_white_color td_accent_bg"><span>{{ __('View Details') }}</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">{{ __('No topics yet.') }}</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- tab_4: VACANCIES --}}
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
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>{{ __('Vacancy') }}</span></a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                        href="{{ route('vacancies-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}</p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('vacancies-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span
                                                            class="td_btn_in td_white_color td_accent_bg"><span>{{ __('View Details') }}</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">{{ __('No vacancies yet.') }}</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COURSES SLIDE-UP MODAL --}}
        @php
            $courseNames = ['IOSH', 'NEBOSH', 'CIEH', 'IIRSM', 'NSC', 'Local Training', 'E-learning'];
        @endphp
        <div class="courses-modal_backdrop" id="coursesBackdrop" aria-hidden="true"></div>
        <div class="courses-modal" id="coursesModal" role="dialog" aria-modal="true"
            aria-labelledby="coursesModalTitle" aria-describedby="coursesModalDesc">
            <div class="courses-modal_header">
                <h3 id="coursesModalTitle" class="courses-modal_title">{{ __('Academic Courses') }}</h3>
                <button type="button" class="courses-modal_close" id="closeCoursesModal"
                    aria-label="{{ __('Close') }}">✕</button>
            </div>
            <div class="courses-modal_body">
                <p id="coursesModalDesc" class="mb-3" style="color:#64748b">
                    {{ __('Choose a course brand/category to filter:') }}</p>
                <div class="chip-grid">
                    @foreach ($courseNames as $name)
                        <a class="chip" href="{{ route('courses-grid-view', ['q' => $name]) }}">
                            <span class="dot" aria-hidden="true"></span>
                            <span>{{ $name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="courses-modal_footer">
                <a class="btn-outline" href="{{ route('courses-grid-view') }}">{{ __('View all courses') }}</a>
                <button type="button" class="btn-primary" id="closeCoursesModal2">{{ __('Close') }}</button>
            </div>
        </div>

        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Popular Courses -->

    <script>
        (function() {
            const openBtn = document.getElementById('openCoursesModal');
            const modal = document.getElementById('coursesModal');
            const backdrop = document.getElementById('coursesBackdrop');
            const closeBtns = [document.getElementById('closeCoursesModal'), document.getElementById(
                'closeCoursesModal2')];

            function openModal(e) {
                if (e) e.preventDefault(); // stop tab switch
                backdrop.classList.add('show');
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                setTimeout(() => closeBtns[0]?.focus(), 60);
            }

            function closeModal() {
                backdrop.classList.remove('show');
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }

            openBtn?.addEventListener('click', openModal);
            backdrop?.addEventListener('click', closeModal);
            closeBtns.forEach(btn => btn?.addEventListener('click', closeModal));
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });

            // ------- Ensure Topics tab content is visible on initial load -------
            // Some tab scripts require syncing "active" on both tab link and content.
            // We set it in HTML, but also enforce here in case theme JS overwrites.
            const topicsLinkLi = document.querySelector('ul.td_tab_links li.active');
            const topicsTab = document.getElementById('tab_3');
            if (topicsLinkLi && topicsTab) {
                topicsTab.classList.add('active');
            } else {
                // fallback: if nothing active, make topics active
                document.querySelectorAll('.td_tab').forEach(t => t.classList.remove('active'));
                document.getElementById('tab_3')?.classList.add('active');
                const links = document.querySelectorAll('ul.td_tab_links li');
                links.forEach(li => li.classList.remove('active'));
                document.querySelector('ul.td_tab_links li:nth-child(3)')?.classList.add('active');
            }
        })();
    </script>


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

    <section id="home-features">
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

    <section id="home-campus" class="td_accent_bg td_shape_section_1">
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
                                <a href="{{ 'en/courses' }}"
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





<section id="home-resources">
    <div class="td_height_112 td_height_lg_75"></div>
    <div class="container">
        <div class="td_section_heading td_style_1 text-center">
            <h2 class="td_section_title td_fs_48 mb-0">
                {{ __('Fresh Learning Materials & Downloads') }}
            </h2>
        </div>
        <div class="td_height_50 td_height_lg_50"></div>

        @if (isset($resources) && $resources->count())
            @php
                /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\ResourceItem[] $resources */
                $hero = $resources->first();

                $heroExt  = strtolower(pathinfo($hero->resourceUrl, PATHINFO_EXTENSION) ?: '');
                $heroMime = strtolower($hero->mime ?? '');
                $heroIsImage =
                    \Illuminate\Support\Str::startsWith($heroMime, 'image/') ||
                    in_array($heroExt, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true);
                $heroIsPdf = !$heroIsImage && $heroExt === 'pdf';

                // Sağ list üçün loop
                $baseList = $resources->values()->all();
                if (count($baseList) < 4) {
                    $baseList = array_merge($baseList, $baseList);
                }
                $loopList = array_merge($baseList, $baseList);
            @endphp

            <div class="row td_gap_y_30">
                {{-- SOL: BÖYÜK HERO PREVIEW --}}
                <div class="col-lg-6">
                    <div style="background:transparent!important;border:none!important;box-shadow:none!important;">
                        <a id="res-hero-link"
                           href="{{ route('resources-details', $hero->id) }}"
                           style="text-decoration:none!important;color:inherit!important;">
                            <div id="res-hero-card"
                                 style="
                                    position:relative!important;
                                    border-radius:34px!important;
                                    overflow:hidden!important;
                                    height:460px!important;
                                    background:#020617!important;
                                    box-shadow:0 40px 110px rgba(15,23,42,0.95)!important;
                                 ">

                                {{-- MEDIA LAYER --}}
                                <div style="position:absolute!important;inset:0!important;overflow:hidden!important;">
                                    <img id="res-hero-img"
                                         src="{{ $heroIsImage ? $hero->resourceUrl : '' }}"
                                         alt=""
                                         style="
                                            width:100%!important;
                                            height:100%!important;
                                            object-fit:cover!important;
                                            display:{{ $heroIsImage ? 'block' : 'none' }}!important;
                                         ">

                                    <iframe id="res-hero-pdf"
                                            src="{{ $heroIsPdf ? $hero->resourceUrl . '#page=1&view=FitH' : '' }}"
                                            style="
                                                width:100%!important;
                                                height:100%!important;
                                                border:0!important;
                                                display:{{ $heroIsPdf ? 'block' : 'none' }}!important;
                                            ">
                                    </iframe>

                                    <div id="res-hero-icon"
                                         style="
                                            position:absolute!important;
                                            inset:0!important;
                                            display:{{ (!$heroIsImage && !$heroIsPdf) ? 'flex' : 'none' }}!important;
                                            align-items:center!important;
                                            justify-content:center!important;
                                            color:rgba(226,232,240,0.45)!important;
                                            font-size:72px!important;
                                        ">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </div>

                                    {{-- DARK GRADIENT OVERLAY --}}
                                    <div
                                        style="
                                            position:absolute!important;
                                            inset:0!important;
                                            background:
                                                linear-gradient(
                                                    to top,
                                                    rgba(15,23,42,0.98),
                                                    rgba(15,23,42,0.4),
                                                    transparent
                                                )!important;
                                        ">
                                    </div>
                                </div>

                                {{-- CONTENT LAYER --}}
                                <div
                                    style="
                                        position:absolute!important;
                                        inset:0!important;
                                        padding:24px 26px 26px 26px!important;
                                        display:flex!important;
                                        flex-direction:column!important;
                                        justify-content:space-between!important;
                                        z-index:2!important;
                                    ">

                                    <div
                                        style="
                                            display:flex!important;
                                            justify-content:space-between!important;
                                            align-items:flex-start!important;
                                            gap:12px!important;
                                        ">
                                        <div
                                            style="
                                                display:inline-flex!important;
                                                align-items:center!important;
                                                gap:8px!important;
                                                padding:6px 15px!important;
                                                border-radius:999px!important;
                                                background:rgba(15,23,42,0.9)!important;
                                                color:#e5e7eb!important;
                                                font-size:12px!important;
                                                font-weight:600!important;
                                                border:1px solid rgba(148,163,184,0.7)!important;
                                                letter-spacing:0.04em!important;
                                                text-transform:uppercase!important;
                                            ">
                                            <span
                                                style="
                                                    width:7px!important;
                                                    height:7px!important;
                                                    border-radius:999px!important;
                                                    background:#22c55e!important;
                                                    box-shadow:0 0 0 4px rgba(34,197,94,0.35)!important;
                                                ">
                                            </span>
                                            <span id="res-hero-type">
                                                {{ $hero->type?->name ?? 'Resource' }}
                                                @if ($hero->year)
                                                    • {{ $hero->year }}
                                                @endif
                                            </span>
                                        </div>

                                        @php $heroLabel = strtoupper($heroExt ?: ($hero->mime ?: 'file')); @endphp
                                        <span id="res-hero-ext"
                                              style="
                                                background:rgba(15,23,42,0.9)!important;
                                                color:#e5e7eb!important;
                                                border-radius:999px!important;
                                                padding:4px 11px!important;
                                                font-size:11px!important;
                                                font-weight:700!important;
                                                letter-spacing:0.08em!important;
                                                text-transform:uppercase!important;
                                                border:1px solid rgba(148,163,184,0.7)!important;
                                              ">
                                            {{ $heroLabel }}
                                        </span>
                                    </div>

                                    <div
                                        style="
                                            margin-top:auto!important;
                                            padding-top:12px!important;
                                        ">
                                        <div
                                            style="
                                                display:flex!important;
                                                flex-wrap:wrap!important;
                                                align-items:center!important;
                                                gap:8px!important;
                                                margin-bottom:8px!important;
                                                font-size:13px!important;
                                                color:#cbd5f5!important;
                                                opacity:0.9!important;
                                            ">
                                            <span id="res-hero-date">
                                                {{ optional($hero->created_at)->format('M d, Y') }}
                                            </span>
                                            @if ($hero->mime)
                                                <span
                                                    style="width:3px!important;height:3px!important;border-radius:999px!important;background:#9ca3af!important;">
                                                </span>
                                                <span id="res-hero-mime">{{ $hero->mime }}</span>
                                            @endif
                                        </div>

                                        <h2 id="res-hero-title"
                                            style="
                                                margin:0!important;
                                                font-size:28px!important;
                                                line-height:1.3!important;
                                                font-weight:600!important;
                                                color:#f9fafb!important;
                                                text-shadow:0 8px 22px rgba(15,23,42,0.98)!important;
                                            ">
                                            {{ $hero->name }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div style="padding-top:14px!important;">
                            <p id="res-hero-meta"
                               style="
                                    margin-bottom:18px!important;
                                    font-size:15px!important;
                                    color:#4b5563!important;
                               ">
                                {{ $hero->type?->name ?? 'Resource' }}
                                @if ($hero->year)
                                    • {{ $hero->year }}
                                @endif
                                @if ($hero->mime)
                                    • {{ $hero->mime }}
                                @endif
                            </p>
                            <a id="res-hero-cta"
                               href="{{ route('resources-details', $hero->id) }}"
                               class="td_btn td_style_1 td_radius_10 td_medium">
                                <span class="td_btn_in td_white_color td_accent_bg">
                                    <span>View / Download</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- SAĞ: VERTİKAL SCROLL + HOVER PREVIEW --}}
                <div class="col-lg-6">
                    <div class="js-res-list"
                         style="
                            position:relative!important;
                            overflow:hidden!important;
                            height:430px!important;
                         ">
                        <div class="js-res-list-track"
                             style="
                                position:relative!important;
                                display:flex!important;
                                flex-direction:column!important;
                                gap:16px!important;
                                will-change:transform!important;
                                animation:resListScroll 28s linear infinite!important;
                             ">
                            @foreach ($loopList as $res)
                                @php
                                    $ext  = strtolower(pathinfo($res->resourceUrl, PATHINFO_EXTENSION) ?: '');
                                    $mime = strtolower($res->mime ?? '');
                                    $isImage =
                                        \Illuminate\Support\Str::startsWith($mime, 'image/') ||
                                        in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true);
                                    $isPdf  = !$isImage && $ext === 'pdf';
                                    $label  = strtoupper($ext ?: ($res->mime ?: 'file'));
                                @endphp

                                <div class="js-res-item"
                                     data-id="{{ $res->id }}"
                                     data-title="{{ e($res->name) }}"
                                     data-type="{{ e($res->type?->name ?? 'Resource') }}"
                                     data-year="{{ $res->year }}"
                                     data-mime="{{ $res->mime }}"
                                     data-date="{{ optional($res->created_at)->format('M d, Y') }}"
                                     data-details-url="{{ route('resources-details', $res->id) }}"
                                     data-src="{{ $res->resourceUrl }}"
                                     data-ext="{{ $ext }}"
                                     data-is-image="{{ $isImage ? '1' : '0' }}"
                                     style="cursor:pointer!important;">

                                    {{-- BURDA ARTıq td_card YOXDUR, ÖZ KARTIMIZ VAR --}}
                                    <div class="res-side-card"
                                         style="
                                            border-radius:18px!important;
                                            background:#ffffff!important;
                                            border:1px solid rgba(226,232,240,0.9)!important;
                                            box-shadow:0 14px 34px rgba(15,23,42,0.12)!important;
                                            overflow:hidden!important;
                                            padding:11px 16px 12px 14px!important;
                                            display:flex!important;
                                            align-items:stretch!important;
                                            gap:14px!important;
                                         ">

                                        {{-- THUMBNAIL --}}
                                        <div
                                            style="
                                                flex:0 0 120px!important;
                                                height:92px!important;
                                                border-radius:14px!important;
                                                overflow:hidden!important;
                                                position:relative!important;
                                                background:#0f172a!important;
                                            ">
                                            @if ($isImage)
                                                <img src="{{ $res->resourceUrl }}"
                                                     alt=""
                                                     style="
                                                        width:100%!important;
                                                        height:100%!important;
                                                        object-fit:cover!important;
                                                     ">
                                            @elseif ($isPdf)
                                                <iframe src="{{ $res->resourceUrl }}#page=1&view=FitH"
                                                        style="
                                                            width:100%!important;
                                                            height:100%!important;
                                                            border:0!important;
                                                        ">
                                                </iframe>
                                            @else
                                                <div
                                                    style="
                                                        position:absolute!important;
                                                        inset:0!important;
                                                        display:flex!important;
                                                        align-items:center!important;
                                                        justify-content:center!important;
                                                        color:rgba(148,163,184,0.9)!important;
                                                        font-size:28px!important;
                                                    ">
                                                    <i class="fa-regular fa-file-lines"></i>
                                                </div>
                                            @endif

                                            <span
                                                style="
                                                    position:absolute!important;
                                                    left:8px!important;
                                                    bottom:7px!important;
                                                    background:rgba(15,23,42,0.92)!important;
                                                    color:#e5e7eb!important;
                                                    border-radius:999px!important;
                                                    padding:3px 8px!important;
                                                    font-size:10px!important;
                                                    font-weight:700!important;
                                                    letter-spacing:0.06em!important;
                                                    text-transform:uppercase!important;
                                                    border:1px solid rgba(148,163,184,0.7)!important;
                                                ">
                                                {{ $label }}
                                            </span>
                                        </div>

                                        {{-- TEXT + BUTTON --}}
                                        <div
                                            style="
                                                flex:1 1 auto!important;
                                                display:flex!important;
                                                flex-direction:column!important;
                                                min-width:0!important;
                                                padding-right:6px!important;
                                            ">
                                            <div
                                                style="
                                                    flex:1 1 auto!important;
                                                    display:flex!important;
                                                    flex-direction:column!important;
                                                ">
                                                <div
                                                    style="
                                                        display:inline-flex!important;
                                                        align-items:center!important;
                                                        gap:8px!important;
                                                        margin-bottom:4px!important;
                                                        font-size:11px!important;
                                                        font-weight:600!important;
                                                        color:#6b7280!important;
                                                        text-transform:uppercase!important;
                                                        letter-spacing:0.06em!important;
                                                    ">
                                                    <span>{{ $res->type?->name ?? 'Resource' }}</span>
                                                    @if ($res->year)
                                                        <span
                                                            style="width:3px!important;height:3px!important;border-radius:999px!important;background:#9ca3af!important;">
                                                        </span>
                                                        <span>{{ $res->year }}</span>
                                                    @endif
                                                </div>

                                                <h3
                                                    style="
                                                        margin:0 0 4px 0!important;
                                                        font-size:16px!important;
                                                        line-height:1.35!important;
                                                        color:#0f172a!important;
                                                        white-space:nowrap!important;
                                                        overflow:hidden!important;
                                                        text-overflow:ellipsis!important;
                                                    ">
                                                    {{ $res->name }}
                                                </h3>

                                                <p
                                                    style="
                                                        margin:0 0 6px 0!important;
                                                        font-size:12px!important;
                                                        color:#6b7280!important;
                                                    ">
                                                    {{ optional($res->created_at)->format('M d, Y') }}
                                                    @if ($res->mime)
                                                        • {{ $res->mime }}
                                                    @endif
                                                </p>
                                            </div>

                                            {{-- BUTTON: HƏR KARTDA AŞAĞI-SAĞDA SABİT --}}
                                            <div
                                                style="
                                                    margin-top:6px!important;
                                                    display:flex!important;
                                                    justify-content:flex-end!important;
                                                ">
                                                <a href="{{ route('resources-details', $res->id) }}"
                                                   class="td_btn td_style_1 td_radius_10 td_medium"
                                                   style="
                                                       font-size:12px!important;
                                                       padding:0!important;
                                                   ">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Details</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center text-muted">No resources yet.</div>
        @endif
    </div>
    <div class="td_height_120 td_height_lg_80"></div>
</section>

<style>
    @keyframes resListScroll {
        0%   { transform: translateY(0); }
        100% { transform: translateY(-50%); }
    }

    #home-resources .js-res-list:hover .js-res-list-track {
        animation-play-state: paused !important;
    }

    #home-resources .js-res-item:hover .res-side-card {
        transform: translateY(-3px) !important;
        box-shadow: 0 18px 46px rgba(15, 23, 42, 0.18) !important;
        border-color: rgba(209, 213, 219, 1) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateHeroFromItem(el) {
            var ds = el.dataset || {};

            var img   = document.getElementById('res-hero-img');
            var pdf   = document.getElementById('res-hero-pdf');
            var icon  = document.getElementById('res-hero-icon');
            var link  = document.getElementById('res-hero-link');
            var title = document.getElementById('res-hero-title');
            var type  = document.getElementById('res-hero-type');
            var date  = document.getElementById('res-hero-date');
            var mime  = document.getElementById('res-hero-mime');
            var meta  = document.getElementById('res-hero-meta');
            var extEl = document.getElementById('res-hero-ext');
            var cta   = document.getElementById('res-hero-cta');

            var isImage = ds.isImage === '1';
            var ext     = (ds.ext || '').toLowerCase();
            var isPdf   = !isImage && ext === 'pdf';

            if (img) img.style.display  = 'none';
            if (pdf) pdf.style.display  = 'none';
            if (icon) icon.style.display = 'none';

            if (isImage && ds.src && img) {
                img.src = ds.src;
                img.style.display = 'block';
            } else if (isPdf && ds.src && pdf) {
                pdf.src = ds.src + '#page=1&view=FitH';
                pdf.style.display = 'block';
            } else if (icon) {
                icon.style.display = 'flex';
            }

            if (title) title.textContent = ds.title || '';
            if (type)  type.textContent  = (ds.type || 'Resource') + (ds.year ? ' • ' + ds.year : '');
            if (date)  date.textContent  = ds.date || '';
            if (mime)  mime.textContent  = ds.mime || (ds.ext || 'file');

            var label = (ds.ext || ds.mime || 'file').toUpperCase();
            if (extEl) extEl.textContent = label;

            if (meta) {
                var parts = [];
                if (ds.type) parts.push(ds.type);
                if (ds.year) parts.push(ds.year);
                if (ds.mime) parts.push(ds.mime);
                meta.textContent = parts.join(' • ');
            }

            if (cta && ds.detailsUrl)  cta.href  = ds.detailsUrl;
            if (link && ds.detailsUrl) link.href = ds.detailsUrl;
        }

        document
            .querySelectorAll('#home-resources .js-res-item')
            .forEach(function (item) {
                item.addEventListener('mouseenter', function () {
                    updateHeroFromItem(item);
                });
            });
    });
</script>

    

    {{-- Scripts (pdf.js + thumb builder) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
        // pdf.js worker
        (function() {
            try {
                const pdfjs = window['pdfjs-dist/build/pdf'];
                if (pdfjs?.GlobalWorkerOptions) {
                    pdfjs.GlobalWorkerOptions.workerSrc =
                        "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
                }
            } catch (e) {
                /* ignore */
            }
        })();

        (function() {
            const OFFICE = ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'odt', 'odp', 'ods', 'rtf', 'txt'];
            const IMG = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
            const VID = ['mp4', 'mov', 'webm', 'mkv', 'avi'];
            const AUD = ['mp3', 'wav', 'ogg', 'm4a'];

            const isOffice = (e, m) => OFFICE.includes(e) || (m || '').includes('officedocument');
            const isImg = (e, m) => IMG.includes(e) || (m || '').startsWith('image/');
            const isPdf = (e, m) => e === 'pdf' || (m || '') === 'application/pdf';
            const isVid = (e, m) => VID.includes(e) || (m || '').startsWith('video/');
            const isAud = (e, m) => AUD.includes(e) || (m || '').startsWith('audio/');

            const svgPlay = 'data:image/svg+xml;utf8,' +
                encodeURIComponent(
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><polygon points="24,16 48,32 24,48" fill="#cbd5e1"/></svg>'
                );

            const svgFile = 'data:image/svg+xml;utf8,' +
                encodeURIComponent(
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><path d="M40 4H20a6 6 0 0 0-6 6v44l10-5 10 5 10-5 10 5V20z" fill="#cbd5e1"/></svg>'
                );

            function extFromUrl(u) {
                try {
                    const p = (new URL(u, window.location.origin)).pathname;
                    const e = p.split('.').pop()?.toLowerCase() || '';
                    return e.replace(/[^a-z0-9]/g, '');
                } catch (_) {
                    return '';
                }
            }

            async function buildThumb(link) {
                const urlRaw = link.getAttribute('data-src') || '';
                const url = urlRaw.replace(/&amp;/g, '&');
                const mime = (link.getAttribute('data-mime') || '').toLowerCase();
                const ext = extFromUrl(url) || (mime.split('/')[1] || '');
                const img = link.querySelector('.res-thumb-img');
                const cvs = link.querySelector('.res-thumb-canvas');
                const badge = link.querySelector('.res-ext');
                const icon = link.querySelector('.res-icon');

                if (badge) {
                    badge.textContent = ext || (mime || 'file');
                }

                // IMAGE
                if (isImg(ext, mime)) {
                    img.src = url;
                    img.style.display = 'block';
                    cvs.style.display = 'none';
                    icon.style.display = 'none';
                    return;
                }

                // VIDEO
                if (isVid(ext, mime)) {
                    img.src = svgPlay;
                    img.style.display = 'block';
                    cvs.style.display = 'none';
                    icon.style.display = 'none';
                    return;
                }

                // AUDIO
                if (isAud(ext, mime)) {
                    img.src = svgFile;
                    img.style.display = 'block';
                    cvs.style.display = 'none';
                    icon.style.display = 'none';
                    return;
                }

                // OFFICE
                if (isOffice(ext, mime)) {
                    img.src = svgFile;
                    img.style.display = 'block';
                    cvs.style.display = 'none';
                    icon.style.display = 'none';
                    return;
                }

                // PDF → pdf.js ilə 1-ci səhifə
                if (isPdf(ext, mime)) {
                    try {
                        const pdfjs = window['pdfjs-dist/build/pdf'];
                        if (!pdfjs) throw new Error('no pdfjs');
                        const pdf = await pdfjs.getDocument({
                            url,
                            withCredentials: false
                        }).promise;
                        const page = await pdf.getPage(1);
                        const viewport = page.getViewport({
                            scale: 0.35
                        });
                        cvs.width = viewport.width;
                        cvs.height = viewport.height;
                        await page.render({
                            canvasContext: cvs.getContext('2d', {
                                willReadFrequently: true
                            }),
                            viewport
                        }).promise;
                        img.style.display = 'none';
                        cvs.style.display = 'block';
                        icon.style.display = 'none';
                        return;
                    } catch (e) {
                        // Fallback: ikon
                        img.src = svgFile;
                        img.style.display = 'block';
                        cvs.style.display = 'none';
                        icon.style.display = 'none';
                        return;
                    }
                }

                // Digər — ikon
                img.src = svgFile;
                img.style.display = 'block';
                cvs.style.display = 'none';
                icon.style.display = 'none';
            }

            // Lazy init (viewporta gələndə)
            const nodes = document.querySelectorAll('.res-thumb');
            if ('IntersectionObserver' in window) {
                const io = new IntersectionObserver(entries => {
                    entries.forEach(ent => {
                        if (ent.isIntersecting) {
                            buildThumb(ent.target);
                            io.unobserve(ent.target);
                        }
                    });
                }, {
                    rootMargin: '120px 0px'
                });
                nodes.forEach(n => io.observe(n));
            } else {
                nodes.forEach(n => buildThumb(n));
            }
        })();
    </script>



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

    <section id="home-video-contact">
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
                        {{ __('Take a Video Tour to Learn Intro of Campus') }}
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
                    {{ __('or') }}
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
    <section id="home-accreditations">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">

            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    {{ __('Accreditations') }}
                </p>
                <h2 class="td_section_title td_fs_48 mb-0"> {{ __('Recognitions & Partnerships') }}</h2>
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

    <!-- Start Team Highlight (carousel) -->
    <section id="home-team" class="td_heading_bg td_hobble">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <h2 class="td_section_title td_fs_48 mb-0 td_white_color">{{ __('Learn and grow with our team') }}
                </h2>
                <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
                    {{ __('Meet our experts from HSE.AZ') }}
                </p>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>

            @if ($teamMembers->count())
                @php
                    $maleDefault =
                        'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
                    $femaleDefault =
                        'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';
                @endphp

                <div class="js-home-team-slider">
                    @foreach ($teamMembers as $member)
                        @php
                            $thumb =
                                $member->imageUrl ?: ($member->gender === 'female' ? $femaleDefault : $maleDefault);

                            $skills = (array) ($member->skills ?? []);
                            $skills = array_values(array_filter($skills, fn($s) => !empty($s['name'])));
                        @endphp

                        <div class="js-home-team-slide">
                            <div class="row align-items-center td_gap_y_40">
                                <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                                    <div class="td_testimonial_img_wrap">
                                        <img src="{{ $thumb }}" alt="{{ $member->full_name }}"
                                            class="td_testimonial_img"
                                            style="object-fit:cover;border-radius:18px;aspect-ratio:4/3;width:100%;height:auto;">
                                        <span class="td_testimonial_img_shape_1"><span></span></span>
                                        <span class="td_testimonial_img_shape_2 td_accent_color td_hover_layer_3">
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
                                                <img src="{{ $thumb }}" alt="{{ $member->full_name }}"
                                                    style="width:100%;height:100%;object-fit:cover;">
                                            </div>
                                            <div>
                                                <h3 class="td_fs_24 td_semibold td_mb_2">{{ $member->full_name }}
                                                </h3>
                                                <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">
                                                    {{ $member->position ?: 'Team Member' }}</p>
                                            </div>
                                        </div>

                                        <blockquote class="td_fs_18 td_heading_color td_opacity_9"
                                            style="line-height:1.7;">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($member->description ?? ''), 320) ?: '—' !!}
                                        </blockquote>

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
                                            <a href="{{ route('team-details', $member) }}"
                                                class="td_btn td_style_1 td_radius_10 td_medium">
                                                <span class="td_btn_in td_white_color td_accent_bg"><span>View
                                                        Profile</span></span>
                                            </a>
                                            @if ($member->email)
                                                <a href="mailto:{{ $member->email }}"
                                                    class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span
                                                        class="td_btn_in td_accent_color td_white_bg"><span>Email</span></span>
                                                </a>
                                            @endif
                                            @if ($member->phone)
                                                <a href="tel:{{ preg_replace('/\s+/', '', $member->phone) }}"
                                                    class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span
                                                        class="td_btn_in td_accent_color td_white_bg"><span>Call</span></span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Team Highlight -->

    <style>
        /* Slick dots custom style for team slider */
        #home-team .slick-dots {
            position: static;
            margin-top: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        #home-team .slick-dots li {
            margin: 0;
            padding: 0;
        }

        #home-team .slick-dots li button {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            border: none;
            padding: 0;
            background: rgba(255, 255, 255, 0.35);
            cursor: pointer;
            font-size: 0;
            /* rəqəmi gizlət */
            line-height: 0;
            outline: none;
            transition: all 0.25s ease;
        }

        #home-team .slick-dots li.slick-active button {
            width: 22px;
            height: 9px;
            background: #ff7a3c;
            box-shadow: 0 0 0 2px rgba(255, 122, 60, 0.35);
        }

        #home-team .slick-dots li button::before {
            display: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery !== 'undefined' && typeof jQuery.fn.slick === 'function') {
                jQuery('.js-home-team-slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000, // 3 saniyə
                    adaptiveHeight: true,
                    pauseOnHover: true,
                });
            }
        });
    </script>




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

        // Əsas list – az department olanda doldururuq ki, sıra uzun olsun
        $baseList = $list;

        if (count($baseList) && count($baseList) < 6) {
            while (count($baseList) < 6) {
                $baseList = array_merge($baseList, $list);
            }
        }

        // Sonsuz loop üçün baseList-i 2 dəfə təkrarlayırıq
        $loopList = array_merge($baseList, $baseList);
    @endphp

    <section id="home-departments" style="background:transparent!important;">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                @if ($kicker)
                    <p
                        class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                        {{ __('Departments') }}
                    </p>
                @endif

                <h2 class="td_section_title td_fs_48 mb-0">
                    {{ __('Popular Departments') }}
                </h2>

                @if ($subtitle)
                    <p class="td_section_subtitle td_fs_18 mb-0">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>

            <div class="td_height_50 td_height_lg_50"></div>

            {{-- Sonsuz, yavaş, sağdan-sola axan slider (glassmorphism kartlar) --}}
            <div class="td_departments_scroller"
                style="
                position:relative!important;
                overflow:hidden!important;
                width:100%!important;
                padding:8px 0 8px 0!important;
                background:transparent!important;
             ">
                <div class="td_departments_track"
                    style="
                    display:flex!important;
                    flex-wrap:nowrap!important;
                    align-items:stretch!important;
                    gap:36px!important;
                    width:max-content!important;
                    will-change:transform!important;
                    animation:departmentsScroll 40s linear infinite!important;
                 ">
                    @foreach ($loopList as $i => $it)
                        @php
                            $itTitle = data_get($it, 'title', '');
                            $icon = $toUrl(data_get($it, 'icon'));
                        @endphp

                        <div class="td_iconbox td_style_1 text-center"
                            style="
                            flex:0 0 auto!important;
                            padding:4px!important;
                            box-sizing:border-box!important;
                         ">
                            <div
                                style="
                                min-width:300px!important;
                                max-width:380px!important;
                                width:340px!important;

                                /* glassmorphism */
                                background:rgba(255,255,255,0.06)!important;
                                backdrop-filter:blur(18px)!important;
                                -webkit-backdrop-filter:blur(18px)!important;
                                border-radius:26px!important;
                                border:1px solid rgba(255,255,255,0.14)!important;

                                padding:26px 24px 22px 24px!important;
                                box-shadow:0 28px 70px rgba(0,0,0,0.65)!important;
                                color:#ffffff!important;
                                box-sizing:border-box!important;
                                position:relative!important;
                                overflow:hidden!important;
                                height:100%!important;
                                display:flex!important;
                                flex-direction:column!important;
                                align-items:center!important;
                                justify-content:flex-start!important;
                            ">

                                {{-- Böyük image, mərkəzdə --}}
                                <div class="td_iconbox_icon td_accent_color td_mb_10"
                                    style="
                                    margin-bottom:20px!important;
                                    display:flex!important;
                                    align-items:center!important;
                                    justify-content:center!important;
                                 ">
                                    <div
                                        style="
                                    width:140px!important;
                                    height:140px!important;
                                    border-radius:32px!important;
                                    background:radial-gradient(circle at 20% 15%,rgba(255,255,255,0.9) 0,rgba(255,255,255,0) 45%)!important;
                                    border:1px solid rgba(255,255,255,0.18)!important;
                                    display:flex!important;
                                    align-items:center!important;
                                    justify-content:center!important;
                                    overflow:hidden!important;
                                    box-shadow:0 20px 50px rgba(0,0,0,0.75)!important;
                                ">
                                        @if ($icon)
                                            <img src="{{ $icon }}" alt="{{ $itTitle }}"
                                                width="140" height="140"
                                                style="
                                                display:block!important;
                                                width:120px!important;
                                                height:120px!important;
                                                object-fit:cover!important;
                                                border-radius:24px!important;
                                             ">
                                        @endif
                                    </div>
                                </div>

                                {{-- Yalnız title --}}
                                <p class="td_iconbox_title mb-0 td_medium td_fs_36"
                                    style="
                                  font-size:22px!important;
                                  line-height:1.25!important;
                                  margin:0!important;
                                  font-weight:600!important;
                                  text-align:center!important;
                                  letter-spacing:0.01em!important;
                               ">
                                    {{ $itTitle }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    {{-- End Departments Section --}}

    <style>
        @keyframes departmentsScroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @media (max-width: 992px) {
            #home-departments .td_departments_track {
                animation-duration: 35s !important;
                gap: 28px !important;
            }

            #home-departments .td_departments_track .td_iconbox>div {
                min-width: 270px !important;
                max-width: 330px !important;
                width: 300px !important;
            }
        }

        @media (max-width: 576px) {
            #home-departments .td_departments_track {
                animation-duration: 30s !important;
                gap: 20px !important;
            }

            #home-departments .td_departments_track .td_iconbox>div {
                min-width: 84% !important;
                max-width: 94% !important;
                width: 90% !important;
            }
        }
    </style>




    @php
        // Sosial şəbəkələr
        $fb = setting('social.facebook');
        $tw = setting('social.twitter');
        $ig = setting('social.instagram');
        $pin = setting('social.pinterest'); // fallback üçün saxlayırıq
        $wa = setting('social.whatsapp'); // tercihen wa.me/…

        // LinkedIn: varsa onu götür, yoxdursa Pinterest URL-ni istifadə et
        $li = setting('social.linkedin', $pin);

        // Linkləri təhlükəsiz açmaq üçün atributlar
        $attrs = 'target="_blank" rel="noopener noreferrer"';

        // Sayt məlumatları
        $siteName = setting('site.name', 'Educve');
        $phone = setting('site.phone');
        $email = setting('site.email');
        $address = setting('site.address');
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

        // Footer qalereyası üçün son şəkillər (gallery_images cədvəlindən)
        $footerGallery = \App\Models\GalleryImage::query()->latest()->take(6)->get();
    @endphp


    <x-chat-widget label="Mesaj göndərin" title="Bizə yazın" />
    <footer class="td_footer td_style_1">
        <div class="container">
            <div class="td_footer_row">
                {{-- 1. Sütun: Logo, mətn, kontakt, sosial ikonlar --}}
                <div class="td_footer_col">
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

                            {{-- Tagline settings-dən (site.tagline) gəlir --}}
                            <p>{{ $tagline }}</p>
                        </div>

                        <ul class="td_footer_address_widget td_medium td_mp_0">
                            @if ($phone && $telHref)
                                <li>
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <a href="{{ $telHref }}">{{ $phone }}</a>
                                </li>
                                <li>
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <a href="{{ $telHref }}">(+994) 10 253 23 88</a>
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

                        {{-- Sosial ikonlar --}}
                        @if ($fb || $tw || $ig || $li || $wa)
                            <div class="td_footer_social_btns td_fs_20 mt-3">
                                @if ($fb)
                                    <a href="{{ $fb }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                @endif

                                @if ($tw)
                                    <a href="{{ $tw }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                @endif

                                @if ($ig)
                                    <a href="{{ $ig }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                @endif

                                {{-- Pinterest göstərilmir, onun yerinə LinkedIn (Pinterest URL fallback kimi) --}}
                                @if ($li)
                                    <a href="{{ $li }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                @endif

                                @if ($wa)
                                    <a href="{{ $wa }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 2. Sütun: Naviqasiya --}}
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                            {{ __('Navigateion') }}
                        </h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('faqss') }}">{{ __('Faqs') }}</a></li>
                            <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                            <li><a href="{{ route('resources') }}">{{ __('Resources') }}</a></li>
                            <li><a href="{{ route('team') }}">{{ __('Team') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                        </ul>
                    </div>
                </div>

                {{-- 3. Sütun: Courses / Services / Topics / Vacancies --}}
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                            {{ __('Courses') }}
                        </h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="{{ route('courses-grid-view') }}">{{ __('Courses') }}</a></li>
                            <li><a href="{{ route('services') }}">{{ __('Services') }}</a></li>
                            <li><a href="{{ route('topices') }}">{{ __('Topics') }}</a></li>
                            <li><a href="{{ route('vacancies') }}">{{ __('Vacancies') }}</a></li>
                        </ul>
                    </div>
                </div>

                {{-- 4. Sütun: Subscribe + Gallery images --}}
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                            {{ __('Subscribe now') }}
                        </h2>
                        <div class="td_newsletter td_style_1">
                            <p class="td_mb_20 td_opacity_7">
                                {{ __('Far far away, behind the word mountains, far from the Consonantia, there live the blind texts.') }}
                            </p>
                            <form class="td_newsletter_form" action="{{ route('subscribe') }}" method="POST"
                                id="newsletterForm">
                                @csrf
                                <input type="email" name="email" class="td_newsletter_input"
                                    placeholder="Email address" required>
                                <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg">
                                        <span>{{ __('Subscribe now') }}</span>
                                    </span>
                                </button>
                            </form>

                            @if (session('sub_ok'))
                                <div class="alert alert-success mt-2">{{ session('sub_ok') }}</div>
                            @endif

                            <script>
                                // İstəsən AJAX
                                document.getElementById('newsletterForm')?.addEventListener('submit', async function(e) {
                                    if (!this.hasAttribute('data-ajax')) return;
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

                        {{-- GalleryImages qalereyası: bütün şəkillər eyni blok ölçüsündə, kəsilmədən görünür --}}
                        @if ($footerGallery->count())
                            <div class="td_footer_gallery mt-4">
                                <h3 class="td_fs_20 td_white_color td_medium mb-3">
                                </h3>
                                <div class="row g-2">
                                    @foreach ($footerGallery as $g)
                                        <div class="col-4">
                                            <a href="{{ $g->image }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <img src="{{ $g->image }}"
                                                    alt="Gallery image {{ $loop->iteration }}" class="img-fluid"
                                                    style="
                                                    width: 100%;
                                                    height: 90px;
                                                    object-fit: contain;
                                                    background: #111;
                                                    padding: 4px;
                                                    border-radius: 10px;
                                                 ">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="td_footer_bottom td_fs_18">
            <div class="container">
                <div class="td_footer_bottom_in">
                    <p class="td_copyright mb-0">{{ __('Copyright') }}</p>
                    <ul class="td_footer_widget_menu">
                        <li><a href="#">{{ __('Terms & Conditions') }}</a></li>
                        <li><a href="#">{{ __('Privacy & Policy') }}</a></li>
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


    <script>
        (function() {
            function switchLocale(targetLocale) {
                var locales = ['az', 'en', 'ru'];
                var path = window.location.pathname;
                var parts = path.replace(/^\/+/, '').split('/'); // remove leading slash then split
                if (parts.length && locales.indexOf(parts[0]) !== -1) {
                    parts[0] = targetLocale; // replace existing locale
                } else {
                    parts.unshift(targetLocale); // prepend locale
                }
                var newPath = '/' + parts.join('/');
                var qs = window.location.search || '';
                var hash = window.location.hash || '';
                window.location.href = newPath + qs + hash;
            }
            document.addEventListener('click', function(e) {
                var a = e.target.closest('a.js-lang');
                if (a) {
                    e.preventDefault();
                    var loc = a.getAttribute('data-locale');
                    if (loc) {
                        switchLocale(loc);
                    }
                }
            }, {
                passive: false
            });
        })();
    </script>

    {{-- ===== Scroll-driven GUIDE (Settings-based) ===== --}}
    @php
        // Settings-dən gələn addımlar
        $guideSections = collect(setting('ui.guides.index.sections', []))
            ->map(function ($s) {
                return [
                    'sel' => trim((string) ($s['selector'] ?? '')),
                    'title' => trim((string) ($s['title'] ?? '')),
                    'text' => trim((string) ($s['text'] ?? '')),
                ];
            })
            ->filter(fn($s) => $s['sel'] && $s['title'] && $s['text'])
            ->values()
            ->all();

        // Fallback (əgər settings boşdursa) — 10-luq default
        $fallbackSteps = [
            [
                'sel' => '#home-hero',
                'title' => 'Başlanğıc paneli',
                'text' =>
                    'Ana vitrin: əsas dəyər təklifi, qısa izah və hərəkətə çağırışlar (CTA). Buradan istifadəçi ən qısa marşrutla kurslara və ya müraciətə yönlənir.',
            ],
            [
                'sel' => '#home-about',
                'title' => 'Haqqımızda (qısa icmal)',
                'text' =>
                    'Missiya, yanaşma və əsas üstünlüklər. İki şəkilli kompozisiya və dairəvi video düyməsi vizual etibarı yüksəldir; CTA isə uzun “About” səhifəsinə aparır.',
            ],
            [
                'sel' => '#home-courses',
                'title' => 'Populyar kurslar',
                'text' =>
                    'Tablarla “Courses/Services/Topics/Vacancies” bölmələrinə keçid. Kartlar vahid hündürlükdədir, başlıq və təsvir clamp olunub; “View Details” konversiyanı sadələşdirir.',
            ],
            [
                'sel' => '#home-features',
                'title' => 'Üstünlüklər (Campus)',
                'text' =>
                    'Şəkil + mətn kombinasiyası ilə dəyər təklifi: infrastruktur, mentor dəstəyi, praktik layihələr və ölçülə bilən nəticələr. 4 maddəlik siyahı fokus yaradır.',
            ],
            [
                'sel' => '#home-campus',
                'title' => 'Naviqasiya kartları',
                'text' =>
                    'Dörd istiqamətə sürətli keçid üçün mozaika kartlar. Hər kartda vizual vurğu, başlıq və kliklə dərhal yönləndirmə — “keçid sürəti” əsas prioritetdir.',
            ],
            [
                'sel' => '#home-resources',
                'title' => 'Resurslar & Yükləmələr',
                'text' =>
                    'Materiallar PDF/image/video kimi avtomatik önbaxışla göstərilir (pdf.js dəstəyi). “Featured” resurs solda, sağda isə üç kompakt kart — sürətli seçim üçün.',
            ],
            [
                'sel' => '#home-video-contact',
                'title' => 'Video təqdimat + əlaqə',
                'text' =>
                    'Qısa tanıtım videosu brend tonunu çatdırır; alt hissədə e-poçt və telefon üçün iri CTA qutuları var. Hədəf: sual yaranan kimi minimal sürtünmə ilə əlaqə.',
            ],
            [
                'sel' => '#home-accreditations',
                'title' => 'Akkreditasiyalar',
                'text' =>
                    'Tərəfdaşlıq və tanınmalar: solda “featured” loqo + tarix, sağda kompakt kartlar. Sosial sübut rolunu oynayır və şübhəni azaldır.',
            ],
            [
                'sel' => '#home-team',
                'title' => 'Komanda hekayəsi',
                'text' =>
                    'Ön plana çıxarılan ekspertin foto, qısa bio və bacarıq səviyyələri (progress bar). Yanındakı sürətli əməl düymələri “View Profile / Email / Call” verir.',
            ],
            [
                'sel' => '#home-departments',
                'title' => 'Fakültələr',
                'text' =>
                    '8-lik grid: hər bölmə üçün ikon + başlıq. “Birdən çox maraq nöqtəsi” ssenarisində istifadəçiyə geniş baxış imkanı yaradır.',
            ],
        ];
    @endphp

    <style>
        .guide-bubble {
            position: fixed;
            right: 18px;
            bottom: 78px;
            z-index: 9999;
            max-width: 360px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 16px 40px rgba(2, 6, 23, .14);
            padding: 14px 14px 14px 16px;
        }

        .guide-bubble h4 {
            margin: 0 0 4px;
            font-size: 16px;
            font-weight: 800;
            color: #111827
        }

        .guide-bubble p {
            margin: 0;
            font-size: 14px;
            color: #334155;
            line-height: 1.45
        }

        .guide-count {
            font-size: 12px;
            color: #64748b;
            margin-left: auto
        }

        .guide-current {
            outline: 2px dashed #e31b23;
            outline-offset: 8px;
            border-radius: 10px;
            transition: outline-color .2s ease, outline-offset .2s ease;
        }

        @media (max-width: 575.98px) {
            .guide-bubble {
                left: 12px;
                right: 12px;
                bottom: 12px;
            }
        }
    </style>

    <script>
        (function() {
            // Settings-dən gələn addımlar (əgər boşdursa fallback istifadə olunur)
            const STEPS = @json($guideSections ?: $fallbackSteps, JSON_UNESCAPED_UNICODE);

            // DOM-nu yüklə
            const els = STEPS.map(s => document.querySelector(s.sel));

            // Bubble UI
            const bubble = document.createElement('div');
            bubble.className = 'guide-bubble';
            bubble.innerHTML = `
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <path d="M21 11.5a8.5 8.5 0 1 1-3.2-6.6L22 4l-1.8 3.7A8.46 8.46 0 0 1 21 11.5Z" stroke="#e31b23" stroke-width="2"/>
    </svg>
    <h4 id="g-title" style="margin-right:auto">Guide</h4>
    <span class="guide-count" id="g-count"></span>
    <button id="g-close" type="button" aria-label="Close guide"
      style="margin-left:8px;display:inline-grid;place-items:center;width:28px;height:28px;
             border:1px solid #e5e7eb;border-radius:8px;background:#fff;cursor:pointer;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M6 6l12 12M18 6L6 18" stroke="#111827" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>
  </div>
  <p id="g-text"></p>
`;

            // Əvvəlcədən bağlanıbsa, heç nə göstərməyək
            if (localStorage.getItem('guide:about:closed') === '1') {
                bubble.remove();
                return;
            }

            // X düyməsi: bubble-i bağla və resursları təmizlə
            const closeBtn = bubble.querySelector('#g-close');
            closeBtn?.addEventListener('click', () => {
                try {
                    io?.disconnect?.();
                } catch (_) {}
                window.removeEventListener('scroll', chooseMostVisible, {
                    passive: true
                });
                window.removeEventListener('resize', chooseMostVisible, {
                    passive: true
                });
                window.removeEventListener('load', chooseMostVisible);
                // yadda saxla (istəməsən bu sətri sil)
                localStorage.setItem('guide:about:closed', '1');
                bubble.remove();
            });

            document.body.appendChild(bubble);

            let current = -1;

            function setActive(idx) {
                if (idx === current) return;
                if (els[current]) els[current].classList.remove('guide-current');
                current = idx;
                const step = STEPS[current],
                    node = els[current];
                if (!step || !node) return;
                node.classList.add('guide-current');
                document.getElementById('g-title').textContent = step.title;
                document.getElementById('g-text').textContent = step.text;
                document.getElementById('g-count').textContent = (current + 1) + ' / ' + STEPS.length;
            }

            // Ekranda ən çox görünən section-u seç
            function chooseMostVisible() {
                const vh = innerHeight || document.documentElement.clientHeight;
                let bestIdx = 0,
                    bestScore = -1;
                els.forEach((el, idx) => {
                    if (!el) return;
                    const r = el.getBoundingClientRect();
                    const vis = Math.max(0, Math.min(vh, r.bottom) - Math.max(0, r.top)); // görünən hündürlük
                    const score = vis * (r.width || 1);
                    if (score > bestScore) {
                        bestScore = score;
                        bestIdx = idx;
                    }
                });
                setActive(bestIdx);
            }

            // Observer + scroll
            if ('IntersectionObserver' in window) {
                const io = new IntersectionObserver(() => chooseMostVisible(), {
                    root: null,
                    rootMargin: '-10% 0px -10% 0px',
                    threshold: [0, .1, .25, .5, .75, 1]
                });
                els.forEach(el => el && io.observe(el));
            }
            addEventListener('scroll', chooseMostVisible, {
                passive: true
            });
            addEventListener('resize', chooseMostVisible, {
                passive: true
            });
            addEventListener('load', chooseMostVisible);

            // İlk aktivləşdirmə
            chooseMostVisible();
        })();
    </script>


</body>

</html>
