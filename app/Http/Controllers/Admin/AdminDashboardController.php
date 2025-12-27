<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Resource;
use App\Models\ResourceType;
use App\Models\Team;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\Accreditation;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $who = Auth::user();

        // Ümumi saylar – hamısı Course üzərindən type ilə
        $totals = [
            'courses'         => Course::type(Course::TYPE_COURSE)->count(),
            'services'        => Course::type(Course::TYPE_SERVICE)->count(),
            'topics'          => Course::type(Course::TYPE_TOPIC)->count(),
            'vacancies'       => Course::type(Course::TYPE_VACANCY)->count(),
            'news'            => Course::type(Course::TYPE_NEWS)->count(),

            // Bunlar ayrı modellərdirsə:
            'resources'       => class_exists(Resource::class)      ? Resource::count()      : 0,
            'resource_types'  => class_exists(ResourceType::class)  ? ResourceType::count()  : 0,
            'teams'           => class_exists(Team::class)          ? Team::count()          : 0,
            'faqs'            => class_exists(Faq::class)           ? Faq::count()           : 0,
            'gallery_images'  => class_exists(GalleryImage::class)  ? GalleryImage::count()  : 0,
            'accreditations'  => class_exists(Accreditation::class) ? Accreditation::count() : 0,
        ];

        // Ümumi baxışlar – bütün course-ların views cəmi
        $totalViews = (int) Course::sum('views');

        // Son 5 xəbər / vakansiya / kurs – hamısı Course modeli üzərindən
        $latestNews = Course::type(Course::TYPE_NEWS)
            ->latest('created_at')
            ->take(5)
            ->get();

        $latestVacancies = Course::type(Course::TYPE_VACANCY)
            ->latest('created_at')
            ->take(5)
            ->get();

        $latestCourses = Course::type(Course::TYPE_COURSE)
            ->latest('created_at')
            ->take(5)
            ->get();

        // Sağdakı “Son resurslar” üçün (əgər bu model varsa)
        $latestResources = class_exists(Resource::class)
            ? Resource::latest('created_at')->take(5)->get()
            : collect();

        return view('admin.dashboard', [
            'who'             => $who,
            'totals'          => $totals,
            'totalViews'      => $totalViews,
            'latestNews'      => $latestNews,
            'latestVacancies' => $latestVacancies,
            'latestCourses'   => $latestCourses,
            'latestResources' => $latestResources,
        ]);
    }
}
