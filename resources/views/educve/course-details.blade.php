@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Carbon;

    $title       = $course->name             ?? 'Course Title';
    $category    = $course->category->name   ?? ($course->category ?? 'General');

    // trainer -> instructor (DB column: instructor)
    $instructor  = $course->instructor       ?? ($course->trainer_name ?? 'Instructor');

    $updatedAt   = $course->updated_at       ?? now();
    $updatedTxt  = Carbon::parse($updatedAt)->format('d M, Y');

    $thumb       = $course->imageUrl         ?? asset('assets/img/placeholder/placeholder-800x500.jpg');
    $views       = $course->views            ?? 0;
    $videoUrl    = $course->video_url        ?? null;

    $description = $course->description      ?? 'No description provided yet.';
    $info        = $course->info             ?? null;

    // New columns
    $duration    = trim((string)($course->duration ?? ''));
    $priceRaw    = $course->price ?? null;

    $hasPrice    = $priceRaw !== null && $priceRaw !== '' && is_numeric($priceRaw);
    $priceNumber = $hasPrice ? (float)$priceRaw : null;

    $currency    = $course->currency ?? 'AZN'; // sütun yoxdursa default
    $priceText   = $hasPrice
        ? (fmod($priceNumber, 1.0) === 0.0 ? number_format($priceNumber, 0) : rtrim(rtrim(number_format($priceNumber, 2, '.', ''), '0'), '.'))
        : null;

    $isFree      = $hasPrice && $priceNumber == 0.0;

    // Topics (course_topics table)
    $topics = collect($course->topics ?? $course->courseTopics ?? $course->course_topics ?? [])
        ->sortBy(fn($t) => $t->sort_order ?? 9999)
        ->values();

    // social links
    $sl = $course->socialLink ?? null;
    $twitter   = $sl?->twitterurl;
    $facebook  = $sl?->facebookurl;
    $linkedin  = $sl?->linkedinurl;

    $emailRaw  = $sl?->emailurl;
    $emailLink = $emailRaw
        ? (Str::startsWith($emailRaw, ['mailto:', 'http']) ? $emailRaw : 'mailto:'.$emailRaw)
        : null;

    $waRaw     = $sl?->whatsappurl;
    $waLink    = null;
    if ($waRaw) {
        $waLink = Str::startsWith($waRaw, ['http', 'https'])
            ? $waRaw
            : ('https://wa.me/'.preg_replace('/\D+/', '', $waRaw));
    }

    // Optional extra content (Safety leadership section)
    $safetyLeadership = $course->safety_leadership ?? $course->safetyLeadership ?? $course->safety ?? null;

    /*
      ✅ NEW: Parse description blocks created by admin
      Format saved in DB:
      <section data-desc-item="1">
        <h3>Title</h3>
        <div data-desc-body="1">Body with <br> etc</div>
      </section>
    */
    $descSections = [];
    $rawDesc = (string)($course->description ?? '');

    if (trim($rawDesc) !== '' && str_contains($rawDesc, 'data-desc-item="1"')) {
        try {
            libxml_use_internal_errors(true);

            $dom = new \DOMDocument('1.0', 'UTF-8');
            // wrap to keep HTML valid
            $dom->loadHTML('<div id="wrap">'.$rawDesc.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $xpath = new \DOMXPath($dom);
            $nodes = $xpath->query('//section[@data-desc-item="1"]');

            if ($nodes && $nodes->length > 0) {
                foreach ($nodes as $sec) {
                    $h3 = null;
                    foreach ($sec->childNodes as $ch) {
                        if ($ch instanceof \DOMElement && strtolower($ch->tagName) === 'h3') {
                            $h3 = $ch;
                            break;
                        }
                    }

                    $titleTxt = $h3 ? trim($h3->textContent ?? '') : '';
                    $titleTxt = $titleTxt !== '' ? $titleTxt : 'Description';

                    $bodyEl = null;
                    foreach ($sec->childNodes as $ch) {
                        if ($ch instanceof \DOMElement && strtolower($ch->tagName) === 'div' && $ch->getAttribute('data-desc-body') === '1') {
                            $bodyEl = $ch;
                            break;
                        }
                    }

                    $bodyHtml = '';
                    if ($bodyEl) {
                        $bodyHtml = '';
                        foreach ($bodyEl->childNodes as $child) {
                            $bodyHtml .= $dom->saveHTML($child);
                        }
                        $bodyHtml = trim($bodyHtml);
                    }

                    if ($titleTxt !== '' || $bodyHtml !== '') {
                        $descSections[] = [
                            'title' => $titleTxt,
                            'body'  => $bodyHtml !== '' ? $bodyHtml : '',
                        ];
                    }
                }
            }

            libxml_clear_errors();
        } catch (\Throwable $e) {
            $descSections = [];
        }
    }

    $hasDescSections = count($descSections) > 0;
@endphp

<style>
  :root{
    --ink:#0f172a;
    --muted:#64748b;
    --line:#e5e7eb;
    --bg:#f8fafc;
    --card:#ffffff;

    --accBg:#0b1220;
    --accGlow: rgba(99, 102, 241, .18);
    --accGlow2: rgba(14, 165, 233, .12);
  }

  .course-wrap{max-width: 980px; margin:0 auto;}
  .course-top-grid{display:grid; grid-template-columns: 1.45fr .55fr; gap:18px;}
  @media (max-width: 991.98px){ .course-top-grid{ grid-template-columns: 1fr; } }

  .course-thumb{
    position: relative;
    border-radius: 14px;
    background:#0b1220;
    height: 520px;
    overflow: hidden;
    border:1px solid rgba(255,255,255,.08);
    box-shadow: 0 16px 50px rgba(15,23,42,.14);
  }
  @media (max-width: 991.98px){ .course-thumb{ height: 380px; } }
  @media (max-width: 575.98px){ .course-thumb{ height: 260px; } }

  .course-thumb img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    opacity: .95;
  }

  .course-thumb iframe{
    width: 100%;
    aspect-ratio: 16/9;
    height: auto;
    max-height: 100%;
    display: block;
  }

  .media-grad{
    position:absolute; inset:0;
    background: linear-gradient(180deg, rgba(0,0,0,.10) 25%, rgba(0,0,0,.70) 100%);
    pointer-events:none;
  }

  .views-badge {
    position: absolute; top: 12px; left: 12px;
    background: rgba(0,0,0,0.6); color:#fff; font-weight:800;
    font-size:13px; line-height:1; padding:7px 11px; border-radius: 999px;
    display:inline-flex; align-items:center; gap:6px; z-index:2;
    backdrop-filter: blur(6px);
  }
  .views-badge svg{ width:16px; height:16px; }

  .meta-chip-row{
    position:absolute; left:12px; right:12px; bottom:12px;
    display:flex; gap:8px; flex-wrap:wrap; justify-content:space-between; align-items:flex-end;
    z-index:2;
  }
  .chip{
    display:inline-flex; align-items:center; gap:.45rem;
    padding:7px 10px;
    border-radius:999px;
    font-weight:800;
    font-size:.78rem;
    color:#0f172a;
    background: rgba(255,255,255,.92);
    border:1px solid rgba(255,255,255,.40);
  }
  .chip-dark{
    color:#fff;
    background: rgba(0,0,0,.55);
    border:1px solid rgba(255,255,255,.12);
    backdrop-filter: blur(6px);
  }
  .chip svg{ width:16px; height:16px; }

  .side-card{
    background:var(--card);
    border:1px solid var(--line);
    border-radius:14px;
    padding:16px;
    box-shadow: 0 10px 26px rgba(15,23,42,.06);
    height:100%;
  }
  .side-title{
    font-weight:900; font-size:16px; margin:0 0 10px 0;
  }
  .kv{
    display:flex; justify-content:space-between; gap:12px;
    padding:10px 0; border-top:1px dashed rgba(15,23,42,.10);
    font-size:14px;
  }
  .kv:first-of-type{ border-top:0; padding-top:0; }
  .kv .k{ color:var(--muted); }
  .kv .v{ font-weight:800; color:var(--ink); text-align:right; }

  .course-title{
    font-weight: 900;
    font-size: 44px;
    margin: 10px 0 10px 0;
    line-height: 1.08;
  }
  @media (max-width:575.98px){ .course-title{ font-size:34px; } }

  .subline{
    display:flex; flex-wrap:wrap; gap:12px;
    align-items:center;
    color:var(--muted);
    font-size:14px;
  }
  .subline .dot{ width:4px; height:4px; background:#cbd5e1; border-radius:50%; }

  .label{
    display:inline-flex; align-items:center;
    padding:6px 10px; border-radius:999px;
    background:#eef2ff;
    color:#3730a3;
    font-weight:900;
    font-size:12px;
    border:1px solid rgba(55,48,163,.12);
  }

  .topics{
    display:flex; flex-direction:column; gap:10px;
  }
  .topic-item{
    display:flex; gap:12px; align-items:flex-start;
    padding:12px;
    border-radius:12px;
    border:1px solid rgba(15,23,42,.08);
    background:#fff;
  }
  .topic-num{
    width:30px; height:30px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    background:#f1f5f9;
    color:#0f172a;
    font-weight:900;
    flex:0 0 auto;
  }
  .topic-txt{ font-weight:800; color:var(--ink); line-height:1.35; }
  .topic-sub{ color:var(--muted); font-size:13px; margin-top:2px; }

  .social-btns{display:flex; flex-wrap:wrap; gap:.6rem;}
  .social-btns a{
    display:inline-flex; align-items:center; gap:.5rem;
    border-radius:999px; padding:.55rem .9rem; font-weight:800;
    text-decoration:none; border:1px solid var(--line);
    background:#fff;
  }

  .register-box{
    border:1px solid rgba(0,0,0,.08);
    border-radius: 14px;
    padding: 18px;
    background: #fff;
  }
  .register-box .mini{
    opacity:.8;
    font-size: 14px;
    margin:0;
  }

  .equal-card{display:flex;flex-direction:column;height:100%;}
  .equal-card .td_card_thumb{display:block;position:relative;overflow:hidden;border-radius:10px}
  .equal-card .td_card_info{flex:1;display:flex;flex-direction:column}
  .equal-card .td_card_info_in{flex:1;display:flex;flex-direction:column}
  .equal-card .td_card_title{min-height:56px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
  .equal-card .td_card_subtitle{min-height:72px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
  .equal-card .btn-row{margin-top:auto;display:flex;gap:.5rem;align-items:center}

  /* Custom accordion (NO Bootstrap dependency) */
  .acc-wrap{
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(15,23,42,.10);
    background:
      radial-gradient(1200px 240px at 20% 0%, var(--accGlow), transparent 60%),
      radial-gradient(900px 240px at 80% 0%, var(--accGlow2), transparent 55%),
      #ffffff;
    box-shadow: 0 14px 40px rgba(15,23,42,.08);
  }

  .acc-item{
    border-top:1px solid rgba(15,23,42,.08);
    background:rgba(255,255,255,.92);
    backdrop-filter: blur(10px);
  }
  .acc-item:first-child{ border-top:0; }

  .acc-trigger{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    padding:16px 18px;
    border:0;
    background:transparent;
    cursor:pointer;
    text-align:left;
  }

  .acc-left{
    display:flex; align-items:center; gap:12px;
    min-width:0;
  }

  .acc-badge{
    width:36px; height:36px;
    border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    background:#0b1220;
    color:#fff;
    box-shadow: 0 10px 22px rgba(11,18,32,.14);
    flex:0 0 auto;
    font-weight:900;
  }

  .acc-title{
    font-weight:950;
    font-size:18px;
    color:var(--ink);
    line-height:1.2;
    margin:0;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

  .acc-sub{
    margin:2px 0 0 0;
    font-size:13px;
    color:var(--muted);
    line-height:1.25;
  }

  .acc-chevron{
    width:36px; height:36px;
    border-radius:999px;
    display:flex; align-items:center; justify-content:center;
    background:#f1f5f9;
    border:1px solid rgba(15,23,42,.08);
    flex:0 0 auto;
    transition: transform .18s ease, background .18s ease;
  }
  .acc-item.is-open .acc-chevron{
    transform: rotate(180deg);
    background:#eaf0ff;
  }

  .acc-panel{
    overflow:hidden;
    max-height:0;
    transition: max-height .22s ease;
  }

  .acc-content{
    padding:0 18px 18px 18px;
    border-top:1px solid rgba(15,23,42,.06);
  }

  .acc-trigger:focus-visible{
    outline:3px solid rgba(99,102,241,.25);
    outline-offset:-3px;
    border-radius:12px;
  }
</style>

<section style="margin-top: 50px; background:var(--bg)">
  <div class="td_height_120 td_height_lg_80"></div>
  <div class="container">
    <div class="course-wrap">

      {{-- TOP GRID: media + quick facts --}}
      <div class="course-top-grid td_mb_30">

        <div class="course-thumb">
          <span class="views-badge" title="Views">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
            </svg>
            {{ number_format($views) }}
          </span>

          @if($videoUrl)
            <iframe class="embed-responsive-item" src="{{ $videoUrl }}" allowfullscreen></iframe>
          @else
            <img src="{{ $thumb }}" alt="{{ $title }}">
          @endif

          <div class="media-grad"></div>

          <div class="meta-chip-row">
            <span class="chip-dark">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 20s7-4.5 7-10a7 7 0 0 0-14 0c0 5.5 7 10 7 10Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9.5 10.5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
              {{ $category }}
            </span>

            <span class="d-flex gap-2 flex-wrap justify-content-end">
              @if($duration !== '')
                <span class="chip" title="Duration">
                  <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M12 7v6l4 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  {{ $duration }}
                </span>
              @endif

              @if($hasPrice)
                <span class="chip" title="Price">
                  <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M7 7h10v10H7z" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M9 11h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  </svg>
                  @if($isFree)
                    Free
                  @else
                    <b style="font-weight:900">{{ $priceText }}</b> {{ $currency }}
                  @endif
                </span>
              @endif
            </span>
          </div>
        </div>

        {{-- Quick facts --}}
        <aside class="side-card">
          <h3 class="side-title">Course info</h3>

          <div class="kv">
            <div class="k">Category</div>
            <div class="v">{{ $category }}</div>
          </div>

          <div class="kv">
            <div class="k">Instructor</div>
            <div class="v">{{ $instructor }}</div>
          </div>

          @if($duration !== '')
            <div class="kv">
              <div class="k">Duration</div>
              <div class="v">{{ $duration }}</div>
            </div>
          @endif

          @if($hasPrice)
            <div class="kv">
              <div class="k">Price</div>
              <div class="v">
                @if($isFree) Free @else {{ $priceText }} {{ $currency }} @endif
              </div>
            </div>
          @endif

          <div class="kv">
            <div class="k">Last update</div>
            <div class="v">{{ $updatedTxt }}</div>
          </div>

          @if(!empty($course->courseUrl))
            <div class="kv">
              <div class="k">Link</div>
              <div class="v">
                <a href="{{ $course->courseUrl }}" target="_blank" rel="noopener" style="font-weight:900; text-decoration:none">
                  Open
                </a>
              </div>
            </div>
          @endif

          {{-- Registration button (if course type == course) --}}
          @if(($course->type ?? null) === \App\Models\Course::TYPE_COURSE)
            <div style="margin-top:14px">
              <a href="{{ route('courses.register', $course->id) }}" class="td_btn td_style_1 td_radius_10 td_medium w-100">
                <span class="td_btn_in td_white_color td_accent_bg">
                  <span>Register</span>
                </span>
              </a>
              <p class="mini mb-0" style="margin-top:10px; color:var(--muted)">
                Fill the form and submit your registration for this course.
              </p>
            </div>
          @endif
        </aside>

      </div>

      {{-- Title + subtitle --}}
      <div class="td_mb_30">
        <span class="label">{{ $category }}</span>
        <h1 class="course-title">{{ $title }}</h1>

        <div class="subline">
          <span><b style="color:var(--ink)">Instructor:</b> {{ $instructor }}</span>
          <span class="dot"></span>
          <span><b style="color:var(--ink)">Updated:</b> {{ $updatedTxt }}</span>
          @if($duration !== '')
            <span class="dot"></span>
            <span><b style="color:var(--ink)">Duration:</b> {{ $duration }}</span>
          @endif
          @if($hasPrice)
            <span class="dot"></span>
            <span><b style="color:var(--ink)">Price:</b>
              @if($isFree) Free @else {{ $priceText }} {{ $currency }} @endif
            </span>
          @endif
        </div>
      </div>

      {{-- CUSTOM ACCORDION (NO BOOTSTRAP) --}}
      <div class="acc-wrap td_mb_30" id="courseAcc">

        {{-- ✅ DESCRIPTION SECTIONS (from admin) --}}
        @if($hasDescSections)
          @foreach($descSections as $i => $sec)
            @php
              $accId = 'accDescSec'.($i+1);
              $open = $i === 0;
              $badge = $i + 1;
              $subtitle = 'Description section';
            @endphp

            <div class="acc-item {{ $open ? 'is-open' : '' }}" data-acc-item>
              <button class="acc-trigger" type="button" data-acc-btn aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="{{ $accId }}">
                <div class="acc-left">
                  <div class="acc-badge" aria-hidden="true">{{ $badge }}</div>
                  <div style="min-width:0">
                    <p class="acc-title">{{ $sec['title'] ?? 'Description' }}</p>
                    <p class="acc-sub">{{ $subtitle }}</p>
                  </div>
                </div>
                <div class="acc-chevron" aria-hidden="true">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
              </button>

              <div class="acc-panel" id="{{ $accId }}" data-acc-panel role="region" aria-label="{{ $sec['title'] ?? 'Description' }}">
                <div class="acc-content">
                  @if(!empty($sec['body']))
                    {!! $sec['body'] !!}
                  @else
                    <p class="mb-0"> </p>
                  @endif
                </div>
              </div>
            </div>
          @endforeach

        @else
          {{-- Fallback: old single description --}}
          <div class="acc-item is-open" data-acc-item>
            <button class="acc-trigger" type="button" data-acc-btn aria-expanded="true" aria-controls="accDesc">
              <div class="acc-left">
                <div class="acc-badge" aria-hidden="true">D</div>
                <div style="min-width:0">
                  <p class="acc-title">Description</p>
                  <p class="acc-sub">Overview, what you will learn</p>
                </div>
              </div>
              <div class="acc-chevron" aria-hidden="true">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                  <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </button>

            <div class="acc-panel" id="accDesc" data-acc-panel role="region" aria-label="Description">
              <div class="acc-content">
                @if(!empty($course->description))
                  {!! $description !!}
                @else
                  <p class="mb-0">{{ $description }}</p>
                @endif
              </div>
            </div>
          </div>
        @endif

        {{-- Topics --}}
        <div class="acc-item" data-acc-item>
          <button class="acc-trigger" type="button" data-acc-btn aria-expanded="false" aria-controls="accTopics">
            <div class="acc-left">
              <div class="acc-badge" aria-hidden="true">T</div>
              <div style="min-width:0">
                <p class="acc-title">Topics</p>
                <p class="acc-sub">Lessons, order, curriculum</p>
              </div>
            </div>
            <div class="acc-chevron" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
          </button>

          <div class="acc-panel" id="accTopics" data-acc-panel role="region" aria-label="Topics">
            <div class="acc-content">
              @if($topics->count() > 0)
                <div class="topics">
                  @foreach($topics as $i => $t)
                    <div class="topic-item">
                      <div class="topic-num">{{ $i + 1 }}</div>
                      <div>
                        <div class="topic-txt">{{ $t->title ?? '' }}</div>
                        @if(!empty($t->sort_order))
                          <div class="topic-sub">Order: {{ $t->sort_order }}</div>
                        @endif
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <div class="alert alert-light border mb-0">No topics yet.</div>
              @endif
            </div>
          </div>
        </div>

        {{-- Registration --}}
        <div class="acc-item" data-acc-item>
          <button class="acc-trigger" type="button" data-acc-btn aria-expanded="false" aria-controls="accReg">
            <div class="acc-left">
              <div class="acc-badge" aria-hidden="true">R</div>
              <div style="min-width:0">
                <p class="acc-title">Registration</p>
                <p class="acc-sub">Submit your registration form</p>
              </div>
            </div>
            <div class="acc-chevron" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
          </button>

          <div class="acc-panel" id="accReg" data-acc-panel role="region" aria-label="Registration">
            <div class="acc-content">
              @if(($course->type ?? null) === \App\Models\Course::TYPE_COURSE)
                <div class="register-box">
                  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                      <h3 class="td_fs_24 td_semibold mb-1">Registration</h3>
                      <p class="mini mb-0">Fill the form and submit your registration for this course.</p>
                    </div>

                    <a href="{{ route('courses.register', $course->id) }}"
                       class="td_btn td_style_1 td_radius_10 td_medium">
                      <span class="td_btn_in td_white_color td_accent_bg">
                        <span>Register</span>
                      </span>
                    </a>
                  </div>
                </div>
              @else
                <div class="alert alert-light border mb-0">Registration is not available for this item.</div>
              @endif
            </div>
          </div>
        </div>

        {{-- Follow / Contact --}}
        <div class="acc-item" data-acc-item>
          <button class="acc-trigger" type="button" data-acc-btn aria-expanded="false" aria-controls="accSocial">
            <div class="acc-left">
              <div class="acc-badge" aria-hidden="true">F</div>
              <div style="min-width:0">
                <p class="acc-title">Follow / Contact</p>
                <p class="acc-sub">Social links and quick contact</p>
              </div>
            </div>
            <div class="acc-chevron" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
          </button>

          <div class="acc-panel" id="accSocial" data-acc-panel role="region" aria-label="Follow / Contact">
            <div class="acc-content">
              @if($twitter || $facebook || $linkedin || $emailLink || $waLink)
                <div class="social-btns">
                  @if($twitter)
                    <a href="{{ $twitter }}" target="_blank" rel="noopener">
                      <i class="fa-brands fa-x-twitter"></i> Twitter
                    </a>
                  @endif
                  @if($facebook)
                    <a href="{{ $facebook }}" target="_blank" rel="noopener">
                      <i class="fa-brands fa-facebook-f"></i> Facebook
                    </a>
                  @endif
                  @if($linkedin)
                    <a href="{{ $linkedin }}" target="_blank" rel="noopener">
                      <i class="fa-brands fa-linkedin-in"></i> LinkedIn
                    </a>
                  @endif
                  @if($emailLink)
                    <a href="{{ $emailLink }}">
                      <i class="fa-solid fa-envelope"></i> Email
                    </a>
                  @endif
                  @if($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener">
                      <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </a>
                  @endif
                </div>
              @else
                <div class="alert alert-light border mb-0">No social links added yet.</div>
              @endif
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
  <div class="td_height_120 td_height_lg_80"></div>
</section>

{{-- Related Courses: max 3 card --}}
@php
  $rel = collect($relatedCourses ?? [])->take(3);
@endphp

<section style="background:#fff">
  <div class="td_height_60 td_height_lg_60"></div>
  <div class="container">
    <h2 class="td_fs_48 td_mb_50">Courses you may like</h2>

    <div class="row td_gap_y_30 td_row_gap_30">
      @forelse($rel as $rc)
        <div class="col-lg-4 col-md-6 d-flex">
          <div class="td_card td_style_3 td_radius_10 equal-card w-100">
            <a href="{{ route('course-details', $rc->id) }}" class="td_card_thumb">
              <span class="views-badge" title="Views">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6" />
                </svg>
                {{ $rc->views ?? 0 }}
              </span>
              <img src="{{ $rc->imageUrl ?? asset('assets/img/placeholder/placeholder-800x500.jpg') }}"
                   alt="{{ $rc->name ?? 'Course' }}"
                   style="width:100%;height:220px;object-fit:cover">
            </a>

            <div class="td_card_info td_white_bg">
              <div class="td_card_info_in">
                <a href="{{ route('courses-grid-view') }}" class="td_card_category td_fs_14 td_bold td_heading_color td_mb_14">
                  <span>{{ $rc->category->name ?? ($rc->category ?? 'General') }}</span>
                </a>

                <h2 class="td_card_title td_fs_24 td_mb_16">
                  <a href="{{ route('course-details', $rc->id) }}">{{ $rc->name ?? 'Course title' }}</a>
                </h2>

                @php $rcDesc = strip_tags($rc->description ?? ''); @endphp
                @if($rcDesc)
                  <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                    {{ Str::limit($rcDesc, 140) }}
                  </p>
                @else
                  <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20"> </p>
                @endif

                <div class="btn-row">
                  <a href="{{ route('course-details', $rc->id) }}" class="td_btn td_style_1 td_radius_10 td_medium">
                    <span class="td_btn_in td_white_color td_accent_bg"><span>Details</span></span>
                  </a>

                  @if(!empty($rc->courseUrl))
                    <a href="{{ $rc->courseUrl }}" target="_blank" rel="noopener" class="td_btn td_style_2 td_radius_10 td_medium">
                      <span class="td_btn_in td_heading_color td_white_bg"><span>Visit</span></span>
                    </a>
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-light border text-center">No related courses yet.</div>
        </div>
      @endforelse
    </div>
  </div>
  <div class="td_height_120 td_height_lg_80"></div>
</section>

{{-- INFO TOAST --}}
@include('partials.info-toast', ['text' => $info])

{{-- Custom accordion JS (no Bootstrap needed) --}}
<script>
  (function () {
    const root = document.getElementById('courseAcc');
    if (!root) return;

    const items = Array.from(root.querySelectorAll('[data-acc-item]'));

    function setPanelHeight(item, open) {
      const panel = item.querySelector('[data-acc-panel]');
      const btn = item.querySelector('[data-acc-btn]');
      if (!panel || !btn) return;

      if (open) {
        item.classList.add('is-open');
        btn.setAttribute('aria-expanded', 'true');
        panel.style.maxHeight = panel.scrollHeight + 'px';
      } else {
        item.classList.remove('is-open');
        btn.setAttribute('aria-expanded', 'false');
        panel.style.maxHeight = '0px';
      }
    }

    function closeAll(except) {
      items.forEach((it) => {
        if (except && it === except) return;
        setPanelHeight(it, false);
      });
    }

    // init (open ones)
    items.forEach((it) => {
      const isOpen = it.classList.contains('is-open');
      setPanelHeight(it, isOpen);
    });

    // click handlers
    items.forEach((item) => {
      const btn = item.querySelector('[data-acc-btn]');
      const panel = item.querySelector('[data-acc-panel]');
      if (!btn || !panel) return;

      btn.addEventListener('click', function () {
        const isOpen = item.classList.contains('is-open');
        if (isOpen) {
          setPanelHeight(item, false);
          return;
        }
        closeAll(item);
        setPanelHeight(item, true);
      });
    });

    // keep heights correct on resize
    let rAf = null;
    window.addEventListener('resize', function () {
      if (rAf) cancelAnimationFrame(rAf);
      rAf = requestAnimationFrame(function () {
        items.forEach((it) => {
          if (!it.classList.contains('is-open')) return;
          const panel = it.querySelector('[data-acc-panel]');
          if (panel) panel.style.maxHeight = panel.scrollHeight + 'px';
        });
      });
    });
  })();
</script>

{{-- Success Toast (after registration) --}}
@if(session('ok'))
  <div id="regToastBackdrop" style="
      position:fixed; inset:0; background:rgba(0,0,0,.35);
      display:flex; align-items:center; justify-content:center;
      z-index:9999; padding:16px;
  ">
    <div id="regToast" style="
        width:min(520px, 100%);
        background:#fff; border-radius:14px;
        box-shadow:0 20px 70px rgba(0,0,0,.25);
        overflow:hidden;
        border:1px solid rgba(0,0,0,.08);
    ">
      <div style="padding:18px 18px 10px 18px; display:flex; gap:12px; align-items:flex-start;">
        <div style="
            width:42px; height:42px; border-radius:12px;
            background:#e9f7ef; display:flex; align-items:center; justify-content:center;
            flex:0 0 auto;
        ">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 6L9 17L4 12" stroke="#1e8e3e" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>

        <div style="flex:1 1 auto;">
          <div style="font-weight:900; font-size:18px; margin-bottom:4px;">Registration received</div>
          <div style="opacity:.8; font-size:14px; line-height:1.4;">
            {{ session('ok') }}
          </div>
        </div>

        <button type="button" id="regToastCloseBtn" aria-label="Close" style="
            border:0; background:transparent; font-size:22px; line-height:1;
            padding:0 4px; cursor:pointer; opacity:.65;
        ">×</button>
      </div>

      <div style="padding:0 18px 18px 18px; display:flex; gap:10px; justify-content:flex-end;">
        <button type="button" id="regToastOkBtn" class="td_btn td_style_1 td_radius_10 td_medium">
          <span class="td_btn_in td_white_color td_accent_bg">
            <span>OK</span>
          </span>
        </button>
      </div>
    </div>
  </div>

  <script>
    (function () {
      const backdrop = document.getElementById('regToastBackdrop');
      const closeBtn = document.getElementById('regToastCloseBtn');
      const okBtn = document.getElementById('regToastOkBtn');

      function closeToast() {
        if (!backdrop) return;
        backdrop.style.opacity = '0';
        backdrop.style.transition = 'opacity .18s ease';
        setTimeout(() => backdrop.remove(), 180);
      }

      if (closeBtn) closeBtn.addEventListener('click', closeToast);
      if (okBtn) okBtn.addEventListener('click', closeToast);

      if (backdrop) {
        backdrop.addEventListener('click', function (e) {
          if (e.target === backdrop) closeToast();
        });
      }

      setTimeout(closeToast, 4500);
    })();
  </script>
@endif
