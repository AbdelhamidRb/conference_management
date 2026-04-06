<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conference;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'firstName' => ['required', 'min:3'],
            'lastName' => ['required', 'min:3'],
            'affiliation' => ['required'],
            'country' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
                'confirmed'
            ]
        ]);

        // Générer un token de vérification
        $verificationToken = Str::random(60);

        $user = User::where('email', $attributes['email'])->first();

        if ($user) {
            if ($user->password) {
                return back()->withErrors(['email' => 'This email is already in use.']);
            } else {
                $user->fill([
                    'firstName' => $attributes['firstName'],
                    'lastName' => $attributes['lastName'],
                    'affiliation' => $attributes['affiliation'],
                    'country' => $attributes['country'],
                    'password' => bcrypt($attributes['password']),
                    'verification_token' => $verificationToken,
                    'email_verified_at' => null,
                    'last_activity' => now()
                ])->save();
            }
        } else {
            $attributes['password'] = bcrypt($attributes['password']);
            $attributes['verification_token'] = $verificationToken;
            $user = User::create($attributes);
        }

        // Envoyer l'email de vérification
        Mail::to($user->email)->send(new EmailVerification($user));

        // Ne pas connecter l'utilisateur directement
        return redirect('/email/verify')->with(['status' => 'A verification link has been sent to your email address.', 'email' => $user->email]);
    }

    public function resend(Request $request)
    {
        $email = null;
        if (request('unverified_email')) {
            $email = request('unverified_email');
        }


        if (session()->has('unverified_email')) {
            $email = session('unverified_email');
        } elseif (request()->has('email')) {
            $email = request('email');
        }

        $user = $request->user() ?: User::where('email', $email)->first();



        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Your email is already verified.');
        }

        // Générer un nouveau token valide 24h
        $token = Str::random(60);
        $expiresAt = Carbon::now()->addHours(24);

        $user->update([
            'verification_token' => $token,
            'verification_token_expires_at' => $expiresAt
        ]);

        Mail::to($user->email)->send(new EmailVerification($user, $token));
        if (request('unverified_email') || session()->has('unverified_email')) {
            return redirect('login')->with('unverified_email', $email);
        }
        return back()->with(['status' => 'A verification link has been sent to your email address.', 'email' => $user->email]);
    }
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect('/register')->with('error', 'Invalid verification link.');
        }

        $user->update([
            'email_verified_at' => now(),
            'verification_token' => null
        ]);

        Auth::login($user);

        return redirect('/')->with('success', '**Your email has been successfully verified!**
');
    }

    public function create()
    {
        return view('auth.register');
    }
    public function showLogin()
    {
        return view('auth.login');
    }
    public function showUser()
    {
        $userId = request('user');
        $acronyme = request('acronyme');
        if (!$userId || !$acronyme) {
            abort(403);
        }

        // Get the user and the conference by their IDs
        $user = User::find($userId);  // Use find() for single model
        $conference = Conference::where('acronyme', $acronyme)->first();  // Use first() to get a single model

        // Check if the conference exists
        if (!$conference) {
            abort(403);
        }

        // Check if the current user is the chair of the conference
        $isChair = $conference->userconferences->contains(function ($userConference) {
            return $userConference->user_id === Auth::id() && $userConference->role === 'chair';
        });

        if (!$isChair) {
            abort(403);
        }

        return view('dashboardUser.chair.userInformation', ['user' => $user]);
    }
    public function verify1()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.verify-email');
    }
}
