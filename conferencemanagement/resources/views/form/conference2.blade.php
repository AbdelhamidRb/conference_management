@extends('layouts.app')

@section('title', 'FSTconference 2024 - Conference Management System')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Banner with Gradient -->
    <div class="w-full py-6 md:py-8 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="container mx-auto px-4 md:px-6">
            <h1 class="text-2xl md:text-3xl font-bold text-center">Create a Conference</h1>
            <p class="mt-2 text-blue-100 text-center max-w-2xl mx-auto text-sm md:text-base">Configure dates and additional details for your conference.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center py-6 md:py-12 px-4">
        <div class="w-full max-w-4xl">
            <!-- Mobile/Tablet Layout -->
            <div class="block lg:hidden">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4 md:p-6">
                    <input name='formule1' type='hidden' id='formule1'>

                    <!-- Progress Section -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Step <span id="stepNumber">2</span> of 3</span>
                            <span id="progressText">66%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 66%;"></div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <form id="multiStepForm" method="POST" action="/create-conference/step2" class="space-y-4">
                        @csrf

                        {{-- Step 2 --}}
                        <div class="step" id="step2">
                            <div class="mb-6">
                                <h2 class="text-lg md:text-xl font-semibold text-blue-800 flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Conference Details
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">Set dates and additional information</p>
                            </div>

                            <div class="space-y-4">
                                <!-- Conference Web Page -->
                                <div class="space-y-2">
                                    <label for="conferenceWebPage" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-globe mr-1 text-blue-600"></i>
                                        Conference Website (Optional)
                                    </label>
                                    <input
                                        id="conferenceWebPage"
                                        name="conferenceWebPage"
                                        value="{{ old('conferenceWebPage', session('conference.step2.conferenceWebPage') ?? '') }}"
                                        placeholder="https://yourconference.com"
                                        type="url"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base" />
                                    @error('conferenceWebPage')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{$message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Estimated Submissions -->
                                <div class="space-y-2">
                                    <label for="estimatedNumberSubmission" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-file-alt mr-1 text-blue-600"></i>
                                        Expected Submissions (Optional)
                                    </label>
                                    <input
                                        id="estimatedNumberSubmission"
                                        name="estimatedNumberSubmission"
                                        value="{{ old('estimatedNumberSubmission', session('conference.step2.estimatedNumberSubmission') ?? '') }}"
                                        type="number"
                                        min="1"
                                        placeholder="e.g., 100"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base" />
                                    @error('estimatedNumberSubmission')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{$message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Important Dates Section -->
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-blue-900 mb-3 flex items-center">
                                        <i class="fas fa-calendar-check mr-2"></i>
                                        Important Dates
                                    </h3>

                                    <div class="space-y-4">
                                        <!-- First Day -->
                                        <div class="space-y-2">
                                            <label for="firstDay" class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-play mr-1 text-green-600"></i>
                                                Conference Start Date
                                            </label>
                                            <input
                                                name="firstDay"
                                                value="{{ old('firstDay', session('conference.step2.firstDay') ?? '') }}"
                                                type="date"
                                                id="firstDay"
                                                class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                                required />
                                            @error('firstDay')
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{$message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <!-- Last Day -->
                                        <div class="space-y-2">
                                            <label for="lastDay" class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-stop mr-1 text-red-600"></i>
                                                Conference End Date
                                            </label>
                                            <input
                                                name="lastDay"
                                                value="{{ old('lastDay', session('conference.step2.lastDay') ?? '') }}"
                                                type="date"
                                                id="lastDay"
                                                class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                                required />
                                            @error('lastDay')
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{$message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <!-- Submission Deadline -->
                                        <div class="space-y-2">
                                            <label for="submissionDeadLine" class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-clock mr-1 text-orange-600"></i>
                                                Submission Deadline
                                            </label>
                                            <input
                                                name="submissionDeadLine"
                                                value="{{ old('submissionDeadLine', session('conference.step2.submissionDeadLine') ?? '') }}"
                                                type="date"
                                                id="submissionDeadLine"
                                                class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                                required />
                                            @error('submissionDeadLine')
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{$message }}
                                            </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                            <button type="button" id="prevButton" class="w-full sm:w-auto bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Previous
                            </button>
                            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                                Next Step
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Desktop Layout -->
            <div class="hidden lg:block">
                <div class="grid grid-cols-12 gap-8">
                    <!-- Progress Sidebar -->
                    <div class="col-span-4">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sticky top-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Conference Creation</h3>

                            <!-- Progress Steps -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-600">General Information</p>
                                        <p class="text-xs text-gray-500">Completed</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                        2
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-blue-600">Dates & Details</p>
                                        <p class="text-xs text-gray-500">Current step</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">
                                        3
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-400">Final Configuration</p>
                                        <p class="text-xs text-gray-400">Pending</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-6">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Progress</span>
                                    <span>66%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 66%;"></div>
                                </div>
                            </div>

                            <!-- Help Section -->
                            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Date Guidelines</h4>
                                <ul class="text-xs text-blue-700 space-y-1">
                                    <li>• Submission deadline should be before conference start</li>
                                    <li>• End date must be after start date</li>
                                    <li>• Allow enough time for review process</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="col-span-8">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                            <input name='formule1' type='hidden' id='formule1'>

                            <form id="multiStepFormDesktop" method="POST" action="/create-conference/step2" class="space-y-6">
                                @csrf

                                {{-- Step 2 --}}
                                <div class="step" id="step2Desktop">
                                    <div class="mb-8">
                                        <h2 class="text-2xl font-bold text-blue-800 flex items-center">
                                            <i class="fas fa-calendar-alt mr-3"></i>
                                            Conference Details
                                        </h2>
                                        <p class="text-gray-600 mt-2">Configure dates and additional information for your conference</p>
                                    </div>

                                    <div class="space-y-8">
                                        <!-- Additional Information Section -->
                                        <div class="space-y-6">
                                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Additional Information</h3>

                                            <!-- Conference Web Page -->
                                            <div class="space-y-2">
                                                <label for="conferenceWebPageDesktop" class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-globe mr-2 text-blue-600"></i>
                                                    Conference Website
                                                </label>
                                                <input
                                                    id="conferenceWebPageDesktop"
                                                    name="conferenceWebPage"
                                                    value="{{ old('conferenceWebPage', session('conference.step2.conferenceWebPage') ?? '') }}"
                                                    placeholder="https://yourconference.com"
                                                    type="url"
                                                    class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                                                <p class="text-xs text-gray-500">Optional: Link to your conference website</p>
                                                @error('conferenceWebPage')
                                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{$message }}
                                                </p>
                                                @enderror
                                            </div>

                                            <!-- Estimated Submissions -->
                                            <div class="space-y-2">
                                                <label for="estimatedNumberSubmissionDesktop" class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                                                    Expected Number of Submissions
                                                </label>
                                                <input
                                                    id="estimatedNumberSubmissionDesktop"
                                                    name="estimatedNumberSubmission"
                                                    value="{{ old('estimatedNumberSubmission', session('conference.step2.estimatedNumberSubmission') ?? '') }}"
                                                    type="number"
                                                    min="1"
                                                    placeholder="e.g., 100"
                                                    class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                                                <p class="text-xs text-gray-500">Optional: Helps us prepare the review system</p>
                                                @error('estimatedNumberSubmission')
                                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{$message }}
                                                </p>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Important Dates Section -->
                                        <div class="bg-blue-50 p-6 rounded-lg">
                                            <h3 class="text-lg font-semibold text-blue-900 mb-6 flex items-center">
                                                <i class="fas fa-calendar-check mr-2"></i>
                                                Important Dates
                                            </h3>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <!-- Conference Dates -->
                                                <div class="space-y-4">
                                                    <h4 class="text-sm font-medium text-gray-700 border-b border-blue-200 pb-1">Conference Period</h4>

                                                    <!-- First Day -->
                                                    <div class="space-y-2">
                                                        <label for="firstDayDesktop" class="block text-sm font-medium text-gray-700">
                                                            <i class="fas fa-play mr-2 text-green-600"></i>
                                                            Start Date
                                                        </label>
                                                        <input
                                                            name="firstDay"
                                                            value="{{ old('firstDay', session('conference.step2.firstDay') ?? '') }}"
                                                            type="date"
                                                            id="firstDayDesktop"
                                                            class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                            required />
                                                        @error('firstDay')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{$message }}
                                                        </p>
                                                        @enderror
                                                    </div>

                                                    <!-- Last Day -->
                                                    <div class="space-y-2">
                                                        <label for="lastDayDesktop" class="block text-sm font-medium text-gray-700">
                                                            <i class="fas fa-stop mr-2 text-red-600"></i>
                                                            End Date
                                                        </label>
                                                        <input
                                                            name="lastDay"
                                                            value="{{ old('lastDay', session('conference.step2.lastDay') ?? '') }}"
                                                            type="date"
                                                            id="lastDayDesktop"
                                                            class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                            required />
                                                        @error('lastDay')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{$message }}
                                                        </p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Submission Deadline -->
                                                <div class="space-y-4">
                                                    <h4 class="text-sm font-medium text-gray-700 border-b border-blue-200 pb-1">Submission</h4>

                                                    <div class="space-y-2">
                                                        <label for="submissionDeadLineDesktop" class="block text-sm font-medium text-gray-700">
                                                            <i class="fas fa-clock mr-2 text-orange-600"></i>
                                                            Submission Deadline
                                                        </label>
                                                        <input
                                                            name="submissionDeadLine"
                                                            value="{{ old('submissionDeadLine', session('conference.step2.submissionDeadLine') ?? '') }}"
                                                            type="date"
                                                            id="submissionDeadLineDesktop"
                                                            class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                            required />
                                                        <p class="text-xs text-gray-500">Must be before conference start date</p>
                                                        @error('submissionDeadLine')
                                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            {{$message }}
                                                        </p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between pt-8 border-t border-gray-200">
                                    <button type="button" id="prevButtonDesktop" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Previous Step
                                    </button>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
                                        Continue to Final Step
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom focus styles */
    .form-input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Smooth transitions */
    .form-input {
        transition: all 0.2s ease-in-out;
    }

    /* Hover effects */
    .form-input:hover {
        border-color: #93c5fd;
    }

    /* Date input styling */
    input[type="date"] {
        position: relative;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        color: #3b82f6;
        cursor: pointer;
    }
</style>

<script>
    // Handle Previous button functionality
    document.getElementById('prevButton')?.addEventListener('click', function() {
        window.location.href = '/createConference';
    });

    document.getElementById('prevButtonDesktop')?.addEventListener('click', function() {
        window.location.href = '/createConference';
    });

    // Date validation
    document.addEventListener('DOMContentLoaded', function() {
        const firstDayInputs = document.querySelectorAll('#firstDay, #firstDayDesktop');
        const lastDayInputs = document.querySelectorAll('#lastDay, #lastDayDesktop');
        const submissionInputs = document.querySelectorAll('#submissionDeadLine, #submissionDeadLineDesktop');

        function validateDates() {
            firstDayInputs.forEach((firstDay, index) => {
                const lastDay = lastDayInputs[index];
                const submission = submissionInputs[index];

                if (firstDay && lastDay && firstDay.value && lastDay.value) {
                    if (new Date(firstDay.value) > new Date(lastDay.value)) {
                        lastDay.setCustomValidity('End date must be after start date');
                    } else {
                        lastDay.setCustomValidity('');
                    }
                }

                if (submission && firstDay && submission.value && firstDay.value) {
                    if (new Date(submission.value) >= new Date(firstDay.value)) {
                        submission.setCustomValidity('Submission deadline must be before conference start');
                    } else {
                        submission.setCustomValidity('');
                    }
                }
            });
        }

        // Add event listeners for date validation
        [...firstDayInputs, ...lastDayInputs, ...submissionInputs].forEach(input => {
            input?.addEventListener('change', validateDates);
        });
    });
</script>

@endsection