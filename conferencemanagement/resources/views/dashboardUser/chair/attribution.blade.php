@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-4">
    <!-- Header -->
    <div class="mb-6 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
        </div>
        <h1 class="mt-3 text-xl font-bold">Article List</h1>
        <p class="mt-1 text-xs text-gray-600">Assign reviewers to submitted articles</p>
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

    <!-- Mobile Cards (shown only on phones) -->
    <div class="block md:hidden space-y-4">
        @forelse($articles as $article)
        <div class="rounded-lg border border-gray-200 p-4 shadow-sm hover:bg-gray-50 transition-colors">
            <!-- Article Title -->
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-sm font-medium text-gray-900">
                    {{ $article->titre }}
                </h3>
                <span class="text-xs text-gray-500">
                    {{ $article->evaluations_count }} reviewers
                </span>
            </div>

            <!-- Keywords -->
            <div class="mb-3">
                <p class="text-xs text-gray-500 mb-1">Keywords:</p>
                <div class="flex flex-wrap gap-1">
                    @foreach(explode(',', $article->keywords) as $keyword)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-2xs font-semibold bg-blue-50 text-blue-700 border border-blue-300">
                        {{ trim($keyword) }}
                    </span>
                    @endforeach
                </div>
            </div>

            <!-- PDF Link -->
            <div class="mb-3">
                <p class="text-xs text-gray-500 mb-1">Document:</p>
                <a href="{{ asset('storage/' . $article->latestPdf->pdf) }}" target="_blank"
                    class="inline-flex items-center text-blue-600 text-sm underline">
                    <i class="fas fa-file-pdf mr-1"></i> View PDF
                </a>
            </div>

            <!-- Action Button -->
            <button onclick="openIframe('{{ $article->idSubmission }}')"
                class="w-full mt-2 inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow transition duration-200">
                <i class="fas fa-plus-circle mr-2"></i> Assign Reviewers
            </button>
        </div>
        @empty
        <div class="text-center py-6 text-gray-500">
            No articles found
        </div>
        @endforelse
    </div>

    <!-- Desktop Table (hidden on phones) -->
    <div class="hidden md:block overflow-hidden rounded-lg border border-gray-200 shadow-sm mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt mr-3 text-blue-500"></i>
                            Article Name
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-tags mr-3 text-blue-500"></i>
                            Keywords
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-file-pdf mr-3 text-blue-500"></i>
                            PDF
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-3 text-blue-500"></i>
                            Reviewers
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
                @forelse($articles as $article)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-900 text-center">
                        {{ $article->titre }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap align-top">
                        <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                            @foreach(explode(',', $article->keywords) as $keyword)
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-300 shadow-sm">
                                {{ trim($keyword) }}
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-blue-600 text-center">
                        <a href="{{ asset('storage/' . $article->latestPdf->pdf) }}" target="_blank" class="underline">View PDF</a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 text-center">
                        {{ $article->evaluations_count }}
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="openIframe('{{ $article->idSubmission }}')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow transition duration-200">
                            <i class="fas fa-plus-circle mr-2"></i> Assign
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        No articles found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal with iframe (same as original) -->
    <div id="iframeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center">
        <div class="bg-white w-11/12 md:w-4/5 h-5/6 rounded-lg shadow-lg relative p-4">
            <button onclick="closeIframe()"
                class="absolute top-4 right-4 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow" id="close-alert">
                Close
            </button>
            <iframe id="pcmembreIframe" src="" class="w-full h-full border-0 rounded"></iframe>
        </div>
    </div>
</div>

<script>
    function openIframe(articleId) {
        const modal = document.getElementById('iframeModal');
        const iframe = document.getElementById('pcmembreIframe');
        iframe.src = `/articles/${articleId}/pcmembres`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeIframe() {
        const modal = document.getElementById('iframeModal');
        const iframe = document.getElementById('pcmembreIframe');
        iframe.src = '';
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endsection
