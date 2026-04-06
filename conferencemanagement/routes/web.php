<?php

use App\Models\Evaluation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AttributionController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StatisticsController;

// Landing page for connecte/nonConnecte Users

Route::get('/', [ConferenceController::class, 'index'])->name('home');

Route::post('/logout', [SessionController::class, 'destroy']);

// Authentication routes
Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store']);
Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');


// Conference routes
Route::get('/register', [ConferenceController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::get('/email/verify', [AuthController::class, 'verify1'])->name('verification.notice');
Route::get('/verify-email/{token}', [AuthController::class, 'verify'])->name('verification.verify');
// Renvoi de l'email de vérification
Route::post('/email/resend', [AuthController::class, 'resend'])
    ->name('verification.resend');
Route::get('/email/resend', [AuthController::class, 'resend'])
    ->name('verification.resend');




Route::get('/services', [ConferenceController::class, 'showServices']);
Route::get('/about', [ConferenceController::class, 'showAbout']);

/*Route::get('/speakers', [ConferenceController::class, 'speakers'])->name('speakers');
Route::get('/schedule', [ConferenceController::class, 'schedule'])->name('schedule');
Route::get('/features', [ConferenceController::class, 'features'])->name('features');
*/








// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {

    Route::post('/creerConference', [ConferenceController::class, 'confirmationCreateConference']);
    Route::get('/createConference', [ConferenceController::class, 'step1'])->name('conference.step1');
    Route::post('/create-conference/step1', [ConferenceController::class, 'postStep1']);

    Route::get('/create-conference/step2', [ConferenceController::class, 'step2'])->name('conference.step2');
    Route::post('/create-conference/step2', [ConferenceController::class, 'postStep2']);

    Route::get('/create-conference/step3', [ConferenceController::class, 'step3'])->name('conference.step3');
    Route::post('/create-conference/step3', [ConferenceController::class, 'postStep3']);


    Route::get('/myRoles', [RoleController::class, 'myRoles']);

    //invitation depuis l'application
    Route::get('/all-pending-invitations', [ConferenceController::class, 'showAllPendingInvitations'])->name('all.pending.invitations');
    Route::post('/invitations/accept/{token}', [ConferenceController::class, 'accept'])->name('invitation.accept');
    Route::post('/invitations/reject/{token}', [ConferenceController::class, 'reject'])->name('invitation.reject');
    //Route::get('/dashboard', [ConferenceController::class, 'dashboard']);
    //Route::get('/profile', [ConferenceController::class, 'profile'])->name('profile');
    //Route::get('/submissions', [ConferenceController::class, 'submissions'])->name('submissions');

    //submission routes
    Route::get('/submission1', [SubmissionController::class, 'create']);
    Route::post('/store1', [SubmissionController::class, 'store1'])->name('store1');

    Route::get('/submission2', [SubmissionController::class, 'create2'])->name('submission2');
    Route::post('/store2', [SubmissionController::class, 'store2'])->name('store2');
    Route::get('/submission/result', function () {
        return view('submissionresult');
    })->name('submission.result');
    Route::get('/submissionEdit/{Submission}', [SubmissionController::class, 'edit']);
    Route::put('/submissionEdit/{Submission}', [SubmissionController::class, 'update'])
        ->name('submissions.update');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])
        ->name('submissions.destroy');
    //details for a specific submission 
    Route::get('/submission/{idSubmission}/details', [SubmissionController::class, 'showDetails'])->name('submissions.details');



    //configuration conference
    Route::get('/configuration', [ConferenceController::class, 'showConfiguration']);
    //modifier configuration
    Route::put('/configurations/{conference}', [ConferenceController::class, 'updateConfiguration'])->name('configurations.update');


    //chair
    Route::get('/conferenceDetails', [ConferenceController::class, 'showConferenceDetails']);
    Route::get('/userDashboard', [RoleController::class, 'dashboardRole'])->name('userDashboard');
    Route::get('/coChairs', [ConferenceController::class, 'formulaireCoChairs'])->name('coChairs');
    Route::post('/coChairsInvitation', [ConferenceController::class, 'handleInvitations'])->name('coChairsPcMembersInvitation');
    Route::get('/evaluation', [EvaluationController::class, 'evaluationChair']);
    Route::get('/finalDecision', [EvaluationController::class, 'finalDecision']);
    Route::post('/finalDecision/{id}/accept', [EvaluationController::class, 'accept'])->name('finalDecision.accept');
    Route::post('/finalDecision/{id}/reject', [EvaluationController::class, 'reject'])->name('finalDecision.reject');
    Route::post('/finalDecision/{id}/borderline', [EvaluationController::class, 'borderline'])->name('finalDecision.borderline');
    Route::get('/review-form', [EvaluationController::class, 'showReviewForm'])->name('review.form');
    Route::get('/evaluation/details/{pc_member_id}/{submission_id}', [EvaluationController::class, 'details'])->name('evaluation.details');
     //pending notifications vue 
    Route::get('/conferences/{acronyme}/pending-notifications', [AttributionController::class, 'index'])
    ->name('chair.pendingNotifications');
      // Handle sending notifications
    Route::post('/conferences/{acronyme}/send-notifications', 
        [AttributionController::class, 'sendNotifications'])
        ->name('notifications.send');
//send decisions
    Route::get('/conferences/{acronyme}/send-decisions', [EvaluationController::class, 'showDecisionForm'])->name('chair.decisions.form');
    Route::post('/conferences/send-decisions', [EvaluationController::class, 'sendDecisions'])->name('chair.send-decisions');
//iframe routes
    Route::get('/chair/email-form/{acronyme}/{mode}', [EvaluationController::class, 'showComposeIframe'])
     ->name('chair.email-form');
//send info 
     Route::get('/conferences/{acronyme}/send-info', [EvaluationController::class, 'showInfoForm'])->name('chair.info.form');
     Route::post('/conferences/send-info', [EvaluationController::class, 'sendInfo'])->name('chair.send-info');
     
//********************************************************************************************* 

    //assin pc memebers to articles 
    Route::get('/pc-members-assignments', [AttributionController::class, 'showPcMembers']);
    Route::get('/pcmembers/{pcMemberId}/articles/{acronyme}', [AttributionController::class, 'afficherFormulaireArticles'])
        ->name('pcmembers.articles');
    Route::post('/pcmembers/{pcMemberId}/articles', [AttributionController::class, 'storeArticles'])
        ->name('pcmembers.articles.store');

    //to visualize all of assignements 
    Route::get('/conferences/{acronyme}/assignments', [AttributionController::class, 'showAssignments'])
        ->name('assignments.index');

    //To see history of downloads
    Route::get('/submissions/{submission}/history', [SubmissionController::class, 'viewHistory'])->name('submissions.history');

    // invitation depuis e-mail
    Route::get('/addPcMember', [ConferenceController::class, 'formulairePcMembers'])->name('addPcMember');
    Route::post('/pcMembersInvitation', [ConferenceController::class, 'pcMembersInvitation'])->name('pcMembersInvitation');
    Route::get('/conference/PcMembersInvitation/{token}', [ConferenceController::class, 'invitationFormulaire'])->name('invitation.form');
    Route::post('/invitation/response', [ConferenceController::class, 'reponseInvitation']);
    Route::get('/pcMembers', [ConferenceController::class, 'showPcMembers'])->name('pcMembers.list');
    Route::get('/userInformation', [AuthController::class, 'showUser']);

    //attribution
    Route::get('/Attribution', [AttributionController::class, 'showArticles']);
    Route::get('/articles/{article}/pcmembres', [AttributionController::class, 'afficherFormulairePcmembres'])->name("afficher.pcmembres");
    Route::post('/attribution/{article}', [AttributionController::class, 'store'])->name('attribution.store');

    //evaluation 
    Route::get('/evaluations/form/{submission_id}/{pc_member_id}', [EvaluationController::class, 'form'])->name('evaluations.form');
    Route::post('/evaluations/save/{submission_id}/{pc_member_id}', [EvaluationController::class, 'save'])->name('evaluations.save');

    Route::get('/reviews/{acronyme}', [EvaluationController::class, 'myReviews'])->name('MyReviews');
    // Show the update form (avec acronyme dans l'URL)
    Route::get('/{acronyme}/evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])
        ->name('evaluations.edit');


    // Handle update (avec acronyme dans l'URL)
    Route::put('/{acronyme}/evaluations/{evaluation}', [EvaluationController::class, 'update'])
        ->name('evaluations.update');



    //statistiques
    Route::get('/statistics', [StatisticsController::class, 'index']);
});
