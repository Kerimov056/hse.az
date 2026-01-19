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

    // YENI: holding
    $holding = trim((string) $request->query('holding', ''));

    $query = Course::query()->type(Course::TYPE_SERVICE);

    // YENI: holding filter (exact)
    if ($holding !== '') {
        $query->where('courseHoldingName', $holding);
    }

    if ($q !== '') {
        $aliases = collect([$normalized]);

        if (preg_match('/^evac(uation)?[\s\-]*map$/i', $normalized)) {
            $aliases = $aliases->merge(['Evacuation Map', 'Evacuation plan', 'Evac Map']);
        }

        if (preg_match('/^instruction[\s\-]*books?$/i', $normalized)) {
            $aliases = $aliases->merge(['Instruction Books', 'Instruction Book', 'Manual', 'Manuals']);
        }

        if (preg_match('/^safety[\s\-]*signs?$/i', $normalized)) {
            $aliases = $aliases->merge(['Safety Signs', 'Safety Signage', 'Signage']);
        }

        $query->where(function ($wrap) use ($aliases) {
            foreach ($aliases->unique() as $term) {
                $wrap->orWhere('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            }
        });
    }

    $services = $query->latest()
        ->paginate(9)
        ->appends(['q' => $q, 'holding' => $holding]);

    return view('educve.service', compact('services', 'q', 'holding'));
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
