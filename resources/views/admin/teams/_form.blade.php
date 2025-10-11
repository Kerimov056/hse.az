@php
  // Edit zamanı $team ola bilər, create-də null olacaq
  $full_name       = old('full_name',       $team->full_name       ?? '');
  $position        = old('position',        $team->position        ?? '');
  $gender          = old('gender',          $team->gender          ?? 'male');
  $phone           = old('phone',           $team->phone           ?? '');
  $email           = old('email',           $team->email           ?? '');
  $description     = old('description',     $team->description     ?? '');
  $expertise_title = old('expertise_title', $team->expertise_title ?? '');
  $expertise_intro = old('expertise_intro', $team->expertise_intro ?? '');
  $skills          = old('skills',          $team->skills          ?? []); // array([{name,percent}])

  // Default avatar URL-ləri
  $maleDefault   = 'https://t4.ftcdn.net/jpg/14/05/81/37/360_F_1405813706_e7f6ONwQ8KD8bRbinELfD1jazaXGB5q3.jpg';
  $femaleDefault = 'https://img.freepik.com/premium-vector/portrait-business-woman_505024-2793.jpg?semt=ais_hybrid&w=740&q=80';

  $currentThumb = $team->imageUrl ?? null;
  if (!$currentThumb) {
      $currentThumb = ($gender === 'female') ? $femaleDefault : $maleDefault;
  }
@endphp

@csrf {{-- CSRF mütləq olsun --}}

{{-- Errors --}}
@if ($errors->any())
  <div class="alert alert-danger">
    <div class="fw-bold mb-1">Xəta:</div>
    <ul class="mb-0 ps-3">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="row g-4">
  {{-- Left: Foto və əsas məlumat --}}
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex flex-column align-items-center text-center">
          <img id="avatarPreview"
               src="{{ $currentThumb }}"
               alt="Avatar"
               style="width:140px;height:186px;object-fit:cover;border-radius:12px;border:1px solid #eee">
          <div class="mt-3 w-100">
            <label for="image" class="form-label">Şəkil (3x4) — opsional</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <div class="form-text">
              Şəkil yükləməsəniz, cinsə görə <b>default avatar</b> istifadə olunacaq.
            </div>
          </div>

          <div class="mt-3 w-100">
            <label class="form-label">Cins <span class="text-danger">*</span></label>
            <div class="d-flex gap-3">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male"  {{ $gender === 'male' ? 'checked' : '' }}>
                <label class="form-check-label" for="genderMale">Kişi</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" {{ $gender === 'female' ? 'checked' : '' }}>
                <label class="form-check-label" for="genderFemale">Qadın</label>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- Right: Məlumat formu --}}
  <div class="col-lg-8">
    <div class="card h-100">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Ad Soyad <span class="text-danger">*</span></label>
            <input type="text" name="full_name" value="{{ $full_name }}" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Vəzifə</label>
            <input type="text" name="position" value="{{ $position }}" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" value="{{ $phone }}" class="form-control" placeholder="+994 xx xxx xx xx">
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ $email }}" class="form-control" placeholder="name@example.com">
          </div>

          <div class="col-12">
            <label class="form-label">Qısa Başlıq (My Expertise)</label>
            <input type="text" name="expertise_title" value="{{ $expertise_title }}" class="form-control" placeholder="Məs: Leadership & Management">
          </div>

          <div class="col-12">
            <label class="form-label">Giriş mətni (expertise intro)</label>
            <textarea name="expertise_intro" rows="3" class="form-control" placeholder="Qısa tanıtım mətni...">{{ $expertise_intro }}</textarea>
          </div>

          <div class="col-12">
            <label class="form-label">Haqqında (Description)</label>
            {{-- Rich text (Trix) --}}
            <input id="desc-input" type="hidden" name="description" value="{{ $description }}">
            <trix-editor input="desc-input" class="trix-content"></trix-editor>
          </div>

          {{-- Skills repeater --}}
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <label class="form-label m-0">Bacarıqlar (faizlə)</label>
              <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddSkill">+ Bacarıq əlavə et</button>
            </div>

            <div id="skillsList" class="vstack gap-2">
              @forelse($skills as $row)
                @php
                  $sName = $row['name']    ?? ($row->name    ?? '');
                  $sPerc = $row['percent'] ?? ($row->percent ?? 0);
                @endphp
                <div class="card shadow-sm skill-item">
                  <div class="card-body py-2">
                    <div class="row g-2 align-items-center">
                      <div class="col-md-7">
                        <input type="text" class="form-control" name="skill_name[]" value="{{ $sName }}" placeholder="Bacarıq adı (məs: Management)">
                      </div>
                      <div class="col-md-3">
                        <div class="input-group">
                          <input type="number" class="form-control" name="skill_percent[]" value="{{ (int)$sPerc }}" min="0" max="100">
                          <span class="input-group-text">%</span>
                        </div>
                      </div>
                      <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm btnRemoveSkill">Sil</button>
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                {{-- boş gəlirsə 1 sətir göstər --}}
                <div class="card shadow-sm skill-item">
                  <div class="card-body py-2">
                    <div class="row g-2 align-items-center">
                      <div class="col-md-7">
                        <input type="text" class="form-control" name="skill_name[]" placeholder="Bacarıq adı (məs: Management)">
                      </div>
                      <div class="col-md-3">
                        <div class="input-group">
                          <input type="number" class="form-control" name="skill_percent[]" value="0" min="0" max="100">
                          <span class="input-group-text">%</span>
                        </div>
                      </div>
                      <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-outline-danger btn-sm btnRemoveSkill">Sil</button>
                      </div>
                    </div>
                  </div>
                </div>
              @endforelse
            </div>

            {{-- template --}}
            <template id="skillTemplate">
              <div class="card shadow-sm skill-item">
                <div class="card-body py-2">
                  <div class="row g-2 align-items-center">
                    <div class="col-md-7">
                      <input type="text" class="form-control" name="skill_name[]" placeholder="Bacarıq adı">
                    </div>
                    <div class="col-md-3">
                      <div class="input-group">
                        <input type="number" class="form-control" name="skill_percent[]" value="0" min="0" max="100">
                        <span class="input-group-text">%</span>
                      </div>
                    </div>
                    <div class="col-md-2 text-end">
                      <button type="button" class="btn btn-outline-danger btn-sm btnRemoveSkill">Sil</button>
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
  {{-- Trix editor --}}
  <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endpush

@push('scripts')
  <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
  <script>
    (function(){
      const maleDefault   = @json($maleDefault);
      const femaleDefault = @json($femaleDefault);

      const imgInput = document.getElementById('image');
      const avatar   = document.getElementById('avatarPreview');
      const gMale    = document.getElementById('genderMale');
      const gFemale  = document.getElementById('genderFemale');

      // Şəkil seçildikdə ön-baxış
      imgInput.addEventListener('change', function(){
        if (this.files && this.files[0]) {
          const reader = new FileReader();
          reader.onload = e => avatar.src = e.target.result;
          reader.readAsDataURL(this.files[0]);
        } else {
          avatar.src = gFemale.checked ? femaleDefault : maleDefault;
        }
      });

      // Gender dəyişəndə, şəkil seçilməyibsə default avatarı dəyiş
      [gMale, gFemale].forEach(r => r.addEventListener('change', () => {
        if (!imgInput.files || imgInput.files.length === 0) {
          avatar.src = gFemale.checked ? femaleDefault : maleDefault;
        }
      }));

      // Skills: əlavə/sil
      const list = document.getElementById('skillsList');
      const tpl  = document.getElementById('skillTemplate');
      document.getElementById('btnAddSkill').addEventListener('click', () => {
        const node = tpl.content.cloneNode(true);
        list.appendChild(node);
      });
      list.addEventListener('click', (e) => {
        if (e.target.closest('.btnRemoveSkill')) {
          const item = e.target.closest('.skill-item');
          item?.remove();
        }
      });
    })();
  </script>
@endpush
