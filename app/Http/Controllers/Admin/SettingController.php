<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->get();
        return view('admin.settings.index', compact('settings'));
    }

    public function edit()
    {
        $merged = [];
        foreach (Setting::get(['key', 'value']) as $row) {
            Arr::set($merged, $row->key, $row->value);
        }
        $settings = $merged;

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $r)
    {
        $r->validate([
            // Base
            'site.name'      => 'nullable|string|max:100',
            'site.phone'     => 'nullable|string|max:100',
            'site.email'     => 'nullable|email|max:150',
            'site.address'   => 'nullable|string|max:255',
            'site.logo_file' => 'nullable|image|max:4096',

            // Social
            'social.facebook'  => 'nullable|url',
            'social.instagram' => 'nullable|url',
            'social.twitter'   => 'nullable|url',
            'social.pinterest' => 'nullable|url',
            'social.whatsapp'  => 'nullable|url',
            'social.linkedin'  => 'nullable|url',

            // Branding
            'logo'    => 'nullable|image|max:4096',
            'favicon' => 'nullable|image|max:2048',

            // About files
            'home.about.image_1_file'    => 'nullable|image|max:8192',
            'home.about.image_2_file'    => 'nullable|image|max:8192',
            'home.about.circle_img_file' => 'nullable|mimes:svg,png,jpg,jpeg,webp|max:4096',

            // Features
            'home.features.image_file'       => 'nullable|image|max:8192',
            'home.features.list'             => 'nullable|array|max:4',
            'home.features.list.*.icon_file' => 'nullable|mimes:svg,png,jpg,jpeg,webp|max:4096',

            // Campus
            'home.campus.cards.*.image_file' => 'nullable|image|max:8192',

            // Video
            'home.video.bg_image_file'       => 'nullable|image|max:8192',

            // Departments
            'home.departments.kicker'            => 'nullable|string|max:100',
            'home.departments.title'             => 'nullable|string|max:200',
            'home.departments.subtitle'          => 'nullable|string|max:1000',
            'home.departments.list'              => 'nullable|array|max:8',
            'home.departments.list.*.title'      => 'nullable|string|max:150',
            'home.departments.list.*.icon_file'  => 'nullable|mimes:svg,png,jpg,jpeg,webp|max:4096',

            // Hero
            'home.hero.kicker'            => 'nullable|string|max:150',
            'home.hero.title'             => 'nullable|string|max:500',
            'home.hero.subtitle'          => 'nullable|string|max:1000',
            'home.hero.cta.text'          => 'nullable|string|max:120',
            'home.hero.cta.url'           => 'nullable|string|max:255',
            'home.hero.buttons'           => 'nullable|array|max:3',
            'home.hero.buttons.*.text'    => 'nullable|string|max:120',
            'home.hero.buttons.*.url'     => 'nullable|string|max:255',


            // VALIDATION daxilinə əlavə et:
            'ui.guides'                         => 'nullable|array',
            'ui.guides.*.sections'              => 'nullable|array|max:12',
            'ui.guides.*.sections.*.selector'   => 'nullable|string|max:120',
            'ui.guides.*.sections.*.title'      => 'nullable|string|max:120',
            'ui.guides.*.sections.*.text'       => 'nullable|string|max:1000',
            'ui.guides.*.sections.*.trigger'    => 'nullable|in:load,enter',
            'ui.guides.*.sections.*.once'       => 'nullable|in:0,1',
        ]);

        // BRANDING
        $branding = setting('branding', []);
        if ($r->hasFile('logo')) {
            $branding['logo'] = $this->storeToCdn($r->file('logo'), 'settings/branding');
        }
        if ($r->hasFile('favicon')) {
            $branding['favicon'] = $this->storeToCdn($r->file('favicon'), 'settings/branding');
        }
        $this->write('branding', $branding);

        // SITE & SOCIAL
        foreach (['site.name', 'site.phone', 'site.email', 'site.address', 'social'] as $k) {
            $this->write($k, $r->input($k, setting($k)));
        }
        if ($r->hasFile('site.logo_file')) {
            $path = $this->storeToCdn($r->file('site.logo_file'), 'settings/site');
            $this->write('site.logo', $path);
        }

        // HOME.ABOUT
        $about = setting('home.about', []);
        Arr::set($about, 'est_year',   $r->input('home.about.est_year',   Arr::get($about, 'est_year')));
        Arr::set($about, 'kicker',     $r->input('home.about.kicker',     Arr::get($about, 'kicker')));
        Arr::set($about, 'title',      $r->input('home.about.title',      Arr::get($about, 'title')));
        Arr::set($about, 'subtitle',   $r->input('home.about.subtitle',   Arr::get($about, 'subtitle')));
        Arr::set($about, 'items',      $r->input('home.about.items',      Arr::get($about, 'items', [])));
        Arr::set($about, 'video_url',  $r->input('home.about.video_url',  Arr::get($about, 'video_url')));
        Arr::set($about, 'cta.text',   $r->input('home.about.cta.text',   Arr::get($about, 'cta.text')));
        Arr::set($about, 'cta.url',    $r->input('home.about.cta.url',    Arr::get($about, 'cta.url')));

        if ($r->hasFile('home.about.image_1_file')) {
            Arr::set($about, 'image_1', $this->storeToCdn($r->file('home.about.image_1_file'), 'settings/home/about'));
        }
        if ($r->hasFile('home.about.image_2_file')) {
            Arr::set($about, 'image_2', $this->storeToCdn($r->file('home.about.image_2_file'), 'settings/home/about'));
        }
        if ($r->hasFile('home.about.circle_img_file')) {
            Arr::set($about, 'circle_img', $this->storeToCdn($r->file('home.about.circle_img_file'), 'settings/home/about'));
        }
        $this->write('home.about', $about);

        // HOME.FEATURES
        $features = setting('home.features', []);
        Arr::set($features, 'kicker', $r->input('home.features.kicker', Arr::get($features, 'kicker')));
        Arr::set($features, 'title',  $r->input('home.features.title',  Arr::get($features, 'title')));

        if ($r->hasFile('home.features.image_file')) {
            Arr::set($features, 'image', $this->storeToCdn($r->file('home.features.image_file'), 'settings/home/features'));
        }

        $listInput = $r->input('home.features.list', []);
        $listSaved = [];
        for ($i = 0; $i < 4; $i++) {
            $row = Arr::get($listInput, $i, []);
            $saved = [
                'title' => Arr::get($row, 'title', Arr::get($features, "list.$i.title")),
                'text'  => Arr::get($row, 'text',  Arr::get($features, "list.$i.text")),
                'icon'  => Arr::get($features, "list.$i.icon"),
            ];
            if ($r->hasFile("home.features.list.$i.icon_file")) {
                $saved['icon'] = $this->storeToCdn($r->file("home.features.list.$i.icon_file"), 'settings/home/features/icons');
            }
            if (!empty($saved['title']) || !empty($saved['text']) || !empty($saved['icon'])) {
                $listSaved[] = $saved;
            }
        }
        Arr::set($features, 'list', $listSaved);
        $this->write('home.features', $features);

        // HOME.CAMPUS
        $campus = setting('home.campus', []);
        Arr::set($campus, 'title',    $r->input('home.campus.title',    Arr::get($campus, 'title')));
        Arr::set($campus, 'subtitle', $r->input('home.campus.subtitle', Arr::get($campus, 'subtitle')));
        Arr::set($campus, 'cta.text', $r->input('home.campus.cta.text', Arr::get($campus, 'cta.text')));
        Arr::set($campus, 'cta.url',  $r->input('home.campus.cta.url',  Arr::get($campus, 'cta.url')));

        $cards = $r->input('home.campus.cards', Arr::get($campus, 'cards', []));
        foreach ($cards as $i => $card) {
            if ($r->hasFile("home.campus.cards.$i.image_file")) {
                $card['image'] = $this->storeToCdn($r->file("home.campus.cards.$i.image_file"), 'settings/home/campus');
            } else {
                $card['image'] = Arr::get($campus, "cards.$i.image", Arr::get($card, 'image'));
            }
            $cards[$i] = $card;
        }
        Arr::set($campus, 'cards', $cards);
        $this->write('home.campus', $campus);

        // HOME.VIDEO
        $video = setting('home.video', []);
        Arr::set($video, 'heading',     $r->input('home.video.heading',     Arr::get($video, 'heading')));
        Arr::set($video, 'youtube_url', $r->input('home.video.youtube_url', Arr::get($video, 'youtube_url')));
        Arr::set($video, 'contact.email_label', $r->input('home.video.contact.email_label', Arr::get($video, 'contact.email_label')));
        Arr::set($video, 'contact.email',       $r->input('home.video.contact.email',       Arr::get($video, 'contact.email')));
        Arr::set($video, 'contact.phone_label', $r->input('home.video.contact.phone_label', Arr::get($video, 'contact.phone_label')));
        Arr::set($video, 'contact.phone',       $r->input('home.video.contact.phone',       Arr::get($video, 'contact.phone')));

        if ($r->hasFile('home.video.bg_image_file')) {
            Arr::set($video, 'bg_image', $this->storeToCdn($r->file('home.video.bg_image_file'), 'settings/home/video'));
        }
        $this->write('home.video', $video);

        // HOME.DEPARTMENTS
        $departments = setting('home.departments', []);
        Arr::set($departments, 'kicker',   $r->input('home.departments.kicker',   Arr::get($departments, 'kicker')));
        Arr::set($departments, 'title',    $r->input('home.departments.title',    Arr::get($departments, 'title')));
        Arr::set($departments, 'subtitle', $r->input('home.departments.subtitle', Arr::get($departments, 'subtitle')));

        $depInput = $r->input('home.departments.list', []);
        $depSaved = [];
        for ($i = 0; $i < 8; $i++) {
            $row = Arr::get($depInput, $i, []);
            $saved = [
                'title' => Arr::get($row, 'title', Arr::get($departments, "list.$i.title")),
                'icon'  => Arr::get($departments, "list.$i.icon"),
            ];
            if ($r->hasFile("home.departments.list.$i.icon_file")) {
                $saved['icon'] = $this->storeToCdn($r->file("home.departments.list.$i.icon_file"), 'settings/home/departments/icons');
            }
            if (!empty($saved['title']) || !empty($saved['icon'])) {
                $depSaved[] = $saved;
            }
        }
        Arr::set($departments, 'list', $depSaved);
        $this->write('home.departments', $departments);

        // HOME.HERO (+ buttons)
        $hero = setting('home.hero', []);
        Arr::set($hero, 'kicker',   $r->input('home.hero.kicker',   Arr::get($hero, 'kicker')));
        Arr::set($hero, 'title',    $r->input('home.hero.title',    Arr::get($hero, 'title')));
        Arr::set($hero, 'subtitle', $r->input('home.hero.subtitle', Arr::get($hero, 'subtitle')));
        Arr::set($hero, 'cta.text', $r->input('home.hero.cta.text', Arr::get($hero, 'cta.text')));
        Arr::set($hero, 'cta.url',  $r->input('home.hero.cta.url',  Arr::get($hero, 'cta.url')));

        $btnInput = $r->input('home.hero.buttons', []);
        $btnSaved = [];
        for ($i = 0; $i < 3; $i++) {
            $row = Arr::get($btnInput, $i, []);
            $saved = [
                'text' => Arr::get($row, 'text', Arr::get($hero, "buttons.$i.text")),
                'url'  => Arr::get($row, 'url',  Arr::get($hero, "buttons.$i.url")),
            ];
            if (!empty($saved['text']) || !empty($saved['url'])) {
                $btnSaved[] = $saved;
            }
        }
        Arr::set($hero, 'buttons', $btnSaved);
        $this->write('home.hero', $hero);


        // ===== UI.GUIDES =====
        // Köhnəni götür, yeni ilə birləşdir (selektor boşdursa at)
        $guidesInput = $r->input('ui.guides', []);
        $normalized  = [];
        foreach ($guidesInput as $pageKey => $cfg) {
            $sectionsIn  = $cfg['sections'] ?? [];
            $sectionsOut = [];
            foreach ($sectionsIn as $row) {
                $sel = trim((string)($row['selector'] ?? ''));
                if ($sel === '') {
                    continue;
                }
                $sectionsOut[] = [
                    'selector' => $sel,
                    'title'    => $row['title']   ?? null,
                    'text'     => $row['text']    ?? null,
                    'trigger'  => in_array(($row['trigger'] ?? 'enter'), ['load', 'enter']) ? $row['trigger'] : 'enter',
                    'once'     => (bool)($row['once'] ?? true),
                ];
            }
            $normalized[$pageKey] = ['sections' => $sectionsOut];
        }
        $this->write('ui.guides', $normalized ?: setting('ui.guides', []));

        Cache::forget('settings:merged');
        return back()->with('ok', 'Settings updated');
    }

    /**
     * Faylı GCS diskində saxlayıb TAM URL qaytarır.
     */
    private function storeToCdn(\Illuminate\Http\UploadedFile $file, string $dir): string
    {
        $disk = Storage::disk('gcs');

        // Faylı public ACL ilə yüklə (GCS-də obyekt səviyyəsində public olsun)
        // Qeyd: bucket-də "Uniform bucket-level access" açıqdırsa, obyektlər default public ola bilməz;
        // o halda CDN/proxy istifadə edin və ya imzalı URL mexanizminə keçin.
        $path = $disk->putFile($dir, $file, 'public');  // ex: settings/branding/xxx.png

        return $this->gcsPublicUrl($path);
    }

    /**
     * GCS public URL qurur:
     *  - Əgər .env-də CDN_BASE_URL varsa onu istifadə edir (məs: https://cdn.educve.com)
     *  - Yoxdursa filesystems.php/disk parametrləri ilə standart GCS URL yığır
     */
    private function gcsPublicUrl(string $path): string
    {
        $cdn = rtrim(env('CDN_BASE_URL', ''), '/');
        $diskCfg = config('filesystems.disks.gcs');

        $api    = rtrim($diskCfg['api_url'] ?? 'https://storage.googleapis.com', '/');
        $bucket = $diskCfg['bucket'] ?? '';
        $prefix = trim($diskCfg['path_prefix'] ?? '', '/');

        // path_prefix + fayl path-ını birləşdir
        $full = ltrim($path, '/');
        if ($prefix !== '') {
            $full = $prefix . '/' . $full;
        }

        if ($cdn !== '') {
            // CDN istifadə edirik: https://cdn.domain.tld/{prefix}/{path}
            return $cdn . '/' . $full;
        }

        // Standart GCS public URL: https://storage.googleapis.com/{bucket}/{prefix}/{path}
        return $api . '/' . $bucket . '/' . $full;
    }

    private function write(string $key, $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting:$key");
    }
}
