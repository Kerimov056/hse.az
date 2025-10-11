<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TopicesController extends Controller
{
    // Grid + Search: yalnız TOPIC-lər
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $topics = Course::query()
            ->type(Course::TYPE_TOPIC) // <-- MÜTLƏQ: modeldə TYPE_TOPIC olmalıdır
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('admin.topices.index', compact('topics', 'q'));
    }

    public function create()
    {
        return view('admin.topices.create');
    }

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
            $file     = $request->file('image');
            $filename = Str::slug($data['name'] ?? 'topic') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($data, $imageUrl) {
            $topic = Course::create([
                'type'        => Course::TYPE_TOPIC, // <-- MƏCBURİ
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl'] ?? null,
                'description' => $data['description'] ?? null,
                'imageUrl'    => $imageUrl,
            ]);

            SocialLink::create([
                'course_id'   => $topic->id,
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
        });

        return redirect()->route('admin.topices.index')->with('ok', 'Topic yaradıldı');
    }

    // Admin "show" -> istifadəçi detallara yönləndir
    public function show(Course $topice)
    {
        abort_unless($topice->type === Course::TYPE_TOPIC, 404);
        return view('admin.topices.show', ['topic' => $topice->load('socialLink')]);
    }

    public function edit(Course $topice)
    {
        abort_unless($topice->type === Course::TYPE_TOPIC, 404);
        $topice->load('socialLink');
        return view('admin.topices.edit', ['topic' => $topice]);
    }

    public function update(Request $request, Course $topice)
    {
        abort_unless($topice->type === Course::TYPE_TOPIC, 404);

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

        $imageUrl = $topice->imageUrl;
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = Str::slug($data['name'] ?? 'topic') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($topice, $data, $imageUrl) {
            $topice->update([
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl'] ?? null,
                'description' => $data['description'] ?? null,
                'imageUrl'    => $imageUrl,
            ]);

            $link = $topice->socialLink ?: new SocialLink(['course_id' => $topice->id]);
            $link->fill([
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
            $link->course()->associate($topice);
            $link->save();
        });

        return redirect()->route('admin.topices.index')->with('ok', 'Yeniləndi');
    }

    public function destroy(Course $topice)
    {
        abort_unless($topice->type === Course::TYPE_TOPIC, 404);
        $topice->delete();
        return redirect()->route('admin.topices.index')->with('ok', 'Silindi');
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
