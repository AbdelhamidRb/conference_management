<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        if (!request('email')) {
            abort(404);
        }
        $user = User::where('email', $request->email)->first();
        if (!($user->email_verified_at)) {
            return redirect()->route('verification.resend')->with('unverified_email', $request->email);
        }
        $request->validate(['email' => 'required|email|exists:users,email']);
        $token = Str::random(64);
        $user = User::where('email', $request->email)->first();
        if (!($user->email_verified_at)) {
            return redirect('verification.resend')->with(['unverified_email' => $request->email]);
        }

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = url("/reset-password/{$token}?email={$request->email}");

        // Envoie email
        Mail::raw("Click here to reset your password: $resetLink", function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset your password');
        });

        return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre email.');
    }

    public function showResetForm(Request $request, $token)
    {
        if (!$token) {
            return redirect()->route('login');
        }
        $email = $request->query('email');

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Invalid or expired token']);
        }

        // Change password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Supprime le token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Password successfully reset.');
    }
}
