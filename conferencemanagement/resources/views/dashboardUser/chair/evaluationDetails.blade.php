@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
        <!-- Header -->
        <div class="mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Evaluation Details</h1>
            <p class="text-gray-600">Reviewer's comments and feedback</p>
        </div>

        <!-- Evaluation Card -->
        <div class="space-y-6">
            <!-- Reviewer Info -->
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl">
                        {{ substr($evaluation->pcMember->user->firstName, 0, 1) }}{{ substr($evaluation->pcMember->user->lastName, 0, 1) }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $evaluation->pcMember->user->firstName }} {{ $evaluation->pcMember->user->lastName }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Loop Through Versions -->
            @foreach($evaluation->versions->sortByDesc('created_at') as $version)
            <div class="border-t pt-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-500">
                        {{ $version->created_at->format('M d, Y \a\t h:i A') }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
            @if($version->decision === 'accepted') bg-green-100 text-green-800
            @elseif($version->decision === 'rejected') bg-red-100 text-red-800
            @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($version->decision) }}
                    </span>
                </div>

                <!-- Remarks Section -->
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-gray-700 mb-2">Reviewer Remarks</h4>
                    @if($version->remarque)
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($version->remarque)) !!}
                    </div>
                    @else
                    <p class="text-gray-400 italic">No remarks provided</p>
                    @endif
                </div>

                <!-- Confidential Comments Section -->
                <div class="bg-gray-100 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-gray-700 mb-2">Confidential Comments</h4>
                    @if($version->commentaires_confidentiels)
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($version->commentaires_confidentiels)) !!}
                    </div>
                    @else
                    <p class="text-gray-400 italic">No confidential comments provided</p>
                    @endif
                </div>
            </div>
            @endforeach


            <!-- Scores (if applicable) -->
            @if($evaluation->score)
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="text-sm text-blue-600 font-medium">Score</p>
                    <p class="text-xl font-bold">{{ $evaluation->score }}/10</p>
                </div>
                <!-- Add more score metrics if needed -->
            </div>
            @endif

            <!-- Back Button -->
            <div class="pt-4 border-t">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection