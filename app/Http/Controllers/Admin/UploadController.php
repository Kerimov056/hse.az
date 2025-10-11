<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function trix(Request $request)
    {
        $data = $request->validate([
            'file' => ['required', 'image', 'max:3072'], // ~3MB
        ]);

        $file = $data['file'];
        $ext  = $file->getClientOriginalExtension();
        $name = Str::uuid()->toString().'.'.$ext;

        // Hansı disk default olsa da, GCS-dirsə GCS, yoxdursa local PUBLIC istifadə edirik
        $defaultDisk = config('filesystems.default', 'public');

        if ($defaultDisk === 'gcs') {
            $path = "trix/{$name}";
            Storage::disk('gcs')->put($path, file_get_contents($file), 'public');
            $url  = $this->gcsPublicUrl($path);
        } else {
            // Lokal: HƏMİŞƏ 'public' disk
            // storage/app/public/trix/..  →  /storage/trix/.. (symlink lazımdır)
            $path = $file->storePubliclyAs('trix', $name, 'public');

            // Bəzi mühitlərdə Storage::url() mövcud olmaya bilər – etibarlı fallback:
            $url  = asset('storage/'.$path);
        }

        return response()->json(['url' => $url], 201);
    }

    private function gcsPublicUrl(string $filename): string
    {
        $base   = rtrim(config('filesystems.disks.gcs.api_url'), '/');
        $bucket = config('filesystems.disks.gcs.bucket');
        $prefix = trim(config('filesystems.disks.gcs.path_prefix', ''), '/');

        return $prefix
            ? "{$base}/{$bucket}/{$prefix}/{$filename}"
            : "{$base}/{$bucket}/{$filename}";
    }
}
