<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course; // eyni cədvəl/model
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    // Grid + Search: yalnız SERVICE-ləri göstər
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $services = Course::query()
            ->type(Course::TYPE_SERVICE) // <-- ƏSAS FİLTİR
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('admin.services.index', compact('services', 'q'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    // STORE: type = service
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'courseUrl'   => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:3072'],

            'twitterurl'  => ['nullable', 'url'],
            'facebookurl' => ['nullable', 'url'],
            'linkedinurl' => ['nullable', 'url'],
            'emailurl'    => ['nullable', 'string', 'max:255'],
            'whatsappurl' => ['nullable', 'string', 'max:255'],
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($data['name'] ?? 'service') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($data, $imageUrl) {
            $service = Course::create([
                'type'        => Course::TYPE_SERVICE, // <-- MƏCBURİ
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl'] ?? null,
                'description' => $data['description'] ?? null,
                'imageUrl'    => $imageUrl,
            ]);

            SocialLink::create([
                'course_id'   => $service->id,
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
        });

        return redirect()->route('admin.services.index')->with('ok', 'Service yaradıldı');
    }

    // Admin "show": sadə info səhifəsi
    public function show(Course $service)
    {
        abort_unless($service->type === Course::TYPE_SERVICE, 404);
        return view('admin.services.show', compact('service'));
    }

    public function edit(Course $service)
    {
        abort_unless($service->type === Course::TYPE_SERVICE, 404);
        $service->load('socialLink');
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Course $service)
    {
        abort_unless($service->type === Course::TYPE_SERVICE, 404);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'courseUrl'   => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:3072'],

            'twitterurl'  => ['nullable', 'url'],
            'facebookurl' => ['nullable', 'url'],
            'linkedinurl' => ['nullable', 'url'],
            'emailurl'    => ['nullable', 'string', 'max:255'],
            'whatsappurl' => ['nullable', 'string', 'max:255'],
        ]);

        $imageUrl = $service->imageUrl;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($data['name'] ?? 'service') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($service, $data, $imageUrl) {
            $service->update([
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl'] ?? null,
                'description' => $data['description'] ?? null,
                'imageUrl'    => $imageUrl,
            ]);

            $link = $service->socialLink ?: new SocialLink(['course_id' => $service->id]);
            $link->fill([
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
            $link->course()->associate($service);
            $link->save();
        });

        return redirect()->route('admin.services.index')->with('ok', 'Yeniləndi');
    }

    public function destroy(Course $service)
    {
        abort_unless($service->type === Course::TYPE_SERVICE, 404);
        $service->delete();
        return redirect()->route('admin.services.index')->with('ok', 'Silindi');
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
