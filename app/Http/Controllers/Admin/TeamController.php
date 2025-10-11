<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    /**
     * Komanda siyahısı + axtarış/filtr.
     */
    public function index(Request $request)
    {
        $q      = trim((string) $request->get('q', ''));
        $gender = $request->get('gender', '');

        $teams = Team::query()
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('full_name', 'like', "%{$q}%")
                      ->orWhere('position', 'like', "%{$q}%");
                });
            })
            ->when(in_array($gender, ['male', 'female'], true), function ($qq) use ($gender) {
                $qq->where('gender', $gender);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.teams.index', compact('teams', 'q', 'gender'));
    }

    /**
     * Yarat formu.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Yarat – GCS yükləmə + skills JSON.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'position'  => ['nullable', 'string', 'max:255'],
            'gender'    => ['required', 'in:male,female'],
            'image'     => ['nullable', 'image', 'max:4096'],

            'description'     => ['nullable', 'string'],
            'phone'           => ['nullable', 'string', 'max:50'],
            'email'           => ['nullable', 'email', 'max:255'],
            'expertise_title' => ['nullable', 'string', 'max:255'],
            'expertise_intro' => ['nullable', 'string'],

            'skill_name.*'    => ['nullable', 'string', 'max:120'],
            'skill_percent.*' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $imageUrl = $this->uploadToGcsIfAny($request->file('image'));

        $skills = $this->collectSkills(
            $request->input('skill_name', []),
            $request->input('skill_percent', [])
        );

        Team::create([
            'imageUrl'        => $imageUrl,
            'gender'          => $data['gender'],
            'full_name'       => $data['full_name'],
            'position'        => $data['position'] ?? null,

            'description'     => $data['description'] ?? null,
            'phone'           => $data['phone'] ?? null,
            'email'           => $data['email'] ?? null,
            'expertise_title' => $data['expertise_title'] ?? null,
            'expertise_intro' => $data['expertise_intro'] ?? null,
            'skills'          => $skills ?: null,
        ]);

        return redirect()->route('admin.teams.index')->with('ok', 'Komanda üzvü yaradıldı');
    }

    /**
     * Bax.
     */
    public function show(Team $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    /**
     * Redaktə formu.
     */
    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Yenilə – GCS yükləmə + skills JSON.
     */
    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'position'  => ['nullable', 'string', 'max:255'],
            'gender'    => ['required', 'in:male,female'],
            'image'     => ['nullable', 'image', 'max:4096'],

            'description'     => ['nullable', 'string'],
            'phone'           => ['nullable', 'string', 'max:50'],
            'email'           => ['nullable', 'email', 'max:255'],
            'expertise_title' => ['nullable', 'string', 'max:255'],
            'expertise_intro' => ['nullable', 'string'],

            'skill_name.*'    => ['nullable', 'string', 'max:120'],
            'skill_percent.*' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $imageUrl = $team->imageUrl;
        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadToGcsIfAny($request->file('image'));
        }

        $skills = $this->collectSkills(
            $request->input('skill_name', []),
            $request->input('skill_percent', [])
        );

        $team->update([
            'imageUrl'        => $imageUrl,
            'gender'          => $data['gender'],
            'full_name'       => $data['full_name'],
            'position'        => $data['position'] ?? null,

            'description'     => $data['description'] ?? null,
            'phone'           => $data['phone'] ?? null,
            'email'           => $data['email'] ?? null,
            'expertise_title' => $data['expertise_title'] ?? null,
            'expertise_intro' => $data['expertise_intro'] ?? null,
            'skills'          => $skills ?: null,
        ]);

        return redirect()->route('admin.teams.index')->with('ok', 'Yeniləndi');
    }

    /**
     * Sil.
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('ok', 'Silindi');
    }

    // ----------------- Helpers -----------------

    /**
     * Verilən faylı GCS-ə yükləyib public URL qaytarır.
     * Layihənizin filesystems.php -> disks.gcs konfiqurasiyasından istifadə edir.
     */
    private function uploadToGcsIfAny(?\Illuminate\Http\UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        $filename = 'teams/' . Str::uuid() . '.' . $file->getClientOriginalExtension();

        // public obyekt kimi yüklə
        Storage::disk('gcs')->put($filename, file_get_contents($file), [
            'visibility' => 'public',
            'metadata'   => ['cacheControl' => 'public, max-age=31536000'],
        ]);

        // Public URL qur (konfiqurasiya ilə)
        $base   = rtrim(config('filesystems.disks.gcs.api_url', ''), '/');
        $bucket = config('filesystems.disks.gcs.bucket');
        $prefix = trim(config('filesystems.disks.gcs.path_prefix', ''), '/');

        $path = $prefix ? "{$prefix}/{$filename}" : $filename;

        return $base
            ? "{$base}/{$bucket}/{$path}"
            : Storage::disk('gcs')->url($filename);
    }

    /**
     * Formdan gələn skill-ləri təmizləyib array qaytarır.
     * @param array $names
     * @param array $percents
     * @return array<int, array{name:string,percent:int}>
     */
    private function collectSkills(array $names, array $percents): array
    {
        $skills = [];
        foreach ($names as $i => $name) {
            $name = trim((string) $name);
            if ($name === '') {
                continue;
            }
            $p = (int) ($percents[$i] ?? 0);
            $p = max(0, min(100, $p));
            $skills[] = ['name' => $name, 'percent' => $p];
        }
        return $skills;
    }
}
