@extends('layouts.app')

@section('title', 'FSTconference 2024 - Conference Management System')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Banner with Gradient -->
    <div class="w-full py-6 md:py-8 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="container mx-auto px-4 md:px-6">
            <h1 class="text-2xl md:text-3xl font-bold text-center">Create a Conference</h1>
            <p class="mt-2 text-blue-100 text-center max-w-2xl mx-auto text-sm md:text-base">Fill out the details below to register a new conference.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center py-6 md:py-12 px-4">
        <div class="w-full max-w-4xl">
            <!-- Mobile/Tablet Layout -->
            <div class="block lg:hidden">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4 md:p-6">
                    <!-- Progress Section -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Step <span id="stepNumber">1</span> of 3</span>
                            <span id="progressText">33%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 33%;"></div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <form id="multiStepForm" method="POST" action="/create-conference/step1" class="space-y-4">
                        @csrf

                        {{-- Step 1 --}}
                        <div class="step" id="step1">
                            <div class="mb-6">
                                <h2 class="text-lg md:text-xl font-semibold text-blue-800 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    General Information
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">Basic details about your conference</p>
                            </div>

                            <div class="space-y-4">
                                <!-- Title Field -->
                                <div class="space-y-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-heading mr-1 text-blue-600"></i>
                                        Conference Title
                                    </label>
                                    <input
                                        id="title"
                                        name="title"
                                        value="{{ old('title', session('conference.step1.title') ?? '') }}"
                                        placeholder="Enter conference title"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                        required />
                                    @error('title')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{$message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Acronym Field -->
                                <div class="space-y-2">
                                    <label for="acronyme" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-tag mr-1 text-blue-600"></i>
                                        Acronym
                                    </label>
                                    <input
                                        id="acronyme"
                                        name="acronyme"
                                        value="{{ old('acronyme', session('conference.step1.acronyme') ?? '') }}"
                                        placeholder="e.g., ICML2024"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                        required />
                                    @error('acronyme')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{$message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Venue Field -->
                                <div class="space-y-2">
                                    <label for="venue" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-building mr-1 text-blue-600"></i>
                                        Venue
                                    </label>
                                    <input
                                        id="venue"
                                        name="venue"
                                        value="{{ old('venue', session('conference.step1.venue') ?? '') }}"
                                        placeholder="Conference venue or location"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                        required />
                                    @error('venue')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{$message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Location Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Country Field -->
                                    <div class="space-y-2">
                                        <label for="country" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-flag mr-1 text-blue-600"></i>
                                            Country
                                        </label>
                                        <input
                                            id="country"
                                            name="country"
                                            value="{{ old('country', session('conference.step1.country') ?? '') }}"
                                            placeholder="Country"
                                            class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                            required />
                                        @error('country')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{$message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <!-- City Field -->
                                    <div class="space-y-2">
                                        <label for="city" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-map-marker-alt mr-1 text-blue-600"></i>
                                            City
                                        </label>
                                        <input
                                            id="city"
                                            name="city"
                                            value="{{ old('city', session('conference.step1.city') ?? '') }}"
                                            placeholder="City"
                                            class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                            required />
                                        @error('city')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{$message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
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
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                        1
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-blue-600">General Information</p>
                                        <p class="text-xs text-gray-500">Basic conference details</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">
                                        2
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-400">Dates & Deadlines</p>
                                        <p class="text-xs text-gray-400">Important dates</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">
                                        3
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-400">Additional Details</p>
                                        <p class="text-xs text-gray-400">Final configuration</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-6">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Progress</span>
                                    <span>33%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 33%;"></div>
                                </div>
                            </div>

                            <!-- Help Section -->
                            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Need Help?</h4>
                                <p class="text-xs text-blue-700">Fill out all required fields to proceed to the next step. Make sure your acronym is unique.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="col-span-8">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                            <form id="multiStepFormDesktop" method="POST" action="/create-conference/step1" class="space-y-6">
                                @csrf

                                {{-- Step 1 --}}
                                <div class="step" id="step1Desktop">
                                    <div class="mb-8">
                                        <h2 class="text-2xl font-bold text-blue-800 flex items-center">
                                            <i class="fas fa-info-circle mr-3"></i>
                                            General Information
                                        </h2>
                                        <p class="text-gray-600 mt-2">Provide the basic details about your conference</p>
                                    </div>

                                    <div class="space-y-6">
                                        <!-- Title Field -->
                                        <div class="space-y-2">
                                            <label for="titleDesktop" class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-heading mr-2 text-blue-600"></i>
                                                Conference Title
                                            </label>
                                            <input
                                                id="titleDesktop"
                                                name="title"
                                                value="{{ old('title', session('conference.step1.title') ?? '') }}"
                                                placeholder="Enter the full title of your conference"
                                                class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                required />
                                            @error('title')
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{$message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <!-- Acronym Field -->
                                        <div class="space-y-2">
                                            <label for="acronymeDesktop" class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-tag mr-2 text-blue-600"></i>
                                                Conference Acronym
                                            </label>
                                            <input
                                                id="acronymeDesktop"
                                                name="acronyme"
                                                value="{{ old('acronyme', session('conference.step1.acronyme') ?? '') }}"
                                                placeholder="e.g., ICML2024, NIPS2024"
                                                class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                required />
                                            <p class="text-xs text-gray-500">A short, unique identifier for your conference</p>
                                            @error('acronyme')
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{$message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <!-- Venue Field -->
                                        <div class="space-y-2">
                                            <label for="venueDesktop" class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-building mr-2 text-blue-600"></i>
                                                Venue
                                            </label>
                                            <input
                                                id="venueDesktop"
                                                name="venue"
                                                value="{{ old('venue', session('conference.step1.venue') ?? '') }}"
                                                placeholder="Conference center, university, hotel, etc."
                                                class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                required />
                                            @error('venue')
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{$message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <!-- Location Fields -->
                                        <div class="grid grid-cols-2 gap-6">
                                            <!-- Country Field -->
                                            <div class="space-y-2">
                                                <label for="countryDesktop" class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-flag mr-2 text-blue-600"></i>
                                                    Country
                                                </label>
                                                <input
                                                    id="countryDesktop"
                                                    name="country"
                                                    value="{{ old('country', session('conference.step1.country') ?? '') }}"
                                                    placeholder="Country name"
                                                    class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                    required />
                                                @error('country')
                                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{$message }}
                                                </p>
                                                @enderror
                                            </div>

                                            <!-- City Field -->
                                            <div class="space-y-2">
                                                <label for="cityDesktop" class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                                                    City
                                                </label>
                                                <input
                                                    id="cityDesktop"
                                                    name="city"
                                                    value="{{ old('city', session('conference.step1.city') ?? '') }}"
                                                    placeholder="City name"
                                                    class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                    required />
                                                @error('city')
                                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{$message }}
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end pt-8 border-t border-gray-200">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
                                        Continue to Next Step
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
</style>

@endsection