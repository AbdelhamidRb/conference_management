@extends('dashboardUser.chair.dashboardChair')

@section('content1')

<div class="mb-8 text-center">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
    </div>
    <h1 class="mt-3 text-2xl font-bold">Submission Details</h1>
    <p class="mt-2 text-sm text-gray-600">View the details of this conference submission</p>
</div>

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-6 space-y-6 border border-gray-200">

    <div class="flex items-start space-x-4">
        <i class="fas fa-heading text-blue-500 mt-1"></i>
        <div class="flex-1">
            <div class="font-semibold text-gray-900">Title</div>
            <div class="text-gray-600 mt-1">{{ $submission->titre ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="flex items-start space-x-4">
        <i class="fas fa-tags text-blue-500 mt-1"></i>
        <div class="flex-1">
            <div class="font-semibold text-gray-900">Keywords</div>
            <div class="text-gray-600 mt-1">{{ $submission->keywords ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="flex items-start space-x-4">
        <i class="fas fa-align-left text-blue-500 mt-1"></i>
        <div class="flex-1">
            <div class="font-semibold text-gray-900">Abstract</div>
            <div class="text-gray-600 mt-1">{{ $submission->resume ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="flex items-start space-x-4">
        <i class="fas fa-file-pdf text-blue-500 mt-1"></i>
        <div class="flex-1">
            <div class="font-semibold text-gray-900">PDF Document</div>
            <div class="text-gray-600 mt-1">
                <a href="{{ asset('storage/' . $submission->latestPdf->pdf) }}"
                    class="text-blue-600 hover:underline"
                    target="_blank" download>
                    Download Latest PDF
                </a>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-800 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Back to Previous Page
        </a>
    </div>

</div>

@endsection