@csrf

<div class="row g-3">

  <div class="col-md-6">
    <label class="form-label">Kurs adı *</label>
    <input type="text" name="name" class="form-control" required
           value="{{ old('name', $course->name ?? '') }}">
    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Course Holding Name (optional)</label>
    <input type="text" name="courseHoldingName" class="form-control"
           value="{{ old('courseHoldingName', $course->courseHoldingName ?? '') }}"
           placeholder="Məs: Xezer Academy">
    @error('courseHoldingName')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Course URL</label>
    <input type="url" name="courseUrl" class="form-control"
           value="{{ old('courseUrl', $course->courseUrl ?? '') }}">
    @error('courseUrl')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12">
    <label class="form-label">Təsvir</label>
    <input id="desc-input" type="hidden" name="description"
           value="{{ old('description', $course->description ?? '') }}">
    <trix-editor input="desc-input" class="form-control trix-content"></trix-editor>
    @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  {{-- info (optional) --}}
  <div class="col-12">
    <label class="form-label">Əlavə info (optional)</label>
    <textarea name="info" class="form-control" rows="3">{{ old('info', $course->info ?? '') }}</textarea>
    @error('info')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  {{-- duration / instructor / price --}}
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

  {{-- TOPICS (dynamic) --}}
  <div class="col-12">
    <label class="form-label">Course Topics (optional)</label>

    @php
      $topics = old('topics',
        $courseTopics
          ?? (isset($course) ? ($course->courseTopics?->pluck('title')->values()->all() ?? []) : [])
      );

      if (!is_array($topics)) $topics = [];
      if (count($topics) === 0) $topics = [''];
    @endphp

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

    <div class="form-text">Hər mövzu üçün ayrı input. + ilə artır, - ilə sil.</div>

    @error('topics')<div class="text-danger small">{{ $message }}</div>@enderror
    @error('topics.*')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Şəkil (upload)</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    @error('image')<div class="text-danger small">{{ $message }}</div>@enderror

    @if(!empty($course?->imageUrl))
      <div class="mt-2">
        <img src="{{ $course->imageUrl }}" alt="" style="height:60px" class="rounded">
      </div>
    @endif
  </div>

  <div class="col-12"><hr><strong>Sosial Linklər</strong></div>
  @php $s = isset($course) && $course->socialLink ? $course->socialLink : null; @endphp

  <div class="col-md-6">
    <label class="form-label">Twitter URL</label>
    <input type="url" name="twitterurl" class="form-control" value="{{ old('twitterurl', $s->twitterurl ?? '') }}">
    @error('twitterurl')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Facebook URL</label>
    <input type="url" name="facebookurl" class="form-control" value="{{ old('facebookurl', $s->facebookurl ?? '') }}">
    @error('facebookurl')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">LinkedIn URL</label>
    <input type="url" name="linkedinurl" class="form-control" value="{{ old('linkedinurl', $s->linkedinurl ?? '') }}">
    @error('linkedinurl')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Email URL (mailto:… ola bilər)</label>
    <input type="text" name="emailurl" class="form-control" value="{{ old('emailurl', $s->emailurl ?? '') }}">
    @error('emailurl')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">WhatsApp URL</label>
    <input type="text" name="whatsappurl" class="form-control" value="{{ old('whatsappurl', $s->whatsappurl ?? '') }}">
    @error('whatsappurl')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
</div>

<div class="mt-3">
  <button class="btn btn-primary">{{ $btn ?? 'Yadda saxla' }}</button>
  <a href="{{ route('admin.courses.index') }}" class="btn btn-light">Geri</a>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.css">
<style>
  .trix-content { min-height: 220px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.umd.min.js"></script>

<script>
(function () {
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  document.addEventListener('trix-attachment-add', async function (event) {
    const attachment = event.attachment;
    if (attachment.file) {
      try {
        const form = new FormData();
        form.append('file', attachment.file);

        const resp = await fetch("{{ route('admin.uploads.trix') }}", {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': csrf },
          body: form
        });

        if (!resp.ok) throw new Error('Upload failed: ' + resp.status);

        const data = await resp.json();
        if (!data.url) throw new Error('No url in response');

        attachment.setAttributes({ url: data.url, href: data.url });
      } catch (err) {
        console.error(err);
        alert('Şəkil yüklənmədi. Zəhmət olmasa sonra yenidən cəhd edin.');
      }
    }
  });

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
      <button type="button" class="btn btn-outline-primary btn-add-topic" title="Əlavə et">
        <i class="bi bi-plus-lg"></i>
      </button>
      <button type="button" class="btn btn-outline-danger btn-remove-topic" title="Sil">
        <i class="bi bi-dash-lg"></i>
      </button>
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
