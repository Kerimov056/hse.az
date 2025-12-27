<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // News list + search
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $normalized = $q !== '' ? preg_replace('/\s+/u', ' ', $q) : '';

        $query = Course::query()->type(Course::TYPE_NEWS);

        if ($q !== '') {
            $query->where(function ($wrap) use ($normalized) {
                $wrap->where('name', 'like', "%{$normalized}%")
                     ->orWhere('description', 'like', "%{$normalized}%");
            });
        }

        $news = $query->latest()
            ->paginate(9)
            ->appends(['q' => $q]);

        return view('educve.news', compact('news', 'q'));
    }

    // News detail
    public function show(Course $news)
    {
        abort_unless($news->type === Course::TYPE_NEWS, 404);

        // view sayını artır
        $news->increment('views');

        $relatedNews = Course::query()
            ->type(Course::TYPE_NEWS)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(6)
            ->get();

        return view('educve.news-details', [
            'news'         => $news->fresh(),
            'relatedNews'  => $relatedNews,
        ]);
    }
}
