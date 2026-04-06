@extends('layouts.app')

@section('title', 'FSTconference 2024 - Conference Management System')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Banner with Gradient -->
    <div class="w-full py-6 md:py-8 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="container mx-auto px-4 md:px-6">
            <h1 class="text-2xl md:text-3xl font-bold text-center">Create a Conference</h1>
            <p class="mt-2 text-blue-100 text-center max-w-2xl mx-auto text-sm md:text-base">Final step: Configure organizer details and topics.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center py-6 md:py-12 px-4">
        <div class="w-full max-w-5xl">
            <!-- Mobile/Tablet Layout -->
            <div class="block lg:hidden">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4 md:p-6">
                    <!-- Progress Section -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Step <span id="stepNumber">3</span> of 3</span>
                            <span id="progressText">99%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 99%;"></div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <form id="multiStepForm" method="POST" action="/create-conference/step3" class="space-y-4">
                        @csrf

                        <!-- Organizer Information Section -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h2 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                Organizer Information
                            </h2>
                            
                            <div class="space-y-4">
                                <!-- Organizer Name -->
                                <div class="space-y-2">
                                    <label for="organizer" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-user mr-1 text-blue-600"></i>
                                        Organizer Name
                                    </label>
                                    <input 
                                        type="text" 
                                        name="organizer" 
                                        id="organizer" 
                                        placeholder="Full name of the organizer"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base" 
                                        required
                                    >
                                    @error('organizer')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Organizer Email -->
                                <div class="space-y-2">
                                    <label for="organizerEmail" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-envelope mr-1 text-blue-600"></i>
                                        Email Address
                                    </label>
                                    <input 
                                        type="email" 
                                        name="organizerEmail" 
                                        id="organizerEmail" 
                                        placeholder="organizer@example.com"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base" 
                                        required
                                    >
                                    @error('organizer_email')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Contact Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Website -->
                                    <div class="space-y-2">
                                        <label for="organizerWebPage" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-globe mr-1 text-blue-600"></i>
                                            Website (Optional)
                                        </label>
                                        <input 
                                            type="url" 
                                            name="organizerWebPage" 
                                            id="organizerWebPage" 
                                            placeholder="https://organizer.com"
                                            class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                        >
                                        @error('organizerWebPage')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="space-y-2">
                                        <label for="organizerPhoneNumber" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-phone mr-1 text-blue-600"></i>
                                            Phone (Optional)
                                        </label>
                                        <input 
                                            type="tel" 
                                            name="organizerPhoneNumber" 
                                            id="organizerPhoneNumber" 
                                            placeholder="+1 234 567 8900"
                                            class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                        >
                                        @error('organizerPhoneNumber')
                                        <p class="text-red-500 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Research Areas Section -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                                <i class="fas fa-microscope mr-2"></i>
                                Research Areas
                            </h3>
                            
                            <div class="space-y-4">
                                <!-- Primary Area -->
                                <div class="space-y-2">
                                    <label for="primaryArea" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-star mr-1 text-green-600"></i>
                                        Primary Research Area (Optional)
                                    </label>
                                    <input 
                                        type="text" 
                                        name="primaryArea" 
                                        id="primaryArea" 
                                        placeholder="e.g., Computer Science"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                    >
                                    @error('primaryArea')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Secondary Area -->
                                <div class="space-y-2">
                                    <label for="secondaryArea" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-star-half-alt mr-1 text-green-600"></i>
                                        Secondary Research Area (Optional)
                                    </label>
                                    <input 
                                        type="text" 
                                        name="secondaryArea" 
                                        id="secondaryArea" 
                                        placeholder="e.g., Data Science"
                                        class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base"
                                    >
                                    @error('secondaryArea')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Topics Section -->
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800 mb-4 flex items-center">
                                <i class="fas fa-tags mr-2"></i>
                                Conference Topics
                            </h3>
                            
                            <!-- Topic Selection -->
                            <div class="space-y-4">
                                <!-- Predefined Topics -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-list mr-1 text-purple-600"></i>
                                        Select from Available Topics
                                    </label>
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <select id="availableTopics" class="form-select flex-1 rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base">
                                            <option value="" selected disabled>Choose a topic...</option>
                                            <option value="Artificial Intelligence">Artificial Intelligence</option>
                                            <option value="Machine Learning">Machine Learning</option>
                                            <option value="Cybersecurity">Cybersecurity</option>
                                            <option value="Data Science">Data Science</option>
                                            <option value="Software Engineering">Software Engineering</option>
                                            <option value="Computer Networks">Computer Networks</option>
                                            <option value="Human-Computer Interaction">Human-Computer Interaction</option>
                                            <option value="Cloud Computing">Cloud Computing</option>
                                            <option value="Internet of Things">Internet of Things</option>
                                            <option value="Blockchain">Blockchain</option>
                                        </select>
                                        <button type="button" onclick="addTopicFromSelect()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg whitespace-nowrap text-sm">
                                            <i class="fas fa-plus mr-1"></i>
                                            Add
                                        </button>
                                    </div>
                                </div>

                                <!-- Custom Topic -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-edit mr-1 text-purple-600"></i>
                                        Add Custom Topic
                                    </label>
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input 
                                            type="text" 
                                            id="topicInput" 
                                            placeholder="Enter custom topic" 
                                            class="form-input flex-1 rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base" 
                                        />
                                        <button type="button" onclick="addCustomTopic()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg whitespace-nowrap text-sm">
                                            <i class="fas fa-plus mr-1"></i>
                                            Add
                                        </button>
                                    </div>
                                    @error('topicInput')
                                    <p class="text-red-500 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Selected Topics Display -->
                                <div class="border border-purple-200 rounded-md p-4 bg-white">
                                    <h4 class="text-sm font-medium mb-3 text-gray-700 flex items-center">
                                        <i class="fas fa-check-circle mr-2 text-purple-600"></i>
                                        Selected Topics
                                    </h4>
                                    <ul id="topicList" class="space-y-2">
                                        <li class="text-gray-500 text-sm" id="noTopicsMessage">No topics selected yet</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Field -->
                        <input type="hidden" name="topics" id="topicsField">
                        @error('topics')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{$message}}
                        </p>
                        @enderror

                        <!-- Navigation Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                            <button type="button" id="prevButton" class="w-full sm:w-auto bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Previous
                            </button>
                            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center justify-center">
                                @if(session()->has('conference.step1') && session()->has('conference.step2') && session()->has('conference.step3') && session()->has('update'))
                                <i class="fas fa-save mr-2"></i>
                                Update Conference
                                @else
                                <i class="fas fa-check mr-2"></i>
                                Create Conference
                                @endif
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
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-600">Dates & Details</p>
                                        <p class="text-xs text-gray-500">Completed</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                        3
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-blue-600">Final Configuration</p>
                                        <p class="text-xs text-gray-500">Current step</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-6">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Progress</span>
                                    <span>99%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 99%;"></div>
                                </div>
                            </div>

                            <!-- Help Section -->
                            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Final Step!</h4>
                                <ul class="text-xs text-blue-700 space-y-1">
                                    <li>• Add organizer contact information</li>
                                    <li>• Select relevant conference topics</li>
                                    <li>• Review and submit your conference</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="col-span-8">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                            <form id="multiStepFormDesktop" method="POST" action="/create-conference/step3" class="space-y-8">
                                @csrf

                                <!-- Header -->
                                <div class="mb-8">
                                    <h2 class="text-2xl font-bold text-blue-800 flex items-center">
                                        <i class="fas fa-cog mr-3"></i>
                                        Final Configuration
                                    </h2>
                                    <p class="text-gray-600 mt-2">Complete your conference setup with organizer details and topics</p>
                                </div>

                                <!-- Organizer Information Section -->
                                <div class="bg-blue-50 p-6 rounded-lg">
                                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        Organizer Information
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Left Column -->
                                        <div class="space-y-6">
                                            <!-- Organizer Name -->
                                            <div class="space-y-2">
                                                <label for="organizerDesktop" class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-user mr-2 text-blue-600"></i>
                                                    Organizer Name
                                                </label>
                                                <input 
                                                    type="text" 
                                                    name="organizer" 
                                                    id="organizerDesktop" 
                                                    placeholder="Full name of the main organizer"
                                                    class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                                    required
                                                >
                                                @error('organizer')
                                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                                @enderror
                                            </div>

                                            <!-- Organizer Email -->
                                            <div class="space-y-2">
                                                <label for="organizerEmailDesktop" class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-envelope mr-2 text-blue-600"></i>
                                                    Email Address
                                                </label>
                                                <input 
                                                    type="email" 
                                                    name="organizerEmail" 
                                                    id="organizerEmailDesktop" 
                                                    placeholder="organizer@example.com"
                                                    class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                                    required
                                                >
                                                @error('organizer_email')
                                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="space-y-6">
                                            <!-- Website -->
                                            <div class="space-y-2">
                                                <label for="organizerWebPageDesktop" class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-globe mr-2 text-blue-600"></i>
                                                    Website
                                                </label>
                                                <input 
                                                    type="url" 
                                                    name="organizerWebPage" 
                                                    id="organizerWebPageDesktop" 
                                                    placeholder="https://organizer.com"
                                                    class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                >
                                                <p class="text-xs text-gray-500">Optional: Organization or personal website</p>
                                                @error('organizerWebPage')
                                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                                @enderror
                                            </div>

                                            <!-- Phone -->
                                            <div class="space-y-2">
                                                <label for="organizerPhoneNumberDesktop" class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-phone mr-2 text-blue-600"></i>
                                                    Phone Number
                                                </label>
                                                <input 
                                                    type="tel" 
                                                    name="organizerPhoneNumber" 
                                                    id="organizerPhoneNumberDesktop" 
                                                    placeholder="+1 234 567 8900"
                                                    class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                >
                                                <p class="text-xs text-gray-500">Optional: Contact phone number</p>
                                                @error('organizerPhoneNumber')
                                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Research Areas Section -->
                                <div class="bg-green-50 p-6 rounded-lg">
                                    <h3 class="text-lg font-semibold text-green-800 mb-6 flex items-center">
                                        <i class="fas fa-microscope mr-2"></i>
                                        Research Areas
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Primary Area -->
                                        <div class="space-y-2">
                                            <label for="primaryAreaDesktop" class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-star mr-2 text-green-600"></i>
                                                Primary Research Area
                                            </label>
                                            <input 
                                                type="text" 
                                                name="primaryArea" 
                                                id="primaryAreaDesktop" 
                                                placeholder="e.g., Computer Science"
                                                class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            >
                                            <p class="text-xs text-gray-500">Optional: Main research domain</p>
                                            @error('primaryArea')
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <!-- Secondary Area -->
                                        <div class="space-y-2">
                                            <label for="secondaryAreaDesktop" class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-star-half-alt mr-2 text-green-600"></i>
                                                Secondary Research Area
                                            </label>
                                            <input 
                                                type="text" 
                                                name="secondaryArea" 
                                                id="secondaryAreaDesktop" 
                                                placeholder="e.g., Data Science"
                                                class="form-input w-full rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            >
                                            <p class="text-xs text-gray-500">Optional: Secondary research domain</p>
                                            @error('secondaryArea')
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Topics Section -->
                                <div class="bg-purple-50 p-6 rounded-lg">
                                    <h3 class="text-lg font-semibold text-purple-800 mb-6 flex items-center">
                                        <i class="fas fa-tags mr-2"></i>
                                        Conference Topics
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Left Column - Topic Selection -->
                                        <div class="space-y-6">
                                            <!-- Predefined Topics -->
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-list mr-2 text-purple-600"></i>
                                                    Select from Available Topics
                                                </label>
                                                <div class="flex gap-2">
                                                    <select id="availableTopicsDesktop" class="form-select flex-1 rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                                        <option value="" selected disabled>Choose a topic...</option>
                                                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                                                        <option value="Machine Learning">Machine Learning</option>
                                                        <option value="Cybersecurity">Cybersecurity</option>
                                                        <option value="Data Science">Data Science</option>
                                                        <option value="Software Engineering">Software Engineering</option>
                                                        <option value="Computer Networks">Computer Networks</option>
                                                        <option value="Human-Computer Interaction">Human-Computer Interaction</option>
                                                        <option value="Cloud Computing">Cloud Computing</option>
                                                        <option value="Internet of Things">Internet of Things</option>
                                                        <option value="Blockchain">Blockchain</option>
                                                    </select>
                                                    <button type="button" onclick="addTopicFromSelectDesktop()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                                                        <i class="fas fa-plus mr-1"></i>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Custom Topic -->
                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    <i class="fas fa-edit mr-2 text-purple-600"></i>
                                                    Add Custom Topic
                                                </label>
                                                <div class="flex gap-2">
                                                    <input 
                                                        type="text" 
                                                        id="topicInputDesktop" 
                                                        placeholder="Enter custom topic" 
                                                        class="form-input flex-1 rounded-md px-4 py-3 bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                                    />
                                                    <button type="button" onclick="addCustomTopicDesktop()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg whitespace-nowrap">
                                                        <i class="fas fa-plus mr-1"></i>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column - Selected Topics -->
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-gray-700">
                                                <i class="fas fa-check-circle mr-2 text-purple-600"></i>
                                                Selected Topics
                                            </label>
                                            <div class="border border-purple-200 rounded-md p-4 bg-white min-h-[200px]">
                                                <ul id="topicListDesktop" class="space-y-2">
                                                    <li class="text-gray-500 text-sm" id="noTopicsMessageDesktop">No topics selected yet</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden Field -->
                                <input type="hidden" name="topics" id="topicsFieldDesktop">
                                @error('topics')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{$message}}
                                </p>
                                @enderror

                                <!-- Navigation Buttons -->
                                <div class="flex justify-between pt-8 border-t border-gray-200">
                                    <button type="button" id="prevButtonDesktop" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Previous Step
                                    </button>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
                                        @if(session()->has('conference.step1') && session()->has('conference.step2') && session()->has('conference.step3') && session()->has('update'))
                                        <i class="fas fa-save mr-2"></i>
                                        Update Conference
                                        @else
                                        <i class="fas fa-check mr-2"></i>
                                        Create Conference
                                        @endif
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
    .form-input:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Smooth transitions */
    .form-input, .form-select {
        transition: all 0.2s ease-in-out;
    }
    
    /* Hover effects */
    .form-input:hover, .form-select:hover {
        border-color: #93c5fd;
    }

    /* Topic list styling */
    .topic-item {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    var selectedTopics = [];

    // Mobile functions
    function addTopicFromSelect() {
        const select = document.getElementById('availableTopics');
        const topic = select.value;
        if (topic && !selectedTopics.includes(topic)) {
            selectedTopics.push(topic);
            renderSelectedTopics();
            select.value = '';
        } else if (selectedTopics.includes(topic)) {
            alert('This topic is already selected');
        }
    }

    function addCustomTopic() {
        const input = document.getElementById('topicInput');
        const topic = input.value.trim();
        if (topic !== '' && !selectedTopics.includes(topic)) {
            selectedTopics.push(topic);
            input.value = '';
            renderSelectedTopics();
        } else if (selectedTopics.includes(topic)) {
            alert('This topic is already selected');
        }
    }

    // Desktop functions
    function addTopicFromSelectDesktop() {
        const select = document.getElementById('availableTopicsDesktop');
        const topic = select.value;
        if (topic && !selectedTopics.includes(topic)) {
            selectedTopics.push(topic);
            renderSelectedTopicsDesktop();
            select.value = '';
        } else if (selectedTopics.includes(topic)) {
            alert('This topic is already selected');
        }
    }

    function addCustomTopicDesktop() {
        const input = document.getElementById('topicInputDesktop');
        const topic = input.value.trim();
        if (topic !== '' && !selectedTopics.includes(topic)) {
            selectedTopics.push(topic);
            input.value = '';
            renderSelectedTopicsDesktop();
        } else if (selectedTopics.includes(topic)) {
            alert('This topic is already selected');
        }
    }

    function removeTopic(index) {
        selectedTopics.splice(index, 1);
        renderSelectedTopics();
        renderSelectedTopicsDesktop();
    }

    function renderSelectedTopics() {
        const list = document.getElementById('topicList');
        const hiddenField = document.getElementById('topicsField');
        
        if (!list) return;

        list.innerHTML = '';
        if (selectedTopics.length === 0) {
            list.innerHTML = '<li class="text-gray-500 text-sm" id="noTopicsMessage">No topics selected yet</li>';
        } else {
            selectedTopics.forEach((topic, index) => {
                const li = document.createElement('li');
                li.className = 'flex items-center justify-between py-2 px-3 bg-purple-100 border border-purple-200 rounded-md shadow-sm topic-item';

                const span = document.createElement('span');
                span.textContent = topic;
                span.className = 'text-purple-800 text-sm font-medium';

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                removeBtn.className = 'text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 transition-colors';
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    removeTopic(index);
                };

                li.appendChild(span);
                li.appendChild(removeBtn);
                list.appendChild(li);
            });
        }

        if (hiddenField) {
            hiddenField.value = JSON.stringify(selectedTopics);
        }
    }

    function renderSelectedTopicsDesktop() {
        const list = document.getElementById('topicListDesktop');
        const hiddenField = document.getElementById('topicsFieldDesktop');
        
        if (!list) return;

        list.innerHTML = '';
        if (selectedTopics.length === 0) {
            list.innerHTML = '<li class="text-gray-500 text-sm" id="noTopicsMessageDesktop">No topics selected yet</li>';
        } else {
            selectedTopics.forEach((topic, index) => {
                const li = document.createElement('li');
                li.className = 'flex items-center justify-between py-2 px-3 bg-purple-100 border border-purple-200 rounded-md shadow-sm topic-item';

                const span = document.createElement('span');
                span.textContent = topic;
                span.className = 'text-purple-800 text-sm font-medium';

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                removeBtn.className = 'text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 transition-colors';
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    removeTopic(index);
                };

                li.appendChild(span);
                li.appendChild(removeBtn);
                list.appendChild(li);
            });
        }

        if (hiddenField) {
            hiddenField.value = JSON.stringify(selectedTopics);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Mobile event listeners
        const topicInput = document.getElementById('topicInput');
        if (topicInput) {
            topicInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addCustomTopic();
                }
            });
        }

        // Desktop event listeners
        const topicInputDesktop = document.getElementById('topicInputDesktop');
        if (topicInputDesktop) {
            topicInputDesktop.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addCustomTopicDesktop();
                }
            });
        }

        // Form validation for both mobile and desktop
        const forms = ['multiStepForm', 'multiStepFormDesktop'];
        forms.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function(e) {
                    const topicsField = document.getElementById(formId === 'multiStepForm' ? 'topicsField' : 'topicsFieldDesktop');
                    const errorId = formId + '-topics-error';

                    // Remove old error message if it exists
                    const oldError = document.getElementById(errorId);
                    if (oldError) oldError.remove();

                    // Check if topics field is empty (or contains empty array)
                    if (!topicsField.value || topicsField.value === '[]') {
                        e.preventDefault(); // Prevent form submission
                        const error = document.createElement('p');
                        error.id = errorId;
                        error.textContent = "Please select at least one topic.";
                        error.className = "text-red-500 text-sm mt-1 flex items-center";
                        error.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Please select at least one topic.';
                        topicsField.insertAdjacentElement('afterend', error);
                    }
                });
            }
        });

        // Previous button handlers
        const prevButton = document.getElementById('prevButton');
        if (prevButton) {
            prevButton.addEventListener('click', function() {
                window.location.href = '/create-conference/step2';
            });
        }

        const prevButtonDesktop = document.getElementById('prevButtonDesktop');
        if (prevButtonDesktop) {
            prevButtonDesktop.addEventListener('click', function() {
                window.location.href = '/create-conference/step2';
            });
        }
    });

    // Prevent back navigation
    window.onload = function() {
        history.pushState(null, document.title, location.href);
        window.addEventListener('popstate', function() {
            history.pushState(null, document.title, location.href);
        });
    };
</script>
@endsection
