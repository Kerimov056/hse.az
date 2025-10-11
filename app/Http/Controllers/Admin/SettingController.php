<?php
// app/Http/Controllers/Admin/SettingController.php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller {
  public function edit() {
    $settings = Setting::pluck('value','key')->toArray();
    return view('admin.settings.edit', compact('settings'));
  }

  public function update(Request $r) {
    $data = $r->validate([
      'site.name'    => 'nullable|string|max:100',
      'site.phone'   => 'nullable|string|max:100',
      'site.email'   => 'nullable|email|max:150',
      'site.address' => 'nullable|string|max:255',
      'social.facebook'  => 'nullable|url',
      'social.instagram' => 'nullable|url',
      'logo' => 'nullable|image|max:2048',
      'favicon' => 'nullable|image|max:1024',
    ]);

    // media upload (logo, favicon)
    $branding = setting('branding', []);
    if ($r->hasFile('logo'))    $branding['logo']    = $r->file('logo')->store('branding','public');
    if ($r->hasFile('favicon')) $branding['favicon'] = $r->file('favicon')->store('branding','public');

    // yaz
    foreach (['site.name','site.phone','site.email','site.address','social'] as $k) {
      Setting::updateOrCreate(['key'=>$k], ['value'=>$data[$k] ?? setting($k)]);
      Cache::forget("setting:$k");
    }
    Setting::updateOrCreate(['key'=>'branding'], ['value'=>$branding]); Cache::forget('setting:branding');

    return back()->with('ok','Settings updated');
  }
}
