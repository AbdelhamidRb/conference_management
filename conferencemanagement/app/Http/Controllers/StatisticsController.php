<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $acronyme = request('acronyme');

        if (!$acronyme) {
            abort(404);
        }

        $conference = Conference::where('acronyme', $acronyme)->firstOrFail();

        $user = Auth::user();

        $isChair = $conference->userconferences
            ->where('user_id', $user?->id)
            ->where('role', 'chair')
            ->isNotEmpty();

        if (!$isChair) {
            abort(404);
        }

        $conferenceId = $conference->id;

        // Nombre de retraits de papier
        $nombreRetraits = DB::table('submissions')
            ->where('conference_id', $conferenceId)
            ->where('statut', 'withdrawn')
            ->count();

        // Moyenne de reviews par papier
        $moyenneReviews = DB::table(DB::raw('(
            SELECT s.idSubmission, COUNT(DISTINCT CASE WHEN ev.id IS NOT NULL THEN e.id END) AS nb_evaluations_reelles
            FROM submissions s
            LEFT JOIN evaluations e ON e.submission_id = s.idSubmission
            LEFT JOIN evaluation_versions ev ON ev.evaluation_id = e.id
            WHERE s.conference_id = ' . $conferenceId . '
            GROUP BY s.idSubmission
        ) AS subquery'))
            ->select(DB::raw('ROUND(SUM(nb_evaluations_reelles) * 1.0 / COUNT(*), 2) AS moyenne_evaluations_par_article'))
            ->first();

        // Nombre de reviews reçues
        $totalReviews = DB::table('submissions as s')
            ->join('evaluations as e', 'e.submission_id', '=', 's.idSubmission')
            ->join('evaluation_versions as ev', 'ev.evaluation_id', '=', 'e.id')
            ->where('s.conference_id', $conferenceId)
            ->select(DB::raw('COUNT(DISTINCT e.id) AS total_reviews'))
            ->first();

        // Nombre des PC
        $nombrePC = DB::table('user_conferences')
            ->where('role', 'pc member')
            ->where('conference_id', $conferenceId)
            ->count();

        // Taux d'acceptation
        $acceptanceRate = DB::table('submissions')
            ->where('conference_id', $conferenceId)
            ->select(DB::raw("(SUM(CASE WHEN statut = 'accepted' THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) AS acceptance_rate"))
            ->first();

        // Taux de rejet
        $rejectionRate = DB::table('submissions')
            ->where('conference_id', $conferenceId)
            ->select(DB::raw("(SUM(CASE WHEN statut = 'rejected' THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) AS rejection_rate"))
            ->first();

        // Nombre total d'articles
        $totalArticles = DB::table('submissions')
            ->where('conference_id', $conferenceId)
            ->count();

        // Nombre d'articles acceptés
        $totalArticlesAccepted = DB::table('submissions')
            ->where('conference_id', $conferenceId)
            ->where('statut', 'accepted')
            ->count();

        // Nombre d'articles rejetés
        $totalArticlesRejected = DB::table('submissions')
            ->where('conference_id', $conferenceId)
            ->where('statut', 'rejected')
            ->count();

        // Nombre d'articles retirés
        $totalArticlesWithdrawn = DB::table('submissions')
            ->where('conference_id', $conferenceId)
            ->where('statut', 'withdrawn')
            ->count();

        return view('dashboardStatistic', compact(
            'nombreRetraits',
            'moyenneReviews',
            'totalReviews',
            'nombrePC',
            'acceptanceRate',
            'rejectionRate',
            'totalArticles',
            'totalArticlesAccepted',
            'totalArticlesRejected',
            'totalArticlesWithdrawn'
        ));
    }
}
