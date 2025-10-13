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
                                    <span class="td_btn_in td_white_color td_accent_bg"><span>Admin Panel</span></span>
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
            @php $buttons = setting('home.hero.buttons', []); @endphp
            @foreach ($buttons as $i => $btn)
                @php
                    $text = data_get($btn, 'text');
                    $url = data_get($btn, 'url', '#');
                @endphp
                @if ($text && $url)
                    <a href="{{ $url }}"
                        class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                        data-wow-duration="0.9s" data-wow-delay="0.35s">
                        <span class="td_btn_in td_white_color td_accent_bg">
                            <span>{{ $text }}</span>
                            {{-- SVG: index-ə görə fərqli ikonlar (0,1,2) --}}
                            @if ($i === 0)
                                {{-- Apply Now icon --}}
                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            @elseif($i === 1)
                                {{-- Request Info icon --}}
                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    {{-- ... sənin verdiyin ikinci SVG ... --}}
                                </svg>
                            @else
                                {{-- Chat With Us icon --}}
                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    {{-- ... sənin verdiyin üçüncü SVG ... --}}
                                </svg>
                            @endif
                        </span>
                    </a>
                @endif
            @endforeach
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

                <style>
                    .res-thumb {
                        position: relative
                    }

                    .res-thumb::before {
                        content: "";
                        display: block;
                        aspect-ratio: 16/9
                    }

                    .res-thumb>* {
                        position: absolute;
                        inset: 0
                    }

                    .res-thumb-img {
                        width: 100%;
                        height: 100%;
                        object-fit: contain;
                        background: #0b1324
                    }

                    .res-thumb-canvas {
                        width: 100%;
                        height: 100%
                    }

                    .res-ext {
                        position: absolute;
                        right: 10px;
                        bottom: 10px;
                        background: rgba(0, 0, 0, .7);
                        color: #fff;
                        border-radius: 10px;
                        padding: 4px 8px;
                        font-size: 12px;
                        font-weight: 700
                    }

                    .res-icon {
                        position: absolute;
                        inset: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: #cbd5e1
                    }
                </style>

                <div class="row td_gap_y_30">
                    <!-- FEATURED -->
                    <div class="col-lg-6">
                        <div class="td_card td_style_1 td_radius_5">
                            <a href="{{ route('resources-details', $hero->id) }}"
                                class="td_card_thumb td_mb_30 d-block res-thumb" data-src="{{ $hero->resourceUrl }}"
                                data-mime="{{ strtolower($hero->mime ?? '') }}">
                                <img class="res-thumb-img" alt="Resource"
                                    src="data:image/gif;base64,R0lGODlhAQABAAAAACw=">
                                <canvas class="res-thumb-canvas" style="display:none;"></canvas>
                                <span class="res-ext"></span>
                                <div class="res-icon" aria-hidden="true" style="display:none"></div>
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
                                    class="td_card_thumb d-block res-thumb" data-src="{{ $res->resourceUrl }}"
                                    data-mime="{{ strtolower($res->mime ?? '') }}">
                                    <img class="res-thumb-img" alt="Resource"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=">
                                    <canvas class="res-thumb-canvas" style="display:none;"></canvas>
                                    <span class="res-ext"></span>
                                    <div class="res-icon" aria-hidden="true" style="display:none"></div>
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
