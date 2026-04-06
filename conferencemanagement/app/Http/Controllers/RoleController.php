<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\UserConference;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SubmissionController;

class RoleController extends Controller
{
    public function myRoles()
    {
        if (!(Auth::check())) {
            return redirect()->route('login');
        }
        $data = Auth::user()->userConferences
            ->where('statut', 'accepted')
            ->groupBy(fn($userConference) => $userConference->conference->acronyme);
        return view('MyRoles', ['data' => $data]);
    }
    public function dashboardRole()
    {
        $acronyme = request('acronyme');
        $role = request('role');
        if (!$acronyme || !$role) {
            abort(404);
        }

        // exécuter la requête avec first()
        $conference = Conference::where('acronyme', $acronyme)->first();

        if (!$conference) {
            abort(404); // acronyme inexistant
        }

        // vérifier si l'utilisateur a accès
        $userConference = UserConference::where('conference_id', $conference->id)
            ->where('user_id', Auth::id())
            ->where('role', $role)
            ->first(); // ici aussi, on exécute la requête
        // dd($userConference->conference);

        if (!$userConference) {
            abort(404); // pas d'accès
        } else {
            switch ($role) {
                case 'auteur':
                    $data = SubmissionController::index(request('acronyme'));

                    // authorisation
                    $isAuthorPr = $data['submissions']->contains(function ($item) {
                        return $item->auteur_id === Auth::id();
                    });

                    if (!$isAuthorPr) {
                        abort(403, 'Access denied. You must be an Author to view this page.');
                    }

                    return view('dashboardUser.auteur.submissionsAuteurs', [
                        'conference' => $data['conference'],
                        'submissions' => $data['submissions']
                    ]);

                case 'chair':
                    $submissions = Submission::with('latestPdf')
                        ->where('conference_id', $conference->id)
                        ->get();
                    return view('dashboardUser.chair.submissionsConference', ['submissions' => $submissions]);
                case 'pc member':
                    $evaluations = EvaluationController::showEvaluationsToDo($conference);
                    return view('dashboardUser.pcMember.articles', compact('evaluations'));
                default:
                    abort(404);
            }
        }
    }
}
