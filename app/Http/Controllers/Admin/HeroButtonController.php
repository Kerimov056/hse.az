<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroButton;
use Illuminate\Http\Request;

class HeroButtonController extends Controller
{
    public function index()
    {
        $items = HeroButton::orderBy('order')->get();
        return view('admin.hero_buttons.index', compact('items'));
    }

    public function create()
    {
        return view('admin.hero_buttons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => ['required', 'string', 'max:255'],
            'url'  => ['required', 'string', 'max:255'],
            'order'=> ['nullable', 'integer'],
        ]);

        HeroButton::create($data);

        return redirect()->route('admin.hero-buttons.index')->with('ok', 'Button əlavə edildi');
    }

    public function edit(HeroButton $heroButton)
    {
        return view('admin.hero_buttons.edit', compact('heroButton'));
    }

    public function update(Request $request, HeroButton $heroButton)
    {
        $data = $request->validate([
            'text' => ['required', 'string', 'max:255'],
            'url'  => ['required', 'string', 'max:255'],
            'order'=> ['nullable', 'integer'],
        ]);

        $heroButton->update($data);

        return redirect()->route('admin.hero-buttons.index')->with('ok', 'Yeniləndi');
    }

    public function destroy(HeroButton $heroButton)
    {
        $heroButton->delete();
        return redirect()->route('admin.hero-buttons.index')->with('ok', 'Silindi');
    }
}
