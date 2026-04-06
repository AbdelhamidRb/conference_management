<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Chair;
use App\Models\Topic;
use App\Models\PcMember;
use App\Models\Conference;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\UserConference;
use App\Mail\ConferenceCreated;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Mail\CoChairInvitationMail;
use App\Mail\PcMemberInvitationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;



class ConferenceController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        //si user est connecter 
        if (Auth::check()) {
            $oneYearAgo = Carbon::now()->copy()->subYear();

            $data = Auth::user()
                ->userConferences
                ->where('statut', 'accepted')
                ->filter(function ($userConference) use ($oneYearAgo) {
                    $firstDay = $userConference->conference->firstDay;

                    return Carbon::parse($firstDay)->gt($oneYearAgo);
                })
                ->groupBy(fn($userConference) => $userConference->conference->acronyme);



            return view('index1', ['data' => $data]);
        }
        // si user est deconnecte
        return view('index');
    }

    public function showAbout()
    {
        return view('about');
    }

    /**
     * Display the speakers page.
     */
    public function speakers()
    {
        // In a real app, you would fetch speakers from the database
        return view('speakers');
    }

    /**
     * Display the schedule page.
     */
    public function schedule()
    {
        // In a real app, you would fetch schedule from the database
        return view('schedule');
    }

    /**
     * Display the features page.
     */
    public function features()
    {
        return view('features');
    }
    public function showServices()
    {
        return view('services');
    }


    public function showRegister()
    {
        return view('auth.register');
    }
    /**
     * Display the user dashboard.
     */
    public function dashboard()
    {
        return view('dashboard');
    }
    public function createConference()
    {

        return view('form.conference1');
    }
    public function step1()
    {
        // pour changer la derniere button 'finish'->'update' dans le cas de modification
        if (session('conference.step1', false) && session('conference.step2', false) && session('conference.step3', false)) {
            Session::put('update', true);
        }
        return view('form.conference1');
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'regex:/\d+$/'],
            'acronyme' => ['required', 'regex:/\d+$/', 'unique:conferences,acronyme'],
            'venue' => 'required',
            'country' => 'required',
            'city' => 'required',
        ], [
            'title.regex' => 'Le titre doit se terminer par un chiffre.',
            'acronyme.regex' => "L'acronyme doit se terminer par un chiffre.",
            'acronyme.unique' => "Cet acronyme existe déjà.",
        ]);


        Session::put('conference.step1', $validated);
        return redirect()->route('conference.step2');
    }

    public function step2()
    {
        if (!session()->has("conference.step1")) {
            return view('form.conference1');
        }
        return view('form.conference2');
    }

    public function postStep2(Request $request)
    {
        $validated = request()->validate([
            'conferenceWebPage' => 'nullable|url',
            'estimatedNumberSubmission' => 'nullable|integer',
            'firstDay' => [
                'required',
                'date',
                'after:today', // Must be after today
                'before_or_equal:today + 2 years' // Must be within 2 years from today
            ],
            'lastDay' => [
                'required',
                'date',
                'after_or_equal:firstDay',
                function ($attribute, $value, $fail) use ($request) {
                    $firstDay = Carbon::parse($request->firstDay);
                    $lastDay = Carbon::parse($value);
                    // Vérifie si l'écart dépasse 2 mois
                    if ($firstDay->diffInMonths($lastDay) > 2) {
                        $fail('La date de fin doit être au maximum 2 mois après la date de début.');
                    }
                },
            ],
            'submissionDeadLine' => [
                'required',
                'after:today',
                'before:firstDay' // Must be before the first day
            ]
        ], [ // Custom messages as separate array
            'firstDay.after' => 'The first day must be a future date.',
            'firstDay.before_or_equal' => 'The first day must be within 2 years from now.',
            'lastDay.after_or_equal' => 'The last day must be on or after the first day.',
            'lastDay.before_or_equal' => 'The last day must be at most 2 months after the first day.',
            'submissionDeadLine.before' => 'The submission deadline must be before the conference start date.',
        ]);
        Session::put('conference.step2', $validated);
        return redirect()->route('conference.step3');
    }

    public function step3()
    {
        return view('form.conference3');
    }

    public function postStep3(Request $request)
    {
        $validated = $request->validate([
            'organizer' => 'required|string',
            'organizerEmail' => 'required|email',
            'organizerWebPage' => 'nullable|url',
            'organizerPhoneNumber' => 'nullable|string',
            'primaryArea' => 'nullable|string',
            'secondaryArea' => 'nullable|string',
            'topics' => [
                'required',
                'json',
                function ($attribute, $value, $fail) {
                    $topics = json_decode($value, true);
                    if (count($topics) > 4) {
                        $fail('You can select a maximum of 4 topics.');
                    }
                },
            ],
        ]);
        $validated['submissionLink'] = url('/submission1') . '?acronyme=' . session('conference.step1')['acronyme'];

        $topics = json_decode($validated['topics'], true);
        $validated['topics'] = $topics;

        Session::put('conference.step3', $validated);
        return view('succesConferenceCreation');
    }

    /**
     * Display the user profile.
     */

    public function confirmationCreateConference()
    {

        $step1 = Session::get('conference.step1');
        $step2 = Session::get('conference.step2');
        $step3 = Session::get('conference.step3');
        if ($step1 != null && $step2 != null && $step3 != null) {
            $allData = array_merge($step1, $step2, $step3);

            // Save to DB
            DB::transaction(function () use ($allData) {
                //Create Chair if not exist and pc member 
                $chair = Chair::firstOrCreate(
                    ['id' => Auth::id()],  // Check if chair already exists for the current user
                );
                $pcMember = PcMember::firstOrCreate(
                    ['id' => Auth::id()],  // Check if chair already exists for the current user
                );

                $conference = Conference::create([
                    'title' => $allData['title'],
                    'acronyme' => $allData['acronyme'],
                    'venue' => $allData['venue'],
                    'country' => $allData['country'],
                    'city' => $allData['city'],
                    'conferenceWebPage' => $allData['conferenceWebPage'],
                    'estimatedNumberSubmission' => $allData['estimatedNumberSubmission'],
                    'firstDay' => $allData['firstDay'],
                    'lastDay' => $allData['lastDay'],
                    'submissionDeadLine' => $allData['submissionDeadLine'],
                    'organizer' => $allData['organizer'],
                    'organizerWebPage' => $allData['organizerWebPage'],
                    'organizerPhoneNumber' => $allData['organizerPhoneNumber'],
                    'organizerEmail' => $allData['organizerEmail'],
                    'primaryArea' => $allData['primaryArea'],
                    'secondaryArea' => $allData['secondaryArea'],
                    'submissionLink' => $allData['submissionLink'],
                    'chair_id' => $chair->id,
                ]);

                foreach ($allData['topics'] as $topicName) {
                    $topic = Topic::create(['conference_id' => $conference['id'], 'name' => $topicName]);
                    $topicIds[] = $topic->id;
                }

                //4.insertion dans la table userconference
                DB::table('user_conferences')->insert([
                    'conference_id' => $conference->id,
                    'user_id' => Auth::id(),
                    'role' => 'chair',
                    'statut' => 'accepted',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('user_conferences')->insert([
                    'conference_id' => $conference->id,
                    'user_id' => Auth::id(),
                    'role' => 'pc member',
                    'statut' => 'accepted',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);


                // 5. Create default configuration for the conference
                Configuration::create($conferenceData = [
                    'conference_id' => $conference->id,
                    'numberArticle' => 10,
                    'numberReviewer' => 5,
                    'submissionAllowed' => 1,
                    'submissionUpdateAllowed' => 1,
                ]);
                // Send the email *after* the conference is created
                Mail::to(Auth::user()->email)
                    ->send(new ConferenceCreated($conference->title));
            });
            Session::forget('conference.step1');
            Session::forget('conference.step2');
            Session::forget('conference.step3');
        }
        return redirect('/');
    }

    public function showConferenceDetails()
    {
        $acronyme = request('acronyme');

        // Vérifier si les paramètres sont présents dans la requête
        if (!$acronyme) {
            abort(404); // Rediriger vers une page 404 si les paramètres sont manquants
        }
        // Récupérer la conférence avec l'acronyme
        $conference = Conference::where('acronyme', request('acronyme'))->first();

        // Vérifier si la conférence existe
        if (!$conference) {
            abort(404);
        }

        // Vérifier si l'utilisateur est associé à cette conférence
        $userConference = UserConference::where('conference_id', $conference->id)
            ->where('user_id', Auth::id())
            ->first();

        // Si l'utilisateur est associé à la conférence, afficher la vue, sinon 404
        if ($userConference) {
            return view('conferenceDetails');
        } else {
            abort(404);
        }
    }
    public function formulaireCoChairs()
    {
        $acronyme = request('acronyme');
        if (!$acronyme) {
            abort(404);
        }
        $conference = Conference::where('acronyme', $acronyme)->firstOrFail();

        $isChair = $conference->userconferences()
            ->where('role', 'chair')
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isChair) {
            abort(403, 'Access denied. Only chairs can access this page.');
        }
        return view('form.co-chair');
    }
    public function handleInvitations()
    {
        // Récupérer l'acronyme de la conférence
        $acronyme = request('acronyme');

        if (!$acronyme) {
            abort(404);
        }

        // Récupérer la conférence
        $conference = Conference::where('acronyme', $acronyme)->firstOrFail();

        // Validation des données pour les deux types de membres
        $validated = request()->validate([
            'contacts1.*.firstName' => 'sometimes|required|string|max:255', // Co-Chairs
            'contacts1.*.lastName' => 'sometimes|required|string|max:255',
            'contacts1.*.email' => 'sometimes|required|email',
            'contacts2.*.firstName' => 'sometimes|required|string|max:255', // PC Members
            'contacts2.*.lastName' => 'sometimes|required|string|max:255',
            'contacts2.*.email' => 'sometimes|required|email',
        ]);

        DB::transaction(function () use ($validated, $conference) {
            // Traitement des Co-Chairs (contacts1)
            if (isset($validated['contacts1'])) {
                foreach ($validated['contacts1'] as $contact) {
                    $this->processChairInvitation($contact, $conference);
                }
            }

            // Traitement des PC Members (contacts2)
            if (isset($validated['contacts2'])) {
                foreach ($validated['contacts2'] as $contact) {
                    $this->processPcMemberInvitation($contact, $conference);
                }
            }
        });

        // Message de succès
        $message = 'Invitations sent successfully!';
        if (isset($validated['contacts1']) && isset($validated['contacts2'])) {
            $message = 'Co-chairs and PC members added successfully!';
        } elseif (isset($validated['contacts1'])) {
            $message = 'Co-chairs added successfully!';
        } elseif (isset($validated['contacts2'])) {
            $message = 'PC members added successfully!';
        }

        Session::put('success', $message);
        return redirect()->route('coChairs', ['acronyme' => $acronyme]);
    }

    private function processChairInvitation($contact, $conference)
    {
        $user = User::firstOrCreate(
            ['email' => $contact['email']],
            [
                'firstName' => $contact['firstName'],
                'lastName' => $contact['lastName']
            ]
        );

        // Créer le chair et le pc member (comme dans votre logique originale)
        $chair = Chair::firstOrCreate(['id' => $user->id]);
        $pcMember = PcMember::firstOrCreate(['id' => $user->id]);

        // Associer comme chair
        UserConference::firstOrCreate(
            [
                'user_id' => $user->id,
                'conference_id' => $conference->id,
                'role' => 'chair'
            ],
            ['statut' => 'accepted']
        );

        // Associer aussi comme pc member (comme dans votre logique originale)
        UserConference::firstOrCreate(
            [
                'user_id' => $user->id,
                'conference_id' => $conference->id,
                'role' => 'pc member'
            ],
            ['statut' => 'accepted']
        );

        Mail::to($user->email)->send(new CoChairInvitationMail($user, $conference));
    }

    private function processPcMemberInvitation($contact, $conference)
    {
        $user = User::firstOrCreate(
            ['email' => $contact['email']],
            [
                'firstName' => $contact['firstName'],
                'lastName' => $contact['lastName']
            ]
        );

        $pcMember = PcMember::firstOrCreate(['id' => $user->id]);

        // Vérifier si une invitation en attente existe déjà
        $existingInvitation = UserConference::where('user_id', $user->id)
            ->where('conference_id', $conference->id)
            ->where('role', 'pc member')
            ->where('statut', 'pending')
            ->first();

        if (!$existingInvitation) {
            $userConference = UserConference::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'conference_id' => $conference->id,
                    'role' => 'pc member'
                ],
                ['statut' => 'pending']
            );

            $token = Str::random(60);
            $userConference->token = $token;
            $userConference->save();

            $invitationLink = route('invitation.form', ['token' => $token]);
            Mail::to($user->email)->send(new PcMemberInvitationMail($user, $conference, $invitationLink));
        }
    }


    /*public function submissions()
    {
        // In a real app, you would fetch user submissions from the database
        return view('submissions');
    }*/
    public function showConfiguration()
    {
        $acronyme = request('acronyme');

        if (!$acronyme) {
            abort(403, 'Missing acronym.');
        }

        // Retrieve the conference associated with the acronym
        $conference = Conference::where('acronyme', $acronyme)->first();

        // If no conference found
        if (!$conference) {
            abort(403, 'Conference not found.');
        }

        // Check if the user is a "chair" for this conference
        $isChair = $conference->userconferences->contains(function ($item) {
            return $item->user_id === Auth::id() && $item->role === 'chair';
        });

        if (!$isChair) {
            abort(403, 'Access denied. You must be a chair to view this page.');
        }


        // Récupérer la configuration de la conférence
        $configuration = $conference->configuration;

        return view('.dashboardUser.chair.configuration', ['configuration' => $configuration]);
    }


    public function updateConfiguration(Request $request, $conferenceId)
    {
        $configuration = Configuration::where('conference_id', $conferenceId)->firstOrFail();
        $configuration->update([
            'numberArticle' => $request->numberArticle,
            'numberReviewer' => $request->numberReviewer,
            'submissionAllowed' => $request->submissionAllowed,
            'submissionUpdateAllowed' => $request->submissionUpdateAllowed,
        ]);

        return back()->with('success', 'Configuration mise à jour avec succès');
    }
    public function formulairePcMembers()
    {
        $acronyme = request('acronyme');
        if (!$acronyme) {
            abort(404);
        }
        $conference = Conference::where('acronyme', $acronyme)->firstOrFail();

        $isChair = $conference->userconferences()
            ->where('role', 'chair')
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isChair) {
            abort(403, 'Access denied. Only chairs can access this page.');
        }
        return view('form.pc-member');
    }


    public function invitationFormulaire(Request $request)
    {

        $token = request('token');

        if (!$token) {
            // Handle missing token appropriately, e.g., redirect to an error page or home
            return redirect()->route('home')->with('error', 'Invitation link is missing a token.');
        }

        // --- IMPORTANT CHANGE HERE ---
        // Store the intended URL in the session ONLY if the user is NOT authenticated.
        // This ensures Laravel redirects them back after they log in.
        if (!Auth::check()) {
            Session::put('url.intended', $request->fullUrl()); // Use $request->fullUrl()
            return redirect()->route('login');
        }
        // --- END IMPORTANT CHANGE ---

        // If the user IS authenticated, proceed with token verification
        $userConference = UserConference::where('token', $token)->first();

        if (!$userConference) {
            // Log out the current user if the token is invalid or not found,
            // as this could indicate a tampered or expired link.
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'The invitation link is invalid or expired. Please try again.');
        }

        // Verify that the authenticated user matches the invitation's user_id
        if ($userConference->user_id != Auth::id()) {
            // Log out the current user if they are not the intended recipient.
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'You are not authorized to view this invitation. Please log in with the correct account.');
        }

        // Check invitation status
        if ($userConference->statut == 'accepted' || $userConference->statut == 'refused') {
            // If already responded, redirect to a status page or dashboard with a message
            return redirect()->route('home')->with('info', 'This invitation has already been responded to.');
        }

        // If all checks pass, display the invitation form
        return view("form.reponse-pc-member", compact('token'));
    }

    public function reponseInvitation(Request $request)
    {
        $token = request('token');

        // Vérifier si le token existe dans la base de données
        $userConference = UserConference::where('token', $token)->first();
        if (!$userConference) {
            // It's better to redirect or show a specific error message here,
            // rather than aborting with 404 for a handled response.
            // For example:
            return redirect()->route('home')->with('error', 'The invitation token is invalid or expired.');
            // Or if you strictly want 404:
            // abort(404);
        }

        // Vérifier que l'utilisateur authentifié correspond à celui de l'invitation
        // IMPORTANT: This check assumes the user is logged in.
        // If the user gets logged out before this check, Auth::id() will be null,
        // and this condition might behave unexpectedly depending on your middleware.
        if ($userConference->user_id != Auth::id()) {
            // Log out the user if they're trying to use someone else's token
            // and redirect to login. This is a security measure.
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'You are not authorized to respond to this invitation.');
            // Or if you strictly want 404:
            // abort(404);
        }

        // Check if the invitation has already been responded to
        if ($userConference->statut == 'accepted' || $userConference->statut == 'refused') {
            return redirect()->route('home')->with('info', 'This invitation has already been responded to.');
        }

        // Mise à jour du statut de l'invitation
        if ($request->has('accept')) {
            $userConference->update(['statut' => 'accepted', 'token' => null]);
        } elseif ($request->has('refuse')) {
            $userConference->update(['statut' => 'refused', 'token' => null]);
        }

        // Rediriger vers une page de confirmation ou d'information
        return redirect()->route('home')->with('success', 'Your response has been recorded.');
    }
    public function showPcMembers()
    {

        // Récupérer l'acronyme
        $acronyme = request('acronyme');

        if ($acronyme) {
            // Récupérer la conférence associée à l'acronyme
            $conference = Conference::where('acronyme', $acronyme)->first();

            if (!$conference) {
                // Si aucune conférence n'est trouvée
                abort(404);
            }
            $pcMembersRaw = UserConference::where('conference_id', $conference->id)
                ->whereIn('role', ['pc member', 'chair'])
                ->with('user') // assuming User relationship is defined
                ->get();

            // Group by user_id and prioritize chair
            $pcMembers = collect();

            $grouped = $pcMembersRaw->groupBy('user_id');

            foreach ($grouped as $userId => $roles) {
                // If chair exists, use that one; otherwise use pc member
                $pcMembers->push(
                    $roles->firstWhere('role', 'chair') ?? $roles->firstWhere('role', 'pc member')
                );
            }
        } else {
            // Si aucun acronyme n'est fourni
            abort(404);
        }

        // user a le droit de voir cette page si il est chair ou co-chair
        $isChair = $conference->userconferences->contains(function ($userConference) {
            return $userConference->user_id === Auth::id() && $userConference->role === 'chair';
        });

        // Si l'utilisateur n'est pas chair, renvoyer une erreur 403 (interdit)
        if (!$isChair) {
            abort(403); // Interdiction d'accès si l'utilisateur n'est pas chair
        }

        //dd($chairs);
        return view('dashboardUser.chair.pc-members', ['pcMembers' => $pcMembers]);
    }

    public function showAllPendingInvitations()
    {
        if (!(Auth::check())) {
            return redirect()->route('login');
        }
        $invitations = UserConference::where('statut', 'pending')->where('user_id', Auth::id()) // Eager load user and conference data
            ->get();
        return view('invitations', ['invitations' => $invitations]);
    }

    public function accept(Request $request, string $token)
    {

        $userConference = UserConference::where('token', $token);
        if (!$userConference) {
            abort(404);
        }
        // Ensure the logged-in user is the one invited (optional, but recommended)
        if (Auth::id() !== $userConference->first()->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $userConference->update(['statut' => 'accepted', 'token' => null]); // Update status and clear token

        return redirect()->back()->with('success', 'Invitation accepted!');
    }

    public function reject(Request $request, string $token)
    {

        $userConference = UserConference::where('token', $token)->get();
        if (!$userConference) {
            abort(404);
        }
        // Ensure the logged-in user is the one invited (optional, but recommended)
        if (Auth::id() !== $userConference->first()->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $userConference->update(['statut' => 'refused', 'token' => null]); // Update status and clear token

        return redirect()->back()->with('warning', 'Invitation rejected.');
    }
}
