<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResourceItem;
use App\Models\ResourceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourcesController extends Controller
{
    public function index(Request $request)
    {
        $q       = trim((string)$request->get('q', ''));
        $type_id = (int)$request->get('type_id', 0);

        $resources = ResourceItem::query()
            ->when($type_id > 0, fn($qq) => $qq->where('resource_type_id', $type_id))
            ->search($q)
            ->latest()
            ->with('type')
            ->paginate(12)
            ->withQueryString();

        $types = ResourceType::orderBy('name')->get();

        return view('admin.resources.index', compact('resources', 'q', 'types', 'type_id'));
    }

    public function create()
    {
        $types = ResourceType::orderBy('name')->get();
        return view('admin.resources.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'resource_type_id' => ['required', 'exists:resource_types,id'],
            'name'             => ['required', 'string', 'max:255'],
            'year'             => ['nullable', 'integer', 'between:1900,2100'],
            'file'             => ['required', 'file', 'max:20480'], // 20MB
        ]);

        $file = $request->file('file');
        $ext  = $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();

        $filename = Str::slug($data['name']).'-'.uniqid().'.'.$ext;
        Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
        $url = $this->gcsPublicUrl($filename);

        DB::transaction(function () use ($data, $url, $mime) {
            ResourceItem::create([
                'resource_type_id' => $data['resource_type_id'],
                'name'             => $data['name'],
                'resourceUrl'      => $url,
                'year'             => $data['year'] ?? null,
                'mime'             => $mime,
            ]);
        });

        return redirect()->route('admin.resources.index')->with('ok', 'Resurs yaradıldı');
    }

    public function show(ResourceItem $resource)
    {
        return view('admin.resources.show', compact('resource'));
    }

    public function edit(ResourceItem $resource)
    {
        $types = ResourceType::orderBy('name')->get();
        return view('admin.resources.edit', compact('resource', 'types'));
    }

    public function update(Request $request, ResourceItem $resource)
    {
        $data = $request->validate([
            'resource_type_id' => ['required', 'exists:resource_types,id'],
            'name'             => ['required', 'string', 'max:255'],
            'year'             => ['nullable', 'integer', 'between:1900,2100'],
            'file'             => ['nullable', 'file', 'max:20480'],
        ]);

        $url  = $resource->resourceUrl;
        $mime = $resource->mime;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext  = $file->getClientOriginalExtension();
            $mime = $file->getClientMimeType();

            $filename = Str::slug($data['name']).'-'.uniqid().'.'.$ext;
            Storage::disk('gcs')->put($filename, file_get_contents($file), 'public');
            $url = $this->gcsPublicUrl($filename);
        }

        $resource->update([
            'resource_type_id' => $data['resource_type_id'],
            'name'             => $data['name'],
            'resourceUrl'      => $url,
            'year'             => $data['year'] ?? null,
            'mime'             => $mime,
        ]);

        return redirect()->route('admin.resources.index')->with('ok', 'Yeniləndi');
    }

    public function destroy(ResourceItem $resource)
    {
        $resource->delete();
        return redirect()->route('admin.resources.index')->with('ok', 'Silindi');
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
