@extends('dashboardUser.chair.dashboardChair')

@section('content1')

<div class="mb-8 text-center">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
        <i class="fas fa-users text-blue-600 text-xl"></i>
    </div>
    <h1 class="mt-3 text-2xl font-bold">List of Chairs</h1>
    <p class="mt-2 text-sm text-gray-600">Manage the chairs associated with this conference</p>
</div>

@if ($chairs->isNotEmpty())
<div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm mt-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-3 text-blue-500"></i>
                        First Name
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-3 text-blue-500"></i>
                        Last Name
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-blue-500"></i>
                        Email
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($chairs as $chair)
            <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $chair->user['firstName'] ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $chair->user['lastName'] ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $chair->user['email'] ?? 'N/A' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-200/50 mt-6">
    <p class="text-gray-700 text-sm">No chairs are currently associated with this conference.</p>
</div>
@endif

@endsection