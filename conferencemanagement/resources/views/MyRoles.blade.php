@extends('layouts.app')

@section('title', 'FSTconference 2024 - Conference Management System')

@section('content')

<!-- Roles Table Section -->
<div class="container mx-auto px-4 md:px-6 py-12">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 mb-10">
        <h2 class="text-2xl text-center font-semibold text-blue-600 mb-6">My Roles</h2>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 dark:border-gray-700">
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
@endsection