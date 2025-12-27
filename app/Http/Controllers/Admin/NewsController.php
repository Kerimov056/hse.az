<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course; // eyni cədvəl
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // INDEX: yalnız TYPE_NEWS
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $news = Course::query()
            ->type(Course::TYPE_NEWS) // <-- əsas filter
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('info', 'like', "%{$q}%"); // istəsən axtarışa info-nu da əlavə edə bilərsən
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('admin.news.index', compact('news', 'q'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    // STORE: type = news
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'courseUrl'   => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
            'info'        => ['nullable', 'string'], // <-- info validation
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
            $filename = Str::slug($data['name'] ?? 'news') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($data, $imageUrl) {
            $news = Course::create([
                'type'        => Course::TYPE_NEWS, // ← əsas fərq
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl']   ?? null,
                'description' => $data['description'] ?? null,
                'info'        => $data['info']        ?? null, // <-- BURADA DB-yə yazırıq
                'imageUrl'    => $imageUrl,
            ]);

            SocialLink::create([
                'course_id'   => $news->id,
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
        });

        return redirect()->route('admin.news.index')->with('ok', 'Xəbər yaradıldı');
    }

    public function show(Course $news)
    {
        abort_unless($news->type === Course::TYPE_NEWS, 404);
        return view('admin.news.show', compact('news'));
    }

    public function edit(Course $news)
    {
        abort_unless($news->type === Course::TYPE_NEWS, 404);
        $news->load('socialLink');

        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, Course $news)
    {
        abort_unless($news->type === Course::TYPE_NEWS, 404);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'courseUrl'   => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
            'info'        => ['nullable', 'string'], // <-- validation
            'image'       => ['nullable', 'image', 'max:3072'],

            'twitterurl'  => ['nullable', 'url'],
            'facebookurl' => ['nullable', 'url'],
            'linkedinurl' => ['nullable', 'url'],
            'emailurl'    => ['nullable', 'string', 'max:255'],
            'whatsappurl' => ['nullable', 'string', 'max:255'],
        ]);

        $imageUrl = $news->imageUrl;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($data['name'] ?? 'news') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $imageUrl = $this->gcsPublicUrl($filename);
        }

        DB::transaction(function () use ($news, $data, $imageUrl) {
            $news->update([
                'name'        => $data['name'],
                'courseUrl'   => $data['courseUrl']   ?? null,
                'description' => $data['description'] ?? null,
                'info'        => $data['info']        ?? null, // <-- BURADA DA update edirik
                'imageUrl'    => $imageUrl,
            ]);

            $link = $news->socialLink ?: new SocialLink(['course_id' => $news->id]);
            $link->fill([
                'twitterurl'  => $data['twitterurl']  ?? null,
                'facebookurl' => $data['facebookurl'] ?? null,
                'linkedinurl' => $data['linkedinurl'] ?? null,
                'emailurl'    => $data['emailurl']    ?? null,
                'whatsappurl' => $data['whatsappurl'] ?? null,
            ]);
            $link->course()->associate($news);
            $link->save();
        });

        return redirect()->route('admin.news.index')->with('ok', 'Xəbər yeniləndi');
    }

    public function destroy(Course $news)
    {
        abort_unless($news->type === Course::TYPE_NEWS, 404);
        $news->delete();

        return redirect()->route('admin.news.index')->with('ok', 'Xəbər silindi');
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
