@extends('layouts.app')

@section('title', 'All Pending Invitations')

@section('content')
<div class="flex min-h-screen flex-col items-center justify-start bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-5xl">


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
        @elseif (session('warning'))
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
        <!-- Header section -->
        <div class="mb-4 text-center"> <!-- Réduit la marge du haut ici -->
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                <i class="fas fa-envelope-open-text text-blue-500 text-xl"></i>
            </div>
            <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">All Invitations</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">A list of all pending PC member invitations.</p>
        </div>

        @if ($invitations->isNotEmpty())
        <!-- Table Card -->
        <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-200/50 dark:ring-gray-700/50">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-university mr-2"></i>
                                    Conference Title
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-tag mr-2"></i>
                                    Role
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($invitations as $invitation)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $invitation->conference->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $invitation->role ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                <form action="{{ route('invitation.accept', ['token' => $invitation->token]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded-md shadow-sm transition">
                                        <i class="fas fa-check mr-1"></i> Accept
                                    </button>
                                </form>
                                <form action="{{ route('invitation.reject', ['token' => $invitation->token]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-md shadow-sm transition">
                                        <i class="fas fa-times mr-1"></i> Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <!-- No invitations message -->
        <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-lg ring-1 ring-gray-200/50 dark:ring-gray-700/50 mt-6 text-center">
            <p class="text-gray-700 dark:text-gray-300 text-sm">No pending invitations found.</p>
        </div>
        @endif

    </div>
</div>
@endsection