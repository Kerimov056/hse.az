@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $q = $q ?? request('q');
@endphp

<style>
    /* ===== THEME TOKENS ===== */
    :root {
        --ink: #0f172a;
        --muted: #64748b;
        --line: #e5e7eb;
        --card: #ffffff;
        --bg: #f8fafc;
        --chip: #f1f5f9;
    }

    /* ===== SEARCH ===== */
    .courses-search-wrap {
        display: flex;
        justify-content: center
    }

    .courses-search {
        display: flex;
        gap: .6rem;
        width: 100%;
        max-width: 820px
    }

    .courses-search input[type="text"] {
        flex: 1;
        min-width: 0;
        height: 48px;
        border: 1px solid var(--line);
        border-radius: 999px;
        padding: .8rem 1rem;
        font-size: 1rem;
        background: #fff;
    }

    .courses-search .td_btn {
        border: none;
        border-radius: 999px;
        padding: .8rem 1.1rem;
        font-weight: 700
    }

    @media (max-width:575.98px) {
        .courses-search {
            flex-direction: column
        }

        .courses-search .td_btn {
            width: 100%
        }
    }

    /* ===== CARD ===== */
    .course-card {
        height: 100%;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 26px rgba(15, 23, 42, .06);
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease
    }

    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 42px rgba(15, 23, 42, .10);
        border-color: #dbe1ea
    }

    /* media */
    .course-media {
        position: relative;
        display: block;
        overflow: hidden;
        background: #0b1220
    }

    .course-media::before {
        content: "";
        display: block;
        padding-top: 62.5%
    }

    .course-media>img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s ease
    }

    .course-card:hover .course-media>img {
        transform: scale(1.045)
    }

    .media-grad {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, .0) 45%, rgba(0, 0, 0, .65) 100%)
    }

    .media-top {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        display: flex;
        justify-content: space-between;
        gap: 8px
    }

    .media-bottom {
        position: absolute;
        left: 12px;
        right: 12px;
        bottom: 12px;
        display: flex;
        justify-content: space-between;
        gap: 8px
    }

    /* chips */
    .chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: 6px 10px;
        font-weight: 700;
        font-size: .78rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, .92);
        color: #0f172a
    }

    .chip-dark {
        background: rgba(0, 0, 0, .65);
        color: #fff
    }

    /* body */
    .course-body {
        padding: 14px 14px 16px;
        display: flex;
        flex-direction: column;
        gap: .5rem
    }

    .course-title {
        font-size: 1.05rem;
        font-weight: 800;
        margin: 0
    }

    .course-desc {
        color: var(--ink);
        opacity: .78;
        line-height: 1.55
    }

    .meta-row {
        display: flex;
        gap: .5rem;
        align-items: center;
        color: var(--muted);
        font-size: .9rem;
        flex-wrap: wrap
    }

    .meta-row .dot {
        width: 4px;
        height: 4px;
        background: #cbd5e1;
        border-radius: 50%
    }

    .btn-wide {
        min-width: 100px
    }

    .btn-wide .td_btn_in {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .9rem 1.15rem
    }

    /* actions */
    .actions {
        margin-top: auto;
        display: flex;
        gap: .5rem;
        flex-wrap: wrap
    }

    .btn-soft {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        font-weight: 700
    }

    .btn-primary-round {
        border-radius: 10px;
        font-weight: 700
    }

    /* empty state */
    .empty-state {
        max-width: 560px;
        margin: 40px auto 0;
        text-align: center
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 14px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f7fb
    }

    .empty-title {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: .25rem
    }

    .empty-desc {
        opacity: .75
    }
</style>

<!-- Header -->
<header class="td_site_header td_style_1 td_type_2 td_sticky_header td_medium td_heading_color">
    {{-- mövcud header olduğu kimi qalır --}}
</header>
<!-- End Header -->

<!-- Page Heading (with settings-driven slider) -->
<section id="courses-hero" class="td_page_heading td_center td_heading_bg text-center td_hobble">
    @php
        // courses hero slider şəkilləri (settings → pages.heroes.courses.images)
        $courseSlides = (array) setting('pages.heroes.courses.images', []);
        $courseSlides = array_values(array_filter($courseSlides, fn($v) => is_string($v) && trim($v) !== ''));
        if (count($courseSlides) === 0) {
            $courseSlides = [asset('assets/img/others/page_heading_bg.jpg')];
        }
    @endphp

    <style>
        /* ===== HERO SLIDER (courses) ===== */
        #courses-hero { position: relative; overflow: hidden; }
        #courses-hero .hero-slider { position: absolute; inset: 0; z-index: 0; }
        #courses-hero .hero-slide{
            position:absolute; inset:0;
            background-size:cover; background-position:center;
            opacity:0; transition:opacity .8s ease-in-out; will-change:opacity;
        }
        #courses-hero .hero-slide.is-active{ opacity:1; }
        #courses-hero .hero-overlay{
            position:absolute; inset:0;
            background:linear-gradient(180deg, rgba(15,23,42,.25) 0%, rgba(15,23,42,.45) 100%);
            z-index:1;
        }
        #courses-hero .td_page_heading_in{ position:relative; z-index:2; }
    </style>

    {{-- Slides (background) --}}
    <div class="hero-slider" aria-hidden="true">
        @foreach ($courseSlides as $i => $src)
            <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}"
                 style="background-image:url('{{ $src }}')"></div>
        @endforeach
        <div class="hero-overlay"></div>
    </div>

    <div class="container">
        <div class="td_page_heading_in">
            <h1 class="td_white_color td_fs_48 td_mb_10">{{ __("Courses") }}</h1>
            <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __("Home") }}</a></li>
                <li class="breadcrumb-item active">{{ __("Courses") }}</li>
            </ol>
        </div>
    </div>

    {{-- Mövcud dekorativ formalar (eyni saxlanılıb) --}}
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

{{-- HERO slider JS: 2s interval, hover-da dayandırır, tab dəyişəndə pauza edir --}}
<script>
    (function () {
        const root = document.querySelector('#courses-hero .hero-slider');
        if (!root) return;

        const slides = Array.from(root.querySelectorAll('.hero-slide'));
        if (slides.length <= 1) return; // Tək şəkil üçün animasiya lazım deyil

        let idx = 0, timer = null;
        const INTERVAL = 2000; // 2s

        function show(i){ slides.forEach((s,k)=>s.classList.toggle('is-active', k===i)); }
        function next(){ idx = (idx + 1) % slides.length; show(idx); }

        function start(){ if(!timer) timer = setInterval(next, INTERVAL); }
        function stop(){ if(timer){ clearInterval(timer); timer = null; } }

        start();

        const hero = document.getElementById('courses-hero');
        hero.addEventListener('mouseenter', stop);
        hero.addEventListener('mouseleave', start);

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) stop(); else start();
        });
    })();
</script>


<!-- Courses Grid View -->
<section style="background:var(--bg)">
    <div class="td_height_120 td_height_lg_80"></div>
    <div class="container">

        {{-- Search --}}
        <div class="courses-search-wrap">
            <form id="courses-search" class="courses-search" action="{{ route('courses-grid-view') }}" method="GET"
                role="search" aria-label="Course search">
                <input type="text" name="q" value="{{ $q }}"
                    placeholder="Search by name or description..." autocomplete="off" />
                <button class="td_btn td_style_1 td_medium" type="submit">
                    <span class="td_btn_in td_white_color td_accent_bg">
                        <span>{{ __("Axtar") }}</span>
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
                </button>
                @if ($q)
                    <a href="{{ route('courses-grid-view') }}" class="td_btn td_style_2 td_medium" title="Clear search">
                        <span class="td_btn_in td_heading_color td_white_bg"><span>Clear</span></span>
                    </a>
                @endif
            </form>
        </div>

        <div class="td_height_40 td_height_lg_30"></div>

        {{-- Header (counts + query) --}}
        <div class="td_section_head_2">
            <div class="td_section_head_2_left">
                <span class="td_heading_color td_medium">
                    @if (method_exists($courses, 'total'))
                        @if (($q ?? '') !== '')
                      
                        @else
                            Showing {{ $courses->count() }} Courses of {{ $courses->total() }}
                        @endif
                    @else
                        {{ $q ? "Result for “{$q}”: " . count($courses) . ' course(s)' : 'Showing ' . count($courses) . ' Courses' }}
                    @endif
                </span>
            </div>
        </div>

        <div class="td_height_30"></div>

        {{-- GRID --}}
        @if ($courses->count() > 0)
            <div id="courses-grid" class="row td_gap_y_30 td_row_gap_30">
                @foreach ($courses as $course)
                    <div class="col-lg-4 col-md-6">
                        <article class="course-card">

                            {{-- Media --}}
                            <a href="{{ route('course-details', $course->id) }}" class="course-media"
                                aria-label="Open {{ $course->name }}">
                                @if (!empty($course->imageUrl))
                                    <img src="{{ $course->imageUrl }}" alt="{{ $course->name }}">
                                @else
                                    <img src="{{ asset('assets/img/placeholder/placeholder-800x500.jpg') }}"
                                        alt="{{ $course->name }}">
                                @endif

                                <div class="media-grad"></div>

                                <div class="media-top">
                                    <span
                                        class="chip">{{ $course->category->name ?? ($course->category ?? 'General') }}</span>
                                    <span class="chip chip-dark" title="Views">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"
                                                stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <circle cx="12" cy="12" r="3" stroke="currentColor"
                                                stroke-width="1.6" />
                                        </svg>
                                        {{ number_format($course->views ?? 0) }}
                                    </span>
                                </div>

                                <div class="media-bottom">
                                    @if (!empty($course->courseUrl))
                                        <span class="chip">External</span>
                                    @endif
                                </div>
                            </a>

                            {{-- Body --}}
                            <div class="course-body">
                                <h2 class="course-title">
                                    <a href="{{ route('course-details', $course->id) }}"
                                        class="td_heading_color">{{ $course->name }}</a>
                                </h2>

                                @php $desc = trim(strip_tags($course->description ?? '')); @endphp
                                @if ($desc)
                                    <p class="course-desc">{{ Str::limit($desc, 120) }}</p>
                                @endif

                                <div class="meta-row">
                                    <span>{{ optional($course->created_at)->format('M d, Y') }}</span>
                                    <span class="dot"></span>
                                    <span>{{ $course->level ?? 'All levels' }}</span>
                                    @if (!empty($course->duration))
                                        <span class="dot"></span>
                                        <span>{{ $course->duration }}</span>
                                    @endif
                                </div>

                                <div class="actions">
                                    <a href="{{ route('course-details', $course->id) }}"
                                        class="td_btn td_style_1 td_medium btn-primary-round">
                                        <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                                    </a>
                                    @if (!empty($course->courseUrl))
                                        <a href="{{ $course->courseUrl }}" target="_blank" rel="noopener"
                                            class="td_btn td_style_2 td_medium btn-soft btn-wide">
                                            <span
                                                class="td_btn_in td_heading_color td_white_bg"><span>Visit</span></span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </article>
                    </div>
                @endforeach
            </div>

            @if (method_exists($courses, 'links'))
                <div class="td_height_60 td_height_lg_40"></div>
                <div class="d-flex justify-content-center">
                    {{ $courses->appends(['q' => $q])->links() }}
                </div>
            @endif
        @else
            {{-- Empty state --}}
            @if (($q ?? '') !== '')
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" width="30" height="30" fill="none"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.6" />
                            <path d="M20 20L17 17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="empty-title">Axtardığınız üzrə nəticə tapılmadı</div>
                    <div class="empty-desc">“{{ $q }}” üçün uyğun kurs tapılmadı. Başqa açar sözlə
                        yoxlayın.</div>
                    <div class="td_height_20"></div>
                    <a href="{{ route('courses-grid-view') }}" class="td_btn td_style_2 td_radius_10 td_medium">
                        <span class="td_btn_in td_heading_color td_white_bg"><span>Hamısını göstər</span></span>
                    </a>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-title">Hələ kurs əlavə edilməyib</div>
                    <div class="empty-desc">Tezliklə yeni kurslar burada görünəcək.</div>
                </div>
            @endif
        @endif

        <div class="td_height_60 td_height_lg_40"></div>
    </div>
    <div class="td_height_120 td_height_lg_80"></div>
</section>

{{-- Coach-mark komponenti: bu səhifə üçün --}}
<x-section-guide page="course" />
