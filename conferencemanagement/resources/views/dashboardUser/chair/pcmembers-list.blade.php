@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-4">
    <!-- Header -->
    <div class="mb-6 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-users text-blue-600 text-xl"></i>
        </div>
        <h1 class="mt-3 text-xl font-bold">PC Members</h1>
        <p class="mt-1 text-xs text-gray-600">Assign articles to committee members</p>
    </div>

    <!-- Flash Messages -->
    @if(session('error'))
    <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-xs text-red-800 shadow-sm">
        {{ session('error') }}
    </div>
    @endif
    @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-xs text-green-800 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Mobile Cards (visible on small screens) -->
    <div class="block md:hidden space-y-3">
        @forelse($pcMembers as $pcMember)
        <div class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:bg-gray-50">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-medium text-gray-900">
                        {{ $pcMember->user->firstName }} {{ $pcMember->user->lastName }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $pcMember->user->email }}</p>
                </div>
                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-800 rounded-full">
                    {{ $pcMember->evaluations_count }} assignments
                </span>
            </div>

            <div class="mt-3 flex justify-between items-center">
                <button onclick="openIframe('{{ $pcMember->id }}')"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded shadow transition duration-200">
                    <i class="fas fa-plus-circle mr-1"></i> Assign Articles
                </button>
            </div>
        </div>
        @empty
        <div class="bg-white p-4 rounded-lg shadow border border-gray-100 text-center">
            <p class="text-xs text-gray-500">No PC members found or all have reached maximum assignments</p>
        </div>
        @endforelse
    </div>

    <!-- Original Table (hidden on mobile) -->
    <div class="hidden md:block overflow-hidden rounded-lg border border-gray-200 shadow-sm mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-user mr-3 text-blue-500"></i>
                            PC Member
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-500"></i>
                            Email
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt mr-3 text-blue-500"></i>
                            Current Assignments
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-cogs mr-3 text-blue-500"></i>
                            Action
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pcMembers as $pcMember)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $pcMember->user->firstName }} {{ $pcMember->user->lastName }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $pcMember->user->email }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $pcMember->evaluations_count }}
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="openIframe('{{ $pcMember->id }}')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow transition duration-200">
                            <i class="fas fa-plus-circle mr-2"></i> Assign Articles
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                        No PC members found or all have reached maximum assignments
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal with iframe (unchanged) -->
    <div id="iframeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white w-11/12 md:w-4/5 h-5/6 rounded-lg shadow-lg relative p-4">
            <button onclick="closeIframe()"
                id='close-alert'
                class="absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">
                Close
            </button>
            <iframe id="articlesIframe" src="" class="w-full h-full border-0 rounded"></iframe>
        </div>
    </div>
</div>

<script>
    function openIframe(pcMemberId) {
        const modal = document.getElementById('iframeModal');
        const iframe = document.getElementById('articlesIframe');
        iframe.src = `/pcmembers/${pcMemberId}/articles/{{ request('acronyme') }}`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeIframe() {
        setTimeout(function() {
            location.reload();
        }, 50);
        const modal = document.getElementById('iframeModal');
        const iframe = document.getElementById('articlesIframe');
        iframe.src = '';
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endsection