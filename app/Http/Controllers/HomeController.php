<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Team;
use App\Models\Accreditation;
use App\Models\ResourceItem;

class HomeController extends Controller
{
    public function index()
    {
        // “Popular Courses” üçün hər tipdən ən yenilər
        $courses   = Course::query()->type(Course::TYPE_COURSE)->latest()->take(6)->get();
        $services  = Course::query()->type(Course::TYPE_SERVICE)->latest()->take(6)->get();
        $topics    = Course::query()->type(Course::TYPE_TOPIC)->latest()->take(6)->get();
        $vacancies = Course::query()->type(Course::TYPE_VACANCY)->latest()->get();

        // Team highlight – bütün komanda üzvləri (slider üçün)
        $teamMembers = Team::query()
            ->latest()
            ->get();

        // Event bölməsi üçün 4 akkreditasiya (1 böyük + 3 kiçik)
        $accreds = Accreditation::query()->latest()->take(4)->get();

        // Event bölməsinin yerinə göstəriləcək “Latest Resources”
        $resources = ResourceItem::query()
            ->with('type')
            ->latest()
            ->take(4)   // 1 böyük + 3 kiçik
            ->get();

        return view('educve.index', compact(
            'courses',
            'services',
            'topics',
            'vacancies',
            'teamMembers',
            'accreds',
            'resources'
        ));
    }
}
