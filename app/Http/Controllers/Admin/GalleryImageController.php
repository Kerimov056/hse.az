<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryImageController extends Controller
{
    /**
     * Siyahı.
     */
    public function index()
    {
        $images = GalleryImage::latest()->paginate(20);

        return view('admin.gallery_images.index', compact('images'));
    }

    /**
     * Yarat formu.
     */
    public function create()
    {
        $image = new GalleryImage();

        return view('admin.gallery_images.create', compact('image'));
    }

    /**
     * Yarat – URL + GCS upload.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image_url'  => ['nullable', 'url', 'max:2048'],
            'image_file' => ['nullable', 'image', 'max:4096'],
        ]);

        if (!$request->filled('image_url') && !$request->hasFile('image_file')) {
            return back()
                ->withErrors(['image_url' => 'Zəhmət olmasa URL yazın və ya fayl seçin.'])
                ->withInput();
        }

        // Əsas dəyər
        $imageUrl = $data['image_url'] ?? null;

        // Fayl varsa, onu GCS-ə yükləyib üstün tuturuq
        if ($request->hasFile('image_file')) {
            $imageUrl = $this->uploadToGcsIfAny($request->file('image_file'));
        }

        $image = GalleryImage::create([
            'image' => $imageUrl,
        ]);

        return redirect()
            ->route('admin.gallery-images.index')
            ->with('ok', 'Şəkil əlavə olundu');
    }

    /**
     * Tək şəklə baxış.
     */
    public function show(GalleryImage $galleryImage)
    {
        return view('admin.gallery_images.show', [
            'image' => $galleryImage,
        ]);
    }

    /**
     * Redaktə formu.
     */
    public function edit(GalleryImage $galleryImage)
    {
        return view('admin.gallery_images.edit', [
            'image' => $galleryImage,
        ]);
    }

    /**
     * Yenilə – URL + GCS upload.
     */
    public function update(Request $request, GalleryImage $galleryImage)
    {
        $data = $request->validate([
            'image_url'  => ['nullable', 'url', 'max:2048'],
            'image_file' => ['nullable', 'image', 'max:4096'],
        ]);

        if (!$request->filled('image_url') && !$request->hasFile('image_file')) {
            return back()
                ->withErrors(['image_url' => 'Zəhmət olmasa URL yazın və ya fayl seçin.'])
                ->withInput();
        }

        $imageUrl = $data['image_url'] ?? $galleryImage->image;

        if ($request->hasFile('image_file')) {
            $imageUrl = $this->uploadToGcsIfAny($request->file('image_file'));
        }

        $galleryImage->update([
            'image' => $imageUrl,
        ]);

        return redirect()
            ->route('admin.gallery-images.index')
            ->with('ok', 'Yeniləndi');
    }

    /**
     * Sil.
     */
    public function destroy(GalleryImage $galleryImage)
    {
        $galleryImage->delete();

        return redirect()
            ->route('admin.gallery-images.index')
            ->with('ok', 'Silindi');
    }

    /**
     * Verilən faylı GCS-ə yükləyib public URL qaytarır.
     */
    private function uploadToGcsIfAny(?\Illuminate\Http\UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        $filename = 'gallery/' . Str::uuid() . '.' . $file->getClientOriginalExtension();

        Storage::disk('gcs')->put($filename, file_get_contents($file), [
            'visibility' => 'public',
            'metadata'   => ['cacheControl' => 'public, max-age=31536000'],
        ]);

        $base   = rtrim(config('filesystems.disks.gcs.api_url', ''), '/');
        $bucket = config('filesystems.disks.gcs.bucket');
        $prefix = trim(config('filesystems.disks.gcs.path_prefix', ''), '/');

        $path = $prefix ? "{$prefix}/{$filename}" : $filename;

        return $base
            ? "{$base}/{$bucket}/{$path}"
            : Storage::disk('gcs')->url($filename);
    }
}
