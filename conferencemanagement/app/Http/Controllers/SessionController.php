<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
    public function create()
    {
        return view('auth.login');
    }
    public function store()
    {
        $attribute = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Trouver l'utilisateur d'abord pour vérifier son statut
        $user = User::where('email', $attribute['email'])->first();
        if ($user && !$user->email_verified_at) {
            return redirect()->route('auth.verify-emailverification.resend')
                ->with('unverified_email', $user->email);
        }

        if (!Auth::attempt($attribute)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.'
            ]);
        }

        request()->session()->regenerate();

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->last_activity = now(); //
        $user->save();

        return redirect('/');
    }
}
