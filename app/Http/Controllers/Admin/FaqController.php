<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $faqs = Faq::query()
            ->when($q !== '', fn($qq) =>
                $qq->where('question', 'like', "%{$q}%")
                   ->orWhere('answer', 'like', "%{$q}%")
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.faqs.index', compact('faqs', 'q'));
    }

    public function create()
    {
        $faq = new Faq(['is_active' => true]);
        return view('admin.faqs.create', compact('faq'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question'  => ['required', 'string', 'max:255'],
            'answer'    => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Faq::create([
            'question'  => $data['question'],
            'answer'    => $data['answer'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.faqs.index')->with('ok', 'FAQ əlavə olundu.');
    }

    public function show(Faq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question'  => ['required', 'string', 'max:255'],
            'answer'    => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $faq->update([
            'question'  => $data['question'],
            'answer'    => $data['answer'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.faqs.index')->with('ok', 'FAQ yeniləndi.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('ok', 'Silindi.');
    }
}
