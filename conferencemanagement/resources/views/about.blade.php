@extends('layouts.app')

@section('title', 'TechConf 2024 - Conference Management System')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">How FSTconference Works</h1>
        <p class="text-xl opacity-90 max-w-2xl mx-auto">A simple and transparent process for academic paper submissions and reviews</p>
    </div>
</section>

<!-- Process Overview Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">The Complete Process</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">From submission to publication, we've streamlined every step</p>
        </div>

        <div class="max-w-3xl mx-auto space-y-8">
            @foreach([
                ['num' => 1, 'title' => 'Create an Account', 'desc' => 'Sign up for a free account to access all freeConf features and services.'],
                ['num' => 2, 'title' => 'Submit Your Paper', 'desc' => 'Upload your paper, add metadata, and select the appropriate conference.'],
                ['num' => 3, 'title' => 'Review Process', 'desc' => 'Your paper undergoes a thorough peer review by experts in your field.'],
                ['num' => 4, 'title' => 'Receive Feedback', 'desc' => 'Get detailed feedback and a decision on your submission.'],
                ['num' => 5, 'title' => 'Revise (If Needed)', 'desc' => 'Make revisions based on reviewer feedback if requested.'],
                ['num' => 6, 'title' => 'Publication', 'desc' => 'Accepted papers are published in the conference proceedings.']
            ] as $step)
            <div class="flex items-start p-6 rounded-lg hover:bg-gray-50 transition-all duration-300">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold mr-6 mt-1">
                    {{ $step['num'] }}
                </div>
                <div class="text-left">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-gray-600">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-lg text-blue-700 max-w-2xl mx-auto">Common questions about the submission and review process</p>
        </div>

        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['question' => 'What file formats are accepted for paper submissions?', 'answer' => 'We accept papers in PDF format only.'],
                ['question' => 'How long does the review process typically take?', 'answer' => 'The review process typically takes 4-6 weeks.'],
                ['question' => 'Can I submit the same paper to multiple conferences?', 'answer' => 'No, simultaneous submission is considered unethical.'],
                ['question' => 'What happens if my paper is rejected?', 'answer' => 'You\'ll receive detailed feedback to improve your paper.'],
                ['question' => 'Can I appeal a rejection decision?', 'answer' => 'Most conferences have an appeals process.'],
                ['question' => 'Do I need to present my paper at the conference if it\'s accepted?', 'answer' => 'Yes, most conferences require presentation.']
            ] as $faq)
            <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <button 
                    @click="open = !open" 
                    class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 transition-colors duration-200"
                >
                    <h3 class="text-lg font-semibold text-blue-900">{{ $faq['question'] }}</h3>
                    <svg :class="{'rotate-180': open}" class="w-5 h-5 text-blue-500 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-5 text-gray-600">
                    <p>{{ $faq['answer'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Submit Your Paper?</h2>
        <p class="text-xl opacity-90 mb-8 max-w-2xl mx-auto">Join thousands of researchers who have successfully published through freeConf</p>
        
        @guest
        <div class="flex flex-wrap justify-center gap-4">
            <a href="/register" class="inline-block px-8 py-3 bg-white text-blue-900 rounded-lg font-semibold hover:bg-gray-100 transition-all shadow-md hover:shadow-lg">
                Create Account
            </a>
            <a href="/login" class="inline-block px-8 py-3 border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-900 transition-all">
                Sign In
            </a>
        </div>
        @endguest
    </div>
</section>

@endsection