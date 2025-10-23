<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // Sorğunu götür və səliqəyə sal
        $q = trim((string) $request->query('q', ''));
        $normalized = $q !== '' ? preg_replace('/\s+/u', ' ', $q) : '';

        // Yalnız kurs tipləri
        $query = Course::query()->type(Course::TYPE_COURSE);

        if ($q !== '') {
            // Yazılış fərqləri üçün kiçik sinonim/alias dəstəyi
            $aliases = collect([$normalized]);

            // E-learning variasiyaları
            if (preg_match('/^e[\s\-]?learning$/i', $normalized)) {
                $aliases = $aliases->merge(['E-learning', 'Elearning', 'E learning']);
            }

            // Local Training variasiyası
            if (strcasecmp($normalized, 'Local Training') === 0) {
                $aliases = $aliases->merge(['Local', 'Local Training']);
            }

            // Məşhur sertifikat adları üçün heç nə etməyə də bilərdik,
            // amma bərkidək ki, böyük-kiçik hərf fərqi problem olmasın:
            $known = ['IOSH', 'NEBOSH', 'CIEH', 'IIRSM', 'NSC'];
            if (in_array(strtoupper($normalized), $known, true)) {
                $aliases->push(strtoupper($normalized))->push(ucfirst(strtolower($normalized)));
            }

            // Axtarışı tək bir qrupda saxlayırıq (WHERE (... OR ...))
            $query->where(function ($wrap) use ($aliases, $normalized) {
                // Ad və təsvir üzrə axtarış
                foreach ($aliases->unique() as $term) {
                    $wrap->orWhere('name', 'like', '%' . $term . '%')
                        ->orWhere('description', 'like', '%' . $term . '%');
                }
            });
        }

        // Sıralama + səhifələmə; q parametri linklərdə saxlanır
        $courses = $query->latest()
            ->paginate(9)
            ->appends(['q' => $q]);

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
