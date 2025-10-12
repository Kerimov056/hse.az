<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

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
            'site.name'    => 'nullable|string|max:100',
            'site.phone'   => 'nullable|string|max:100',
            'site.email'   => 'nullable|email|max:150',
            'site.address' => 'nullable|string|max:255',

            // Social
            'social.facebook'  => 'nullable|url',
            'social.instagram' => 'nullable|url',
            'social.twitter'   => 'nullable|url',
            'social.pinterest' => 'nullable|url',
            'social.whatsapp'  => 'nullable|url',

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
        ]);

        // BRANDING
        $branding = setting('branding', []);
        if ($r->hasFile('logo')) {
            $branding['logo'] = $r->file('logo')->store('settings/branding', 'public');
        }
        if ($r->hasFile('favicon')) {
            $branding['favicon'] = $r->file('favicon')->store('settings/branding', 'public');
        }
        $this->write('branding', $branding);

        // SITE & SOCIAL
        foreach (['site.name', 'site.phone', 'site.email', 'site.address', 'social'] as $k) {
            $this->write($k, $r->input($k, setting($k)));
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
            Arr::set($about, 'image_1', $r->file('home.about.image_1_file')->store('settings/home/about', 'public'));
        }
        if ($r->hasFile('home.about.image_2_file')) {
            Arr::set($about, 'image_2', $r->file('home.about.image_2_file')->store('settings/home/about', 'public'));
        }
        if ($r->hasFile('home.about.circle_img_file')) {
            Arr::set($about, 'circle_img', $r->file('home.about.circle_img_file')->store('settings/home/about', 'public'));
        }
        $this->write('home.about', $about);

        // HOME.FEATURES (max 4)
        $features = setting('home.features', []);
        Arr::set($features, 'kicker', $r->input('home.features.kicker', Arr::get($features, 'kicker')));
        Arr::set($features, 'title',  $r->input('home.features.title',  Arr::get($features, 'title')));

        if ($r->hasFile('home.features.image_file')) {
            Arr::set($features, 'image', $r->file('home.features.image_file')->store('settings/home/features', 'public'));
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
                $saved['icon'] = $r->file("home.features.list.$i.icon_file")->store('settings/home/features/icons', 'public');
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
                $card['image'] = $r->file("home.campus.cards.$i.image_file")->store('settings/home/campus', 'public');
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
            Arr::set($video, 'bg_image', $r->file('home.video.bg_image_file')->store('settings/home/video', 'public'));
        }
        $this->write('home.video', $video);

        Cache::forget('settings:merged');
        return back()->with('ok', 'Settings updated');
    }

    private function write(string $key, $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting:$key");
    }
}
