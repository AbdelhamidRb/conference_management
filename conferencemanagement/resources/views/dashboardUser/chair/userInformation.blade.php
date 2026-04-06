@extends('dashboardUser.chair.dashboardChair')

@section('content1')

<div class="mb-8 text-center">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
        <i class="fas fa-user text-blue-600 text-xl"></i>
    </div>
    <h1 class="mt-3 text-2xl font-bold">Member Information</h1>
    <p class="mt-2 text-sm text-gray-600">View the details of the user associated with this conference</p>
</div>

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-6 space-y-4 border border-gray-200">

    <div class="flex items-center space-x-4">
        <i class="fas fa-user text-blue-500"></i>
        <div class="text-sm">
            <div class="font-semibold text-gray-900">First Name</div>
            <div class="text-gray-600">{{ $user->firstName ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <i class="fas fa-user text-blue-500"></i>
        <div class="text-sm">
            <div class="font-semibold text-gray-900">Last Name</div>
            <div class="text-gray-600">{{ $user->lastName ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <i class="fas fa-building text-blue-500"></i>
        <div class="text-sm">
            <div class="font-semibold text-gray-900">Affiliation</div>
            <div class="text-gray-600">{{ $user->affiliation ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <i class="fas fa-flag text-blue-500"></i>
        <div class="text-sm">
            <div class="font-semibold text-gray-900">Country</div>
            <div class="text-gray-600">{{ $user->country ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <i class="fas fa-envelope text-blue-500"></i>
        <div class="text-sm">
            <div class="font-semibold text-gray-900">Email</div>
            <div class="text-gray-600">{{ $user->email ?? 'N/A' }}</div>
        </div>
    </div>

</div>

@endsection