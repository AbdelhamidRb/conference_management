@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-2 sm:p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-4 sm:mb-6 text-center">
        <div class="mx-auto flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-users text-blue-600 text-lg sm:text-xl"></i>
        </div>
        <h1 class="mt-2 sm:mt-3 text-lg sm:text-xl font-bold">PC Members</h1>
        <p class="mt-1 text-xs sm:text-sm text-gray-600">Manage conference committee members</p>
    </div>

    @if ($pcMembers->isNotEmpty())
    <!-- Mobile & Tablet Cards (visible on small and medium screens) -->
    <div class="block xl:hidden space-y-3">
        @foreach($pcMembers as $pcMember)
        <div class="bg-white p-3 sm:p-4 rounded-lg shadow border border-gray-100 {{ $pcMember->role === 'chair' ? 'bg-blue-50' : '' }}">
            <!-- Header Row -->
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 min-w-0 pr-2">
                    <h3 class="font-medium text-gray-900 text-sm sm:text-base break-words">
                        {{ $pcMember->user['firstName'] ?? 'N/A' }} {{ $pcMember->user['lastName'] ?? '' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1 break-all">{{ $pcMember->user['email'] ?? 'N/A' }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded-full ml-2 flex-shrink-0 whitespace-nowrap
                    {{ $pcMember->role === 'chair' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($pcMember->role ?? 'N/A') }}
                </span>
            </div>

            <!-- Status and Last Activity Row -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                <div class="flex-shrink-0">
                    @if ($pcMember->statut === 'accepted')
                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                        <i class="fas fa-check-circle mr-1 text-green-600 text-xs"></i> Accepted
                    </span>
                    @elseif ($pcMember->statut === 'declined')
                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                        <i class="fas fa-times-circle mr-1 text-red-600 text-xs"></i> Declined
                    </span>
                    @else
                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                        <i class="fas fa-hourglass-half mr-1 text-yellow-600 text-xs"></i> Pending
                    </span>
                    @endif
                </div>
                <span class="text-xs text-gray-500 break-words">
                    Last: {{ $pcMember->user->last_activity ?? 'Never' }}
                </span>
            </div>

            <!-- Action Row -->
            <div class="text-right border-t border-gray-100 pt-2">
                <a href="/userInformation?acronyme={{$pcMember->conference->acronyme}}&user={{$pcMember->user->id}}"
                    class="inline-flex items-center text-xs sm:text-sm text-blue-600 hover:text-blue-800">
                    <i class="fas fa-search mr-1"></i> View Details
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Desktop Table (visible on extra large screens only) -->
    <div class="hidden xl:block mt-6">
        <div class="rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/6">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2 text-blue-500"></i>
                                First Name
                            </div>
                        </th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/6">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2 text-blue-500"></i>
                                Last Name
                            </div>
                        </th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/4">
                            <div class="flex items-center">
                                <i class="fas fa-envelope mr-2 text-blue-500"></i>
                                Email
                            </div>
                        </th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/8">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2 text-blue-500"></i>
                                Role
                            </div>
                        </th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2 text-blue-500"></i>
                                Status
                            </div>
                        </th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/8">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Last Visit
                            </div>
                        </th>
                        <th scope="col" class="px-3 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider w-1/12">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                Info
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pcMembers as $pcMember)
                    <tr class="hover:bg-gray-100 transition-colors duration-150 {{ $pcMember->role === 'chair' ? 'bg-gray-200' : 'bg-gray-50' }}">
                        <td class="px-3 py-4 font-medium text-gray-900 text-sm break-words">
                            {{ $pcMember->user['firstName'] ?? 'N/A' }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-900 break-words">
                            {{ $pcMember->user['lastName'] ?? 'N/A' }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-600 break-all">
                            {{ $pcMember->user['email'] ?? 'N/A' }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-600">
                            {{ $pcMember->role ?? 'N/A' }}
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-600">
                            @if ($pcMember->statut === 'accepted')
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                <i class="fas fa-check-circle mr-1 text-green-600"></i> Accepted
                            </span>
                            @elseif ($pcMember->statut === 'declined')
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                <i class="fas fa-times-circle mr-1 text-red-600"></i> Declined
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                <i class="fas fa-hourglass-half mr-1 text-yellow-600"></i> Pending
                            </span>
                            @endif
                        </td>
                        <td class="px-3 py-4 text-xs text-gray-600 break-words">
                            {{ $pcMember->user->last_activity ?? 'N/A' }}
                        </td>
                        <td class="px-3 py-4 text-center">
                            <a href="/userInformation?acronyme={{$pcMember->conference->acronyme}}&user={{$pcMember->user->id}}"
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="rounded-lg bg-white p-4 sm:p-6 shadow-lg ring-1 ring-gray-200/50 mt-4 sm:mt-6">
        <p class="text-gray-700 text-sm">No PC Members are currently associated with this conference.</p>
    </div>
    @endif
</div>
@endsection