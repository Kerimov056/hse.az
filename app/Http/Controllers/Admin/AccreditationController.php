<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccreditationController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $items = Accreditation::query()
            ->when(
                $q !== '',
                fn($qq) =>
                $qq->where('description', 'like', "%{$q}%")
            )
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.accreditations.index', compact('items', 'q'));
    }

    public function create()
    {
        $item = new Accreditation();
        return view('admin.accreditations.create', compact('item'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image'       => ['nullable', 'image', 'max:4096'],
            'description' => ['nullable', 'string'],
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = 'accr-' . Str::random(10) . '-' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        Accreditation::create([
            'imageUrl'    => $imageUrl,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.accreditations.index')->with('ok', 'Accreditation əlavə olundu.');
    }

    public function show(Accreditation $accreditation)
    {
        return view('admin.accreditations.show', ['item' => $accreditation]);
    }

    public function edit(Accreditation $accreditation)
    {
        return view('admin.accreditations.edit', ['item' => $accreditation]);
    }

    public function update(Request $request, Accreditation $accreditation)
    {
        $data = $request->validate([
            'image'       => ['nullable', 'image', 'max:4096'],
            'description' => ['nullable', 'string'],
        ]);

        $imageUrl = $accreditation->imageUrl;
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = 'accr-' . Str::random(10) . '-' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        $accreditation->update([
            'imageUrl'    => $imageUrl,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('admin.accreditations.index')->with('ok', 'Accreditation yeniləndi.');
    }

    public function destroy(Accreditation $accreditation)
    {
        $accreditation->delete();
        return redirect()->route('admin.accreditations.index')->with('ok', 'Silindi.');
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
