{{-- resources/views/admin/gallery_images/_form.blade.php --}}
@csrf

<div class="mb-3">
    <label for="image_url" class="form-label">Şəkil URL</label>
    <input
        type="text"
        name="image_url"
        id="image_url"
        class="form-control @error('image_url') is-invalid @enderror"
        value="{{ old('image_url', $image->image ?? '') }}"
        placeholder="https://example.com/image.jpg"
    >
    @error('image_url')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="text-muted">
        Əgər fayl yükləsəniz, URL avtomatik üstə yazılacaq.
    </small>
</div>

<div class="mb-3">
    <label for="image_file" class="form-label">Şəkil faylı</label>
    <input
        type="file"
        name="image_file"
        id="image_file"
        class="form-control @error('image_file') is-invalid @enderror"
        accept="image/*"
    >
    @error('image_file')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if(!empty($image->image))
    <div class="mb-3">
        <label class="form-label d-block">Cari şəkil</label>
        <img src="{{ $image->image }}" alt="" style="max-width: 200px; height: auto;">
    </div>
@endif
