<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;   // Admin tərəfdə istifadə etdiyiniz model
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Faqs list — iki hissəyə bölünmüş şəkildə.
     */
    public function index(): View
    {
        // İstəyə görə burada published/is_active filtri qoya bilərsiniz.
        // Məs: ->where('is_active', true) və ya ->where('published', 1)
        $faqs = Faq::query()
            ->latest()
            ->get();

        $count      = $faqs->count();
        $firstCount = (int) ceil($count / 2);

        $faqsCol1 = $faqs->slice(0, $firstCount)->values();
        $faqsCol2 = $faqs->slice($firstCount)->values();

        return view('educve.faqss', compact('faqsCol1', 'faqsCol2'));
    }
}
