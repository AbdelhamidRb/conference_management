@vite('resources/css/app.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="mb-10 text-center">
    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-200 shadow-md">
        <i class="fas fa-clipboard-check text-blue-700 text-2xl"></i>
    </div>
    <h2 class="mt-4 text-3xl font-extrabold text-gray-800">
        Evaluate the article: {{ $evaluation->submission->titre ?? 'N/A' }}
    </h2>
    <p class="mt-2 text-base text-gray-600">
        Submit your evaluation for this article
    </p>
</div>

@if(session('error'))
<div class="mb-6 rounded-lg bg-red-200 p-4 text-red-900 shadow text-center">
    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="mb-6 rounded-lg bg-green-200 p-4 text-green-900 shadow text-center">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('evaluations.save', ['submission_id' => $evaluation->submission_id, 'pc_member_id' => $evaluation->pc_member_id]) }}" class="space-y-6">
    @csrf

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">


        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-comment-alt mr-2 text-blue-500"></i>Remarks
            </label>
            <textarea name="remark" rows="6" required
                class="block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="Provide detailed evaluation comments..."></textarea>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-user-secret mr-2 text-red-500"></i>Commentaire confidentiel
            </label>
            <textarea name="comentaire_confedentiel" rows="4"
                class="block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                placeholder="This comment will only be visible to the program committee..."></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-gavel mr-2 text-blue-500"></i>Decision
            </label>
            <select name="decision" required
                class="block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="" disabled selected>Select your decision</option>
                <option value="accepted">Accepted</option>
                <option value="borderline">BorderLine</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit"
                class="inline-flex items-center px-7 py-3 border border-transparent text-base font-medium rounded-xl shadow-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
                <i class="fas fa-save mr-2"></i>Submit Evaluation
            </button>
        </div>
    </div>


</form>