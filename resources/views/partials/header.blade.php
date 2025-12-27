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

    <style>
        /* ================== GLOBAL CONTAINER ================== */
        .td_site_header .container {
            max-width: 1400px;
            padding-left: 100px;
            padding-right: 100px;
        }

        @media (max-width: 1200px) {
            .td_site_header .container {
                padding-left: 24px;
                padding-right: 24px;
            }
        }

        @media (max-width: 768px) {
            .td_site_header .container {
                padding-left: 16px;
                padding-right: 16px;
            }
        }

        /* ================== TOP BAR ================== */

        .td_top_header_in {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            width: 100%;
        }

        .td_top_header_left {
            flex: 1 1 auto;
            min-width: 0;
        }

        .td_top_header_right {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 16px;
            white-space: nowrap;
        }

        .typed-text {
            font-weight: 600;
            font-size: 14px;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
        }

        .ticker-line {
            position: relative;
            overflow: hidden;
            white-space: nowrap;
        }

        .ticker-inner {
            display: inline-block;
            will-change: transform;
        }

        .ticker-line.is-scrolling .ticker-inner {
            animation: ticker-scroll 22s linear infinite;
        }

        @keyframes ticker-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .top-lang-search {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-lang-select {
            padding: 4px 10px;
            border-radius: 999px;
            border: 0;
            font-size: 13px;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .top-lang-select:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, .4);
        }

        .top-search-btn {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            border: 0;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .top-search-btn img {
            width: 15px;
            height: 15px;
        }

        .top-quick-toggle {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 0;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .top-quick-toggle span {
            display: block;
            width: 14px;
            height: 2px;
            border-radius: 999px;
            background: #fff;
            position: relative;
        }

        .top-quick-toggle span::before,
        .top-quick-toggle span::after {
            content: "";
            position: absolute;
            left: 0;
            width: 100%;
            height: 2px;
            border-radius: 999px;
            background: #fff;
        }

        .top-quick-toggle span::before {
            top: -4px;
        }

        .top-quick-toggle span::after {
            top: 4px;
        }

        @media (max-width: 768px) {
            .td_top_header_in {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .td_top_header_right {
                width: 100%;
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .top-lang-search {
                order: 2;
            }
        }

        /* ================== MAIN HEADER ================== */

        .td_main_header_in {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .td_main_header_left {
            flex: 0 0 auto;
            display: flex;
            align-items: flex-end;
        }

        .td_site_branding {
            display: inline-flex;
            align-items: center;
        }

        .td_site_branding img {
            height: 54px;
            width: auto;
            display: block;
            margin-top: 4px;
        }

        .td_main_header_right {
            flex: 1 1 auto;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            min-width: 0;
        }

        .td_nav {
            flex: 1 1 auto;
            min-width: 0;
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
            flex-wrap: wrap;
        }

        .td_nav_list>li {
            position: relative;
        }

        .td_nav_list>li>a {
            display: inline-block;
            padding: 10px 4px;
        }

        .td_hero_icon_btns {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
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
            transition: background .2s ease, border-color .2s ease, transform .15s ease;
        }

        .td_circle_btn:hover {
            background: rgba(15, 23, 42, .10);
            border-color: rgba(15, 23, 42, .12);
            transform: translateY(-1px);
        }

        #globalSearch {
            position: relative;
        }

        /* SEARCH DROPDOWN: bigger panel + full width results */
        #globalSearchResults {
            position: relative;
            top: auto;
            right: auto;
            left: auto;
            min-width: 100%;
            max-width: 100%;
            background: #f8fafc;
            border-radius: 12px;
            box-shadow: inset 0 0 0 1px #e2e8f0;
            z-index: 70;
            padding: 4px 0;
            height: 320px;
            overflow-y: auto;
            margin-top: 8px;
            font-size: 14px;
        }

        #globalSearchResults .gsearch-dropdown {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        #globalSearchResults .gsearch-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
            cursor: pointer;
            background: #ffffff;
            transition: background .15s ease, box-shadow .15s ease, transform .1s ease;
        }

        #globalSearchResults .gsearch-item:last-child {
            border-bottom: none;
        }

        #globalSearchResults .gsearch-item:hover {
            background: #edf2ff;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.12);
            transform: translateY(-1px);
        }

        #globalSearchResults img {
            max-width: 56px;
            max-height: 56px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            display: block;
        }

        #globalSearchResults .gsearch-title {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 2px;
        }

        #globalSearchResults .gsearch-meta {
            font-size: 12px;
            color: #64748b;
        }

        #globalSearchResults .gsearch-empty {
            padding: 8px 12px;
            font-size: 13px;
            color: #64748b;
        }

        /* Desktop language next to search */
        .header-lang-desktop {
            display: flex;
            align-items: center;
            margin-left: 4px;
        }

        .header-lang-desktop .top-lang-select {
            background: rgba(15, 23, 42, .04);
            color: #0f172a;
            border: 1px solid rgba(15, 23, 42, .10);
        }

        @media (max-width: 992px) {
            .td_main_header_in {
                flex-direction: column;
                align-items: flex-start;
            }

            .td_main_header_left {
                width: 100%;
                justify-content: space-between;
                margin-bottom: 6px;
            }

            .td_main_header_right {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .td_nav {
                width: 100%;
            }

            .td_nav_list {
                width: 100%;
                row-gap: 4px;
                column-gap: 16px;
            }

            .td_hero_icon_btns {
                align-self: flex-end;
            }

            /* hide desktop lang on mobile */
            .header-lang-desktop {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .td_site_branding img {
                height: 44px;
            }

            .td_nav_list>li>a {
                padding: 8px 2px;
                font-size: 14px;
            }

            .td_nav_list {
                overflow-x: auto;
                white-space: nowrap;
                flex-wrap: nowrap;
            }
        }

        /* ================== VERTICAL SOCIAL BAR ================== */

        .header-social-rail {
            position: fixed;
            right: 18px;
            top: 40%;
            transform: translateY(-50%);
            z-index: 80;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .header-social-rail a {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.9);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .3);
        }

        .header-social-rail a:hover {
            opacity: .9;
        }

        @media (max-width: 768px) {
            .header-social-rail {
                display: none;
            }
        }

        .td_header_search {
            width: auto !important;
        }
    </style>

    {{-- ================= HEADER ================= --}}
    <header class="td_site_header td_style_1 td_type_2 td_sticky_header td_medium td_heading_color">

        <style>
            .td_site_header .container {
                max-width: 1400px;
                padding-left: 100px;
                padding-right: 100px;
            }

            @media (max-width: 1200px) {
                .td_site_header .container {
                    padding-left: 24px;
                    padding-right: 24px;
                }
            }

            @media (max-width: 768px) {
                .td_site_header .container {
                    padding-left: 16px;
                    padding-right: 16px;
                }
            }

            .td_top_header_in {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                width: 100%;
            }

            .td_top_header_left {
                flex: 1 1 auto;
                min-width: 0;
            }

            .td_top_header_right {
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                gap: 12px;
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            @media (max-width: 768px) {
                .td_top_header_in {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 8px;
                }

                .td_top_header_right {
                    width: 100%;
                    justify-content: space-between;
                }
            }

            .td_main_header_in {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                width: 100%;
            }

            .td_main_header_left {
                flex: 0 0 auto;
                display: flex;
                align-items: center;
            }

            .td_site_branding {
                display: inline-flex;
                align-items: center;
            }

            .td_site_branding img {
                height: 54px;
                width: auto;
                display: block;
                margin-top: 4px;
            }

            .td_main_header_right {
                flex: 1 1 0%;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                min-width: 0;
            }

            .td_nav_list_wrap_in {
                display: block;
            }

            .td_nav_list {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 16px 18px;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .td_nav_list>li {
                position: relative;
                margin: 0;
            }

            .td_nav_list>li>a {
                display: inline-block;
                padding: 10px 4px;
                font-size: 15px;
                position: relative;
                text-decoration: none;
            }

            .td_nav_list>li>a::after {
                content: "";
                position: absolute;
                left: 0;
                bottom: 2px;
                width: 0;
                height: 2px;
                border-radius: 999px;
                background: #0f172a;
                transition: width .18s ease;
            }

            .td_nav_list>li:hover>a::after,
            .td_nav_list>li>a.active::after {
                width: 100%;
            }

            .td_hero_icon_btns {
                flex: 0 0 auto;
                display: flex;
                align-items: center;
                gap: 8px;
                position: relative;
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
                transition: background .2s ease, border-color .2s ease, transform .15s ease;
            }

            .td_circle_btn:hover {
                background: rgba(15, 23, 42, .10);
                border-color: rgba(15, 23, 42, .12);
                transform: translateY(-1px);
            }

            #globalSearchResults {
                position: relative;
                top: auto;
                right: auto;
                left: auto;
                min-width: 100%;
                max-width: 100%;
                background: #f8fafc;
                border-radius: 12px;
                box-shadow: inset 0 0 0 1px #e2e8f0;
                z-index: 70;
                padding: 4px 0;
                height: 320px;
                overflow-y: auto;
                margin-top: 8px;
                font-size: 14px;
            }

            #globalSearchResults .gsearch-dropdown {
                display: flex;
                flex-direction: column;
                gap: 4px;
                top: 0% !important;
            }

            #globalSearchResults .gsearch-item {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                padding: 8px 12px;
                border-bottom: 1px solid #e2e8f0;
                cursor: pointer;
                background: #ffffff;
                transition: background .15s ease, box-shadow .15s ease, transform .1s ease;
            }

            #globalSearchResults .gsearch-item:last-child {
                border-bottom: none;
            }

            #globalSearchResults .gsearch-item:hover {
                background: #edf2ff;
                box-shadow: 0 4px 10px rgba(15, 23, 42, 0.12);
                transform: translateY(-1px);
            }

            #globalSearchResults img {
                max-width: 56px;
                max-height: 56px;
                border-radius: 8px;
                object-fit: cover;
                flex-shrink: 0;
                display: block;
            }

            #globalSearchResults .gsearch-title {
                font-weight: 600;
                color: #0f172a;
                margin-bottom: 2px;
            }

            #globalSearchResults .gsearch-meta {
                font-size: 12px;
                color: #64748b;
            }

            #globalSearchResults .gsearch-empty {
                padding: 8px 12px;
                font-size: 13px;
                color: #64748b;
            }

            /* Desktop lang near search */
            .header-lang-desktop {
                display: flex;
                align-items: center;
                margin-left: 4px;
            }

            .header-lang-desktop .top-lang-select {
                background: rgba(15, 23, 42, .04);
                color: #0f172a;
                border: 1px solid rgba(15, 23, 42, .10);
            }

            /* Mobile only row inside nav for search + lang */
            .nav-utility-row {
                display: none;
                width: 100%;
            }

            .nav-utility-content {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 8px;
                padding: 4px 0;
            }

            .nav-utility-content .top-lang-select {
                background: rgba(15, 23, 42, .04);
                color: #0f172a;
                border: 1px solid rgba(15, 23, 42, .10);
            }

            @media (max-width: 992px) {
                .td_main_header_in {
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                }

                .td_main_header_left {
                    width: 100%;
                    justify-content: center;
                    margin-bottom: 6px;
                }

                .td_main_header_right {
                    width: 100%;
                    flex-direction: column;
                    align-items: stretch;
                    gap: 10px;
                }

                .td_nav {
                    width: 100%;
                }

                .td_nav_list {
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 4px;
                    margin: 0;
                    padding: 0;
                    list-style: none;
                    overflow-x: visible;
                    white-space: normal;
                }

                .td_nav_list>li {
                    width: 100%;
                }

                .td_nav_list>li>a {
                    display: block;
                    width: 100%;
                    text-align: left;
                    padding: 10px 4px;
                    font-size: 14px;
                }

                .td_nav_list>li>a::after {
                    bottom: 0;
                }

                .td_hero_icon_btns {
                    align-self: flex-end;
                }

                .nav-utility-row {
                    display: block;
                }

                .td_header_search_wrap {
                    position: fixed !important;
                    right: 12px !important;
                    left: 12px !important;
                    top: 70px !important;
                    width: auto !important;
                    max-width: none !important;
                    z-index: 200 !important;
                }

                .header-lang-desktop {
                    display: none;
                }

                /* MOBILE submenu open/close */
                .td_nav_list>li.has-submenu>ul {
                    display: none !important;
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height .25s ease;
                    position: static !important;
                    min-width: 0 !important;
                    width: 100% !important;
                    box-shadow: none !important;
                    background: transparent !important;
                    padding: 4px 0 6px 14px !important;
                    margin: 0 !important;
                    list-style: none !important;
                }

                .td_nav_list>li.has-submenu.is-open>ul {
                    display: block !important;
                    max-height: 900px;
                }

                /* parent row layout */
                .td_nav_list>li.has-submenu>a {
                    display: flex !important;
                    align-items: center !important;
                    justify-content: space-between !important;
                    gap: 12px !important;
                }

                /* PLUS/MINUS indicator with visible border */
                .td_nav_list>li.has-submenu>a .submenu-indicator {
                    width: 30px;
                    height: 30px;
                    border-radius: 8px;
                    border: 2px solid #0f172a;
                    background: #ffffff;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: 900;
                    font-size: 18px;
                    line-height: 1;
                    color: #0f172a;
                    flex: 0 0 auto;
                    box-shadow: 0 6px 14px rgba(15, 23, 42, 0.10);
                }

                .td_nav_list>li.has-submenu>a .submenu-indicator::before {
                    content: "+";
                }

                .td_nav_list>li.has-submenu.is-open>a .submenu-indicator::before {
                    content: "-";
                }
            }

            @media (max-width: 576px) {
                .td_site_branding img {
                    height: 44px;
                    margin-top: 0;
                }

                .td_nav_list>li>a {
                    padding: 8px 4px;
                    font-size: 13px;
                }
            }

            /* Desktop submenu */
            .td_nav_list>li.has-submenu {
                position: relative;
            }

            .td_nav_list>li.has-submenu>ul {
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

            .td_nav_list>li.has-submenu:hover>ul,
            .td_nav_list>li.has-submenu.is-open>ul {
                display: block;
            }

            .td_nav_list>li.has-submenu>ul>li>a {
                display: block;
                padding: 10px 14px;
                font-size: 14px;
            }

            @media (max-width: 992px) {
                .td_nav_list>li.has-submenu:hover>ul {
                    display: none;
                }
            }
        </style>

        {{-- ==== TOP STRIP ==== --}}
        @include('partials.top-strip')

        {{-- ==== MAIN HEADER ==== --}}
        <div class="td_main_header">
            <div class="container" style="max-width:1400px!important;padding:0 16px!important;margin:0 auto!important;">
                <div class="td_main_header_in"
                    style="display:flex!important;flex-wrap:wrap!important;align-items:center!important;justify-content:space-between!important;gap:16px!important;width:100%!important;">

                    {{-- Logo --}}
                    <div class="td_main_header_left"
                        style="flex:0 0 auto!important;display:flex!important;align-items:center!important;">
                        <a class="td_site_branding td_accent_color" href="{{ route('home') }}"
                            style="display:inline-flex!important;align-items:center!important;text-decoration:none!important;">
                            <img src="{{ asset('assets/img/hse.png') }}" alt="{{ $siteName }}"
                                style="height:54px!important;width:auto!important;display:block!important;margin-top:4px!important;">
                        </a>
                    </div>

                    {{-- Nav + icons --}}
                    <div class="td_main_header_right"
                        style="flex:1 1 0%!important;display:flex!important;flex-wrap:wrap!important;align-items:center!important;justify-content:space-between!important;gap:12px!important;min-width:0!important;">

                        <nav class="td_nav"
                            style="flex:1 1 auto!important;min-width:0!important;overflow-x:visible!important;white-space:normal!important;">
                            <div class="td_nav_list_wrap">
                                <div class="td_nav_list_wrap_in">
                                    <ul class="td_nav_list">
                                        <li>
                                            <a href="{{ route('home') }}">
                                                {{ __('Home') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('faqss') }}">
                                                {{ __('Faqs') }}
                                            </a>
                                        </li>

                                        <li class="has-submenu">
                                            <a href="{{ route('about') }}">
                                                {{ __('About Us') }}
                                                <span class="submenu-indicator" aria-hidden="true"></span>
                                            </a>
                                            <ul>
                                                <li><a href="{{ route('about') }}#about-who">{{ __('Who we are') }}</a></li>
                                                <li><a href="{{ route('about') }}#about-vision-mission">{{ __('Vision & Mission') }}</a></li>
                                                <li><a href="{{ route('about') }}#about-accreditations">{{ __('Licenses & Accreditations') }}</a></li>
                                                <li><a href="{{ route('team') }}">{{ __('Team') }}</a></li>
                                                <li><a href="{{ route('faqss') }}">{{ __('FAQ') }}</a></li>
                                            </ul>
                                        </li>

                                        <li class="has-submenu">
                                            <a href="{{ route('courses-grid-view') }}">
                                                {{ __('Training') }}
                                                <span class="submenu-indicator" aria-hidden="true"></span>
                                            </a>
                                            <ul>
                                                <li><a href="{{ route('courses-grid-view') }}?q=IOSH">{{ __('IOSH') }}</a></li>
                                                <li><a href="{{ route('courses-grid-view') }}?q=NEBOSH">{{ __('NEBOSH') }}</a></li>
                                                <li><a href="{{ route('courses-grid-view') }}?q=CIEH">{{ __('CIEH') }}</a></li>
                                                <li><a href="{{ route('courses-grid-view') }}?q=IIRSM">{{ __('IIRSM') }}</a></li>
                                                <li><a href="{{ route('courses-grid-view') }}?q=NSC">{{ __('NSC') }}</a></li>
                                                <li><a href="{{ route('courses-grid-view') }}?q=Local%20Training">{{ __('Local Training') }}</a></li>
                                                <li><a href="{{ route('courses-grid-view') }}?q=E-learning">{{ __('E-learning') }}</a></li>
                                            </ul>
                                        </li>

                                        <li class="has-submenu">
                                            <a href="{{ route('resources') }}">
                                                {{ __('Resources') }}
                                                <span class="submenu-indicator" aria-hidden="true"></span>
                                            </a>
                                            <ul>
                                                <li><a href="{{ route('resources') }}?q=Reading materials">{{ __('Reading materials') }}</a></li>
                                                <li><a href="{{ route('resources') }}?q=Posters">{{ __('Posters') }}</a></li>
                                                <li><a href="{{ route('resources') }}?q=PPT training materials">{{ __('PPT training materials') }}</a></li>
                                                <li><a href="{{ route('resources') }}?q=Checklists">{{ __('Checklists') }}</a></li>
                                            </ul>
                                        </li>

                                        <li class="has-submenu">
                                            <a href="{{ route('courses-grid-view') }}">
                                                {{ __('Courses') }}
                                                <span class="submenu-indicator" aria-hidden="true"></span>
                                            </a>
                                            <ul>
                                                <li><a href="{{ route('courses-grid-view') }}">{{ __('Courses') }}</a></li>
                                                <li><a href="{{ route('services') }}">{{ __('Services') }}</a></li>
                                                <li><a href="{{ route('vacancies') }}">{{ __('Vacancies') }}</a></li>
                                            </ul>
                                        </li>

                                        <li class="has-submenu">
                                            <a href="{{ route('topices') }}">
                                                {{ __('Topics') }}
                                                <span class="submenu-indicator" aria-hidden="true"></span>
                                            </a>
                                            <ul>
                                                <li><a href="{{ route('topices') }}?q=Occupational safety">{{ __('Occupational safety') }}</a></li>
                                                <li><a href="{{ route('topices') }}?q=Occupational health">{{ __('Occupational health') }}</a></li>
                                                <li><a href="{{ route('topices') }}?q=Environemntal protection">{{ __('Environemntal protection') }}</a></li>
                                                <li><a href="{{ route('topices') }}?q=Home safety">{{ __('Home safety') }}</a></li>
                                                <li><a href="{{ route('topices') }}?q=Public safety">{{ __('Public safety') }}</a></li>
                                                <li><a href="{{ route('topices') }}?q=Travel safety">{{ __('Travel safety') }}</a></li>
                                            </ul>
                                        </li>

                                        <li><a href="{{ route('team') }}">{{ __('Team') }}</a></li>
                                        <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>

                                        {{-- MOBILE: search + language inside menu --}}
                                        <li class="nav-utility-row">
                                            <div class="nav-utility-content">
                                                <button class="td_circle_btn td_center js-open-global-search" type="button" aria-label="Search">
                                                    <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt=""
                                                        style="width:16px!important;height:16px!important;">
                                                </button>
                                                <select class="top-lang-select nav-lang-select" aria-label="Language">
                                                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                                                    <option value="az" {{ app()->getLocale() === 'az' ? 'selected' : '' }}>AZ</option>
                                                    <option value="ru" {{ app()->getLocale() === 'ru' ? 'selected' : '' }}>RU</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <div class="td_hero_icon_btns position-relative">
                            {{-- Desktop / tablet search --}}
                            <div class="position-relative" id="globalSearch" style="position:relative!important;">
                                <button class="td_circle_btn td_center td_search_tobble_btn" type="button">
                                    <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt=""
                                        style="width:16px!important;height:16px!important;">
                                </button>

                                <div class="td_header_search_wrap"
                                    style="position:absolute!important;right:0!important;top:120%!important;width:460px!important;max-width:calc(100vw - 32px)!important;background:#ffffff!important;border-radius:18px!important;box-shadow:0 18px 40px rgba(15,23,42,.22)!important;padding:12px 14px!important;display:none;">
                                    <form action="javascript:void(0)" class="td_header_search" autocomplete="off"
                                        style="display:flex!important;align-items:center!important;gap:8px!important;">
                                        <input type="text" class="td_header_search_input" id="globalSearchInput"
                                            placeholder="Search For Anything"
                                            style="flex:1 1 auto!important;border-radius:999px!important;border:1px solid #e2e8f0!important;padding:6px 12px!important;font-size:14px!important;outline:none!important;">
                                        <button class="td_header_search_btn td_center" type="submit"
                                            style="width:32px!important;height:32px!important;border-radius:999px!important;border:none!important;background:#0f172a!important;display:flex!important;align-items:center!important;justify-content:center!important;">
                                            <img src="{{ asset('assets/img/icons/search_2.svg') }}" alt=""
                                                style="width:14px!important;height:14px!important;filter:invert(1)!important;">
                                        </button>
                                    </form>

                                    <div id="globalSearchResults" style="display:none;"></div>
                                </div>
                            </div>

                            {{-- Desktop language selector --}}
                            <div class="header-lang-desktop">
                                <select class="top-lang-select" aria-label="Language">
                                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                                    <option value="az" {{ app()->getLocale() === 'az' ? 'selected' : '' }}>AZ</option>
                                    <option value="ru" {{ app()->getLocale() === 'ru' ? 'selected' : '' }}>RU</option>
                                </select>
                            </div>

                            @auth
                                <div class="position-relative ms-2" style="position:relative!important;">
                                    <button class="td_circle_btn td_center" type="button" aria-label="Profile">
                                        <img src="{{ asset('assets/img/icons/user.svg') }}" alt="User"
                                            style="width:16px!important;height:16px!important;">
                                    </button>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Global search JS --}}
        <script>
            (function() {
                const root = document.getElementById('globalSearch');
                if (!root) return;

                const input = document.getElementById('globalSearchInput');
                const box = document.getElementById('globalSearchResults');
                const wrap = root.querySelector('.td_header_search_wrap');

                let timer = null;

                function render(html) {
                    box.innerHTML = html || '';
                    box.style.display = html ? 'block' : 'none';
                    if (html) {
                        box.style.display = 'block';
                        wrap.style.display = 'block';
                    }
                }

                function search(q) {
                    if (!q || q.trim() === '') {
                        box.style.display = 'none';
                        return;
                    }
                    fetch(`{{ route('search') }}?q=${encodeURIComponent(q) }`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(r => r.json())
                        .then(({ html }) => render(html))
                        .catch(() => render('<div class="gsearch-dropdown"><div class="gsearch-empty">Error.</div></div>'));
                }

                input?.addEventListener('input', function() {
                    clearTimeout(timer);
                    const value = this.value;
                    timer = setTimeout(() => search(value), 280);
                });

                root.querySelector('form')?.addEventListener('submit', (e) => {
                    e.preventDefault();
                    search(input.value);
                });

                document.addEventListener('click', (e) => {
                    if (!root.contains(e.target)) {
                        if (wrap) wrap.style.display = 'none';
                    }
                });

                const mainToggleBtn = root.querySelector('.td_search_tobble_btn');

                mainToggleBtn?.addEventListener('click', () => {
                    if (!wrap) return;
                    wrap.style.display = wrap.style.display === 'block' ? 'none' : 'block';
                    if (wrap.style.display === 'block') {
                        setTimeout(() => input?.focus(), 50);
                    }
                });

                const externalSearchBtns = document.querySelectorAll('.js-open-global-search');
                externalSearchBtns.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (!wrap) return;
                        wrap.style.display = wrap.style.display === 'block' ? 'none' : 'block';
                        if (wrap.style.display === 'block') {
                            setTimeout(() => input?.focus(), 50);
                        }
                    });
                });
            })();
        </script>

        <!-- ✅ MOBILE DROPDOWN FIX: click parent toggles open/close (no navigation) -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mq = window.matchMedia('(max-width: 992px)');

                function isMobile() {
                    return mq.matches;
                }

                const navList = document.querySelector('.td_nav_list');
                if (!navList) return;

                const submenuItems = Array.from(navList.querySelectorAll('li.has-submenu'));

                function closeAll(exceptLi) {
                    submenuItems.forEach(function(li) {
                        if (exceptLi && li === exceptLi) return;
                        li.classList.remove('is-open');
                        const a = li.querySelector(':scope > a');
                        if (a) a.setAttribute('aria-expanded', 'false');
                    });
                }

                submenuItems.forEach(function(li) {
                    const a = li.querySelector(':scope > a');
                    if (a) a.setAttribute('aria-expanded', li.classList.contains('is-open') ? 'true' : 'false');
                });

                navList.addEventListener('click', function(e) {
                    if (!isMobile()) return;

                    const li = e.target.closest('li.has-submenu');
                    if (!li) return;

                    const link = li.querySelector(':scope > a');
                    const dropdown = li.querySelector(':scope > ul');
                    if (!link || !dropdown) return;

                    // submenu link clicked, allow it
                    if (dropdown.contains(e.target)) return;

                    // parent clicked, always toggle (and prevent navigation)
                    if (link.contains(e.target)) {
                        e.preventDefault();
                        e.stopPropagation();

                        const isOpen = li.classList.contains('is-open');
                        if (isOpen) {
                            li.classList.remove('is-open');
                            link.setAttribute('aria-expanded', 'false');
                        } else {
                            closeAll(li);
                            li.classList.add('is-open');
                            link.setAttribute('aria-expanded', 'true');
                        }
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!isMobile()) return;
                    const nav = document.querySelector('.td_nav');
                    if (!nav) return;
                    if (!nav.contains(e.target)) closeAll();
                });

                function onMqChange() {
                    if (!isMobile()) closeAll();
                }
                if (mq.addEventListener) mq.addEventListener('change', onMqChange);
                if (mq.addListener) mq.addListener(onMqChange);

                // Language switcher
                const langSelects = document.querySelectorAll('.top-lang-select');
                langSelects.forEach(function(select) {
                    select.addEventListener('change', function() {
                        const lang = this.value;
                        const url = new URL(window.location.href);
                        url.searchParams.set('lang', lang);
                        window.location.href = url.toString();
                    });
                });
            });
        </script>

    </header>
    {{-- ================= END HEADER ================= --}}

    {{-- VERTICAL SOCIAL RAIL --}}
    <div class="header-social-rail">
        @if (setting('social.facebook'))
            <a href="{{ setting('social.facebook') }}" target="_blank" rel="noopener noreferrer"><i
                    class="fab fa-facebook-f"></i></a>
        @endif
        @if (setting('social.instagram'))
            <a href="{{ setting('social.instagram') }}" target="_blank" rel="noopener noreferrer"><i
                    class="fab fa-instagram"></i></a>
        @endif
        @if (setting('social.linkedin') || setting('social.pinterest'))
            <a href="{{ setting('social.linkedin', setting('social.pinterest')) }}" target="_blank"
                rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
        @endif
        @if (setting('social.whatsapp'))
            <a href="{{ setting('social.whatsapp') }}" target="_blank" rel="noopener noreferrer"><i
                    class="fab fa-whatsapp"></i></a>
        @endif
    </div>
</body>

</html>
