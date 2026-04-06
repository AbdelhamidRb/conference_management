@vite('resources/css/app.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="mb-10 text-center">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-200 shadow-md">
        <i class="fas fa-tasks text-blue-700 text-2xl"></i>
    </div>
    <h2 class="mt-4 text-3xl font-extrabold text-gray-800">
        Assign PC members to the article: {{ $article->titre }}
    </h2>
    <p class="mt-2 text-base text-gray-600">
        Select the members you want to assign to this article
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

<form method="POST" action="{{ route('attribution.store', $article->idSubmission) }}" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($pcmembres as $pc)
        @php $nbAttributions = $pc->evaluations_count ?? 0; @endphp

        <div class="flex items-center bg-white p-5 rounded-xl shadow-md border border-gray-200 transition hover:shadow-lg">
            <input type="checkbox" name="pcs[]" value="{{ $pc->id }}" class="form-checkbox text-blue-600 mr-4 w-5 h-5">
            <label class="text-gray-800 text-sm">
                <span class="font-semibold">{{ $pc->user->firstName }} {{ $pc->user->lastName }}</span>
                <span class="block text-xs text-gray-500 mt-1">(Current articles: {{ $nbAttributions }})</span>
            </label>
        </div>
        @endforeach
    </div>

    @if($pcmembres->count())
    <div class="text-center">
        <button type="submit"
            class="mt-8 inline-flex items-center px-7 py-3 border border-transparent text-base font-medium rounded-xl shadow-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
            <i class="fas fa-paper-plane mr-2"></i>Assign
        </button>
    </div>
    @else
    <div class="text-center text-gray-600 mt-8">
        <i class="fas fa-info-circle mr-1"></i>No Pc Members available for assignment.
    </div>
    @endif

</form>