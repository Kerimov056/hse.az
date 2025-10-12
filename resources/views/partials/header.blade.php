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
        <div class="td_top_header td_heading_bg td_white_color">
            <div class="container">
                <div class="td_top_header_in">
                    <div class="td_top_header_left">
                        <div class="ticker" role="marquee" aria-label="Site notice">
                            <div class="ticker__inner">
                                Welcome to the first occupational health, safety, environmental web portal!
                            </div>
                        </div>
                    </div>


                    <div class="td_top_header_right">
                        @guest
                            <span>
                                <a href="{{ route('auth.show', 'login') }}" class="">Login</a> /
                                <a href="{{ route('auth.show', 'register') }}" class="">Register</a>
                            </span>
                        @endguest

                        @auth
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="td_btn td_style_1 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg"><span>Admin</span></span>
                                </a>
                            @endif
                        @endauth

                        @auth
                            <div class="d-inline-flex align-items-center gap-3">
                                <span class="td_medium">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="td_btn td_style_1 td_medium">
                                        <span class="td_btn_in td_white_color td_accent_bg">
                                            <span>Logout</span>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="td_main_header">
            <div class="container">
                <div class="td_main_header_in">
                    <div class="td_main_header_left">
                        <a class="td_site_branding td_accent_color" href="{{ route('home') }}">
                            {{-- LOGO --}}
                            <a class="td_site_branding" href="{{ route('home') }}">
                                <img src="{{ $logoUrl }}" alt="Logo">
                            </a>
                        </a>


                    </div>

                    <div class="td_main_header_right">
                        <nav class="td_nav">
                            <div class="td_nav_list_wrap">
                                <div class="td_nav_list_wrap_in">
                                    <ul class="td_nav_list">
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        <li><a href="{{ route('faqss') }}">Faqs</a></li>
                                        <li><a href="{{ route('about') }}">About Us</a></li>
                                        <li><a href="{{ route('resources') }}">Resources</a></li>
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
