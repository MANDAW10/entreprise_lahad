<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function showDirectResetForm()
    {
        return view('auth.passwords.direct');
    }

    public function resetDirect(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'L\'adresse email ou le numéro de téléphone ne correspondent pas à nos dossiers.'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Votre mot de passe a été modifié avec succès ! Vous pouvez maintenant vous connecter.');
    }
}
