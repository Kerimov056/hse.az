<?php
// app/Observers/CourseObserver.php
namespace App\Observers;

use App\Events\NewContentPublished;
use App\Models\Course;

class CourseObserver
{
    public function created(Course $course): void
    {
        // yalnız dörd tipdən biri
        if (!in_array($course->type, ['course', 'service', 'topic', 'vacancy'])) return;

        event(new NewContentPublished(
            $course->type,
            $course->name,
            route(match ($course->type) {
                'service' => 'service-details',
                'topic'   => 'topices-details',
                'vacancy' => 'vacancies-details',
                default   => 'course-details',
            }, $course->id),
            \Illuminate\Support\Str::limit(strip_tags($course->description ?? ''), 160)
        ));
    }
}
