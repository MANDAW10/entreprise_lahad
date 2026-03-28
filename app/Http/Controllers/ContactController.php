<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $dbMessage = \App\Models\ContactMessage::create($validated);

        \Illuminate\Support\Facades\Notification::send(
            \App\Models\User::where('is_admin', true)->get(),
            new \App\Notifications\NewContactMessage($dbMessage)
        );

        return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons rapidement.');
    }
}
