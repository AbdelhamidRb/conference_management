@extends('layouts.app')

@section('title', 'FSTconference 2024 - Conference Management System')

@section('content')
<div class="flex min-h-screen flex-col items-center justify-start bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl">
        <!-- Header with user greeting -->
        @if (session('success'))
        <div class="rounded-md bg-green-200 border-green-200 dark:bg-green-900/30 p-4 mt-4 mb-2">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 mt-1"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
            @php session()->forget('success') @endphp
        </div>
        @elseif (session('error'))
        <div class="rounded-md bg-red-200 border-red-200 dark:bg-red-900/30 p-4 mt-4 mb-2">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
            @php session()->forget('error') @endphp
        </div>
        @endif
        <div class="mb-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <i class="fas fa-user-tie text-blue-600 text-xl"></i>
            </div>
            <h1 class="mt-3 text-2xl font-bold text-gray-900">
                Hello, {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
            </h1>
            <p class="mt-2 text-sm text-gray-600 ">Your recent roles in the conference management system</p>
        </div>

        <!-- Table card -->
        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200/50 text-center">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Your Recent Roles</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-hashtag mr-2"></i>
                                    Acronym
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-user-tag mr-2"></i>
                                    Roles
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $acronyme => $userConferences)
                        @php
                        $currentUserId = auth()->id();
                        $rolesToDisplay = [];
                        $hasChair = false;
                        $hasPcMember = false;
                        $hasAuthor = false;

                        // First pass: Check all conferences for roles
                        foreach ($userConferences as $uc) {
                        // Check for chair/pc member
                        if ($uc->role === 'chair') {
                        $hasChair = true;
                        } elseif ($uc->role === 'pc member') {
                        $hasPcMember = true;
                        }

                        // Check for author status
                        $isMainAuthor = $uc->conference->submissions->contains(function ($submission) use ($currentUserId) {
                        return $submission->auteur_id == $currentUserId;
                        });

                        if ($isMainAuthor) {
                        $hasAuthor = true;
                        }
                        }

                        // Apply role priority rules
                        if ($hasChair) {
                        $rolesToDisplay[] = 'chair';
                        } elseif ($hasPcMember) {
                        $rolesToDisplay[] = 'pc member';
                        }

                        // Add author if found (independent of other roles)
                        if ($hasAuthor) {
                        $rolesToDisplay[] = 'auteur';
                        }

                        @endphp

                        @if(count($rolesToDisplay) > 0)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="conferenceDetails?acronyme={{ $acronyme }}" class="text-blue-600 hover:text-blue-800 underline focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    {{ $acronyme }}
                                </a>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                @foreach($rolesToDisplay as $role)
                                <a href="userDashboard?acronyme={{ $acronyme }}&role={{ $role }}"
                                    class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-lg mr-2 underline hover:underline-offset-4 decoration-blue-600 transition-all duration-200">
                                    {{ $role }}
                                </a>
                                @endforeach
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                                No roles assigned yet.
                            </td>
                        </tr>
                        @endif

                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                                No roles assigned yet.
                            </td>
                        </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection