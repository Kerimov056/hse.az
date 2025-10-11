@csrf

<div class="mb-3">
  <label class="form-label">Sual</label>
  <input type="text" name="question" class="form-control"
         value="{{ old('question', $faq->question) }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Cavab (Trix editor)</label>
  <input id="answer" type="hidden" name="answer" value="{{ old('answer', $faq->answer) }}">
  <trix-editor input="answer" class="form-control"></trix-editor>
</div>

<div class="form-check mb-3">
  <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
         value="1" @checked(old('is_active', $faq->is_active))>
  <label class="form-check-label" for="is_active">Aktiv</label>
</div>

<div class="d-flex gap-2">
  <button class="btn btn-primary">Yadda saxla</button>
  <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Geri</a>
</div>

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.0.8/dist/trix.css">
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/trix@2.0.8/dist/trix.umd.min.js"></script>
  <script>
    // (İstəyə görə) Trix editor üçün fayl yükləmə
    addEventListener('trix-attachment-add', function (event) {
      const attachment = event.attachment;
      if (attachment.file) {
        uploadTrixAttachment(attachment);
      }
    });

    function uploadTrixAttachment(attachment) {
      const form = new FormData();
      form.append('attachment', attachment.file);

      fetch("{{ route('admin.uploads.trix') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: form
      })
      .then(res => res.json())
      .then(({url, href}) => {
        attachment.setAttributes({ url, href });
      })
      .catch(() => alert('Yükləmə xətası'));
    }
  </script>
@endpush
