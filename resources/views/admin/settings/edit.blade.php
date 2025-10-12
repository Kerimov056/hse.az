@extends('layouts.admin')

@section('content')
    <style>
        .form-help {
            font-size: .825rem;
            opacity: .75
        }

        .thumb-prev {
            max-height: 60px;
            border: 1px solid #e5e7eb;
            border-radius: .5rem;
            background: #fff;
            object-fit: contain
        }

        .card+.card {
            margin-top: 1rem
        }

        .repeater-row {
            border: 1px dashed #e5e7eb;
            border-radius: .5rem;
            padding: 10px;
            margin-bottom: 10px;
            background: #fafafa
        }
    </style>

    @php use Illuminate\Support\Str; @endphp

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">Edit Settings</h1>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">Back to Overview</a>
        </div>

        @if (session('ok'))
            <div class="alert alert-success">{{ session('ok') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Xəta!</strong> Zəhmət olmasa sahələri yoxla.
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf

            {{-- SITE --}}
            <div class="card">
                <div class="card-header fw-semibold">Site</div>
                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Site name</label>
                        <input class="form-control" name="site[name]" value="{{ data_get($settings, 'site.name') }}"
                            placeholder="Educve">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" name="site[phone]" value="{{ data_get($settings, 'site.phone') }}"
                            placeholder="+23 (000) 68 603">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" name="site[email]" value="{{ data_get($settings, 'site.email') }}"
                            placeholder="support@educat.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input class="form-control" name="site[address]" value="{{ data_get($settings, 'site.address') }}"
                            placeholder="66 broklyn golden street, New York, USA">
                    </div>

                    {{-- NEW: Site Logo (branding-dən ayrı) --}}
                    <div class="col-md-6">
                        <label class="form-label">Site Logo</label>
                        <input type="file" class="form-control" name="site[logo_file]">
                        @if ($p = data_get($settings, 'site.logo'))
                            @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.ltrim($p,'/')); @endphp
                            <div class="form-help mt-1">Mövcud:</div>
                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Site Logo">
                        @endif
                    </div>
                </div>
            </div>

            {{-- SOCIAL --}}
            <div class="card">
                <div class="card-header fw-semibold">Social</div>
                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Facebook</label>
                        <input class="form-control" name="social[facebook]"
                            value="{{ data_get($settings, 'social.facebook') }}" placeholder="https://fb.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Instagram</label>
                        <input class="form-control" name="social[instagram]"
                            value="{{ data_get($settings, 'social.instagram') }}" placeholder="https://instagram.com/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Twitter/X</label>
                        <input class="form-control" name="social[twitter]"
                            value="{{ data_get($settings, 'social.twitter') }}" placeholder="https://twitter.com/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pinterest</label>
                        <input class="form-control" name="social[pinterest]"
                            value="{{ data_get($settings, 'social.pinterest') }}" placeholder="https://pinterest.com/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">WhatsApp</label>
                        <input class="form-control" name="social[whatsapp]"
                            value="{{ data_get($settings, 'social.whatsapp') }}" placeholder="https://wa.me/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">LinkedIn (opsional)</label>
                        <input class="form-control" name="social[linkedin]"
                            value="{{ data_get($settings, 'social.linkedin') }}"
                            placeholder="https://www.linkedin.com/company/...">
                    </div>
                </div>
            </div>

            {{-- BRANDING --}}
            <div class="card">
                <div class="card-header fw-semibold">Branding</div>
                <div class="card-body row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" name="logo">
                        @if ($p = data_get($settings, 'branding.logo'))
                            @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                            <div class="form-help mt-1">Mövcud:</div>
                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Brand Logo">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Favicon</label>
                        <input type="file" class="form-control" name="favicon">
                        @if ($p = data_get($settings, 'branding.favicon'))
                            @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                            <div class="form-help mt-1">Mövcud:</div>
                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Favicon">
                        @endif
                    </div>
                </div>
            </div>

            {{-- HOME: HERO (NEW) --}}
            <div class="card">
                <div class="card-header fw-semibold">Home – Hero</div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Kicker (üst yazı)</label>
                        <input class="form-control" name="home[hero][kicker]"
                            value="{{ data_get($settings, 'home.hero.kicker') }}" placeholder="Knowledge is Power">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Title (HTML dəstəkləyir)</label>
                        <input class="form-control" name="home[hero][title]"
                            value="{{ data_get($settings, 'home.hero.title') }}"
                            placeholder="<span>Educve</span> - The Best Place to Invest in your Knowledge">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Subtitle</label>
                        <textarea class="form-control" rows="3" name="home[hero][subtitle]"
                            placeholder="A university is a vibrant institution...">{{ data_get($settings, 'home.hero.subtitle') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">CTA Text</label>
                        <input class="form-control" name="home[hero][cta][text]"
                            value="{{ data_get($settings, 'home.hero.cta.text') }}" placeholder="View Our Program">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">CTA URL</label>
                        <input class="form-control" name="home[hero][cta][url]"
                            value="{{ data_get($settings, 'home.hero.cta.url') }}" placeholder="courses-grid-view.html">
                    </div>
                </div>
            </div>

            {{-- HOME: ABOUT --}}
            <div class="card">
                <div class="card-header fw-semibold">Home – About</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Est Year</label>
                            <input class="form-control" name="home[about][est_year]"
                                value="{{ data_get($settings, 'home.about.est_year') }}" placeholder="EST 1995">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kicker</label>
                            <input class="form-control" name="home[about][kicker]"
                                value="{{ data_get($settings, 'home.about.kicker') }}" placeholder="About us">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input class="form-control" name="home[about][title]"
                                value="{{ data_get($settings, 'home.about.title') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Subtitle</label>
                            <textarea class="form-control" rows="3" name="home[about][subtitle]">{{ data_get($settings, 'home.about.subtitle') }}</textarea>
                        </div>

                        {{-- Items --}}
                        <div class="col-12">
                            <label class="form-label d-flex justify-content-between align-items-center">
                                <span>Items</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addAboutItem">+ Add
                                    item</button>
                            </label>
                            <div id="aboutItems">
                                @php $items = data_get($settings,'home.about.items',[]); @endphp
                                @foreach ($items as $i => $it)
                                    <div class="repeater-row" data-index="{{ $i }}">
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <input class="form-control"
                                                    name="home[about][items][{{ $i }}][title]"
                                                    value="{{ data_get($it, 'title') }}" placeholder="Title">
                                            </div>
                                            <div class="col-md-7">
                                                <input class="form-control"
                                                    name="home[about][items][{{ $i }}][text]"
                                                    value="{{ data_get($it, 'text') }}" placeholder="Text">
                                            </div>
                                            <div class="col-md-1 d-grid">
                                                <button type="button"
                                                    class="btn btn-outline-danger remove-row">&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Media --}}
                        <div class="col-md-4">
                            <label class="form-label">Image 1</label>
                            <input type="file" class="form-control" name="home[about][image_1_file]">
                            @if ($p = data_get($settings, 'home.about.image_1'))
                                @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                                <div class="form-help mt-1">Mövcud:</div>
                                <img src="{{ $url }}" class="thumb-prev mt-1" alt="About Image 1">
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Image 2</label>
                            <input type="file" class="form-control" name="home[about][image_2_file]">
                            @if ($p = data_get($settings, 'home.about.image_2'))
                                @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                                <div class="form-help mt-1">Mövcud:</div>
                                <img src="{{ $url }}" class="thumb-prev mt-1" alt="About Image 2">
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Circle Image (SVG)</label>
                            <input type="file" class="form-control" name="home[about][circle_img_file]">
                            @if ($p = data_get($settings, 'home.about.circle_img'))
                                @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                                <div class="form-help mt-1">Mövcud:</div>
                                <img src="{{ $url }}" class="thumb-prev mt-1" alt="About Circle Image">
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">YouTube URL</label>
                            <input class="form-control" name="home[about][video_url]"
                                value="{{ data_get($settings, 'home.about.video_url') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CTA Text</label>
                            <input class="form-control" name="home[about][cta][text]"
                                value="{{ data_get($settings, 'home.about.cta.text') }}" placeholder="More About">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CTA URL</label>
                            <input class="form-control" name="home[about][cta][url]"
                                value="{{ data_get($settings, 'home.about.cta.url') }}"
                                placeholder="courses-grid-view.html">
                        </div>
                    </div>
                </div>
            </div>

            {{-- HOME: FEATURES --}}
            <div class="card">
                <div class="card-header fw-semibold">Home – Features (max 4)</div>
                <div class="card-body row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Kicker</label>
                        <input class="form-control" name="home[features][kicker]"
                            value="{{ data_get($settings, 'home.features.kicker') }}" placeholder="CAMPUS">
                    </div>
                    <div class="col-md-9">
                        <label class="form-label">Title</label>
                        <input class="form-control" name="home[features][title]"
                            value="{{ data_get($settings, 'home.features.title') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Main Image</label>
                        <input type="file" class="form-control" name="home[features][image_file]">
                        @if ($p = data_get($settings, 'home.features.image'))
                            @php $url = Str::startsWith($p, ['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                            <div class="form-help mt-1">Mövcud:</div>
                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Features Main Image">
                        @endif
                    </div>

                    <div class="col-12">
                        <hr>
                    </div>

                    @php $featuresList = data_get($settings,'home.features.list', []); @endphp
                    @for ($i = 0; $i < 4; $i++)
                        @php $row = $featuresList[$i] ?? []; @endphp
                        <div class="col-12">
                            <div class="repeater-row">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label">Item {{ $i + 1 }} Title</label>
                                        <input class="form-control"
                                            name="home[features][list][{{ $i }}][title]"
                                            value="{{ data_get($row, 'title') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Item {{ $i + 1 }} Text (optional)</label>
                                        <input class="form-control"
                                            name="home[features][list][{{ $i }}][text]"
                                            value="{{ data_get($row, 'text') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Icon</label>
                                        <input type="file" class="form-control"
                                            name="home[features][list][{{ $i }}][icon_file]">
                                        @if ($icon = data_get($row, 'icon'))
                                            @php $url = Str::startsWith($icon, ['http','/storage','assets/']) ? asset($icon) : asset('storage/'.$icon); @endphp
                                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Feature Icon">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- HOME: DEPARTMENTS --}}
            <div class="card">
                <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                    <span>Home – Departments (max 8)</span>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addDepartment">+ Add
                        department</button>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Kicker</label>
                            <input class="form-control" name="home[departments][kicker]"
                                value="{{ data_get($settings, 'home.departments.kicker') }}" placeholder="Departments">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Title</label>
                            <input class="form-control" name="home[departments][title]"
                                value="{{ data_get($settings, 'home.departments.title') }}"
                                placeholder="Popular Departments">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Subtitle (supports HTML)</label>
                            <textarea class="form-control" rows="2" name="home[departments][subtitle]">{{ data_get($settings, 'home.departments.subtitle') }}</textarea>
                        </div>
                    </div>

                    <div id="departmentList">
                        @php $deps = data_get($settings, 'home.departments.list', []); @endphp
                        @foreach ($deps as $i => $dep)
                            <div class="repeater-row" data-index="{{ $i }}">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-6">
                                        <label class="form-label">Title</label>
                                        <input class="form-control"
                                            name="home[departments][list][{{ $i }}][title]"
                                            value="{{ data_get($dep, 'title') }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Icon</label>
                                        <input type="file" class="form-control"
                                            name="home[departments][list][{{ $i }}][icon_file]">
                                        @if ($p = data_get($dep, 'icon'))
                                            @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                                            <img src="{{ $url }}" class="thumb-prev mt-1"
                                                alt="Department Icon">
                                        @endif
                                    </div>
                                    <div class="col-md-1 d-grid">
                                        <button type="button" class="btn btn-outline-danger remove-row">&times;</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- HOME: CAMPUS --}}
            <div class="card">
                <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                    <span>Home – Campus</span>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addCampusCard">+ Add card</button>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Title</label>
                            <input class="form-control" name="home[campus][title]"
                                value="{{ data_get($settings, 'home.campus.title') }}" placeholder="Navigate">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Subtitle</label>
                            <input class="form-control" name="home[campus][subtitle]"
                                value="{{ data_get($settings, 'home.campus.subtitle') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">CTA Text</label>
                            <input class="form-control" name="home[campus][cta][text]"
                                value="{{ data_get($settings, 'home.campus.cta.text') }}" placeholder="View All Program">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">CTA URL</label>
                            <input class="form-control" name="home[campus][cta][url]"
                                value="{{ data_get($settings, 'home.campus.cta.url') }}">
                        </div>
                    </div>

                    <div id="campusCards">
                        @php $cards = data_get($settings,'home.campus.cards', []); @endphp
                        @foreach ($cards as $i => $card)
                            <div class="repeater-row" data-index="{{ $i }}">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label">Title</label>
                                        <input class="form-control"
                                            name="home[campus][cards][{{ $i }}][title]"
                                            value="{{ data_get($card, 'title') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">URL</label>
                                        <input class="form-control" name="home[campus][cards][{{ $i }}][url]"
                                            value="{{ data_get($card, 'url') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control"
                                            name="home[campus][cards][{{ $i }}][image_file]">
                                        @if ($p = data_get($card, 'image'))
                                            @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                                            <img src="{{ $url }}" class="thumb-prev mt-1"
                                                alt="Campus Card Image">
                                        @endif
                                    </div>
                                    <div class="col-md-1 d-grid">
                                        <button type="button" class="btn btn-outline-danger remove-row">&times;</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- HOME: VIDEO --}}
            <div class="card">
                <div class="card-header fw-semibold">Home – Video / Contact</div>
                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Heading</label>
                        <input class="form-control" name="home[video][heading]"
                            value="{{ data_get($settings, 'home.video.heading') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">YouTube URL</label>
                        <input class="form-control" name="home[video][youtube_url]"
                            value="{{ data_get($settings, 'home.video.youtube_url') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Background Image</label>
                        <input type="file" class="form-control" name="home[video][bg_image_file]">
                        @if ($p = data_get($settings, 'home.video.bg_image'))
                            @php $url = Str::startsWith($p,['http','/storage','assets/']) ? asset($p) : asset('storage/'.$p); @endphp
                            <div class="form-help mt-1">Mövcud:</div>
                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Video Background">
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Email Label</label>
                        <input class="form-control" name="home[video][contact][email_label]"
                            value="{{ data_get($settings, 'home.video.contact.email_label') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" name="home[video][contact][email]"
                            value="{{ data_get($settings, 'home.video.contact.email') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone Label</label>
                        <input class="form-control" name="home[video][contact][phone_label]"
                            value="{{ data_get($settings, 'home.video.contact.phone_label') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" name="home[video][contact][phone]"
                            value="{{ data_get($settings, 'home.video.contact.phone') }}">
                    </div>
                </div>
            </div>

            <div class="d-grid mt-3">
                <button class="btn btn-success btn-lg">Save</button>
            </div>
        </form>
    </div>

    <script>
        const aboutWrap = document.getElementById('aboutItems');
        const addAboutBtn = document.getElementById('addAboutItem');
        if (addAboutBtn) {
            addAboutBtn.addEventListener('click', () => {
                const idx = aboutWrap.children.length;
                const div = document.createElement('div');
                div.className = 'repeater-row';
                div.innerHTML = `
      <div class="row g-2">
        <div class="col-md-4">
          <input class="form-control" name="home[about][items][${idx}][title]" placeholder="Title">
        </div>
        <div class="col-md-7">
          <input class="form-control" name="home[about][items][${idx}][text]" placeholder="Text">
        </div>
        <div class="col-md-1 d-grid">
          <button type="button" class="btn btn-outline-danger remove-row">&times;</button>
        </div>
      </div>`;
                aboutWrap.appendChild(div);
            });
        }

        const campusWrap = document.getElementById('campusCards');
        const addCampusBtn = document.getElementById('addCampusCard');
        if (addCampusBtn) {
            addCampusBtn.addEventListener('click', () => {
                const idx = campusWrap.children.length;
                const div = document.createElement('div');
                div.className = 'repeater-row';
                div.innerHTML = `
      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label">Title</label>
          <input class="form-control" name="home[campus][cards][${idx}][title]">
        </div>
        <div class="col-md-4">
          <label class="form-label">URL</label>
          <input class="form-control" name="home[campus][cards][${idx}][url]">
        </div>
        <div class="col-md-3">
          <label class="form-label">Image</label>
          <input type="file" class="form-control" name="home[campus][cards][${idx}][image_file]">
        </div>
        <div class="col-md-1 d-grid">
          <button type="button" class="btn btn-outline-danger remove-row">&times;</button>
        </div>
      </div>`;
                campusWrap.appendChild(div);
            });
        }

        const depWrap = document.getElementById('departmentList');
        const addDepBtn = document.getElementById('addDepartment');
        if (addDepBtn) {
            addDepBtn.addEventListener('click', () => {
                const idx = depWrap.children.length;
                if (idx >= 8) return;
                const div = document.createElement('div');
                div.className = 'repeater-row';
                div.innerHTML = `
      <div class="row g-2 align-items-end">
        <div class="col-md-6">
          <label class="form-label">Title</label>
          <input class="form-control" name="home[departments][list][${idx}][title]">
        </div>
        <div class="col-md-5">
          <label class="form-label">Icon</label>
          <input type="file" class="form-control" name="home[departments][list][${idx}][icon_file]">
        </div>
        <div class="col-md-1 d-grid">
          <button type="button" class="btn btn-outline-danger remove-row">&times;</button>
        </div>
      </div>`;
                depWrap.appendChild(div);
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('.repeater-row')?.remove();
            }
        });
    </script>
@endsection
