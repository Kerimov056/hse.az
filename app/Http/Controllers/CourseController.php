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

        $query = \App\Models\Course::query()
            ->type(\App\Models\Course::TYPE_COURSE); // <-- yalnız kurslar

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $courses = $query->latest()->paginate(9)->appends(['q' => $q]);

        return view('educve.courses-grid-view', compact('courses', 'q'));
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
