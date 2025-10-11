<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    // Grid + Search: yalnız COURSE-ları göstər
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $courses = \App\Models\Course::query()
            ->type(\App\Models\Course::TYPE_COURSE)        // <-- ƏSAS
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('admin.courses.index', compact('courses', 'q'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    // CREATE/STORE: type-i məcburi course yaz
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
            $filename = Str::slug($data['name'] ?? 'course') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($data, $imageUrl) {
            $course = \App\Models\Course::create([
                'type'        => \App\Models\Course::TYPE_COURSE, // <-- MƏCBURİ
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl'] ?? null,
                'description' => $data['description'] ?? null,
                'imageUrl'    => $imageUrl,
            ]);

            SocialLink::create([
                'course_id'   => $course->id,
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
        });

        return redirect()->route('admin.courses.index')->with('ok', 'Kurs yaradıldı');
    }

    // Admin "show" -> istifadəçi details-ə yönləndirək (view sayını da orada artırırıq)
    public function show(Course $course)
    {
        abort_unless($course->type === \App\Models\Course::TYPE_COURSE, 404);
        return redirect()->route('course-details', $course);
    }

    public function edit(Course $course)
    {
        abort_unless($course->type === \App\Models\Course::TYPE_COURSE, 404);
        $course->load('socialLink');
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        abort_unless($course->type === \App\Models\Course::TYPE_COURSE, 404);
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

        $imageUrl = $course->imageUrl;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($data['name'] ?? 'course') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($course, $data, $imageUrl) {
            $course->update([
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl'] ?? null,
                'description' => $data['description'] ?? null,
                'imageUrl'    => $imageUrl,
            ]);

            $link = $course->socialLink ?: new SocialLink(['course_id' => $course->id]);
            $link->fill([
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
            $link->course()->associate($course);
            $link->save();
        });

        return redirect()->route('admin.courses.index')->with('ok', 'Yeniləndi');
    }

    public function destroy(Course $course)
    {
        abort_unless($course->type === \App\Models\Course::TYPE_COURSE, 404);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('ok', 'Silindi');
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
