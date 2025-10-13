{{-- resources-details.blade.php --}}
@extends('layouts.app')
@section('title', $resource->name)

@push('styles')
    <style>
        :root {
            --bg: #f8fafc;
            --ink: #0f172a;
            --muted: #64748b;
            --chip: #f1f5f9;
            --card: #ffffff;
            --shadow: 0 12px 34px rgba(15, 23, 42, .08);
            --stage: #0b1220;
            --bar: #0f172a;
            --barfg: #e2e8f0;
        }

        .page-wrap {
            background: var(--bg)
        }

        .cardx {
            background: var(--card);
            border-radius: 18px;
            box-shadow: var(--shadow);
            overflow: hidden
        }

        .pad {
            padding: 16px 18px
        }

        .muted {
            color: var(--muted)
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--chip);
            color: var(--ink);
            border-radius: 999px;
            padding: 6px 10px;
            font-weight: 700;
            font-size: .82rem
        }

        .btn-pill {
            border-radius: 12px;
            font-weight: 700
        }

        .btn-ghost {
            background: #fff;
            border: 1px solid #e2e8f0
        }

        .hstack {
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-wrap: wrap
        }

        .row-badges,
        .row-actions {
            gap: .5rem
        }

        /* Stage + PDF viewer */
        .stage {
            position: relative;
            background: linear-gradient(180deg, var(--stage) 0%, var(--stage) 40%, #101827 100%)
        }

        .pdf-wrap {
            position: relative
        }

        .pdf-toolbar {
            position: absolute;
            left: 12px;
            right: 12px;
            top: 12px;
            display: flex;
            align-items: center;
            gap: .4rem;
            flex-wrap: wrap;
            background: rgba(15, 23, 42, .78);
            backdrop-filter: saturate(160%) blur(6px);
            color: #fff;
            border-radius: 12px;
            padding: 8px 10px;
            z-index: 5
        }

        .pdf-toolbar .sep {
            width: 1px;
            height: 26px;
            background: rgba(255, 255, 255, .12);
            margin: 0 4px
        }

        .pdf-toolbar .btnx {
            appearance: none;
            border: 0;
            outline: 0;
            background: #111827;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 10px;
            font-weight: 700;
            padding: 6px 10px;
            cursor: pointer
        }

        .pdf-toolbar .btnx:hover {
            background: #0b1220
        }

        .pdf-toolbar input[type="number"] {
            width: 86px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, .18);
            background: #0b1220;
            color: #fff;
            padding: 6px 8px;
            font-weight: 700
        }

        .ratio-16x9 {
            position: relative;
            width: 100%
        }

        .ratio-16x9::before {
            content: "";
            display: block;
            padding-top: 56.25%
        }

        .fit {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            border: 0
        }

        .skel {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
            z-index: 1
        }

        #pdfCanvas {
            position: absolute;
            inset: 0;
            margin: auto;
            max-width: 100%;
            max-height: 100%;
            background: #0000
        }

        /* Right list */
        .side-card {
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, .06)
        }

        .side-card .in {
            padding: 16px 18px
        }

        .mini {
            display: flex;
            gap: .8rem;
            align-items: start
        }

        .thumb {
            width: 72px;
            height: 52px;
            border-radius: 10px;
            background: #0b1220;
            flex: 0 0 72px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
            overflow: hidden
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .list-unstyled {
            list-style: none;
            margin: 0;
            padding: 0
        }

        .list-unstyled li+li {
            margin-top: 12px
        }

        .line-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden
        }

        /* meta grid */
        .kv {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: .5rem .75rem
        }

        .kv b {
            color: var(--muted)
        }
    </style>
@endpush

@section('content')
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
        data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">{{ $resource->name }}</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resources') }}">Resources</a></li>
                    <li class="breadcrumb-item active">{{ \Illuminate\Support\Str::limit($resource->name, 40) }}</li>
                </ol>
            </div>
        </div>
    </section>

    @php
        $mime = strtolower($resource->mime ?? '');
        $path = parse_url($resource->resourceUrl, PHP_URL_PATH) ?? '';
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $isImg =
            in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']) ||
            \Illuminate\Support\Str::startsWith($mime, 'image/');
        $isVid =
            in_array($ext, ['mp4', 'mov', 'webm', 'mkv', 'avi']) ||
            \Illuminate\Support\Str::startsWith($mime, 'video/');
        $isPdf = $ext === 'pdf' || $mime === 'application/pdf';
        $isAud = in_array($ext, ['mp3', 'wav', 'ogg', 'm4a']) || \Illuminate\Support\Str::startsWith($mime, 'audio/');
        $isOff =
            in_array($ext, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'odt', 'odp', 'ods', 'rtf', 'txt']) ||
            \Illuminate\Support\Str::contains($mime, 'officedocument');
        $docsViewer = 'https://docs.google.com/gview?embedded=1&url=' . urlencode($resource->resourceUrl);
        $downloadUrl = $resource->resourceUrl . (str_contains($resource->resourceUrl, '?') ? '&' : '?') . 'download=1';
    @endphp

    <section class="page-wrap">
        <div class="td_height_120 td_height_lg_80"></div>
        <div class="container">
            <div class="row td_gap_y_30">
                {{-- LEFT --}}
                <div class="col-lg-8">
                    <div class="cardx">

                        {{-- Top bar --}}
                        <div class="pad d-flex justify-content-between align-items-center flex-wrap" style="gap:10px">
                            <div class="hstack row-badges">
                                <span class="chip"><b>Tip:</b> {{ $resource->type?->name ?? '—' }}</span>
                                <span class="chip"><b>İl:</b> {{ $resource->year ?: '—' }}</span>
                                <span class="chip"><b>Baxış:</b> {{ number_format($resource->views) }}</span>
                                @if ($resource->mime)
                                    <span class="chip">{{ $resource->mime }}</span>
                                @endif
                                @if ($ext)
                                    <span class="chip">.{{ $ext }}</span>
                                @endif
                            </div>
                            <div class="hstack row-actions">
                                <a href="{{ $resource->resourceUrl }}" target="_blank" rel="noopener"
                                    class="btn btn-ghost btn-pill">Yeni tabda aç</a>
                                <a href="{{ $downloadUrl }}" download class="btn btn-primary btn-pill">Yüklə</a>
                                <button type="button" class="btn btn-ghost btn-pill" id="copyLinkBtn"
                                    data-url="{{ $resource->resourceUrl }}">Linki kopyala</button>
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div class="stage ratio-16x9">
                            <div id="sk" class="skel"><span>Yüklənir…</span></div>

                            @if ($isImg)
                                <img class="fit" src="{{ $resource->resourceUrl }}" alt=""
                                    onload="document.getElementById('sk').style.display='none'">
                            @elseif($isVid)
                                <video class="fit" src="{{ $resource->resourceUrl }}" controls playsinline
                                    onloadeddata="document.getElementById('sk').style.display='none'"></video>
                            @elseif($isAud)
                                <div class="fit d-flex align-items-center justify-content-center">
                                    <audio src="{{ $resource->resourceUrl }}" controls style="width:90%"
                                        onloadeddata="document.getElementById('sk').style.display='none'"></audio>
                                </div>
                            @elseif($isPdf)
                                {{-- PDF.js Canvas Viewer + Toolbar --}}
                                <div id="pdfWrap" class="pdf-wrap fit" style="display:none">
                                    <div class="pdf-toolbar">
                                        <button class="btnx" id="prevBtn" title="Previous (←)">Prev</button>
                                        <button class="btnx" id="nextBtn" title="Next (→)">Next</button>
                                        <span class="sep"></span>
                                        <label class="text-white-50 small">Go to</label>
                                        <input type="number" id="pageInput" min="1" value="1" />
                                        <span id="pageTotal" class="small text-white-50">/ ?</span>
                                        <span class="sep"></span>
                                        <button class="btnx" id="zoomOutBtn" title="Zoom out (-)">−</button>
                                        <button class="btnx" id="zoomInBtn" title="Zoom in (+)">+</button>
                                        <button class="btnx" id="zoomResetBtn" title="Reset (0)">100%</button>
                                        <span class="sep"></span>
                                        <button class="btnx" id="rotLeftBtn" title="Rotate Left (Shift+R)">⟲</button>
                                        <button class="btnx" id="rotRightBtn" title="Rotate Right (R)">⟳</button>
                                        <span class="sep"></span>
                                        <button class="btnx" id="printBtn" title="Print (P)">Print</button>
                                        <a class="btnx" id="downloadBtn" href="{{ $downloadUrl }}" download>Download</a>
                                    </div>
                                    <canvas id="pdfCanvas"></canvas>
                                </div>

                                {{-- Fallback: Google Viewer (görünməz, lazım olsa göstəriləcək) --}}
                                <iframe id="pdfFallback" class="fit" style="display:none" src="{{ $docsViewer }}"
                                    allow="fullscreen" onload="document.getElementById('sk').style.display='none'"></iframe>
                            @elseif($isOff)
                                <iframe class="fit" src="{{ $docsViewer }}" title="Document" allowfullscreen
                                    onload="document.getElementById('sk').style.display='none'"></iframe>
                            @else
                                <div
                                    class="fit d-flex flex-column align-items-center justify-content-center text-center muted">
                                    <div class="mb-3">Bu fayl üçün daxili önbaxış yoxdur.</div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ $resource->resourceUrl }}" target="_blank" rel="noopener"
                                            class="btn btn-ghost btn-pill">Yeni tabda aç</a>
                                        <a href="{{ $downloadUrl }}" class="btn btn-primary btn-pill" download>Yüklə</a>
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('sk').style.display = 'none'
                                </script>
                            @endif
                        </div>

                        {{-- Meta --}}
                        <div class="pad">
                            <div class="kv">
                                <b>Ad</b> <span>{{ $resource->name }}</span>
                                <b>Tip</b> <span>{{ $resource->type?->name ?? '—' }}</span>
                                <b>İl</b> <span>{{ $resource->year ?: '—' }}</span>
                                <b>MIME</b> <span>{{ $resource->mime ?: '—' }}</span>
                                <b>Uzantı</b> <span>{{ $ext ? '.' . $ext : '—' }}</span>
                                <b>Link</b> <span><a href="{{ $resource->resourceUrl }}" target="_blank"
                                        rel="noopener">{{ $resource->resourceUrl }}</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4">
                    @if ($related->count())
                        <div class="side-card">
                            <div class="in">
                                <h3 class="td_fs_24 td_mb_16">Oxşar resurslar</h3>
                                <ul class="list-unstyled">
                                    @foreach ($related as $it)
                                        @php
                                            $m = strtolower($it->mime ?? '');
                                            $p = parse_url($it->resourceUrl, PHP_URL_PATH) ?? '';
                                            $e = strtolower(pathinfo($p, PATHINFO_EXTENSION));
                                            $imgMini =
                                                in_array($e, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']) ||
                                                \Illuminate\Support\Str::startsWith($m, 'image/');
                                            $vidMini =
                                                in_array($e, ['mp4', 'mov', 'webm', 'mkv', 'avi']) ||
                                                \Illuminate\Support\Str::startsWith($m, 'video/');
                                            $pdfMini = $e === 'pdf' || $m === 'application/pdf';
                                        @endphp
                                        <li>
                                            <a href="{{ route('resources-details', $it) }}" class="text-decoration-none">
                                                <div class="mini">
                                                    <div class="thumb">
                                                        @if ($imgMini)
                                                            <img src="{{ $it->resourceUrl }}" alt="">
                                                        @elseif($vidMini)
                                                            <svg width="28" height="28" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor">
                                                                <path d="M23 7l-7 5 7 5V7z" />
                                                                <rect x="1" y="5" width="15" height="14"
                                                                    rx="2" />
                                                            </svg>
                                                        @elseif($pdfMini)
                                                            <svg width="28" height="28" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor">
                                                                <path d="M14 2H6a2 2 0 0 0-2 2v16l4-2 4 2 4-2 4 2V8z" />
                                                                <path d="M14 2v6h6" />
                                                            </svg>
                                                        @else
                                                            <svg width="28" height="28" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor">
                                                                <path d="M14 2H6a2 2 0 0 0-2 2v16l4-2 4 2 4-2 4 2V8z" />
                                                                <path d="M14 2v6h6" />
                                                            </svg>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="line-1">{{ $it->name }}</div>
                                                        <div class="small muted">{{ $it->type?->name ?? 'Tip' }} ·
                                                            {{ $it->year ?: '—' }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="td_height_120 td_height_lg_80"></div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- pdf.js (core + worker) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
        // Link copy UX
        (function() {
            const btn = document.getElementById('copyLinkBtn');
            if (!btn) return;
            btn.addEventListener('click', async () => {
                const url = btn.getAttribute('data-url');
                try {
                    await navigator.clipboard.writeText(url);
                    const t = btn.textContent;
                    btn.textContent = 'Kopyalandı!';
                    setTimeout(() => btn.textContent = t, 1200);
                } catch (_) {
                    prompt('Linki kopyalayın:', url);
                }
            });
        })();
    </script>

    @if ($isPdf)
        <script>
            (function() {
                // ---- Setup
                const urlRaw = @json($resource->resourceUrl);
                const url = (urlRaw || '').replace(/&amp;/g, '&'); // HTML entity fix
                const sk = document.getElementById('sk');
                const wrap = document.getElementById('pdfWrap');
                const canvas = document.getElementById('pdfCanvas');
                const ctx = canvas.getContext('2d', {
                    willReadFrequently: true
                });

                const fb = document.getElementById('pdfFallback');

                // Toolbar refs
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const pageInput = document.getElementById('pageInput');
                const pageTotal = document.getElementById('pageTotal');
                const zoomInBtn = document.getElementById('zoomInBtn');
                const zoomOutBtn = document.getElementById('zoomOutBtn');
                const zoomResetBtn = document.getElementById('zoomResetBtn');
                const rotLeftBtn = document.getElementById('rotLeftBtn');
                const rotRightBtn = document.getElementById('rotRightBtn');
                const printBtn = document.getElementById('printBtn');
                const downloadBtn = document.getElementById('downloadBtn');

                // ---- pdf.js init
                const pdfjs = window['pdfjs-dist/build/pdf'];
                if (pdfjs?.GlobalWorkerOptions) {
                    pdfjs.GlobalWorkerOptions.workerSrc =
                        "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
                }

                let pdfDoc = null,
                    pageNum = 1,
                    scale = 1.0,
                    rotation = 0,
                    rendering = false,
                    pending = null;

                function queueRender(num) {
                    if (rendering) {
                        pending = num;
                    } else {
                        renderPage(num);
                    }
                }

                async function renderPage(num) {
                    rendering = true;
                    try {
                        const page = await pdfDoc.getPage(num);

                        // viewport with current scale & rotation
                        const vp = page.getViewport({
                            scale,
                            rotation
                        });

                        // HiDPI scale (crisp)
                        const dpr = window.devicePixelRatio || 1;
                        canvas.width = Math.floor(vp.width * dpr);
                        canvas.height = Math.floor(vp.height * dpr);
                        canvas.style.width = vp.width + 'px';
                        canvas.style.height = vp.height + 'px';

                        const renderCtx = {
                            canvasContext: ctx,
                            viewport: vp,
                            transform: dpr !== 1 ? [dpr, 0, 0, dpr, 0, 0] : null
                        };
                        await page.render(renderCtx).promise;

                        // UI
                        pageInput.value = pageNum;
                        pageTotal.textContent = '/ ' + pdfDoc.numPages;
                        zoomResetBtn.textContent = Math.round(scale * 100) + '%';

                        rendering = false;
                        if (pending !== null) {
                            const n = pending;
                            pending = null;
                            renderPage(n);
                        }
                    } catch (e) {
                        console.warn('pdf.js render error', e);
                        // Fallback → Google Viewer
                        wrap.style.display = 'none';
                        fb.style.display = 'block';
                    } finally {
                        sk.style.display = 'none';
                    }
                }

                function goTo(n) {
                    n = Math.max(1, Math.min(pdfDoc.numPages, n | 0));
                    if (n !== pageNum) {
                        pageNum = n;
                        queueRender(pageNum);
                    }
                }

                // ---- Controls
                prevBtn.addEventListener('click', () => goTo(pageNum - 1));
                nextBtn.addEventListener('click', () => goTo(pageNum + 1));
                pageInput.addEventListener('change', () => goTo(parseInt(pageInput.value || '1', 10)));

                zoomInBtn.addEventListener('click', () => {
                    scale = Math.min(scale * 1.2, 5);
                    queueRender(pageNum);
                });
                zoomOutBtn.addEventListener('click', () => {
                    scale = Math.max(scale / 1.2, .2);
                    queueRender(pageNum);
                });
                zoomResetBtn.addEventListener('click', () => {
                    scale = 1;
                    queueRender(pageNum);
                });

                rotRightBtn.addEventListener('click', () => {
                    rotation = (rotation + 90) % 360;
                    queueRender(pageNum);
                });
                rotLeftBtn.addEventListener('click', () => {
                    rotation = (rotation + 270) % 360;
                    queueRender(pageNum);
                });

                // Print: gizli iframe ilə cəhd; alınmasa yeni tab
                printBtn.addEventListener('click', () => {
                    try {
                        const ifr = document.createElement('iframe');
                        ifr.style.position = 'fixed';
                        ifr.style.right = '-9999px';
                        ifr.style.bottom = '-9999px';
                        ifr.src = url;
                        document.body.appendChild(ifr);
                        ifr.onload = () => {
                            try {
                                ifr.contentWindow.focus();
                                ifr.contentWindow.print();
                            } catch (_) {
                                window.open(url, '_blank');
                            }
                        };
                        setTimeout(() => document.body.removeChild(ifr), 15000);
                    } catch (_) {
                        window.open(url, '_blank');
                    }
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', (ev) => {
                    const k = ev.key;
                    if (k === 'ArrowLeft') {
                        ev.preventDefault();
                        goTo(pageNum - 1);
                    } else if (k === 'ArrowRight') {
                        ev.preventDefault();
                        goTo(pageNum + 1);
                    } else if (k === '+' || k === '=') {
                        ev.preventDefault();
                        scale = Math.min(scale * 1.2, 5);
                        queueRender(pageNum);
                    } else if (k === '-' || k === '_') {
                        ev.preventDefault();
                        scale = Math.max(scale / 1.2, .2);
                        queueRender(pageNum);
                    } else if (k === '0') {
                        ev.preventDefault();
                        scale = 1;
                        queueRender(pageNum);
                    } else if (k === 'r' && !ev.shiftKey) {
                        ev.preventDefault();
                        rotation = (rotation + 90) % 360;
                        queueRender(pageNum);
                    } else if ((k === 'R' && ev.shiftKey) || (k === 'r' && ev.shiftKey)) {
                        ev.preventDefault();
                        rotation = (rotation + 270) % 360;
                        queueRender(pageNum);
                    } else if (k === 'p' || k === 'P') {
                        ev.preventDefault();
                        printBtn.click();
                    }
                });

                // ---- Load document
                (async () => {
                    try {
                        const doc = await pdfjs.getDocument({
                            url,
                            withCredentials: false
                        }).promise;
                        pdfDoc = doc;
                        wrap.style.display = 'block';
                        fb.style.display = 'none';
                        pageNum = 1;
                        scale = 1;
                        rotation = 0;
                        renderPage(pageNum);
                        downloadBtn.href = url + (url.includes('?') ? '&' : '?') + 'download=1';
                    } catch (e) {
                        console.warn('pdf.js load failed, fallback viewer', e);
                        wrap.style.display = 'none';
                        fb.style.display = 'block';
                        sk.style.display = 'none';
                    }
                })();
            })();
        </script>
    @endif
@endpush
