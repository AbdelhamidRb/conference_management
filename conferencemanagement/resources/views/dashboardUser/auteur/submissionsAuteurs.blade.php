@extends('dashboardUser.auteur.dashboardAuteur')

@section('content1')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                <i class="fas fa-file-alt text-blue-600 dark:text-blue-400 text-xl"></i>
            </div>
            <h1 class="mt-3 text-2xl font-bold text-gray-900 dark:text-white">Submissions</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Conference: <span class="font-medium text-blue-600 dark:text-blue-400">{{ $conference->title }}</span>
            </p>
        </div>

        <!-- Quick Navigation (Desktop only) -->
        @if($submissions->isNotEmpty())
        <div class="hidden lg:block mb-6 text-center">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Quick navigation:</span>
            <div class="mt-2 flex flex-wrap justify-center gap-2">
                @foreach($submissions as $submission)
                <a href="#submission-{{ $submission->idSubmission }}"
                    class="inline-block px-3 py-1 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                    #{{ $submission->idSubmission }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 p-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-3"></i>
                <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 p-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 mr-3"></i>
                <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Mobile Layout -->
        <div class="block lg:hidden space-y-6">
            @foreach($submissions as $submission)
            <div id="submission-{{ $submission->idSubmission }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Mobile Header -->
                <div class="bg-blue-600 dark:bg-blue-700 px-4 py-3">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">Submission #{{ $submission->idSubmission }}</h3>
                        <span class="text-xs text-blue-100">{{ $submission->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <!-- Mobile Content -->
                <div class="p-4 space-y-4">
                    <!-- Title -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Title</h4>
                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $submission->titre }}</p>
                    </div>

                    <!-- Primary Author -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Primary Author</h4>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-gray-500 dark:text-gray-400 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $submission->primaryAuthor->user->firstName }} {{ $submission->primaryAuthor->user->lastName }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $submission->primaryAuthor->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Co-Authors -->
                    @if($submission->secondaryAuthors->isNotEmpty())
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Co-Authors</h4>
                        <div class="space-y-2">
                            @foreach($submission->secondaryAuthors as $author)
                            <div class="flex items-center">
                                <i class="fas fa-user text-gray-400 text-xs mr-2"></i>
                                <span class="text-sm text-gray-900 dark:text-white">
                                    {{ $author->user->firstName }} {{ $author->user->lastName }}
                                    @if($author->id == auth()->id())
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">You</span>
                                    @endif
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Keywords -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Keywords</h4>
                        <div class="flex flex-wrap gap-1">
                            @foreach(explode(',', $submission->keywords) as $keyword)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-200">
                                {{ trim($keyword) }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Abstract -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Abstract</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3">{{ $submission->resume }}</p>
                    </div>

                    <!-- PDF and Actions -->
                    <div class="flex flex-col space-y-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                        @if ($submission->latestPdf && $submission->latestPdf->pdf)
                        <a href="{{ Storage::url('submissions/' . $submission->latestPdf->pdf) }}"
                            download
                            class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-download mr-2"></i>
                            Télécharger le PDF
                        </a>
                        @endif

                        <div class="flex space-x-3">
                            @php
                            $canEdit = $submission->conference->configuration->submissionUpdateAllowed && now()->lte($submission->conference->submissionDeadLine);
                            @endphp

                            @if ($canEdit)
                            <a href="/submissionEdit/{{ $submission->idSubmission }}"
                                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                            @else
                            <button disabled
                                class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm font-medium py-2 px-4 rounded-lg cursor-not-allowed flex items-center justify-center"
                                title="{{ !$submission->conference->configuration->submissionUpdateAllowed ? 'Updates are disabled' : 'Deadline has passed' }}">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </button>
                            @endif

                            <button onclick="showDeleteModal('{{ route('submissions.destroy', $submission->idSubmission) }}')"
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                                <i class="fas fa-trash mr-2"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop Layout -->
        <div class="hidden lg:block space-y-6">
            @foreach($submissions as $submission)
            <div id="submission-{{ $submission->idSubmission }}" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Desktop Header -->
                <div class="px-6 py-4 bg-blue-600 dark:bg-blue-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">Submission #{{ $submission->idSubmission }}</h3>
                        <span class="text-sm text-blue-100">Submitted on {{ $submission->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <!-- Desktop Content -->
                <div class="divide-y divide-gray-200 dark:divide-gray-600">
                    <!-- Title -->
                    <div class="px-6 py-4 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                            <i class="fas fa-heading mr-2"></i> Title
                        </dt>
                        <dd class="text-sm text-gray-900 dark:text-white col-span-2 font-medium">{{ $submission->titre }}</dd>
                    </div>

                    <!-- Primary Author -->
                    <div class="px-6 py-4 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                            <i class="fas fa-user mr-2"></i> Primary Author
                        </dt>
                        <dd class="text-sm text-gray-900 dark:text-white col-span-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-gray-500 dark:text-gray-400"></i>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $submission->primaryAuthor->user->firstName }} {{ $submission->primaryAuthor->user->lastName }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">{{ $submission->primaryAuthor->user->email }}</div>
                                </div>
                            </div>
                        </dd>
                    </div>

                    <!-- Co-Authors -->
                    <div class="px-6 py-4 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                            <i class="fas fa-users mr-2"></i> Co-Authors
                        </dt>
                        <dd class="text-sm text-gray-900 dark:text-white col-span-2">
                            @forelse($submission->secondaryAuthors as $author)
                            <div class="flex items-center mb-2">
                                <i class="fas fa-user text-gray-400 mr-2"></i>
                                <span>
                                    {{ $author->user->firstName }} {{ $author->user->lastName }}
                                    @if($author->id == auth()->id())
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">You</span>
                                    @endif
                                </span>
                            </div>
                            @empty
                            <span class="text-gray-500 dark:text-gray-400">None</span>
                            @endforelse
                        </dd>
                    </div>

                    <!-- Keywords -->
                    <div class="px-6 py-4 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                            <i class="fas fa-key mr-2"></i> Keywords
                        </dt>
                        <dd class="text-sm text-gray-900 dark:text-white col-span-2">
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $submission->keywords) as $keyword)
                                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-200 border border-blue-200 dark:border-blue-700">
                                    {{ trim($keyword) }}
                                </span>
                                @endforeach
                            </div>
                        </dd>
                    </div>

                    <!-- Abstract -->
                    <div class="px-6 py-4 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                            <i class="fas fa-align-left mr-2"></i> Abstract
                        </dt>
                        <dd class="text-sm text-gray-600 dark:text-gray-300 col-span-2">{{ $submission->resume }}</dd>
                    </div>

                    <!-- PDF and Actions -->
                    <div class="px-6 py-4 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                            <i class="fas fa-cogs mr-2"></i> Actions
                        </dt>
                        <dd class="text-sm text-gray-900 dark:text-white col-span-2">
                            <div class="flex items-center space-x-4">
                                @if($submission->latestPdf->pdf)
                                <a href="{{ Storage::url($submission->latestPdf->pdf) }}" download
                                    class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md transition-colors">
                                    <i class="fas fa-download mr-1"></i>
                                    Download PDF
                                </a>
                                @endif

                                @php
                                $canEdit = $submission->conference->configuration->submissionUpdateAllowed && now()->lte($submission->conference->submissionDeadLine);
                                @endphp

                                @if ($canEdit)
                                <a href="/submissionEdit/{{ $submission->idSubmission }}"
                                    class="text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors"
                                    title="Edit submission">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                @else
                                <span class="text-gray-400 dark:text-gray-500 cursor-not-allowed"
                                    title="{{ !$submission->conference->configuration->submissionUpdateAllowed ? 'Updates are disabled' : 'Deadline has passed' }}">
                                    <i class="fas fa-edit text-lg"></i>
                                </span>
                                @endif

                                <button onclick="showDeleteModal('{{ route('submissions.destroy', $submission->idSubmission) }}')"
                                    class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                    title="Delete submission">
                                    <i class="fas fa-trash text-lg"></i>
                                </button>
                            </div>
                        </dd>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($submissions->isEmpty())
        <div class="text-center py-12">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                <i class="fas fa-file-alt text-gray-400 dark:text-gray-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No submissions yet</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first submission.</p>
            <a href="/submission1/{{ $conference->acronyme }}"
                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>
                New Submission
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div id="delete-modal" class="fixed inset-0 hidden z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white text-center mb-2">Withdraw Submission</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-6">
                Are you sure you want to withdraw this submission? This action cannot be undone.
            </p>

            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex items-center justify-center mb-4">
                    <div class="flex items-center text-red-600 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="text-sm">This action is permanent</span>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 font-medium py-2 px-4 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Withdraw
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showDeleteModal(formAction) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        form.action = formAction;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('delete-modal');
        if (event.target === modal) {
            closeModal();
        }
    });
</script>
@endsection