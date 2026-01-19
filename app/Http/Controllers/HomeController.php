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
        $courses   = Course::query()->type(Course::TYPE_COURSE)->latest()->take(6)->get();
        $services  = Course::query()->type(Course::TYPE_SERVICE)->latest()->take(6)->get();
        $topics    = Course::query()->type(Course::TYPE_TOPIC)->latest()->take(6)->get();
        $vacancies = Course::query()->type(Course::TYPE_VACANCY)->latest()->get();

        $teamMembers = Team::query()->latest()->get();
        $accreds = Accreditation::query()->latest()->take(5)->get();

        $resources = ResourceItem::query()
            ->with('type')
            ->latest()
            ->take(4)
            ->get();

        // YENI: dropdown üçün unique holding list-lər
        $courseHoldings = Course::query()
            ->type(Course::TYPE_COURSE)
            ->whereNotNull('courseHoldingName')
            ->where('courseHoldingName', '!=', '')
            ->select('courseHoldingName')
            ->distinct()
            ->orderBy('courseHoldingName')
            ->pluck('courseHoldingName');

        $serviceHoldings = Course::query()
            ->type(Course::TYPE_SERVICE)
            ->whereNotNull('courseHoldingName')
            ->where('courseHoldingName', '!=', '')
            ->select('courseHoldingName')
            ->distinct()
            ->orderBy('courseHoldingName')
            ->pluck('courseHoldingName');

        $topicHoldings = Course::query()
            ->type(Course::TYPE_TOPIC)
            ->whereNotNull('courseHoldingName')
            ->where('courseHoldingName', '!=', '')
            ->select('courseHoldingName')
            ->distinct()
            ->orderBy('courseHoldingName')
            ->pluck('courseHoldingName');

        return view('educve.index', compact(
            'courses',
            'services',
            'topics',
            'vacancies',
            'teamMembers',
            'accreds',
            'resources',
            'courseHoldings',
            'serviceHoldings',
            'topicHoldings'
        ));
    }
}
