@csrf
<div class="row g-3">
  <div class="col-md-4">
    <label class="form-label">Type</label>
    <input type="text" class="form-control" value="Service" disabled>
    <input type="hidden" name="type" value="service">
  </div>

  <div class="col-md-8">
    <label class="form-label">Ad *</label>
    <input type="text" name="name" class="form-control" required value="{{ old('name', $service->name ?? '') }}">
  </div>

  <div class="col-12">
    <label class="form-label">Açıqlama</label>
    <input id="desc-input" type="hidden" name="description" value="{{ old('description', $service->description ?? '') }}">
    <trix-editor input="desc-input" class="trix-content border rounded p-2"></trix-editor>
  </div>

  <div class="col-md-6">
    <label class="form-label">Service URL</label>
    <input type="url" name="courseUrl" class="form-control" value="{{ old('courseUrl', $service->courseUrl ?? '') }}">
  </div>

  <div class="col-md-6">
    <label class="form-label">Şəkil (upload)</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    @if(!empty($service?->imageUrl))
      <div class="mt-2"><img src="{{ $service->imageUrl }}" alt="" style="height:60px" class="rounded"></div>
    @endif
  </div>

  <div class="col-12"><hr><strong>Sosial Linklər</strong></div>
  @php $s = isset($service) && $service->socialLink ? $service->socialLink : null; @endphp

  <div class="col-md-6"><label class="form-label">Twitter</label>
    <input type="url" name="twitterurl" class="form-control" value="{{ old('twitterurl', $s->twitterurl ?? '') }}"></div>
  <div class="col-md-6"><label class="form-label">Facebook</label>
    <input type="url" name="facebookurl" class="form-control" value="{{ old('facebookurl', $s->facebookurl ?? '') }}"></div>
  <div class="col-md-6"><label class="form-label">LinkedIn</label>
    <input type="url" name="linkedinurl" class="form-control" value="{{ old('linkedinurl', $s->linkedinurl ?? '') }}"></div>
  <div class="col-md-6"><label class="form-label">Email</label>
    <input type="text" name="emailurl" class="form-control" value="{{ old('emailurl', $s->emailurl ?? '') }}"></div>
  <div class="col-md-6"><label class="form-label">WhatsApp</label>
    <input type="text" name="whatsappurl" class="form-control" value="{{ old('whatsappurl', $s->whatsappurl ?? '') }}"></div>
</div>

<div class="mt-3">
  <button class="btn btn-primary">{{ $btn ?? 'Yadda saxla' }}</button>
  <a href="{{ route('admin.services.index') }}" class="btn btn-light">Geri</a>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.4/dist/trix.css">
@endpush
@push('scripts')
<script src="https://unpkg.com/trix@2.0.4/dist/trix.umd.min.js"></script>
@endpush
