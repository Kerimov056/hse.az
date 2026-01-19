@extends('layouts.admin')
@section('title','Yeni Kurs')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.4/dist/trix.css">
<style>
  .trix-content { min-height: 260px; }
  .card .form-label { font-weight: 600; }
  .preview-img{max-height:240px;object-fit:cover}
  .input-help{font-size:.9rem;color:#6c757d}
  .badge-type{letter-spacing:.3px}
  .trix-button-group.trix-button-group--file-tools{display:inline-flex;}
  .trix-dialogs{z-index: 1050;}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div>
    <h1 class="mb-1">Yeni Kurs</h1>
    <div class="input-help">Bu hissədə yalnız <span class="badge bg-primary-subtle text-primary border border-primary badge-type">Course</span> yaradırsınız.</div>
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

<form action="{{ route('admin.courses.store') }}" method="post" enctype="multipart/form-data" class="row g-4">
  @csrf

  {{-- SOL --}}
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body p-3 p-md-4">
        <div class="row g-3">

          <div class="col-md-4">
            <label class="form-label">Type</label>
            <input type="text" class="form-control" value="Course" disabled>
            <input type="hidden" name="type" value="course">
            <div class="form-text">Bu bölmədə tip həmişə <b>course</b> olur.</div>
          </div>

          <div class="col-md-8">
            <label class="form-label">Ad *</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}"
                   placeholder="Məs: Fullstack Laravel Bootcamp">
            @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          {{-- NEW --}}
          <div class="col-12">
            <label class="form-label">Course Holding Name (optional)</label>
            <input type="text" name="courseHoldingName" class="form-control"
                   value="{{ old('courseHoldingName') }}" placeholder="Məs: Xezer Academy">
            @error('courseHoldingName')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-12">
            <label class="form-label">Açıqlama</label>
            <input id="description" type="hidden" name="description" value="{{ old('description') }}">
            <trix-editor input="description" class="trix-content border rounded p-2"></trix-editor>
            @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
            <div class="form-text"><small>Şəkil əlavə etmək üçün sürükləyib buraxın və ya fayl ikonundan istifadə edin. (limit: 3MB)</small></div>
          </div>

          <div class="col-12">
            <label class="form-label">Əlavə info (optional)</label>
            <textarea name="info" class="form-control" rows="3">{{ old('info') }}</textarea>
            @error('info')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          {{-- duration / instructor / price --}}
          <div class="col-md-4">
            <label class="form-label">Duration (optional)</label>
            <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="Məs: 6 həftə">
            @error('duration')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-4">
            <label class="form-label">Instructor (optional)</label>
            <input type="text" name="instructor" class="form-control" value="{{ old('instructor') }}" placeholder="Məs: Elvin">
            @error('instructor')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-4">
            <label class="form-label">Price (optional)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" placeholder="Məs: 199">
            @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          {{-- Topics dynamic --}}
          <div class="col-12">
            <label class="form-label">Course Topics (optional)</label>

            @php
              $topics = old('topics', ['']);
              if (!is_array($topics)) $topics = [''];
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

            <div class="form-text">+ ilə yeni mövzu əlavə et, - ilə sil.</div>
            @error('topics')<div class="text-danger small">{{ $message }}</div>@enderror
            @error('topics.*')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Course Link (optional)</label>
            <input type="url" name="courseUrl" class="form-control" value="{{ old('courseUrl') }}" placeholder="https://...">
            @error('courseUrl')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6">
            <label class="form-label">Şəkil (max 3MB)</label>
            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
            @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
            <div class="form-text"><small>Yüklədiyiniz şəkil sağ tərəfdə önizlənəcək.</small></div>
          </div>

        </div>
      </div>
    </div>

    {{-- Sosial linklər --}}
    <div class="card shadow-sm mt-4">
      <div class="card-body p-3 p-md-4">
        <h5 class="card-title mb-3">Sosial linklər (istəyə bağlı)</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Twitter</label>
            <input type="url" name="twitterurl" class="form-control" value="{{ old('twitterurl') }}" placeholder="https://x.com/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">Facebook</label>
            <input type="url" name="facebookurl" class="form-control" value="{{ old('facebookurl') }}" placeholder="https://facebook.com/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">LinkedIn</label>
            <input type="url" name="linkedinurl" class="form-control" value="{{ old('linkedinurl') }}" placeholder="https://linkedin.com/in/...">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="text" name="emailurl" class="form-control" value="{{ old('emailurl') }}" placeholder="user@mail.com və ya mailto:user@mail.com">
          </div>
          <div class="col-md-6">
            <label class="form-label">WhatsApp</label>
            <input type="text" name="whatsappurl" class="form-control" value="{{ old('whatsappurl') }}" placeholder="+994501112233 və ya https://wa.me/...">
          </div>
        </div>
      </div>
    </div>

    <div class="mt-4 d-flex gap-2">
      <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Ləğv et</a>
      <button class="btn btn-primary">Yarat</button>
    </div>
  </div>

  {{-- SAĞ --}}
  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-header fw-semibold">Şəkil önizləmə</div>
      <div class="card-body">
        <img id="previewImg" src="{{ asset('assets/img/placeholder/placeholder-800x500.jpg') }}"
             class="img-fluid rounded border preview-img w-100" alt="preview">
        <div class="mt-3 small text-muted">Fayl seçdikdən sonra burada görünəcək.</div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script src="https://unpkg.com/trix@2.0.4/dist/trix.umd.min.js"></script>

<script>
(function () {
  const imgInput = document.getElementById('imageInput');
  const preview  = document.getElementById('previewImg');
  if (imgInput) {
    imgInput.addEventListener('change', (e) => {
      const f = e.target.files?.[0];
      if (!f) return;
      preview.src = URL.createObjectURL(f);
    });
  }

  const MAX_FILE_SIZE = 3 * 1024 * 1024;
  addEventListener('trix-file-accept', function (event) {
    const file = event.file;
    if (file && file.size > MAX_FILE_SIZE) {
      event.preventDefault();
      alert('Fayl 3MB-dan böyükdür.');
    }
  });

  addEventListener('trix-attachment-add', function (event) {
    const attachment = event.attachment;
    if (attachment && attachment.file) uploadTrixFile(attachment);
  });

  function uploadTrixFile(attachment) {
    const formData = new FormData();
    formData.append('file', attachment.file);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', "{{ route('admin.uploads.trix') }}", true);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

    xhr.upload.addEventListener('progress', (e) => {
      if (e.lengthComputable) {
        attachment.setUploadProgress((e.loaded / e.total) * 100);
      }
    });

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status >= 200 && xhr.status < 300) {
          try {
            const { url } = JSON.parse(xhr.responseText);
            attachment.setAttributes({ url, href: url });
          } catch (e) {
            alert('Serverdən gözlənilməyən cavab.');
          }
        } else {
          alert('Şəkil yüklənmədi. Zəhmət olmasa yenidən cəhd edin.');
        }
      }
    };

    xhr.send(formData);
  }

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
