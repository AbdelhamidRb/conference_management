@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-4">
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
            <i class="fas fa-cog text-blue-600 text-xl"></i>
        </div>
        <h1 class="mt-3 text-2xl md:text-3xl font-bold">Configuration</h1>
        <p class="mt-2 text-sm md:text-base text-gray-600">Manage your system configuration settings</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="mb-6 rounded-md bg-green-200 p-4 border border-green-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-900">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Mobile View (Cards) - jusqu'à 768px -->
    <div class="block md:hidden space-y-4">
        <form method="POST" action="{{ route('configurations.update', $configuration->conference_id) }}">
            @csrf
            @method('PUT')

            <!-- Maximum Articles Card -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-signature text-blue-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900">Maximum Articles</h3>
                            <p class="text-xs text-gray-500">Maximum number of articles allowed</p>
                        </div>
                    </div>
                    <div class="ml-4">
                        <input 
                            type="number"
                            name="numberArticle"
                            value="{{ $configuration->numberArticle }}"
                            class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 w-16 text-center"
                            min="1"
                        >
                    </div>
                </div>
            </div>

            <!-- Reviewers per Article Card -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-check text-blue-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900">Reviewers per Article</h3>
                            <p class="text-xs text-gray-500">Number of reviewers assigned per article</p>
                        </div>
                    </div>
                    <div class="ml-4">
                        <input 
                            type="number"
                            name="numberReviewer"
                            value="{{ $configuration->numberReviewer }}"
                            class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 w-16 text-center"
                            min="1"
                        >
                    </div>
                </div>
            </div>

            <!-- Submissions Allowed Card -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <i class="fas fa-paper-plane text-blue-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900">Submissions Allowed</h3>
                            <p class="text-xs text-gray-500">Allow new article submissions</p>
                        </div>
                    </div>
                    <div class="ml-4">
                        <select name="submissionAllowed" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="1" {{ $configuration->submissionAllowed ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ !$configuration->submissionAllowed ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Updates Allowed Card -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <i class="fas fa-sync-alt text-blue-500 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900">Updates Allowed</h3>
                            <p class="text-xs text-gray-500">Allow updates to existing submissions</p>
                        </div>
                    </div>
                    <div class="ml-4">
                        <select name="submissionUpdateAllowed" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="1" {{ $configuration->submissionUpdateAllowed ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ !$configuration->submissionUpdateAllowed ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Last Update Card -->
            <div class="bg-gray-50 rounded-lg shadow border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar-alt text-gray-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Last Update</h3>
                        <p class="text-xs text-gray-600">{{ \Carbon\Carbon::parse($configuration->updated_at)->isoFormat('LL [at] HH:mm') }}</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                <button 
                    type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Tablet View (Compact Cards) - 768px à 1024px -->
    <div class="hidden md:block lg:hidden">
        <form method="POST" action="{{ route('configurations.update', $configuration->conference_id) }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cog mr-2 text-blue-500"></i>
                        Conference Configuration
                    </h2>
                </div>

                <div class="divide-y divide-gray-200">
                    <!-- Maximum Articles -->
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-signature text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Maximum Articles</h3>
                                    <p class="text-sm text-gray-500">Maximum number of articles allowed per author</p>
                                </div>
                            </div>
                            <div class="ml-6">
                                <input 
                                    type="number"
                                    name="numberArticle"
                                    value="{{ $configuration->numberArticle }}"
                                    class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 w-20 text-center"
                                    min="1"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Reviewers per Article -->
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-check text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Reviewers per Article</h3>
                                    <p class="text-sm text-gray-500">Number of reviewers assigned to each article</p>
                                </div>
                            </div>
                            <div class="ml-6">
                                <input 
                                    type="number"
                                    name="numberReviewer"
                                    value="{{ $configuration->numberReviewer }}"
                                    class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 w-20 text-center"
                                    min="1"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Submissions Allowed -->
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-paper-plane text-purple-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Submissions Allowed</h3>
                                    <p class="text-sm text-gray-500">Allow new article submissions to the conference</p>
                                </div>
                            </div>
                            <div class="ml-6">
                                <select name="submissionAllowed" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="1" {{ $configuration->submissionAllowed ? 'selected' : '' }}>Enabled</option>
                                    <option value="0" {{ !$configuration->submissionAllowed ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Updates Allowed -->
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-sync-alt text-orange-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">Updates Allowed</h3>
                                    <p class="text-sm text-gray-500">Allow updates to existing submissions</p>
                                </div>
                            </div>
                            <div class="ml-6">
                                <select name="submissionUpdateAllowed" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="1" {{ $configuration->submissionUpdateAllowed ? 'selected' : '' }}>Enabled</option>
                                    <option value="0" {{ !$configuration->submissionUpdateAllowed ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Last Update -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-gray-600"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">Last Update</h3>
                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($configuration->updated_at)->isoFormat('LL [at] HH:mm') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <button 
                        type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Save Configuration
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Desktop View (Table) - 1024px et plus -->
    <div class="hidden lg:block">
        <div class="max-w-4xl mx-auto">
            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm bg-white">
                <form method="POST" action="{{ route('configurations.update', $configuration->conference_id) }}">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-cog mr-3 text-blue-500"></i>
                            Conference Configuration Settings
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">Manage the configuration parameters for your conference</p>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-cog mr-3 text-blue-500"></i>
                                        Parameter
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                    Value
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Maximum articles -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-file-signature text-blue-600 text-sm"></i>
                                        </div>
                                        Maximum Articles
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    Maximum number of articles allowed per author
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input 
                                        type="number"
                                        name="numberArticle"
                                        value="{{ $configuration->numberArticle }}"
                                        class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 w-24 text-center"
                                        min="1"
                                    >
                                </td>
                            </tr>

                            <!-- Reviewers per article -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150 bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-user-check text-green-600 text-sm"></i>
                                        </div>
                                        Reviewers per Article
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    Number of reviewers assigned to each article
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input 
                                        type="number"
                                        name="numberReviewer"
                                        value="{{ $configuration->numberReviewer }}"
                                        class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 w-24 text-center"
                                        min="1"
                                    >
                                </td>
                            </tr>

                            <!-- Submissions allowed -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-paper-plane text-purple-600 text-sm"></i>
                                        </div>
                                        Submissions Allowed
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    Allow new article submissions to the conference
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select name="submissionAllowed" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="1" {{ $configuration->submissionAllowed ? 'selected' : '' }}>
                                            <i class="fas fa-check mr-1"></i> Enabled
                                        </option>
                                        <option value="0" {{ !$configuration->submissionAllowed ? 'selected' : '' }}>
                                            <i class="fas fa-times mr-1"></i> Disabled
                                        </option>
                                    </select>
                                </td>
                            </tr>

                            <!-- Updates allowed -->
                            <tr class="hover:bg-gray-50 transition-colors duration-150 bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-sync-alt text-orange-600 text-sm"></i>
                                        </div>
                                        Updates Allowed
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    Allow updates to existing submissions
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select name="submissionUpdateAllowed" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="1" {{ $configuration->submissionUpdateAllowed ? 'selected' : '' }}>Enabled</option>
                                        <option value="0" {{ !$configuration->submissionUpdateAllowed ? 'selected' : '' }}>Disabled</option>
                                    </select>
                                </td>
                            </tr>

                            <!-- Last update (non-editable) -->
                            <tr class="bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-calendar-alt text-gray-600 text-sm"></i>
                                        </div>
                                        Last Update
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    When this configuration was last modified
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($configuration->updated_at)->isoFormat('LL [at] HH:mm') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Submit button -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                        <button 
                            type="submit"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Save Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom focus styles */
    input:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Smooth transitions */
    input, select, button {
        transition: all 0.2s ease-in-out;
    }
    
    /* Hover effects */
    input:hover, select:hover {
        border-color: #93c5fd;
    }

    /* Number input styling */
    input[type="number"] {
        -moz-appearance: textfield;
    }
    
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

@endsection
