<?php

namespace App\Observers;

use App\Events\NewContentPublished;
use App\Models\Course;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CourseObserver
{
    private const NAV_KEYS = [
        'nav.course_holdings',
        'nav.service_holdings',
        'nav.topic_holdings',
    ];

    private function bustNavCache(): void
    {
        foreach (self::NAV_KEYS as $key) {
            Cache::forget($key);
        }
    }

    public function created(Course $course): void
    {
        // 1) navbar holding cache-ləri dərhal yenilənsin
        $this->bustNavCache();

        // 2) yalnız dörd tipdən biri
        if (!in_array($course->type, ['course', 'service', 'topic', 'vacancy'], true)) {
            return;
        }

        event(new NewContentPublished(
            $course->type,
            $course->name,
            route(match ($course->type) {
                'service' => 'service-details',
                'topic'   => 'topices-details',
                'vacancy' => 'vacancies-details',
                default   => 'course-details',
            }, $course->id),
            Str::limit(strip_tags($course->description ?? ''), 160)
        ));
    }

    public function updated(Course $course): void
    {
        // type və ya courseHoldingName dəyişəndə nav cache-lər dərhal yenilənsin
        $this->bustNavCache();
    }

    public function deleted(Course $course): void
    {
        $this->bustNavCache();
    }

    public function restored(Course $course): void
    {
        $this->bustNavCache();
    }

    public function forceDeleted(Course $course): void
    {
        $this->bustNavCache();
    }
}
