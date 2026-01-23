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

    <header style="font-size: 14px !important"
        class="td_site_header td_style_1 td_type_3 td_sticky_header td_medium td_heading_color">
        <style>
            .container {
                max-width: 100%;
                padding-left: 50px;
                padding-right: 50px;
            }

            .td_top_header_in {
                display: flex;
                align-items: center;
                gap: 16px;
                width: 100%;
            }

            .td_top_header_left {
                flex: 1 1 auto;
                max-width: calc(100% - 220px);
                overflow: hidden;
                white-space: nowrap;
            }

            .typed-text {
                font-weight: 950;
                font-size: 14px;
                color: #fff;
                white-space: pre;
                display: inline-block;
            }

            .td_top_header_right {
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                gap: 12px;
                white-space: nowrap;
            }

            /* MAIN HEADER */
            .td_main_header_in {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .td_header_bar_left {
                display: flex;
                align-items: center;
                gap: 28px;
                flex: 1 1 auto;
                min-width: 0;
            }

            .td_site_branding {
                display: inline-flex;
                align-items: center;
            }

            .td_site_branding img {
                height: 48px;
                width: auto;
                display: block;
            }

            .td_nav {
                flex: 1 1 auto;
            }

            .td_nav_list_wrap {
                overflow: visible;
            }

            .td_nav_list_wrap_in {
                display: block;
            }

            .td_nav_list {
                display: inline-flex;
                align-items: center;
                gap: 20px;
                margin: 0;
                padding: 0;
                list-style: none;
                white-space: nowrap;
            }

            .td_nav_list>li {
                position: relative;
            }

            .td_nav_list>li:first-child {
                margin-left: 24px;
            }

            .td_nav_list>li>a {
                display: inline-block;
                padding: 12px 0px;
            }

            .td_nav_list>li.menu-item-has-children>ul {
                position: absolute;
                top: 100%;
                left: 0;
                background: #fff;
                min-width: 220px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
                padding: 8px 0;
                margin: 0;
                list-style: none;
                display: none;
                z-index: 50;
            }

            .td_nav_list>li.menu-item-has-children:hover>ul {
                display: block;
            }

            .td_nav_list>li.menu-item-has-children>ul>li>a {
                display: block;
                padding: 10px 14px;
            }

            .td_main_header_right {
                display: flex;
                align-items: center;
                flex: 0 0 auto;
            }

            @media (max-width: 1200px) {
                .td_nav_list {
                    gap: 14px;
                }

                .container {
                    padding-left: 24px;
                    padding-right: 24px;
                }
            }

            @media (max-width: 992px) {
                .td_nav {
                    display: none;
                }
            }

            .td_main_header_right {
                display: flex;
                align-items: center;
            }

            .td_language_wrap {
                margin-right: 4px;
            }

            .td_header_social_btns {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .td_social_btn {
                --btn-bg: rgba(15, 23, 42, .06);
                --btn-icon: #0f172a;
                --btn-ring: rgba(15, 23, 42, .25);

                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                border-radius: 999px;
                background: var(--btn-bg);
                color: var(--btn-icon);
                border: 1px solid rgba(15, 23, 42, .06);
                box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
                transition: background .2s ease, color .2s ease, transform .15s ease, box-shadow .2s ease, border-color .2s ease;
            }

            .td_social_btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 18px rgba(15, 23, 42, .10);
                border-color: rgba(15, 23, 42, .10);
            }

            .td_social_btn:focus-visible {
                outline: none;
                box-shadow: 0 0 0 3px var(--btn-ring);
            }

            .td_social_btn--fb:hover {
                background: #1877F2;
                color: #fff;
            }

            .td_social_btn--tw:hover {
                background: #111;
                color: #fff;
            }

            .td_social_btn--ig:hover {
                background: radial-gradient(120% 120% at 0% 100%, #feda75, #d62976 50%, #962fbf 75%, #4f5bd5);
                color: #fff;
            }

            .td_social_btn--li:hover {
                background: #0A66C2;
                color: #fff;
            }

            .td_social_btn--wa:hover {
                background: #25D366;
                color: #fff;
            }

            @media (prefers-color-scheme: dark) {
                .td_social_btn {
                    --btn-bg: rgba(255, 255, 255, .06);
                    --btn-icon: #e5e7eb;
                    --btn-ring: rgba(255, 255, 255, .35);
                    border-color: rgba(255, 255, 255, .08);
                    box-shadow: 0 2px 8px rgba(0, 0, 0, .35);
                }
            }

            @media (prefers-reduced-motion: reduce) {

                .td_social_btn,
                .td_social_btn:hover {
                    transition: none;
                    transform: none;
                }
            }

            .td_circle_btn {
                width: 36px;
                height: 36px;
                border-radius: 999px;
                background: rgba(15, 23, 42, .06);
                border: 1px solid rgba(15, 23, 42, .06);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .td_circle_btn:hover {
                background: rgba(15, 23, 42, .10);
            }

            /* =============== SIDE HEADER =============== */

            .td_side_header {
                position: fixed;
                inset: 0;
                z-index: 999;
                pointer-events: none;
            }

            .td_side_header_backdrop {
                position: absolute;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                opacity: 0;
                transition: opacity .25s ease;
            }

            .td_side_header_panel {
                position: absolute;
                top: 0;
                right: 0;
                width: 360px;
                max-width: 90vw;
                height: 100%;
                background: #0f172a;
                color: #e5e7eb;
                transform: translateX(100%);
                transition: transform .25s ease;
                box-shadow: -12px 0 30px rgba(15, 23, 42, 0.45);
            }

            .td_side_header_in {
                display: flex;
                flex-direction: column;
                height: 100%;
                padding: 20px 18px 18px;
                gap: 18px;
            }

            .td_side_header_head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
            }

            .td_side_header_title {
                font-size: 15px;
                font-weight: 600;
            }

            .td_side_close_btn {
                width: 32px;
                height: 32px;
                border-radius: 999px;
                border: none;
                background: rgba(15, 23, 42, 0.85);
                color: #e5e7eb;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }

            .td_side_header_body {
                flex: 1 1 auto;
                display: flex;
                flex-direction: column;
                gap: 18px;
                overflow-y: auto;
            }

            .td_side_lang_search {
                display: none;
                flex-direction: column;
                gap: 12px;
                padding: 12px;
                border-radius: 14px;
                background: rgba(15, 23, 42, 0.75);
                border: 1px solid rgba(148, 163, 184, 0.35);
            }

            .td_side_lang_block label {
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: .06em;
                color: #94a3b8;
                margin-bottom: 4px;
                display: inline-block;
            }

            .td_side_lang_select_wrap {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 6px 10px;
                border-radius: 999px;
                background: rgba(15, 23, 42, 0.95);
                border: 1px solid rgba(148, 163, 184, 0.6);
            }

            .td_side_lang_select_wrap img {
                width: 22px;
                height: 22px;
                border-radius: 999px;
                object-fit: cover;
                flex-shrink: 0;
            }

            .td_side_lang_select_wrap select {
                flex: 1 1 auto;
                border: none;
                outline: none;
                background: transparent;
                color: #e5e7eb;
                font-size: 13px;
                font-weight: 500;
                padding: 3px 0;
                cursor: pointer;
            }

            .td_side_search_block {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .td_side_search_block label {
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: .06em;
                color: #94a3b8;
            }

            .td_side_search_form {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 6px 8px;
                border-radius: 999px;
                background: #020617;
                border: 1px solid rgba(148, 163, 184, 0.6);
            }

            .td_side_search_form input {
                flex: 1 1 auto;
                border: none;
                outline: none;
                background: transparent;
                color: #e5e7eb;
                font-size: 13px;
            }

            .td_side_search_form button {
                width: 28px;
                height: 28px;
                border-radius: 999px;
                border: none;
                background: #e5e7eb;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }

            .td_side_search_form button img {
                width: 14px;
                height: 14px;
            }

            .td_side_search_results {
                max-height: 220px;
                overflow-y: auto;
                border-radius: 12px;
                background: #020617;
                border: 1px solid rgba(148, 163, 184, 0.35);
                padding: 6px 0;
                display: none;
            }

            .td_side_search_results .gsearch-item {
                display: flex;
                gap: 8px;
                padding: 8px 10px;
                border-bottom: 1px solid rgba(30, 41, 59, 0.8);
                cursor: pointer;
            }

            .td_side_search_results .gsearch-item:last-child {
                border-bottom: none;
            }

            .td_side_search_results .gsearch-title {
                font-size: 13px;
                font-weight: 500;
                color: #e5e7eb;
            }

            .td_side_search_results .gsearch-meta {
                font-size: 11px;
                color: #94a3b8;
            }

            .td_side_footer {
                padding-top: 6px;
                border-top: 1px solid rgba(148, 163, 184, 0.35);
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .td_side_social_row {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .td_side_legal {
                font-size: 11px;
                color: #94a3b8;
            }

            .td_side_header.is-open {
                pointer-events: auto;
            }

            .td_side_header.is-open .td_side_header_backdrop {
                opacity: 1;
            }

            .td_side_header.is-open .td_side_header_panel {
                transform: translateX(0);
            }

            /* 1199–1724 */
            @media (min-width: 1199px) and (max-width: 1724px) {

                .td_main_header_in,
                .td_header_bar_left,
                .td_main_header_right {
                    align-items: center;
                }

                .td_site_branding img {
                    margin-top: 0;
                }

                .td_main_header_right #globalSearch,
                .td_main_header_right .td_header_social_btns {
                    display: none;
                }

                .td_side_lang_search {
                    display: flex;
                }
            }

            .td_header_social_btns .td_social_btn {
                width: 30px;
                height: 30px;
            }

            .td_header_social_btns .td_social_btn i {
                font-size: 12px;
            }

            @media (min-width: 1199px) and (max-width: 1261px) {
                .td_nav_list {
                    gap: 0px;
                }
            }

            .td_side_head_actions {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .td_side_head_lang {
                display: flex;
                align-items: center;
                gap: 4px;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: .06em;
            }

            .td_side_head_lang a {
                color: #e5e7eb;
                text-decoration: none;
            }

            .td_side_head_lang a.is-active {
                font-weight: 700;
                text-decoration: underline;
            }

            /* inline language dropdown near search (<=1200px) */
            .td_header_lang_inline {
                display: none;
                margin: 0 8px;
            }

            @media (max-width: 1200px) {
                .td_header_lang_inline {
                    display: block;
                }
            }

            @media (prefers-color-scheme: dark) {
                .td_header_lang_inline .td_header_dropdown_btn {
                    color: #e5e7eb;
                }
            }

            /* Mobil */
            @media (max-width: 1200px) {

                .td_nav_list_wrap_in {
                    display: block;
                }

                .td_nav_list {
                    display: block !important;
                    margin: 0;
                    padding: 0;
                    white-space: normal;
                }

                .td_nav_list>li {
                    width: 100%;
                }

                .td_nav_list>li>a {
                    display: block;
                    width: 100%;
                    padding: 12px 0;
                }

                .td_nav_list>li.menu-item-has-children>ul {
                    position: static;
                    background: transparent;
                    box-shadow: none;
                    padding: 4px 0 4px 24px;
                    margin: 0;
                }

                .td_nav_list>li.menu-item-has-children>ul>li>a {
                    display: block;
                    padding: 6px 0;
                    color: #fff;
                    font-size: 14px;
                }
            }

            @media (max-width: 475px) {
                .td_main_header .container-fluid {
                    padding-right: 25px !important;
                    padding-left: 25px !important;
                }
            }

            /* ============================================================
           FIX: Mobile submenu toggle (+ / -) + hover conflict on touch
           ============================================================ */

            .td_submenu_toggle {
                display: none;
                background: transparent;
                border: 0;
                padding: 0;
                cursor: pointer;
                line-height: 1;
                user-select: none;
                margin-right: 10px;
            }

            @media (max-width: 1200px) {
                .td_nav_list>li.menu-item-has-children:hover>ul {
                    display: none !important;
                }

                .td_nav_list>li.menu-item-has-children>ul {
                    display: none !important;
                }

                .td_nav_list>li.menu-item-has-children.is-open>ul {
                    display: block !important;
                }

                .td_nav_list>li.menu-item-has-children {
                    display: flex;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 10px;
                }

                .td_nav_list>li.menu-item-has-children>a {
                    flex: 1 1 auto;
                    order: 1;
                    padding-right: 10px;
                }

                .td_nav_list>li.menu-item-has-children>.td_submenu_toggle {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 34px;
                    height: 34px;
                    border-radius: 999px;
                    background: rgba(255, 255, 255, .08);
                    border: 1px solid rgba(255, 255, 255, .12);
                    color: #fff;
                    order: 2;
                    margin-left: auto;
                }

                .td_nav_list>li.menu-item-has-children>.td_submenu_toggle::before {
                    content: "+";
                    font-size: 20px;
                    font-weight: 700;
                }

                .td_nav_list>li.menu-item-has-children.is-open>.td_submenu_toggle::before {
                    content: "−";
                }

                .td_nav_list>li.menu-item-has-children>ul {
                    width: 100%;
                    order: 3;
                }
            }

            /* Side panel üçün submenu davranışı */
            @media (max-width: 1200px) {
                .td_side_header_panel li.menu-item-has-children:hover>ul {
                    display: none !important;
                }

                .td_side_header_panel li.menu-item-has-children>ul {
                    display: none !important;
                }

                .td_side_header_panel li.menu-item-has-children.is-open>ul {
                    display: block !important;
                }
            }

            /* ============================================================
           REMOVE OLD PLUS: td_munu_dropdown_toggle (non-circle +)
           Theme inject edir, ona gore həm CSS-lə gizlədirik, həm JS-lə silirik.
           ============================================================ */
            @media (max-width: 1200px) {

                /* Köhnə (dairəsiz) + hər yerdə gizlənsin (hansı konteynerdə olmağından asılı deyil) */
                .td_munu_dropdown_toggle,
                span.td_munu_dropdown_toggle {
                    display: none !important;
                    visibility: hidden !important;
                    opacity: 0 !important;
                    pointer-events: none !important;
                }

                .td_munu_dropdown_toggle::before,
                .td_munu_dropdown_toggle::after,
                .td_munu_dropdown_toggle span::before,
                .td_munu_dropdown_toggle span::after {
                    content: none !important;
                    display: none !important;
                }

                /* Bizim dairəli toggle düzgün yerdə dayansın (flex olmayan menyularda da) */
                .td_side_header_panel li.menu-item-has-children,
                .td_side_header li.menu-item-has-children,
                .td_mobile_menu li.menu-item-has-children {
                    position: relative;
                }

                .td_side_header_panel li.menu-item-has-children>a,
                .td_side_header li.menu-item-has-children>a,
                .td_mobile_menu li.menu-item-has-children>a {
                    padding-right: 46px;
                    /* düymə üçün yer */
                }

                .td_side_header_panel li.menu-item-has-children>button.td_submenu_toggle,
                .td_side_header li.menu-item-has-children>button.td_submenu_toggle,
                .td_mobile_menu li.menu-item-has-children>button.td_submenu_toggle {
                    display: inline-flex !important;
                    position: absolute;
                    right: 0;
                    top: 50%;
                    transform: translateY(-50%);
                    margin: 0 !important;
                }

                /* parent li flex olsun, amma link 100% olmasın */
                .td_nav_list>li.menu-item-has-children {
                    display: flex;
                    align-items: center;
                    flex-wrap: wrap;
                    /* submenu aşağıda qalsın */
                    gap: 10px;
                }

                /* IMPORTANT: burada width:100% override edirik */
                .td_nav_list>li.menu-item-has-children>a {
                    width: auto !important;
                    /* bunu qoymasan yenə aşağı düşəcək */
                    flex: 1 1 auto;
                    order: 1;
                    padding-right: 12px;
                }

                .td_nav_list>li.menu-item-has-children>.td_submenu_toggle {
                    order: 2;
                    margin-left: auto;
                    flex: 0 0 auto;
                    align-self: center;
                }

                /* submenu tam aşağı sətirdə qalsın */
                .td_nav_list>li.menu-item-has-children>ul {
                    width: 100%;
                    order: 3;
                }
            }

            .td_side_header_panel .td_munu_dropdown_toggle::before,
            .td_side_header_panel .td_munu_dropdown_toggle::after,
            .td_side_header_panel .td_munu_dropdown_toggle span::before,
            .td_side_header_panel .td_munu_dropdown_toggle span::after {
                content: none !important;
                display: none !important;
            }

            /* Bizim dairəli toggle qalır */
            .td_side_header_panel button.td_submenu_toggle {
                display: inline-flex !important;
            }
            }
        </style>

        {{-- ==== TOP STRIP ==== --}}
        @include('partials.top-strip')

        <!-- MAIN HEADER -->
        <div class="td_main_header">
            <div class="container-fluid">
                <div class="td_main_header_in">
                    <div class="td_header_bar_left">
                        <a class="td_site_branding" href="{{ route('home') }}" aria-label="Logo">
                            <img src="{{ $logoUrl }}" alt="Logo">
                        </a>

                        <nav style="margin-left: -4px" class="td_nav" aria-label="Primary">
                            <div class="td_nav_list_wrap">
                                <div class="td_nav_list_wrap_in">
                                    <ul class="td_nav_list">
                                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>

                                        <li class="menu-item-has-children">
                                            <a href="{{ route('about') }}">{{ __('About Us') }}</a>
                                            <ul>
                                                <li>
                                                    <a href="{{ route('about') }}#about-who">
                                                        {{ __('Who we are') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('about') }}#about-vision-mission">
                                                        {{ __('Vision & Mission') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('about') }}#about-accreditations">
                                                        {{ __('Licenses & Accreditations') }}
                                                    </a>
                                                </li>
                                                <li><a href="{{ route('team') }}">{{ __('Team') }}</a></li>
                                                <li><a href="{{ route('faqss') }}">{{ __('FAQ') }}</a></li>
                                            </ul>
                                        </li>

                                        <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>

                                        <li class="menu-item-has-children">
                                            <a href="{{ route('services') }}">{{ __('Services') }}</a>
                                            <ul>
                                                @forelse(($serviceHoldings ?? []) as $h)
                                                    <li>
                                                        <a href="{{ route('services', ['holding' => $h]) }}">
                                                            {{ $h }}
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li><a href="{{ route('services') }}">{{ __('All services') }}</a>
                                                    </li>
                                                @endforelse
                                            </ul>
                                        </li>


                                        <li class="menu-item-has-children">
                                            <a href="{{ route('courses-grid-view') }}">{{ __('Training') }}</a>
                                            <ul>
                                                @forelse(($courseHoldings ?? []) as $h)
                                                    <li>
                                                        <a href="{{ route('courses-grid-view', ['holding' => $h]) }}">
                                                            {{ $h }}
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li><a
                                                            href="{{ route('courses-grid-view') }}">{{ __('All trainings') }}</a>
                                                    </li>
                                                @endforelse
                                            </ul>
                                        </li>


                                        <li class="menu-item-has-children">
                                            <a href="{{ route('resources') }}">{{ __('Resources') }}</a>
                                            <ul>
                                                <li>
                                                    <a href="{{ route('resources') }}?q=Reading materials">
                                                        {{ __('Reading materials') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('resources') }}?q=Posters">
                                                        {{ __('Posters') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('resources') }}?q=PPT training materials">
                                                        {{ __('PPT training materials') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('resources') }}?q=Checklists">
                                                        {{ __('Checklists') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="menu-item-has-children">
                                            <a href="{{ route('topices') }}">{{ __('Topics') }}</a>
                                            <ul>
                                                @forelse(($topicHoldings ?? []) as $h)
                                                    <li>
                                                        <a href="{{ route('topices', ['holding' => $h]) }}">
                                                            {{ $h }}
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li><a href="{{ route('topices') }}">{{ __('All topics') }}</a>
                                                    </li>
                                                @endforelse
                                            </ul>
                                        </li>


                                        <li><a href="{{ route('vacancies') }}">{{ __('Vacancies') }}</a></li>
                                        <li><a href="{{ route('news') }}">{{ __('News') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>

                    <div class="td_main_header_right">
                        @php
                            $labels = ['en' => __('English'), 'az' => __('Azerbaijani'), 'ru' => __('Russian')];
                            $currentLocale = app()->getLocale();
                            $fb = setting('social.facebook');
                            $tw = setting('social.twitter');
                            $ig = setting('social.instagram');
                            $pin = setting('social.pinterest');
                            $wa = setting('social.whatsapp');
                            $li = setting('social.linkedin', $pin);
                            $attrs = 'target="_blank" rel="noopener noreferrer"';
                        @endphp

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
                                <div id="globalSearchResults" style="display:none;"></div>
                            </div>
                        </div>

                        {{-- language dropdown near search (mobile / <=1200px) --}}
                        <div style="margin-top:2px;" class="td_header_lang_inline">
                            <div class="position-relative td_language_wrap">
                                <button class="td_header_dropdown_btn td_medium td_heading_color" type="button">
                                    <img src="{{ asset('assets/img/icons/world.svg') }}" alt=""
                                        class="td_header_dropdown_btn_icon">
                                </button>
                                <ul class="td_header_dropdown_list td_mp_0">
                                    <li><a href="/az">{{ __('Azerbaijani') }}</a></li>
                                    <li><a href="/en">{{ __('English') }}</a></li>
                                    <li><a href="/ru">{{ __('Russian') }}</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="td_header_social_btns" aria-label="Social links">
                            @if ($fb)
                                <a href="{{ $fb }}" class="td_social_btn td_social_btn--fb"
                                    {!! $attrs !!} aria-label="Facebook" title="Facebook">
                                    <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($tw)
                                <a href="{{ $tw }}" class="td_social_btn td_social_btn--tw"
                                    {!! $attrs !!} aria-label="X (Twitter)" title="X (Twitter)">
                                    <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($ig)
                                <a href="{{ $ig }}" class="td_social_btn td_social_btn--ig"
                                    {!! $attrs !!} aria-label="Instagram" title="Instagram">
                                    <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($li)
                                <a href="{{ $li }}" class="td_social_btn td_social_btn--li"
                                    {!! $attrs !!} aria-label="LinkedIn" title="LinkedIn">
                                    <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
                                </a>
                            @endif

                            @if ($wa)
                                <a href="{{ $wa }}" class="td_social_btn td_social_btn--wa"
                                    {!! $attrs !!} aria-label="WhatsApp" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>

                        <button class="td_hamburger_btn" type="button" aria-label="Menu"></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDE HEADER --}}
        <div class="td_side_header">
            <div class="td_side_header_backdrop" data-side-close></div>
            <div class="td_side_header_panel" role="dialog" aria-modal="true">
                <div class="td_side_header_in">
                    <div class="td_side_header_head">
                        <div class="td_side_header_title">
                            {{ __('Menu & Quick Actions') }}
                        </div>

                        <div class="td_side_head_actions">
                            <div class="td_side_head_lang">
                                <a href="/az" class="{{ $currentLocale === 'az' ? 'is-active' : '' }}">AZ</a>
                                <span>·</span>
                                <a href="/en" class="{{ $currentLocale === 'en' ? 'is-active' : '' }}">EN</a>
                                <span>·</span>
                                <a href="/ru" class="{{ $currentLocale === 'ru' ? 'is-active' : '' }}">RU</a>
                            </div>

                            <button class="td_side_close_btn" type="button" data-side-close
                                aria-label="Close side menu">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    <div class="td_side_header_body">
                        {{-- 1199–1724 aralığında dil + search burda görünəcək --}}
                        <div class="td_side_lang_search">
                            <div class="td_side_lang_block">
                                <label>{{ __('Language') }}</label>
                                <div class="td_side_lang_select_wrap">
                                    <img id="sideLangFlag"
                                        src="{{ asset('assets/img/flags/' . ($currentLocale === 'az' ? 'az.jpg' : ($currentLocale === 'ru' ? 'ru.jpg' : 'en.jpg'))) }}"
                                        alt="Flag">
                                    <select id="sideLangSelect">
                                        <option value="az" data-flag="{{ asset('assets/img/flags/az.jpg') }}"
                                            {{ $currentLocale === 'az' ? 'selected' : '' }}>
                                            {{ __('Azerbaijani') }}
                                        </option>
                                        <option value="en" data-flag="{{ asset('assets/img/flags/en.jpg') }}"
                                            {{ $currentLocale === 'en' ? 'selected' : '' }}>
                                            {{ __('English') }}
                                        </option>
                                        <option value="ru" data-flag="{{ asset('assets/img/flags/ru.jpg') }}"
                                            {{ $currentLocale === 'ru' ? 'selected' : '' }}>
                                            {{ __('Russian') }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="td_side_search_block" id="sideSearch">
                                <label>{{ __('Search') }}</label>
                                <form class="td_side_search_form" action="javascript:void(0)" autocomplete="off">
                                    <input type="text" id="sideSearchInput"
                                        placeholder="{{ __('Search for anything') }}">
                                    <button type="submit">
                                        <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt="">
                                    </button>
                                </form>
                                <div class="td_side_search_results" id="sideSearchResults"></div>
                            </div>
                        </div>
                    </div>

                    <div class="td_side_footer">
                        <div class="td_side_social_row">
                            @if ($fb)
                                <a href="{{ $fb }}" class="td_social_btn td_social_btn--fb"
                                    {!! $attrs !!} aria-label="Facebook" title="Facebook">
                                    <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if ($tw)
                                <a href="{{ $tw }}" class="td_social_btn td_social_btn--tw"
                                    {!! $attrs !!} aria-label="X (Twitter)" title="X (Twitter)">
                                    <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if ($ig)
                                <a href="{{ $ig }}" class="td_social_btn td_social_btn--ig"
                                    {!! $attrs !!} aria-label="Instagram" title="Instagram">
                                    <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if ($li)
                                <a href="{{ $li }}" class="td_social_btn td_social_btn--li"
                                    {!! $attrs !!} aria-label="LinkedIn" title="LinkedIn">
                                    <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if ($wa)
                                <a href="{{ $wa }}" class="td_social_btn td_social_btn--wa"
                                    {!! $attrs !!} aria-label="WhatsApp" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                        <div class="td_side_legal">
                            © {{ date('Y') }} {{ $siteName ?? 'Educve' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Global search JS (desktop) --}}
        <script>
            (function() {
                const root = document.getElementById('globalSearch');
                if (!root) return;

                const input = document.getElementById('globalSearchInput');
                const box = document.getElementById('globalSearchResults');
                const wrap = root.querySelector('.td_header_search_wrap');
                const toggleBtn = root.querySelector('.td_search_tobble_btn');
                let timer = null;

                function render(html) {
                    box.innerHTML = html || '';
                    box.style.display = html ? 'block' : 'none';
                    if (html) {
                        wrap.style.display = 'block';
                    }
                }

                function search(q) {
                    if (!q || q.trim() === '') {
                        render('');
                        return;
                    }
                    fetch(`{{ route('search') }}?q=${encodeURIComponent(q) }`, {
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
                    const value = this.value;
                    timer = setTimeout(() => search(value), 280);
                });

                root.querySelector('form').addEventListener('submit', (e) => {
                    e.preventDefault();
                    search(input.value);
                });

                document.addEventListener('click', (e) => {
                    if (!root.contains(e.target)) {
                        wrap.style.display = 'none';
                        box.style.display = 'none';
                    }
                });

                toggleBtn?.addEventListener('click', () => {
                    const visible = wrap.style.display === 'block';
                    wrap.style.display = visible ? 'none' : 'block';
                    if (!visible) {
                        setTimeout(() => input.focus(), 50);
                    }
                });
            })();
        </script>

        {{-- Side header JS --}}
        <script>
            (function() {
                const side = document.querySelector('.td_side_header');
                const panel = document.querySelector('.td_side_header_panel');
                const btn = document.querySelector('.td_hamburger_btn');
                const closers = document.querySelectorAll('[data-side-close]');
                if (!side || !panel || !btn) return;

                // --- helpers ---
                function removeOldPluses(scope) {
                    if (!scope) return;
                    scope.querySelectorAll('.td_munu_dropdown_toggle').forEach(el => el.remove());
                }

                function setupSubmenuToggles(scope) {
                    if (!scope) return;

                    // köhnə + (theme) əvvəlcə silinsin
                    removeOldPluses(scope);

                    const items = scope.querySelectorAll('li.menu-item-has-children');
                    items.forEach((li) => {
                        const submenu = li.querySelector(':scope > ul');
                        const link = li.querySelector(':scope > a');
                        if (!submenu || !link) return;

                        // bizim dairəli toggle
                        let toggle = li.querySelector(':scope > button.td_submenu_toggle');
                        if (!toggle) {
                            toggle = document.createElement('button');
                            toggle.type = 'button';
                            toggle.className = 'td_submenu_toggle';
                            toggle.setAttribute('aria-label', 'Toggle submenu');
                            toggle.setAttribute('aria-expanded', 'false');
                            link.insertAdjacentElement('afterend', toggle);
                        }

                        // initial state (default bağlı)
                        li.classList.remove('is-open');
                        toggle.setAttribute('aria-expanded', 'false');

                        // click bind only once
                        if (toggle.dataset.bound === '1') return;
                        toggle.dataset.bound = '1';

                        toggle.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();

                            const isOpen = li.classList.toggle('is-open');
                            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                        });
                    });
                }

                // MutationObserver: tema menyunu sonradan inject edəndə də işləsin
                let observer = null;

                function startObserver() {
                    if (observer) return;

                    observer = new MutationObserver(() => {
                        // inject olunan köhnə plusları sil + toggle-ları yenilə
                        setupSubmenuToggles(panel);
                    });

                    observer.observe(panel, {
                        childList: true,
                        subtree: true
                    });
                }

                function stopObserver() {
                    if (!observer) return;
                    observer.disconnect();
                    observer = null;
                }

                function openSide() {
                    side.classList.add('is-open');

                    // observer açıq olanda işləsin
                    startObserver();

                    // dərhal + bir az gecikmə ilə (inject varsa)
                    setupSubmenuToggles(panel);
                    setTimeout(() => setupSubmenuToggles(panel), 120);
                    setTimeout(() => setupSubmenuToggles(panel), 350);
                }

                function closeSide() {
                    side.classList.remove('is-open');
                    stopObserver();
                }

                btn.addEventListener('click', openSide);
                closers.forEach(el => el.addEventListener('click', closeSide));

                document.addEventListener('keyup', (e) => {
                    if (e.key === 'Escape') closeSide();
                });

                // Side language flag + redirect
                const select = document.getElementById('sideLangSelect');
                const flagImg = document.getElementById('sideLangFlag');
                if (select && flagImg) {
                    function updateFlagAndNavigate() {
                        const opt = select.options[select.selectedIndex];
                        if (!opt) return;
                        const flagUrl = opt.getAttribute('data-flag');
                        if (flagUrl) {
                            flagImg.src = flagUrl;
                            flagImg.alt = opt.value.toUpperCase() + ' flag';
                        }
                        window.location.href = `/${opt.value}`;
                    }
                    select.addEventListener('change', updateFlagAndNavigate);
                }

                // Side search
                const searchRoot = document.getElementById('sideSearch');
                if (searchRoot) {
                    const input = document.getElementById('sideSearchInput');
                    const results = document.getElementById('sideSearchResults');
                    const form = searchRoot.querySelector('form');
                    let timer = null;

                    function renderSide(html) {
                        results.innerHTML = html || '';
                        results.style.display = html ? 'block' : 'none';
                    }

                    function sideSearch(q) {
                        if (!q || q.trim() === '') {
                            renderSide('');
                            return;
                        }
                        fetch(`{{ route('search') }}?q=${encodeURIComponent(q) }`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(r => r.json())
                            .then(({
                                html
                            }) => renderSide(html))
                            .catch(() => renderSide(
                                '<div class="gsearch-dropdown"><div class="gsearch-empty">Error.</div></div>'));
                    }

                    input.addEventListener('input', function() {
                        clearTimeout(timer);
                        const value = this.value;
                        timer = setTimeout(() => sideSearch(value), 280);
                    });

                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        sideSearch(input.value);
                    });
                }

                // səhifə yüklənəndə də: varsa köhnə plusları sil
                setupSubmenuToggles(document);
            })();
        </script>

    </header>



    <div class="td_side_header" id="sideHeader">
        <button class="td_close" type="button" aria-label="Close"></button>

        {{-- Overlay content-in üstünü örtməsin deyə in-dən kənarda saxlayırıq --}}
        <div class="td_side_header_overlay" aria-hidden="true"></div>

        <div class="td_side_header_in">
            <div class="td_side_header_shape"></div>

            @if ($logoUrl)
                <img src="{{ asset('assets/img/hse.png') }}" alt="{{ $siteName }}"
                    style="max-height:64px;width:auto;">
            @else
                <svg width="241" height="64" viewBox="0 0 241 64" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    {{-- ... SVG path-ların burda qalır ... --}}
                </svg>
            @endif

            <div class="td_side_header_box">
                <h2 class="td_side_header_heading">
                    Do you have a project in your <br> mind? Keep connect us.
                </h2>
            </div>

            <div class="td_side_header_box">
                <h3 class="td_side_header_title td_heading_color">Contact Us</h3>

                <ul class="td_side_header_contact_info td_mp_0">
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

            <div class="td_side_header_box">
                <h3 class="td_side_header_title td_heading_color">{{ __('Subscribe') }}</h3>

                <div class="td_newsletter td_style_1">
                    <form class="td_newsletter_form" action="{{ route('subscribe') }}" method="POST"
                        id="newsletterForm">
                        @csrf
                        <input type="email" name="email" class="td_newsletter_input" placeholder="Email address"
                            required>
                        <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                            <span class="td_btn_in td_white_color td_accent_bg">
                                <span>{{ __('Subscribe now') }}</span>
                            </span>
                        </button>
                    </form>

                    @if (session('sub_ok'))
                        <div class="alert alert-success mt-2">{{ session('sub_ok') }}</div>
                    @endif
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
    <style>
        .td_side_header {
            position: fixed;
            inset: 0;
            z-index: 9999;
        }

        /* overlay fon üçündür, amma content-in üstünü örtməsin */
        .td_side_header_overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: auto;
            /* overlay-ə klik edəndə bağlaya bilərsən */
        }

        /* content overlay-dən yuxarıda olmalıdır */
        .td_side_header_in {
            position: relative;
            z-index: 2;
            pointer-events: auto;
        }

        /* close button da yuxarıda olsun */
        .td_close {
            position: absolute;
            z-index: 3;
            pointer-events: auto;
        }

        /* ehtiyat üçün: input/button həmişə klik qəbul etsin */
        .td_side_header_in input,
        .td_side_header_in button,
        .td_side_header_in a,
        .td_side_header_in textarea,
        .td_side_header_in select {
            pointer-events: auto;
        }
    </style>

    <!-- End Header Section -->
    <!-- Start Hero Section -->
    {{-- Home – Hero (settings-driven) --}}
    @php

        // Mövcud hero mətnləri (dəyişmir)
        $hero = setting('home.hero', []);
        $kicker = data_get($hero, 'kicker', 'Knowledge is Power');
        $titleHtml = data_get($hero, 'title', '<span>Educve</span> - The Best Place to Invest in your Knowledge');
        $subtitle = data_get(
            $hero,
            'subtitle',
            'A university is a vibrant institution that serves as a hub for higher education and research. It provides a dynamic environment.',
        );
        $ctaText = data_get($hero, 'cta.text', 'View Our Program');
        $ctaUrl = data_get($hero, 'cta.url', '/');

        // Köhnə tək BG məntiqini saxlayırıq (fallback üçün)
        $bg = setting('home.hero.bg_image');
        $bgUrl = $bg
            ? (Str::startsWith($bg, ['http', '/storage', 'assets/'])
                ? asset($bg)
                : asset('storage/' . ltrim($bg, '/')))
            : asset('assets/img/home_1/hero_bg_1.jpg');

        // YENİ: Home hero slider şəkilləri (0–12, opsional)
        $homeSlides = (array) setting('pages.heroes.home.images', []);
        $homeSlides = array_values(array_filter($homeSlides, fn($v) => is_string($v) && trim($v) !== ''));

        // Heç şəkil verilməyibsə: köhnə $bgUrl-i slayt kimi istifadə et
        if (count($homeSlides) === 0) {
            $homeSlides = [$bgUrl];
        }
    @endphp

    <section id="home-hero" class="td_hero td_style_1 td_heading_bg td_center">
        <style>
            /* ===== HOME HERO SLIDER ===== */
            #home-hero {
                position: relative;
                overflow: hidden;
            }

            #home-hero .hero-slider {
                position: absolute;
                inset: 0;
                z-index: 0;
            }

            #home-hero .hero-slide {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                opacity: 0;
                /* Daha maraqlı keçid: yüngül zoom + parallax */
                transform: scale(1.08) translateX(4%);
                transition:
                    opacity 0.9s ease-in-out,
                    transform 0.9s ease-in-out;
                will-change: opacity, transform;
            }

            /* Aktiv olan slayd – ortaya yaxınlaşır */
            #home-hero .hero-slide.is-active {
                opacity: 1;
                transform: scale(1) translateX(0);
                z-index: 1;
            }

            /* Keçidən çıxan əvvəlki slayd – bir az sola çəkilir */
            #home-hero .hero-slide.is-prev {
                opacity: 0;
                transform: scale(1.03) translateX(-4%);
                z-index: 0;
            }

            #home-hero .hero-overlay {
                position: absolute;
                inset: 0;
                z-index: 1;
                background: linear-gradient(180deg, rgba(15, 23, 42, .25) 0%, rgba(15, 23, 42, .65) 100%);
            }

            #home-hero .td_hero_text {
                position: relative;
                z-index: 2;
            }

            #home-hero .td_lines {
                position: relative;
                z-index: 2;
            }
        </style>

        {{-- Arxa fon slaytları --}}
        <div class="hero-slider" aria-hidden="true">
            @foreach ($homeSlides as $i => $src)
                <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}"
                    style="background-image:url('{{ $src }}')">
                </div>
            @endforeach
            <div class="hero-overlay"></div>
        </div>

        <div class="container">
            <div class="td_hero_text wow fadeInRight" data-wow-duration="0.9s" data-wow-delay="0.35s">
                @if ($kicker)
                    <p
                        class="td_hero_subtitle_up td_fs_18 td_white_color td_spacing_1 td_semibold text-uppercase td_mb_10 td_opacity_9">
                        {{ $kicker }}
                    </p>
                @endif

                <h1 class="td_hero_title td_fs_64 td_white_color td_mb_12">{!! $titleHtml !!}</h1>

                @if ($subtitle)
                    <p class="td_hero_subtitle td_fs_18 td_white_color td_opacity_7 td_mb_30">{{ $subtitle }}</p>
                @endif
                @php
                    // CTA URL düzəlt (DB-dən gələn url)
                    $ctaHref = null;

                    if (!empty($ctaUrl)) {
                        // Absolute (http/https) və ya root (/) ilə başlayırsa olduğu kimi saxla
                        if (\Illuminate\Support\Str::startsWith($ctaUrl, ['http://', 'https://', '/'])) {
                            $ctaHref = $ctaUrl;
                        } else {
                            // nisbi url-dirsə "en/" əlavə elə
                            $ctaHref = 'en/' . ltrim($ctaUrl, '/');
                        }
                    } else {
                        // fallback
                        $ctaHref = route('courses-grid-view');
                    }
                @endphp

                @if ($ctaText && $ctaHref)
                    <a href="{{ $ctaHref }}" class="td_btn td_style_1 td_radius_10 td_medium">
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

        {{-- Slider üçün sadə JS – 3 saniyədən bir slayd dəyişir --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const hero = document.getElementById('home-hero');
                if (!hero) return;

                const slides = hero.querySelectorAll('.hero-slide');
                if (!slides.length) return;

                let current = 0;
                const total = slides.length;
                const intervalMs = 3000; // 3 saniyə

                const goToSlide = (index) => {
                    if (index === current) return;

                    const prevSlide = slides[current];
                    const nextSlide = slides[index];

                    // Köhnə slaydı çıxan kimi işarələ
                    prevSlide.classList.remove('is-active');
                    prevSlide.classList.add('is-prev');

                    // Yeni slaydı aktiv et
                    nextSlide.classList.add('is-active');
                    nextSlide.classList.remove('is-prev');

                    current = index;

                    // Animasiya bitəndən sonra .is-prev class-ını sil (təmizlik üçün)
                    setTimeout(() => {
                        prevSlide.classList.remove('is-prev');
                    }, 1000);
                };

                const startAutoPlay = () => {
                    setInterval(() => {
                        const nextIndex = (current + 1) % total;
                        goToSlide(nextIndex);
                    }, intervalMs);
                };

                startAutoPlay();
            });
        </script>
    </section>

    {{-- Slider JS: 2s interval; hover/tab gizlənəndə pauza --}}
    <script>
        (function() {
            const root = document.querySelector('#home-hero .hero-slider');
            if (!root) return;

            const slides = Array.from(root.querySelectorAll('.hero-slide'));
            if (slides.length <= 1) return;

            let idx = 0,
                timer = null;
            const INTERVAL = 2000;

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

            const sec = document.getElementById('home-hero');
            sec.addEventListener('mouseenter', stop);
            sec.addEventListener('mouseleave', start);

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) stop();
                else start();
            });
        })();
    </script>

    @php

        $heroButtons = \App\Models\HeroButton::orderBy('order')->get();
        $locale = app()->getLocale(); // az | en | ru

        $normalizeHeroUrl = function (?string $raw) use ($locale) {
            $raw = trim((string) $raw);

            if ($raw === '') {
                return '#';
            }

            // 1) external və ya xüsusi protokollar: toxunma
            if (preg_match('~^(https?:)?//~i', $raw) || preg_match('~^(mailto:|tel:|whatsapp:|sms:)~i', $raw)) {
                return $raw;
            }

            // 2) anchor (#...) toxunma
            if (Str::startsWith($raw, '#')) {
                return $raw;
            }

            // raw daxilində query/fragment ola bilər, onları saxlayırıq
            // məsələn: contact?x=1#y
            $path = $raw;
            $qs = '';
            $hash = '';

            if (str_contains($path, '#')) {
                [$path, $hash] = explode('#', $path, 2);
                $hash = '#' . $hash;
            }
            if (str_contains($path, '?')) {
                [$path, $qs] = explode('?', $path, 2);
                $qs = '?' . $qs;
            }

            $path = '/' . ltrim($path, '/'); // həmişə / ilə başlasın

            // 3) artıq locale prefix varsa toxunma
            // /en/..., /az/..., /ru/...
            if (preg_match('~^/(az|en|ru)(/|$)~i', $path)) {
                return $path . $qs . $hash;
            }

            // 4) locale əlavə et
            return '/' . $locale . $path . $qs . $hash;
        };
    @endphp

    @if ($heroButtons->count())
        <div class="container">
            <div class="td_hero_btn_group">
                @foreach ($heroButtons as $b)
                    <a href="{{ $normalizeHeroUrl($b->url) }}"
                        class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                        data-wow-duration="0.9s" data-wow-delay="{{ number_format(0.35 + $loop->index * 0.1, 2) }}">
                        <span class="td_btn_in td_white_color td_accent_bg">
                            <span>{{ $b->text }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif



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

        $cta = setting('home.about.cta', ['text' => 'More About', 'url' => '/']);

        // ✅ FIX: button href must come from CTA url
        $ctaUrl = data_get($cta, 'url', '/');
    @endphp

    <section id="home-about">
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
                                {{ $kicker }}
                            </p>
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

                        <a href="{{ $ctaUrl }}" class="td_btn td_style_1 td_radius_10 td_medium">
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
    <section id="home-courses" class="td_gray_bg_3">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.15s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    {{ __('Popular Courses') }}
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">{{ __('Academic Courses') }}</h2>
            </div>

            <div class="td_height_30 td_height_lg_30"></div>

            <div class="td_tabs">
                <ul class="td_tab_links td_style_1 td_mp_0 td_fs_20 td_medium td_heading_color wow fadeInUp"
                    data-wow-duration="1s" data-wow-delay="0.2s">
                    {{-- NOTE: clicking Courses opens the modal (see JS). It is not the active tab. --}}
                    <li><a href="#tab_1" id="openCoursesModal">{{ __('Courses') }}</a></li>
                    <li><a href="#tab_2">{{ __('Services') }}</a></li>
                    <li class="active"><a href="#tab_3" id="topicsTabLink">{{ __('Topics') }}</a></li>
                    <li><a href="#tab_4">{{ __('Vacancies') }}</a></li>
                </ul>

                <div class="td_height_50 td_height_lg_50"></div>

                <style>
                    /* --- Uniform card/grid fixes (used by Services/Topics/Vacancies) --- */
                    .td_card.td_style_3 {
                        display: flex;
                        flex-direction: column;
                        height: 100%
                    }

                    .td_card.td_style_3 .td_card_thumb {
                        position: relative;
                        width: 100%;
                        aspect-ratio: 16/9;
                        overflow: hidden;
                        border-top-left-radius: 10px;
                        border-top-right-radius: 10px
                    }

                    .td_card.td_style_3 .td_card_thumb img {
                        position: absolute;
                        inset: 0;
                        width: 100%;
                        height: 100%;
                        object-fit: cover
                    }

                    .td_card.td_style_3 .td_card_info {
                        flex: 1;
                        display: flex
                    }

                    .td_card.td_style_3 .td_card_info_in {
                        display: flex;
                        flex-direction: column;
                        width: 100%
                    }

                    .td_card.td_style_3 .td_card_title {
                        -webkit-line-clamp: 2;
                        display: -webkit-box;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        min-height: 3.2em
                    }

                    .td_card.td_style_3 .td_card_subtitle {
                        -webkit-line-clamp: 3;
                        display: -webkit-box;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        min-height: 3.9em
                    }

                    .td_card.td_style_3 .td_card_btn {
                        margin-top: auto
                    }

                    /* --- Courses Modal (slide-up drawer) --- */
                    .courses-modal_backdrop {
                        position: fixed;
                        inset: 0;
                        background: rgba(2, 6, 23, .45);
                        backdrop-filter: saturate(1.2) blur(2px);
                        display: none;
                        z-index: 9998;
                    }

                    .courses-modal {
                        position: fixed;
                        left: 50%;
                        bottom: -100%;
                        transform: translateX(-50%);
                        width: min(920px, 94vw);
                        background: #fff;
                        border-radius: 20px 20px 0 0;
                        box-shadow: 0 30px 60px rgba(2, 6, 23, .25);
                        z-index: 9999;
                        transition: bottom .28s ease;
                    }

                    .courses-modal_header {
                        padding: 18px 20px;
                        border-bottom: 1px solid #e5e7eb;
                        display: flex;
                        align-items: center;
                        justify-content: space-between
                    }

                    .courses-modal_title {
                        font-size: 22px;
                        font-weight: 800;
                        margin: 0
                    }

                    .courses-modal_close {
                        width: 36px;
                        height: 36px;
                        border-radius: 10px;
                        border: 1px solid #e5e7eb;
                        background: #fff;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .courses-modal_body {
                        padding: 18px 18px 2px
                    }

                    .chip-grid {
                        display: grid;
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                        gap: 10px
                    }

                    @media (min-width:576px) {
                        .chip-grid {
                            grid-template-columns: repeat(3, minmax(0, 1fr))
                        }
                    }

                    @media (min-width:768px) {
                        .chip-grid {
                            grid-template-columns: repeat(4, minmax(0, 1fr))
                        }
                    }

                    .chip {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 12px 14px;
                        border: 1px solid #e5e7eb;
                        border-radius: 12px;
                        background: #fff;
                        transition: transform .05s ease, box-shadow .15s ease, border-color .15s ease;
                        text-decoration: none;
                        color: #0f172a;
                        font-weight: 700
                    }

                    .chip:hover {
                        border-color: #fecaca;
                        box-shadow: 0 8px 22px rgba(2, 6, 23, .06)
                    }

                    .chip:active {
                        transform: translateY(1px)
                    }

                    .chip .dot {
                        width: 10px;
                        height: 10px;
                        border-radius: 9999px;
                        background: #e31b23;
                        box-shadow: 0 0 0 4px rgba(227, 27, 35, .08)
                    }

                    .courses-modal_footer {
                        padding: 14px 18px 18px;
                        display: flex;
                        gap: 10px;
                        justify-content: flex-end
                    }

                    .btn-outline {
                        border: 1px solid #e5e7eb;
                        background: #fff;
                        border-radius: 10px;
                        padding: 10px 14px;
                        font-weight: 700
                    }

                    .btn-primary {
                        border: 1px solid #e31b23;
                        background: #e31b23;
                        color: #fff;
                        border-radius: 10px;
                        padding: 10px 14px;
                        font-weight: 700
                    }

                    .courses-modal_backdrop.show {
                        display: block
                    }

                    .courses-modal.show {
                        bottom: 0
                    }

                    .td_main_header .container-fluid {
                        padding-right: 65px;
                        padding-left: 65px;
                    }
                </style>

                <div class="td_tab_body">
                    {{-- tab_1 is intentionally empty; clicking its tab opens the modal --}}
                    <div class="td_tab" id="tab_1" aria-hidden="true"></div>

                    {{-- tab_2: SERVICES --}}
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
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>{{ __('Service') }}</span></a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                        href="{{ route('service-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}</p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('service-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span
                                                            class="td_btn_in td_white_color td_accent_bg"><span>{{ __('View Details') }}</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">{{ __('No services yet.') }}</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- tab_3: TOPICS (DEFAULT ACTIVE ON LOAD) --}}
                    <div class="td_tab active" id="tab_3">
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
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>{{ __('Topic') }}</span></a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                        href="{{ route('topices-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}</p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('topices-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span
                                                            class="td_btn_in td_white_color td_accent_bg"><span>{{ __('View Details') }}</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">{{ __('No topics yet.') }}</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- tab_4: VACANCIES --}}
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
                                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14"><span>{{ __('Vacancy') }}</span></a>
                                                <h2 class="td_card_title td_fs_24 td_mb_16"><a
                                                        href="{{ route('vacancies-details', $it->id) }}">{{ $it->name }}</a>
                                                </h2>
                                                <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                    {{ Str::limit(strip_tags($it->description), 110) }}</p>
                                                <div class="td_card_btn">
                                                    <a href="{{ route('vacancies-details', $it->id) }}"
                                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                                        <span
                                                            class="td_btn_in td_white_color td_accent_bg"><span>{{ __('View Details') }}</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">{{ __('No vacancies yet.') }}</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COURSES SLIDE-UP MODAL --}}
        @php
            $courseNames = ['IOSH', 'NEBOSH', 'CIEH', 'IIRSM', 'NSC', 'Local Training', 'E-learning'];
        @endphp
        <div class="courses-modal_backdrop" id="coursesBackdrop" aria-hidden="true"></div>
        <div class="courses-modal" id="coursesModal" role="dialog" aria-modal="true"
            aria-labelledby="coursesModalTitle" aria-describedby="coursesModalDesc">
            <div class="courses-modal_header">
                <h3 id="coursesModalTitle" class="courses-modal_title">{{ __('Academic Courses') }}</h3>
                <button type="button" class="courses-modal_close" id="closeCoursesModal"
                    aria-label="{{ __('Close') }}">✕</button>
            </div>
            <div class="courses-modal_body">
                <p id="coursesModalDesc" class="mb-3" style="color:#64748b">
                    {{ __('Choose a course brand/category to filter:') }}</p>
                <div class="chip-grid">
                    @foreach ($courseNames as $name)
                        <a class="chip" href="{{ route('courses-grid-view', ['q' => $name]) }}">
                            <span class="dot" aria-hidden="true"></span>
                            <span>{{ $name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="courses-modal_footer">
                <a class="btn-outline" href="{{ route('courses-grid-view') }}">{{ __('View all courses') }}</a>
                <button type="button" class="btn-primary" id="closeCoursesModal2">{{ __('Close') }}</button>
            </div>
        </div>

        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Popular Courses -->

    <script>
        (function() {
            const openBtn = document.getElementById('openCoursesModal');
            const modal = document.getElementById('coursesModal');
            const backdrop = document.getElementById('coursesBackdrop');
            const closeBtns = [document.getElementById('closeCoursesModal'), document.getElementById(
                'closeCoursesModal2')];

            function openModal(e) {
                if (e) e.preventDefault(); // stop tab switch
                backdrop.classList.add('show');
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                setTimeout(() => closeBtns[0]?.focus(), 60);
            }

            function closeModal() {
                backdrop.classList.remove('show');
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }

            openBtn?.addEventListener('click', openModal);
            backdrop?.addEventListener('click', closeModal);
            closeBtns.forEach(btn => btn?.addEventListener('click', closeModal));
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });

            // ------- Ensure Topics tab content is visible on initial load -------
            // Some tab scripts require syncing "active" on both tab link and content.
            // We set it in HTML, but also enforce here in case theme JS overwrites.
            const topicsLinkLi = document.querySelector('ul.td_tab_links li.active');
            const topicsTab = document.getElementById('tab_3');
            if (topicsLinkLi && topicsTab) {
                topicsTab.classList.add('active');
            } else {
                // fallback: if nothing active, make topics active
                document.querySelectorAll('.td_tab').forEach(t => t.classList.remove('active'));
                document.getElementById('tab_3')?.classList.add('active');
                const links = document.querySelectorAll('ul.td_tab_links li');
                links.forEach(li => li.classList.remove('active'));
                document.querySelector('ul.td_tab_links li:nth-child(3)')?.classList.add('active');
            }
        })();
    </script>

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

    <section id="home-features">
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

                                $link = data_get($it, 'url'); // <-- YENİ
                            @endphp

                            <li>
                                @if (!empty($link))
                                    <a href="{{ $link }}"
                                        class="td_feature_link d-flex align-items-start gap-3"
                                        style="text-decoration:none;color:inherit;">
                                @endif

                                <div class="td_feature_icon td_center">
                                    @if ($iconUrl)
                                        <img src="{{ $iconUrl }}" alt=""
                                            style="width:60px;height:60px;object-fit:contain;">
                                    @endif
                                </div>

                                <div class="td_feature_info">
                                    <h3 class="td_fs_32 td_semibold td_mb_15">
                                        {{ data_get($it, 'title') }}
                                    </h3>

                                    @if (data_get($it, 'text'))
                                        <p class="td_fs_14 td_heading_color td_opacity_7 mb-0">
                                            {{ data_get($it, 'text') }}
                                        </p>
                                    @endif
                                </div>

                                @if (!empty($link))
                                    </a>
                                @endif
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
    <style>
        #home-features .td_feature_link:hover h3 {
            text-decoration: underline;
        }

        #home-features .td_feature_link {
            display: flex;
            width: 100%;
        }
    </style>

    {{-- End Feature Section --}}

    {{-- Start Campus Life (settings-driven, fixed) --}}
    @php
        $campus = setting('home.campus', []);
        $title = data_get($campus, 'title', 'Navigate');
        $subtitle = data_get($campus, 'subtitle', null);

        // ✅ Map CTA from settings
        $ctaText = data_get($campus, 'cta.text', 'View All Program');
        $ctaUrl = data_get($campus, 'cta.url', 'courses-grid-view.html');

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

        // ✅ Page link normalize (cta + card urls)
        $toLink = function (?string $url, string $fallback = '#') {
            $url = trim((string) $url);
            if ($url === '') {
                return $fallback;
            }

            if (Str::startsWith($url, ['http://', 'https://', '#', '/'])) {
                return $url;
            }

            return url($url);
        };

        $ctaHref = $toLink($ctaUrl, '#');
    @endphp

    <section id="home-campus" class="td_accent_bg td_shape_section_1">
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

                    <div class="td_btn_box">
                        <svg width="299" height="315" viewBox="0 0 299 315" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.75" clip-path="url(#clip0_34_2222)">
                                <path
                                    d="M242.757 275.771C242.505 275.771 242.253 275.75 242.005 275.707C32.3684 239.98 0.342741 8.13005 0.0437414 5.79468C-0.108609 4.51176 0.22739 3.21754 0.9787 2.19335C1.73001 1.16916 2.8359 0.497795 4.05598 0.32519C5.27606 0.152585 6.5117 0.492693 7.4943 1.27158C8.4769 2.05047 9.12704 3.20518 9.3034 4.48471C9.59772 6.7514 40.7872 231.477 243.5 266.022C244.658 266.22 245.702 266.868 246.426 267.838C247.15 268.808 247.5 270.028 247.406 271.256C247.312 272.484 246.782 273.63 245.921 274.467C245.06 275.303 243.93 275.769 242.757 275.771Z"
                                    fill="white" />
                                <path
                                    d="M299.002 275.455C271.709 283.305 237.446 297.872 215.562 314.617L235.465 269.602L223.318 221.648C242.099 242.137 273.428 262.728 299.002 275.455Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_34_2222">
                                    <rect width="299" height="314" fill="white"
                                        transform="translate(0 0.421875)" />
                                </clipPath>
                            </defs>
                        </svg>
                        <div class="td_btn_box_in">
                            <a href="{{ $ctaHref }}" class="td_btn td_style_1 td_radius_10 td_medium td_fs_18">
                                <span class="td_btn_in td_heading_color td_white_bg">
                                    <span>{{ $ctaText }}</span>
                                </span>
                            </a>
                        </div>
                    </div>
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
                                    $c0Url = $toLink(data_get($c0, 'url', '#'), '#');
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
                                    $c2Url = $toLink(data_get($c2, 'url', '#'), '#');
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
                                    $c1Url = $toLink(data_get($c1, 'url', '#'), '#');
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
                                    $c3Url = $toLink(data_get($c3, 'url', '#'), '#');
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

    <section id="home-resources">
        <div class="td_height_112 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center">
                <h2 class="td_section_title td_fs_48 mb-0">
                    {{ __('Fresh Learning Materials & Downloads') }}
                </h2>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>

            @if (isset($resources) && $resources->count())
                @php
                    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\ResourceItem[] $resources */
                    $hero = $resources->first();
                    $others = $resources->slice(1, 3); // sağ tərəfdə max 3 ədəd
                    $heroExt = strtolower(pathinfo($hero->resourceUrl, PATHINFO_EXTENSION) ?: '');
                    $heroMime = strtolower($hero->mime ?? '');
                    $heroIsImage =
                        \Illuminate\Support\Str::startsWith($heroMime, 'image/') ||
                        in_array($heroExt, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true);
                @endphp

                <div class="row td_gap_y_30">
                    {{-- SOL: BÖYÜK KART (Event schedule böyük kartı kimi) --}}
                    <div class="col-lg-6">
                        <div class="td_card td_style_1 td_radius_5">
                            <a href="{{ route('resources-details', $hero->id) }}"
                                class="td_card_thumb td_mb_30 d-block">
                                @if ($heroIsImage)
                                    <img src="{{ $hero->resourceUrl }}" alt="{{ $hero->name }}">
                                @else
                                    {{-- şəkil deyilsə placeholder istifadə et --}}
                                    <img src="{{ asset('assets/img/home_1/event_thumb_1.jpg') }}"
                                        alt="{{ $hero->name }}">
                                @endif
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                <span class="td_card_location td_medium td_white_color td_fs_18">
                                    {{-- location yerinə type/year göstəririk --}}
                                    <svg width="16" height="22" viewBox="0 0 16 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.0004 0.5C3.86669 0.5 0.554996 3.86526 0.500458 7.98242C0.48345 9.42271 0.942105 10.7046 1.56397 11.8232C2.76977 13.9928 4.04435 16.8182 5.32856 19.4639C5.9286 20.7002 6.89863 21.5052 8.0004 21.5C9.10217 21.4948 10.0665 20.6836 10.6575 19.4404C11.9197 16.7856 13.1685 13.9496 14.4223 11.835C15.1136 10.6691 15.4653 9.3606 15.4974 8.01758C15.5966 3.86772 12.1342 0.5 8.0004 0.5ZM8.0004 2.00586C11.3235 2.00586 14.0821 4.6775 14.0033 7.97363C13.9749 9.08002 13.6796 10.1416 13.1273 11.0732C11.7992 13.3133 10.5449 16.1706 9.2954 18.7988C8.85773 19.7191 8.35538 19.9924 7.98864 19.9941C7.62183 19.9959 7.12572 19.7246 6.68204 18.8105C5.41121 16.1923 4.12648 13.3534 2.87056 11.0938C2.32971 10.121 1.9798 9.11653 1.9946 8.00586C2.03995 4.67555 4.67723 2.00586 8.0004 2.00586ZM8.0004 4.25C5.94024 4.25 4.25034 5.94266 4.25034 8.00586C4.25034 10.0691 5.94024 11.75 8.0004 11.75C10.0605 11.75 11.7503 10.0691 11.7503 8.00586C11.7503 5.94266 10.0605 4.25 8.0004 4.25ZM8.0004 5.74414C9.25065 5.74414 10.2446 6.75372 10.2446 8.00586C10.2446 9.258 9.25065 10.2559 8.0004 10.2559C6.7501 10.2559 5.75331 9.258 5.75331 8.00586C5.75331 6.75372 6.7501 5.74414 8.0004 5.74414Z"
                                            fill="currentColor" />
                                    </svg>
                                    {{ $hero->type?->name ?? 'Resource' }}
                                    @if ($hero->year)
                                        • {{ $hero->year }}
                                    @endif
                                </span>
                            </a>
                            <div class="td_card_info">
                                <div class="td_card_info_in">
                                    <div class="td_mb_30">
                                        <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                            <li>
                                                {{-- tarix --}}
                                                <svg class="td_accent_color" width="22" height="24"
                                                    viewBox="0 0 22 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.3308 11.7869H19.0049C19.3833 11.7869 19.6913 11.479 19.6913 11.1005V9.42642C19.6913 9.04795 19.3833 8.74003 19.0049 8.74003H17.3308C16.9523 8.74003 16.6444 9.04795 16.6444 9.42642V11.1005C16.6444 11.479 16.9523 11.7869 17.3308 11.7869Z"
                                                        fill="currentColor" />
                                                    {{-- qalan path-larını qısaltdım, dizayn eyni qalır --}}
                                                </svg>
                                                <span>{{ optional($hero->created_at)->format('M d , Y') }}</span>
                                            </li>
                                            @if ($hero->mime)
                                                <li>
                                                    {{-- saat yerinə mime/type göstəririk --}}
                                                    <svg class="td_accent_color" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g>
                                                            <path
                                                                d="M12 24C18.616 24 24 18.616 24 12C24 5.38401 18.6161 0 12 0C5.38394 0 0 5.38401 0 12C0 18.616 5.38401 24 12 24Z"
                                                                fill="currentColor" />
                                                            <path d="M15.4992 15.8209L11.9992 11.9969V5.59686"
                                                                fill="currentColor" />
                                                        </g>
                                                    </svg>
                                                    <span>{{ $hero->mime }}</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <h2 class="td_card_title td_fs_32 td_semibold td_mb_20">
                                        <a
                                            href="{{ route('resources-details', $hero->id) }}">{{ $hero->name }}</a>
                                    </h2>
                                    @if ($hero->description)
                                        <p class="td_mb_30 td_fs_18">
                                            {{ \Illuminate\Support\Str::limit($hero->description, 140) }}
                                        </p>
                                    @endif
                                    <a href="{{ route('resources-details', $hero->id) }}"
                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                        <span class="td_btn_in td_white_color td_accent_bg">
                                            <span>{{ __('View / Download') }}</span>
                                            <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
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

                    {{-- SAĞ: KİÇİK KARTLAR (Event schedule sağ tərəf kimi) --}}
                    <div class="col-lg-6 td_gap_y_30 flex-wrap d-flex">
                        @foreach ($others as $res)
                            @php
                                $ext = strtolower(pathinfo($res->resourceUrl, PATHINFO_EXTENSION) ?: '');
                                $mime = strtolower($res->mime ?? '');
                                $isImg =
                                    \Illuminate\Support\Str::startsWith($mime, 'image/') ||
                                    in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'], true);
                            @endphp
                            <div class="td_card td_style_1 td_type_1">
                                <a href="{{ route('resources-details', $res->id) }}" class="td_card_thumb d-block">
                                    @if ($isImg)
                                        <img src="{{ $res->resourceUrl }}" alt="{{ $res->name }}">
                                    @else
                                        <img src="{{ asset('assets/img/home_1/event_thumb_2.jpg') }}"
                                            alt="{{ $res->name }}">
                                    @endif
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                                <div class="td_card_info">
                                    <div class="td_card_info_in">
                                        <div class="td_mb_20">
                                            <ul class="td_card_meta td_mp_0 td_medium td_heading_color">
                                                <li>
                                                    <svg class="td_accent_color" width="22" height="24"
                                                        viewBox="0 0 22 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17.3308 11.7869H19.0049C19.3833 11.7869 19.6913 11.479 19.6913 11.1005V9.42642C19.6913 9.04795 19.3833 8.74003 19.0049 8.74003H17.3308Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                    <span>{{ optional($res->created_at)->format('M d , Y') }}</span>
                                                </li>
                                                @if ($res->mime)
                                                    <li>
                                                        <svg class="td_accent_color" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <g>
                                                                <path
                                                                    d="M12 24C18.616 24 24 18.616 24 12C24 5.38401 18.6161 0 12 0C5.38394 0 0 5.38401 0 12C0 18.616 5.38401 24 12 24Z"
                                                                    fill="currentColor" />
                                                            </g>
                                                        </svg>
                                                        <span>{{ $res->mime }}</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <h2 class="td_card_title td_fs_20 td_semibold td_mb_20">
                                            <a href="{{ route('resources-details', $res->id) }}">
                                                {{ $res->name }}
                                            </a>
                                        </h2>
                                        <span class="td_card_location td_medium td_heading_color">
                                            <svg class="td_accent_color" width="16" height="22"
                                                viewBox="0 0 16 22" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.0004 0.5C3.86669 0.5 0.554996 3.86526 0.500458 7.98242C0.48345 9.42271 0.942105 10.7046 1.56397 11.8232C2.76977 13.9928 4.04435 16.8182 5.32856 19.4639C5.9286 20.7002 6.89863 21.5052 8.0004 21.5Z"
                                                    fill="currentColor" />
                                            </svg>
                                            {{ $res->type?->name ?? 'Resource' }}
                                            @if ($res->year)
                                                • {{ $res->year }}
                                            @endif
                                        </span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateHeroFromItem(el) {
                var ds = el.dataset || {};

                var img = document.getElementById('res-hero-img');
                var pdf = document.getElementById('res-hero-pdf');
                var icon = document.getElementById('res-hero-icon');
                var link = document.getElementById('res-hero-link');
                var title = document.getElementById('res-hero-title');
                var type = document.getElementById('res-hero-type');
                var date = document.getElementById('res-hero-date');
                var mime = document.getElementById('res-hero-mime');
                var meta = document.getElementById('res-hero-meta');
                var extEl = document.getElementById('res-hero-ext');
                var cta = document.getElementById('res-hero-cta');

                var isImage = ds.isImage === '1';
                var ext = (ds.ext || '').toLowerCase();
                var isPdf = !isImage && ext === 'pdf';

                if (img) img.style.display = 'none';
                if (pdf) pdf.style.display = 'none';
                if (icon) icon.style.display = 'none';

                if (isImage && ds.src && img) {
                    img.src = ds.src;
                    img.style.display = 'block';
                } else if (isPdf && ds.src && pdf) {
                    pdf.src = ds.src + '#page=1&view=FitH';
                    pdf.style.display = 'block';
                } else if (icon) {
                    icon.style.display = 'flex';
                }

                if (title) title.textContent = ds.title || '';
                if (type) type.textContent = (ds.type || 'Resource') + (ds.year ? ' • ' + ds.year : '');
                if (date) date.textContent = ds.date || '';
                if (mime) mime.textContent = ds.mime || (ds.ext || 'file');

                var label = (ds.ext || ds.mime || 'file').toUpperCase();
                if (extEl) extEl.textContent = label;

                if (meta) {
                    var parts = [];
                    if (ds.type) parts.push(ds.type);
                    if (ds.year) parts.push(ds.year);
                    if (ds.mime) parts.push(ds.mime);
                    meta.textContent = parts.join(' • ');
                }

                if (cta && ds.detailsUrl) cta.href = ds.detailsUrl;
                if (link && ds.detailsUrl) link.href = ds.detailsUrl;
            }

            document
                .querySelectorAll('#home-resources .js-res-item')
                .forEach(function(item) {
                    item.addEventListener('mouseenter', function() {
                        updateHeroFromItem(item);
                    });
                });
        });
    </script>

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

    <section id="home-video-contact">
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
                        {{ __('Take a Video Tour to Learn Intro of Campus') }}
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
                    {{ __('or') }}
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

    <!-- Start Accreditation Showcase -->
    <section id="home-accreditations">
        <div class="td_height_112 td_height_lg_75"></div>

        <style>
            /* Sol tərəfdə 2 kart sığması üçün featured kartı kiçildir */
            #home-accreditations .left-stack {
                display: flex;
                flex-direction: column;
                gap: 24px;
            }

            #home-accreditations .left-featured .td_card_thumb {
                margin-bottom: 18px !important;
            }

            #home-accreditations .left-featured .td_card_thumb img {
                height: 240px;
                /* ƏVVƏL daha böyük idi, indi kiçildirik */
                width: 100%;
                object-fit: cover;
            }

            #home-accreditations .left-featured .td_card_title {
                margin-bottom: 10px !important;
            }

            #home-accreditations .left-featured .td_mb_24 {
                margin-bottom: 14px !important;
            }

            #home-accreditations .left-featured .td_fs_32 {
                font-size: 26px !important;
            }

            /* başlıq biraz kiçik */

            /* 2-ci sol kart daha kompakt olsun */
            #home-accreditations .left-second .td_card_thumb img {
                height: 200px;
                width: 100%;
                object-fit: cover;
            }

            #home-accreditations .left-second .td_fs_22 {
                font-size: 20px !important;
            }

            #home-accreditations .left-second .td_mb_16 {
                margin-bottom: 10px !important;
            }
        </style>

        <div class="container">

            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    {{ __('Accreditations') }}
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">{{ __('Recognitions & Partnerships') }}</h2>
            </div>

            <div class="td_height_50 td_height_lg_50"></div>

            @if (isset($accreds) && $accreds->count())
                @php
                    $hero = $accreds->first();
                    $leftSecond = $accreds->skip(1)->first();
                    $rightItems = $accreds->skip(1); // sağ tərəf əvvəlki kimi qalsın (sən dedin ora toxunmuruq)

                    // description-un ilk sözünü çıxarma helper-i
                    $firstWordFromDesc = function ($item) {
                        $txt = trim(strip_tags($item->description ?? ''));
                        if ($txt === '') {
                            return 'Accreditation';
                        }
                        // ilk söz (boşluğa qədər)
                        return strtok($txt, " \n\r\t");
                    };

                    $heroTitle = $firstWordFromDesc($hero);
                    $leftSecondTitle = $leftSecond ? $firstWordFromDesc($leftSecond) : null;
                @endphp

                <div class="row td_gap_y_30">
                    <!-- Left: 2 cards -->
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="left-stack">

                            <!-- Featured (but smaller) -->
                            <div class="td_card td_style_1 td_radius_5 left-featured">
                                <a href="{{ route('about') }}#accreditations" class="td_card_thumb d-block">
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
                                                    <span>{{ optional($hero->created_at)->format('M d, Y') }}</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <h2 class="td_card_title td_fs_32 td_semibold">
                                            <a href="{{ route('about') }}#accreditations">{{ $heroTitle }}</a>
                                        </h2>

                                        <p class="td_fs_18 td_mb_24">
                                            {{ Str::limit(strip_tags($hero->description ?? ''), 180) ?: 'International recognition and partnership highlight.' }}
                                        </p>

                                        <a href="{{ route('about') }}#accreditations"
                                            class="td_btn td_style_1 td_radius_10 td_medium">
                                            <span class="td_btn_in td_white_color td_accent_bg">
                                                <span>Learn More</span>
                                                <svg width="19" height="20" viewBox="0 0 19 20"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Second card under it -->
                            @if ($leftSecond)
                                <div class="td_card td_style_1 td_radius_5 left-second">
                                    <a href="{{ route('about') }}#accreditations" class="td_card_thumb d-block">
                                        <img src="{{ $leftSecond->imageUrl ?: asset('assets/img/others/faq_bg_1.jpg') }}"
                                            alt="Accreditation">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        <span class="td_card_location td_medium td_white_color td_fs_18">
                                            <svg width="16" height="22" viewBox="0 0 16 22" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.0004 0.5C3.86669 0.5..." fill="currentColor" />
                                            </svg>
                                            {{ optional($leftSecond->created_at)->format('M d, Y') }}
                                        </span>
                                    </a>

                                    <div class="td_card_info">
                                        <div class="td_card_info_in">
                                            <h3 class="td_fs_22 td_semibold td_mb_10">
                                                <a
                                                    href="{{ route('about') }}#accreditations">{{ $leftSecondTitle }}</a>
                                            </h3>

                                            <p class="td_fs_16 td_heading_color td_opacity_8 td_mb_16">
                                                {{ Str::limit(strip_tags($leftSecond->description ?? ''), 110) ?: 'Recognition / partnership details.' }}
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
                            @endif

                        </div>
                    </div>

                    <!-- Right: əvvəlki kimi qalır (sən dedin ora toxunmuruq) -->
                    <div class="col-lg-6 td_gap_y_30 flex-wrap d-flex wow fadeInRight" data-wow-duration="1s"
                        data-wow-delay="0.3s">
                        @foreach ($rightItems->skip(1) as $a)
                            @php $rightTitle = $firstWordFromDesc($a); @endphp
                            <div class="td_card td_style_1 td_type_1" style="flex:1 1 100%; max-width:100%;">
                                <a href="{{ route('about') }}#accreditations" class="td_card_thumb d-block">
                                    <img src="{{ $a->imageUrl ?: asset('assets/img/others/faq_bg_1.jpg') }}"
                                        alt="Accreditation">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                                <div class="td_card_info">
                                    <div class="td_card_info_in">
                                        <h3 class="td_fs_22 td_semibold td_mb_10">
                                            <a href="{{ route('about') }}#accreditations">{{ $rightTitle }}</a>
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
                <div class="text-center text-muted">No accreditations yet.</div>
            @endif

        </div>

        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    <!-- End Accreditation Showcase -->


   <!-- Start Team Highlight (carousel) -->
<section id="home-team" class="td_heading_bg td_hobble">
  <div class="td_height_112 td_height_lg_75"></div>

  <div class="container">
    <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
      <h2 class="td_section_title td_fs_48 mb-0 td_white_color">{{ __('Learn and grow with our team') }}</h2>
      <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">{{ __('Meet our experts from HSE.AZ') }}</p>
    </div>

    <div class="td_height_50 td_height_lg_50"></div>

    @if ($teamMembers->count())
      @php
        $maleDefault =
          'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
        $femaleDefault =
          'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';
      @endphp

      <div class="js-home-team-slider">
        @foreach ($teamMembers as $member)
          @php
            $thumb = $member->imageUrl ?: ($member->gender === 'female' ? $femaleDefault : $maleDefault);

            $skills = (array) ($member->skills ?? []);
            $skills = array_values(array_filter($skills, fn($s) => !empty($s['name'])));
          @endphp

          <div class="js-home-team-slide">
            <div class="row align-items-center td_gap_y_40">
              <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <div class="td_testimonial_img_wrap">
                  <img
                    src="{{ $thumb }}"
                    alt="{{ $member->full_name }}"
                    class="td_testimonial_img"
                    style="object-fit:cover;border-radius:18px;aspect-ratio:4/3;width:100%;height:auto;"
                  >
                  <span class="td_testimonial_img_shape_1"><span></span></span>
                  <span class="td_testimonial_img_shape_2 td_accent_color td_hover_layer_3">
                    <svg width="145" height="165" viewBox="0 0 145 165" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="34" cy="150" r="15" fill="currentColor" />
                      <circle cx="15" cy="137" r="15" fill="currentColor" />
                      <circle cx="24" cy="144" r="15" fill="white" />
                    </svg>
                  </span>
                </div>
              </div>

              <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                <div class="td_white_bg td_radius_5" style="border-radius:14px;border:1px solid #eef2f7;padding:26px 24px;">
                  <div class="d-flex align-items-center gap-3 td_mb_20">
                    <div style="width:58px;height:58px;border-radius:50%;overflow:hidden;border:1px solid #eee;">
                      <img src="{{ $thumb }}" alt="{{ $member->full_name }}" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div>
                      <h3 class="td_fs_24 td_semibold td_mb_2">{{ $member->full_name }}</h3>
                      <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">{{ $member->position ?: 'Team Member' }}</p>
                    </div>
                  </div>

                  <blockquote class="td_fs_18 td_heading_color td_opacity_9" style="line-height:1.7;">
                    {!! \Illuminate\Support\Str::limit(strip_tags($member->description ?? ''), 320) ?: '-' !!}
                  </blockquote>

                  @if (count($skills))
                    <div class="td_height_10"></div>
                    @foreach (array_slice($skills, 0, 3) as $s)
                      @php $p = (int)($s['percent'] ?? 0); @endphp
                      <div class="mb-2">
                        <div class="d-flex justify-content-between td_medium">
                          <span>{{ $s['name'] }}</span><span>{{ $p }}%</span>
                        </div>
                        <div class="progress" style="height:8px;background:#f1f5f9;">
                          <div class="progress-bar td_accent_bg" role="progressbar" style="width: {{ $p }}%"></div>
                        </div>
                      </div>
                    @endforeach
                  @endif

                  <div class="d-flex gap-2 td_mt_20">
                    <a href="{{ route('team-details', $member) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                      <span class="td_btn_in td_white_color td_accent_bg"><span>View Profile</span></span>
                    </a>

                    @if ($member->email)
                      <a href="mailto:{{ $member->email }}" class="td_btn td_style_1 td_radius_10 td_medium">
                        <span class="td_btn_in td_accent_color td_white_bg"><span>Email</span></span>
                      </a>
                    @endif

                    @if ($member->phone)
                      <a href="tel:{{ preg_replace('/\s+/', '', $member->phone) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                        <span class="td_btn_in td_accent_color td_white_bg"><span>Call</span></span>
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  <div class="td_height_120 td_height_lg_80"></div>
</section>

<style>
  /* Slick dots custom style for team slider */
  #home-team .slick-dots{
    position: static !important;
    margin: 26px 0 0 0 !important;
    padding: 0 !important;

    display:flex !important;
    align-items:center;
    justify-content:center;
    gap: 10px;

    list-style:none !important;

    /* Bu hissə arxadaki pill/kolge effektini tam silir */
    background: transparent !important;
    box-shadow: none !important;
    filter: none !important;
    border: 0 !important;
  }

  /* Bazi temalarda ul:before / ul:after arxa fon cəkir, bunu da kill eliyirik */
  #home-team .slick-dots::before,
  #home-team .slick-dots::after{
    content: none !important;
    display: none !important;
  }

  #home-team .slick-dots li{
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;

    background: transparent !important;
    box-shadow: none !important;
    filter: none !important;
    border: 0 !important;
  }

  #home-team .slick-dots li::before,
  #home-team .slick-dots li::after{
    content: none !important;
    display: none !important;
  }

  #home-team .slick-dots li button{
    width: 9px;
    height: 9px;
    border-radius: 999px;
    border: none !important;
    padding: 0;
    background: rgba(255,255,255,0.35);

    cursor: pointer;
    font-size: 0;
    line-height: 0;
    outline: none;

    /* Bütün kölgələri söndür */
    box-shadow: none !important;
    filter: none !important;

    transition: all 0.25s ease;
  }

  /* Slick-in default number/dot pseudo elementini söndür */
  #home-team .slick-dots li button::before{
    content: none !important;
    display:none !important;
  }

  #home-team .slick-dots li.slick-active button{
    width: 24px;
    height: 9px;
    background: #ff7a3c;

    /* Active dot-un da arxa kölgəsini söndür (səndəki "halo" burdan gəlirdi) */
    box-shadow: none !important;
    filter: none !important;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof jQuery === 'undefined' || typeof jQuery.fn.slick !== 'function') return;

    const $slider = jQuery('.js-home-team-slider');
    if (!$slider.length) return;

    if ($slider.hasClass('slick-initialized')) {
      $slider.slick('unslick');
    }

    $slider.slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      dots: true,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 400,
      adaptiveHeight: true,

      pauseOnHover: false,
      pauseOnFocus: false,
      pauseOnDotsHover: false,
    });

    $slider.slick('slickPlay');
  });
</script>
<!-- End Team Highlight -->



    {{-- Start Departments Section (settings-driven) --}}
    @php

        $deps = setting('home.departments', []);
        $kicker = data_get($deps, 'kicker', 'Departments');
        $title = data_get($deps, 'title', 'Popular Departments');
        $subtitle = data_get($deps, 'subtitle', null);
        $list = array_values(array_slice(data_get($deps, 'list', []), 0, 8));

        $toUrl = function (?string $path): string {
            if (!$path) {
                return '';
            }
            return Str::startsWith($path, ['http', '/storage', 'assets/'])
                ? asset($path)
                : asset('storage/' . ltrim($path, '/'));
        };

        $baseList = $list;

        if (count($baseList) && count($baseList) < 6) {
            while (count($baseList) < 6) {
                $baseList = array_merge($baseList, $list);
            }
        }

        $loopList = array_merge($baseList, $baseList);
    @endphp

    <style>
        .td_departments_title {
            font-size: 34px;
            line-height: 1.2;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        /* Sadə scroller */
        .td_departments_scroller {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding: 8px 0;
        }

        .td_departments_track {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 20px;
            width: max-content;
            animation: departmentsScrollPlain 35s linear infinite;
        }

        @keyframes departmentsScrollPlain {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .td_departments_item {
            flex: 0 0 auto;
            text-align: center;
        }

        .td_departments_img {
            display: block;
            width: 130px;
            height: 130px;
            object-fit: cover;
        }

        .td_departments_title_text {
            margin-top: 6px;
            font-size: 14px;
            color: #ffffff;
            opacity: 0.9;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .td_departments_title {
                font-size: 26px;
            }

            .td_departments_img {
                width: 100px;
                height: 100px;
            }

            .td_departments_title_text {
                font-size: 13px;
            }
        }
    </style>

    <section id="home-departments" style="background:transparent!important;">
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

                <h2 class="td_section_title td_departments_title mb-0">
                    {{ $title }}
                </h2>

                @if ($subtitle)
                    <p class="td_section_subtitle td_fs_18 mb-0">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>

            <div class="td_height_50 td_height_lg_50"></div>

            {{-- Sadə şəkillər, eyni ölçüdə, slider --}}
            <div class="td_departments_scroller">
                <div class="td_departments_track">
                    @foreach ($loopList as $i => $it)
                        @php
                            $itTitle = data_get($it, 'title', '');
                            $icon = $toUrl(data_get($it, 'icon'));
                        @endphp

                        <div class="td_departments_item">
                            @if ($icon)
                                <img src="{{ $icon }}" alt="{{ $itTitle }}"
                                    class="td_departments_img">
                            @endif

                            @if ($itTitle)
                                <div class="td_departments_title_text">
                                    {{ $itTitle }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="td_height_120 td_height_lg_80"></div>
    </section>
    {{-- End Departments Section --}}

    @php
        // Sosial şəbəkələr
        $fb = setting('social.facebook');
        $tw = setting('social.twitter');
        $ig = setting('social.instagram');
        $pin = setting('social.pinterest'); // fallback üçün saxlayırıq
        $wa = setting('social.whatsapp'); // tercihen wa.me/…

        // LinkedIn: varsa onu götür, yoxdursa Pinterest URL-ni istifadə et
        $li = setting('social.linkedin', $pin);

        // Linkləri təhlükəsiz açmaq üçün atributlar
        $attrs = 'target="_blank" rel="noopener noreferrer"';

        // Sayt məlumatları
        $siteName = setting('site.name', 'Educve');
        $phone = setting('site.phone');
        $email = setting('site.email');
        $address = setting('site.address');
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

        // Footer qalereyası üçün son şəkillər (gallery_images cədvəlindən)
        $footerGallery = \App\Models\GalleryImage::query()->latest()->take(6)->get();
    @endphp


    @include('partials.chat-switcher')
    @auth
        @if (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin())
            @include('partials.admin-shortcut')
        @endif
    @endauth

    <footer class="td_footer td_style_1">



        <div class="container">
            <div class="td_footer_row">
                {{-- 1. Sütun: Logo, mətn, kontakt, sosial ikonlar --}}
                <div class="td_footer_col">
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

                            {{-- Tagline settings-dən (site.tagline) gəlir --}}
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

                        {{-- Sosial ikonlar --}}
                        @if ($fb || $tw || $ig || $li || $wa)
                            <div class="td_footer_social_btns td_fs_20 mt-3">
                                @if ($fb)
                                    <a href="{{ $fb }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                @endif

                                @if ($tw)
                                    <a href="{{ $tw }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                @endif

                                @if ($ig)
                                    <a href="{{ $ig }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                @endif

                                {{-- Pinterest göstərilmir, onun yerinə LinkedIn (Pinterest URL fallback kimi) --}}
                                @if ($li)
                                    <a href="{{ $li }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                @endif

                                @if ($wa)
                                    <a href="{{ $wa }}" class="td_center" {!! $attrs !!}>
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 2. Sütun: Naviqasiya --}}
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                            {{ __('Navigateion') }}
                        </h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('faqss') }}">{{ __('Faqs') }}</a></li>
                            <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                            <li><a href="{{ route('resources') }}">{{ __('Resources') }}</a></li>
                            <li><a href="{{ route('team') }}">{{ __('Team') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                        </ul>
                    </div>
                </div>

                {{-- 3. Sütun: Courses / Services / Topics / Vacancies --}}
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                            {{ __('Courses') }}
                        </h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="{{ route('courses-grid-view') }}">{{ __('Courses') }}</a></li>
                            <li><a href="{{ route('services') }}">{{ __('Services') }}</a></li>
                            <li><a href="{{ route('topices') }}">{{ __('Topics') }}</a></li>
                            <li><a href="{{ route('vacancies') }}">{{ __('Vacancies') }}</a></li>
                        </ul>
                    </div>
                </div>

                {{-- 4. Sütun: Subscribe + Copyright --}}
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">
                            {{ __('Subscribe now') }}
                        </h2>
                        <div class="td_newsletter td_style_1">
                            <p class="td_mb_20 td_opacity_7">
                                {{ __('Far far away, behind the word mountains, far from the Consonantia, there live the blind texts.') }}
                            </p>
                            <form class="td_newsletter_form" action="{{ route('subscribe') }}" method="POST"
                                id="newsletterForm">
                                @csrf
                                <input type="email" name="email" class="td_newsletter_input"
                                    placeholder="Email address" required>
                                <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg">
                                        <span>{{ __('Subscribe now') }}</span>
                                    </span>
                                </button>
                            </form>

                            @if (session('sub_ok'))
                                <div class="alert alert-success mt-2">{{ session('sub_ok') }}</div>
                            @endif
                        </div>

                        {{-- Burada əvvəl qalereya vardı, indi onun yerinə footer_bottom kontenti gəlir --}}
                        <div class="td_footer_bottom_widget td_fs_18 mt-4">
                            <div class="td_footer_bottom_in d-flex flex-wrap gap-2 align-items-center">
                                <p class="td_copyright mb-0">
                                    © {{ date('Y') }} {{ $siteName }} · {{ __('All rights reserved') }}
                                </p>
                                <ul class="td_footer_widget_menu d-flex flex-wrap gap-3 mb-0">
                                    <li><a href="#">{{ __('Terms & Conditions') }}</a></li>
                                    <li><a href="#">{{ __('Privacy & Policy') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>



            </div> {{-- .td_footer_row --}}
            {{-- GalleryImages qalereyası: bütün şəkillər eyni blok ölçüsündə, kəsilmədən görünür (artıq full-width bar) --}}
            @if ($footerGallery->count())
                <div class="td_footer_gallery_bar py-4">
                    <div class="container">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                            {{-- Sol tərəf: mətn --}}
                            <div class="td_footer_gallery_text">
                                <h3 class="td_fs_20 td_white_color td_medium mb-1">
                                    Lisenziyası qəbul olunan şirkətlər
                                </h3>
                                <p class="mb-0 td_opacity_7 td_fs_16">
                                    Təlim və sertifikatlarımız aşağıdakı təşkilatlar tərəfindən tanınır.
                                </p>
                            </div>

                            {{-- Sağ tərəf: şəkillər --}}
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                @foreach ($footerGallery as $g)
                                    <a href="{{ $g->image }}" target="_blank" rel="noopener noreferrer"
                                        class="td_footer_gallery_item">
                                        <img src="{{ $g->image }}"
                                            alt="Gallery image {{ $loop->iteration }}"
                                            style="
                                    width: 110px;
                                    height: 80px;
                                    object-fit: contain;
                                    background: #111;
                                    padding: 4px;
                                    border-radius: 10px;
                                 ">
                                    </a>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            @endif



        </div> {{-- .container --}}
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


    <script>
        (function() {
            function switchLocale(targetLocale) {
                var locales = ['az', 'en', 'ru'];
                var path = window.location.pathname;
                var parts = path.replace(/^\/+/, '').split('/'); // remove leading slash then split
                if (parts.length && locales.indexOf(parts[0]) !== -1) {
                    parts[0] = targetLocale; // replace existing locale
                } else {
                    parts.unshift(targetLocale); // prepend locale
                }
                var newPath = '/' + parts.join('/');
                var qs = window.location.search || '';
                var hash = window.location.hash || '';
                window.location.href = newPath + qs + hash;
            }
            document.addEventListener('click', function(e) {
                var a = e.target.closest('a.js-lang');
                if (a) {
                    e.preventDefault();
                    var loc = a.getAttribute('data-locale');
                    if (loc) {
                        switchLocale(loc);
                    }
                }
            }, {
                passive: false
            });
        })();
    </script>

    {{-- ===== Scroll-driven GUIDE (Settings-based) ===== --}}
    @php
        // Settings-dən gələn addımlar
        $guideSections = collect(setting('ui.guides.index.sections', []))
            ->map(function ($s) {
                return [
                    'sel' => trim((string) ($s['selector'] ?? '')),
                    'title' => trim((string) ($s['title'] ?? '')),
                    'text' => trim((string) ($s['text'] ?? '')),
                ];
            })
            ->filter(fn($s) => $s['sel'] && $s['title'] && $s['text'])
            ->values()
            ->all();

        // Fallback (əgər settings boşdursa) — 10-luq default
        $fallbackSteps = [
            [
                'sel' => '#home-hero',
                'title' => 'Başlanğıc paneli',
                'text' =>
                    'Ana vitrin: əsas dəyər təklifi, qısa izah və hərəkətə çağırışlar (CTA). Buradan istifadəçi ən qısa marşrutla kurslara və ya müraciətə yönlənir.',
            ],
            [
                'sel' => '#home-about',
                'title' => 'Haqqımızda (qısa icmal)',
                'text' =>
                    'Missiya, yanaşma və əsas üstünlüklər. İki şəkilli kompozisiya və dairəvi video düyməsi vizual etibarı yüksəldir; CTA isə uzun “About” səhifəsinə aparır.',
            ],
            [
                'sel' => '#home-courses',
                'title' => 'Populyar kurslar',
                'text' =>
                    'Tablarla “Courses/Services/Topics/Vacancies” bölmələrinə keçid. Kartlar vahid hündürlükdədir, başlıq və təsvir clamp olunub; “View Details” konversiyanı sadələşdirir.',
            ],
            [
                'sel' => '#home-features',
                'title' => 'Üstünlüklər (Campus)',
                'text' =>
                    'Şəkil + mətn kombinasiyası ilə dəyər təklifi: infrastruktur, mentor dəstəyi, praktik layihələr və ölçülə bilən nəticələr. 4 maddəlik siyahı fokus yaradır.',
            ],
            [
                'sel' => '#home-campus',
                'title' => 'Naviqasiya kartları',
                'text' =>
                    'Dörd istiqamətə sürətli keçid üçün mozaika kartlar. Hər kartda vizual vurğu, başlıq və kliklə dərhal yönləndirmə — “keçid sürəti” əsas prioritetdir.',
            ],
            [
                'sel' => '#home-resources',
                'title' => 'Resurslar & Yükləmələr',
                'text' =>
                    'Materiallar PDF/image/video kimi avtomatik önbaxışla göstərilir (pdf.js dəstəyi). “Featured” resurs solda, sağda isə üç kompakt kart — sürətli seçim üçün.',
            ],
            [
                'sel' => '#home-video-contact',
                'title' => 'Video təqdimat + əlaqə',
                'text' =>
                    'Qısa tanıtım videosu brend tonunu çatdırır; alt hissədə e-poçt və telefon üçün iri CTA qutuları var. Hədəf: sual yaranan kimi minimal sürtünmə ilə əlaqə.',
            ],
            [
                'sel' => '#home-accreditations',
                'title' => 'Akkreditasiyalar',
                'text' =>
                    'Tərəfdaşlıq və tanınmalar: solda “featured” loqo + tarix, sağda kompakt kartlar. Sosial sübut rolunu oynayır və şübhəni azaldır.',
            ],
            [
                'sel' => '#home-team',
                'title' => 'Komanda hekayəsi',
                'text' =>
                    'Ön plana çıxarılan ekspertin foto, qısa bio və bacarıq səviyyələri (progress bar). Yanındakı sürətli əməl düymələri “View Profile / Email / Call” verir.',
            ],
            [
                'sel' => '#home-departments',
                'title' => 'Fakültələr',
                'text' =>
                    '8-lik grid: hər bölmə üçün ikon + başlıq. “Birdən çox maraq nöqtəsi” ssenarisində istifadəçiyə geniş baxış imkanı yaradır.',
            ],
        ];
    @endphp

    <style>
        .guide-bubble {
            position: fixed;
            right: 18px;
            bottom: 78px;
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

        @media (max-width: 575.98px) {
            .guide-bubble {
                left: 12px;
                right: 12px;
                bottom: 12px;
            }
        }
    </style>

    <script>
        (function() {
            // Settings-dən gələn addımlar (əgər boşdursa fallback istifadə olunur)
            const STEPS = @json($guideSections ?: $fallbackSteps, JSON_UNESCAPED_UNICODE);

            // DOM-nu yüklə
            const els = STEPS.map(s => document.querySelector(s.sel));

            // Bubble UI
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

            // Ekranda ən çox görünən section-u seç
            function chooseMostVisible() {
                const vh = innerHeight || document.documentElement.clientHeight;
                let bestIdx = 0,
                    bestScore = -1;
                els.forEach((el, idx) => {
                    if (!el) return;
                    const r = el.getBoundingClientRect();
                    const vis = Math.max(0, Math.min(vh, r.bottom) - Math.max(0, r.top)); // görünən hündürlük
                    const score = vis * (r.width || 1);
                    if (score > bestScore) {
                        bestScore = score;
                        bestIdx = idx;
                    }
                });
                setActive(bestIdx);
            }

            // Observer + scroll
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

            // İlk aktivləşdirmə
            chooseMostVisible();
        })();
    </script>


</body>

</html>
