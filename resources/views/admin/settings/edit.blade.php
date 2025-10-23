@extends('layouts.admin')
@section('title', 'Edit Settings')

@push('styles')
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

        .sticky-save {
            position: sticky;
            bottom: 0;
            z-index: 10;
            background: #ffffffcc;
            backdrop-filter: saturate(1.2) blur(6px);
            border-top: 1px solid #e5e7eb
        }

        .section-note {
            font-size: .9rem;
            color: #64748b
        }

        details>summary {
            cursor: pointer
        }

        /* Pages → Hero Images */
        .hero-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px
        }

        .hero-item {
            border: 1px solid #e5e7eb;
            border-radius: .5rem;
            padding: 8px;
            background: #fff;
            position: relative
        }

        .hero-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: .35rem
        }

        .hero-item .small {
            font-size: .8rem
        }

        .hero-item .rm {
            position: absolute;
            top: 6px;
            right: 6px
        }

        .hero-limit {
            font-size: .8rem;
            color: #64748b
        }
    </style>
@endpush

@section('content')
    @php
        use Illuminate\Support\Str;

        /**
         * DB-də saxlanan dəyəri təhlükəsiz şəkildə göstərilə bilən URL-ə çevirir:
         * - http/https → eynilə qaytar
         * - '/storage' və ya 'assets/' → asset($p)
         * - digər nisbi path-lar → asset('storage/'.$p)
         */
        $toUrl = function ($p) {
            if (!$p) {
                return null;
            }
            if (Str::startsWith($p, ['http://', 'https://'])) {
                return $p;
            }
            if (Str::startsWith($p, ['/storage', 'assets/'])) {
                return asset($p);
            }
            return asset('storage/' . ltrim($p, '/'));
        };
    @endphp

    <div class="container-fluid py-3">
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
            <div class="card shadow-sm">
                <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                    <span>Site</span>
                    <span class="section-note">Ümumi əlaqə və loqo</span>
                </div>
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
                    <div class="col-md-6">
                        <label class="form-label">Site Logo</label>
                        <input type="file" class="form-control" name="site[logo_file]">
                        @php
                            $p = data_get($settings, 'site.logo');
                            $url = $toUrl($p);
                        @endphp
                        @if ($url)
                            <div class="form-help mt-1">Mövcud:</div>
                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Site Logo">
                        @endif
                    </div>
                </div>
            </div>

            {{-- SOCIAL --}}
            <div class="card shadow-sm">
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
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Branding</div>
                <div class="card-body row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" name="logo">
                        @php
                            $p = data_get($settings, 'branding.logo');
                            $url = $toUrl($p);
                        @endphp
                        @if ($url)
                            <div class="form-help mt-1">Mövcud:</div>
                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Brand Logo">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Favicon</label>
                        <input type="file" class="form-control" name="favicon">
                        @php
                            $p = data_get($settings, 'branding.favicon');
                            $url = $toUrl($p);
                        @endphp
                        @if ($url)
                            <div class="form-help mt-1">Mövcud:</div>
                            <img src="{{ $url }}" class="thumb-prev mt-1" alt="Favicon">
                        @endif
                    </div>
                </div>
            </div>

            {{-- HOME: HERO --}}
            <div class="card shadow-sm">
                <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                    <span>Home – Hero</span>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addHeroButton">+ Add
                        button</button>
                </div>
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
                    <div class="col-12">
                        <hr>
                        <label class="form-label d-flex justify-content-between align-items-center">
                            <span>Hero Buttons (max 3)</span>
                        </label>
                        <div id="heroButtons">
                            @php $btns = data_get($settings,'home.hero.buttons',[]); @endphp
                            @foreach ($btns as $i => $b)
                                <div class="repeater-row" data-index="{{ $i }}">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-5">
                                            <label class="form-label">Text</label>
                                            <input class="form-control"
                                                name="home[hero][buttons][{{ $i }}][text]"
                                                value="{{ data_get($b, 'text') }}" placeholder="Apply Now">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">URL</label>
                                            <input class="form-control"
                                                name="home[hero][buttons][{{ $i }}][url]"
                                                value="{{ data_get($b, 'url') }}" placeholder="courses-grid-view.html">
                                        </div>
                                        <div class="col-md-1 d-grid">
                                            <button type="button"
                                                class="btn btn-outline-danger remove-row">&times;</button>
                                        </div>
                                    </div>
                                    <div class="form-help mt-1">Icon/SVG görünüşü templatdan gəlir. Dəyişmək istəsən, front
                                        tərəfdə index-ə görə fərqləndir.</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- HOME: ABOUT --}}
            <div class="card shadow-sm">
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
                                            <div class="col-md-4"><input class="form-control"
                                                    name="home[about][items][{{ $i }}][title]"
                                                    value="{{ data_get($it, 'title') }}" placeholder="Title"></div>
                                            <div class="col-md-7"><input class="form-control"
                                                    name="home[about][items][{{ $i }}][text]"
                                                    value="{{ data_get($it, 'text') }}" placeholder="Text"></div>
                                            <div class="col-md-1 d-grid"><button type="button"
                                                    class="btn btn-outline-danger remove-row">&times;</button></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Image 1</label>
                            <input type="file" class="form-control" name="home[about][image_1_file]">
                            @php
                                $p = data_get($settings, 'home.about.image_1');
                                $url = $toUrl($p);
                            @endphp
                            @if ($url)
                                <div class="form-help mt-1">Mövcud:</div>
                                <img src="{{ $url }}" class="thumb-prev mt-1" alt="About Image 1">
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Image 2</label>
                            <input type="file" class="form-control" name="home[about][image_2_file]">
                            @php
                                $p = data_get($settings, 'home.about.image_2');
                                $url = $toUrl($p);
                            @endphp
                            @if ($url)
                                <div class="form-help mt-1">Mövcud:</div>
                                <img src="{{ $url }}" class="thumb-prev mt-1" alt="About Image 2">
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Circle Image (SVG)</label>
                            <input type="file" class="form-control" name="home[about][circle_img_file]">
                            @php
                                $p = data_get($settings, 'home.about.circle_img');
                                $url = $toUrl($p);
                            @endphp
                            @if ($url)
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
            <div class="card shadow-sm">
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
                        @php
                            $p = data_get($settings, 'home.features.image');
                            $url = $toUrl($p);
                        @endphp
                        @if ($url)
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
                                        @php
                                            $icon = data_get($row, 'icon');
                                            $iconUrl = $toUrl($icon);
                                        @endphp
                                        @if ($iconUrl)
                                            <img src="{{ $iconUrl }}" class="thumb-prev mt-1" alt="Feature Icon">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- HOME: DEPARTMENTS --}}
            <div class="card shadow-sm">
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
                                        @php
                                            $p = data_get($dep, 'icon');
                                            $url = $toUrl($p);
                                        @endphp
                                        @if ($url)
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
            <div class="card shadow-sm">
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
                                        @php
                                            $p = data_get($card, 'image');
                                            $url = $toUrl($p);
                                        @endphp
                                        @if ($url)
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
            <div class="card shadow-sm">
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
                        @php
                            $p = data_get($settings, 'home.video.bg_image');
                            $url = $toUrl($p);
                        @endphp
                        @if ($url)
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

            {{-- UI: SECTION GUIDES --}}
            @php
                // Mövcud dəyərlər
                $uiGuides = data_get($settings, 'ui.guides', []);

                // Əgər seed edilməyibsə belə, default səhifə açarları göstər
                $uiPages = [
                    'index',
                    'faqs',
                    'about-us',
                    'resource',
                    'course',
                    'topices',
                    'vacancy',
                    'team',
                    'contact',
                    'services',
                ];

                // Tabları göstərmək üçün birləşdir (mövcud + default)
                $pages = array_values(array_unique(array_merge(array_keys($uiGuides ?: []), $uiPages)));
            @endphp

            <div class="card shadow-sm">
                <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                    <span>UI – Section Guides (coach-mark)</span>
                    <span class="section-note">Hər səhifə üçün izah buludlarını idarə et</span>
                </div>

                <div class="card-body">
                    {{-- PAGE TABS --}}
                    <ul class="nav nav-pills mb-3" id="guideTabs" role="tablist">
                        @foreach ($pages as $i => $page)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $i === 0 ? 'active' : '' }}" id="tab-{{ $page }}"
                                    data-bs-toggle="pill" data-bs-target="#pane-{{ $page }}" type="button"
                                    role="tab" aria-controls="pane-{{ $page }}"
                                    aria-selected="{{ $i === 0 ? 'true' : 'false' }}">
                                    {{ $page }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="guideTabContent">
                        @foreach ($pages as $i => $page)
                            @php
                                $sections = data_get($uiGuides, "$page.sections", []);
                            @endphp
                            <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="pane-{{ $page }}"
                                role="tabpanel" aria-labelledby="tab-{{ $page }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Səhifə: <code>{{ $page }}</code></h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary js-add-guide"
                                        data-page="{{ $page }}">
                                        + Bölmə əlavə et
                                    </button>
                                </div>

                                <div class="alert alert-light border small">
                                    <div><b>İpucu:</b> <code>selector</code> CSS seçicisidir (məs:
                                        <code>#services-hero</code>, <code>.hero .title</code>).
                                    </div>
                                    <div><b>trigger</b>: <code>load</code> (səhifə yüklənəndə) və ya <code>enter</code>
                                        (element görünüşə daxil olanda)
                                        .</div>
                                    <div><b>once</b>: aktiv olarsa həmin cihazda yalnız bir dəfə göstəriləcək.</div>
                                </div>

                                <div class="guide-repeater" data-page="{{ $page }}">
                                    @forelse($sections as $k => $row)
                                        <div class="repeater-row" data-index="{{ $k }}">
                                            <div class="row g-2 align-items-end">
                                                <div class="col-md-3">
                                                    <label class="form-label">Selector</label>
                                                    <input class="form-control"
                                                        name="ui[guides][{{ $page }}][sections][{{ $k }}][selector]"
                                                        value="{{ data_get($row, 'selector') }}"
                                                        placeholder="#id yaxud .class">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Title</label>
                                                    <input class="form-control"
                                                        name="ui[guides][{{ $page }}][sections][{{ $k }}][title]"
                                                        value="{{ data_get($row, 'title') }}" placeholder="Başlıq">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Trigger</label>
                                                    <select class="form-select"
                                                        name="ui[guides][{{ $page }}][sections][{{ $k }}][trigger]">
                                                        @php $tr = data_get($row,'trigger','load'); @endphp
                                                        <option value="load" @selected($tr === 'load')>load</option>
                                                        <option value="enter" @selected($tr === 'enter')>enter</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Once?</label>
                                                    @php $once = (bool) data_get($row,'once', true); @endphp
                                                    <select class="form-select"
                                                        name="ui[guides][{{ $page }}][sections][{{ $k }}][once]">
                                                        <option value="1" @selected($once)>Yes</option>
                                                        <option value="0" @selected(!$once)>No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1 d-grid">
                                                    <button type="button"
                                                        class="btn btn-outline-danger remove-row">&times;</button>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Text</label>
                                                    <textarea class="form-control" rows="2"
                                                        name="ui[guides][{{ $page }}][sections][{{ $k }}][text]" placeholder="İzah mətni...">{{ data_get($row, 'text') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-muted small">Hələ bölmə əlavə edilməyib. “+ Bölmə əlavə et”
                                            düyməsi ilə başlayın.</div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- =================== YENİ: PAGES → HERO IMAGES (max 12) =================== --}}
            @php
                $heroPages = [
                    'home' => 'Home',
                    'faqs' => 'Faqs',
                    'about' => 'About',
                    'resources' => 'Resources',
                    'courses' => 'Courses',
                    'services' => 'Services',
                    'topics' => 'Topics',
                    'vacancies' => 'Vacancies',
                    'team' => 'Team',
                    'contact' => 'Contact',
                ];
            @endphp

            <div class="card shadow-sm">
                <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                    <span>Pages – Hero Images</span>
                    <span class="section-note">Hər səhifə üçün hero şəkilləri (maks. 12 şəkil)</span>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        @foreach ($heroPages as $key => $label)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                    data-bs-target="#heroes-{{ $key }}" type="button" role="tab"
                                    aria-controls="heroes-{{ $key }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $label }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach ($heroPages as $key => $label)
                            @php
                                $imgs = (array) data_get($settings, "pages.heroes.$key.images", []);
                            @endphp
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="heroes-{{ $key }}" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="hero-limit">
                                        Cari say: <b class="js-count"
                                            data-page="{{ $key }}">{{ count($imgs) }}</b> / 12
                                    </div>
                                    <div class="text-end">
                                        <label class="btn btn-sm btn-outline-primary mb-0">
                                            Fayl əlavə et (multiple)
                                            <input type="file"
                                                name="pages[heroes][{{ $key }}][images_files][]"
                                                class="d-none js-files" multiple accept="image/*">
                                        </label>
                                    </div>
                                </div>

                                <div class="hero-grid js-grid" data-page="{{ $key }}">
                                    @foreach ($imgs as $i => $url)
                                        @php $full = $toUrl($url); @endphp
                                        <div class="hero-item">
                                            <button type="button" class="btn btn-sm btn-danger rm"
                                                title="Sil">&times;</button>
                                            <img src="{{ $full }}" alt="Hero">
                                            <input type="hidden" name="pages[heroes][{{ $key }}][images][]"
                                                value="{{ $url }}">
                                            <div class="small text-truncate mt-1" title="{{ $url }}">
                                                {{ $url }}</div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row g-2 mt-2">
                                    <div class="col-md-9">
                                        <input type="url" class="form-control js-url"
                                            placeholder="Yeni şəkil URL-i (http/https)">
                                    </div>
                                    <div class="col-md-3 d-grid">
                                        <button type="button" class="btn btn-outline-secondary js-add-url"
                                            data-page="{{ $key }}">
                                            URL ilə əlavə et
                                        </button>
                                    </div>
                                </div>

                                <div class="form-help mt-2">
                                    Qeyd: Silmək üçün kartın üzərindəki <b>×</b> düyməsinə klik et. Maksimum 12 şəkil.
                                </div>

                                <hr class="my-4">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="sticky-save p-3 mt-3">
                <div class="d-grid d-md-flex gap-2">
                    <button class="btn btn-success btn-lg flex-fill flex-md-grow-0">
                        <i class="bi bi-check2-circle me-1"></i> Save
                    </button>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">Ləğv et</a>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            /**
             * UI – Section Guides repeater
             * data-page atributuna görə input adlarını dinamik qurur.
             */
            document.querySelectorAll('.js-add-guide').forEach(btn => {
                btn.addEventListener('click', () => {
                    const page = btn.dataset.page;
                    const wrap = document.querySelector(`.guide-repeater[data-page="${page}"]`);
                    const idx = wrap.querySelectorAll('.repeater-row').length;

                    const div = document.createElement('div');
                    div.className = 'repeater-row';
                    div.dataset.index = idx;
                    div.innerHTML = `
      <div class="row g-2 align-items-end">
        <div class="col-md-3">
          <label class="form-label">Selector</label>
          <input class="form-control" name="ui[guides][${page}][sections][${idx}][selector]" placeholder="#id yaxud .class">
        </div>
        <div class="col-md-3">
          <label class="form-label">Title</label>
          <input class="form-control" name="ui[guides][${page}][sections][${idx}][title]" placeholder="Başlıq">
        </div>
        <div class="col-md-3">
          <label class="form-label">Trigger</label>
          <select class="form-select" name="ui[guides][${page}][sections][${idx}][trigger]">
            <option value="load" selected>load</option>
            <option value="enter">enter</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Once?</label>
          <select class="form-select" name="ui[guides][${page}][sections][${idx}][once]">
            <option value="1" selected>Yes</option>
            <option value="0">No</option>
          </select>
        </div>
        <div class="col-md-1 d-grid">
          <button type="button" class="btn btn-outline-danger remove-row">&times;</button>
        </div>
        <div class="col-12">
          <label class="form-label">Text</label>
          <textarea class="form-control" rows="2" name="ui[guides][${page}][sections][${idx}][text]" placeholder="İzah mətni..."></textarea>
        </div>
      </div>`;
                    wrap.appendChild(div);
                });
            });

            // Silmə (guides + ümumi repeater)
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.repeater-row')?.remove();
                }
            });
        </script>
    @endpush

    @push('scripts')
        <script>
            // ABOUT items
            const aboutWrap = document.getElementById('aboutItems');
            const addAboutBtn = document.getElementById('addAboutItem');
            if (addAboutBtn) {
                addAboutBtn.addEventListener('click', () => {
                    const idx = aboutWrap.children.length;
                    const div = document.createElement('div');
                    div.className = 'repeater-row';
                    div.innerHTML = `
      <div class="row g-2">
        <div class="col-md-4"><input class="form-control" name="home[about][items][${idx}][title]" placeholder="Title"></div>
        <div class="col-md-7"><input class="form-control" name="home[about][items][${idx}][text]" placeholder="Text"></div>
        <div class="col-md-1 d-grid"><button type="button" class="btn btn-outline-danger remove-row">&times;</button></div>
      </div>`;
                    aboutWrap.appendChild(div);
                });
            }

            // CAMPUS cards
            const campusWrap = document.getElementById('campusCards');
            const addCampusBtn = document.getElementById('addCampusCard');
            if (addCampusBtn) {
                addCampusBtn.addEventListener('click', () => {
                    const idx = campusWrap.children.length;
                    const div = document.createElement('div');
                    div.className = 'repeater-row';
                    div.innerHTML = `
      <div class="row g-2 align-items-end">
        <div class="col-md-4"><label class="form-label">Title</label><input class="form-control" name="home[campus][cards][${idx}][title]"></div>
        <div class="col-md-4"><label class="form-label">URL</label><input class="form-control" name="home[campus][cards][${idx}][url]"></div>
        <div class="col-md-3"><label class="form-label">Image</label><input type="file" class="form-control" name="home[campus][cards][${idx}][image_file]"></div>
        <div class="col-md-1 d-grid"><button type="button" class="btn btn-outline-danger remove-row">&times;</button></div>
      </div>`;
                    campusWrap.appendChild(div);
                });
            }

            // DEPARTMENTS
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
        <div class="col-md-6"><label class="form-label">Title</label><input class="form-control" name="home[departments][list][${idx}][title]"></div>
        <div class="col-md-5"><label class="form-label">Icon</label><input type="file" class="form-control" name="home[departments][list][${idx}][icon_file]"></div>
        <div class="col-md-1 d-grid"><button type="button" class="btn btn-outline-danger remove-row">&times;</button></div>
      </div>`;
                    depWrap.appendChild(div);
                });
            }

            // HERO buttons
            const heroBtnWrap = document.getElementById('heroButtons');
            const addHeroBtn = document.getElementById('addHeroButton');
            if (addHeroBtn) {
                addHeroBtn.addEventListener('click', () => {
                    const idx = heroBtnWrap.children.length;
                    if (idx >= 3) return;
                    const div = document.createElement('div');
                    div.className = 'repeater-row';
                    div.innerHTML = `
      <div class="row g-2 align-items-end">
        <div class="col-md-5"><label class="form-label">Text</label><input class="form-control" name="home[hero][buttons][${idx}][text]" placeholder="Button text"></div>
        <div class="col-md-6"><label class="form-label">URL</label><input class="form-control" name="home[hero][buttons][${idx}][url]" placeholder="https://..."></div>
        <div class="col-md-1 d-grid"><button type="button" class="btn btn-outline-danger remove-row">&times;</button></div>
      </div>
      <div class="form-help mt-1">Icon/SVG görünüşü templatdan gəlir (index-ə görə fərqləndirilə bilər).</div>`;
                    heroBtnWrap.appendChild(div);
                });
            }

            // remove any repeater row (generic)
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.repeater-row')?.remove();
                }
            });
        </script>
    @endpush

    @push('scripts')
        <script>
            /* ====== PAGES → HERO IMAGES ====== */
            const MAX = 12;

            function updateCount(page) {
                const wrap = document.querySelector(`.js-grid[data-page="${page}"]`);
                const cnt = wrap ? wrap.querySelectorAll('.hero-item').length : 0;
                const badge = document.querySelector(`.js-count[data-page="${page}"]`);
                if (badge) badge.textContent = String(cnt);
            }

            function addCard(page, url) {
                if (!url) return;
                const grid = document.querySelector(`.js-grid[data-page="${page}"]`);
                if (!grid) return;
                const current = grid.querySelectorAll('.hero-item').length;
                if (current >= MAX) {
                    alert('Maksimum 12 şəkil ola bilər.');
                    return;
                }

                const div = document.createElement('div');
                div.className = 'hero-item';
                div.innerHTML = `
                <button type="button" class="btn btn-sm btn-danger rm" title="Sil">&times;</button>
                <img src="${url}" alt="Hero">
                <input type="hidden" name="pages[heroes][${page}][images][]" value="${url}">
                <div class="small text-truncate mt-1" title="${url}">${url}</div>
              `;
                grid.appendChild(div);
                updateCount(page);
            }

            document.addEventListener('click', (e) => {
                const rm = e.target.closest('.rm');
                if (rm) {
                    const page = rm.closest('.js-grid').dataset.page;
                    rm.closest('.hero-item')?.remove();
                    updateCount(page);
                }
            });

            document.querySelectorAll('.js-add-url').forEach(btn => {
                btn.addEventListener('click', () => {
                    const page = btn.dataset.page;
                    const input = btn.closest('.row').querySelector('.js-url');
                    const url = (input.value || '').trim();
                    if (!/^https?:\/\//i.test(url)) {
                        alert('Düzgün URL daxil edin (http/https).');
                        return;
                    }
                    addCard(page, url);
                    input.value = '';
                });
            });
            // Multiple file inputs serverdə emal olunur (controller-də)
        </script>
    @endpush
@endsection
