<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'email'     => ['required', 'email', 'max:150'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'topic'     => ['nullable', 'string', 'max:200'],
            'message'   => ['required', 'string', 'max:5000'],
        ]);

        // hard-coded recipient (as requested)
        $to = 'ulvisk@code.edu.az';

        // send immediately (no queue)
        Mail::to($to)->send(new ContactMessageMail($data));

        return back()->with('contact_ok', 'Thanks! Your message has been sent.');
    }
}
