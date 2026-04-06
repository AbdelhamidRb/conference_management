@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-2 sm:p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-4 sm:mb-6 text-center">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 break-words">
            <span class="text-blue-600">{{ request('acronyme') }}</span> List of Submissions
        </h1>
        <p class="mt-1 sm:mt-2 text-gray-600 text-sm sm:text-base lg:text-lg break-words">
            Explore all the submissions related to the <span class="font-semibold text-blue-600">{{ request('acronyme') }}</span> conference.
        </p>
    </div>

    @if($submissions->count() > 0)
    
    <!-- Mobile & Tablet Cards (visible on screens smaller than 1280px) -->
    <div class="block xl:hidden space-y-3 sm:space-y-4">
        @foreach($submissions as $submission)
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow border border-gray-200 hover:bg-gray-50 transition-colors">
            <!-- Header with ID and Status -->
            <div class="flex justify-between items-start mb-3">
                <span class="text-xs sm:text-sm font-medium text-gray-500 break-words">#{{ $submission->idSubmission }}</span>
                @php
                $statusClasses = match ($submission->statut) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'accepted' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-600',
                };
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClasses }} flex-shrink-0 ml-2">
                    {{ ucfirst($submission->statut) }}
                </span>
            </div>

            <!-- Title -->
            <h3 class="text-sm sm:text-base font-medium text-gray-900 mb-3 break-words leading-tight">
                {{ $submission->titre }}
            </h3>

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

            <!-- Dates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3 text-xs text-gray-500 border-t border-gray-100 pt-3">
                <div>
                    <p class="font-medium">Created:</p>
                    <p class="break-words">{{ $submission->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="font-medium">Updated:</p>
                    <p class="break-words">{{ $submission->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <!-- PDF Button -->
                <a href="{{ asset('storage/submissions/' . basename($submission->latestPdf->pdf)) }}"
                    target="_blank"
                    class="inline-flex items-center justify-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium rounded shadow transition-colors">
                    <i class="fas fa-file-pdf mr-1"></i> View PDF
                </a>

                <!-- History Button -->
                <a href="{{ route('submissions.history', ['submission' => $submission->idSubmission, 'acronyme' => $submission->conference->acronyme]) }}"
                    class="inline-flex items-center justify-center px-3 py-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 text-xs font-medium rounded shadow transition-colors">
                    <i class="fas fa-history mr-1"></i> History
                </a>

                <!-- Details Button -->
                <a href="{{ route('submissions.details', ['idSubmission' => $submission->idSubmission, 'acronyme' => $submission->conference->acronyme]) }}"
                    class="inline-flex items-center justify-center px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-medium rounded shadow transition-colors">
                    <i class="fas fa-eye mr-1"></i> Details
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Desktop Table (visible on screens 1280px and larger) -->
    <div class="hidden xl:block">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="px-3 py-3 text-left font-semibold text-sm w-1/12">ID</th>
                            <th class="px-3 py-3 text-left font-semibold text-sm w-1/4">Title</th>
                            <th class="px-3 py-3 text-left font-semibold text-sm w-1/6">Keywords</th>
                            <th class="px-3 py-3 text-center font-semibold text-sm w-1/8">Actions</th>
                            <th class="px-3 py-3 text-center font-semibold text-sm w-1/12">Status</th>
                            <th class="px-3 py-3 text-left font-semibold text-sm w-1/8">Created</th>
                            <th class="px-3 py-3 text-left font-semibold text-sm w-1/8">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition-colors">
                            <td class="border-t border-gray-200 px-3 py-4 text-gray-800 text-sm">{{ $submission->idSubmission }}</td>
                            <td class="border-t border-gray-200 px-3 py-4 text-gray-800 text-sm break-words">{{ $submission->titre }}</td>
                            <td class="border-t border-gray-200 px-3 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach(explode(',', $submission->keywords) as $keyword)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ trim($keyword) }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-4">
                                <div class="flex flex-col space-y-1 items-center">
                                    <a href="{{ asset('storage/submissions/' . basename($submission->latestPdf->pdf)) }}"
                                        target="_blank"
                                        class="inline-flex items-center px-2 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded text-xs font-medium transition-colors w-full justify-center">
                                        <i class="fas fa-file-pdf mr-1"></i> PDF
                                    </a>
                                    <a href="{{ route('submissions.history', ['submission' => $submission->idSubmission, 'acronyme' => $submission->conference->acronyme]) }}"
                                        class="inline-flex items-center px-2 py-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 rounded text-xs font-medium transition-colors w-full justify-center">
                                        <i class="fas fa-history mr-1"></i> History
                                    </a>
                                    <a href="{{ route('submissions.details', ['idSubmission' => $submission->idSubmission, 'acronyme' => $submission->conference->acronyme]) }}"
                                        class="inline-flex items-center px-2 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded text-xs font-medium transition-colors w-full justify-center">
                                        <i class="fas fa-eye mr-1"></i> Details
                                    </a>
                                </div>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-4 text-center">
                                @php
                                $statusClasses = match ($submission->statut) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'accepted' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClasses }}">
                                    {{ ucfirst($submission->statut) }}
                                </span>
                            </td>
                            <td class="border-t border-gray-200 px-3 py-4 text-gray-800 text-xs break-words">{{ $submission->created_at->format('d/m/Y H:i') }}</td>
                            <td class="border-t border-gray-200 px-3 py-4 text-gray-800 text-xs break-words">{{ $submission->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @else
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow border border-gray-200 text-center">
        <div class="flex flex-col items-center">
            <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-600 text-sm sm:text-base">There are no submissions at the moment.</p>
        </div>
    </div>
    @endif
</div>
@endsection
