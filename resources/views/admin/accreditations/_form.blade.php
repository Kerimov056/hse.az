@csrf

<div class="mb-3">
  <label class="form-label">Şəkil (opsional)</label>
  @if(!empty($item->imageUrl))
    <div class="mb-2">
      <img src="{{ $item->imageUrl }}" alt="image" style="max-width:240px;border-radius:8px">
    </div>
  @endif
  <input type="file" class="form-control" name="image" accept="image/*">
  <div class="form-text">Maks. 4MB. PNG/JPG/WebP.</div>
</div>

<div class="mb-3">
  <label class="form-label">Açıqlama</label>
  <span class="text-danger">Burda daxil etdiyiniz ilk soz Accreditations adi kimi qeyd olunacaq.</span>
  {{-- Trix: hidden input + editor --}}
  <input id="description" type="hidden" name="description" value="{{ old('description', $item->description) }}">
  <trix-editor input="description" class="form-control"></trix-editor>
</div>

<div class="d-flex gap-2">
  <button class="btn btn-primary">Yadda saxla</button>
  <a href="{{ route('admin.accreditations.index') }}" class="btn btn-outline-secondary">Geri</a>
</div>

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.0.8/dist/trix.css">
@endpush
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/trix@2.0.8/dist/trix.umd.min.js"></script>
  <script>
    // (istəsən) Trix-ə upload endpoint qoşmaq olar: route('admin.uploads.trix')
    addEventListener('trix-attachment-add', function (event) {
      const attachment = event.attachment;
      if (attachment.file) {
        uploadTrixAttachment(attachment);
      }
    });

    function uploadTrixAttachment(attachment) {
      const file = attachment.file;
      const form = new FormData();
      form.append('attachment', file);

      fetch("{{ route('admin.uploads.trix') }}", {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: form
      })
      .then(res => res.json())
      .then(({url, href}) => {
        attachment.setAttributes({url, href});
      })
      .catch(() => alert('Yükləmə xətası'));
    }
  </script>
@endpush
