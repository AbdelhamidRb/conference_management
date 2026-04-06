@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-2 sm:p-4">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 text-center">
        <div class="mx-auto flex h-10 sm:h-12 w-10 sm:w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-file-alt text-blue-600 text-lg sm:text-xl"></i>
        </div>
        <h1 class="mt-2 sm:mt-3 text-xl sm:text-2xl font-bold">My Articles to Review</h1>
        <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-600">Review the articles assigned to you</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('error'))
    <div class="mb-3 sm:mb-4 rounded-lg bg-red-100 px-4 sm:px-6 py-2 sm:py-4 text-xs sm:text-sm text-red-800 shadow-sm">
        {{ session('error') }}
    </div>
    @endif
    @if(session('success'))
    <div class="mb-3 sm:mb-4 rounded-lg bg-green-100 px-4 sm:px-6 py-2 sm:py-4 text-xs sm:text-sm text-green-800 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Mobile Cards (shown only on small screens) -->
    <div class="block lg:hidden space-y-3 sm:space-y-4">
        @forelse($evaluations as $evaluation)
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow border border-gray-200 hover:bg-gray-50">
            <!-- Title -->
            <h3 class="text-xs sm:text-sm font-medium text-gray-900 mb-1 sm:mb-2">
                {{ $evaluation->submission->titre ?? 'N/A' }}
            </h3>

            <!-- Abstract -->
            <div class="mb-2 sm:mb-3">
                <p class="text-2xs sm:text-xs text-gray-500 mb-0.5 sm:mb-1">Abstract:</p>
                <p class="text-2xs sm:text-xs text-gray-600">
                    {{ Str::limit($evaluation->submission->resume ?? 'N/A', 100) }}
                </p>
            </div>

            <!-- Keywords -->
            <div class="mb-2 sm:mb-3">
                <p class="text-2xs sm:text-xs text-gray-500 mb-0.5 sm:mb-1">Keywords:</p>
                <div class="flex flex-wrap gap-0.5 sm:gap-1">
                    @if($evaluation->submission->keywords ?? false)
                    @foreach(explode(',', $evaluation->submission->keywords) as $keyword)
                    <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 rounded-full text-3xs sm:text-2xs font-semibold bg-blue-50 text-blue-700 border border-blue-300">
                        {{ trim($keyword) }}
                    </span>
                    @endforeach
                    @else
                    <span class="text-2xs sm:text-xs text-gray-400">N/A</span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-1 sm:gap-2">
                <!-- Download Button -->
                @if($evaluation->submission->latestPdf ?? false)
                <a href="{{ Storage::url($evaluation->submission->latestPdf->pdf) }}" download
                    class="inline-flex items-center justify-center px-2 py-1 sm:py-1.5 bg-green-600 hover:bg-green-700 text-white text-2xs sm:text-xs rounded shadow">
                    <i class="fas fa-file-pdf mr-1 text-2xs sm:text-xs"></i> Download
                </a>
                @else
                <span class="inline-flex items-center justify-center px-2 py-1 sm:py-1.5 bg-gray-200 text-gray-500 text-2xs sm:text-xs rounded">
                    No document
                </span>
                @endif

                <!-- Review Button -->
                <button onclick="openIframe('{{ $evaluation->submission_id }}', '{{ $evaluation->pc_member_id }}')"
                    class="inline-flex items-center justify-center px-2 py-1 sm:py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-2xs sm:text-xs rounded shadow">
                    <i class="fas fa-edit mr-1 text-2xs sm:text-xs"></i> Review
                </button>
            </div>
        </div>
        @empty
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow border border-gray-100 text-center">
            <p class="text-2xs sm:text-xs text-gray-500">No articles to review</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop Table (hidden on small screens) -->
    <div class="hidden lg:block overflow-x-auto">
        <div class="inline-block min-w-full rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-4 py-2 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt mr-2 sm:mr-3 text-blue-500 text-xs sm:text-sm"></i>
                                Title
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-2 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-align-left mr-2 sm:mr-3 text-blue-500 text-xs sm:text-sm"></i>
                                Abstract
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-2 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-tags mr-2 sm:mr-3 text-blue-500 text-xs sm:text-sm"></i>
                                Keywords
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-2 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-file-pdf mr-2 sm:mr-3 text-blue-500 text-xs sm:text-sm"></i>
                                Document
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-2 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2 sm:mr-3 text-blue-500 text-xs sm:text-sm"></i>
                                Action
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($evaluations as $evaluation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-normal text-xs sm:text-sm text-gray-900 max-w-xs">
                            {{ $evaluation->submission->titre ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 whitespace-normal text-xs sm:text-sm text-gray-600 max-w-xs">
                            {{ Str::limit($evaluation->submission->resume ?? 'N/A', 100) }}
                        </td>
                        <td class="px-4 py-3 whitespace-normal align-top">
                            @if($evaluation->submission->keywords ?? false)
                            <div class="flex flex-wrap gap-1 sm:gap-2 text-xs sm:text-sm text-gray-600">
                                @foreach(explode(',', $evaluation->submission->keywords) as $keyword)
                                <span class="inline-flex items-center px-2 sm:px-3 py-0.5 rounded-full text-2xs sm:text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-300 shadow-sm">
                                    {{ trim($keyword) }}
                                </span>
                                @endforeach
                            </div>
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($evaluation->submission->latestPdf ?? false)
                            <a href="{{ Storage::url($evaluation->submission->latestPdf->pdf) }}" download
                                class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-medium rounded shadow transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 sm:h-4 w-3 sm:w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download
                            </a>
                            @else
                            <span class="text-gray-400 text-xs sm:text-sm">No document</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <button onclick="openIframe('{{ $evaluation->submission_id }}', '{{ $evaluation->pc_member_id }}')"
                                class="inline-flex items-center px-3 sm:px-4 py-1 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded shadow transition duration-200">
                                <i class="fas fa-edit mr-1 sm:mr-2 text-xs sm:text-sm"></i> Review
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-xs sm:text-sm text-gray-500">
                            No articles to review
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal with iframe -->
<div id="iframeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
    <div class="bg-white w-11/12 md:w-4/5 h-5/6 rounded-lg shadow-lg relative p-2 sm:p-4">
        <button onclick="closeIframe()"
            class="absolute top-2 sm:top-4 right-2 sm:right-4 bg-red-500 hover:bg-red-600 text-white px-2 sm:px-3 py-0.5 sm:py-1 rounded shadow" id="close-alert">
            Close
        </button>
        <iframe id="evaluationIframe" src="" class="w-full h-full border-0 rounded"></iframe>
    </div>
</div>

<script>
    function openIframe(submissionId, pcMemberId) {
        const modal = document.getElementById('iframeModal');
        const iframe = document.getElementById('evaluationIframe');
        iframe.src = `/evaluations/form/${submissionId}/${pcMemberId}`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeIframe() {
        const modal = document.getElementById('iframeModal');
        const iframe = document.getElementById('evaluationIframe');
        iframe.src = '';
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';

        // Optional: reload after closing if needed
        setTimeout(function() {
            location.reload();
        }, 10);
    }
</script>

@endsection