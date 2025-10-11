@php use Illuminate\Support\Str; @endphp

<style>
  /* inline, sadə və təmiz dropdown */
  .gsearch-dropdown{
    position:absolute; left:0; right:0; top:100%; margin-top:8px;
    background:#fff; border:1px solid #e5e7eb; border-radius:12px;
    box-shadow:0 16px 40px rgba(2,6,23,.12); overflow:hidden; z-index:9999;

    /* Yeni: max hündürlük və scroll */
    max-height:420px;              /* istəsən 60vh də yaza bilərsən */
    overflow-y:auto;
  }

  /* Nazik scrollbar */
  .gsearch-dropdown::-webkit-scrollbar{width:8px}
  .gsearch-dropdown::-webkit-scrollbar-track{background:#f8fafc;border-radius:10px}
  .gsearch-dropdown::-webkit-scrollbar-thumb{background:#e5e7eb;border-radius:10px}
  .gsearch-dropdown{scrollbar-width:thin; scrollbar-color:#e5e7eb #f8fafc}

  .gsearch-section{padding:10px 12px; border-top:1px solid #f1f5f9;}
  .gsearch-section:first-child{border-top:none}
  .gsearch-title{margin:6px 10px 8px; font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:#64748b; font-weight:700}
  .gsearch-item{display:flex; gap:10px; align-items:flex-start; padding:10px 12px; border-radius:10px; text-decoration:none; color:#0f172a;}
  .gsearch-item:hover{background:#f8fafc}
  .gsearch-thumb{width:42px; height:42px; flex:0 0 42px; border:1px solid #e5e7eb; border-radius:8px; background:#fff; display:flex; align-items:center; justify-content:center; overflow:hidden}
  .gsearch-thumb img{max-width:100%; max-height:100%; object-fit:cover}
  .gsearch-name{font-weight:700; font-size:14px; margin:0 0 3px}
  .gsearch-desc{font-size:13px; color:#64748b; margin:0}
  .gsearch-empty{padding:14px; color:#64748b}
</style>

<div class="gsearch-dropdown">
  @if(!$courses->count() && !$services->count() && !$topics->count() && !$vacancies->count() && !$resources->count())
    <div class="gsearch-empty">No results for “{{ $q }}”.</div>
  @else
    @if($courses->count())
      <div class="gsearch-section">
        <div class="gsearch-title">Courses</div>
        @foreach($courses as $it)
          <a class="gsearch-item" href="{{ route('course-details', $it) }}">
            <div class="gsearch-thumb">
              <img src="{{ $it->imageUrl ?: asset('assets/img/home_1/post_1.jpg') }}" alt="">
            </div>
            <div>
              <div class="gsearch-name">{{ $it->name }}</div>
              <p class="gsearch-desc">{{ Str::limit(strip_tags($it->description), 80) }}</p>
            </div>
          </a>
        @endforeach
      </div>
    @endif

    @if($services->count())
      <div class="gsearch-section">
        <div class="gsearch-title">Services</div>
        @foreach($services as $it)
          <a class="gsearch-item" href="{{ route('service-details', $it->id) }}">
            <div class="gsearch-thumb">
              <img src="{{ $it->imageUrl ?: asset('assets/img/home_1/post_1.jpg') }}" alt="">
            </div>
            <div>
              <div class="gsearch-name">{{ $it->name }}</div>
              <p class="gsearch-desc">{{ Str::limit(strip_tags($it->description), 80) }}</p>
            </div>
          </a>
        @endforeach
      </div>
    @endif

    @if($topics->count())
      <div class="gsearch-section">
        <div class="gsearch-title">Topics</div>
        @foreach($topics as $it)
          <a class="gsearch-item" href="{{ route('topices-details', $it->id) }}">
            <div class="gsearch-thumb">
              <img src="{{ $it->imageUrl ?: asset('assets/img/home_1/post_1.jpg') }}" alt="">
            </div>
            <div>
              <div class="gsearch-name">{{ $it->name }}</div>
              <p class="gsearch-desc">{{ Str::limit(strip_tags($it->description), 80) }}</p>
            </div>
          </a>
        @endforeach
      </div>
    @endif

    @if($vacancies->count())
      <div class="gsearch-section">
        <div class="gsearch-title">Vacancies</div>
        @foreach($vacancies as $it)
          <a class="gsearch-item" href="{{ route('vacancies-details', $it->id) }}">
            <div class="gsearch-thumb">
              <img src="{{ $it->imageUrl ?: asset('assets/img/home_1/post_1.jpg') }}" alt="">
            </div>
            <div>
              <div class="gsearch-name">{{ $it->name }}</div>
              <p class="gsearch-desc">{{ Str::limit(strip_tags($it->description), 80) }}</p>
            </div>
          </a>
        @endforeach
      </div>
    @endif

    @if($resources->count())
      <div class="gsearch-section">
        <div class="gsearch-title">Resources</div>
        @foreach($resources as $it)
          <a class="gsearch-item" href="{{ route('resources-details', $it->id) }}">
            <div class="gsearch-thumb">
              <img src="{{ asset('assets/img/icons/file.svg') }}" alt="">
            </div>
            <div>
              <div class="gsearch-name">{{ $it->name }}</div>
              <p class="gsearch-desc">
                {{ $it->type?->name ?? 'Resource' }}
                @if($it->year) • {{ $it->year }} @endif
                @if($it->mime) • {{ $it->mime }} @endif
              </p>
            </div>
          </a>
        @endforeach
      </div>
    @endif
  @endif
</div>
