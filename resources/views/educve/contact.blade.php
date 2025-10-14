@extends('layouts.app')


<!-- Start Page Heading Section -->
<section id="contact-hero" class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
        <div class="td_page_heading_in">
            <h1 class="td_white_color td_fs_48 td_mb_10">Contact</h1>
            <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </div>
    </div>
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
                            <a href="tel:+994512067288">(+994) 51-206-72-88</a>
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
                            <strong>Shopping for other products:</strong>
                            <a href="mailto:shopping@hse.az">shopping@hse.az</a>
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
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96652.27317354927!2d-74.33557928194516!3d40.79756494697628!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c3a82f1352d0dd%3A0x81d4f72c4435aab5!2sTroy+Meadows+Wetlands!5e0!3m2!1sen!2sbd!4v1563075599994!5m2!1sen!2sbd"
            allowfullscreen=""></iframe>
    </div>
</section>
<!-- End Contact Section -->

{{-- Coach-mark komponenti: bu SƏHİFƏ üçün --}}
<x-section-guide page="contact" />
