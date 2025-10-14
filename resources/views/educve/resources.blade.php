{{-- resources.blade.php --}}
@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $q = $q ?? request('q');
@endphp

@section('content')

    <style>
        /* ===== Theme tokens ===== */
        :root {
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --chip: #f1f5f9;
            --card: #ffffff;
            --bg: #f8fafc;
            --accent: #0d6efd;
            /* Bootstrap primary */
        }

        /* Page */
        .res-page {
            background: var(--bg)
        }

        /* Sticky filter bar */
        .res-filterbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: linear-gradient(#fff, #fff);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 10px;
            box-shadow: 0 10px 30px rgba(2, 6, 23, .06);
        }

        /* Search group */
        .res-input {
            border: 1px solid var(--line) !important;
            border-radius: 12px !important;
            height: 48px
        }

        .res-select {
            border: 1px solid var(--line) !important;
            border-radius: 12px !important;
            height: 48px
        }

        .res-btn {
            border-radius: 12px;
            font-weight: 700
        }

        /* Type chips */
        .res-chips {
            display: flex;
            gap: .5rem;
            overflow: auto;
            padding-bottom: 4px;
            scrollbar-width: thin
        }

        .res-chip {
            white-space: nowrap;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
            border-radius: 999px;
            padding: 8px 12px;
            font-weight: 700;
            font-size: .92rem;
            text-decoration: none
        }

        .res-chip:hover {
            border-color: #cbd5e1
        }

        .res-chip.active {
            background: var(--ink);
            color: #fff;
            border-color: var(--ink)
        }

        /* Stats line */
        .res-stats {
            color: var(--muted);
            font-weight: 600
        }

        /* Cards */
        .rs_card {
            height: 100%;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 26px rgba(15, 23, 42, .08);
            transition: transform .2s, box-shadow .2s
        }

        .rs_card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, .12)
        }

        .rs_thumb {
            position: relative;
            background: #0b1220
        }

        .rs_thumb::before {
            content: "";
            display: block;
            padding-top: 56.25%
        }

        .rs_fit {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 0
        }

        .rs_icon_wrap {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1
        }

        .rs_ext {
            position: absolute;
            right: 10px;
            bottom: 10px;
            background: rgba(0, 0, 0, .70);
            color: #fff;
            border-radius: 10px;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 700
        }

        .rs_body {
            padding: 16px 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        .rs_meta {
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .rs_badge {
            background: var(--chip);
            border-radius: 999px;
            padding: 6px 10px;
            font-weight: 700;
            font-size: 12px;
            color: var(--ink)
        }

        .rs_title {
            font-size: 1.125rem;
            font-weight: 800;
            margin: 0
        }

        .rs_actions {
            margin-top: 6px;
            display: flex;
            gap: .5rem;
            flex-wrap: wrap
        }

        .rs_btn {
            border-radius: 10px;
            font-weight: 700
        }

        .rs_btn-outline {
            background: #fff;
            border: 1px solid var(--line)
        }

        .empty {
            padding: 40px 0;
            color: #94a3b8
        }

        .preview-stage {
            min-height: 60vh;
            background: #0b1220
        }

        @media (max-width: 991.98px) {
            .preview-stage {
                min-height: 50vh
            }
        }
    </style>

    {{-- Heading (selector üçün id əlavə olundu) --}}
    <section id="resources-hero" class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
        data-src="{{ asset('assets/img/others/page_heading_bg.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Resources</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Resources</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="res-page">
        <div class="td_height_120 td_height_lg_80"></div>
        <div class="container">

            {{-- Sticky Search + Filter --}}
            <div class="res-filterbar mb-4">
                <form method="GET" class="row g-2 align-items-center">
                    <div class="col-xl-6 col-lg-6">
                        <div class="input-group">
                            <span class="input-group-text res-input" style="border-right:0;background:#fff">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b"
                                    stroke-width="2">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="M21 21l-4.35-4.35" />
                                </svg>
                            </span>
                            <input type="search" class="form-control res-input" name="q" value="{{ $q }}"
                                placeholder="Ad, il, MIME ilə axtar…" style="border-left:0">
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4">
                        <select name="type_id" class="form-select res-select">
                            <option value="0">Bütün tiplər</option>
                            @foreach ($types as $t)
                                <option value="{{ $t->id }}" @selected($type_id == $t->id)>{{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xl-2 col-lg-2 d-flex gap-2">
                        <button class="btn btn-primary w-100 res-btn">Axtar</button>
                        <a href="{{ route('resources') }}" class="btn btn-outline-secondary res-btn">Təmizlə</a>
                    </div>
                </form>

                @if ($types->count())
                    <div class="mt-3 res-chips">
                        <a class="res-chip {{ $type_id == 0 ? 'active' : '' }}"
                            href="{{ route('resources', ['q' => $q]) }}">Hamısı</a>
                        @foreach ($types as $t)
                            <a class="res-chip {{ $type_id == $t->id ? 'active' : '' }}"
                                href="{{ route('resources', ['q' => $q, 'type_id' => $t->id]) }}">{{ $t->name }}</a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Stats --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="res-stats">
                    @php $count = $resources instanceof \Illuminate\Contracts\Pagination\Paginator ? $resources->total() : $resources->count(); @endphp
                    {{ $count }} nəticə
                    @if ($q)
                        · “{{ $q }}”
                    @endif
                    @if ($type_id > 0)
                        · tip: {{ optional($types->firstWhere('id', $type_id))->name }}
                    @endif
                </div>
            </div>

            {{-- Grid --}}
            <div class="row g-4">
                @forelse($resources as $r)
                    @php
                        $mime = strtolower($r->mime ?? '');
                        $extPath = parse_url($r->resourceUrl, PHP_URL_PATH) ?? '';
                        $ext = strtolower(pathinfo($extPath, PATHINFO_EXTENSION));
                        $downloadUrl =
                            $r->resourceUrl . (str_contains($r->resourceUrl, '?') ? '&' : '?') . 'download=1';
                    @endphp

                    <div class="col-xl-4 col-md-6">
                        <div class="rs_card">
                            {{-- THUMBNAIL (lazy) --}}
                            <div class="rs_thumb js-lazy-preview" data-url="{{ $r->resourceUrl }}"
                                data-mime="{{ $mime }}" data-ext="{{ $ext }}">
                                @if ($ext)
                                    <span class="rs_ext">{{ $ext }}</span>
                                @endif
                            </div>

                            {{-- BODY --}}
                            <div class="rs_body">
                                <div class="rs_meta">
                                    <span class="rs_badge">{{ $r->type?->name ?? 'Tip' }}</span>
                                    <span class="text-muted small">{{ $r->year ?: '—' }}</span>
                                </div>

                                <h3 class="rs_title">
                                    <a href="{{ route('resources-details', $r) }}"
                                        class="text-decoration-none text-dark">{{ $r->name }}</a>
                                </h3>

                                <div class="rs_actions">
                                    <a href="{{ route('resources-details', $r) }}"
                                        class="btn btn-danger rs_btn">Detallar</a>

                                    <button class="btn btn-outline-dark rs_btn rs_btn-outline" type="button"
                                        data-bs-toggle="modal" data-bs-target="#previewModal"
                                        data-url="{{ $r->resourceUrl }}" data-mime="{{ $mime }}"
                                        data-ext="{{ $ext }}">
                                        Göster
                                    </button>

                                    <a href="{{ $downloadUrl }}" class="btn btn-outline-primary rs_btn rs_btn-outline"
                                        download>Yüklə</a>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="empty text-center">Nəticə tapılmadı.</div>
                @endforelse
            </div>

            <div class="td_height_40"></div>
            @if ($resources instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="d-flex justify-content-center">
                    {{ $resources->appends(['q' => $q, 'type_id' => $type_id])->links() }}
                </div>
            @endif
        </div>

        {{-- Preview Modal --}}
        <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xxl modal-dialog-centered modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bağla"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="previewStage"
                            class="preview-stage ratio ratio-16x9 d-flex align-items-center justify-content-center text-white">
                            <span class="opacity-75">Yüklənir…</span>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <div class="small text-muted" id="previewMeta"></div>
                        <div class="d-flex gap-2">
                            <a id="previewOpen" href="#" class="btn btn-outline-secondary" target="_blank"
                                rel="noopener">Yeni tabda aç</a>
                            <a id="previewDownload" href="#" class="btn btn-primary" download>Yüklə</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="td_height_120 td_height_lg_80"></div>
    </section>

    {{-- JS (inline) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    @verbatim
        <script>
            /* ---- PDF.js worker ---- */
            (function initPdfWorker() {
                try {
                    const pdfjs = window['pdfjs-dist/build/pdf'];
                    if (pdfjs?.GlobalWorkerOptions) {
                        pdfjs.GlobalWorkerOptions.workerSrc =
                            "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
                    }
                } catch (e) {
                    console.warn('PDF.js init skipped', e);
                }
            })
            ();

            /* ---- Helpers ---- */
            (function() {
                const OFFICE_EXTS = ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'odt', 'odp', 'ods', 'rtf', 'txt'];
                const IMG_EXTS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
                const VID_EXTS = ['mp4', 'mov', 'webm', 'mkv', 'avi'];
                const AUD_EXTS = ['mp3', 'wav', 'ogg', 'm4a'];

                const isOffice = (e, m) => OFFICE_EXTS.includes(e) || (m || '').includes('officedocument');
                const isImg = (e, m) => IMG_EXTS.includes(e) || (m || '').startsWith('image/');
                const isPdf = (e, m) => e === 'pdf' || (m || '') === 'application/pdf';
                const isVid = (e, m) => VID_EXTS.includes(e) || (m || '').startsWith('video/');
                const isAud = (e, m) => AUD_EXTS.includes(e) || (m || '').startsWith('audio/');
                const gviewUrl = (u) => 'https://docs.google.com/gview?embedded=1&url=' + encodeURIComponent(u);
                const safeUrl = (u) => (u || '').replace(/&amp;/g, '&');

                const ICONS = {
                    file: `<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16l4-2 4 2 4-2 4 2V8z"/><path d="M14 2v6h6"/></svg>`,
                    play: `<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="5,3 19,12 5,21 5,3"></polygon></svg>`,
                    pdf: `<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16l4-2 4 2 4-2 4 2V8z"/><path d="M14 2v6h6"/><text x="7" y="17" font-size="7" font-weight="800">PDF</text></svg>`
                };

                async function buildThumb(el, urlRaw, mime, ext) {
                    const url = safeUrl(urlRaw);
                    el.innerHTML = (ext ? `<span class="rs_ext">${ext}</span>` : '');

                    if (isImg(ext, mime)) {
                        el.insertAdjacentHTML('afterbegin', `<img class="rs_fit" src="${url}" alt="" loading="lazy">`);
                        return;
                    }

                    if (isVid(ext, mime)) {
                        el.insertAdjacentHTML('afterbegin', `<div class="rs_icon_wrap">${ICONS.play}</div>`);
                        return;
                    }

                    if (isPdf(ext, mime)) {
                        try {
                            const pdfjs = window['pdfjs-dist/build/pdf'];
                            if (!pdfjs) throw new Error('pdfjs not loaded');
                            const pdf = await pdfjs.getDocument({
                                url,
                                withCredentials: false
                            }).promise;
                            const page = await pdf.getPage(1);
                            const viewport = page.getViewport({
                                scale: .25
                            });
                            const canvas = document.createElement('canvas');
                            canvas.width = viewport.width;
                            canvas.height = viewport.height;
                            const ctx = canvas.getContext('2d', {
                                willReadFrequently: true
                            });
                            await page.render({
                                canvasContext: ctx,
                                viewport
                            }).promise;
                            const img = new Image();
                            img.className = 'rs_fit';
                            img.loading = 'lazy';
                            img.src = canvas.toDataURL('image/png');
                            el.insertAdjacentElement('afterbegin', img);
                            return;
                        } catch (e) {
                            el.insertAdjacentHTML('afterbegin',
                                `<iframe class="rs_fit" src="${gviewUrl(url)}" style="border:0" loading="lazy"></iframe>`
                                );
                            return;
                        }
                    }

                    if (isAud(ext, mime)) {
                        el.insertAdjacentHTML('afterbegin', `<div class="rs_icon_wrap">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M11 5l-6 4H3v6h2l6 4z"/><path d="M19 12a4 4 0 0 0-4-4"/>
            </svg>
          </div>`);
                        return;
                    }

                    if (isOffice(ext, mime)) {
                        el.insertAdjacentHTML('afterbegin', `<div class="rs_icon_wrap">${ICONS.file}</div>`);
                        return;
                    }

                    el.insertAdjacentHTML('afterbegin', `<div class="rs_icon_wrap">${ICONS.file}</div>`);
                }

                const thumbs = document.querySelectorAll('.js-lazy-preview');
                if ('IntersectionObserver' in window) {
                    const io = new IntersectionObserver((ents) => {
                        ents.forEach(ent => {
                            if (ent.isIntersecting) {
                                const el = ent.target;
                                buildThumb(el, el.dataset.url, (el.dataset.mime || '').toLowerCase(), (el
                                    .dataset.ext || '').toLowerCase());
                                io.unobserve(el);
                            }
                        });
                    }, {
                        rootMargin: '120px 0px'
                    });
                    thumbs.forEach(t => io.observe(t));
                } else {
                    thumbs.forEach(el => buildThumb(el, el.dataset.url, (el.dataset.mime || '').toLowerCase(), (el.dataset
                        .ext || '').toLowerCase()));
                }

                /* ---- Modal preview ---- */
                const modal = document.getElementById('previewModal');
                const stage = document.getElementById('previewStage');
                const meta = document.getElementById('previewMeta');
                const open = document.getElementById('previewOpen');
                const dl = document.getElementById('previewDownload');

                modal.addEventListener('show.bs.modal', function(e) {
                    const btn = e.relatedTarget;
                    const urlRaw = btn.getAttribute('data-url');
                    const url = safeUrl(urlRaw);
                    const mime = (btn.getAttribute('data-mime') || '').toLowerCase();
                    const ext = (btn.getAttribute('data-ext') || '').toLowerCase();

                    meta.textContent = mime || ext || 'fayl';
                    open.href = url;
                    dl.href = url + (url.includes('?') ? '&' : '?') + 'download=1';
                    dl.setAttribute('download', '');

                    stage.innerHTML = '<span class="opacity-75">Yüklənir…</span>';

                    if ((mime || '').startsWith('image/') || ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg']
                        .includes(ext)) {
                        stage.innerHTML =
                            `<img src="${url}" alt="" style="width:100%;height:100%;object-fit:contain">`;
                        return;
                    }

                    if (ext === 'pdf' || mime === 'application/pdf') {
                        stage.innerHTML =
                            `<iframe src="${url}#page=1&view=FitH" style="width:100%;height:100%;border:0"></iframe>`;
                        setTimeout(() => {
                            const ifr = stage.querySelector('iframe');
                            if (ifr && !ifr.contentWindow) {
                                stage.innerHTML =
                                    `<iframe src="${gviewUrl(url)}" style="width:100%;height:100%;border:0"></iframe>`;
                            }
                        }, 1500);
                        return;
                    }

                    if ((mime || '').startsWith('video/') || ['mp4', 'mov', 'webm', 'mkv', 'avi'].includes(ext)) {
                        stage.innerHTML =
                            `<video src="${url}" controls style="width:100%;height:100%;object-fit:contain"></video>`;
                        return;
                    }

                    if ((mime || '').startsWith('audio/') || ['mp3', 'wav', 'ogg', 'm4a'].includes(ext)) {
                        stage.innerHTML = `<audio src="${url}" controls style="width:90%"></audio>`;
                        return;
                    }

                    if (OFFICE_EXTS.includes(ext) || (mime || '').includes('officedocument')) {
                        stage.innerHTML =
                            `<iframe src="${gviewUrl(url)}" style="width:100%;height:100%;border:0"></iframe>`;
                        return;
                    }

                    stage.innerHTML = `<a class="btn btn-primary" href="${url}" download>Faylı yüklə</a>`;
                });

                modal.addEventListener('hidden.bs.modal', () => {
                    stage.innerHTML = '';
                });
            })();
        </script>
    @endverbatim

    {{-- Coach-mark komponenti: 1 selector kifayətdir --}}
    <x-section-guide page="resource" />
@endsection
