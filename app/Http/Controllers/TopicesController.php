<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class TopicesController extends Controller
{
    // Grid + Search
public function index(Request $request)
{
    $q = trim((string) $request->query('q', ''));

    // YENI: holding
    $holding = trim((string) $request->query('holding', ''));

    $query = Course::query()->type(Course::TYPE_TOPIC);

    // YENI: holding filter (exact)
    if ($holding !== '') {
        $query->where('courseHoldingName', $holding);
    }

    if ($q !== '') {
        $query->where(function ($qq) use ($q) {
            $qq->where('name', 'like', "%{$q}%")
               ->orWhere('description', 'like', "%{$q}%");
        });
    }

    $topices = $query->latest()
        ->paginate(9)
        ->appends(['q' => $q, 'holding' => $holding]);

    return view('educve.topices', compact('topices', 'q', 'holding'));
}


    // Details (param adı {topic} ilə eyni OLMALIDIR)
    public function show(Course $topic)
    {
        // Bu id-li yazının tipini yoxla; TOPIC deyilsə 404
        abort_unless($topic->type === Course::TYPE_TOPIC, 404);

        $topic->increment('views');

        $relatedTopices = Course::query()
            ->type(Course::TYPE_TOPIC)
            ->where('id', '!=', $topic->id)
            ->latest()
            ->take(6)
            ->get();

        return view('educve.topices-details', [
            'topic'          => $topic->fresh('socialLink'),
            'relatedTopices' => $relatedTopices,
        ]);
    }
}
