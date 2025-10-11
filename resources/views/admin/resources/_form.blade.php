@csrf
<div class="row g-3">

  <div class="col-md-6">
    <label class="form-label fw-semibold">Ad *</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name', $resource->name ?? '') }}">
  </div>

  <div class="col-md-3">
    <label class="form-label fw-semibold">İl (opsional)</label>
    <input type="number" name="year" class="form-control" min="1900" max="2100" value="{{ old('year', $resource->year ?? '') }}">
  </div>

  <div class="col-md-3">
    <label class="form-label fw-semibold">Tip *</label>
    <select name="resource_type_id" class="form-select" required>
      <option value="">Seçin…</option>
      @foreach($types as $t)
        <option value="{{ $t->id }}"
          @selected(old('resource_type_id', $resource->resource_type_id ?? '') == $t->id)>
          {{ $t->name }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="col-12">
    <label class="form-label fw-semibold">Fayl {{ empty($resource) ? '*' : '(yeniləmək istəsəniz)' }}</label>
    <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.png,.jpg,.jpeg,.gif,.webp,.mp4,.mov,.avi,.mkv,.mp3,.wav,.zip,.rar,.7z">
    <div class="form-text">Maksimum 20MB. Yükləndikdən sonra GCS üzərindən public URL yaranacaq.</div>

    @isset($resource)
      @if(!empty($resource->resourceUrl))
        <div class="mt-2">
          Cari fayl: <a href="{{ $resource->resourceUrl }}" target="_blank" rel="noopener">{{ $resource->resourceUrl }}</a>
        </div>
      @endif
    @endisset
  </div>

</div>

<div class="mt-3">
  <button class="btn btn-primary">{{ $btn ?? 'Yadda saxla' }}</button>
  <a href="{{ route('admin.resources.index') }}" class="btn btn-light">Geri</a>
</div>
