@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $q = $q ?? request('q');
@endphp

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading (with settings-driven slider) -->
    <section id="topics-hero" class="td_page_heading td_center td_heading_bg text-center td_hobble">
        @php
            // topics hero slider şəkilləri (settings → pages.heroes.topics.images)
            $topicSlides = (array) setting('pages.heroes.topics.images', []);
            $topicSlides = array_values(array_filter($topicSlides, fn($v) => is_string($v) && trim($v) !== ''));
            if (count($topicSlides) === 0) {
                $topicSlides = [asset('assets/img/others/page_heading_bg.jpg')];
            }
        @endphp

        <style>
            /* ===== HERO SLIDER (topics) ===== */
            #topics-hero {
                position: relative;
                overflow: hidden;
            }

            #topics-hero .hero-slider {
                position: absolute;
                inset: 0;
                z-index: 0;
            }

            #topics-hero .hero-slide {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                opacity: 0;
                transition: opacity .8s ease-in-out;
                will-change: opacity;
            }

            #topics-hero .hero-slide.is-active {
                opacity: 1;
            }

            #topics-hero .hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(15, 23, 42, .25) 0%, rgba(15, 23, 42, .45) 100%);
                z-index: 1;
            }

            #topics-hero .td_page_heading_in {
                position: relative;
                z-index: 2;
            }
        </style>

        {{-- Slides (background) --}}
        <div class="hero-slider" aria-hidden="true">
            @foreach ($topicSlides as $i => $src)
                <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}" style="background-image:url('{{ $src }}')">
                </div>
            @endforeach
            <div class="hero-overlay"></div>
        </div>

        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Topics</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Topics</li>
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
        (function() {
            const root = document.querySelector('#topics-hero .hero-slider');
            if (!root) return;

            const slides = Array.from(root.querySelectorAll('.hero-slide'));
            if (slides.length <= 1) return; // Tək şəkil üçün animasiya lazım deyil

            let idx = 0,
                timer = null;
            const INTERVAL = 2000; // 2s

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

            const hero = document.getElementById('topics-hero');
            hero.addEventListener('mouseenter', stop);
            hero.addEventListener('mouseleave', start);

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) stop();
                else start();
            });
        })();
    </script>

    <section>
        <div class="td_height_120 td_height_lg_80"></div>
        <div class="container">

            {{-- Search --}}
            <div id="topics-search" class="td_mb_30">
                <form action="{{ route('topices') }}" method="GET" role="search" aria-label="Topics search">
                    <div class="input-group" style="max-width:720px;margin:0 auto;">
                        <input type="text" name="q" class="form-control"
                            placeholder="Search topics by name or description..." value="{{ $q }}"
                            autocomplete="off">
                        @if ($q)
                            <a href="{{ route('topices') }}" class="btn btn-outline-secondary">Clear</a>
                        @endif
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>

            @if ($topices->count() > 0)
                <div id="topics-grid" class="row td_gap_y_30">
                    @foreach ($topices as $t)
                        <div class="col-lg-6">
                            <div class="td_card td_style_1 td_radius_5">
                                <a href="{{ route('topices-details', $t->id) }}"
                                    class="td_card_thumb td_mb_30 d-block position-relative">
                                    <img src="{{ $t->imageUrl ?: asset('assets/img/placeholder/placeholder-800x500.jpg') }}"
                                        alt="{{ $t->name }}">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    <span class="td_card_location td_medium td_white_color td_fs_18">
                                        <svg width="16" height="22" viewBox="0 0 16 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.0004 0.5C3.86669 0.5 0.554996 3.86526 0.500458 7.98242C0.48345 9.42271 0.942105 10.7046 1.56397 11.8232C2.76977 13.9928 4.04435 16.8182 5.32856 19.4639C5.9286 20.7002 6.89863 21.5052 8.0004 21.5C9.10217 21.4948 10.0665 20.6836 10.6575 19.4404C11.9197 16.7856 13.1685 13.9496 14.4223 11.835C15.1136 10.6691 15.4653 9.3606 15.4974 8.01758C15.5966 3.86772 12.1342 0.5 8.0004 0.5Z"
                                                fill="currentColor" />
                                        </svg>
                                        {{ $t->category->name ?? ($t->category ?? 'Topic') }}
                                    </span>
                                </a>

                                <div class="td_card_info">
                                    <div class="td_card_info_in">
                                        <div class="td_mb_30">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <svg class="td_accent_color" width="22" height="24"
                                                        viewBox="0 0 22 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17.3308 11.7869H19.0049C19.3833 11.7869 19.6913 11.479 19.6913 11.1005V9.42642C19.6913 9.04795 19.3833 8.74003 19.0049 8.74003H17.3308C16.9523 8.74003 16.6444 9.04795 16.6444 9.42642V11.1005C16.6444 11.479 16.9523 11.7869 17.3308 11.7869Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                    <span>{{ optional($t->updated_at)->format('M d, Y') }}</span>
                                                </li>
                                                <li>
                                                    <svg class="td_accent_color" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"
                                                            stroke="currentColor" stroke-width="1.6" />
                                                        <circle cx="12" cy="12" r="3" stroke="currentColor"
                                                            stroke-width="1.6" />
                                                    </svg>
                                                    <span>{{ number_format($t->views ?? 0) }} views</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <h2 class="td_card_title td_fs_32 td_semibold td_mb_20">
                                            <a href="{{ route('topices-details', $t->id) }}">{{ $t->name }}</a>
                                        </h2>

                                        @php $desc = strip_tags($t->description ?? ''); @endphp
                                        <p class="td_mb_30 td_fs_18">{{ $desc ? Str::limit($desc, 180) : ' ' }}</p>

                                        <a href="{{ route('topices-details', $t->id) }}"
                                            class="td_btn td_style_1 td_radius_10 td_medium">
                                            <span class="td_btn_in td_white_color td_accent_bg">
                                                <span>Learn More</span>
                                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor"
                                                        stroke-width="1.5" />
                                                </svg>
                                            </span>
                                        </a>
                                        @if (!empty($t->courseUrl))
                                            <a href="{{ $t->courseUrl }}" target="_blank" rel="noopener"
                                                class="td_btn td_style_2 td_radius_10 td_medium">
                                                <span
                                                    class="td_btn_in td_heading_color td_white_bg"><span>Visit</span></span>
                                            </a>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                @if (method_exists($topices, 'links'))
                    <div class="td_height_60 td_height_lg_40"></div>
                    <div class="text-center">{{ $topices->appends(['q' => $q])->links() }}</div>
                @endif
            @else
                <div class="text-center td_opacity_8">
                    @if ($q)
                        No topics found for “{{ $q }}”.
                        <div class="td_height_10"></div>
                        <a href="{{ route('topices') }}" class="td_btn td_style_2 td_radius_10 td_medium">
                            <span class="td_btn_in td_heading_color td_white_bg"><span>Show All</span></span>
                        </a>
                    @else
                        No topics added yet.
                    @endif
                </div>
            @endif

        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>

    {{-- Coach-mark komponenti: bu səhifə üçün --}}
    <x-section-guide page="topices" />
@endsection
