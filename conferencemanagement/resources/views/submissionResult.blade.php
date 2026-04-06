@extends('layouts.app')

@section('title', session('submission_status') === 'success' ? 'Submission Successful' : 'Submission Error')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    @if(session('submission_status') === 'success')
    <!-- Success State -->

    <!-- Header -->
    <div class="max-w-4xl mx-auto px-4 mb-8">
        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg p-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/20 mb-4">
                <i class="fas fa-check text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold mb-2">Submission Successful!</h1>
            <p class="text-green-100">Your paper has been received by our system</p>
        </div>
    </div>

    <!-- Mobile Layout -->
    <div class="block lg:hidden max-w-2xl mx-auto px-4">
        <!-- Success Message -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 text-center">Thank You for Your Submission</h2>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-4">
                We've successfully received your conference paper submission. A confirmation email has been sent to the corresponding author.
            </p>

            @if(session('submission_id'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-green-600 dark:text-green-400 mr-3"></i>
                    <div>
                        <p class="text-sm text-green-800 dark:text-green-200">
                            Your submission ID: <span class="font-bold">{{ session('submission_id') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="text-center">
                <a href="/" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Return to Dashboard
                </a>
            </div>
        </div>

        <!-- Process Steps -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 text-center">What Happens Next?</h3>
            <p class="text-gray-600 dark:text-gray-400 text-center mb-6">Your journey through the review process</p>

            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm font-bold mr-4">
                        1
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Initial Screening</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Our editorial team will verify your submission meets all requirements.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm font-bold mr-4">
                        2
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Peer Review</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Experts in your field will evaluate your paper's technical merit.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm font-bold mr-4">
                        3
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Final Decision</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">You'll receive notification of acceptance, revision requests, or rejection.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Layout -->
    <div class="hidden lg:block max-w-6xl mx-auto px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Success Message -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Thank You for Your Submission</h2>
                <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                    We've successfully received your conference paper submission. A confirmation email has been sent to the corresponding author.
                </p>

                @if(session('submission_id'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg p-4 mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-green-600 dark:text-green-400 mr-3"></i>
                        <div>
                            <p class="text-sm text-green-800 dark:text-green-200">
                                Your submission ID: <span class="font-bold">{{ session('submission_id') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="text-center">
                    <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Return to Dashboard
                    </a>
                </div>
            </div>

            <!-- Process Steps -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 text-center">What Happens Next?</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center mb-8">Your journey through the review process</p>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg font-bold mr-5">
                            1
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Initial Screening</h4>
                            <p class="text-gray-600 dark:text-gray-400">Our editorial team will verify your submission meets all requirements.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg font-bold mr-5">
                            2
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Peer Review</h4>
                            <p class="text-gray-600 dark:text-gray-400">Experts in your field will evaluate your paper's technical merit.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg font-bold mr-5">
                            3
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Final Decision</h4>
                            <p class="text-gray-600 dark:text-gray-400">You'll receive notification of acceptance, revision requests, or rejection.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Error State -->

    <!-- Header -->
    <div class="max-w-4xl mx-auto px-4 mb-8">
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg p-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/20 mb-4">
                <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold mb-2">Submission Failed</h1>
            <p class="text-red-100">We encountered an issue processing your submission</p>
        </div>
    </div>

    <!-- Error Content -->
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-bold text-red-600 dark:text-red-400 mb-6 text-center">Submission Error</h2>

            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-sm text-red-800 dark:text-red-200">
                            {{ session('submission_message', 'An unknown error occurred during submission.') }}
                        </p>
                    </div>
                </div>
            </div>

            <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
                Please try submitting again or contact our support team if the problem persists.
            </p>

            <div class="text-center">
                <a href="/" class="w-full lg:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 inline-flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Return to Dashboard
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    window.onload = function() {
        if (window.history && window.history.pushState) {
            window.history.pushState({
                page: "submission_result"
            }, "Submission Result", "{{ route('submission.result') }}");

            window.addEventListener('popstate', function(event) {
                if (event.state && event.state.page === "submission_result") {
                    window.location.href = "/";
                }
            });
        }
    };
</script>
@endsection