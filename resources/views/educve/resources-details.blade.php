@extends('layouts.app')
@section('title', $resource->name)

@push('styles')
<style>
  /* ====== Layout & Theme ====== */
  .page-wrap{--card-bg:#fff;--muted:#64748b;--chip-bg:#f1f5f9}
  .cardx{background:var(--card-bg);border-radius:18px;box-shadow:0 12px 32px rgba(15,23,42,.08);overflow:hidden}
  .soft{box-shadow:0 10px 26px rgba(15,23,42,.06)}
  .chip{display:inline-flex;align-items:center;gap:.35rem;background:var(--chip-bg);color:#0f172a;border-radius:999px;padding:6px 10px;font-size:.82rem;font-weight:700}
  .muted{color:var(--muted)}
  .btn-pill{border-radius:12px;font-weight:700}
  .btn-ghost{background:#fff;border:1px solid #e2e8f0}
  .hstack{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
  .pad{padding:16px 18px}
  /* ====== Preview ====== */
  .stage{position:relative;background:linear-gradient(180deg,#0b1220 0%, #0b1220 40%, #101827 100%)}
  .ratio-16x9{position:relative;width:100%}
  .ratio-16x9::before{content:"";display:block;padding-top:56.25%}
  .fit{position:absolute;inset:0;width:100%;height:100%;object-fit:contain;border:0}
  .skeleton{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#cbd5e1}
  /* ====== Sidebar ====== */
  .side-card{background:var(--card-bg);border-radius:16px;box-shadow:0 8px 22px rgba(15,23,42,.06)}
  .side-card .in{padding:16px 18px}
  .mini{display:flex;gap:.75rem;align-items-start}
  .thumb{width:64px;height:48px;border-radius:8px;background:#0b1220;flex:0 0 64px;display:flex;align-items:center;justify-content:center;color:#cbd5e1}
  .thumb img{width:100%;height:100%;object-fit:cover;border-radius:8px}
  .list-unstyled{list-style:none;margin:0;padding:0}
  .list-unstyled li+li{margin-top:12px}
  /* ====== Badges row ====== */
  .row-badges{gap:.5rem}
  .row-actions{gap:.5rem}
  /* anchor truncate */
  .line-1{display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden}
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

<section class="page-wrap">
  <div class="td_height_120 td_height_lg_80"></div>
  <div class="container">
    <div class="row td_gap_y_30">
      {{-- ===== Left: Main Card ===== --}}
      <div class="col-lg-8">
        <div class="cardx">

          {{-- Top bar: meta + actions --}}
          <div class="pad d-flex justify-content-between align-items-center flex-wrap" style="gap:10px">
            <div class="hstack row-badges">
              <span class="chip"><b>Tip:</b>&nbsp;{{ $resource->type?->name ?? '—' }}</span>
              <span class="chip"><b>İl:</b>&nbsp;{{ $resource->year ?: '—' }}</span>
              <span class="chip"><b>Views:</b>&nbsp;{{ number_format($resource->views) }}</span>
              @if($resource->mime)
                <span class="chip">{{ $resource->mime }}</span>
              @endif
            </div>

            @php
              $downloadUrl = $resource->resourceUrl . (str_contains($resource->resourceUrl,'?') ? '&' : '?') . 'download=1';
            @endphp
            <div class="hstack row-actions">
              <a href="{{ $resource->resourceUrl }}" target="_blank" rel="noopener" class="btn btn-ghost btn-pill">
                Yeni tabda aç
              </a>
              <a href="{{ $downloadUrl }}" download class="btn btn-primary btn-pill">Yüklə</a>
              <button type="button" class="btn btn-ghost btn-pill" id="copyLinkBtn" data-url="{{ $resource->resourceUrl }}">Linki kopyala</button>
            </div>
          </div>

          {{-- Preview Stage --}}
          @php
            $mime = strtolower($resource->mime ?? '');
            $path = parse_url($resource->resourceUrl, PHP_URL_PATH) ?? '';
            $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $isImg = in_array($ext,['jpg','jpeg','png','gif','webp','bmp','svg']) || \Illuminate\Support\Str::startsWith($mime,'image/');
            $isVid = in_array($ext,['mp4','mov','webm','mkv','avi']) || \Illuminate\Support\Str::startsWith($mime,'video/');
            $isPdf = ($ext==='pdf') || ($mime==='application/pdf');
            $isAud = in_array($ext,['mp3','wav','ogg','m4a']) || \Illuminate\Support\Str::startsWith($mime,'audio/');
            $isOff = in_array($ext,['doc','docx','ppt','pptx','xls','xlsx','odt','odp','ods','rtf','txt']) || \Illuminate\Support\Str::contains($mime,'officedocument');
            $docsViewer = 'https://docs.google.com/gview?embedded=1&url='.urlencode($resource->resourceUrl);
          @endphp

          <div class="stage ratio-16x9">
            <div id="sk" class="skeleton"><span>Yüklənir…</span></div>

            @if($isImg)
              <img class="fit" src="{{ $resource->resourceUrl }}" alt="" onload="document.getElementById('sk').style.display='none'">
            @elseif($isVid)
              <video class="fit" src="{{ $resource->resourceUrl }}" controls playsinline onloadeddata="document.getElementById('sk').style.display='none'"></video>
            @elseif($isAud)
              <div class="fit d-flex align-items-center justify-content-center">
                <audio src="{{ $resource->resourceUrl }}" controls style="width:90%" onloadeddata="document.getElementById('sk').style.display='none'"></audio>
              </div>
            @elseif($isPdf || $isOff)
              {{-- CORS-safe preview --}}
              <iframe class="fit" src="{{ $docsViewer }}" title="Document" allowfullscreen
                      onload="document.getElementById('sk').style.display='none'"></iframe>
            @else
              <div class="fit d-flex flex-column align-items-center justify-content-center text-center muted">
                <div class="mb-3">Bu fayl üçün daxili önbaxış yoxdur.</div>
                <div class="d-flex gap-2">
                  <a href="{{ $resource->resourceUrl }}" target="_blank" rel="noopener" class="btn btn-ghost btn-pill">Yeni tabda aç</a>
                  <a href="{{ $downloadUrl }}" class="btn btn-primary btn-pill" download>Yüklə</a>
                </div>
              </div>
              <script>document.getElementById('sk').style.display='none'</script>
            @endif
          </div>

          <div class="pad">
            <div class="muted">
              <b>Orijinal link:</b>
              <a href="{{ $resource->resourceUrl }}" target="_blank" rel="noopener">{{ $resource->resourceUrl }}</a>
            </div>
          </div>
        </div>
      </div>

      {{-- ===== Right: Sidebar ===== --}}
      <div class="col-lg-4">
        @if($related->count())
          <div class="side-card soft">
            <div class="in">
              <h3 class="td_fs_24 td_mb_16">Oxşar resurslar</h3>
              <ul class="list-unstyled">
                @foreach($related as $it)
                  @php
                    $m = strtolower($it->mime ?? '');
                    $p = parse_url($it->resourceUrl, PHP_URL_PATH) ?? '';
                    $e = strtolower(pathinfo($p, PATHINFO_EXTENSION));
                    $imgMini = in_array($e,['jpg','jpeg','png','gif','webp','bmp','svg']) || \Illuminate\Support\Str::startsWith($m,'image/');
                    $vidMini = in_array($e,['mp4','mov','webm','mkv','avi']) || \Illuminate\Support\Str::startsWith($m,'video/');
                    $pdfMini = ($e==='pdf') || ($m==='application/pdf');
                  @endphp
                  <li>
                    <a href="{{ route('resources-details',$it) }}" class="text-decoration-none">
                      <div class="mini">
                        <div class="thumb">
                          @if($imgMini)
                            <img src="{{ $it->resourceUrl }}" alt="">
                          @elseif($vidMini)
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M23 7l-7 5 7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                          @elseif($pdfMini)
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16l4-2 4 2 4-2 4 2V8z"/><path d="M14 2v6h6"/></svg>
                          @else
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16l4-2 4 2 4-2 4 2V8z"/><path d="M14 2v6h6"/></svg>
                          @endif
                        </div>
                        <div>
                          <div class="line-1">{{ $it->name }}</div>
                          <div class="small muted">{{ $it->type?->name ?? 'Tip' }} · {{ $it->year ?: '—' }}</div>
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
<script>
  // Link copy
  (function(){
    const btn=document.getElementById('copyLinkBtn');
    if(!btn) return;
    btn.addEventListener('click',async ()=>{
      const url=btn.getAttribute('data-url');
      try{
        await navigator.clipboard.writeText(url);
        btn.textContent='Kopyalandı!';
        setTimeout(()=>btn.textContent='Linki kopyala',1200);
      }catch(_){
        prompt('Linki kopyalayın:', url);
      }
    });
  })();
</script>
@endpush
