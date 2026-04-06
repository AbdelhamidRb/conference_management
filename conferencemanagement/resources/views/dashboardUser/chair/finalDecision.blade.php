@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-2 sm:p-4 lg:p-6">
    <div class="mb-6 sm:mb-8 text-center">
        <div class="mx-auto flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-file-alt text-blue-600 text-lg sm:text-xl"></i>
        </div>
        <h1 class="mt-2 sm:mt-3 text-xl sm:text-2xl font-bold">
            <span class="text-blue-600">{{ request('acronyme') }}</span> List of Submissions
        </h1>
        <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-600">
            Manage submissions for <span class="font-semibold text-blue-600">{{ request('acronyme') }}</span> conference
        </p>
    </div>

    @if(session('success'))
    <div class="mx-auto mt-4 text-center rounded-lg bg-green-100 border border-green-400 px-4 sm:px-6 py-3 sm:py-4 text-green-800 text-sm shadow-sm">
        <i class="fas fa-check-circle mr-2 text-green-500"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($submissions->count() > 0)

    <!-- Mobile & Tablet Cards (visible on screens smaller than 1280px) -->
    <div class="block xl:hidden space-y-4">
        @foreach($submissions as $submission)
        <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm hover:bg-gray-50 transition-colors">
            <!-- Header with ID, Title and Score -->
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1 min-w-0 pr-2">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs text-gray-500">ID:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $submission->idSubmission }}</span>
                    </div>
                    <h3 class="text-sm sm:text-base font-semibold text-gray-900 break-words leading-tight">
                        {{ $submission->titre }}
                    </h3>
                </div>

                @php
                $totalScore = 0;
                foreach($submission->evaluations as $evaluation) {
                $totalScore += match($evaluation->latestVersion->decision ?? 'Pas de décision') {
                'accepted' => 1,
                'rejected' => -1,
                default => 0
                };
                }
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-medium flex-shrink-0
                    {{ $totalScore > 0 ? 'bg-green-100 text-green-800' : 
                       ($totalScore < 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ $totalScore > 0 ? '+'.$totalScore : $totalScore }}
                </span>
            </div>

            <!-- Keywords -->
            <div class="mb-3">
                <p class="text-xs text-gray-500 mb-2">Keywords:</p>
                <div class="flex flex-wrap gap-1">
                    @foreach(explode(',', $submission->keywords) as $keyword)
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                        {{ trim($keyword) }}
                    </span>
                    @endforeach
                </div>
            </div>

            <!-- Reviews -->
            <div class="mb-4">
                <p class="text-xs text-gray-500 mb-2">Reviews:</p>
                <div class="flex flex-wrap gap-1">
                    @foreach($submission->evaluations as $evaluation)
                    @php
                    $score = match($evaluation->latestVersion->decision ?? 'Pas de décision') {
                    'accepted' => '+1',
                    'rejected' => '-1',
                    default => '0'
                    };
                    $bgColor = match($evaluation->latestVersion->decision ?? 'Pas de décision') {
                    'accepted' => 'bg-green-50 text-green-700 border-green-200',
                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                    default => 'bg-yellow-50 text-yellow-700 border-yellow-200'
                    };
                    @endphp
                    <a href="{{ route('evaluation.details', [
                        'acronyme' => $evaluation->submission->conference->acronyme,
                        'pc_member_id' => $evaluation->pc_member_id,
                        'submission_id' => $evaluation->submission_id
                    ]) }}"
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $bgColor }} hover:shadow transition-colors">
                        <span class="break-words">{{ $evaluation->pcMember->user->firstName }} {{ $evaluation->pcMember->user->lastName }}</span>
                        <span class="ml-1 font-bold">{{ $score }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-gray-100 pt-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <!-- Add Review -->
                    <button onclick="openReviewIframe('{{ $submission->idSubmission }}')"
                        class="inline-flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded shadow transition duration-200">
                        <i class="fas fa-plus-circle mr-1"></i> Add Review
                    </button>

                    <!-- Final Decision Dropdown -->
                    <div class="relative">
                        <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                            class="w-full inline-flex items-center justify-center px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-medium rounded shadow transition duration-200">
                            <i class="fas fa-gavel mr-1"></i> Final Decision
                        </button>

                        <div class="hidden absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200">
                            <!-- Accept -->
                            <form action="{{ route('finalDecision.accept', $submission->idSubmission) }}" method="POST" class="block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-3 py-2 text-xs text-green-700 hover:bg-green-50 border-b border-gray-100">
                                    <i class="fas fa-check mr-1"></i> Accept
                                </button>
                            </form>

                            <!-- Reject -->
                            <form action="{{ route('finalDecision.reject', $submission->idSubmission) }}" method="POST" class="block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-3 py-2 text-xs text-red-700 hover:bg-red-50 border-b border-gray-100">
                                    <i class="fas fa-times mr-1"></i> Reject
                                </button>
                            </form>

                            <!-- Borderline -->
                            <form action="{{ route('finalDecision.borderline', $submission->idSubmission) }}" method="POST" class="block w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-3 py-2 text-xs text-yellow-700 hover:bg-yellow-50">
                                    <i class="fas fa-minus-circle mr-1"></i> Borderline
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Desktop Table (visible on screens 1280px and larger) -->
    <div class="hidden xl:block mt-4 sm:mt-6">
        <div class="rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/12">
                            <div class="flex items-center">
                                <i class="fas fa-id-card mr-2 text-blue-500"></i>
                                ID
                            </div>
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/4">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                                Title
                            </div>
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/6">
                            <div class="flex items-center">
                                <i class="fas fa-tags mr-2 text-blue-500"></i>
                                Keywords
                            </div>
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/4">
                            <div class="flex items-center">
                                <i class="fas fa-star mr-2 text-blue-500"></i>
                                Reviews
                            </div>
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/12">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-chart-bar mr-1 text-blue-500"></i>
                                Score
                            </div>
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/12">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-plus-circle mr-1 text-blue-500"></i>
                                Review
                            </div>
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/8">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-gavel mr-1 text-purple-500"></i>
                                Decision
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($submissions as $submission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-4 text-sm text-gray-900">
                            {{ $submission->idSubmission }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-900 break-words">
                            {{ $submission->titre }}
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(explode(',', $submission->keywords) as $keyword)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ trim($keyword) }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($submission->evaluations as $evaluation)
                                @php
                                $score = match($evaluation->latestVersion->decision ?? 'Pas de décision') {
                                'accepted' => '+1',
                                'rejected' => '-1',
                                default => '0'
                                };
                                $bgColor = match($evaluation->latestVersion->decision ?? 'Pas de décision') {
                                'accepted' => 'bg-green-50 text-green-700 border-green-200',
                                'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-yellow-50 text-yellow-700 border-yellow-200'
                                };
                                @endphp
                                <a href="{{ route('evaluation.details', [
                                    'acronyme' => $evaluation->submission->conference->acronyme,
                                    'pc_member_id' => $evaluation->pc_member_id,
                                    'submission_id' => $evaluation->submission_id
                                ]) }}"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $bgColor }} hover:shadow transition-colors">
                                    <span class="break-words">{{ $evaluation->pcMember->user->firstName }} {{ $evaluation->pcMember->user->lastName }}</span>
                                    <span class="ml-1 font-bold">{{ $score }}</span>
                                </a>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            @php
                            $totalScore = 0;
                            foreach($submission->evaluations as $evaluation) {
                            $totalScore += match($evaluation->latestVersion->decision ?? 'Pas de décision') {
                            'accepted' => 1,
                            'rejected' => -1,
                            default => 0
                            };
                            }
                            @endphp
                            <span class="px-2 py-1 rounded-full text-sm font-medium 
                                {{ $totalScore > 0 ? 'bg-green-100 text-green-800' : 
                                   ($totalScore < 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $totalScore > 0 ? '+'.$totalScore : $totalScore }}
                            </span>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <button onclick="openReviewIframe('{{ $submission->idSubmission }}')"
                                class="inline-flex items-center px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded shadow transition duration-200"
                                title="Add review for this submission">
                                <i class="fas fa-plus-circle mr-1"></i> Add
                            </button>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col space-y-1">
                                <!-- Accept Button -->
                                <form action="{{ route('finalDecision.accept', $submission->idSubmission) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded shadow transition duration-200 w-full justify-center"
                                        title="Accept this submission">
                                        <i class="fas fa-check mr-1"></i> Accept
                                    </button>
                                </form>

                                <!-- Reject Button -->
                                <form action="{{ route('finalDecision.reject', $submission->idSubmission) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded shadow transition duration-200 w-full justify-center"
                                        title="Reject this submission">
                                        <i class="fas fa-times mr-1"></i> Reject
                                    </button>
                                </form>

                                <!-- Borderline Button -->
                                <form action="{{ route('finalDecision.borderline', $submission->idSubmission) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium rounded shadow transition duration-200 w-full justify-center"
                                        title="Mark as Borderline">
                                        <i class="fas fa-minus-circle mr-1"></i> Borderline
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @else
    <div class="bg-white rounded-lg border border-gray-200 p-6 sm:p-8 text-center text-sm text-gray-500 shadow-sm">
        There are no submissions at the moment.
    </div>
    @endif
</div>

<!-- Iframe Modal -->
<div id="reviewIframeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white w-full max-w-6xl h-full max-h-[90vh] rounded-lg shadow-lg relative">
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Add Review</h3>
            <button onclick="closeReviewIframe()"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow text-sm">
                Close
            </button>
        </div>
        <iframe id="reviewFrame" src="" class="w-full h-[calc(100%-4rem)] border-0"></iframe>
    </div>
</div>

<script>
    function openReviewIframe(submissionId) {
        const modal = document.getElementById('reviewIframeModal');
        const iframe = document.getElementById('reviewFrame');

        // Get the current user ID (you may need to pass this differently)
        const userId = '{{ auth()->id() }}';

        // Set the iframe source to your evaluation form
        iframe.src = `/review-form?submission_id=${submissionId}&user_id=${userId}`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReviewIframe() {
        const modal = document.getElementById('reviewIframeModal');
        const iframe = document.getElementById('reviewFrame');

        iframe.src = '';
        modal.classList.remove('flex');
        modal.classList.add('hidden');

        // Optional: reload after closing if needed
        setTimeout(() => location.reload(), 100);
    }

    // Close modal when clicking outside
    document.getElementById('reviewIframeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReviewIframe();
        }
    });
</script>
@endsection