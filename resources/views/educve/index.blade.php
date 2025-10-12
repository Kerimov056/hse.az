@php use Illuminate\Support\Str; @endphp

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
        <div class="td_main_header">
            <div class="container-fluid">
                <div class="td_main_header_in">
                    {{-- Left: Logo + Socials --}}
                    <div class="td_main_header_left">
                        <a class="td_site_branding" href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo">
                        </a>
                        <div class="td_header_social_btns">
                            <a href="#" class="td_center"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="td_center"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="#" class="td_center"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="td_center"><i class="fa-brands fa-pinterest-p"></i></a>
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
                                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo">
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
                                        @auth
                                            @if (auth()->user()->isAdmin())
                                                <a href="{{ route('admin.dashboard') }}"
                                                    class="td_btn td_style_1 td_medium">
                                                    <span
                                                        class="td_btn_in td_white_color td_accent_bg"><span>Admin</span></span>
                                                </a>
                                            @endif
                                        @endauth
                                        @auth
                                            <li class="menu-item-has-children">
                                                <a href="#">{{ Auth::user()->name }}</a>
                                                <ul>
                                                    {{-- Gərək olsa profil/linklər bura --}}
                                                    <li>
                                                        <form method="POST" action="{{ route('logout') }}"
                                                            class="px-3 py-2">
                                                            @csrf
                                                            <button type="submit"
                                                                class="td_btn td_style_1 td_medium w-100">
                                                                <span class="td_btn_in td_white_color td_accent_bg">
                                                                    <span>Logout</span>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endauth
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

                        {{-- TOP-RIGHT Auth controls (compact) --}}
                        @guest
                            <div class="d-inline-flex align-items-center gap-2 ms-2">
                                <a href="{{ route('auth.show', 'login') }}" class="td_btn td_style_1 td_medium">
                                    <span class="td_btn_in td_white_color td_heading_bg"><span>Login</span></span>
                                </a>
                                <a href="{{ route('auth.show', 'register') }}" class="td_btn td_style_1 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg"><span>Register</span></span>
                                </a>
                            </div>
                        @endguest
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
            <a class="td_site_branding" href="index.html">
                <img src="{{ asset('assets/img/logo_black.svg') }}" alt="Logo">

            </a>
            <div class="td_side_header_box">
                <h2 class="td_side_header_heading">Do you have a project in your <br> mind? Keep connect us.</h2>
            </div>
            <div class="td_side_header_box">
                <h3 class="td_side_header_title td_heading_color">Contact Us</h3>
                <ul class="td_side_header_contact_info td_mp_0">
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <span><a href="tel:+444547800112">+44 454 7800 112</a></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <span><a href="mailto:example@gmail.com">example@gmail.com</a></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>50 Wall Street Suite, 44150 <br>Ohio, United States</span>
                    </li>
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
                    <a href="#" class="td_center">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="td_center">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="td_center">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="#" class="td_center">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Section -->
    <!-- Start Hero Section -->
    <section class="td_hero td_style_1 td_heading_bg td_center td_bg_filed"
        data-src="{{ asset('assets/img/home_1/hero_bg_1.jpg') }}">
        <div class="container">
            <div class="td_hero_text wow fadeInRight" data-wow-duration="0.9s" data-wow-delay="0.35s">
                <p
                    class="td_hero_subtitle_up td_fs_18 td_white_color td_spacing_1 td_semibold text-uppercase td_mb_10 td_opacity_9">
                    Knowledge is Power</p>
                <h1 class="td_hero_title td_fs_64 td_white_color td_mb_12"><span>Educve</span> - The Best Place to
                    Invest in your Knowledge </h1>
                <p class="td_hero_subtitle td_fs_18 td_white_color td_opacity_7 td_mb_30">A university is a vibrant
                    institution that serves as a hub for higher education and research. It provides a dynamic
                    environment.</p>
                <a href="courses-grid-view.html" class="td_btn td_style_1 td_radius_10 td_medium">
                    <span class="td_btn_in td_white_color td_accent_bg">
                        <span>View Our Program</span>
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
            </div>
        </div>
        <div class="td_lines">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </section>
    <div class="container">
        <div class="td_hero_btn_group">
            <a href="courses-grid-view.html" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Apply Now</span>
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
            <a href="signup.html" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Request Info</span>
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.7945 12.2734H8.95703C8.74129 12.2734 8.56641 12.4484 8.56641 12.6641V14.768C8.56641 14.9837 8.74129 15.1587 8.95703 15.1587H10.7945C11.0102 15.1587 11.1851 14.9837 11.1851 14.768V12.6641C11.1851 12.4483 11.0102 12.2734 10.7945 12.2734ZM10.4038 14.3774H9.34766V13.0547H10.4038V14.3774Z"
                            fill="currentColor" />
                        <path
                            d="M13.0728 5.01978C12.7536 4.76443 12.3872 4.57568 11.9835 4.45861C10.202 3.94346 8.23896 4.61154 7.50396 6.33584C7.43154 6.5058 7.48806 6.7033 7.63951 6.80916L9.08424 7.81908C9.26111 7.94267 9.50451 7.89955 9.62814 7.72279C9.69381 7.62896 9.76912 7.5208 9.85353 7.39881C9.99142 7.19982 10.1816 7.0499 10.397 6.94576C10.489 6.90123 10.5962 6.87959 10.7247 6.87959C10.9277 6.87959 11.1021 6.93791 11.2577 7.05779C11.3854 7.15627 11.4423 7.28365 11.4423 7.47084C11.4423 7.60982 11.4012 7.72803 11.3129 7.84279C10.9575 8.30463 10.4116 8.55889 9.86623 8.85221C9.58689 9.00271 9.35529 9.17463 9.17787 9.36326C8.99771 9.55474 8.85728 9.76459 8.76064 9.9867C8.66752 10.2002 8.60357 10.4253 8.57072 10.6556C8.54017 10.8694 8.52466 11.0956 8.52466 11.3281C8.52466 11.5438 8.69955 11.7187 8.91529 11.7187H10.7668C10.9825 11.7187 11.1574 11.5438 11.1574 11.3281C11.1574 11.2158 11.1831 11.1262 11.2361 11.054C11.3113 10.9515 11.415 10.8558 11.5446 10.7694C11.971 10.485 12.1675 10.4474 12.6908 10.0988C13.1681 9.79709 13.5367 9.43678 13.7863 9.02787C14.043 8.60728 14.1732 8.0881 14.1732 7.48482C14.1732 6.92166 14.0697 6.42881 13.8654 6.01959C13.6629 5.61494 13.3962 5.27853 13.0728 5.01978ZM13.1195 8.62096C12.9324 8.92744 12.6465 9.2033 12.2698 9.44084C12.2104 9.47803 12.018 9.61357 11.7039 9.77424C11.4899 9.88385 11.2904 10 11.1112 10.1195C10.9053 10.2567 10.7354 10.4158 10.6062 10.592C10.5289 10.6973 10.471 10.8128 10.4325 10.9376H9.32384C9.38525 10.2872 9.62193 9.87127 10.2365 9.54021C10.8783 9.19498 11.4781 8.9092 11.9322 8.3192C12.1255 8.06775 12.2235 7.78236 12.2235 7.47092C12.2235 7.0426 12.0545 6.68584 11.7346 6.43908C11.4411 6.21303 11.1014 6.09842 10.7247 6.09842C10.479 6.09842 10.2543 6.14693 10.0567 6.24256C9.47986 6.52142 9.24478 6.91709 9.21091 6.95451L8.36205 6.36111C8.56916 5.99974 8.85256 5.71349 9.22185 5.49123C9.98404 5.03264 10.9217 4.9649 11.7661 5.20908C12.0706 5.29736 12.3461 5.43892 12.5847 5.62986C12.8193 5.81756 13.0152 6.06631 13.1666 6.36892C13.3161 6.66849 13.392 7.04396 13.392 7.4849C13.392 7.94252 13.3003 8.32474 13.1195 8.62096Z"
                            fill="currentColor" />
                        <path
                            d="M10.5 1.32812C5.75047 1.32812 1.90625 5.17172 1.90625 9.92188C1.90625 11.5843 2.37914 13.1897 3.27582 14.5779L2.08254 18.1577C1.98266 18.4573 2.26367 18.7482 2.56801 18.6546L6.39953 17.4756C7.65207 18.1565 9.06594 18.5156 10.5 18.5156C15.2495 18.5156 19.0938 14.672 19.0938 9.92184C19.0938 5.17238 15.2502 1.32812 10.5 1.32812ZM10.5 17.7343C9.14422 17.7343 7.80855 17.3815 6.63734 16.7139C6.54387 16.6606 6.4323 16.6481 6.32902 16.6799L3.06375 17.6846L4.07715 14.6444C4.11562 14.529 4.09812 14.4023 4.02984 14.3016C3.15168 13.007 2.6875 11.4925 2.6875 9.92188C2.6875 5.61406 6.19219 2.10938 10.5 2.10938C14.8078 2.10938 18.3125 5.61406 18.3125 9.92188C18.3125 14.2296 14.8078 17.7343 10.5 17.7343Z"
                            fill="currentColor" />
                    </svg>
                </span>
            </a>
            <a href="#" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Chat With Us</span>
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_34_1694)">
                            <path
                                d="M2.80635 15.5992C2.13805 15.5992 1.48514 15.4286 0.893423 15.0964C0.588974 14.9396 0.471056 14.5473 0.652933 14.2522C1.25723 13.2866 1.47544 12.1062 1.19876 10.9962C0.911987 9.84535 0.497046 8.87611 0.500016 7.65782C0.510313 3.38361 4.06791 -0.0814611 8.33776 0.0014578C12.4619 0.0845253 15.8608 3.55138 15.8609 7.67663C15.8609 13.0643 10.2146 16.8469 5.22991 14.7664C4.54285 15.3057 3.67925 15.5992 2.80635 15.5992ZM1.99429 14.2838C2.93328 14.5754 3.98934 14.3424 4.71344 13.6424C4.89185 13.4699 5.15872 13.4265 5.38258 13.5335C9.65016 15.5739 14.6728 12.3758 14.6727 7.67663C14.6727 4.17008 11.8201 1.2599 8.31385 1.1893C4.70047 1.11752 1.69682 4.04399 1.68811 7.66069C1.68529 8.81785 2.13676 9.74263 2.38349 10.8388C2.64343 11.994 2.50651 13.2155 1.99429 14.2838Z"
                                fill="currentColor" />
                            <path
                                d="M18.193 20.0027C17.3201 20.0027 16.4565 19.7092 15.7695 19.17C13.1186 20.2763 9.96528 19.7725 7.79172 17.8954C7.5434 17.6809 7.51598 17.3059 7.73038 17.0575C7.94483 16.8092 8.31992 16.7817 8.56823 16.9962C10.496 18.661 13.3193 19.0355 15.6168 17.9371C15.8406 17.83 16.1074 17.8735 16.2859 18.046C17.01 18.746 18.0661 18.9791 19.0051 18.6873C18.4008 17.427 18.3171 15.9831 18.7854 14.6464C18.7896 14.6344 18.7942 14.6225 18.7991 14.6108C19.1411 13.8046 19.3134 12.9478 19.3113 12.0642C19.3075 10.5065 18.7893 9.06544 17.8126 7.89691C17.6022 7.64513 17.6358 7.27053 17.8875 7.06014C18.1392 6.8497 18.5139 6.88326 18.7242 7.13499C19.8646 8.49937 20.495 10.2489 20.4994 12.0614C20.5019 13.0995 20.3005 14.107 19.9008 15.0563C19.4809 16.2718 19.674 17.5732 20.3464 18.6557C20.5284 18.9508 20.4104 19.3431 20.1058 19.5C19.5142 19.8321 18.8612 20.0027 18.193 20.0027Z"
                                fill="currentColor" />
                            <path
                                d="M8.18217 8.64459C8.7013 8.64459 9.12215 8.22397 9.12215 7.70511C9.12215 7.18625 8.7013 6.76562 8.18217 6.76562C7.66303 6.76562 7.24219 7.18625 7.24219 7.70511C7.24219 8.22397 7.66303 8.64459 8.18217 8.64459Z"
                                fill="currentColor" />
                            <path
                                d="M4.71732 8.64459C5.23646 8.64459 5.6573 8.22397 5.6573 7.70511C5.6573 7.18625 5.23646 6.76562 4.71732 6.76562C4.19819 6.76562 3.77734 7.18625 3.77734 7.70511C3.77734 8.22397 4.19819 8.64459 4.71732 8.64459Z"
                                fill="currentColor" />
                            <path
                                d="M11.6431 8.64459C12.1622 8.64459 12.5831 8.22397 12.5831 7.70511C12.5831 7.18625 12.1622 6.76562 11.6431 6.76562C11.124 6.76562 10.7031 7.18625 10.7031 7.70511C10.7031 8.22397 11.124 8.64459 11.6431 8.64459Z"
                                fill="currentColor" />
                        </g>
                        <defs>
                            <clipPath id="clip0_34_1694">
                                <rect width="20" height="20" fill="currentColor"
                                    transform="translate(0.5)" />
                            </clipPath>
                        </defs>
                    </svg>
                </span>
            </a>
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
                    <svg><!-- ... --></svg></div>
                <div class="td_features_shape_2 position-absolute td_accent_color td_hover_layer_5">
                    <svg><!-- ... --></svg></div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    {{-- End Feature Section --}}



    <!-- Start Campus Life -->
    <section class="td_accent_bg td_shape_section_1">
        <div class="td_shape_position_4 td_accent_color position-absolute">
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
                <div class="col-lg-5 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_height_57 td_height_lg_0"></div>
                    <div class="td_section_heading td_style_1">
                        <h2 class="td_section_title td_fs_48 mb-0 td_white_color">Navigate</h2>
                        <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
                            Far far away, behind the word mountains, far from the Consonantia, there live the blind
                            texts.
                            Separated they marks grove right at the coast of the Semantics
                        </p>
                    </div>

                    <div class="td_btn_box">
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
                            <a href="courses-grid-view.html"
                                class="td_btn td_style_1 td_radius_10 td_medium td_fs_18">
                                <span class="td_btn_in td_heading_color td_white_bg">
                                    <span>View All Program</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 offset-lg-1">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s"
                                data-wow-delay="0.2s">
                                <a href="course-details.html" class="td_card_thumb d-block">
                                    <img src="{{ asset('assets/img/home_1/campur_life_1.jpg') }}" alt=""
                                        class="w-100">
                                </a>
                                <div class="td_card_info">
                                    <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                        <a href="course-details.html">Campus Student Life</a>
                                    </h2>
                                    <a href="course-details.html" class="td_card_btn">
                                        <!-- SVG icons qalır -->
                                    </a>
                                </div>
                            </div>

                            <div class="td_height_40 td_height_lg_30"></div>

                            <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s"
                                data-wow-delay="0.3s">
                                <a href="course-details.html" class="td_card_thumb d-block">
                                    <img src="{{ asset('assets/img/home_1/campur_life_3.jpg') }}" alt=""
                                        class="w-100">
                                </a>
                                <div class="td_card_info">
                                    <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                        <a href="course-details.html">Recreations & Wellness</a>
                                    </h2>
                                    <a href="course-details.html" class="td_card_btn">
                                        <!-- SVG icons qalır -->
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="td_height_50 td_height_lg_30"></div>
                            <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s"
                                data-wow-delay="0.25s">
                                <a href="course-details.html" class="td_card_thumb d-block">
                                    <img src="{{ asset('assets/img/home_1/campur_life_2.jpg') }}" alt=""
                                        class="w-100">
                                </a>
                                <div class="td_card_info">
                                    <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                        <a href="course-details.html">Arts & Cultural Program</a>
                                    </h2>
                                    <a href="course-details.html" class="td_card_btn">
                                        <!-- SVG icons qalır -->
                                    </a>
                                </div>
                            </div>

                            <div class="td_height_40 td_height_lg_30"></div>

                            <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s"
                                data-wow-delay="0.3s">
                                <a href="course-details.html" class="td_card_thumb d-block">
                                    <img src="{{ asset('assets/img/home_1/campur_life_4.jpg') }}" alt=""
                                        class="w-100">
                                </a>
                                <div class="td_card_info">
                                    <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                        <a href="course-details.html">Sports & Fitness</a>
                                    </h2>
                                    <a href="course-details.html" class="td_card_btn">
                                        <!-- SVG icons qalır -->
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="td_height_112 td_height_lg_75"></div>
    </section>
    <!-- End Campus Life -->


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

                <div class="row td_gap_y_30">
                    <!-- FEATURED -->
                    <div class="col-lg-6">
                        <div class="td_card td_style_1 td_radius_5">
                            <a href="{{ route('resources-details', $hero->id) }}"
                                class="td_card_thumb td_mb_30 d-block res-thumb"
                                style="display:flex;align-items:center;justify-content:center;background:#0b1324;aspect-ratio:16/9;border-radius:8px;overflow:hidden;"
                                data-src="{{ $hero->resourceUrl }}" data-mime="{{ $hero->mime ?? '' }}">
                                {{-- IMG default (icon və ya real şəkil) --}}
                                <img class="res-thumb-img" alt="Resource"
                                    src="{{ resIsImage($hero->resourceUrl ?: $hero->mime) ? $hero->resourceUrl : resIcon($hero->mime) }}"
                                    style="max-width:100%;max-height:100%;object-fit:contain;display:block;">
                                {{-- Canvas (PDF/video üçün) --}}
                                <canvas class="res-thumb-canvas"
                                    style="display:none;width:100%;height:100%;"></canvas>
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
                                        <a href="{{ route('resources-details', $hero->id) }}">{{ $hero->name }}</a>
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
                                    class="td_card_thumb d-block res-thumb"
                                    style="display:flex;align-items:center;justify-content:center;background:#0b1324;aspect-ratio:16/9;border-radius:8px;overflow:hidden;"
                                    data-src="{{ $res->resourceUrl }}" data-mime="{{ $res->mime ?? '' }}">
                                    <img class="res-thumb-img" alt="Resource"
                                        src="{{ resIsImage($res->resourceUrl ?: $res->mime) ? $res->resourceUrl : resIcon($res->mime) }}"
                                        style="max-width:100%;max-height:100%;object-fit:contain;display:block;">
                                    <canvas class="res-thumb-canvas"
                                        style="display:none;width:100%;height:100%;"></canvas>
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


    <!-- Start Video Section -->
    <section>
        <div class="td_video_block td_style_1 td_accent_bg td_bg_filed td_center text-center"
            data-src="{{ asset('assets/img/home_1/video_bg.jpg') }}">
            <div class="container">
                <a href="https://www.youtube.com/embed/rRid6GCJtgc"
                    class="td_player_btn_wrap_2 td_video_open wow zoomIn" data-wow-duration="1s"
                    data-wow-delay="0.2s">
                    <span class="td_player_btn td_center">
                        <span></span>
                    </span>
                </a>
                <div class="td_height_70 td_height_lg_50"></div>
                <h2 class="td_fs_48 td_white_color mb-0 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    Take a Video Tour to Learn <br>Intro of Campus
                </h2>
            </div>
        </div>

        <div class="container wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
            <div class="td_contact_box td_style_1 td_accent_bg td_radius_10">
                <div class="td_contact_box_left">
                    <p class="td_fs_18 td_light td_white_color td_mb_4">Get In Touch:</p>
                    <h3 class="td_fs_36 mb-0 td_white_color">
                        <a href="mailto:info@eduon.com">info@eduon.com</a>
                    </h3>
                </div>

                <div
                    class="td_contact_box_or td_fs_24 td_medium td_white_bg td_white_bg td_center rounded-circle td_accent_color">
                    or
                </div>

                <div class="td_contact_box_right">
                    <p class="td_fs_18 td_light td_white_color td_mb_4">Get In Touch:</p>
                    <h3 class="td_fs_36 mb-0 td_white_color">
                        <a href="tel:+019987698870">+01 998 7698 870</a>
                    </h3>
                </div>
            </div>
        </div>
    </section>
    <!-- End Video Section -->


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


    <!-- Start Footer Section -->
    <footer class="td_footer td_style_1">
        <div class="container">
            <div class="td_footer_row">
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <div class="td_footer_text_widget td_fs_18">
                            <svg width="241" height="64" viewBox="0 0 241 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M77.6 50V15.92H99.2V23.216H85.232V29.312H96.32V36.608H85.232V42.704H99.2V50H77.6ZM113.297 50.528C110.193 50.528 107.553 49.296 105.377 46.832C103.233 44.368 102.161 41.424 102.161 38C102.161 34.576 103.233 31.632 105.377 29.168C107.553 26.704 110.193 25.472 113.297 25.472C116.049 25.472 118.225 26.448 119.825 28.4V14H127.073V50H119.825V47.6C118.225 49.552 116.049 50.528 113.297 50.528ZM110.945 42.272C111.969 43.392 113.297 43.952 114.929 43.952C116.561 43.952 117.873 43.392 118.865 42.272C119.889 41.152 120.401 39.728 120.401 38C120.401 36.272 119.889 34.848 118.865 33.728C117.873 32.608 116.561 32.048 114.929 32.048C113.297 32.048 111.969 32.608 110.945 33.728C109.953 34.848 109.457 36.272 109.457 38C109.457 39.728 109.953 41.152 110.945 42.272ZM141.823 50.528C138.911 50.528 136.671 49.552 135.103 47.6C133.535 45.648 132.751 43.008 132.751 39.68V26H139.999V38.432C139.999 42.112 141.231 43.952 143.695 43.952C146.703 43.952 148.207 41.856 148.207 37.664V26H155.455V50H148.207V47.552C146.831 49.536 144.703 50.528 141.823 50.528ZM172.582 50.528C168.966 50.528 165.958 49.328 163.558 46.928C161.158 44.496 159.958 41.52 159.958 38C159.958 34.48 161.158 31.52 163.558 29.12C165.958 26.688 168.966 25.472 172.582 25.472C175.878 25.472 178.598 26.384 180.742 28.208C182.886 30.032 184.294 32.416 184.966 35.36H177.478C176.422 33.12 174.79 32 172.582 32C171.014 32 169.734 32.544 168.742 33.632C167.75 34.688 167.254 36.144 167.254 38C167.254 39.856 167.75 41.328 168.742 42.416C169.734 43.472 171.014 44 172.582 44C174.79 44 176.422 42.88 177.478 40.64H184.966C184.294 43.584 182.886 45.968 180.742 47.792C178.598 49.616 175.878 50.528 172.582 50.528ZM196.027 50L185.514 26H193.531L199.339 40.592L205.195 26H213.259L202.747 50H196.027ZM226.631 50.528C222.919 50.528 219.863 49.344 217.463 46.976C215.095 44.608 213.911 41.6 213.911 37.952C213.911 34.368 215.111 31.392 217.511 29.024C219.943 26.656 222.983 25.472 226.631 25.472C228.391 25.472 230.039 25.776 231.575 26.384C233.143 26.992 234.519 27.872 235.703 29.024C236.919 30.176 237.863 31.664 238.535 33.488C239.207 35.312 239.511 37.376 239.447 39.68H220.967C221.095 40.992 221.671 42.096 222.695 42.992C223.719 43.856 225.159 44.288 227.015 44.288C228.071 44.288 229.031 44.08 229.895 43.664C230.759 43.216 231.335 42.672 231.623 42.032H239.207C238.439 44.56 236.903 46.608 234.599 48.176C232.295 49.744 229.639 50.528 226.631 50.528ZM226.439 31.232C225.063 31.232 223.911 31.584 222.983 32.288C222.087 32.992 221.479 33.92 221.159 35.072H231.431C231.079 33.76 230.423 32.8 229.463 32.192C228.535 31.552 227.527 31.232 226.439 31.232Z"
                                    fill="white" />
                                <circle cx="32" cy="32" r="32" fill="currentColor" />
                                <g clip-path="url(#clip0_34_2577)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M22.6467 30.6328C23.4232 32.1737 24.1977 33.7161 24.9399 35.2737L26.6086 38.7762C25.1372 38.8256 23.6642 38.8377 22.1948 38.9243C21.6339 38.9574 21.0762 39.0402 20.5225 39.1349C19.7311 39.2703 18.9108 39.4904 18.1533 39.8018C17.1649 40.2082 15.8001 41.1065 15.8288 42.3478C15.8525 43.5661 16.7204 44.4356 17.5569 45.214C18.295 45.9009 19.3666 46.3799 20.2767 46.829C22.1427 47.7497 24.0947 48.5327 26.0432 49.2601C27.3919 49.7637 28.7457 50.152 30.1545 50.4492C30.8123 50.588 31.8614 50.6214 32.196 49.8762C32.4385 49.3306 32.2448 48.723 32.0288 48.2041C31.7527 47.5411 31.4573 46.8842 31.1623 46.2293L29.9514 43.5409C31.8143 43.5741 33.6772 43.6321 35.5405 43.6403C37.0245 43.6473 38.492 43.5623 39.9611 43.3505C41.3406 43.1514 42.982 42.5701 43.7014 41.2806C44.5503 39.759 43.7156 37.8291 42.9012 36.4768C42.5267 35.8548 42.2005 35.2005 41.7772 34.6105L38.9251 30.6352C39.4314 29.9172 39.9592 29.2136 40.4444 28.4806C41.1643 27.3931 41.8721 26.2964 42.5393 25.1753C43.0034 24.3951 43.4349 23.5944 43.8364 22.7802C44.6028 21.227 45.9017 18.6739 44.3166 17.1807C43.3493 16.2696 41.8301 16.2005 40.5805 16.3771C39.2698 16.5623 37.9618 16.7719 36.6596 17.0101C33.2584 17.6323 29.8459 18.7565 26.5277 19.7733C25.3415 20.1369 24.1843 20.59 23.0204 21.0186C22.2364 21.3073 21.4657 21.7203 20.7201 22.1218C20.2743 22.3617 19.8305 22.7021 19.5624 23.1386C19.4029 23.3981 19.4537 23.7786 19.5075 24.0627C19.6125 24.6169 19.8473 25.1374 20.0804 25.6471L22.6467 30.6328ZM34.1923 21.8787C35.4104 21.6447 36.6291 21.4134 37.851 21.2003C38.2375 21.1329 39.2023 20.9037 39.4235 21.3667C39.7333 22.0164 38.8852 23.1216 38.588 23.6636C38.3336 24.1274 38.0638 24.5828 37.8003 25.0412L36.3977 27.4828L34.259 25.0955L32.1535 23.0235L31.6079 22.5726L31.4239 22.4352C32.3466 22.2497 33.2679 22.0563 34.1923 21.8787ZM30.3678 23.9286C30.3923 23.9266 30.416 23.9498 30.431 23.9678L30.502 24.0564C30.6367 24.2571 30.7593 24.4628 30.8862 24.6683C31.4529 25.587 32.0193 26.5064 32.5866 27.4247C32.9624 28.033 33.3402 28.6404 33.716 29.249L34.4583 30.452L34.5228 30.5609C33.9876 31.4412 33.4659 32.3297 32.9171 33.2016C32.4888 33.8825 32.0392 34.5504 31.5919 35.2191C31.3991 35.5063 31.0907 35.909 30.6959 35.8606C29.9319 35.7668 29.6828 34.5705 29.5983 33.9609C29.553 33.6343 29.5124 33.3065 29.4891 32.9776C29.4469 32.3837 29.3874 31.7885 29.4018 31.1931C29.4217 30.373 29.4267 29.5525 29.4613 28.7329C29.482 28.2432 29.4955 27.7511 29.5676 27.2662C29.6667 26.597 29.7658 25.9277 29.865 25.2585C29.9072 24.9737 29.9975 24.6963 30.0825 24.4217C30.1274 24.303 30.1759 24.1885 30.2311 24.0743C30.2311 24.0743 30.303 23.9342 30.3678 23.9286ZM29.2522 44.7164C29.6387 45.656 30.0424 46.6163 30.3025 47.6104C30.336 47.738 30.36 47.8683 30.3772 47.999C30.3914 48.1061 30.3932 48.2148 30.3966 48.3227C30.3981 48.3523 30.3552 48.3819 30.3293 48.3854C30.2757 48.3927 30.2218 48.3621 30.1777 48.3352C29.0438 47.6565 27.9137 46.9704 26.7775 46.2957L22.3376 43.6601L22.2007 43.575L22.3069 43.5529L22.7368 43.5057C23.5683 43.4846 24.3994 43.4267 25.2309 43.4419L28.7526 43.506C28.9192 43.9094 29.0861 44.3126 29.2522 44.7164ZM38.3328 38.7185C38.155 38.8744 37.8726 38.9159 37.6461 38.9449C37.3576 38.9816 37.0676 39.0237 36.7769 39.0244C35.7736 39.0266 34.7701 39.0455 33.767 39.0308C33.076 39.0208 32.3855 38.9803 31.6952 38.9503L27.679 38.7765C27.446 38.2763 27.2132 37.7756 26.9796 37.2758L23.9918 30.8852C23.3381 29.4126 22.6689 27.9466 22.0305 26.4673C21.9103 26.1884 21.817 25.8985 21.7166 25.612C21.6161 25.325 21.4774 24.9322 21.6278 24.6365C21.7596 24.3816 22.0707 24.2704 22.3278 24.1902C22.4603 24.1489 22.5959 24.1162 22.7325 24.0906C23.8484 23.8808 24.9674 23.6881 26.0844 23.4837L29.097 22.9322L28.9769 23.2791L28.8321 23.9369L28.8247 23.9784C28.7219 25.1082 28.5788 26.2347 28.5158 27.3673C28.4436 28.6689 28.4308 29.9736 28.4194 31.2771C28.4141 31.8879 28.4278 32.4996 28.4655 33.1091C28.4987 33.6399 28.5449 34.172 28.6321 34.6968C28.7086 35.1584 28.8262 35.6134 28.9558 36.0632C29.1479 36.7303 29.508 37.3886 30.0841 37.7974C30.2823 37.9381 30.5074 38.042 30.7448 38.0951C31.4956 38.2637 32.2895 37.8845 32.8773 37.4467C33.5009 36.9823 34.1725 36.4527 34.6953 35.854L36.4612 33.831C36.8088 34.4374 37.184 35.0291 37.5042 35.6504C37.8173 36.2572 38.0804 36.8887 38.3591 37.5122C38.501 37.8298 38.6388 38.347 38.3934 38.655C38.3753 38.678 38.3549 38.6991 38.3328 38.7185Z"
                                        fill="white" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_34_2577">
                                        <rect width="38.4" height="38.4" fill="white"
                                            transform="translate(27.25 5.11719) rotate(35.1898)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <p>Far far away, behind the word mountains, far from the Consonantia, there live the blind
                                texts.</p>
                        </div>
                        <ul class="td_footer_address_widget td_medium td_mp_0">
                            <li><i class="fa-solid fa-phone-volume"></i><a href="cal:+23(000)68603">+23 (000) 68
                                    603</a>
                            </li>
                            <li><i class="fa-solid fa-location-dot"></i>66 broklyn golden street <br>600 New york. USA
                            </li>
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
                            <a href="#" class="td_center">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="td_center">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                            <a href="#" class="td_center">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="#" class="td_center">
                                <i class="fa-brands fa-pinterest-p"></i>
                            </a>
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
