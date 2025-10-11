@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Kurs adı *</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name', $course->name ?? '') }}">
    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Course URL</label>
    <input type="url" name="courseUrl" class="form-control" value="{{ old('courseUrl', $course->courseUrl ?? '') }}">
    @error('courseUrl')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12">
    <label class="form-label">Təsvir</label>
    <input id="desc-input" type="hidden" name="description" value="{{ old('description', $course->description ?? '') }}">
    <trix-editor input="desc-input" class="form-control"></trix-editor>
    @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
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
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.umd.min.js"></script>

<script>
(function () {
  // CSRF token
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  document.addEventListener('trix-attachment-add', async function (event) {
    const attachment = event.attachment;
    // Yalnız yeni seçilən faylları yükləyirik (mövcud URL-lərə toxunmuruq)
    if (attachment.file) {
      try {
        const form = new FormData();
        form.append('attachment', attachment.file);

        const resp = await fetch("{{ route('admin.uploads.trix') }}", {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': csrf },
          body: form
        });

        if (!resp.ok) {
          throw new Error('Upload failed: ' + resp.status);
        }
        const data = await resp.json();
        if (!data.url) {
          throw new Error('No url in response');
        }

        // Trix-ə şəkil URL-ni yazırıq
        attachment.setAttributes({
          url: data.url,
          href: data.url
        });
      } catch (err) {
        console.error(err);
        alert('Şəkil yüklənmədi. Zəhmət olmasa sonra yenidən cəhd edin.');
      }
    }
  });
})();
</script>
@endpush
