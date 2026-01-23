@extends('layouts.admin')
@section('title','Kursu redaktə et')

@push('styles')
<style>
  .card .form-label { font-weight: 600; }
  .preview-img{max-height:260px;object-fit:cover}
  .badge-type{letter-spacing:.3px}

  /* Description rows */
  .desc-row textarea { resize: vertical; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div>
    <h1 class="mb-1">Kursu redaktə et</h1>
    <div class="input-help">Bu obyekt <span class="badge bg-primary-subtle text-primary border border-primary badge-type">Course</span> tipindədir.</div>
  </div>
  <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">← Siyahıya qayıt</a>
</div>

@if ($errors->any())
  <div class="alert alert-danger">
    <div class="fw-semibold mb-1">Formada xətalar var:</div>
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@php
  $topics = old('topics', $course->courseTopics?->pluck('title')->values()->all() ?? ['']);
  if (!is_array($topics)) $topics = [''];
  if (count($topics) === 0) $topics = [''];
@endphp

<form action="{{ route('admin.courses.update', $course) }}" method="post" enctype="multipart/form-data" class="row g-4">
  @csrf
  @method('PUT')

  {{-- SOL --}}
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body p-3 p-md-4">
        <div class="row g-3">

          <div class="col-md-4">
            <label class="form-label">Type</label>
            <input type="text" class="form-control" value="Course" disabled>
            <input type="hidden" name="type" value="course">
            <div class="form-text">Tip dəyişdirilə bilməz.</div>
          </div>

          <div class="col-md-8">
            <label class="form-label">Ad *</label>
            <input type="text" name="name" class="form-control" required
                   value="{{ old('name', $course->name) }}" placeholder="Məs: Fullstack Laravel Bootcamp">
            @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-12">
            <label class="form-label">Course Holding Name (optional)</label>
            <input type="text" name="courseHoldingName" class="form-control"
                   value="{{ old('courseHoldingName', $course->courseHoldingName ?? '') }}"
                   placeholder="Məs: Xezer Academy">
            @error('courseHoldingName')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          {{-- ✅ DESCRIPTION (dynamic rows -> single hidden description) --}}
          <div class="col-12">
            <label class="form-label">Açıqlama (Accordion bölmələri)</label>

            <input id="description" type="hidden" name="description"
                   value="{{ old('description', $course->description) }}">

            <div id="descWrap" class="vstack gap-2"></div>

            <div class="form-text">
              Bu hissə DB-də yenə 1 dənə <b>description</b> kimi saxlanacaq. Sadəcə admin üçün bölünmüş editor olacaq.
            </div>

            @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-12">
            <label class="form-label">Əlavə info (optional)</label>
            <textarea name="info" class="form-control" rows="3">{{ old('info', $course->info ?? '') }}</textarea>
            @error('info')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-4">
            <label class="form-label">Duration (optional)</label>
            <input type="text" name="duration" class="form-control"
                   value="{{ old('duration', $course->duration ?? '') }}" placeholder="Məs: 6 həftə">
            @error('duration')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-4">
            <label class="form-label">Instructor (optional)</label>
            <input type="text" name="instructor" class="form-control"
                   value="{{ old('instructor', $course->instructor ?? '') }}" placeholder="Məs: Elvin">
            @error('instructor')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-4">
            <label class="form-label">Price (optional)</label>
            <input type="number" step="0.01" name="price" class="form-control"
                   value="{{ old('price', $course->price ?? '') }}" placeholder="Məs: 199">
            @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          {{-- Topics dynamic --}}
          <div class="col-12">
            <label class="form-label">Course Topics (optional)</label>

            <div id="topicsWrap" class="vstack gap-2">
              @foreach($topics as $i => $val)
                <div class="d-flex gap-2 align-items-center topic-row">
                  <input type="text" name="topics[]" class="form-control"
                         placeholder="Məs: HTML, CSS, Laravel..." value="{{ $val }}">

                  <button type="button" class="btn btn-outline-primary btn-add-topic" title="Əlavə et">
                    <i class="bi bi-plus-lg"></i>
                  </button>

                  <button type="button" class="btn btn-outline-danger btn-remove-topic" title="Sil">
                    <i class="bi bi-dash-lg"></i>
                  </button>
                </div>
              @endforeach
            </div>

            <div class="form-text">+ ilə yeni mövzu əlavə et, - ilə sil.</div>
            @error('topics')<div class="text-danger small">{{ $message }}</div>@enderror
            @error('topics.*')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Course Link (optional)</label>
            <input type="url" name="courseUrl" class="form-control"
                   value="{{ old('courseUrl', $course->courseUrl) }}" placeholder="https://...">
            @error('courseUrl')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Şəkil (max 3MB)</label>
            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
            @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
            <div class="form-text">Yükləsəniz, mövcud şəkil yenilənəcək.</div>
          </div>

        </div>
      </div>
    </div>

    {{-- Sosial linklər --}}
    <div class="card shadow-sm mt-4">
      <div class="card-body p-3 p-md-4">
        <h5 class="card-title mb-3">Sosial linklər (istəyə bağlı)</h5>
        @php $sl = $course->socialLink; @endphp
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Twitter</label>
            <input type="url" name="twitterurl" class="form-control"
                   value="{{ old('twitterurl', $sl->twitterurl ?? '') }}" placeholder="https://x.com/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">Facebook</label>
            <input type="url" name="facebookurl" class="form-control"
                   value="{{ old('facebookurl', $sl->facebookurl ?? '') }}" placeholder="https://facebook.com/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">LinkedIn</label>
            <input type="url" name="linkedinurl" class="form-control"
                   value="{{ old('linkedinurl', $sl->linkedinurl ?? '') }}" placeholder="https://linkedin.com/in/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="text" name="emailurl" class="form-control"
                   value="{{ old('emailurl', $sl->emailurl ?? '') }}" placeholder="user@mail.com və ya mailto:user@mail.com">
          </div>
          <div class="col-md-6">
            <label class="form-label">WhatsApp</label>
            <input type="text" name="whatsappurl" class="form-control"
                   value="{{ old('whatsappurl', $sl->whatsappurl ?? '') }}" placeholder="+994501112233 və ya https://wa.me/...">
          </div>
        </div>
      </div>
    </div>

    <div class="mt-4 d-flex gap-2">
      <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Ləğv et</a>
      <button class="btn btn-primary">Yadda saxla</button>
    </div>
  </div>

  {{-- SAĞ --}}
  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <span class="fw-semibold">Mövcud şəkil</span>
        <span class="text-muted">#{{ $course->id }}</span>
      </div>
      <div class="card-body">
        @if($course->imageUrl)
          <img id="previewImg" src="{{ $course->imageUrl }}" class="img-fluid rounded border preview-img w-100" alt="Course image">
        @else
          <img id="previewImg" src="{{ asset('assets/img/placeholder/placeholder-800x500.jpg') }}" class="img-fluid rounded border preview-img w-100" alt="Course image">
        @endif
        <div class="mt-3 small text-muted">
          Baxış sayı: <b>{{ $course->views }}</b><br>
          Son yenilənmə: <b>{{ optional($course->updated_at)->format('d.m.Y H:i') }}</b>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
  // preview image
  const imgInput = document.getElementById('imageInput');
  const preview  = document.getElementById('previewImg');
  if (imgInput && preview) {
    imgInput.addEventListener('change', (e) => {
      const f = e.target.files?.[0];
      if (!f) return;
      preview.src = URL.createObjectURL(f);
    });
  }

  // ===== DESCRIPTION: parse existing + rows -> hidden description =====
  const descWrap = document.getElementById('descWrap');
  const hiddenDesc = document.getElementById('description');
  if (descWrap && hiddenDesc) {

    function escapeHtml(str) {
      return (str ?? '').toString()
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
    }

    function makeDescRow(title = '', text = '') {
      const div = document.createElement('div');
      div.className = 'border rounded p-2 desc-row';
      div.innerHTML = `
        <div class="d-flex gap-2 align-items-center mb-2">
          <input type="text" class="form-control desc-title" placeholder="Başlıq (məs: Registration)" value="${escapeHtml(title)}">
          <button type="button" class="btn btn-outline-primary btn-add-desc" title="Əlavə et"><i class="bi bi-plus-lg"></i></button>
          <button type="button" class="btn btn-outline-danger btn-remove-desc" title="Sil"><i class="bi bi-dash-lg"></i></button>
        </div>
        <textarea class="form-control desc-text" rows="3" placeholder="Mətn...">${escapeHtml(text)}</textarea>
      `;
      return div;
    }

    function refreshDescButtons() {
      const rows = descWrap.querySelectorAll('.desc-row');
      rows.forEach((row, idx) => {
        const addBtn = row.querySelector('.btn-add-desc');
        const removeBtn = row.querySelector('.btn-remove-desc');
        if (addBtn) addBtn.style.display = (idx === rows.length - 1) ? 'inline-flex' : 'none';
        if (removeBtn) removeBtn.disabled = (rows.length === 1);
      });
    }

    function serializeDesc() {
      const rows = descWrap.querySelectorAll('.desc-row');
      let html = '';

      rows.forEach((row) => {
        const title = row.querySelector('.desc-title')?.value?.trim() ?? '';
        const text  = row.querySelector('.desc-text')?.value?.trim() ?? '';
        if (!title && !text) return;

        const safeTitle = escapeHtml(title);
        const safeText  = escapeHtml(text).replaceAll('\n', '<br>');

        html += `<section data-desc-item="1">` +
                `<h3>${safeTitle}</h3>` +
                `<div data-desc-body="1">${safeText}</div>` +
                `</section>`;
      });

      hiddenDesc.value = html;
    }

    function parseExisting() {
      const raw = hiddenDesc.value || '';

      // Our format
      if (raw.includes('data-desc-item="1"')) {
        const tmp = document.createElement('div');
        tmp.innerHTML = raw;

        const sections = Array.from(tmp.querySelectorAll('section[data-desc-item="1"]'));
        if (sections.length) {
          descWrap.innerHTML = '';
          sections.forEach(sec => {
            const t = (sec.querySelector('h3')?.textContent ?? '').trim();

            const bodyEl = sec.querySelector('[data-desc-body="1"]');
            let b = '';
            if (bodyEl) {
              // br -> \n, then strip to text
              let htmlBody = bodyEl.innerHTML
                .replaceAll('<br>', '\n')
                .replaceAll('<br/>', '\n')
                .replaceAll('<br />', '\n');

              const tmp2 = document.createElement('div');
              tmp2.innerHTML = htmlBody;
              b = (tmp2.textContent || tmp2.innerText || '').trim();
            }

            descWrap.appendChild(makeDescRow(t, b));
          });

          return;
        }
      }

      // fallback: 1 row with plain text
      descWrap.innerHTML = '';
      const tmp = document.createElement('div');
      tmp.innerHTML = raw;
      const text = (tmp.textContent || tmp.innerText || '').trim();
      descWrap.appendChild(makeDescRow('', text));
    }

    descWrap.addEventListener('click', (e) => {
      const add = e.target.closest('.btn-add-desc');
      const remove = e.target.closest('.btn-remove-desc');

      if (add) {
        descWrap.appendChild(makeDescRow('', ''));
        refreshDescButtons();
        serializeDesc();
        const rows = descWrap.querySelectorAll('.desc-row');
        rows[rows.length - 1]?.querySelector('.desc-title')?.focus();
        return;
      }

      if (remove) {
        const rows = descWrap.querySelectorAll('.desc-row');
        if (rows.length === 1) return;
        remove.closest('.desc-row')?.remove();
        refreshDescButtons();
        serializeDesc();
        return;
      }
    });

    descWrap.addEventListener('input', () => serializeDesc());

    // init: parse old description into rows
    parseExisting();
    refreshDescButtons();
    serializeDesc();
  }

  // ===== TOPICS (səndəki kimi) =====
  const wrap = document.getElementById('topicsWrap');
  if (!wrap) return;

  function refreshButtons() {
    const rows = wrap.querySelectorAll('.topic-row');
    rows.forEach((row, idx) => {
      const addBtn = row.querySelector('.btn-add-topic');
      const removeBtn = row.querySelector('.btn-remove-topic');
      addBtn.style.display = (idx === rows.length - 1) ? 'inline-flex' : 'none';
      removeBtn.disabled = (rows.length === 1);
    });
  }

  function escapeHtml(str) {
    return (str ?? '').toString()
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }

  function makeRow(value = '') {
    const div = document.createElement('div');
    div.className = 'd-flex gap-2 align-items-center topic-row';
    div.innerHTML = `
      <input type="text" name="topics[]" class="form-control" placeholder="Məs: HTML, CSS, Laravel..." value="${escapeHtml(value)}">
      <button type="button" class="btn btn-outline-primary btn-add-topic" title="Əlavə et"><i class="bi bi-plus-lg"></i></button>
      <button type="button" class="btn btn-outline-danger btn-remove-topic" title="Sil"><i class="bi bi-dash-lg"></i></button>
    `;
    return div;
  }

  wrap.addEventListener('click', function (e) {
    const add = e.target.closest('.btn-add-topic');
    const remove = e.target.closest('.btn-remove-topic');

    if (add) {
      wrap.appendChild(makeRow(''));
      refreshButtons();
      const inputs = wrap.querySelectorAll('input[name="topics[]"]');
      inputs[inputs.length - 1].focus();
      return;
    }

    if (remove) {
      const rows = wrap.querySelectorAll('.topic-row');
      if (rows.length === 1) return;
      remove.closest('.topic-row')?.remove();
      refreshButtons();
      return;
    }
  });

  wrap.addEventListener('keydown', function (e) {
    if (e.key !== 'Enter') return;
    if (!(e.target && e.target.name === 'topics[]')) return;
    e.preventDefault();
    wrap.appendChild(makeRow(''));
    refreshButtons();
    const inputs = wrap.querySelectorAll('input[name="topics[]"]');
    inputs[inputs.length - 1].focus();
  });

  refreshButtons();
})();
</script>
@endpush
