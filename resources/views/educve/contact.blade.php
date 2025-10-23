@extends('layouts.app')

@php
    // Admin paneldən gələn hero şəkilləri (max 12). Boşdursa default 1 şəkil göstər.
    $contactSlides = (array) setting('pages.heroes.contact.images', []);
    $contactSlides = array_values(array_filter($contactSlides, fn($v) => is_string($v) && trim($v) !== ''));
    if (count($contactSlides) === 0) {
        $contactSlides = [asset('assets/img/others/page_heading_bg.jpg')];
    }
@endphp

<!-- Start Page Heading Section (Hero Slider) -->
<section id="contact-hero" class="td_page_heading td_center td_heading_bg text-center td_hobble">
    <style>
        /* ===== HERO SLIDER (contact) ===== */
        #contact-hero {
            position: relative;
            overflow: hidden;
        }

        .hero-slider {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity .8s ease-in-out;
            will-change: opacity;
        }

        .hero-slide.is-active {
            opacity: 1;
        }

        /* Yüngül tünd overlay ki, yazılar oxunaqlı olsun */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, .25) 0%, rgba(15, 23, 42, .45) 100%);
            z-index: 1;
        }

        /* İç kontent üst qatda qalsın */
        #contact-hero .td_page_heading_in {
            position: relative;
            z-index: 2;
        }

        /* Şəkil/form bölməsinin qalan CSS-ləri aşağıdadır (verilənlərlə eyni saxlanılıb) */
    </style>

    {{-- Slides --}}
    <div class="hero-slider" aria-hidden="true">
        @foreach ($contactSlides as $i => $src)
            <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}" style="background-image:url('{{ $src }}')">
            </div>
        @endforeach
        <div class="hero-overlay"></div>
    </div>

    <div class="container">
        <div class="td_page_heading_in">
            <h1 class="td_white_color td_fs_48 td_mb_10">Contact</h1>
            <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </div>
    </div>

    {{-- Dekorativ formalar (mövcud dizaynla eyni saxlanılıb) --}}
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
        const root = document.querySelector('#contact-hero .hero-slider');
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
            if (timer) return;
            timer = setInterval(next, INTERVAL);
        }

        function stop() {
            if (!timer) return;
            clearInterval(timer);
            timer = null;
        }

        // Autoplay
        start();

        // Hover-da dayandır, çıxanda davam et
        const hero = document.getElementById('contact-hero');
        hero.addEventListener('mouseenter', stop);
        hero.addEventListener('mouseleave', start);

        // Tab gizlənəndə dayandır, qayıdanda davam et
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) stop();
            else start();
        });
    })();
</script>

<!-- Start Contact Section -->
<section>
    <div class="td_height_120 td_height_lg_80"></div>

    {{-- ====== CONTACT CONTENT ====== --}}
    <style>
        :root {
            --bg: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: #e5e7eb;
            --accent: #e31b23;
            --card: #ffffff;
            --shadow: 0 10px 30px rgba(2, 6, 23, .06);
            --radius: 14px;
        }

        * {
            box-sizing: border-box
        }

        .wrap {
            max-width: 1180px;
            margin: 48px auto;
            padding: 0 20px
        }

        .section-title {
            font-size: 32px;
            font-weight: 800;
            margin: 0 0 18px
        }

        .subtitle {
            font-size: 13px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px
        }

        .subtitle .bar {
            width: 46px;
            height: 2px;
            background: var(--accent);
            display: inline-block;
            border-radius: 2px
        }

        .grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 40px;
            align-items: start
        }

        @media (max-width:960px) {
            .grid {
                grid-template-columns: 1fr;
                gap: 28px
            }
        }

        .details {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 24px 22px;
            box-shadow: var(--shadow)
        }

        .list {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .row {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 1px 6px;
            border-top: 1px dashed var(--line)
        }

        .row:first-child {
            border-top: none
        }

        .icon {
            width: 22px;
            height: 22px;
            flex: 0 0 22px;
            margin-top: 2px;
            background: radial-gradient(10px 10px at 60% 40%, #fff 40%, #ffd1d3 41%), var(--accent);
            -webkit-mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24"><path d="M4.293 11.293a1 1 0 0 0 0 1.414l4.95 4.95a1 1 0 0 0 1.414 0l9.05-9.05a1 1 0 1 0-1.414-1.414L10 15.086l-4.243-4.243a1 1 0 0 0-1.464.45Z"/></svg>') center/contain no-repeat;
            mask: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24"><path d="M4.293 11.293a1 1 0 0 0 0 1.414l4.95 4.95a1 1 0 0 0 1.414 0l9.05-9.05a1 1 0 1 0-1.414-1.414L10 15.086l-4.243-4.243a1 1 0 0 0-1.464.45Z"/></svg>') center/contain no-repeat;
        }

        .row strong {
            display: block;
            font-weight: 700;
            margin-bottom: 2px
        }

        .row a {
            color: #0ea5e9;
            text-decoration: none
        }

        .row a:hover {
            text-decoration: underline
        }

        .muted {
            color: var(--muted)
        }

        .form {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow)
        }

        .form h2 {
            margin: 0 0 10px;
            font-size: 32px
        }

        .fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px
        }

        .fields .full {
            grid-column: 1 / -1
        }

        .input,
        .textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 14px 14px;
            font-size: 15px;
            outline: none;
            background: #fff;
            transition: border-color .2s, box-shadow .2s
        }

        .input:focus,
        .textarea:focus {
            border-color: #fecaca;
            box-shadow: 0 0 0 4px rgba(227, 27, 35, .08)
        }

        .textarea {
            min-height: 160px;
            resize: vertical
        }

        .btn {
            margin-top: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            border: none;
            border-radius: 10px;
            background: var(--accent);
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            transition: transform .05s ease, filter .15s ease
        }

        .btn:hover {
            filter: brightness(.95)
        }

        .btn:active {
            transform: translateY(1px)
        }
    </style>

    <div class="wrap">
        <div class="subtitle">TELEPHONE AND EMAIL <span class="bar"></span></div>
        <h1 class="section-title">Contact details</h1>

        <div class="grid">
            <!-- LEFT: DETAILS -->
            <div class="details">
                <ul class="list">
                    <li class="row">
                        <span class="icon" aria-hidden="true"></span>
                        <div>
                            <strong>Telephone:</strong>
                            <a href="tel:+994512067288">(+994) 51-206-72-88</a><br />
                            <a href="tel:+994102532388">(+994) 10-253-23-88</a>
                        </div>
                    </li>
                    <li class="row">
                        <span class="icon" aria-hidden="true"></span>
                        <div>
                            <strong>For general inquiries:</strong>
                            <a href="mailto:info@hse.az">info@hse.az</a>
                        </div>
                    </li>
                    <li class="row">
                        <span class="icon" aria-hidden="true"></span>
                        <div>
                            <strong>For purchasing training courses and getting information about them:</strong>
                            <a href="mailto:training@hse.az">training@hse.az</a>
                        </div>
                    </li>
                    <li class="row">
                        <span class="icon" aria-hidden="true"></span>
                        <div>
                            <strong>For exam / assessment results of courses:</strong>
                            <a href="mailto:customerservice@hse.az">customerservice@hse.az</a>
                        </div>
                    </li>
                    <li class="row">
                        <span class="icon" aria-hidden="true"></span>
                        <div>
                            <strong>Address:</strong>
                            <span class="muted">Tbilisi Avenue 22, "Europe Hotel" 2nd Floor, Room 106, Baku,
                                Azerbaijan, AZ1078</span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- RIGHT: FORM -->
            <div>
                <div class="subtitle">ONLINE CONTACT FORM <span class="bar"></span></div>
                <div class="form" id="contact-form">
                    <h2>Message to us</h2>

                    <form method="POST" action="{{ route('contact.send') }}" id="contactForm" novalidate>
                        @csrf
                        <div class="fields">
                            <input class="input" name="full_name" type="text" placeholder="Name and surname"
                                required />
                            <input class="input" name="email" type="email" placeholder="Email" required />
                            <input class="input full" name="phone" type="text" placeholder="+994" />
                            <input class="input full" name="topic" type="text" placeholder="Topic" />
                            <textarea class="textarea full" name="message" placeholder="Your message" required></textarea>
                        </div>

                        <button style="background-color:#e31b23;color:white" class="btn" type="submit">
                            <span class="btn-text">Send</span>
                            <span class="btn-spinner" style="display:none;margin-left:8px;">⏳</span>
                        </button>
                    </form>

                    <script>
                        document.getElementById('contactForm')?.addEventListener('submit', function() {
                            const btn = this.querySelector('.btn');
                            const text = this.querySelector('.btn-text');
                            const spin = this.querySelector('.btn-spinner');
                            btn.disabled = true;
                            if (text && spin) {
                                text.style.opacity = .8;
                                spin.style.display = 'inline-block';
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>

    <div class="td_height_120 td_height_lg_80"></div>

    <div class="td_map">
        <iframe id="map"
            src="https://www.google.com/maps?q=Tbilisi+Avenue+22,+Europe+Hotel,+2nd+Floor,+Room+106,+Baku,+Azerbaijan,+AZ1078&output=embed"
            width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>
<!-- End Contact Section -->

{{-- Coach-mark komponenti: bu SƏHİFƏ üçün --}}
<x-section-guide page="contact" />
