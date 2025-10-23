@extends('layouts.app')

@php
    $q = $q ?? request('q');

    // Team hero slider şəkilləri (settings → pages.heroes.team.images)
    $teamSlides = (array) setting('pages.heroes.team.images', []);
    $teamSlides = array_values(array_filter($teamSlides, fn($v) => is_string($v) && trim($v) !== ''));
    if (count($teamSlides) === 0) {
        $teamSlides = [asset('assets/img/others/page_heading_bg.jpg')];
    }

    $female =
        'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';
    $male = 'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
@endphp

@section('content')
    {{-- PAGE HERO (Slider) --}}
    <section id="team-hero" class="td_page_heading td_center td_heading_bg text-center td_hobble">
        <style>
            /* ===== HERO SLIDER (team) ===== */
            #team-hero {
                position: relative;
                overflow: hidden;
            }

            #team-hero .hero-slider {
                position: absolute;
                inset: 0;
                z-index: 0;
            }

            #team-hero .hero-slide {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                opacity: 0;
                transition: opacity .8s ease-in-out;
                will-change: opacity;
            }

            #team-hero .hero-slide.is-active {
                opacity: 1;
            }

            #team-hero .hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(15, 23, 42, .25) 0%, rgba(15, 23, 42, .45) 100%);
                z-index: 1;
            }

            #team-hero .td_page_heading_in {
                position: relative;
                z-index: 2;
            }
        </style>

        {{-- Slides --}}
        <div class="hero-slider" aria-hidden="true">
            @foreach ($teamSlides as $i => $src)
                <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}" style="background-image:url('{{ $src }}')">
                </div>
            @endforeach
            <div class="hero-overlay"></div>
        </div>

        {{-- Heading --}}
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Team Members</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Team Members</li>
                </ol>
            </div>
        </div>

        {{-- Mövcud dekorativ formalar --}}
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

    {{-- HERO slider JS: 2s interval, infinite, hover-da pause --}}
    <script>
        (function() {
            const root = document.querySelector('#team-hero .hero-slider');
            if (!root) return;

            const slides = Array.from(root.querySelectorAll('.hero-slide'));
            if (slides.length <= 1) return; // tək şəkil üçün slider lazım deyil

            let idx = 0;
            let timer = null;
            const INTERVAL = 2000; // 2 saniyə

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

            const hero = document.getElementById('team-hero');
            hero.addEventListener('mouseenter', stop);
            hero.addEventListener('mouseleave', start);

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) stop();
                else start();
            });
        })();
    </script>

    {{-- CONTENT --}}
    <section>
        <div class="td_height_120 td_height_lg_80"></div>
        <div class="container">

            {{-- SEARCH / FILTER --}}
            <form id="team-search" method="GET" class="row g-2 mb-4">
                <div class="col-md-6">
                    <input type="search" class="form-control" name="q" value="{{ $q }}"
                        placeholder="Ad / vəzifə üzrə axtar…">
                </div>
                <div class="col-md-4">
                    <select name="gender" class="form-select">
                        <option value="">Bütün cinslər</option>
                        <option value="male" @selected(($gender ?? '') === 'male')>Kişi</option>
                        <option value="female" @selected(($gender ?? '') === 'female')>Qadın</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-100">Axtar</button>
                    <a href="{{ route('team') }}" class="btn btn-outline-secondary">Təmizlə</a>
                </div>
            </form>

            @if ($teams->count())
                <div id="team-grid" class="row td_gap_y_30">
                    @foreach ($teams as $t)
                        @php
                            $thumb = $t->imageUrl ?: ($t->gender === 'female' ? $female : $male);
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="td_team td_style_3 text-center position-relative">
                                <div class="td_team_thumb_wrap td_mb_20">
                                    <div class="td_team_thumb">
                                        <a href="{{ route('team-details', $t) }}">
                                            <img src="{{ $thumb }}" alt="{{ $t->full_name }}"
                                                class="w-100 td_radius_10" style="height:300px;object-fit:cover">
                                        </a>
                                    </div>
                                    <img class="td_team_thumb_shape" src="{{ asset('assets/img/home_4/team_shape.png') }}"
                                        alt="">
                                </div>
                                <div class="td_team_info td_white_bg">
                                    <h3 class="td_team_member_title td_fs_24 td_semibold mb-0">
                                        <a href="{{ route('team-details', $t) }}">{{ $t->full_name }}</a>
                                    </h3>
                                    <p class="td_team_member_designation mb-0 td_fs_18 td_opacity_7 td_heading_color">
                                        {{ $t->position ?: '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="td_height_60 td_height_lg_40"></div>
                <div class="d-flex justify-content-center">
                    {{ $teams->links() }}
                </div>
            @else
                <div class="text-center text-muted">Məlumat tapılmadı.</div>
            @endif
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>

    {{-- Coach-mark komponenti: bu səhifə üçün --}}
    <x-section-guide page="team" />
@endsection
