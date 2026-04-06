<?php

namespace App\Http\Controllers;

use App\Models\PcMember;
use App\Models\Conference;
use App\Models\Evaluation;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticleAssignmentEmail;

class AttributionController extends Controller
{
    public function showArticles()
    {

        // 1. Vérifier si l'acronyme est présent
        if (!request('acronyme')) {
            abort(403);
        }

        // 2. Récupérer la conférence selon son acronyme
        $conference = Conference::where('acronyme', request('acronyme'))->firstOrFail();

        // verifier l'authorisation
        $isChair = $conference->userconferences->contains(function ($userConference) {
            return $userConference->user_id === Auth::id() && $userConference->role === 'chair';
        });

        // Si l'utilisateur n'est pas chair, renvoyer une erreur 403 (interdit)
        if (!$isChair) {
            abort(403); // Interdiction d'accès si l'utilisateur n'est pas chair
        }

        // 3. Récupérer la configuration liée à cette conférence
        $configuration = Configuration::where('conference_id', $conference->id)->firstOrFail();

        // 4. Récupérer les soumissions de cette conférence
        //    qui ont moins de "numberReviewer" évaluations
        $articles = Submission::with('latestPdf')
            ->where('statut', 'pending')
            ->withCount('evaluations')
            ->where('conference_id', $conference->id)
            ->having('evaluations_count', '<', $configuration->numberReviewer)
            ->get();


        return view('dashboardUser.chair.attribution', compact('articles'));
    }
    public function afficherFormulairePcmembres($articleId)
    {
        $article = Submission::findOrFail($articleId);
        $conference = $article->conference;

        // Verify the user is chair for this conference
        $isChair = $conference->userconferences->contains(function ($item) {
            return $item->user_id === Auth::id() && $item->role === 'chair';
        });

        if (!$isChair) {
            abort(403, 'Access denied. You must be chair to view this page.');
        }

        $maxArticles = $conference->configuration->numberArticle;

        // Get PC members for this conference who:
        // 1. Are assigned to this conference
        // 2. Haven't evaluated this specific article yet
        // 3. Haven't reached their max article limit
        $pcmembres = PcMember::whereHas('user.userConferences', function ($query) use ($conference) {
            $query->where('conference_id', $conference->id);
            $query->where('statut', 'accepted');
        })
            ->whereDoesntHave('evaluations', function ($query) use ($articleId) {
                $query->where('submission_id', $articleId);
            })
            ->withCount('evaluations')
            ->having('evaluations_count', '<', $maxArticles)
            ->with('user')
            ->get();

        return view('dashboardUser.chair.pcmembers', compact('article', 'pcmembres'));
    }


    public function store(Request $request, $articleId)
    {
        $request->validate([
            'pcs' => 'required|array',
            'pcs.*' => 'exists:pcmembers,id',
        ]);

        $article = Submission::findOrFail($articleId);

        $conference = $article->conference;
        $config = $conference->configuration;

        // Nombre d’évaluateurs déjà assignés
        $currentCount = Evaluation::where('submission_id', $articleId)->count();

        $pcIds = $request->pcs;

        // Vérification du nombre maximal d’évaluateurs
        if (($currentCount + count($pcIds)) > $config->numberReviewer) {
            return back()->with('error', "You have exceeded the allowed number of reviewers, which is $config->numberReviewer.");
        }

        // On assigne chaque reviewer
        foreach ($pcIds as $pcId) {
            // Création de l’évaluation
            $evaluation = Evaluation::create([
                'submission_id' => $articleId,
                'pc_member_id' => $pcId,
                'emailCheck' => false,
            ]);
        }

        return redirect()->back()->with('success', 'The reviewers have been successfully assigned.');
    }

    //test of pc members 
    public function showPcMembers()
    {
        if (!request('acronyme')) {
            abort(403);
        }

        $conference = Conference::where('acronyme', request('acronyme'))->firstOrFail();
        // Vérifier si l'utilisateur est "chair" pour cette conférence
        $isChair = $conference->userconferences->contains(function ($item) {
            return $item->user_id === Auth::id() && $item->role === 'chair';
        });

        if (!$isChair) {
            abort(403, 'Accès refusé. Vous devez être chair pour voir cette page.');
        }
        $maxArticles = $conference->configuration->numberArticle;

        $pcMembers = PcMember::whereHas('user.userConferences', function ($query) use ($conference) {
            $query->where('conference_id', $conference->id);
            $query->where('statut', 'accepted');
        })
            ->withCount('evaluations')
            ->having('evaluations_count', '<', $maxArticles)
            ->with('user')
            ->get();
        return view('dashboardUser.chair.pcmembers-list', compact('pcMembers'));
    }

    public function afficherFormulaireArticles($pcMemberId)
    {
        $pcMember = PcMember::with('user')->findOrFail($pcMemberId);


        $conference = Conference::where('acronyme', request('acronyme'))->firstOrFail();

        $maxReviewers = $conference->configuration->numberReviewer;

        $articles = Submission::where('conference_id', $conference->id)
            ->whereNotIn('idSubmission', function ($query) use ($pcMemberId) {
                $query->select('submission_id')
                    ->from('evaluations')
                    ->where('pc_member_id', $pcMemberId);
            })
            ->where('statut', 'pending')
            ->withCount('evaluations')
            ->having('evaluations_count', '<', $maxReviewers)
            ->with('latestPdf')
            ->get();


        return view('dashboardUser.chair.articles-assign', compact('pcMember', 'articles', 'conference'));
    }

    public function storeArticles(Request $request, $pcMemberId)
    {
        $request->validate([
            'articles' => 'required|array',
            'articles.*' => 'exists:submissions,idSubmission',
        ]);

        $pcMember = PcMember::findOrFail($pcMemberId);
        $conference = Conference::where('acronyme', request('acronyme'))->firstOrFail();
        $maxArticles = $conference->configuration->numberArticle;

        $currentCount = $pcMember->evaluations()->count();
        if (($currentCount + count($request->articles)) > $maxArticles) {
            return back()->with('error', "This PC member cannot evaluate more than $maxArticles articles.");
        }

        foreach ($request->articles as $articleId) {
            Evaluation::create([
                'submission_id' => $articleId,
                'pc_member_id' => $pcMemberId,
                'emailCheck' => false,
            ]);
        }

        return back()->with('success', 'Articles successfully assigned to PC member.');
    }
    //show all of assignements 
    public function showAssignments()
    {

        $acronyme = request('acronyme');

        $conference = Conference::where('acronyme', $acronyme)->firstOrFail();

        //authorization
        $isChair = $conference->userconferences->contains(function ($userConference) {
            return $userConference->user_id === Auth::id() && $userConference->role === 'chair';
        });

        // Si l'utilisateur n'est pas chair, renvoyer une erreur 403 (interdit)
        if (!$isChair) {
            abort(403); // Interdiction d'accès si l'utilisateur n'est pas chair
        }

        $assignments = Submission::with([
            'latestPdf',
            'evaluations.pcMember.user' // Load PC members with their user data
        ])
            ->where('conference_id', $conference->id)
            ->whereHas('evaluations') // Only show articles with assignments
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboardUser.chair.assignments', compact('assignments'));
    }
    
    //to send pending attribution to the view 
    public function index($acronyme)
{
    $conference = Conference::where('acronyme', $acronyme)->firstOrFail();
            //authorization
        $isChair = $conference->userconferences->contains(function ($userConference) {
            return $userConference->user_id === Auth::id() && $userConference->role === 'chair';
        });

        // Si l'utilisateur n'est pas chair, renvoyer une erreur 403 (interdit)
        if (!$isChair) {
            abort(403); // Interdiction d'accès si l'utilisateur n'est pas chair
        }

    $pendingAssignments = Evaluation::with([
            'pcMember.user', 
            'submission' => fn($q) => $q->select('idSubmission', 'titre', 'created_at')
        ])
        ->whereHas('submission', fn($q) => $q->where('conference_id', $conference->id))
        ->where('emailCheck', false)
        ->get()
        ->groupBy('pc_member_id');

    return view('dashboardUser.chair.pending-notifications', compact('pendingAssignments', 'conference'));
}

public function sendNotifications(Request $request, $acronyme)
{
    
    $request->validate([
        'pc_members' => 'required|json',
        'subject' => 'required|string|max:255',
        'message' => 'required|string'
    ]);

    $conference = Conference::where('acronyme', $acronyme)->firstOrFail();
    $pcMemberIds = json_decode($request->pc_members);

    foreach ($pcMemberIds as $pcMemberId) {
        // Get all pending evaluations for this PC member
        $evaluations = Evaluation::with([
         'pcMember.user',
         'submission.primaryAuthor.user', // Load the primary author and their user details
         'submission.secondaryAuthors.user' // Load the secondary authors and their user details
])
            ->where('pc_member_id', $pcMemberId)
            ->where('emailCheck', false)
            ->whereHas('submission', function($q) use ($conference) {
                $q->where('conference_id', $conference->id);
            })
            ->get();

        if ($evaluations->isEmpty()) {
            continue;
        }

        // Update emailCheck status
        Evaluation::whereIn('id', $evaluations->pluck('id'))
            ->update(['emailCheck' => true]);

        // Prepare article list
        $articleList = $evaluations->map(function($evaluation) {
            $authors = collect([$evaluation->submission->primaryAuthor->user])
                ->merge($evaluation->submission->secondaryAuthors->pluck('user'))
                ->map(fn($user) => $user->firstName . ' ' . $user->lastName)
                ->join(', ');
            
            return "- " . $evaluation->submission->titre . " (Authors: " . $authors . ")";
        })->join("\n");

        // Personalize the message
        $pcMember = $evaluations->first()->pcMember;
        $personalizedMessage = str_replace(
            ['[PC Member Name]', '[Article List]'],
            [$pcMember->user->firstName, $articleList],
            $request->message
        );

        // Send email
        Mail::to($pcMember->user->email)->send(new ArticleAssignmentEmail(
            $request->subject,
            $personalizedMessage,
            $conference
        ));
    }

    return response()->json(['success' => true]);
}
}
