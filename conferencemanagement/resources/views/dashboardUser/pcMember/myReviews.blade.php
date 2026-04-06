@extends('dashboardUser.pcMember.dashboardPcMember')

@section('content1')
<div class="min-h-screen bg-gray-50 p-4">
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
        </div>
        <h1 class="mt-3 text-2xl font-bold">My Reviews</h1>
        <p class="mt-2 text-sm text-gray-600">Manage your article reviews for {{ request('acronyme') }}</p>
    </div>

    <!-- Mobile View (Cards) - jusqu'à 640px -->
    <div class="block sm:hidden space-y-4">
        @forelse($reviews as $review)
        <div class="bg-white p-4 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
            <!-- Submission ID & Title -->
            <div class="mb-3">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-gray-500 font-medium">ID: {{ $review->submission_id }}</span>
                    @if($review->latestVersion->decision ?? false)
                    <span class="px-2 py-1 rounded-full text-xs font-medium border 
                        {{ $review->latestVersion->decision == 'accepted' ? 'bg-green-50 text-green-700 border-green-200' : 
                           ($review->latestVersion->decision == 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : 
                           'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                        {{ ucfirst($review->latestVersion->decision) }}
                    </span>
                    @endif
                </div>
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $review->submission->titre ?? 'N/A' }}
                </h3>
            </div>

            <!-- Remarks -->
            <div class="mb-4">
                <p class="text-xs text-gray-500 mb-1 font-medium">Remarks:</p>
                <p class="text-sm text-gray-600 line-clamp-3">
                    {{ $review->latestVersion->remarque ?? 'N/A' }}
                </p>
            </div>

            <!-- Action Button -->
            <div class="flex justify-end">
                <button onclick="openReviewIframe('{{ $review->id }}')"
                    class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow transition-colors">
                    <i class="fas fa-edit mr-2"></i> Update Review
                </button>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100 text-center">
            <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">No reviews found</p>
        </div>
        @endforelse
    </div>

    <!-- Tablet View (Compact Cards) - 640px à 1024px -->
    <div class="hidden sm:block lg:hidden space-y-4">
        @forelse($reviews as $review)
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Left Column - Article Info -->
                <div class="md:col-span-2 space-y-3">
                    <!-- Header with ID and Decision -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 font-medium">
                            <i class="fas fa-id-card mr-1"></i>
                            ID: {{ $review->submission_id }}
                        </span>
                        @if($review->latestVersion->decision ?? false)
                        <span class="px-3 py-1 rounded-full text-xs font-medium border 
                            {{ $review->latestVersion->decision == 'accepted' ? 'bg-green-50 text-green-700 border-green-200' : 
                               ($review->latestVersion->decision == 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : 
                               'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                            {{ ucfirst($review->latestVersion->decision) }}
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-500 border border-gray-200">
                            No Decision
                        </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ $review->submission->titre ?? 'N/A' }}
                        </h3>
                    </div>

                    <!-- Remarks -->
                    <div>
                        <p class="text-xs text-gray-500 mb-1 font-medium">
                            <i class="fas fa-comment mr-1"></i>
                            Remarks:
                        </p>
                        <p class="text-sm text-gray-600 line-clamp-4">
                            {{ $review->latestVersion->remarque ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <!-- Right Column - Actions -->
                <div class="flex flex-col justify-center">
                    <button onclick="openReviewIframe('{{ $review->id }}')"
                        class="inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow transition duration-200 w-full">
                        <i class="fas fa-edit mr-2"></i>
                        Update Review
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100 text-center">
            <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">No reviews found</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop View (Table) - 1024px et plus -->
    <div class="hidden lg:block overflow-hidden rounded-lg border border-gray-200 shadow-sm mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[120px]">
                            <div class="flex items-center">
                                <i class="fas fa-id-card mr-2 text-blue-500"></i>
                                ID
                            </div>
                        </th>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[200px]">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                                Title
                            </div>
                        </th>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[250px]">
                            <div class="flex items-center">
                                <i class="fas fa-comment mr-2 text-blue-500"></i>
                                Remarks
                            </div>
                        </th>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[120px]">
                            <div class="flex items-center">
                                <i class="fas fa-gavel mr-2 text-blue-500"></i>
                                Decision
                            </div>
                        </th>
                        <th class="px-4 xl:px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider min-w-[120px]">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-2 text-blue-500"></i>
                                Actions
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 xl:px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $review->submission_id }}
                        </td>
                        <td class="px-4 xl:px-6 py-4 text-sm text-gray-900">
                            <div class="font-medium">
                                {{ $review->submission->titre ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 xl:px-6 py-4 text-sm text-gray-600">
                            <div class="max-w-xs xl:max-w-sm">
                                <div class="line-clamp-3">
                                    {{ $review->latestVersion->remarque ?? 'N/A' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-4 xl:px-6 py-4 whitespace-nowrap">
                            @if($review->latestVersion->decision ?? false)
                            <span class="px-3 py-1 rounded-full text-xs font-medium border 
                                {{ $review->latestVersion->decision == 'accepted' ? 'bg-green-50 text-green-700 border-green-200' : 
                                   ($review->latestVersion->decision == 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : 
                                   'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                                {{ ucfirst($review->latestVersion->decision) }}
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-500 border border-gray-200">
                                No Decision
                            </span>
                            @endif
                        </td>
                        <td class="px-4 xl:px-6 py-4 whitespace-nowrap">
                            <button onclick="openReviewIframe('{{ $review->id }}')"
                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded shadow transition duration-200">
                                <i class="fas fa-edit mr-1"></i>
                                <span class="hidden xl:inline">Update</span>
                                <span class="xl:hidden">Edit</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-6">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
                                <p>No reviews found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Iframe Modal -->
<div id="reviewIframeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white w-full max-w-6xl h-[90vh] rounded-lg shadow-xl relative flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-semibold">Update Review</h3>
            <button onclick="closeReviewIframe()"
                class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Iframe Container -->
        <div class="flex-1 overflow-hidden">
            <iframe id="reviewFrame" src="" class="w-full h-full border-0"></iframe>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 px-6 py-3 bg-gray-50 flex justify-end">
            <button onclick="closeReviewIframe()"
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
    function openReviewIframe(reviewId) {
        const modal = document.getElementById('reviewIframeModal');
        const iframe = document.getElementById('reviewFrame');

        // Set the iframe source using your route structure
        iframe.src = `/{{ request('acronyme') }}/evaluations/${reviewId}/edit`;

        // Show modal with animation
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 10);

        // Prevent body scrolling
        document.body.style.overflow = 'hidden';
    }

    function closeReviewIframe() {
        const modal = document.getElementById('reviewIframeModal');
        const iframe = document.getElementById('reviewFrame');

        // Hide modal with animation
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            iframe.src = '';

            // Allow body scrolling
            document.body.style.overflow = '';

            // Reload after closing to see any updates
            setTimeout(() => {
                location.reload();
            }, 100);
        }, 300);
    }

    // Close modal when clicking outside content
    document.getElementById('reviewIframeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReviewIframe();
        }
    });
</script>
@endsection