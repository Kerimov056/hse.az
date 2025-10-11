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

        $query = Course::query()->type(Course::TYPE_SERVICE);

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $services = $query
            ->latest()
            ->paginate(9)
            ->appends(['q' => $q]);

        // View faylı: resources/views/educve/service.blade.php
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
