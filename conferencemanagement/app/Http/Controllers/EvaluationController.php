<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Evaluation;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\EvaluationVersion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DecisionNotification;

class EvaluationController extends Controller
{
    public static function showEvaluationsToDo($conference)
    {
        $pcMemberId = Auth::id();

        return Evaluation::where('pc_member_id', $pcMemberId)
            ->where('emailCheck', true)
            ->whereHas('submission', function ($query) use ($conference) {
                $query->where('conference_id', $conference->id);
            })
            ->whereDoesntHave('versions') // Only evaluations with NO versions
            ->with('submission') // Eager load submission data
            ->get();
    }


    public function form($submission_id, $pc_member_id)
    {
        $evaluation = Evaluation::where('submission_id', $submission_id)
            ->where('pc_member_id', $pc_member_id)
            ->firstOrFail();

        return view('dashboardUser.pcMember.evaluation', compact('evaluation'));
    }
    public function save(Request $request, $submission_id, $pc_member_id)
    {
        $evaluation = Evaluation::where('submission_id', $submission_id)
            ->where('pc_member_id', $pc_member_id)
            ->firstOrFail();

        $evaluationVersion = EvaluationVersion::create([
            'evaluation_id' => $evaluation->id,
            'remarque' => $request->remark,
            'decision' => $request->decision,
            'commentaire_confidentiel' => $request->comentaire_confedentiel
        ]);
        return redirect()->back()->with('success', 'The evaluation was successfully saved.');
    }
    public function evaluationChair()
    {

        if (!request('acronyme')) {
            abort(403);
        }

        // Use first() instead of get() to get a single conference
        $conference = Conference::where('acronyme', request('acronyme'))->first();

        if (!$conference) {
            abort(403);
        }

        // user a le droit de voir cette page si il est pc member
        $isPcMember = $conference->userconferences->contains(function ($userConference) {
            return $userConference->user_id === Auth::id() && $userConference->role === 'pc member';
        });

        // Si l'utilisateur n'est pas chair, renvoyer une erreur 403 (interdit)
        if (!$isPcMember) {
            abort(403); // Interdiction d'accès si l'utilisateur n'est pas chair
        }


        $evaluations = EvaluationController::showEvaluationsToDo($conference);
        return view('dashboardUser.chair.articles', compact('evaluations'));
    }
    public function finalDecision()
    {
        if (!request('acronyme')) {
            dd(403);
        }

        $conference = Conference::where('acronyme', request('acronyme'))->first();

        //authorization
        // user a le droit de voir cette page si il est chair ou co-chair
        $isChair = $conference->userconferences->contains(function ($userConference) {
            return $userConference->user_id === Auth::id() && $userConference->role === 'chair';
        });

        // Si l'utilisateur n'est pas chair, renvoyer une erreur 403 (interdit)
        if (!$isChair) {
            abort(403); // Interdiction d'accès si l'utilisateur n'est pas chair
        }

        $submissions = Submission::where('statut', 'pending')
            ->where('conference_id', $conference->id)
            ->whereHas('evaluations', function ($query) {
                $query->where('emailCheck', true)
                    ->whereHas('versions'); // Must have at least one version
            })
            ->with([
                'evaluations' => function ($query) {
                    $query->where('emailCheck', true)
                        ->whereHas('versions') // Ensure only evaluations with versions are loaded
                        ->with('latestVersion');
                },
                'latestPdf'
            ])
            ->get();


        return view('dashboardUser.chair.finalDecision', compact('submissions'));
    }

    public function accept()
    {
        if (!request('id')) {
            abort(403);
        }

        $submission = Submission::where('idSubmission', request('id'))->first();

        if (!$submission) {
            abort(404);
        }

        $submission->statut = 'accepted';
        $submission->save();

        return back()->with('success', 'Decison successfully added.');
    }

    public function reject()
    {
        if (!request('id')) {
            abort(403);
        }

        $submission = Submission::where('idSubmission', request('id'))->first();

        if (!$submission) {
            abort(404);
        }

        $submission->statut = 'rejected';
        $submission->save();

        return back()->with('success', 'Decison successfully added.');
    }
    // handling borderline decisions 
    public function borderline()
    {
        if (!request('id')) {
            abort(403);
        }

        $submission = Submission::where('idSubmission', request('id'))->first();

        if (!$submission) {
            abort(404);
        }

        $submission->statut = 'borderline';
        $submission->save();

        return back()->with('success', 'Decison successfully added.');
    }

    public function details()
    {

        $pc_member_id = request('pc_member_id');
        $submission_id = request('submission_id');

        $conference = Submission::where('idSubmission', $submission_id)->first()->conference;
        if (!$conference) {
            abort(404);
        }
        if (!$pc_member_id || !$submission_id) {
            abort(403);
        }
        //authorization
        // user a le droit de voir cette page si il est chair ou co-chair
        $isChair = $conference->userconferences->contains(function ($userConference) {
            return $userConference->user_id === Auth::id() && $userConference->role === 'chair';
        });

        // Si l'utilisateur n'est pas chair, renvoyer une erreur 403 (interdit)
        if (!$isChair) {
            abort(403); // Interdiction d'accès si l'utilisateur n'est pas chair
        }

        $evaluation = Evaluation::where('pc_member_id', $pc_member_id)
            ->where('submission_id', $submission_id)->first();
        return view('dashboardUser.chair.evaluationDetails', compact('evaluation'));
    }
    public function myReviews()
    {
        $pcMemberId = Auth::id();

        $conferenceId = Conference::where('acronyme', request()->acronyme)->value('id');

        $reviews = Evaluation::where('pc_member_id', $pcMemberId)
            ->whereHas('submission', function ($query) use ($conferenceId) {
                $query->where('conference_id', $conferenceId);
            })
            ->with(['latestVersion', 'submission']) // Charge la dernière version et la soumission liée
            ->get()
            ->filter(function ($evaluation) {
                return $evaluation->latestVersion !== null
                    && $evaluation->latestVersion->remarque !== null
                    && $evaluation->latestVersion->decision !== null;
            });

        return view('dashboardUser.pcMember.myReviews', compact('reviews'));
    }

    public function edit(string $acronyme, Evaluation $evaluation)
    {
        $version = $evaluation->latestVersion;
        $acronyme = request('acronyme');
        return view('dashboardUser.pcMember.evaluationEdit', compact('evaluation', 'version', 'acronyme'));
    }


    public function update(string $acronyme, Evaluation $evaluation, Request $request)
    {
        $request->validate([
            'remarque' => 'nullable|string|max:255',
            'decision' => 'nullable|string|max:255',
            'commentaire_confidentiel' => 'nullable|string|max:255'
        ]);

        // Create a new version (versioning logic)
        $evaluation->versions()->create([
            'remarque' => $request->remarque,
            'decision' => $request->decision,
            'commentaire_confidentiel' => $request->comentaire_confedentiel
        ]);

        return redirect()->back()->with('success', 'Evaluation updated successfully.');
    }


    //add review handline for co chair 
    public function showReviewForm(Request $request)
    {
        $submissionId = $request->input('submission_id');
        $userId = $request->input('user_id');

        // Find or create the evaluation record
        $evaluation = Evaluation::firstOrCreate([
            'pc_member_id' => $userId,
            'submission_id' => $submissionId
        ]);

        return view('dashboardUser.pcMember.evaluation', compact('evaluation'));
    }


    
public function showDecisionForm($acronyme)
{
    
    $conference = Conference::where('acronyme', $acronyme)->firstOrFail();
    $submissions = Submission::with('primaryAuthor')
        ->where('conference_id', $conference->id)
        ->whereIn('statut', ['Accepted', 'Rejected', 'Borderline'])
        ->where('notified', false)
        ->get();

    return view('dashboardUser.chair.sendDecisions', [
        'conference' => $conference,
        'submissions' => $submissions,
        'mode' => 'decision',
        'sendRoute' => route('chair.send-decisions')
    ]);
}
//iframe
  public function showComposeIframe(Request $request, $acronyme, $mode)
{
    $ids = explode(',', $request->query('submissions', ''));
    
        $sendRoute = $mode === 'decision'
        ? route('chair.send-decisions')
        : route('chair.send-info');
    $submissions = Submission::with(['primaryAuthor', 'Evaluations'])
        ->whereIn('idSubmission', $ids)
        ->get();
       

    return view('dashboardUser.chair.emailDecision_form', [
        'submissions' => $submissions,
        'mode' => $mode,
        'sendRoute'=> $sendRoute
    ]);
}

public function sendDecisions(Request $request)
{
    $validated = $request->validate([
        'submissions' => 'required|array',
        'submissions.*' => 'exists:submissions,idSubmission',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $submissions = Submission::with(['primaryAuthor', 'evaluations'])
        ->whereIn('idSubmission', $validated['submissions'])
        ->get();

    foreach ($submissions as $submission) {
        $remarks = $submission->Evaluations->map(function ($evaluation) {
    return optional($evaluation->latestVersion)->remarque;
})->filter()->all();

        $customizedBody = str_replace(
            ['[Author Name]', '[Paper Title]', '[Decision]', '[Reviewers Remarks]'],
            [
                $submission->primaryAuthor->user->firstName . ' ' . $submission->primaryAuthor->user->lastName,
                $submission->titre,
                $submission->statut,
                $this->formatRemarks($remarks)
            ],
            $validated['message']
        );

        Mail::to($submission->primaryAuthor->user->email)
            ->send(new DecisionNotification($validated['subject'], $customizedBody, $submission->conference));

         $submission->update(['notified' => true]);
    }
    

    return redirect()->back()->with('success', 'Decision notifications sent successfully!');
}

public function showInfoForm($acronyme)
{
     $conference = Conference::where('acronyme', $acronyme)->firstOrFail();
    $submissions = Submission::with('primaryAuthor')
        ->where('conference_id', $conference->id)
        ->whereIn('statut', ['Accepted', 'Rejected', 'Borderline'])
        ->get();

    return view('dashboardUser.chair.sendDecisions', [
        'conference' => $conference,
        'submissions' => $submissions,
        'mode' => 'info',
        'sendRoute' => route('chair.send-info')
    ]);
}


public function sendInfo(Request $request)
{
    $validated = $request->validate([
        'submissions' => 'required|array',
        'submissions.*' => 'exists:submissions,idSubmission',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $submissions = Submission::with(['primaryAuthor'])
        ->whereIn('idSubmission', $validated['submissions'])
        ->get();

    foreach ($submissions as $submission) {
        

        $customizedBody = str_replace(
            ['[Author Name]', '[Paper Title]'],
            [
                $submission->primaryAuthor->user->firstName . ' ' . $submission->primaryAuthor->user->lastName,
                $submission->titre,
              
            ],
            $validated['message']
        );

        Mail::to($submission->primaryAuthor->user->email)
            ->send(new DecisionNotification($validated['subject'], $customizedBody, $submission->conference));

        
    }

    return redirect()->back()->with('success', 'Informational emails sent successfully!');
}

protected function formatRemarks(array $remarks): string
{
    $formatted = '';

    foreach ($remarks as $index => $remark) {
        $number = $index + 1;
        $formatted .= "Review {$number}: {$remark}\n";
    }

    return trim($formatted);
}
}
