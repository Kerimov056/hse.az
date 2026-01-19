<!DOCTYPE html>
<html class="no-js" lang="en">
@php
    $siteName = setting('site.name', 'Educve');
    $phone = setting('site.phone');
    $email = setting('site.email');
    $address = setting('site.address');
    $tagline = setting(
        'site.tagline',
        'Far far away, behind the word mountains, far from the Consonantia, there live the blind texts.',
    );

    $logoPath = setting('site.logo') ?: setting('branding.logo');
    $logoUrl = null;
    if ($logoPath) {
        $logoUrl = \Illuminate\Support\Str::startsWith($logoPath, ['http', '/storage', 'assets/'])
            ? asset($logoPath)
            : asset('storage/' . ltrim($logoPath, '/'));
    }

    $telHref = $phone ? 'tel:' . preg_replace('/[^0-9\+]+/', '', $phone) : null;
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="ThemeDox">
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}">
    <title>Educve | Online Education Platform</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        referrerpolicy="no-referrer" />
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

    {{-- ================= HEADER ================= --}}
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
    {{-- ================= END HEADER ================= --}}

    {{-- VERTICAL SOCIAL RAIL --}}

</body>



</html>
