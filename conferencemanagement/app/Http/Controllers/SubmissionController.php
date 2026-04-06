<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Auteur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Mail\SubmissionConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Models\Submission;
use App\Models\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubmissionController extends Controller

{
    use AuthorizesRequests;
    // we return the first part of the submission 
    public function create()
    {
        $acronyme = request()->query('acronyme');
        $conference = Conference::where('acronyme', $acronyme)->firstOrFail();

        return view('form.submission1', ['conference' => $conference]);
    }
    // validate and then re sent them to the next part
    public function store1(Request $request)
    {

        // Validate the inputs
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'paper_file' => 'required|file|mimes:pdf|max:20480', // 20MB max
        ]);
        // Store data in session
        session([
            'submission' => [
                'title' => $validatedData['title'],
                'abstract' => $validatedData['abstract'],
                'keywords' => $validatedData['keywords'],

            ]
        ]);
        session([
            "conference" => $request->conference,
        ]);

        // Check if there's already a file stored in session
        $previousFilePath = session('submission.file_path');

        if ($previousFilePath) {
            // If there is a previous file, delete it
            Storage::delete($previousFilePath);
        }
        // Store uploaded file temporarily
        $path = $request->file('paper_file')->store('temp', 'public');
        session()->put('submission.file_path', $path);

        // Redirect to the second form
        return redirect()->route('submission2');
    }
    public function create2()
    {
        if (!session()->has('submission') || !session()->has('conference')) {
            // Redirect the user away, maybe back to the start or a dashboard.
            // You could also flash a message explaining why they were redirected.
            return redirect()->route('RecentRoles');
            // Or redirect to a user dashboard if applicable:
            // return redirect()->route('user.dashboard')->with('info', 'Your submission was completed.');
        }
        return view('form.submission2'); // the view you posted above} 
    }
    //FUNCTION TO GENERATE A COSTUM UNIQUE ID 
    public function generateSubmissionId($conference): string
    {
        $acronym = strtoupper($conference->acronyme);

        do {
            $randomNumber = rand(1000, 15000);
            $idSubmission = $randomNumber;
        } while (Submission::where('idSubmission', $idSubmission)->exists());

        return $idSubmission;
    }



    // TO HANDLE SECOND PART OF THE FORM AND INSERT EVERYTHING
    public function store2(Request $request)
    {
        try {
            // Validate the second part of the form
            $validatedData = $request->validate([
                'authors' => 'required|array|min:1',
                'authors.*.first_name' => 'required|string|max:255',
                'authors.*.last_name' => 'required|string|max:255',
                'authors.*.email' => 'required|email|max:255',
                'authors.*.affiliation' => 'required|string|max:255',
                'authors.*.is_corresponding' => 'sometimes|boolean',
            ]);


            // Get data from session
            $submissionData = session('submission');
            $conference = Conference::where('acronyme', session('conference'))->first();

            if (!$conference) {
                throw new \Exception('Conference not found');
            }

            // Separate corresponding author from co-authors
            $correspondingAuthorData = null;
            $coAuthorsData = [];

            foreach ($validatedData['authors'] as $authorData) {
                if (isset($authorData['is_corresponding']) && $authorData['is_corresponding']) {
                    $correspondingAuthorData = $authorData;
                } else {
                    $coAuthorsData[] = $authorData;
                }
            }

            // Ensure we have a corresponding author
            if (!$correspondingAuthorData) {
                return back()->withErrors(['authors' => 'Please specify a corresponding author']);
            }

            // Generate unique submission ID
            $submissionId = $this->generateSubmissionId($conference);
            $newPath = 'submissions/' . $submissionId . '.pdf';

            // Start transaction
            DB::beginTransaction();

            try {
                // Handle corresponding author
                $correspondingAuthor = User::firstOrCreate(
                    ['email' => $correspondingAuthorData['email']],
                    [
                        'firstName' => $correspondingAuthorData['first_name'],
                        'lastName' => $correspondingAuthorData['last_name'],
                        'affiliation' => $correspondingAuthorData['affiliation'],
                    ]
                );

                // Ensure corresponding author exists in auteurs table
                Auteur::firstOrCreate(['id' => $correspondingAuthor->id]);
                //insert role 
                DB::table('user_conferences')->insertOrIgnore([
                    [
                        'conference_id' => $conference->id,
                        'user_id' => $correspondingAuthor->id,
                        'role' => 'auteur',
                        'statut' => 'accepted',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);


                // Create the submission
                $submission = Submission::create([
                    'idSubmission' => $submissionId,
                    'titre' => $submissionData['title'],
                    'keywords' => $submissionData['keywords'],
                    'resume' => $submissionData['abstract'],
                    'statut' => 'pending',
                    'auteur_id' => $correspondingAuthor->id,
                    'conference_id' => $conference->id,
                ]);

                // ✅ Save PDF record (version = 0)
                Pdf::create([
                    'submission_id' => $submissionId,
                    'pdf' => $newPath,
                    'version' => 0,
                ]);

                // Handle co-authors if any
                foreach ($coAuthorsData as $coAuthorData) {
                    $coAuthor = User::firstOrCreate(
                        ['email' => $coAuthorData['email']],
                        [
                            'firstName' => $coAuthorData['first_name'],
                            'lastName' => $coAuthorData['last_name'],
                            'affiliation' => $coAuthorData['affiliation'],
                        ]
                    );

                    // Ensure co-author exists in auteurs table
                    Auteur::firstOrCreate(['id' => $coAuthor->id]);

                    // Insert into user_conferences
                    DB::table('user_conferences')->insertOrIgnore([
                        [
                            'conference_id' => $conference->id,
                            'user_id' => $coAuthor->id,
                            'role' => 'auteur',
                            'statut' => 'accepted',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                    ]);


                    // Attach to submission through pivot table
                    $submission->secondaryAuthors()->attach($coAuthor->id, ['idSubmission' => $submissionId]);
                }

                // Move the file after successful DB operations
                if (!Storage::disk('public')->move($submissionData['file_path'], $newPath)) {
                    throw new \Exception('Failed to move uploaded file');
                }

                // Commit the transaction
                DB::commit();

                // Send email to corresponding author
                Mail::to($correspondingAuthor->email)
                    ->send(new SubmissionConfirmation($correspondingAuthor, $submission, $conference));
                // Clear the session data
                session()->forget(['submission', 'conference']);

                session([
                    'submission_status' => 'success',
                    'submission_message' => 'Your submission has been received successfully!'
                ]);
                return redirect()->route('submission.result');
            } catch (\Exception $e) {
                // Rollback the transaction on error
                DB::rollBack();
                session([
                    'submission_status' => 'error',
                    'submission_message' => 'Submission failed: ' . $e->getMessage()
                ]);
                // Redirect to the result page.
                return redirect()->route('submission.result');
            }
        } catch (\Exception $e) {
            // Redirect to error page
            session([
                'submission_status' => 'error',
                'submission_message' => 'Submission failed: ' . $e->getMessage()
            ]);
            return redirect()->route('submission.result');
        }
    }


    public static  function index($acronyme)
    {

        // Get conference by acronym
        $conference = Conference::where('acronyme', $acronyme)->firstOrFail();
        $user = Auth::user();

        // Get ONLY the current user's submissions for this conference
        $submissions = Submission::with('latestPdf')
            ->where('conference_id', $conference->id)
            ->where(function ($query) use ($user) {
                $query->where('auteur_id', $user->id);
            })
            ->whereNot('statut', 'Withdrawn')
            ->get();


        return ['conference' => $conference, 'submissions' => $submissions];
    }
    //edit the submission
    public function edit($idSubmission)
    {
        if (!request('Submission')) {
            abort(404);
        }

        $submission = Submission::with(['primaryAuthor', 'secondaryAuthors', 'conference'])
            ->findOrFail($idSubmission);
        // Check if updates are allowed
        if (!$submission) {
            abort(404);
        }
        if (!$submission->conference->configuration->submissionUpdateAllowed) {
            abort(403);
        }

        // Check if submission deadline has passed
        if (now()->gt($submission->conference->submissionDeadLine)) {
            abort(403);
        }

        // Check if current user is the corresponding author
        if (Auth::id() !== $submission->auteur_id) {
            abort(403);
        }
        return view('form.submissionEdit', [
            'submission' => $submission,
            'conference' => $submission->conference
        ]);
    }


    // UPDATE THE SUBMISSION 
    public function update(Request $request, $idSubmission)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'paper_file' => 'sometimes|file|mimes:pdf|max:20480', // 20MB max, optional
            'co_authors' => 'sometimes|array',
            'co_authors.*.first_name' => 'required_with:co_authors|string|max:255',
            'co_authors.*.last_name' => 'required_with:co_authors|string|max:255',
            'co_authors.*.email' => 'required_with:co_authors|email|max:255',
            'co_authors.*.affiliation' => 'required_with:co_authors|string|max:255',
            'co_authors.*.id' => 'sometimes|exists:auteurs,id' // For existing authors
        ]);

        DB::beginTransaction();

        try {
            // Find the submission

            $submission = Submission::findOrFail($idSubmission);
            $conference = $submission->conference;
            // Check if updates are allowed

            if (!$conference->configuration->submissionUpdateAllowed) {
                return back()->with('error', 'Submission updates are not currently allowed for this conference.');
            }

            // Check if submission deadline has passed
            if (now()->gt($conference->submissionDeadLine)) {
                return back()->with('error', 'The submission deadline has passed. Updates are no longer allowed.');
            }

            // Check if current user is the corresponding author
            if (Auth::id() !== $submission->auteur_id) {
                return back()->with('error', 'Only the corresponding author can update this submission.');
            }
            // Handle file update if new file was uploaded
            if ($request->hasFile('paper_file')) {
                // Get the latest version number
                $lastVersion = $submission->pdfs()->max('version') ?? -1;
                $newVersion = $lastVersion + 1;

                // Store new file with versioned name
                $filename = 'submissions/' . $submission->idSubmission . '_v' . $newVersion . '.pdf';
                $request->file('paper_file')->storeAs('', $filename, 'public');

                // Create new PDF record
                Pdf::create([
                    'submission_id' => $submission->idSubmission,
                    'pdf' => $filename,
                    'version' => $newVersion,
                ]);
            }

            // Update the submission details
            $submission->update([
                'titre' => $validatedData['title'],
                'keywords' => $validatedData['keywords'],
                'resume' => $validatedData['abstract'],
                'updated_at' => now()
            ]);

            // Handle co-authors update if present in request
            if ($request->has('co_authors')) {
                $currentCoAuthorIds = [];

                foreach ($request->co_authors as $coAuthorData) {
                    // Check if this is an existing author (has ID)
                    if (isset($coAuthorData['id'])) {
                        // Update existing author
                        $author = User::find($coAuthorData['id']);
                        if ($author) {
                            $author->update([
                                'firstName' => $coAuthorData['first_name'],
                                'lastName' => $coAuthorData['last_name'],
                                'email' => $coAuthorData['email'],
                                'affiliation' => $coAuthorData['affiliation'],
                            ]);
                            $currentCoAuthorIds[] = $author->id;
                        }
                    } else {
                        // Create new author
                        $author = User::firstOrCreate(
                            ['email' => $coAuthorData['email']],
                            [
                                'firstName' => $coAuthorData['first_name'],
                                'lastName' => $coAuthorData['last_name'],
                                'affiliation' => $coAuthorData['affiliation'],
                            ]
                        );

                        // Ensure author exists in auteurs table
                        Auteur::firstOrCreate(['id' => $author->id]);

                        // Add to user_conferences if not already present
                        DB::table('user_conferences')->updateOrInsert(
                            [
                                'conference_id' => $conference->id,
                                'user_id' => $author->id,
                            ],
                            [
                                'role' => 'auteur',
                                'statut' => 'accepted',
                                'updated_at' => now(),
                            ]
                        );

                        $currentCoAuthorIds[] = $author->id;
                    }
                }

                // Sync secondary authors - removes any that aren't in current list
                $submission->secondaryAuthors()->sync($currentCoAuthorIds);
            } else {
                $submission->secondaryAuthors()->sync([]);
            }

            DB::commit();

            return redirect()->route('userDashboard', ['acronyme' => $conference->acronyme, 'role' => 'auteur'])
                ->with('success', 'Submission updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('userDashboard', ['acronyme' => $conference->acronyme, 'role' => 'auteur'])
                ->with('error', 'Failed to delete submission: ' . $e->getMessage());
        }
    }


    //DELETE A SUBMISSION *****************************
    public function destroy(Submission $submission)
    {
        // Check if current user is the corresponding author
        if (Auth::id() !== $submission->auteur_id) {
            return back()->with('error', 'Only the corresponding author can delete this submission.');
        }
        DB::beginTransaction();

        try {


            $submission->statut = 'withdrawn';
            $submission->save();

            DB::commit();

            return back()->with('success', 'Submission withdrawn successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete submission: ' . $e->getMessage());
        }
    }

    public function viewHistory(Submission $submission)
    {
        $pdfs = $submission->pdfs; // All versions
        return view('dashboardUser.chair.history', compact('submission', 'pdfs'));
    }
    public function showDetails($idSubmission)
    {
        $submission = Submission::with('latestPdf')->findOrFail($idSubmission);
        return view('dashboardUser.chair.details', compact('submission'));
    }
}
