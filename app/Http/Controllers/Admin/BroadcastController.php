<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\AdminAlert;
use Illuminate\Support\Facades\Notification;

class BroadcastController extends Controller
{
    public function create()
    {
        return view('admin.broadcast.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'target' => 'required|in:all,customers',
        ]);

        $users = User::where('is_admin', false)->get(); // Envoyer à tous les clients

        Notification::send($users, new AdminAlert($validated['title'], $validated['message']));

        return back()->with('success', 'Votre notification a bien été envoyée à ' . $users->count() . ' clients.');
    }
}
