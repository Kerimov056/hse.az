@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Carbon;

    $title = $news->name ?? 'News Title';
    $category = $news->category->name ?? ($news->category ?? 'News');
    $updatedAt = $news->updated_at ?? ($news->created_at ?? now());
    $updatedTxt = Carbon::parse($updatedAt)->format('d M, Y');
    $thumb = $news->imageUrl ?? asset('assets/img/placeholder/placeholder-800x500.jpg');
    $views = $news->views ?? 0;

    // optional social links – əgər varsa göstəriləcək
    $sl = $news->socialLink ?? null;
    $twitter = $sl?->twitterurl;
    $facebook = $sl?->facebookurl;
    $linkedin = $sl?->linkedinurl;

    $emailRaw = $sl?->emailurl;
    $emailLink = $emailRaw
        ? (Str::startsWith($emailRaw, ['mailto:', 'http'])
            ? $emailRaw
            : 'mailto:' . $emailRaw)
        : null;

    $waRaw = $sl?->whatsappurl;
    $waLink = null;
    if ($waRaw) {
        $waLink = Str::startsWith($waRaw, ['http', 'https'])
            ? $waRaw
            : 'https://wa.me/' . preg_replace('/\D+/', '', $waRaw);
    }

    $rel = collect($relatedNews ?? [])->take(3);
@endphp

<style>
    .news-thumb {
        position: relative;
        border-radius: 10px;
        background: #f6f7f9;
        height: 520px;
        overflow: hidden;
    }

    @media (max-width: 991.98px) {
        .news-thumb {
            height: 380px;
        }
    }

    @media (max-width: 575.98px) {
        .news-thumb {
            height: 260px;
        }
    }

    .news-thumb img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .views-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        line-height: 1;
        padding: 6px 10px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
    }

    .views-badge svg {
        width: 16px;
        height: 16px;
    }

    .news-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem 1rem;
        align-items: center;
        color: #6b7280;
        font-size: .95rem;
    }

    .news-meta-row .dot {
        width: 4px;
        height: 4px;
        border-radius: 999px;
        background: #cbd5e1;
    }

    .social-btns {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem;
    }

    .social-btns a {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        border-radius: 999px;
        padding: .55rem .9rem;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #e5e7eb;
        color: #111827;
        background: #fff;
    }

    .equal-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .equal-card .td_card_thumb {
        display: block;
        position: relative;
        overflow: hidden;
        border-radius: 10px
    }

    .equal-card .td_card_info {
        flex: 1;
        display: flex;
        flex-direction: column
    }

    .equal-card .td_card_info_in {
        flex: 1;
        display: flex;
        flex-direction: column
    }

    .equal-card .td_card_title {
        min-height: 56px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden
    }

    .equal-card .td_card_subtitle {
        min-height: 72px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden
    }

    .equal-card .btn-row {
        margin-top: auto;
        display: flex;
        gap: .5rem;
        align-items: center
    }
</style>

{{-- PAGE HEADING (istəsən course-details-dəki kimi ayrıca heading də qoya bilərsən) --}}
<section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
    <div class="container">
        <div class="td_page_heading_in">
            <h1 class="td_white_color td_fs_40 td_mb_10">{{ __('News') }}</h1>
            <ol class="breadcrumb m-0 td_fs_18 td_opacity_8 td_semibold td_white_color">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news') }}">News</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($title, 48) }}</li>
            </ol>
        </div>
    </div>
</section>

<!-- News Details -->
<section style="margin-top: 50px">
    <div class="td_height_120 td_height_lg_80"></div>
    <div class="container">
        <div class="row td_gap_y_50">
            <div class="col-lg-10 mx-auto">
                <div class="td_course_details">

                    <div class="news-thumb td_radius_10 td_mb_30">
                        <span class="views-badge" title="Views">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor"
                                    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
                            </svg>
                            {{ $views }}
                        </span>

                        <img src="{{ $thumb }}" alt="{{ $title }}">
                    </div>

                    <span class="td_course_label td_mb_10">{{ $category }}</span>
                    <h2 class="td_fs_48 td_mb_10">{{ $title }}</h2>

                    <div class="news-meta-row td_mb_30">
                        <span><i class="fa-regular fa-calendar me-1"></i> Published: {{ $updatedTxt }}</span>
                        <span class="dot"></span>
                        <span><i class="fa-regular fa-eye me-1"></i>{{ number_format($views) }} views</span>
                    </div>

                    {{-- Content --}}
                    <div class="td_mb_40 td_content">
                        @if (!empty($news->description))
                            {!! $news->description !!}
                        @else
                            <p>No content added yet.</p>
                        @endif
                    </div>

                    {{-- Social links – əgər təyin olunubsa --}}
                    @if ($twitter || $facebook || $linkedin || $emailLink || $waLink)
                        <div class="td_mb_50">
                            <h3 class="td_fs_24 td_semibold td_mb_15">Share / Contact</h3>
                            <div class="social-btns">
                                @if ($twitter)
                                    <a href="{{ $twitter }}" target="_blank" rel="noopener">
                                        <i class="fa-brands fa-x-twitter"></i> Twitter
                                    </a>
                                @endif
                                @if ($facebook)
                                    <a href="{{ $facebook }}" target="_blank" rel="noopener">
                                        <i class="fa-brands fa-facebook-f"></i> Facebook
                                    </a>
                                @endif
                                @if ($linkedin)
                                    <a href="{{ $linkedin }}" target="_blank" rel="noopener">
                                        <i class="fa-brands fa-linkedin-in"></i> LinkedIn
                                    </a>
                                @endif
                                @if ($emailLink)
                                    <a href="{{ $emailLink }}">
                                        <i class="fa-solid fa-envelope"></i> Email
                                    </a>
                                @endif
                                @if ($waLink)
                                    <a href="{{ $waLink }}" target="_blank" rel="noopener">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related News – max 3 card --}}
<section>
    <div class="td_height_60 td_height_lg_60"></div>
    <div class="container">
        <h2 class="td_fs_48 td_mb_50">More news</h2>

        <div class="row td_gap_y_30 td_row_gap_30">
            @forelse($rel as $item)
                @php
                    $rcThumb = $item->imageUrl ?? asset('assets/img/placeholder/placeholder-800x500.jpg');
                    $rcDesc = strip_tags($item->description ?? '');
                @endphp
                <div class="col-lg-4 col-md-6 d-flex">
                    <div class="td_card td_style_3 td_radius_10 equal-card w-100">
                        <a href="{{ route('news-details', $item->id) }}" class="td_card_thumb">
                            <span class="views-badge" title="Views">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor"
                                        stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor"
                                        stroke-width="1.6" />
                                </svg>
                                {{ $item->views ?? 0 }}
                            </span>
                            <img src="{{ $rcThumb }}" alt="{{ $item->name ?? 'News' }}"
                                style="width:100%;height:220px;object-fit:cover">
                        </a>

                        <div class="td_card_info td_white_bg">
                            <div class="td_card_info_in">
                                <a href="{{ route('news') }}"
                                    class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                                    <span>{{ $item->category->name ?? ($item->category ?? 'News') }}</span>
                                </a>

                                <h2 class="td_card_title td_fs_24 td_mb_16">
                                    <a
                                        href="{{ route('news-details', $item->id) }}">{{ $item->name ?? 'News title' }}</a>
                                </h2>

                                @if ($rcDesc)
                                    <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                        {{ Str::limit($rcDesc, 140) }}
                                    </p>
                                @else
                                    <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20"> </p>
                                @endif

                                <div class="btn-row">
                                    <a href="{{ route('news-details', $item->id) }}"
                                        class="td_btn td_style_1 td_radius_10 td_medium">
                                        <span class="td_btn_in td_white_color td_accent_bg"><span>Read
                                                more</span></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center">No related news yet.</div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="td_height_120 td_height_lg_80"></div>
{{-- INFO TOAST – bu service üçün info varsa göstər --}}
  @include('partials.info-toast', ['text' => $news->info ?? null])

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    referrerpolicy="no-referrer" />
