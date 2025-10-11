<?php
// app/Http/Controllers/SubscribeController.php
namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscribeController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate([
            'email' => ['required', 'email', 'max:150'],
            'name'  => ['nullable', 'string', 'max:120'],
        ]);

        // unik saxla
        $sub = Subscriber::firstOrCreate(
            ['email' => strtolower($data['email'])],
            ['name' => $data['name'] ?? null, 'token' => Str::random(40), 'verified_at' => now()] // sadə: dərhal təsdiq
        );

        // AJAX üçün JSON; adi POST olarsa redirect
        if ($r->expectsJson()) {
            return response()->json(['ok' => true, 'message' => 'Subscribed.']);
        }
        return back()->with('sub_ok', 'Subscribed.');
    }

    public function unsubscribe(Request $r, string $token)
    {
        $sub = Subscriber::where('token', $token)->firstOrFail();
        $sub->delete();

        return redirect()->route('home')->with('sub_ok', 'You unsubscribed successfully.');
    }
}
