@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-2 sm:p-4 lg:p-6">
    <div class="mb-6 sm:mb-8 text-center">
        <div class="mx-auto flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-tasks text-blue-600 text-lg sm:text-xl"></i>
        </div>
        <h1 class="mt-2 sm:mt-3 text-xl sm:text-2xl font-bold">
            <span class="text-blue-600">Article Assignments</span>
        </h1>
        <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-600">
            View all article assignments for <span class="font-semibold text-blue-600">{{ request('acronyme') }}</span>
        </p>
    </div>

    <div class="rounded-lg border border-gray-200 shadow-sm mt-4 sm:mt-6">
        @if($assignments->count() > 0)

        <!-- Mobile & Tablet Cards (visible on screens smaller than 1280px) -->
        <div class="block xl:hidden space-y-3 p-3 sm:p-4">
            @foreach($assignments as $assignment)
            <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm hover:bg-gray-50 transition-colors">
                <!-- Header with ID and Status -->
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1 min-w-0 pr-2">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs text-gray-500">ID:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $assignment->idSubmission }}</span>
                        </div>
                        <h3 class="text-sm sm:text-base font-medium text-gray-900 break-words leading-tight">
                            {{ $assignment->titre }}
                        </h3>
                    </div>

                    @php
                    $statusClass = match($assignment->statut) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'accepted' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                    };
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-medium flex-shrink-0 {{ $statusClass }}">
                        {{ ucfirst($assignment->statut) }}
                    </span>
                </div>

                <!-- PDF Link -->
                <div class="mb-3">
                    <a href="{{ asset('storage/' . $assignment->latestPdf->pdf) }}"
                        target="_blank"
                        class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium shadow-sm hover:bg-blue-100 transition-colors">
                        <i class="fas fa-file-pdf mr-1"></i> View PDF
                    </a>
                </div>

                <!-- Assigned PC Members -->
                <div class="border-t border-gray-100 pt-3">
                    <p class="text-xs text-gray-500 mb-2">Assigned PC Members:</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach($assignment->evaluations as $evaluation)
                        @php
                        $badgeColor = match($evaluation->decision) {
                        'accepted' => 'bg-green-50 text-green-700 border-green-200',
                        'rejected' => 'bg-red-50 text-red-700 border-red-200',
                        'borderline' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        default => 'bg-blue-50 text-blue-700 border-blue-200'
                        };
                        @endphp
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $badgeColor }}">
                            <span class="break-words">{{ $evaluation->pcMember->user->firstName }} {{ $evaluation->pcMember->user->lastName }}</span>
                            @if($evaluation->decision)
                            <span class="ml-1 text-xs">({{ substr(ucfirst($evaluation->decision), 0, 1) }})</span>
                            @endif
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop Table (visible on screens 1280px and larger) -->
        <div class="hidden xl:block">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/12">
                            <div class="flex items-center">
                                <i class="fas fa-id-card mr-2 text-blue-500"></i>
                                ID
                            </div>
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/3">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                                Title
                            </div>
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/12">
                            <div class="flex items-center">
                                <i class="fas fa-file-pdf mr-2 text-blue-500"></i>
                                PDF
                            </div>
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-5/12">
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2 text-blue-500"></i>
                                Assigned PC Members
                            </div>
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/12">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Status
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($assignments as $assignment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-4 text-sm text-gray-900">{{ $assignment->idSubmission }}</td>
                        <td class="px-3 py-4 text-sm text-gray-900 break-words">{{ $assignment->titre }}</td>
                        <td class="px-3 py-4">
                            <a href="{{ asset('storage/' . $assignment->latestPdf->pdf) }}"
                                target="_blank"
                                class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium shadow-sm hover:bg-blue-100 transition-colors">
                                <i class="fas fa-file-pdf mr-1"></i> PDF
                            </a>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($assignment->evaluations as $evaluation)
                                @php
                                $badgeColor = match($evaluation->decision) {
                                'accepted' => 'bg-green-100 text-green-800 border-green-200',
                                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                'borderline' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                default => 'bg-blue-100 text-blue-800 border-blue-200'
                                };
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border shadow-sm {{ $badgeColor }}">
                                    <span class="break-words">{{ $evaluation->pcMember->user->firstName }} {{ $evaluation->pcMember->user->lastName }}</span>
                                    @if($evaluation->decision)
                                    <span class="ml-1 text-xs">({{ ucfirst($evaluation->decision) }})</span>
                                    @endif
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-3 py-4">
                            @php
                            $statusClass = match($assignment->statut) {
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'accepted' => 'bg-green-100 text-green-800 border-green-200',
                            'rejected' => 'bg-red-100 text-red-800 border-red-200',
                            default => 'bg-gray-100 text-gray-800 border-gray-200',
                            };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium border shadow-sm {{ $statusClass }}">
                                {{ ucfirst($assignment->statut) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
        <div class="px-4 sm:px-6 py-6 sm:py-8 text-center text-sm text-gray-500">
            No assignments found
        </div>
        @endif
    </div>
</div>
@endsection