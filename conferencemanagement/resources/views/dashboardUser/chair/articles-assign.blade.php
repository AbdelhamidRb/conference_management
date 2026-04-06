@vite('resources/css/app.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="mb-10 text-center">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-200 shadow-md">
        <i class="fas fa-tasks text-blue-700 text-2xl"></i>
    </div>
    <h2 class="mt-4 text-3xl font-extrabold text-gray-800">
        Assign Articles to: {{ $pcMember->user->firstName }} {{ $pcMember->user->lastName }}
    </h2>
    <p class="mt-2 text-base text-gray-600">
        Current assignments: {{ $pcMember->evaluations_count }}
    </p>
</div>

@if(session('error'))
<div class="mb-6 rounded-lg bg-red-200 p-4 text-red-900 shadow">
    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="mb-6 rounded-lg bg-green-200 p-4 text-green-900 shadow">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('pcmembers.articles.store', $pcMember->id) }}" class="space-y-6">
    @csrf
    <input type="hidden" value="{{ $conference->acronyme }}" name="acronyme">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($articles as $article)
        @php $nbEvaluations = $article->evaluations_count ?? 0; @endphp

        <div class="flex items-center bg-white p-5 rounded-xl shadow-md border border-gray-200 transition hover:shadow-lg">
            <input type="checkbox" name="articles[]" value="{{ $article->idSubmission }}" class="form-checkbox text-blue-600 mr-4 w-5 h-5">
            <label class="text-gray-800 text-sm">
                <span class="font-semibold">{{ $article->titre }}</span>
                <span class="block text-xs text-gray-500 mt-1">
                    Current reviewers: {{ $nbEvaluations }} |
                    <a href="{{ asset('storage/' . $article->latestPdf->pdf) }}" target="_blank" class="text-blue-500 hover:underline">View PDF</a>
                </span>
            </label>
        </div>
        @endforeach
    </div>

    @if($articles->count())
    <div class="text-center">
        <button type="submit"
            class="mt-8 inline-flex items-center px-7 py-3 border border-transparent text-base font-medium rounded-xl shadow-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
            <i class="fas fa-paper-plane mr-2"></i>Assign Articles
        </button>
    </div>
    @else
    <div class="text-center text-gray-600 mt-8">
        <i class="fas fa-info-circle mr-1"></i>No articles available for assignment.
    </div>
    @endif
</form>