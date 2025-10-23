{{-- resources/views/faqs.blade.php --}}
@extends('layouts.app')

@section('title', 'Faqs')

@php
    // Guide məzmununu config-dən oxu; tapılmazsa default ver
    $guide = data_get(config('ui.guides'), 'faqs.sections.0', [
        'selector' => '#faqs-list',
        'title' => 'Sual-cavab',
        'text' => 'Ən çox verilən sualları və cavabları burada tapa bilərsiniz.',
        'trigger' => 'load',
        'once' => true,
    ]);

    // Hero slider şəkilləri: settings → pages.heroes.faqs.images (max 12, optional)
    $faqSlides = (array) setting('pages.heroes.faqs.images', []);
    $faqSlides = array_values(array_filter($faqSlides, fn($v) => is_string($v) && trim($v) !== ''));
    if (count($faqSlides) === 0) {
        $faqSlides = [asset('assets/img/others/page_heading_bg.jpg')];
    }
@endphp

@section('content')
    <!-- Start Page Heading Section (Hero Slider) -->
    <section id="faqs-hero" class="td_page_heading td_center td_heading_bg text-center td_hobble">
        <style>
            /* ===== HERO SLIDER (faqs) ===== */
            #faqs-hero {
                position: relative;
                overflow: hidden;
            }

            #faqs-hero .hero-slider {
                position: absolute;
                inset: 0;
                z-index: 0;
            }

            #faqs-hero .hero-slide {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                opacity: 0;
                transition: opacity .8s ease-in-out;
                will-change: opacity;
            }

            #faqs-hero .hero-slide.is-active {
                opacity: 1;
            }

            #faqs-hero .hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(15, 23, 42, .25) 0%, rgba(15, 23, 42, .45) 100%);
                z-index: 1;
            }

            #faqs-hero .td_page_heading_in {
                position: relative;
                z-index: 2;
            }
        </style>

        {{-- Slides --}}
        <div class="hero-slider" aria-hidden="true">
            @foreach ($faqSlides as $i => $src)
                <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}" style="background-image:url('{{ $src }}')">
                </div>
            @endforeach
            <div class="hero-overlay"></div>
        </div>

        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Faqs</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Faqs</li>
                </ol>
            </div>
        </div>

        {{-- Mövcud dekorativ formaları saxlayırıq --}}
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
    <!-- End Page Heading Section -->

    {{-- HERO slider JS: 2s interval, infinite, hover-da pause --}}
    <script>
        (function() {
            const root = document.querySelector('#faqs-hero .hero-slider');
            if (!root) return;

            const slides = Array.from(root.querySelectorAll('.hero-slide'));
            if (slides.length <= 1) return; // tək şəkil üçün slider lazım deyil

            let idx = 0;
            let timer = null;
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

            const hero = document.getElementById('faqs-hero');
            hero.addEventListener('mouseenter', stop);
            hero.addEventListener('mouseleave', start);

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) stop();
                else start();
            });
        })();
    </script>

    <!-- Start Accordion Section -->
    {{-- BÜTÜN FAQ BLOKLARINI BİR KONTEYNERƏ YIĞIRIQ → #faqs-list (selector) --}}
    <section id="faqs-list">

        {{-- Column 1 --}}
        <div class="td_faq_1 td_style_1 td_type_1">
            <div class="td_faq_1_left">
                <div class="td_faq_1_img td_bg_filed" data-src="{{ asset('assets/img/others/faq_bg_1.jpg') }}"></div>
            </div>

            <div class="td_faq_1_right">
                <div class="td_section_heading td_style_1">
                    <p class="td_section_subtitle_up td_fs_18 td_medium td_spacing_1 td_mb_10 td_accent_color">Faqs 01</p>
                </div>

                <div class="td_accordians td_style_1 td_type_2 td_mb_40">
                    @forelse($faqsCol1 ?? collect() as $faq)
                        <div class="td_accordian {{ $loop->first ? 'active' : '' }}">
                            <div class="td_accordian_head">
                                <h2 class="td_accordian_title td_fs_24">{{ $faq->question }}</h2>
                                <span class="td_accordian_toggle"></span>
                            </div>
                            <div class="td_accordian_body td_fs_18">
                                <p>{!! nl2br(e($faq->answer)) !!}</p>
                            </div>
                        </div><!-- .td_accordian -->
                    @empty
                        <p class="text-muted">Məlumat yoxdur.</p>
                    @endforelse
                </div>

                <a href="{{ url('/contact') }}" class="td_btn td_style_2 td_type_2 td_heading_color td_medium">
                    Get In Touch
                    <i>
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </i>
                </a>
            </div>
        </div>

        <div class="td_height_80 td_height_lg_60"></div>

        {{-- Column 2 --}}
        <div class="td_faq_1 td_style_1">
            <div class="td_faq_1_right">
                <div class="td_section_heading td_style_1">
                    <p class="td_section_subtitle_up td_fs_18 td_medium td_spacing_1 td_mb_10 td_accent_color">Faqs 02</p>
                </div>

                <div class="td_accordians td_style_1 td_type_2 td_mb_40">
                    @foreach ($faqsCol2 ?? collect() as $faq)
                        <div class="td_accordian {{ $loop->first ? 'active' : '' }}">
                            <div class="td_accordian_head">
                                <h2 class="td_accordian_title td_fs_24">{{ $faq->question }}</h2>
                                <span class="td_accordian_toggle"></span>
                            </div>
                            <div class="td_accordian_body td_fs_18">
                                <p>{!! nl2br(e($faq->answer)) !!}</p>
                            </div>
                        </div><!-- .td_accordian -->
                    @endforeach
                </div>

                <a href="{{ url('/contact') }}" class="td_btn td_style_2 td_type_2 td_heading_color td_medium">
                    Get In Touch
                    <i>
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </i>
                </a>
            </div>

            <div class="td_faq_1_left">
                <div class="td_faq_1_img td_bg_filed" data-src="{{ asset('assets/img/others/faq_bg_2.jpg') }}"></div>
            </div>
        </div>
    </section>
    <!-- End Accordion Section -->

    {{-- Blog bölməsi (istəsəniz saxlayın) --}}
    @includeWhen(view()->exists('educvce._blog-snippet'), 'educvce._blog-snippet')
@endsection

@push('styles')
    <style>
        /* Yüngül guide baloncuğu (backdrop və kölgə yoxdur) */
        .guide-bubble {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 9999;
            max-width: 360px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 14px 34px rgba(2, 6, 23, .12);
            padding: 14px 16px;
            display: none;
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
            line-height: 1.5
        }

        .guide-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-top: 10px
        }

        .guide-actions .btn-sm {
            border-radius: 10px;
            padding: 6px 10px;
            font-weight: 700;
            border: 1px solid #e5e7eb;
            background: #fff
        }

        .guide-actions .btn-primary {
            background: #e31b23;
            border-color: #e31b23;
            color: #fff
        }

        .guide-outline {
            outline: 2px dashed #e31b23;
            outline-offset: 8px;
            border-radius: 10px;
            transition: outline-color .2s ease;
        }

        @media (max-width: 575.98px) {
            .guide-bubble {
                left: 12px;
                right: 12px;
                bottom: 12px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (() => {
            // Config-dən gələn selector/title/text (Blade → JS)
            const GUIDE = {
                sel: @json(data_get($guide, 'selector', '#faqs-list')),
                title: @json(data_get($guide, 'title', 'Sual-cavab')),
                text: @json(data_get($guide, 'text', 'Ən çox verilən sualları və cavabları burada tapa bilərsiniz.')),
                once: @json((bool) data_get($guide, 'once', true)),
                key: 'guideSeen.faqs'
            };

            function seen() {
                try {
                    return localStorage.getItem(GUIDE.key) === '1';
                } catch (_) {
                    return false;
                }
            }

            function markSeen() {
                try {
                    localStorage.setItem(GUIDE.key, '1');
                } catch (_) {}
            }

            window.addEventListener('load', () => {
                if (GUIDE.once && seen()) return;

                const target = document.querySelector(GUIDE.sel);
                if (!target) return;

                const box = document.createElement('div');
                box.className = 'guide-bubble';
                box.innerHTML = `
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M21 11.5a8.5 8.5 0 1 1-3.2-6.6L22 4l-1.8 3.7A8.46 8.46 0 0 1 21 11.5Z" stroke="#e31b23" stroke-width="2"/>
        </svg>
        <h4 style="margin:0">${GUIDE.title}</h4>
      </div>
      <p>${GUIDE.text}</p>
      <div class="guide-actions">
        <button type="button" class="btn-sm btn-primary" data-guide-close="1">Başa düşdüm</button>
        <button type="button" class="btn-sm" data-guide-hide="1">Sonra</button>
      </div>`;
                document.body.appendChild(box);

                target.classList.add('guide-outline');

                requestAnimationFrame(() => {
                    box.style.display = 'block';
                });

                box.addEventListener('click', (e) => {
                    if (e.target.matches('[data-guide-close]')) {
                        if (GUIDE.once) markSeen();
                        target.classList.remove('guide-outline');
                        box.remove();
                    }
                    if (e.target.matches('[data-guide-hide]')) {
                        target.classList.remove('guide-outline');
                        box.remove();
                    }
                });
            });
        })();
    </script>
@endpush
