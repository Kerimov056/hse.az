<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VacanciesController extends Controller
{
    // Yalnız VACANCY-lər
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $vacancies = Course::query()
            ->type(Course::TYPE_VACANCY)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('admin.vacancies.index', compact('vacancies', 'q'));
    }

    public function create()
    {
        return view('admin.vacancies.create');
    }

    // CREATE/STORE
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
            $filename = Str::slug($data['name'] ?? 'vacancy') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($data, $imageUrl) {
            $vacancy = Course::create([
                'type'        => Course::TYPE_VACANCY,
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl'] ?? null,
                'description' => $data['description'] ?? null,
                'imageUrl'    => $imageUrl,
            ]);

            SocialLink::create([
                'course_id'   => $vacancy->id,
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
        });

        return redirect()->route('admin.vacancies.index')->with('ok', 'Vakansiya yaradıldı');
    }

    public function show(Course $vacancy)
    {
        abort_unless($vacancy->type === Course::TYPE_VACANCY, 404);
        return view('admin.vacancies.show', ['vacancy' => $vacancy->load('socialLink')]);
    }

    public function edit(Course $vacancy)
    {
        abort_unless($vacancy->type === Course::TYPE_VACANCY, 404);
        $vacancy->load('socialLink');
        return view('admin.vacancies.edit', ['vacancy' => $vacancy]);
    }

    public function update(Request $request, Course $vacancy)
    {
        abort_unless($vacancy->type === Course::TYPE_VACANCY, 404);

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

        $imageUrl = $vacancy->imageUrl;
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = Str::slug($data['name'] ?? 'vacancy') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($vacancy, $data, $imageUrl) {
            $vacancy->update([
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl'] ?? null,
                'description' => $data['description'] ?? null,
                'imageUrl'    => $imageUrl,
            ]);

            $link = $vacancy->socialLink ?: new SocialLink(['course_id' => $vacancy->id]);
            $link->fill([
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
            $link->course()->associate($vacancy);
            $link->save();
        });

        return redirect()->route('admin.vacancies.index')->with('ok', 'Yeniləndi');
    }

    public function destroy(Course $vacancy)
    {
        abort_unless($vacancy->type === Course::TYPE_VACANCY, 404);
        $vacancy->delete();
        return redirect()->route('admin.vacancies.index')->with('ok', 'Silindi');
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
