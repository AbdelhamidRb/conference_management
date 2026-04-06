@extends('dashboardUser.pcMember.dashboardPcMember')

@section('content1')
<div class="min-h-screen bg-gray-50 p-4">
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
        </div>
        <h1 class="mt-3 text-2xl font-bold">My Articles to Review</h1>
        <p class="mt-2 text-sm text-gray-600">Review the articles assigned to you</p>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
    <div class="mb-4 rounded-lg bg-red-100 px-6 py-4 text-sm text-red-800 shadow-sm">
        {{ session('error') }}
    </div>
    @endif
    @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-100 px-6 py-4 text-sm text-green-800 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Mobile View (Cards) - jusqu'à 640px -->
    <div class="block sm:hidden space-y-4">
        @forelse($evaluations as $evaluation)
        <div class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
            <!-- Article Title -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                {{ $evaluation->submission->titre ?? 'N/A' }}
            </h3>

            <!-- Abstract Preview -->
            <div class="mb-3">
                <p class="text-xs text-gray-500 mb-1">Abstract:</p>
                <p class="text-sm text-gray-600 line-clamp-3">
                    {{ $evaluation->submission->resume ?? 'N/A' }}
                </p>
            </div>

            <!-- Keywords -->
            <div class="mb-3">
                <p class="text-xs text-gray-500 mb-1">Keywords:</p>
                <div class="flex flex-wrap gap-1">
                    @if($evaluation->submission->keywords ?? false)
                    @foreach(explode(',', $evaluation->submission->keywords) as $keyword)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                        {{ trim($keyword) }}
                    </span>
                    @endforeach
                    @else
                    <span class="text-xs text-gray-400">N/A</span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between gap-2 mt-4">
                <!-- Download Button -->
                @if($evaluation->submission->latestPdf ?? false)
                <a href="{{ Storage::url($evaluation->submission->latestPdf->pdf) }}" download
                    class="flex-1 flex items-center justify-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded shadow transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i> PDF
                </a>
                @else
                <span class="flex-1 flex items-center justify-center px-3 py-2 bg-gray-100 text-gray-500 text-sm rounded">
                    <i class="fas fa-file-exclamation mr-2"></i> No PDF
                </span>
                @endif

                <!-- Review Button -->
                <button onclick="openIframe('{{ $evaluation->submission_id }}', '{{ $evaluation->pc_member_id }}')"
                    class="flex-1 flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded shadow transition-colors">
                    <i class="fas fa-edit mr-2"></i> Review
                </button>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100 text-center">
            <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">No articles assigned for review</p>
        </div>
        @endforelse
    </div>

    <!-- Tablet View (Compact Cards) - 640px à 1024px -->
    <div class="hidden sm:block lg:hidden space-y-4">
        @forelse($evaluations as $evaluation)
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Left Column -->
                <div class="space-y-3">
                    <!-- Title -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ $evaluation->submission->titre ?? 'N/A' }}
                        </h3>
                    </div>

                    <!-- Abstract -->
                    <div>
                        <p class="text-xs text-gray-500 mb-1 font-medium">Abstract:</p>
                        <p class="text-sm text-gray-600 line-clamp-4">
                            {{ $evaluation->submission->resume ?? 'N/A' }}
                        </p>
                    </div>

                    <!-- Keywords -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2 font-medium">Keywords:</p>
                        <div class="flex flex-wrap gap-1">
                            @if($evaluation->submission->keywords ?? false)
                            @foreach(explode(',', $evaluation->submission->keywords) as $keyword)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ trim($keyword) }}
                            </span>
                            @endforeach
                            @else
                            <span class="text-xs text-gray-400">N/A</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="flex flex-col justify-between">
                    <!-- Document Section -->
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2 font-medium">Document:</p>
                        @if($evaluation->submission->latestPdf ?? false)
                        <a href="{{ Storage::url($evaluation->submission->latestPdf->pdf) }}" download
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded shadow transition duration-200 w-full justify-center">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Download PDF
                        </a>
                        @else
                        <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-500 text-sm rounded w-full justify-center">
                            <i class="fas fa-file-exclamation mr-2"></i>
                            No Document
                        </span>
                        @endif
                    </div>

                    <!-- Action Section -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2 font-medium">Action:</p>
                        <button onclick="openIframe('{{ $evaluation->submission_id }}', '{{ $evaluation->pc_member_id }}')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow transition duration-200 w-full justify-center">
                            <i class="fas fa-edit mr-2"></i>
                            Start Review
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100 text-center">
            <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">No articles assigned for review</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop View (Table) - 1024px et plus -->
    <div class="hidden lg:block overflow-hidden rounded-lg border border-gray-200 shadow-sm mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[200px]">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                                Title
                            </div>
                        </th>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[250px]">
                            <div class="flex items-center">
                                <i class="fas fa-align-left mr-2 text-blue-500"></i>
                                Abstract
                            </div>
                        </th>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[180px]">
                            <div class="flex items-center">
                                <i class="fas fa-tags mr-2 text-blue-500"></i>
                                Keywords
                            </div>
                        </th>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[120px]">
                            <div class="flex items-center">
                                <i class="fas fa-file-pdf mr-2 text-blue-500"></i>
                                Document
                            </div>
                        </th>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[120px]">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2 text-blue-500"></i>
                                Action
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($evaluations as $evaluation)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 xl:px-6 py-4 text-sm text-gray-900">
                            <div class="font-medium">
                                {{ $evaluation->submission->titre ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 xl:px-6 py-4 text-sm text-gray-600">
                            <div class="max-w-xs xl:max-w-sm">
                                <div class="line-clamp-3">
                                    {{ $evaluation->submission->resume ?? 'N/A' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-4 xl:px-6 py-4 align-top">
                            @if($evaluation->submission->keywords ?? false)
                            <div class="flex flex-wrap gap-1">
                                @foreach(explode(',', $evaluation->submission->keywords) as $keyword)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ trim($keyword) }}
                                </span>
                                @endforeach
                            </div>
                            @else
                            <span class="text-sm text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-4 xl:px-6 py-4 whitespace-nowrap">
                            @if($evaluation->submission->latestPdf ?? false)
                            <a href="{{ Storage::url($evaluation->submission->latestPdf->pdf) }}" download
                                class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded shadow transition duration-200">
                                <i class="fas fa-download mr-1"></i>
                                <span class="hidden xl:inline">Download</span>
                                <span class="xl:hidden">PDF</span>
                            </a>
                            @else
                            <span class="text-gray-400 text-xs">No document</span>
                            @endif
                        </td>
                        <td class="px-4 xl:px-6 py-4 whitespace-nowrap">
                            <button onclick="openIframe('{{ $evaluation->submission_id }}', '{{ $evaluation->pc_member_id }}')"
                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded shadow transition duration-200">
                                <i class="fas fa-edit mr-1"></i>
                                <span class="hidden xl:inline">Review</span>
                                <span class="xl:hidden">Edit</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-6">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
                                <p>No articles assigned for review</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Evaluation Modal -->
<div id="iframeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white w-full max-w-6xl h-[90vh] rounded-lg shadow-xl relative flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold">Article Evaluation</h3>
            <button onclick="closeIframe()"
                class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Iframe Container -->
        <div class="flex-1 overflow-hidden">
            <iframe id="evaluationIframe" src="" class="w-full h-full border-0"></iframe>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 px-6 py-3 bg-gray-50 flex justify-end">
            <button onclick="closeIframe()"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<style>
    /* Amélioration du line-clamp pour une meilleure compatibilité */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-4 {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Scroll horizontal pour le tableau si nécessaire */
    @media (min-width: 1024px) and (max-width: 1280px) {
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f7fafc;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
    }
</style>

<script>
    function openIframe(submissionId, pcMemberId) {
        const modal = document.getElementById('iframeModal');
        const iframe = document.getElementById('evaluationIframe');

        // Load evaluation form
        iframe.src = `/evaluations/form/${submissionId}/${pcMemberId}`;

        // Show modal with animation
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 10);

        // Prevent body scrolling
        document.body.style.overflow = 'hidden';
    }

    function closeIframe() {
        const modal = document.getElementById('iframeModal');
        const iframe = document.getElementById('evaluationIframe');

        // Hide modal with animation
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            iframe.src = '';

            // Allow body scrolling
            document.body.style.overflow = '';

            // Optional: reload page to reflect changes
            setTimeout(() => {
                location.reload();
            }, 100);
        }, 300);
    }

    // Close modal when clicking outside content
    document.getElementById('iframeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeIframe();
        }
    });
</script>

@endsection