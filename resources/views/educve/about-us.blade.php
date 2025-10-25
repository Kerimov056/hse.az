@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    {{-- Page heading (About) with settings-driven slider --}}
    <section id="about-hero" class="td_page_heading td_center td_heading_bg text-center">
        @php
            // About hero slider şəkilləri (settings → pages.heroes.about.images)
            $aboutSlides = (array) setting('pages.heroes.about.images', []);
            $aboutSlides = array_values(array_filter($aboutSlides, fn($v) => is_string($v) && trim($v) !== ''));
            if (count($aboutSlides) === 0) {
                $aboutSlides = [asset('assets/img/others/page_heading_bg.jpg')];
            }
        @endphp

        <style>
            /* ===== HERO SLIDER (about) ===== */
            #about-hero {
                position: relative;
                overflow: hidden;
            }

            #about-hero .hero-slider {
                position: absolute;
                inset: 0;
                z-index: 0;
            }

            #about-hero .hero-slide {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                opacity: 0;
                transition: opacity .8s ease-in-out;
                will-change: opacity;
            }

            #about-hero .hero-slide.is-active {
                opacity: 1;
            }

            #about-hero .hero-overlay {
                position: absolute;
                inset: 0;
                z-index: 1;
                background: linear-gradient(180deg, rgba(15, 23, 42, .25) 0%, rgba(15, 23, 42, .5) 100%);
            }

            #about-hero .td_page_heading_in {
                position: relative;
                z-index: 2;
            }
        </style>

        {{-- Background slides --}}
        <div class="hero-slider" aria-hidden="true">
            @foreach ($aboutSlides as $i => $src)
                <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}" style="background-image:url('{{ $src }}')">
                </div>
            @endforeach
            <div class="hero-overlay"></div>
        </div>

        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">{{ __("About Us") }}</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __("Home") }}</a></li>
                    <li class="breadcrumb-item active">{{ __("About Us") }}</li>
                </ol>
            </div>
        </div>
    </section>

    {{-- Slider JS (2s interval; hover-da pauza; tab gizlənəndə pauza) --}}
    <script>
        (function() {
            const root = document.querySelector('#about-hero .hero-slider');
            if (!root) return;

            const slides = Array.from(root.querySelectorAll('.hero-slide'));
            if (slides.length <= 1) return;

            let idx = 0,
                timer = null;
            const INTERVAL = 1900;

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

            const sec = document.getElementById('about-hero');
            sec.addEventListener('mouseenter', stop);
            sec.addEventListener('mouseleave', start);

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) stop();
                else start();
            });
        })();
    </script>


    {{-- About Section (settings-driven) — Selector #2 --}}
    @php
        use Illuminate\Support\Str;

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

    <section id="about-overview">
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
                                    <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
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

    <!-- ACCREDITATIONS — Selector #3 -->
    <section id="about-accreditations" style="padding:100px 0;background:linear-gradient(180deg,#890c25 0%,#6e081e 100%);">
        <div class="container">
            <div style="margin-bottom:24px;">
                <p
                    style="margin:0 0 6px;font-size:18px;letter-spacing:.08em;text-transform:uppercase;color:#fff;font-weight:600;">
                    Accreditation</p>
                <h2 style="margin:0 0 6px;font-size:40px;line-height:1.2;color:#fff;font-weight:800;">Recognitions &amp;
                    Partnerships</h2>
                <p style="margin:0;color:#fff;opacity:.85;font-size:18px;">Our international recognitions and training
                    partners.</p>
            </div>

            <div class="row g-4 align-items-stretch">
                <div class="col-lg-6">
                    @if ($accreditations->count())
                        <div style="display:grid;gap:14px;grid-template-columns:repeat(3,minmax(0,1fr));">
                            @foreach ($accreditations->take(6) as $lg)
                                <div data-acc-go="{{ $lg->id }}"
                                    style="min-height:110px;border-radius:14px;border:1px solid rgba(255,255,255,.22);background:rgba(255,255,255,.12);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;transition:transform .2s,box-shadow .2s,background .2s;cursor:pointer;">
                                    <img src="{{ $lg->imageUrl ?: asset('assets/img/others/faq_bg_1.jpg') }}"
                                        alt="{{ $lg->name ?? 'Accreditation' }}"
                                        style="max-height:64px;width:auto;object-fit:contain;filter:drop-shadow(0 2px 6px rgba(0,0,0,.15));">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="color:#fff;opacity:.75">No accreditation data.</div>
                    @endif
                </div>

                <div class="col-lg-6">
                    @if ($accreditations->count())
                        <div id="accTable"
                            style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(17,24,39,.12);">

                            <div
                                style="display:grid;grid-template-columns:72px 1fr 120px 46px;align-items:center;background:#f8fafc;border-bottom:1px solid #e5e7eb;font-weight:700;color:#111;">
                                <div style="padding:12px 14px;">Logo</div>
                                <div style="padding:12px 14px;">Accreditation</div>
                                <div style="padding:12px 14px;">Date</div>
                                <div style="padding:12px 14px;"></div>
                            </div>

                          @foreach ($accreditations as $i => $a)
    @php
        // Orijinal HTML (ola bilər)
        $descHtml = $a->description ?? '';
        // HTML-i təmizləyib səliqəli mətni al
        $descText = Str::of(strip_tags($descHtml))->squish()->__toString();

        // İlk sözü müəyyən et
        $firstWord = $descText !== '' ? Str::of($descText)->explode(' ')->first() : null;

        // Başlıqda göstəriləcək dəyər:
        //  1) description-ın ilk sözü
        //  2) yoxdursa name
        //  3) o da yoxdursa "Accreditation"
        $display = $firstWord ?: ($a->name ?? 'Accreditation');

        // Açıqlama hissəsində ilk sözü göstərməmək üçün qalan mətni hazırla
        $bodyText = $descText;

        if ($firstWord) {
            $startsWith = Str::startsWith(Str::lower($bodyText), Str::lower($firstWord . ' '))
                          || Str::lower($bodyText) === Str::lower($firstWord);
            if ($startsWith) {
                $bodyText = Str::of($bodyText)->substr(mb_strlen($firstWord))->ltrim()->__toString();
            }
        }

        // Get Courses üçün istifadə edəcəyimiz axtarış termini
        $searchTerm = $firstWord ?: ($a->name ?? null);
        $hasBody = trim($bodyText) !== '';
    @endphp

    <div data-acc-row data-id="{{ $a->id }}" {{ $i === 0 ? 'data-open=1' : '' }}
         style="display:grid;grid-template-columns:72px 1fr 120px 46px;align-items:center;border-bottom:1px solid #f1f5f9;background:#fff;cursor:pointer;">
        <div style="padding:12px 14px;">
            <div
                style="width:44px;height:44px;border-radius:10px;border:1px solid #ececec;background:#fff;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                <img src="{{ $a->imageUrl ?: asset('assets/img/others/faq_bg_1.jpg') }}"
                     alt="{{ $display }}"
                     style="max-width:100%;max-height:100%;object-fit:contain;">
            </div>
        </div>

        <div style="padding:12px 14px;">
            <div style="font-weight:700;color:#111">{{ $display }}</div>
        </div>

        <div style="padding:12px 14px;color:#6b7280;font-size:14px;">
            {{ optional($a->created_at)->format('M d, Y') }}
        </div>

        <div style="padding:12px 14px;">
            <button type="button" data-acc-toggle
                    style="width:32px;height:32px;border:0;border-radius:8px;background:#f3f4f6;display:grid;place-items:center;cursor:pointer;">
                <svg data-acc-icon width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="#111" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round"
                     style="transition:transform .2s; {{ $i === 0 ? 'transform:rotate(90deg);' : '' }}">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        </div>

        <div data-acc-desc
             style="grid-column:1 / -1;border-top:1px dashed #e5e7eb;max-height:{{ $i === 0 ? '400px' : '0' }};overflow:hidden;transition:max-height .25s ease;">
            <div data-acc-inner
                 style="padding:14px 18px 18px 18px;color:#374151;line-height:1.65;">
                @if ($hasBody)
                    {!! nl2br(e($bodyText)) !!}
                @else
                    <em style="color:#6b7280;">No description provided yet.</em>
                @endif

                {{-- Get Courses düyməsi (yalnız term varsa) --}}
                @if ($searchTerm)
                    <div style="margin-top:12px;">
                        <a href="{{ url('en/courses') . '?q=' . urlencode($searchTerm) }}"
                           class="td_btn td_style_1 td_radius_10 td_medium"
                           style="display:inline-flex;align-items:center;gap:8px;">
                            <span class="td_btn_in td_white_color td_accent_bg">
                                <span>Get Courses</span>
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach

                        </div>
                    @else
                        <div
                            style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:20px;text-align:center;color:#6b7280;">
                            No accreditation records yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- JS for accordion sync (unchanged) --}}
    <script>
        (function() {
            const rows = Array.from(document.querySelectorAll('[data-acc-row]'));

            function setHeight(row) {
                const d = row.querySelector('[data-acc-desc]');
                const i = row.querySelector('[data-acc-inner]');
                if (!d || !i) return;
                d.style.maxHeight = row.dataset.open === '1' ? i.scrollHeight + 'px' : '0px';
            }

            function openRow(row) {
                rows.forEach(r => {
                    const on = r === row;
                    r.dataset.open = on ? '1' : '0';
                    const ic = r.querySelector('[data-acc-icon]');
                    if (ic) ic.style.transform = on ? 'rotate(90deg)' : 'rotate(0deg)';
                    setHeight(r);
                });
            }
            rows.forEach(r => {
                r.addEventListener('click', e => {
                    if (e.target.closest('[data-acc-toggle]')) return;
                    openRow(r);
                });
                const b = r.querySelector('[data-acc-toggle]');
                if (b) {
                    b.addEventListener('click', e => {
                        e.stopPropagation();
                        openRow(r);
                    });
                }
            });
            rows.forEach(setHeight);
            addEventListener('resize', () => rows.forEach(r => r.dataset.open === '1' && setHeight(r)), {
                passive: true
            });
            document.querySelectorAll('[data-acc-go]').forEach(t => t.addEventListener('click', () => {
                const id = t.getAttribute('data-acc-go');
                const target = document.querySelector(`[data-acc-row][data-id="${id}"]`);
                if (!target) return;
                openRow(target);
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }));
        })();
    </script>

    <!-- WHO WE ARE + MISSION / VISION — Selector #4 -->
    <section id="about-who" class="who-section" style="padding:100px 0;">
        <div class="container">
            <style>
                .who-section,
                .who-section * {
                    font-family: "Times New Roman", Times, serif !important;
                }

                .who-card {
                    --scale: 1;
                    --shadow: 0 4px 14px rgba(0, 0, 0, .04);
                    --pad: 24px;
                    --font-mult: 1;
                    background: #fff;
                    border: 1px solid #eee;
                    border-radius: 14px;
                    padding: var(--pad);
                    box-shadow: var(--shadow);
                    transform: scale(var(--scale));
                    transition: transform .30s cubic-bezier(.2, .8, .2, 1), box-shadow .30s, border-color .30s;
                }

                .who-card:hover {
                    --scale: 1.02;
                    --shadow: 0 14px 36px rgba(2, 6, 23, .12);
                    border-color: #e5e7eb;
                }

                .who-title {
                    font-size: 22px;
                    color: var(--td-accent, #a00b2b);
                    margin-bottom: .35rem
                }

                .who-text {
                    font-size: calc(18px * var(--font-mult));
                    margin: 0;
                    line-height: 1.6
                }

                .who-card:hover .who-text {
                    --font-mult: 1.06
                }

                .fly {
                    opacity: 0;
                    will-change: transform, opacity;
                    transition: transform .7s ease, opacity .6s ease
                }

                .fly-up {
                    transform: translateY(26px)
                }

                .fly-left {
                    transform: translateX(-60px)
                }

                .fly-right {
                    transform: translateX(60px)
                }

                .fly.in-view {
                    opacity: 1;
                    transform: translateX(0) translateY(0)
                }

                .stagger-1 {
                    transition-delay: .05s
                }

                .stagger-2 {
                    transition-delay: .12s
                }

                .stagger-3 {
                    transition-delay: .18s
                }

                @media (prefers-reduced-motion: reduce) {

                    .who-card,
                    .fly {
                        transition: none !important;
                        transform: none !important;
                        opacity: 1 !important
                    }
                }
            </style>

            <div class="td_section_heading td_style_1 text-center fly fly-up stagger-1">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    {{ __("Who we are?") }}</p>
                <h2 class="td_section_title td_fs_40 mb-0">HSE.AZ LLC</h2>
            </div>

            <div class="td_height_40"></div>

            <div class="row td_gap_y_24">
                <div class="col-lg-12 fly fly-up stagger-2">
                    <div class="who-card">
                        <p class="who-text">{{ $whoWeAre }}</p>
                    </div>
                </div>

                <div class="col-lg-6 fly fly-left stagger-2">
                    <div class="who-card" style="height:100%;">
                        <h3 class="who-title">Vision</h3>
                        <p class="who-text">{{ $missionVision['vision'] }}</p>
                    </div>
                </div>

                <div class="col-lg-6 fly fly-right stagger-3">
                    <div class="who-card" style="height:100%;">
                        <h3 class="who-title">Mission</h3>
                        <p class="who-text">{{ $missionVision['mission'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function() {
                const els = document.querySelectorAll('.who-section .fly');
                if (!els.length) return;

                function revealVisibleNow() {
                    const vh = innerHeight || document.documentElement.clientHeight;
                    els.forEach(el => {
                        const r = el.getBoundingClientRect();
                        if (r.top < vh * 0.9) el.classList.add('in-view');
                    });
                }
                if ('IntersectionObserver' in window) {
                    const io = new IntersectionObserver((entries) => {
                        entries.forEach(en => {
                            if (en.isIntersecting) {
                                en.target.classList.add('in-view');
                                io.unobserve(en.target);
                            }
                        });
                    }, {
                        root: null,
                        rootMargin: '-5% 0px -5% 0px',
                        threshold: 0.12
                    });
                    els.forEach(el => io.observe(el));
                    requestAnimationFrame(revealVisibleNow);
                } else {
                    els.forEach(el => el.classList.add('in-view'));
                }
            })();
        </script>
    </section>

    <!-- Services – titles only — Selector #5 -->
    <section id="about-services" class="td_accent_bg td_shape_section_1" style="padding:100px 0;">
        <div class="container">
            <div class="row td_gap_y_20">
                <div class="col-lg-5">
                    <div class="td_section_heading td_style_1">
                        <h2 class="td_section_title td_fs_40 mb-2 td_white_color">Our Services</h2>
                        <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
                            Browse our training & awareness services. Click an item to view details.
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    @if ($services->count())
                        @foreach ($services as $svc)
                            <a href="{{ route('service-details', $svc->id) }}"
                                class="td_white_color td_fs_18 d-flex align-items-center"
                                style="gap:10px;padding:10px 0;border-bottom:1px dashed rgba(255,255,255,.25);text-decoration:none;">
                                <i class="fa-regular fa-square-check"></i>
                                <span>{{ $svc->name }}</span>
                            </a>
                        @endforeach
                    @else
                        <div class="td_white_color">No services yet.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Blog (unchanged) -->
    <section>
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    {{ __("BLOG & ARTICLES") }}</p>
                <h2 class="td_section_title td_fs_48 mb-0">{{ __("Take A Look At The Latest Articles") }}</h2>
            </div>
            <div class="td_height_50 td_height_lg_40"></div>

            <div class="row td_gap_y_30">
                @forelse($courses as $course)
                    <div class="col-lg-4">
                        <div class="td_post td_style_1">
                            <a href="{{ route('course-details', $course) }}" class="td_post_thumb d-block">
                                <img src="{{ $course->imageUrl ?: asset('assets/img/home_1/post_1.jpg') }}"
                                    alt="">
                                <i class="fa-solid fa-link"></i>
                            </a>
                            <div class="td_post_info">
                                <div class="td_post_meta td_fs_14 td_medium td_mb_20">
                                    <span><img src="{{ asset('assets/img/icons/calendar.svg') }}"
                                            alt="">{{ optional($course->created_at)->format('M d , Y') }}</span>
                                    <span><img src="{{ asset('assets/img/icons/user.svg') }}"
                                            alt="">HSE.AZ</span>
                                </div>
                                <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                                    <a href="{{ route('course-details', $course) }}">{{ $course->name }}</a>
                                </h2>
                                <p class="td_post_subtitle td_mb_24 td_heading_color td_opacity_7">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($course->description), 120) }}</p>
                                <a href="{{ route('course-details', $course) }}"
                                    class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                                    <span class="td_btn_in td_accent_color"><span>Read More</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">No courses found.</div>
                @endforelse
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>

    {{-- ===== Scroll-driven GUIDE (Settings-based for About) ===== --}}
    @php
        $guideSections = collect(setting('ui.guides.about-us.sections', []))
            ->map(
                fn($s) => [
                    'sel' => trim((string) ($s['selector'] ?? '')),
                    'title' => trim((string) ($s['title'] ?? '')),
                    'text' => trim((string) ($s['text'] ?? '')),
                ],
            )
            ->filter(fn($s) => $s['sel'] && $s['title'] && $s['text'])
            ->values()
            ->all();

        // Fallback (settings boşdursa)
        $fallbackSteps = [
            [
                'sel' => '#about-hero',
                'title' => 'Başlanğıc',
                'text' => 'Səhifənin hero hissəsi. Buradan ümumi başlıq və breadcrumb görünür.',
            ],
            [
                'sel' => '#about-overview',
                'title' => 'İcmal',
                'text' => 'Haqqımızda bölməsinin əsas məzmunu, şəkillər və CTA düyməsi.',
            ],
            [
                'sel' => '#about-accreditations',
                'title' => 'Akkreditasiya',
                'text' => 'Tərəfdaşlarımızın loqoları və cədvəl-akkordeon təsviri.',
            ],
            [
                'sel' => '#about-who',
                'title' => 'Kimik?',
                'text' => 'Who we are mətni, Vision və Mission kartları (scroll animasiya ilə).',
            ],
            [
                'sel' => '#about-services',
                'title' => 'Xidmətlər',
                'text' => 'Xidmətlərin qısa siyahısı, hər biri detal səhifəsinə açılır.',
            ],
        ];
    @endphp

    <style>
        .guide-bubble {
            position: fixed;
            right: 18px;
            bottom: 18px;
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

        @media (max-width:575.98px) {
            .guide-bubble {
                left: 12px;
                right: 12px;
                bottom: 12px
            }
        }
    </style>

    <script>
        (function() {
            const STEPS = @json($guideSections ?: $fallbackSteps, JSON_UNESCAPED_UNICODE);
            const els = STEPS.map(s => document.querySelector(s.sel));

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

            function chooseMostVisible() {
                const vh = innerHeight || document.documentElement.clientHeight;
                let bestIdx = 0,
                    bestScore = -1;
                els.forEach((el, idx) => {
                    if (!el) return;
                    const r = el.getBoundingClientRect();
                    const vis = Math.max(0, Math.min(vh, r.bottom) - Math.max(0, r.top));
                    const score = vis * (r.width || 1);
                    if (score > bestScore) {
                        bestScore = score;
                        bestIdx = idx;
                    }
                });
                setActive(bestIdx);
            }

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
            chooseMostVisible();
        })();
    </script>

@endsection
