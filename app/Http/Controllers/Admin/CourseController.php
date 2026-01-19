<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SocialLink;
use App\Models\CourseTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $holding = $request->get('holding'); // ?holding=A

        $query = Course::query()
            ->where('type', Course::TYPE_COURSE)
            ->with('courseTopics');

        // ✅ HOLDING FILTER
        if (!empty($holding)) {
            $query->where('courseHoldingName', $holding);
        }

        // ✅ SEARCH (optional)
        if (!empty($q)) {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('instructor', 'like', "%{$q}%")
                    ->orWhere('duration', 'like', "%{$q}%")
                    ->orWhere('courseHoldingName', 'like', "%{$q}%");
            });
        }

        $courses = $query->orderByDesc('id')->paginate(20);

        return view('admin.courses.index', compact('courses', 'q', 'holding'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:course'],
            'name' => ['required', 'string', 'max:160'],

            // NEW
            'courseHoldingName' => ['nullable', 'string', 'max:160'],

            'courseUrl' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
            'info' => ['nullable', 'string'],

            'duration' => ['nullable', 'string', 'max:120'],
            'instructor' => ['nullable', 'string', 'max:120'],
            'price' => ['nullable', 'numeric', 'min:0'],

            'image' => ['nullable', 'image', 'max:3072'],

            // socials
            'twitterurl' => ['nullable', 'url', 'max:500'],
            'facebookurl' => ['nullable', 'url', 'max:500'],
            'linkedinurl' => ['nullable', 'url', 'max:500'],
            'emailurl' => ['nullable', 'string', 'max:500'],
            'whatsappurl' => ['nullable', 'string', 'max:500'],

            // topics
            'topics' => ['nullable', 'array'],
            'topics.*' => ['nullable', 'string', 'max:120'],
        ]);

        // image upload (səndə storage logic fərqli ola bilər, mövcud logic-i saxla)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $data['imageUrl'] = asset('storage/' . $path);
        }

        $course = Course::create($data);

        // social link upsert
        $course->socialLink()->updateOrCreate(
            ['course_id' => $course->id],
            [
                'twitterurl' => $request->twitterurl,
                'facebookurl' => $request->facebookurl,
                'linkedinurl' => $request->linkedinurl,
                'emailurl' => $request->emailurl,
                'whatsappurl' => $request->whatsappurl,
            ]
        );

        // topics save
        $topics = collect($request->input('topics', []))
            ->map(fn($t) => trim((string) $t))
            ->filter()
            ->values();

        if ($topics->count()) {
            foreach ($topics as $i => $t) {
                $course->courseTopics()->create([
                    'title' => $t,
                    'sort_order' => $i + 1,
                ]);
            }
        }

        return redirect()->route('admin.courses.index')->with('ok', 'Course yaradıldı.');
    }


    public function show(Course $course)
    {
        abort_unless($course->type === Course::TYPE_COURSE, 404);
        return redirect()->route('course-details', $course);
    }

    public function edit(Course $course)
    {
        abort_unless($course->type === Course::TYPE_COURSE, 404);
        $course->load(['socialLink', 'courseTopics']);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'type' => ['required', 'in:course'],
            'name' => ['required', 'string', 'max:160'],

            // NEW
            'courseHoldingName' => ['nullable', 'string', 'max:160'],

            'courseUrl' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
            'info' => ['nullable', 'string'],

            'duration' => ['nullable', 'string', 'max:120'],
            'instructor' => ['nullable', 'string', 'max:120'],
            'price' => ['nullable', 'numeric', 'min:0'],

            'image' => ['nullable', 'image', 'max:3072'],

            // socials
            'twitterurl' => ['nullable', 'url', 'max:500'],
            'facebookurl' => ['nullable', 'url', 'max:500'],
            'linkedinurl' => ['nullable', 'url', 'max:500'],
            'emailurl' => ['nullable', 'string', 'max:500'],
            'whatsappurl' => ['nullable', 'string', 'max:500'],

            // topics
            'topics' => ['nullable', 'array'],
            'topics.*' => ['nullable', 'string', 'max:120'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $data['imageUrl'] = asset('storage/' . $path);
        }

        $course->update($data);

        $course->socialLink()->updateOrCreate(
            ['course_id' => $course->id],
            [
                'twitterurl' => $request->twitterurl,
                'facebookurl' => $request->facebookurl,
                'linkedinurl' => $request->linkedinurl,
                'emailurl' => $request->emailurl,
                'whatsappurl' => $request->whatsappurl,
            ]
        );

        // topics resync
        $topics = collect($request->input('topics', []))
            ->map(fn($t) => trim((string) $t))
            ->filter()
            ->values();

        $course->courseTopics()->delete();

        foreach ($topics as $i => $t) {
            $course->courseTopics()->create([
                'title' => $t,
                'sort_order' => $i + 1,
            ]);
        }

        return redirect()->route('admin.courses.edit', $course)->with('ok', 'Dəyişikliklər yadda saxlanıldı.');
    }
    public function destroy(Course $course)
    {
        abort_unless($course->type === Course::TYPE_COURSE, 404);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('ok', 'Silindi');
    }

    private function gcsPublicUrl(string $filename): string
    {
        $base = rtrim(config('filesystems.disks.gcs.api_url'), '/');
        $bucket = config('filesystems.disks.gcs.bucket');
        $prefix = trim(config('filesystems.disks.gcs.path_prefix', ''), '/');

        return $prefix
            ? "{$base}/{$bucket}/{$prefix}/{$filename}"
            : "{$base}/{$bucket}/{$filename}";
    }
}
