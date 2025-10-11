<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $query = Course::query()->type(Course::TYPE_VACANCY);

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $vacancies = $query->latest()->paginate(9)->appends(['q' => $q]);

        return view('educve.vacancies', compact('vacancies', 'q'));
    }

    public function show(Course $vacancy)
    {
        abort_unless($vacancy->type === Course::TYPE_VACANCY, 404);

        $vacancy->increment('views');

        $relatedVacancies = Course::query()
            ->type(Course::TYPE_VACANCY)
            ->where('id', '!=', $vacancy->id)
            ->latest()
            ->take(6)
            ->get();

        return view('educve.vacancies-details', [
            'vacancy'          => $vacancy->fresh('socialLink'),
            'relatedVacancies' => $relatedVacancies,
        ]);
    }
}
