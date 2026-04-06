@vite('resources/css/app.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="mb-10 text-center">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-200 shadow-md">
        <i class="fas fa-edit text-blue-700 text-2xl"></i>
    </div>
    <h2 class="mt-4 text-3xl font-extrabold text-gray-800">
        Update Evaluation
    </h2>
    <p class="mt-2 text-base text-gray-600">
        Modify your evaluation for submission #{{ $evaluation->submission_id }}
    </p>
</div>

@if(session('success'))
<div class="mb-6 rounded-lg bg-green-200 p-4 text-green-900 shadow text-center">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
</div>
@else

<form method="POST" action="{{ route('evaluations.update', ['acronyme' => $acronyme, 'evaluation' => $evaluation->id]) }}" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <!-- Submission ID -->
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fas fa-hashtag mr-2 text-blue-500"></i>Submission ID
            </label>
            <div class="w-full p-3 bg-gray-100 rounded-lg text-gray-800">
                {{ $evaluation->submission_id }}
            </div>
        </div>

        <!-- Remarks -->
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fas fa-comment-dots mr-2 text-blue-500"></i>Remarks
            </label>
            <textarea name="remarque" rows="4"
                class="w-full p-3 border border-gray-300 rounded-lg bg-white text-gray-800 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition"
                placeholder="Enter your evaluation remarks...">{{ old('remarque', $version->remarque) }}</textarea>
        </div>

        <!-- Commentaire confidentiel -->
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fas fa-lock mr-2 text-red-500"></i>Commentaire confidentiel
            </label>
            <textarea name="commentaire_confidentiel" rows="4"
                class="w-full p-3 border border-gray-300 rounded-lg bg-white text-gray-800 focus:ring-2 focus:ring-red-200 focus:border-red-500 transition"
                placeholder="Saisissez un commentaire confidentiel...">{{ old('commentaire_confidentiel', $version->commentaire_confidentiel ?? '') }}</textarea>
        </div>


        <!-- Decision -->
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-700">
                <i class="fas fa-gavel mr-2 text-blue-500"></i>Decision
            </label>
            <select name="decision"
                class="w-full p-3 border border-gray-300 rounded-lg bg-white text-gray-800 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition appearance-none">
                <option value="accepted" {{ old('decision', $version->decision) == 'accepted' ? 'selected' : '' }}>
                    <i class="fas fa-check-circle text-green-500 mr-2"></i> Accepted
                </option>
                <option value="borderline" {{ old('decision', $version->decision) == 'borderline' ? 'selected' : '' }}>
                    <i class="fas fa-minus-circle text-yellow-500 mr-2"></i> Borderline
                </option>
                <option value="rejected" {{ old('decision', $version->decision) == 'rejected' ? 'selected' : '' }}>
                    <i class="fas fa-times-circle text-red-500 mr-2"></i> Rejected
                </option>
            </select>
        </div>
    </div>

    <div class="text-center">
        <button type="submit"
            class="inline-flex items-center px-7 py-3 border border-transparent text-base font-medium rounded-xl shadow-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
            <i class="fas fa-save mr-2"></i>Update Evaluation
        </button>
    </div>
</form>
@endif