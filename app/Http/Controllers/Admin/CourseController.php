<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SocialLink;
use App\Models\CourseTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $holding = trim((string) $request->get('holding', ''));

        $query = Course::query()
            ->where('type', Course::TYPE_COURSE)
            ->with('courseTopics');

        // HOLDING FILTER
        if ($holding !== '') {
            $query->where('courseHoldingName', $holding);
        }

        // SEARCH
        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('instructor', 'like', "%{$q}%")
                    ->orWhere('duration', 'like', "%{$q}%")
                    ->orWhere('courseHoldingName', 'like', "%{$q}%");
            });
        }

        $courses = $query->orderByDesc('id')->paginate(20)->withQueryString();

        return view('admin.courses.index', compact('courses', 'q', 'holding'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        Log::info('[Course.store] START', [
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'has_file_image' => $request->hasFile('image'),
            'file_keys' => array_keys($request->allFiles()),
        ]);

        $data = $request->validate([
            'type' => ['required', 'in:course'],
            'name' => ['required', 'string', 'max:160'],

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

        Log::info('[Course.store] VALIDATION OK', [
            'data_keys' => array_keys($data),
            'type' => $data['type'] ?? null,
            'name' => $data['name'] ?? null,
        ]);

        // Image upload (GCS if available, else public)
        if ($request->hasFile('image')) {
            $data['imageUrl'] = $this->uploadCourseImage($request->file('image'), $data['name'] ?? 'course');
            Log::info('[Course.store] IMAGE URL SET', ['imageUrl' => $data['imageUrl']]);
        }

        $course = DB::transaction(function () use ($data, $request) {
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

            return $course;
        });

        Log::info('[Course.store] END', ['course_id' => $course->id]);

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
        abort_unless($course->type === Course::TYPE_COURSE, 404);

        Log::info('[Course.update] START', [
            'course_id' => $course->id,
            'method' => $request->method(),
            'has_file_image' => $request->hasFile('image'),
        ]);

        $data = $request->validate([
            'type' => ['required', 'in:course'],
            'name' => ['required', 'string', 'max:160'],

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

        // keep old image unless new uploaded
        if ($request->hasFile('image')) {
            $data['imageUrl'] = $this->uploadCourseImage($request->file('image'), $data['name'] ?? 'course');
            Log::info('[Course.update] IMAGE URL SET', ['course_id' => $course->id, 'imageUrl' => $data['imageUrl']]);
        } else {
            unset($data['imageUrl']); // IMPORTANT: empty gəlməsin, köhnəni silməsin
        }

        DB::transaction(function () use ($course, $data, $request) {
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
        });

        Log::info('[Course.update] END', ['course_id' => $course->id]);

        return redirect()->route('admin.courses.edit', $course)->with('ok', 'Dəyişikliklər yadda saxlanıldı.');
    }

    public function destroy(Course $course)
    {
        abort_unless($course->type === Course::TYPE_COURSE, 404);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('ok', 'Silindi');
    }

    /**
     * Upload image to GCS if disk exists; otherwise store on public disk.
     * Returns public URL for saving into DB.
     */
    private function uploadCourseImage($file, string $nameForSlug): string
    {
        $original = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension() ?: 'png';
        $safeName = Str::slug($nameForSlug ?: 'course');
        $filename = $safeName . '-' . uniqid() . '.' . $ext;

        // Prefer GCS if configured
        try {
            if (config('filesystems.disks.gcs')) {
                Log::info('[Course.image] TRY GCS UPLOAD', [
                    'original' => $original,
                    'filename' => $filename,
                ]);

                Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');

                $url = $this->gcsPublicUrl($filename);

                Log::info('[Course.image] GCS UPLOAD OK', [
                    'filename' => $filename,
                    'url' => $url,
                ]);

                return $url;
            }
        } catch (\Throwable $e) {
            Log::error('[Course.image] GCS UPLOAD FAILED, FALLBACK TO PUBLIC', [
                'error' => $e->getMessage(),
            ]);
        }

        // Fallback: local public disk
        $path = $file->storeAs('courses', $filename, 'public');
        $url = Storage::disk('public')->url($path); // better than asset()

        Log::info('[Course.image] PUBLIC UPLOAD OK', [
            'path' => $path,
            'url' => $url,
            'disk_root' => storage_path('app/public'),
        ]);

        return $url;
    }

    private function gcsPublicUrl(string $filename): string
    {
        $base = rtrim((string) config('filesystems.disks.gcs.api_url'), '/');
        $bucket = (string) config('filesystems.disks.gcs.bucket');
        $prefix = trim((string) config('filesystems.disks.gcs.path_prefix', ''), '/');

        return $prefix !== ''
            ? "{$base}/{$bucket}/{$prefix}/{$filename}"
            : "{$base}/{$bucket}/{$filename}";
    }
}
