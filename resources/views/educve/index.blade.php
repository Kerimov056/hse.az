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
    <!-- Start About Section -->
    <section>
        <div class="td_height_120 td_height_lg_80"></div>
        <div class="td_about td_style_1">
            <div class="container">
                <div class="row align-items-center td_gap_y_40">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.25s">
                        <div class="td_about_thumb_wrap">
                            <div class="td_about_year text-uppercase td_fs_64 td_bold">EST 1995</div>
                            <div class="td_about_thumb_1">
                                <img src="{{ asset('assets/img/home_1/about_img_1.jpg') }}" alt="">
                            </div>
                            <div class="td_about_thumb_2">
                                <img src="{{ asset('assets/img/home_1/about_img_2.jpg') }}" alt="">
                            </div>
                            <a href="https://www.youtube.com/embed/rRid6GCJtgc"
                                class="td_circle_text td_center td_video_open">
                                <svg width="15" height="19" viewBox="0 0 15 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.086 8.63792C14.6603 9.03557 14.6603 9.88459 14.086 10.2822L2.54766 18.2711C1.88444 18.7303 0.978418 18.2557 0.978418 17.449L0.978418 1.47118C0.978418 0.664496 1.88444 0.189811 2.54767 0.649016L14.086 8.63792Z"
                                        fill="white" />
                                </svg>
                                <img src="{{ asset('assets/img/home_1/about_circle_text.svg') }}" alt=""
                                    class="">
                            </a>

                            <div class="td_circle_shape"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                        <div class="td_section_heading td_style_1 td_mb_30">
                            <p
                                class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                                About us</p>
                            <h2 class="td_section_title td_fs_48 mb-0">The largest & Most Diverse Universities in the
                                United Emirates</h2>
                            <p class="td_section_subtitle td_fs_18 mb-0">Far far away, behind the word mountains, far
                                from the Consonantia, there live the blind texts. Separated they marks grove right at
                                the coast of the Semantics a large language ocean</p>
                        </div>
                        <div class="td_mb_40">
                            <ul class="td_list td_style_5 td_mp_0">
                                <li>
                                    <h3 class="td_fs_24 td_mb_8">Graduate Program</h3>
                                    <p class="td_fs_18 mb-0">Browse the Undergraduate Degrees</p>
                                </li>
                                <li>
                                    <h3 class="td_fs_24 td_mb_8">Undergraduate Program</h3>
                                    <p class="td_fs_18 mb-0">Browse the Undergraduate Degrees</p>
                                </li>
                            </ul>
                        </div>
                        <a href="courses-grid-view.html" class="td_btn td_style_1 td_radius_10 td_medium">
                            <span class="td_btn_in td_white_color td_accent_bg">
                                <span>More About</span>
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
    <!-- End About Section -->
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
                    <li class="active"><a href="#tab_1">Undergraduate</a></li>
                    <li><a href="#tab_2">Graduate</a></li>
                    <li><a href="#tab_3">Online</a></li>
                    <li><a href="#tab_4">Short Course</a></li>
                </ul>
                <div class="td_height_50 td_height_lg_50"></div>
                <div class="td_tab_body">
                    <div class="td_tab active" id="tab_1">
                        <div class="row td_gap_y_24">
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_1.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">150 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                <span>Data Analytics</span>
                                            </a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16">
                                                <a href="course-details.html">Starting Reputed Education & Build your
                                                    Skills</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                Far far away, behind the word mountains, far from the Consonantia.
                                            </p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4.5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/5
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s"
                                data-wow-delay="0.25s">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_2.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">100 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">20 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                <span>Software Engeneer</span>
                                            </a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16">
                                                <a href="course-details.html">Master Technology & Elevate Your
                                                    Career</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                Unlock the power of technology to drive your career forward.
                                            </p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/10
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_3.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">300 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">8 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                <span>Bachelor Of Arts</span>
                                            </a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16">
                                                <a href="course-details.html">Boost Creativity & Expand Your
                                                    Horizons</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                Discover innovative techniques to enhance your creative thinking.
                                            </p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/12
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_4.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">250 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                <span>Business Administrator</span>
                                            </a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16">
                                                <a href="course-details.html">Hone Leadership & Achieve Success</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                Develop essential leadership skills to excel in any industry.
                                            </p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/30
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s"
                                data-wow-delay="0.25s">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_5.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">80 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                <span>Fine of Arts</span>
                                            </a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16">
                                                <a href="course-details.html">Learn Coding & Advance Your Skills Up</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                Gain in-demand coding expertise to stay ahead in the tech world.
                                            </p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4.5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/5
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_6.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">200 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                                <span>Computer Science</span>
                                            </a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16">
                                                <a href="course-details.html">Explore Marketing & Build Your Brand</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                Master marketing strategies to grow your personal or business brand.
                                            </p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4.5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/15
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>



                    <div class="td_tab" id="tab_2">
                        <div class="row td_gap_y_24">
                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_3.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">300 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">8 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Bachelor
                                                    Of Arts</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Boost Creativity & Expand Your
                                                    Horizons</a></h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Discover
                                                innovative techniques to enhance your creative thinking.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/12
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_4.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">250 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Business
                                                    Administrator</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Hone Leadership & Achieve Success</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Develop
                                                essential leadership skills to excel in any industry.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/30
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_1.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">150 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Data
                                                    Analytics</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Starting Reputed Education & Build your
                                                    Skills</a></h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Far far
                                                away, behind the word mountains, far from the Consonantia.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4.5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/5
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- digər kartlar da eyni qayda ilə: asset('assets/img/...') -->
                        </div>
                    </div>





                    <div class="td_tab" id="tab_3">
                        <div class="row td_gap_y_24">
                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_4.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">250 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Business
                                                    Administrator</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Hone Leadership & Achieve Success</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Develop
                                                essential leadership skills to excel in any industry.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/30
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_5.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">80 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Fine
                                                    of Arts</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Learn Coding & Advance Your Skills
                                                    Up</a></h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Gain
                                                in-demand coding expertise to stay ahead in the tech world.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4.5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/5
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_6.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">200 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Computer
                                                    Science</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Explore Marketing & Build Your Brand</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Master
                                                marketing strategies to grow your personal or business brand.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4.5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/15
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="td_tab" id="tab_4">
                        <div class="row td_gap_y_24">
                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_6.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">200 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Computer
                                                    Science</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Explore Marketing & Build Your Brand</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Master
                                                marketing strategies to grow your personal or business brand.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4.5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/15
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_4.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">250 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Business
                                                    Administrator</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Hone Leadership & Achieve Success</a>
                                            </h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Develop
                                                essential leadership skills to excel in any industry.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/30
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="td_card td_style_3 d-block td_radius_10">
                                    <a href="course-details.html" class="td_card_thumb">
                                        <img src="{{ asset('assets/img/home_1/course_thumb_1.jpg') }}"
                                            alt="">
                                    </a>
                                    <div class="td_card_info td_white_bg">
                                        <div class="td_card_info_in">
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/user_3.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">150 Seats</span>
                                                </li>
                                                <li>
                                                    <img src="{{ asset('assets/img/icons/book.svg') }}"
                                                        alt="">
                                                    <span class="td_opacity_7">12 Semesters</span>
                                                </li>
                                            </ul>
                                            <a href="courses-grid-with-sidebar.html"
                                                class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>Data
                                                    Analytics</span></a>
                                            <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                    href="course-details.html">Starting Reputed Education & Build your
                                                    Skills</a></h2>
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">Far far
                                                away, behind the word mountains, far from the Consonantia.</p>
                                            <div class="td_card_review">
                                                <div class="td_rating" data-rating="4.5">
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <i class="fa-regular fa-star"></i>
                                                    <div class="td_rating_percentage">
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                        <i class="fa-solid fa-star fa-fw"></i>
                                                    </div>
                                                </div>
                                                <span class="td_heading_color td_opacity_5 td_medium">(5.0/5
                                                    Ratings)</span>
                                            </div>
                                            <div class="td_card_btn">
                                                <a href="cart.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span>Enroll Now</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Popular Courses -->
    <!-- Start Feature Section -->


    <section>
        <div class="td_height_120 td_height_lg_80"></div>
        <div class="container">
            <div class="td_features td_style_1 td_hobble">
                <div class="td_features_thumb">
                    <img src="{{ asset('assets/img/home_1/feature_img.jpg') }}" alt=""
                        class="td_radius_10 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                </div>
                <div class="td_features_content td_white_bg td_radius_10 wow fadeInRight" data-wow-duration="1s"
                    data-wow-delay="0.25s">
                    <div class="td_section_heading td_style_1">
                        <p
                            class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                            CAMPUS</p>
                        <h2 class="td_section_title td_fs_48 mb-0">Campus is your Dream Lifestyle</h2>
                    </div>
                    <div class="td_height_50 td_height_lg_50"></div>
                    <ul class="td_feature_list td_mp_0">
                        <li>
                            <div class="td_feature_icon td_center">
                                <!-- SVGs qalır, dəyişməyə ehtiyac yoxdur -->
                                ...
                            </div>
                            <div class="td_feature_info">
                                <h3 class="td_fs_32 td_semibold td_mb_15">Smart Hostel</h3>
                                <p class="td_fs_14 td_heading_color td_opacity_7 mb-0">Behind the word mountains, far
                                    from the Conso there live the blind texts</p>
                            </div>
                        </li>
                        <!-- digər li-lər də eyni qalır -->
                    </ul>
                </div>

                <!-- SVG şəkil formaları (shape-lər) -->
                <div class="td_features_shape_1 position-absolute td_accent_color td_hover_layer_3">
                    <svg width="482" height="769" viewBox="0 0 482 769" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        ...
                    </svg>
                </div>
                <div class="td_features_shape_2 position-absolute td_accent_color td_hover_layer_5">
                    <svg width="576" height="726" viewBox="0 0 576 726" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        ...
                    </svg>
                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>


    <!-- End Feature Section -->
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
    <!-- Start Departments Section -->
    <section>
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    Event schedule</p>
                <h2 class="td_section_title td_fs_48 mb-0">Upcoming Event Conference 2024 <br>Host by Educve</h2>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>
            <div class="row td_gap_y_30">

                <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_card td_style_1 td_radius_5">
                        <a href="event-details.html" class="td_card_thumb td_mb_30 d-block">
                            <img src="{{ asset('assets/img/home_1/event_thumb_1.jpg') }}" alt="">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span class="td_card_location td_medium td_white_color td_fs_18">
                                <svg width="16" height="22" viewBox="0 0 16 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.0004 0.5C3.86669 0.5 0.554996 3.86526 0.500458 7.98242C0.48345 9.42271 0.942105 10.7046 1.56397 11.8232C2.76977 13.9928 4.04435 16.8182 5.32856 19.4639C5.9286 20.7002 6.89863 21.5052 8.0004 21.5C9.10217 21.4948 10.0665 20.6836 10.6575 19.4404C11.9197 16.7856 13.1685 13.9496 14.4223 11.835C15.1136 10.6691 15.4653 9.3606 15.4974 8.01758C15.5966 3.86772 12.1342 0.5 8.0004 0.5Z"
                                        fill="currentColor" />
                                </svg>
                                Tsc Center, Northern Asia
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
                                                <path d="M17.3308 11.7869H19.0049..." fill="currentColor" />
                                            </svg>
                                            <span>Jan 23 , 2024</span>
                                        </li>
                                        <li>
                                            <svg class="td_accent_color" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 24C18.616 24..." fill="currentColor" />
                                            </svg>
                                            <span>10.00 am - 11.30 am</span>
                                        </li>
                                    </ul>
                                </div>
                                <h2 class="td_card_title td_fs_32 td_semibold td_mb_20">
                                    <a href="event-details.html">Innovate 2024: BBA Admission Conference</a>
                                </h2>
                                <p class="td_mb_30 td_fs_18">
                                    Education is a dynamic and evolving field that plays a crucial role in shaping
                                    individuals and societies...
                                </p>
                                <a href="event-details.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg">
                                        <span>Learn More</span>
                                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 td_gap_y_30 flex-wrap d-flex wow fadeInRight" data-wow-duration="1s"
                    data-wow-delay="0.3s">
                    <div class="td_card td_style_1 td_type_1">
                        <a href="event-details.html" class="td_card_thumb d-block">
                            <img src="{{ asset('assets/img/home_1/event_thumb_2.jpg') }}" alt="">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                        ...
                    </div>

                    <div class="td_card td_style_1 td_type_1">
                        <a href="event-details.html" class="td_card_thumb d-block">
                            <img src="{{ asset('assets/img/home_1/event_thumb_3.jpg') }}" alt="">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                        ...
                    </div>

                    <div class="td_card td_style_1 td_type_1">
                        <a href="event-details.html" class="td_card_thumb d-block">
                            <img src="{{ asset('assets/img/home_1/event_thumb_4.jpg') }}" alt="">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                        ...
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>



    <!-- End Departments Section -->
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
                <h2 class="td_fs_48 td_white_color mb-0 wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay="0.2s">
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
    <!-- Start Event Schedule Section -->
    <section>
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    Event schedule</p>
                <h2 class="td_section_title td_fs_48 mb-0">Upcoming Event Conference 2024 <br>Host by Educve</h2>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>
            <div class="row td_gap_y_30">
                <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_card td_style_1 td_radius_5">
                        <a href="event-details.html" class="td_card_thumb td_mb_30 d-block">
                            <img src="{{ asset('assets/img/home_1/event_thumb_1.jpg') }}" alt="">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span class="td_card_location td_medium td_white_color td_fs_18">
                                <svg width="16" height="22" viewBox="0 0 16 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.0004 0.5C3.86669 0.5..." fill="currentColor" />
                                </svg>
                                Tsc Center, Northern Asia
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
                                                <path d="M17.3308 11.7869H19.0049..." fill="currentColor" />
                                            </svg>
                                            <span>Jan 23 , 2024</span>
                                        </li>
                                        <li>
                                            <svg class="td_accent_color" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 24C18.616 24..." fill="currentColor" />
                                            </svg>
                                            <span>10.00 am - 11.30 am</span>
                                        </li>
                                    </ul>
                                </div>
                                <h2 class="td_card_title td_fs_32 td_semibold td_mb_20">
                                    <a href="event-details.html">Innovate 2024: BBA Admission Conference</a>
                                </h2>
                                <p class="td_mb_30 td_fs_18">
                                    Education is a dynamic and evolving field that plays a crucial role in shaping
                                    individuals and societies.
                                </p>
                                <a href="event-details.html" class="td_btn td_style_1 td_radius_10 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg">
                                        <span>Learn More</span>
                                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 td_gap_y_30 flex-wrap d-flex wow fadeInRight" data-wow-duration="1s"
                    data-wow-delay="0.3s">
                    <div class="td_card td_style_1 td_type_1">
                        <a href="event-details.html" class="td_card_thumb d-block">
                            <img src="{{ asset('assets/img/home_1/event_thumb_2.jpg') }}" alt="">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                        ...
                    </div>

                    <div class="td_card td_style_1 td_type_1">
                        <a href="event-details.html" class="td_card_thumb d-block">
                            <img src="{{ asset('assets/img/home_1/event_thumb_3.jpg') }}" alt="">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                        ...
                    </div>

                    <div class="td_card td_style_1 td_type_1">
                        <a href="event-details.html" class="td_card_thumb d-block">
                            <img src="{{ asset('assets/img/home_1/event_thumb_4.jpg') }}" alt="">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                        ...
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>

    <!-- End Event Schedule Section -->
    <!-- Start Testimonial Section -->
    <section class="td_heading_bg td_hobble">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <h2 class="td_section_title td_fs_48 mb-0 td_white_color">Start your journey With Us</h2>
                <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
                    Education is a dynamic and evolving field that plays a crucial <br>
                    role in shaping individuals and societies. While significant <br>
                    challenges,
                </p>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>

            <div class="row align-items-center td_gap_y_40">
                <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_testimonial_img_wrap">
                        <img src="{{ asset('assets/img/home_1/testimonial_img.png') }}" alt=""
                            class="td_testimonial_img">
                        <span class="td_testimonial_img_shape_1"><span></span></span>
                        <span class="td_testimonial_img_shape_2 td_accent_color td_hover_layer_3">
                            <svg width="145" height="165" viewBox="0 0 145 165" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M145.003 25.9077L139.516 27.7024L143.814 31.5573L145.003 25.9077Z..."
                                    fill="white" />
                                <circle cx="34" cy="150" r="15" fill="currentColor" />
                                <circle cx="15" cy="137" r="15" fill="currentColor" />
                                <circle cx="24" cy="144" r="15" fill="white" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_slider td_style_1">
                        <div class="td_slider_container" data-autoplay="0" data-loop="1" data-speed="800"
                            data-center="0" data-variable-width="0" data-slides-per-view="1">
                            <div class="td_slider_wrapper">

                                <!-- Slide 1 -->
                                <div class="td_slide">
                                    <div class="td_testimonial td_style_1 td_white_bg td_radius_5">
                                        <span class="td_quote_icon td_accent_color">
                                            <svg width="65" height="46" viewBox="0 0 65 46"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.05"
                                                    d="M13.9286 26.6H1V1H26.8571V27.362L17.956 45H6.26764..."
                                                    fill="currentColor" stroke="currentColor" stroke-width="2" />
                                            </svg>
                                        </span>
                                        <div class="td_testimonial_meta td_mb_24">
                                            <img src="{{ asset('assets/img/home_1/avatar_1.png') }}"
                                                alt="">
                                            <div class="td_testimonial_meta_right">
                                                <h3 class="td_fs_24 td_semibold td_mb_2">Marvin McKinney</h3>
                                                <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">15th Batch
                                                    Students</p>
                                            </div>
                                        </div>
                                        <blockquote
                                            class="td_testimonial_text td_fs_20 td_medium td_heading_color td_mb_24 td_opacity_9">
                                            The pandemic has accelerated the shift to online and hybrid learning models.
                                            Platforms like Coursera, edX, and university-specific online programs offer
                                            flexibility and accessibility to a wider audience.
                                        </blockquote>
                                        <div class="td_rating" data-rating="5">
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <div class="td_rating_percentage">
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Slide 2 -->
                                <div class="td_slide">
                                    <div class="td_testimonial td_style_1 td_white_bg td_radius_5">
                                        <span class="td_quote_icon td_accent_color">
                                            <svg width="65" height="46" viewBox="0 0 65 46"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.05"
                                                    d="M13.9286 26.6H1V1H26.8571V27.362L17.956 45H6.26764..."
                                                    fill="currentColor" stroke="currentColor" stroke-width="2" />
                                            </svg>
                                        </span>
                                        <div class="td_testimonial_meta td_mb_24">
                                            <img src="{{ asset('assets/img/home_2/avatar_2.png') }}"
                                                alt="">
                                            <div class="td_testimonial_meta_right">
                                                <h3 class="td_fs_24 td_semibold td_mb_2">Marry Kristano</h3>
                                                <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">13th Batch
                                                    Students</p>
                                            </div>
                                        </div>
                                        <blockquote
                                            class="td_testimonial_text td_fs_20 td_medium td_heading_color td_mb_24 td_opacity_9">
                                            The pandemic has accelerated the shift to online and hybrid learning models.
                                            Platforms like Coursera, edX, and university-specific online programs offer
                                            flexibility and accessibility to a wider audience.
                                        </blockquote>
                                        <div class="td_rating" data-rating="4.5">
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <div class="td_rating_percentage">
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- /.td_slider_wrapper -->
                        </div> <!-- /.td_slider_container -->
                    </div> <!-- /.td_slider -->
                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>

    <!-- End Testimonial Section -->
    <!-- Start Blog Section -->
    <section>
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    BLOG & ARTICLES</p>
                <h2 class="td_section_title td_fs_48 mb-0">Take A Look At The Latest <br>Articles</h2>
            </div>

            <div class="td_height_50 td_height_lg_50"></div>
            <div class="row td_gap_y_30">

                <!-- Blog 1 -->
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_post td_style_1">
                        <a href="blog-details.html" class="td_post_thumb d-block">
                            <img src="{{ asset('assets/img/home_1/post_1.jpg') }}" alt="">
                            <i class="fa-solid fa-link"></i>
                        </a>
                        <div class="td_post_info">
                            <div class="td_post_meta td_fs_14 td_medium td_mb_20">
                                <span><img src="{{ asset('assets/img/icons/calendar.svg') }}" alt="">Jan
                                    23 , 2024</span>
                                <span><img src="{{ asset('assets/img/icons/user.svg') }}" alt="">Jhon
                                    Doe</span>
                            </div>
                            <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                                <a href="blog-details.html">Comprehensive Student Guide for New Educations System</a>
                            </h2>
                            <p class="td_post_subtitle td_mb_24 td_heading_color td_opacity_7">
                                Education is a dynamic and evolving field that plays a crucial.
                            </p>
                            <a href="blog-details.html" class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                                <span class="td_btn_in td_accent_color">
                                    <span>Read More</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>

    <!-- End Blog Section -->
    <!-- Start Footer Section -->
    <footer class="td_footer td_style_1">
        <div class="container">
            <div class="td_footer_row">

                <!-- Footer Logo və Əlaqə -->
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <div class="td_footer_text_widget td_fs_18">
                            <img src="{{ asset('assets/img/footer_logo.svg') }}" alt="Logo">
                            <p>Far far away, behind the word mountains, far from the Consonantia, there live the blind
                                texts.</p>
                        </div>
                        <ul class="td_footer_address_widget td_medium td_mp_0">
                            <li>
                                <i class="fa-solid fa-phone-volume"></i>
                                <a href="cal:+23(000)68603">+23 (000) 68 603</a>
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                66 broklyn golden street <br>600 New york. USA
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Navigate bölməsi -->
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Navigate</h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="contact.html">Contact</a></li>
                            <li><a href="contact.html">Refund</a></li>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Courses bölməsi -->
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Courses</h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="course-details.html">Business Coach</a></li>
                            <li><a href="course-details.html">Development Coach</a></li>
                            <li><a href="course-details.html">Testimonials</a></li>
                            <li><a href="course-details.html">SEO Optimization</a></li>
                            <li><a href="course-details.html">Web Design</a></li>
                            <li><a href="course-details.html">Life Coach</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Subscribe bölməsi -->
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Subscribe Now
                        </h2>
                        <div class="td_newsletter td_style_1">
                            <p class="td_mb_20 td_opacity_7">
                                Far far away, behind the word mountains, far from the Consonantia.
                            </p>
                            <form action="#" class="td_newsletter_form">
                                <input type="email" class="td_newsletter_input" placeholder="Email address">
                                <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg">
                                        <span>Subscribe</span>
                                    </span>
                                </button>
                            </form>
                        </div>

                        <div class="td_footer_social_btns td_fs_20">
                            <a href="#" class="td_center"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="td_center"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="#" class="td_center"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="td_center"><i class="fa-brands fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="td_footer_bottom td_fs_18">
            <div class="container">
                <div class="td_footer_bottom_in">
                    <p class="td_copyright mb-0">
                        Copyright ©educve | All Right Reserved
                    </p>
                    <ul class="td_footer_widget_menu">
                        <li><a href="#">Terms & Conditions</a></li>
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
