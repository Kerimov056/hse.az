<!DOCTYPE html>
<html class="no-js" lang="en">
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
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        referrerpolicy="no-referrer" />
</head>

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


<body>
    <!-- Start Preloader -->
    <div class="td_preloader">
        <div class="td_preloader_in">
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- End Preloader -->

    <style>
        /* TOP BAR layout: sol daha geniş, sağ kompakt */
        .td_top_header_in {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .td_top_header_left {
            flex: 1 1 auto;
            /* SOL: genişlənsin */
            overflow: hidden;
        }

        .td_top_header_right {
            flex: 0 0 auto;
            /* SAĞ: məzmun qədər */
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
        }

        /* Marquee (soldan sağa, dərhal başlasın) */
        .ticker {
            position: relative;
            overflow: hidden;
            height: 28px;
            display: flex;
            align-items: center;
        }

        .ticker__inner {
            --speed: 18s;
            /* sürət (istəyə görə dəyiş) */
            display: inline-block;
            white-space: nowrap;
            padding-inline-end: 60%;
            /* döngüdə soldan təmiz başlasın */
            animation: ticker-ltr var(--speed) linear infinite;
            will-change: transform;
            animation-delay: 0s;
            color: #fff;
            font-weight: 600;
        }

        /* Hover-da pauza (istəməsən sil) */
        .ticker:hover .ticker__inner {
            animation-play-state: paused;
        }

        /* 0%-dan sol kənardan başlasın, sağa getsin; bitəndə yenə sola sıçrayır */
        @keyframes ticker-ltr {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>


    {{-- resources/views/partials/header.blade.php --}}
    <header class="td_site_header td_style_1 td_type_2 td_sticky_header td_medium td_heading_color">
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
                    "";
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

        <div class="td_main_header">
            <div class="container">
                <div class="td_main_header_in">
                    <div class="td_main_header_left">
                        <a class="td_site_branding td_accent_color" href="{{ route('home') }}">
                            {{-- LOGO --}}
                            <a class="td_site_branding" href="{{ route('home') }}">
                                <img src="{{ asset('assets/logoeng.png') }}" alt="Logo">
                            </a>
                        </a>


                    </div>

                    <div class="td_main_header_right">
                        <nav class="td_nav">
                            <div class="td_nav_list_wrap">
                                <div class="td_nav_list_wrap_in">
                                    <ul class="td_nav_list">
                                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                        <li><a href="{{ route('faqss') }}">{{ __('Faqs') }}</a></li>
                                        <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                                        <li><a href="{{ route('resources') }}">{{ __('Resources') }}</a></li>
                                        <li class="menu-item-has-children">
                                            <a href="{{ route('courses-grid-view') }}">{{ __('Courses') }}</a>
                                            <ul>
                                                <a href="{{ route('courses-grid-view') }}">{{ __('Courses') }}</a>
                                                <li><a href="{{ route('services') }}">{{ __('Services') }}</a></li>
                                                <li><a href="{{ route('topices') }}">{{ __('Topics') }}</a></li>
                                                <li><a href="{{ route('vacancies') }}">{{ __('Vacancies') }}</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('team') }}">{{ __('Team') }}</a></li>
                                        <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <div class="td_hero_icon_btns position-relative">
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

                            {{-- İstəsən profil menyusu (auth üçün) --}}
                            @auth
                                <div class="position-relative ms-2">
                                    <button class="td_circle_btn td_center" type="button" aria-label="Profile">
                                        <img src="{{ asset('assets/img/icons/user.svg') }}" alt="User">
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </header>


    
