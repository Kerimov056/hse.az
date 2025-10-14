<?php
// app/Http/Controllers/SearchController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ResourceItem;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') {
            return response()->json(['html' => view('partials.search-results', [
                'q' => $q,
                'courses'   => collect(),
                'services'  => collect(),
                'topics'    => collect(),
                'vacancies' => collect(),
                'resources' => collect(),
            ])->render()]);
        }

        // Courses table – 4 type üzrə ayrıca qruplar
        $base = Course::query()
            ->select('id','type','name','imageUrl','description')
            ->where(function ($qq) use ($q) {
                $qq->where('name','like',"%{$q}%")
                   ->orWhere('description','like',"%{$q}%");
            });

        $courses   = (clone $base)->type(Course::TYPE_COURSE)->latest()->take(5)->get();
        $services  = (clone $base)->type(Course::TYPE_SERVICE)->latest()->take(5)->get();
        $topics    = (clone $base)->type(Course::TYPE_TOPIC)->latest()->take(5)->get();
        $vacancies = (clone $base)->type(Course::TYPE_VACANCY)->latest()->take(5)->get();

        

        // Resources (resources cədvəli)
        $resources = ResourceItem::query()
            ->with('type:id,name')
            ->search($q)
            ->latest()
            ->take(5)
            ->get(['id','resource_type_id','name','year','mime']);

        return response()->json([
            'html' => view('partials.search-results', compact(
                'q','courses','services','topics','vacancies','resources'
            ))->render()
        ]);
    }
}
