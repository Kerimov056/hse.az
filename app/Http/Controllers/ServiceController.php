<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course; // eyni model
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Services grid + search
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $normalized = $q !== '' ? preg_replace('/\s+/u', ' ', $q) : '';

        $query = Course::query()->type(Course::TYPE_SERVICE);

        if ($q !== '') {
            // Kiçik alias dəstəyi
            $aliases = collect([$normalized]);

            // Evacuation Map variasiyaları
            if (preg_match('/^evac(uation)?[\s\-]*map$/i', $normalized)) {
                $aliases = $aliases->merge(['Evacuation Map', 'Evacuation plan', 'Evac Map']);
            }

            // Instruction Books variasiyaları
            if (preg_match('/^instruction[\s\-]*books?$/i', $normalized)) {
                $aliases = $aliases->merge(['Instruction Books', 'Instruction Book', 'Manual', 'Manuals']);
            }

            // Safety Signs variasiyaları
            if (preg_match('/^safety[\s\-]*signs?$/i', $normalized)) {
                $aliases = $aliases->merge(['Safety Signs', 'Safety Signage', 'Signage']);
            }

            // Əsas axtarış (ad və təsvir)
            $query->where(function ($wrap) use ($aliases, $normalized) {
                foreach ($aliases->unique() as $term) {
                    $wrap->orWhere('name', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                }

                // Əgər services üçün ayrıca mətn sütununuz varsa (məs: category və s.), burada əlavə edə bilərsiniz:
                // $wrap->orWhere('category', 'like', "%{$normalized}%");
            });
        }

        $services = $query->latest()
            ->paginate(9)
            ->appends(['q' => $q]);

        return view('educve.service', compact('services', 'q'));
    }

    // Service detail
    public function show(Course $service)
    {
        abort_unless($service->type === Course::TYPE_SERVICE, 404);

        $service->increment('views');

        $relatedServices = Course::query()
            ->type(Course::TYPE_SERVICE)
            ->where('id', '!=', $service->id)
            ->latest()
            ->take(6)
            ->get();

        // View faylı: resources/views/educve/service-details.blade.php
        return view('educve.service-details', [
            'service'         => $service->fresh(),
            'relatedServices' => $relatedServices,
        ]);
    }
}
