@extends('layouts.app')

@section('title', 'Conference Details - Conference Management System')

@section('content')
@php
use App\Models\Conference;
use Carbon\Carbon;

$acronyme = request('acronyme');
$data = Conference::where('acronyme', $acronyme)->first();

// Si la conférence n'existe pas, renvoyer une erreur 404
if (!$data) {
abort(404);
}
@endphp

<!-- Mobile Layout (< 768px) -->
<div class="block md:hidden min-h-screen bg-gray-50">
    <div class="px-4 py-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-6 mb-6 text-white">
            <div class="text-center">
                <h1 class="text-xl font-bold mb-2">{{ $data->title }}</h1>
                <div class="inline-flex items-center bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium mb-3">
                    {{ $data->acronyme }}
                </div>
                <div class="flex items-center justify-center text-blue-100 text-sm">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span>{{ $data->city }}, {{ $data->country }}</span>
                </div>
            </div>
        </div>

        <!-- Important Dates Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                Important Dates
            </h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <div>
                        <p class="text-xs text-green-600 font-medium">Conference Start</p>
                        <p class="text-sm font-semibold text-green-800">{{ $data->firstDay }}</p>
                    </div>
                    <i class="fas fa-play text-green-600"></i>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <div>
                        <p class="text-xs text-red-600 font-medium">Conference End</p>
                        <p class="text-sm font-semibold text-red-800">{{ $data->lastDay }}</p>
                    </div>
                    <i class="fas fa-stop text-red-600"></i>
                </div>
                <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                    <div>
                        <p class="text-xs text-orange-600 font-medium">Submission Deadline</p>
                        <p class="text-sm font-semibold text-orange-800">{{ $data->submissionDeadLine }}</p>
                    </div>
                    <i class="fas fa-clock text-orange-600"></i>
                </div>
            </div>
        </div>

        <!-- Venue Information Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-building mr-2 text-blue-600"></i>
                Venue Information
            </h2>
            <div class="space-y-3">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-map-marker-alt text-gray-400 mt-1"></i>
                    <div>
                        <p class="text-xs text-gray-500">Venue</p>
                        <p class="text-sm font-medium text-gray-900">{{ $data->venue }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <i class="fas fa-globe text-gray-400 mt-1"></i>
                    <div>
                        <p class="text-xs text-gray-500">Location</p>
                        <p class="text-sm font-medium text-gray-900">{{ $data->city }}, {{ $data->country }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Research Areas Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-flask mr-2 text-blue-600"></i>
                Research Areas
            </h2>
            <div class="space-y-3">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-600 font-medium">Primary Area</p>
                    <p class="text-sm font-semibold text-blue-800">{{ $data->primaryArea }}</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-lg">
                    <p class="text-xs text-purple-600 font-medium">Secondary Area</p>
                    <p class="text-sm font-semibold text-purple-800">{{ $data->secondaryArea }}</p>
                </div>
            </div>
        </div>

        <!-- Organizer Information Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user-tie mr-2 text-blue-600"></i>
                Organizer
            </h2>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $data->organizer }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $data->organizerEmail }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-phone text-gray-400 text-xs"></i>
                        <span class="text-sm text-gray-600">{{ $data->organizerPhoneNumber }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-globe text-gray-400 text-xs"></i>
                        <a href="{{ $data->organizerWebPage }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 truncate">
                            {{ $data->organizerWebPage }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Links Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-link mr-2 text-blue-600"></i>
                Important Links
            </h2>
            <div class="space-y-3">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500 mb-1">Conference Website</p>
                    <a href="{{ $data->conferenceWebPage }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium break-all">
                        {{ $data->conferenceWebPage }}
                    </a>
                </div>

                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500 mb-1">Submission Portal</p>
                    @php

                    $deadline = Carbon::parse($data->submissionDeadLine);
                    @endphp

                    @if ($deadline->isBefore(now()))
                    <div class="text-sm text-red-600 font-semibold bg-red-100 p-2 rounded">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Submission closed since {{ $deadline->format('M j, Y') }}
                    </div>
                    @else
                    @if(!$data->configuration->submissionAllowed)
                    <div class="text-sm text-red-600 font-semibold bg-red-100 p-2 rounded">
                        <i class="fas fa-ban mr-1"></i>
                        Submission not allowed
                    </div>
                    @else
                    <a href="{{ $data->submissionLink }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium break-all">
                        {{ $data->submissionLink }}
                    </a>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tablet Layout (768px to 1024px) -->
<div class="hidden md:block lg:hidden min-h-screen bg-gray-50 py-6">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-12 gap-6">
            <!-- Sidebar -->
            <div class="col-span-4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-6">
                    <!-- Conference Header -->
                    <div class="text-center mb-6">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 mb-3">
                            <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                        </div>
                        <h1 class="text-lg font-bold text-gray-900 mb-2">{{ $data->acronyme }}</h1>
                        <p class="text-sm text-gray-600">Conference Details</p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <h3 class="text-sm font-medium text-blue-900 mb-3">Quick Info</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs">
                                <span class="text-blue-600">Location</span>
                                <span class="font-medium text-blue-800">{{ $data->city }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-blue-600">Duration</span>
                                <span class="font-medium text-blue-800">
                                    {{ \Carbon\Carbon::parse($data->firstDay)->diffInDays(\Carbon\Carbon::parse($data->lastDay)) + 1 }} days
                                </span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-blue-600">Organizer</span>
                                <span class="font-medium text-blue-800 truncate">{{ explode(' ', $data->organizer)[0] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="space-y-2">
                        <a href="#dates" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>
                            Important Dates
                        </a>
                        <a href="#venue" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-building mr-2 text-blue-600"></i>
                            Venue Information
                        </a>
                        <a href="#research" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-flask mr-2 text-blue-600"></i>
                            Research Areas
                        </a>
                        <a href="#organizer" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-user-tie mr-2 text-blue-600"></i>
                            Organizer Details
                        </a>
                        <a href="#links" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-link mr-2 text-blue-600"></i>
                            Important Links
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-8">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-6 mb-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold mb-2">{{ $data->title }}</h1>
                            <div class="flex items-center text-blue-100">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $data->city }}, {{ $data->country }}</span>
                            </div>
                        </div>
                        <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium">
                            {{ $data->acronyme }}
                        </span>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Important Dates -->
                    <div id="dates" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-calendar-alt mr-3 text-blue-600"></i>
                            Important Dates
                        </h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <p class="text-sm text-green-600 font-medium">Conference Start</p>
                                <p class="text-lg font-bold text-green-800">{{ $data->firstDay }}</p>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                <p class="text-sm text-red-600 font-medium">Conference End</p>
                                <p class="text-lg font-bold text-red-800">{{ $data->lastDay }}</p>
                            </div>
                            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                <p class="text-sm text-orange-600 font-medium">Submission Deadline</p>
                                <p class="text-lg font-bold text-orange-800">{{ $data->submissionDeadLine }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Venue Information -->
                    <div id="venue" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-building mr-3 text-blue-600"></i>
                            Venue Information
                        </h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Venue</p>
                                <p class="text-lg font-medium text-gray-900">{{ $data->venue }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Location</p>
                                <p class="text-lg font-medium text-gray-900">{{ $data->city }}, {{ $data->country }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Research Areas -->
                    <div id="research" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-flask mr-3 text-blue-600"></i>
                            Research Areas
                        </h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <p class="text-sm text-blue-600 font-medium mb-1">Primary Area</p>
                                <p class="text-lg font-semibold text-blue-800">{{ $data->primaryArea }}</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <p class="text-sm text-purple-600 font-medium mb-1">Secondary Area</p>
                                <p class="text-lg font-semibold text-purple-800">{{ $data->secondaryArea }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Organizer Information -->
                    <div id="organizer" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user-tie mr-3 text-blue-600"></i>
                            Organizer Details
                        </h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 mb-1">Name</p>
                                    <p class="text-lg font-medium text-gray-900">{{ $data->organizer }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 mb-1">Phone</p>
                                    <p class="text-lg font-medium text-gray-900">{{ $data->organizerPhoneNumber }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 mb-1">Email</p>
                                    <a href="mailto:{{ $data->organizerEmail }}" class="text-lg font-medium text-blue-600 hover:text-blue-800 break-all">
                                        {{ $data->organizerEmail }}
                                    </a>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 mb-1">Website</p>
                                    <a href="{{ $data->organizerWebPage }}" target="_blank" class="text-lg font-medium text-blue-600 hover:text-blue-800 break-all">
                                        {{ $data->organizerWebPage }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Links -->
                    <div id="links" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-link mr-3 text-blue-600"></i>
                            Important Links
                        </h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-2">Conference Website</p>
                                <a href="{{ $data->conferenceWebPage }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium break-all">
                                    {{ $data->conferenceWebPage }}
                                </a>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-2">Submission Portal</p>
                                @php
                                $deadline = Carbon::parse($data->submissionDeadLine);
                                @endphp

                                @if ($deadline->isBefore(now()))
                                <div class="text-sm text-red-600 font-semibold bg-red-100 p-3 rounded">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    Submission closed since {{ $deadline->format('F j, Y') }}
                                </div>
                                @else
                                @if(!$data->configuration->submissionAllowed)
                                <div class="text-sm text-red-600 font-semibold bg-red-100 p-3 rounded">
                                    <i class="fas fa-ban mr-2"></i>
                                    Submission not allowed for this conference
                                </div>
                                @else
                                <a href="{{ $data->submissionLink }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium break-all">
                                    {{ $data->submissionLink }}
                                </a>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Desktop Layout (≥ 1024px) -->
<div class="hidden lg:block min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-8">
        <div class="grid grid-cols-12 gap-8">
            <!-- Extended Sidebar -->
            <div class="col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-8">
                    <!-- Conference Header -->
                    <div class="text-center mb-8">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 mb-4">
                            <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $data->acronyme }}</h1>
                        <p class="text-sm text-gray-600">Conference Information Portal</p>
                    </div>

                    <!-- Conference Summary -->
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <h3 class="text-sm font-medium text-blue-900 mb-4">Conference Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-xs">
                                <span class="text-blue-600">Location</span>
                                <span class="font-medium text-blue-800">{{ $data->city }}, {{ $data->country }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-blue-600">Duration</span>
                                <span class="font-medium text-blue-800">
                                    {{ \Carbon\Carbon::parse($data->firstDay)->diffInDays(\Carbon\Carbon::parse($data->lastDay)) + 1 }} days
                                </span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-blue-600">Venue</span>
                                <span class="font-medium text-blue-800 truncate">{{ $data->venue }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-blue-600">Organizer</span>
                                <span class="font-medium text-blue-800 truncate">{{ explode(' ', $data->organizer)[0] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="space-y-2 mb-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Quick Navigation</h4>
                        <a href="#dates" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-calendar mr-3 text-blue-600 w-4"></i>
                            Important Dates
                        </a>
                        <a href="#venue" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-building mr-3 text-blue-600 w-4"></i>
                            Venue Information
                        </a>
                        <a href="#research" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-flask mr-3 text-blue-600 w-4"></i>
                            Research Areas
                        </a>
                        <a href="#organizer" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-user-tie mr-3 text-blue-600 w-4"></i>
                            Organizer Details
                        </a>
                        <a href="#links" class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-link mr-3 text-blue-600 w-4"></i>
                            Important Links
                        </a>
                    </div>

                    <!-- Key Deadlines -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-clock mr-2 text-orange-600"></i>
                            Key Deadlines
                        </h4>
                        <div class="space-y-2">
                            <div class="text-xs">
                                <span class="text-gray-600">Submission:</span>
                                <span class="font-medium text-gray-900 block">{{ $data->submissionDeadLine }}</span>
                            </div>
                            <div class="text-xs">
                                <span class="text-gray-600">Conference:</span>
                                <span class="font-medium text-gray-900 block">{{ $data->firstDay }} - {{ $data->lastDay }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-9">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-8 mb-8 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold mb-3">{{ $data->title }}</h1>
                            <div class="flex items-center text-blue-100 text-lg">
                                <i class="fas fa-map-marker-alt mr-3"></i>
                                <span>{{ $data->city }}, {{ $data->country }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="bg-white/20 text-white px-6 py-3 rounded-full text-lg font-medium">
                                {{ $data->acronyme }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Important Dates -->
                    <div id="dates" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-calendar-alt mr-4 text-blue-600"></i>
                            Important Dates
                        </h2>
                        <div class="grid grid-cols-3 gap-6">
                            <div class="bg-green-50 p-6 rounded-lg border border-green-200 text-center">
                                <i class="fas fa-play text-green-600 text-2xl mb-3"></i>
                                <p class="text-sm text-green-600 font-medium mb-2">Conference Start</p>
                                <p class="text-xl font-bold text-green-800">{{ $data->firstDay }}</p>
                            </div>
                            <div class="bg-red-50 p-6 rounded-lg border border-red-200 text-center">
                                <i class="fas fa-stop text-red-600 text-2xl mb-3"></i>
                                <p class="text-sm text-red-600 font-medium mb-2">Conference End</p>
                                <p class="text-xl font-bold text-red-800">{{ $data->lastDay }}</p>
                            </div>
                            <div class="bg-orange-50 p-6 rounded-lg border border-orange-200 text-center">
                                <i class="fas fa-clock text-orange-600 text-2xl mb-3"></i>
                                <p class="text-sm text-orange-600 font-medium mb-2">Submission Deadline</p>
                                <p class="text-xl font-bold text-orange-800">{{ $data->submissionDeadLine }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Venue Information -->
                    <div id="venue" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-building mr-4 text-blue-600"></i>
                            Venue Information
                        </h2>
                        <div class="grid grid-cols-2 gap-8">
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-xl mr-3"></i>
                                    <h3 class="text-lg font-semibold text-gray-900">Venue</h3>
                                </div>
                                <p class="text-xl font-medium text-gray-900">{{ $data->venue }}</p>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-globe text-gray-400 text-xl mr-3"></i>
                                    <h3 class="text-lg font-semibold text-gray-900">Location</h3>
                                </div>
                                <p class="text-xl font-medium text-gray-900">{{ $data->city }}, {{ $data->country }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Research Areas -->
                    <div id="research" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-flask mr-4 text-blue-600"></i>
                            Research Areas
                        </h2>
                        <div class="grid grid-cols-2 gap-8">
                            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-star text-blue-600 text-xl mr-3"></i>
                                    <h3 class="text-lg font-semibold text-blue-900">Primary Area</h3>
                                </div>
                                <p class="text-xl font-medium text-blue-800">{{ $data->primaryArea }}</p>
                            </div>
                            <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-plus text-purple-600 text-xl mr-3"></i>
                                    <h3 class="text-lg font-semibold text-purple-900">Secondary Area</h3>
                                </div>
                                <p class="text-xl font-medium text-purple-800">{{ $data->secondaryArea }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Organizer Information -->
                    <div id="organizer" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user-tie mr-4 text-blue-600"></i>
                            Organizer Details
                        </h2>
                        <div class="grid grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-user text-gray-400 text-lg mr-3"></i>
                                        <h3 class="text-sm font-medium text-gray-500">Name</h3>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900">{{ $data->organizer }}</p>
                                </div>
                                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-phone text-gray-400 text-lg mr-3"></i>
                                        <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900">{{ $data->organizerPhoneNumber }}</p>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-envelope text-gray-400 text-lg mr-3"></i>
                                        <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                    </div>
                                    <a href="mailto:{{ $data->organizerEmail }}" class="text-lg font-semibold text-blue-600 hover:text-blue-800 break-all">
                                        {{ $data->organizerEmail }}
                                    </a>
                                </div>
                                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <i class="fas fa-globe text-gray-400 text-lg mr-3"></i>
                                        <h3 class="text-sm font-medium text-gray-500">Website</h3>
                                    </div>
                                    <a href="{{ $data->organizerWebPage }}" target="_blank" class="text-lg font-semibold text-blue-600 hover:text-blue-800 break-all">
                                        {{ $data->organizerWebPage }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Links -->
                    <div id="links" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-link mr-4 text-blue-600"></i>
                            Important Links
                        </h2>
                        <div class="grid grid-cols-2 gap-8">
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-globe text-gray-400 text-xl mr-3"></i>
                                    <h3 class="text-lg font-semibold text-gray-900">Conference Website</h3>
                                </div>
                                <a href="{{ $data->conferenceWebPage }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium break-all text-lg">
                                    {{ $data->conferenceWebPage }}
                                </a>
                                <p class="text-sm text-gray-500 mt-2">Official conference information and updates</p>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-upload text-gray-400 text-xl mr-3"></i>
                                    <h3 class="text-lg font-semibold text-gray-900">Submission Portal</h3>
                                </div>
                                @php
                                $deadline = Carbon::parse($data->submissionDeadLine);
                                @endphp

                                @if ($deadline->isBefore(now()))
                                <div class="text-red-600 font-semibold bg-red-100 p-4 rounded-lg">
                                    <i class="fas fa-exclamation-circle mr-2 text-lg"></i>
                                    <span class="text-lg">Submission closed since {{ $deadline->format('F j, Y') }}</span>
                                </div>
                                @else
                                @if(!$data->configuration->submissionAllowed)
                                <div class="text-red-600 font-semibold bg-red-100 p-4 rounded-lg">
                                    <i class="fas fa-ban mr-2 text-lg"></i>
                                    <span class="text-lg">Submission not allowed for this conference</span>
                                </div>
                                @else
                                <a href="{{ $data->submissionLink }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium break-all text-lg">
                                    {{ $data->submissionLink }}
                                </a>
                                <p class="text-sm text-gray-500 mt-2">Submit your research papers and abstracts</p>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth scrolling for anchor links */
    html {
        scroll-behavior: smooth;
    }

    /* Custom focus styles */
    a:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    /* Hover effects */
    .hover\:bg-gray-100:hover {
        background-color: #f3f4f6;
    }

    /* Responsive text truncation */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // Smooth scrolling for navigation links
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('a[href^="#"]');

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>

@endsection