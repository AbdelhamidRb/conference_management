@vite('resources/css/app.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="mb-10 text-center">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-200 dark:bg-blue-800 shadow-md">
        <i class="fas {{ $mode === 'decision' ? 'fa-gavel' : 'fa-envelope' }} text-blue-700 dark:text-blue-300 text-2xl"></i>
    </div>
    <h2 class="mt-4 text-3xl font-extrabold text-gray-800 dark:text-gray-100">
        {{ $mode === 'decision' ? 'Send Decision Notifications' : 'Send Information to Authors' }}
    </h2>
    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
        {{ $mode === 'decision' ? 'Notify authors about their submission status' : 'Communicate important information to authors' }}
    </p>
</div>

@if(session('success'))
<div class="mb-6 rounded-lg bg-green-200 dark:bg-green-800 p-4 text-green-900 dark:text-green-200 shadow">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
</div>
@endif

<form action="{{ $sendRoute }}" method="POST" class="space-y-6">
    @csrf

    @foreach($submissions as $submission)
        <input type="hidden" name="submissions[]" value="{{ $submission->idSubmission }}">
    @endforeach

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fas fa-heading mr-2 text-blue-500"></i>Subject
            </label>
            <input type="text" name="subject" required 
                   class="block w-full px-4 py-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                   value="{{ $mode === 'decision' ? 'Decision for your submission' : 'Important information about your submission' }}">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fas fa-align-left mr-2 text-blue-500"></i>Message
            </label>
            <textarea name="message" rows="6" required
                class="block w-full px-4 py-3 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ $mode === 'decision' ? "Dear [Author Name],\n\nWe have completed the review process for your submission titled \"[Paper Title]\".\n\nDecision: [Decision]\n\nReviewers' remarks:\n[Reviewers Remarks]\n\nThank you for your submission.\n\nBest regards,\nThe Program Committee" : "Dear [Author Name],\n\nWe would like to share some important information regarding your submission titled \"[Paper Title]\".\n\n[Your message here]\n\nBest regards,\nThe Program Committee" }}</textarea>
            
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-info-circle mr-1"></i>Available variables: 
                <span class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">[Author Name]</span>, 
                <span class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">[Paper Title]</span>
                @if($mode === 'decision')
                , <span class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">[Decision]</span>, 
                <span class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">[Reviewers Remarks]</span>
                @endif
            </p>
        </div>

        @if($mode === 'decision')
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                <i class="fas fa-bell mr-2 text-blue-500"></i>Include Reviewers' Comments
            </label>
            <div class="flex items-center">
                <input type="checkbox" name="include_comments" id="include_comments" checked
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="include_comments" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    Include reviewers' remarks in the email
                </label>
            </div>
        </div>
        @endif
    </div>

    <div class="text-center">
        <button type="submit"
            class="inline-flex items-center px-7 py-3 border border-transparent text-base font-medium rounded-xl shadow-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
            <i class="fas fa-paper-plane mr-2"></i>{{ $mode === 'decision' ? 'Send Decisions' : 'Send Information' }}
        </button>
    </div>
</form>