@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Topic adı *</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name', $topic->name ?? '') }}">
    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">External URL (optional)</label>
    <input type="url" name="courseUrl" class="form-control" value="{{ old('courseUrl', $topic->courseUrl ?? '') }}">
    @error('courseUrl')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12">
    <label class="form-label">Təsvir</label>
    <input id="desc-input" type="hidden" name="description" value="{{ old('description', $topic->description ?? '') }}">
    <trix-editor input="desc-input" class="form-control"></trix-editor>
    @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
    <div class="form-text"><small>Editor içində şəkil əlavə etmək üçün faylı sürükləyib buraxın. (limit: 3MB)</small></div>
  </div>

  <div class="col-md-6">
    <label class="form-label">Şəkil (upload)</label>
    <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
    @error('image')<div class="text-danger small">{{ $message }}</div>@enderror

    @if(!empty($topic?->imageUrl))
      <div class="mt-2">
        <img id="previewImg" src="{{ $topic->imageUrl }}" alt="" style="height:60px" class="rounded">
      </div>
    @else
      <div class="mt-2">
        <img id="previewImg" src="{{ asset('assets/img/placeholder/placeholder-800x500.jpg') }}" alt="" style="height:60px" class="rounded">
      </div>
    @endif
  </div>

  <div class="col-12"><hr><strong>Sosial Linklər</strong></div>
  @php $s = isset($topic) && $topic->socialLink ? $topic->socialLink : null; @endphp

  <div class="col-md-6">
    <label class="form-label">Twitter URL</label>
    <input type="url" name="twitterurl" class="form-control" value="{{ old('twitterurl', $s->twitterurl ?? '') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">Facebook URL</label>
    <input type="url" name="facebookurl" class="form-control" value="{{ old('facebookurl', $s->facebookurl ?? '') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">LinkedIn URL</label>
    <input type="url" name="linkedinurl" class="form-control" value="{{ old('linkedinurl', $s->linkedinurl ?? '') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">Email (mailto:… ola bilər)</label>
    <input type="text" name="emailurl" class="form-control" value="{{ old('emailurl', $s->emailurl ?? '') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">WhatsApp</label>
    <input type="text" name="whatsappurl" class="form-control" value="{{ old('whatsappurl', $s->whatsappurl ?? '') }}">
  </div>
</div>

<div class="mt-3">
  <button class="btn btn-primary">{{ $btn ?? 'Yadda saxla' }}</button>
  <a href="{{ route('admin.topices.index') }}" class="btn btn-light">Geri</a>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.css">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.umd.min.js"></script>
<script>
(function () {
  // preview
  const input = document.getElementById('imageInput');
  const img   = document.getElementById('previewImg');
  if (input && img) {
    input.addEventListener('change', e => {
      const f = e.target.files?.[0];
      if (!f) return;
      img.src = URL.createObjectURL(f);
    });
  }

  // Trix upload -> admin.uploads.trix
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  document.addEventListener('trix-file-accept', function (event) {
    const file = event.file;
    if (file && file.size > 3 * 1024 * 1024) {
      event.preventDefault();
      alert('Fayl 3MB-dan böyükdür.');
    }
  });

  document.addEventListener('trix-attachment-add', async function (event) {
    const attachment = event.attachment;
    if (!attachment.file) return;

    try {
      const form = new FormData();
      form.append('file', attachment.file);

      const resp = await fetch("{{ route('admin.uploads.trix') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf },
        body: form
      });

      if (!resp.ok) throw new Error('Upload failed');
      const data = await resp.json();
      if (!data.url) throw new Error('No url');

      attachment.setAttributes({ url: data.url, href: data.url });
    } catch (e) {
      console.error(e);
      alert('Şəkil yüklənmədi, yenidən cəhd edin.');
    }
  });
})();
</script>
@endpush
