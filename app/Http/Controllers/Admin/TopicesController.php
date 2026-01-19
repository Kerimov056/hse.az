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
    // Grid + Search + Holding filter: yalnız TOPIC-lər
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $holding = trim((string) $request->get('holding', ''));

        $base = Course::query()->type(Course::TYPE_TOPIC);

        // Holding-lər (count)
        $holdings = (clone $base)
            ->selectRaw('courseHoldingName as name, COUNT(*) as count')
            ->whereNotNull('courseHoldingName')
            ->where('courseHoldingName', '!=', '')
            ->groupBy('courseHoldingName')
            ->orderBy('courseHoldingName')
            ->get()
            ->map(fn($r) => ['name' => $r->name, 'count' => (int) $r->count])
            ->values()
            ->all();

        $topics = $base
            // ✅ holding filter
            ->when($holding !== '', function ($query) use ($holding) {
                $query->where('courseHoldingName', $holding);
            })
            // ✅ search
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('courseHoldingName', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('admin.topices.index', compact('topics', 'q', 'holding', 'holdings'));
    }

    public function create()
    {
        return view('admin.topices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'courseUrl'         => ['nullable', 'url'],
            'description'       => ['nullable', 'string'],
            'image'             => ['nullable', 'image', 'max:3072'],
            'info'              => ['nullable', 'string'],

            // ✅ NEW
            'courseHoldingName' => ['nullable', 'string', 'max:120'],

            'twitterurl'        => ['nullable', 'url'],
            'facebookurl'       => ['nullable', 'url'],
            'linkedinurl'       => ['nullable', 'url'],
            'emailurl'          => ['nullable', 'string', 'max:255'],
            'whatsappurl'       => ['nullable', 'string', 'max:255'],
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
                'type'             => Course::TYPE_TOPIC,
                'name'             => $data['name'],
                'courseUrl'        => $data['courseUrl'] ?? null,
                'description'      => $data['description'] ?? null,
                'imageUrl'         => $imageUrl,
                'info'             => $data['info'] ?? null,

                // ✅ NEW
                'courseHoldingName'=> $data['courseHoldingName'] ?? null,
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
            'name'              => ['required', 'string', 'max:255'],
            'courseUrl'         => ['nullable', 'url'],
            'description'       => ['nullable', 'string'],
            'image'             => ['nullable', 'image', 'max:3072'],
            'info'              => ['nullable', 'string'],

            // ✅ NEW
            'courseHoldingName' => ['nullable', 'string', 'max:120'],

            'twitterurl'        => ['nullable', 'url'],
            'facebookurl'       => ['nullable', 'url'],
            'linkedinurl'       => ['nullable', 'url'],
            'emailurl'          => ['nullable', 'string', 'max:255'],
            'whatsappurl'       => ['nullable', 'string', 'max:255'],
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
                'name'             => $data['name'],
                'courseUrl'        => $data['courseUrl'] ?? null,
                'description'      => $data['description'] ?? null,
                'imageUrl'         => $imageUrl,
                'info'             => $data['info'] ?? null,

                // ✅ NEW
                'courseHoldingName'=> $data['courseHoldingName'] ?? null,
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
