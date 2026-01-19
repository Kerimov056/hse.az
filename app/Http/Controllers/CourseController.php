<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
  public function index(Request $request)
{
    $q = trim((string) $request->query('q', ''));
    $normalized = $q !== '' ? preg_replace('/\s+/u', ' ', $q) : '';

    // YENI: holding
    $holding = trim((string) $request->query('holding', ''));

    $query = Course::query()->type(Course::TYPE_COURSE);

    // YENI: holding filter (exact)
    if ($holding !== '') {
        $query->where('courseHoldingName', $holding);
    }

    // əvvəlki q search qalır
    if ($q !== '') {
        $aliases = collect([$normalized]);

        if (preg_match('/^e[\s\-]?learning$/i', $normalized)) {
            $aliases = $aliases->merge(['E-learning', 'Elearning', 'E learning']);
        }

        if (strcasecmp($normalized, 'Local Training') === 0) {
            $aliases = $aliases->merge(['Local', 'Local Training']);
        }

        $known = ['IOSH', 'NEBOSH', 'CIEH', 'IIRSM', 'NSC'];
        if (in_array(strtoupper($normalized), $known, true)) {
            $aliases->push(strtoupper($normalized))->push(ucfirst(strtolower($normalized)));
        }

        $query->where(function ($wrap) use ($aliases) {
            foreach ($aliases->unique() as $term) {
                $wrap->orWhere('name', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%');
            }
        });
    }

    $courses = $query->latest()
        ->paginate(9)
        ->appends(['q' => $q, 'holding' => $holding]);

    return view('educve.courses-grid-view', compact('courses', 'q', 'holding'));
}


    public function show(\App\Models\Course $course)
    {
        abort_unless($course->type === \App\Models\Course::TYPE_COURSE, 404);

        $course->increment('views');

        $relatedCourses = \App\Models\Course::query()
            ->type(\App\Models\Course::TYPE_COURSE)   // eyni tipdən oxşarlar
            ->where('id', '!=', $course->id)
            ->latest()
            ->take(6)
            ->get();

        return view('educve.course-details', [
            'course'         => $course->fresh(),
            'relatedCourses' => $relatedCourses,
        ]);
    }
}
