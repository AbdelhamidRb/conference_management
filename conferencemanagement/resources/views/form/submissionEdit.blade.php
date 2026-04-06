@extends('dashboardUser.auteur.dashboardAuteur')

@section('content1')
<div class="min-h-screen bg-gray-50">
    <!-- Header Banner -->
    <div class="w-full py-6 md:py-8 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="container mx-auto px-4 md:px-6">
            <h1 class="text-2xl md:text-3xl font-bold text-center">Update Submission</h1>
            <p class="mt-2 text-blue-100 text-center max-w-2xl mx-auto text-sm md:text-base">
                Edit your submission details and co-authors
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center py-6 md:py-12 px-4">
        <div class="w-full max-w-7xl">
            <!-- Mobile View (Stacked Layout) - jusqu'à 768px -->
            <div class="block md:hidden">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="/userDashboard?acronyme={{$submission->conference->acronyme}}&role=auteur"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                </div>

                <!-- Alert Messages -->
                @if($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">{{ $errors->count() }} error(s)</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('submissions.update', $submission->idSubmission) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Submission Details Card -->
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                        <h2 class="text-lg font-semibold mb-4 flex items-center">
                            <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                            Submission Details
                        </h2>

                        <div class="space-y-4">
                            <!-- Title -->
                            <div>
                                <label for="titleMobile" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-heading mr-1 text-blue-600"></i>
                                    Title
                                </label>
                                <input type="text" name="title" id="titleMobile"
                                    value="{{ old('title', $submission->titre) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>

                            <!-- Keywords -->
                            <div>
                                <label for="keywordsMobile" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-tags mr-1 text-blue-600"></i>
                                    Keywords
                                </label>
                                <input type="text" name="keywords" id="keywordsMobile"
                                    value="{{ old('keywords', $submission->keywords) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            </div>

                            <!-- Abstract -->
                            <div>
                                <label for="abstractMobile" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-align-left mr-1 text-blue-600"></i>
                                    Abstract
                                </label>
                                <textarea name="abstract" id="abstractMobile" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('abstract', $submission->resume) }}</textarea>
                            </div>

                            <!-- PDF File -->
                            <div>
                                <label for="paper_fileMobile" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-file-pdf mr-1 text-blue-600"></i>
                                    PDF File
                                </label>
                                <input type="file" name="paper_file" id="paper_fileMobile"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-xs text-gray-500">Current: {{ basename($submission->latestPdf->pdf) }}</p>
                                <p class="mt-1 text-xs text-gray-500">Leave empty to keep current file</p>
                            </div>
                        </div>
                    </div>

                    <!-- Corresponding Author Card -->
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                        <h3 class="text-lg font-semibold mb-3 flex items-center">
                            <i class="fas fa-user-check mr-2 text-green-600"></i>
                            Corresponding Author
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $submission->primaryAuthor->firstName }} {{ $submission->primaryAuthor->user->lastName }}
                                    </p>
                                    <p class="text-xs text-gray-600">{{ $submission->primaryAuthor->user->email }}</p>
                                    <p class="text-xs text-gray-600">{{ $submission->primaryAuthor->user->affiliation }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-red-600 mt-2">
                                <i class="fas fa-lock mr-1"></i>
                                Cannot be changed
                            </p>
                        </div>
                    </div>

                    <!-- Co-Authors Card -->
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-users mr-2 text-purple-600"></i>
                                Co-Authors
                            </h3>
                            <button type="button" id="add-co-author-mobile" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                <i class="fas fa-plus mr-1"></i> Add
                            </button>
                        </div>

                        <div id="co-authors-mobile" class="space-y-3">
                            @foreach($submission->secondaryAuthors as $index => $author)
                            <div class="co-author-card bg-gray-50 rounded-lg p-3 border border-gray-200">
                                <input type="hidden" name="co_authors[{{ $index }}][id]" value="{{ $author->id }}">
                                
                                <div class="space-y-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700">First Name</label>
                                            <input type="text" name="co_authors[{{ $index }}][first_name]"
                                                value="{{ old('co_authors.$index.first_name', $author->user->firstName) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700">Last Name</label>
                                            <input type="text" name="co_authors[{{ $index }}][last_name]"
                                                value="{{ old('co_authors.$index.last_name', $author->user->lastName) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700">Email</label>
                                        <input type="email" name="co_authors[{{ $index }}][email]"
                                            value="{{ old('co_authors.$index.email', $author->user->email) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700">Affiliation</label>
                                        <input type="text" name="co_authors[{{ $index }}][affiliation]"
                                            value="{{ old('co_authors.$index.affiliation', $author->user->affiliation) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <button type="button" class="remove-co-author-mobile text-red-600 hover:text-red-900 text-sm">
                                            <i class="fas fa-trash mr-1"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div id="no-coauthors-mobile" class="text-center py-6 text-gray-500 {{ count($submission->secondaryAuthors) > 0 ? 'hidden' : '' }}">
                            <i class="fas fa-user-plus text-2xl mb-2"></i>
                            <p class="text-sm">No co-authors added yet</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                        <div class="flex flex-col space-y-3">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i> Update Submission
                            </button>
                            <a href="/userDashboard?acronyme={{$submission->conference->acronyme}}&role=auteur"
                                class="w-full inline-flex justify-center items-center px-4 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tablet View (Two Column Layout) - 768px à 1024px -->
            <div class="hidden md:block lg:hidden">
                <div class="grid grid-cols-12 gap-6">
                    <!-- Sidebar -->
                    <div class="col-span-4">
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 sticky top-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Progress</h3>
                            
                            <!-- Current Submission Info -->
                            <div class="space-y-4 mb-6">
                                <div class="p-4 bg-blue-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-blue-900 mb-2">Current Submission</h4>
                                    <p class="text-sm text-blue-700 font-semibold">{{ $submission->titre }}</p>
                                    <p class="text-xs text-blue-600 mt-1">{{ $submission->conference->acronyme }}</p>
                                </div>
                            </div>

                            <!-- Guidelines -->
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Update Guidelines</h4>
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <li>• Modify submission details as needed</li>
                                    <li>• Add or remove co-authors</li>
                                    <li>• Upload new PDF if required</li>
                                    <li>• Corresponding author cannot be changed</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-span-8">
                        <!-- Back Button -->
                        <div class="mb-6">
                            <a href="/userDashboard?acronyme={{$submission->conference->acronyme}}&role=auteur"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                            </a>
                        </div>

                        <!-- Alert Messages -->
                        @if($errors->any())
                        <div class="mb-6 rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc space-y-1 pl-5">
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('submissions.update', $submission->idSubmission) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Submission Details -->
                            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                                <h2 class="text-xl font-semibold mb-4 flex items-center">
                                    <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                                    Submission Details
                                </h2>

                                <div class="space-y-4">
                                    <!-- Title -->
                                    <div>
                                        <label for="titleTablet" class="block text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" name="title" id="titleTablet"
                                            value="{{ old('title', $submission->titre) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <!-- Keywords -->
                                    <div>
                                        <label for="keywordsTablet" class="block text-sm font-medium text-gray-700">Keywords</label>
                                        <input type="text" name="keywords" id="keywordsTablet"
                                            value="{{ old('keywords', $submission->keywords) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <!-- Abstract -->
                                    <div>
                                        <label for="abstractTablet" class="block text-sm font-medium text-gray-700">Abstract</label>
                                        <textarea name="abstract" id="abstractTablet" rows="5"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('abstract', $submission->resume) }}</textarea>
                                    </div>

                                    <!-- PDF File -->
                                    <div>
                                        <label for="paper_fileTablet" class="block text-sm font-medium text-gray-700">
                                            PDF File (Leave empty to keep current file)
                                        </label>
                                        <input type="file" name="paper_file" id="paper_fileTablet"
                                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <p class="mt-1 text-sm text-gray-500">Current file: {{ basename($submission->latestPdf->pdf) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Corresponding Author -->
                            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-user-check mr-2 text-green-600"></i>
                                    Corresponding Author
                                    <span class="ml-2 text-sm text-red-600">(Cannot be changed)</span>
                                </h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $submission->primaryAuthor->firstName }} {{ $submission->primaryAuthor->user->lastName }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $submission->primaryAuthor->user->email }}</p>
                                            <p class="text-sm text-gray-600">{{ $submission->primaryAuthor->user->affiliation }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Co-Authors -->
                            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold flex items-center">
                                        <i class="fas fa-users mr-2 text-purple-600"></i>
                                        Co-Authors
                                    </h3>
                                    <button type="button" id="add-co-author-tablet" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                        <i class="fas fa-plus mr-2"></i> Add Co-Author
                                    </button>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliation</th>
                                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="co-authors-table-body-tablet" class="bg-white divide-y divide-gray-200">
                                            @foreach($submission->secondaryAuthors as $index => $author)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">
                                                    <input type="hidden" name="co_authors[{{ $index }}][id]" value="{{ $author->id }}">
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <input type="text" name="co_authors[{{ $index }}][first_name]"
                                                            value="{{ old('co_authors.$index.first_name', $author->user->firstName) }}"
                                                            placeholder="First name"
                                                            class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                                        <input type="text" name="co_authors[{{ $index }}][last_name]"
                                                            value="{{ old('co_authors.$index.last_name', $author->user->lastName) }}"
                                                            placeholder="Last name"
                                                            class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="email" name="co_authors[{{ $index }}][email]"
                                                        value="{{ old('co_authors.$index.email', $author->user->email) }}"
                                                        class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="text" name="co_authors[{{ $index }}][affiliation]"
                                                        value="{{ old('co_authors.$index.affiliation', $author->user->affiliation) }}"
                                                        class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                                </td>
                                                <td class="px-4 py-3 text-right">
                                                    <button type="button" class="remove-co-author text-red-600 hover:text-red-900">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div id="no-coauthors-tablet" class="text-center py-8 text-gray-500 {{ count($submission->secondaryAuthors) > 0 ? 'hidden' : '' }}">
                                    <i class="fas fa-user-plus text-3xl mb-2"></i>
                                    <p>No co-authors added yet</p>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                                <div class="flex justify-between">
                                    <a href="/userDashboard?acronyme={{$submission->conference->acronyme}}&role=auteur"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-times mr-2"></i> Cancel
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                        <i class="fas fa-check mr-2"></i> Update Submission
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Desktop View (Enhanced Layout) - 1024px et plus -->
            <div class="hidden lg:block">
                <div class="grid grid-cols-12 gap-8">
                    <!-- Sidebar -->
                    <div class="col-span-3">
                        <div class="bg-white rounded-xl shadow border border-gray-200 p-6 sticky top-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Update Submission</h3>
                            
                            <!-- Current Submission Info -->
                            <div class="space-y-4 mb-8">
                                <div class="p-4 bg-blue-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-blue-900 mb-2 flex items-center">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        Current Submission
                                    </h4>
                                    <p class="text-sm text-blue-700 font-semibold">{{ $submission->titre }}</p>
                                    <p class="text-xs text-blue-600 mt-1">{{ $submission->conference->acronyme }}</p>
                                </div>
                            </div>

                            <!-- Guidelines -->
                            <div class="p-4 bg-gray-50 rounded-lg mb-6">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Update Guidelines</h4>
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <li>• Modify submission details as needed</li>
                                    <li>• Add or remove co-authors</li>
                                    <li>• Upload new PDF if required</li>
                                    <li>• Corresponding author cannot be changed</li>
                                </ul>
                            </div>

                            <!-- File Info -->
                            <div class="p-4 bg-yellow-50 rounded-lg">
                                <h4 class="text-sm font-medium text-yellow-900 mb-2 flex items-center">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    Current File
                                </h4>
                                <p class="text-xs text-yellow-700">{{ basename($submission->latestPdf->pdf) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-span-9">
                        <!-- Back Button -->
                        <div class="mb-8">
                            <a href="/userDashboard?acronyme={{$submission->conference->acronyme}}&role=auteur"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                            </a>
                        </div>

                        <!-- Alert Messages -->
                        @if($errors->any())
                        <div class="mb-8 rounded-lg bg-red-50 p-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc space-y-1 pl-5">
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('submissions.update', $submission->idSubmission) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                            @csrf
                            @method('PUT')

                            <!-- Submission Details -->
                            <div class="bg-white rounded-xl shadow border border-gray-200 p-8">
                                <div class="mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                                        <i class="fas fa-file-alt mr-3 text-blue-600"></i>
                                        Submission Details
                                    </h2>
                                    <p class="text-gray-600 mt-2">Update your paper information and content</p>
                                </div>

                                <div class="grid grid-cols-1 gap-6">
                                    <!-- Title -->
                                    <div>
                                        <label for="titleDesktop" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-heading mr-2 text-blue-600"></i>
                                            Paper Title
                                        </label>
                                        <input type="text" name="title" id="titleDesktop"
                                            value="{{ old('title', $submission->titre) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base">
                                    </div>

                                    <!-- Keywords -->
                                    <div>
                                        <label for="keywordsDesktop" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-tags mr-2 text-blue-600"></i>
                                            Keywords
                                        </label>
                                        <input type="text" name="keywords" id="keywordsDesktop"
                                            value="{{ old('keywords', $submission->keywords) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base">
                                        <p class="mt-1 text-sm text-gray-500">Separate keywords with commas</p>
                                    </div>

                                    <!-- Abstract -->
                                    <div>
                                        <label for="abstractDesktop" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-align-left mr-2 text-blue-600"></i>
                                            Abstract
                                        </label>
                                        <textarea name="abstract" id="abstractDesktop" rows="6"
                                            class="mt-1 block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base">{{ old('abstract', $submission->resume) }}</textarea>
                                    </div>

                                    <!-- PDF File -->
                                    <div>
                                        <label for="paper_fileDesktop" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-file-pdf mr-2 text-blue-600"></i>
                                            PDF File
                                        </label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-500 transition-colors">
                                            <div class="space-y-1 text-center">
                                                <i class="fas fa-file-pdf mx-auto text-3xl text-gray-400"></i>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="paper_fileDesktop" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                                        <span>Upload a new file</span>
                                                        <input id="paper_fileDesktop" name="paper_file" type="file" class="sr-only">
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PDF up to 20MB</p>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            <strong>Current file:</strong> {{ basename($submission->latestPdf->pdf) }}
                                        </p>
                                        <p class="mt-1 text-sm text-gray-500">Leave empty to keep the current file</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Corresponding Author -->
                            <div class="bg-white rounded-xl shadow border border-gray-200 p-8">
                                <div class="mb-6">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <i class="fas fa-user-check mr-3 text-green-600"></i>
                                        Corresponding Author
                                        <span class="ml-3 text-sm text-red-600 font-normal">(Cannot be changed)</span>
                                    </h3>
                                    <p class="text-gray-600 mt-2">The corresponding author receives all communication regarding this submission</p>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0 h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-lg font-medium text-gray-900">
                                                {{ $submission->primaryAuthor->firstName }} {{ $submission->primaryAuthor->user->lastName }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $submission->primaryAuthor->user->email }}</p>
                                            <p class="text-sm text-gray-600">{{ $submission->primaryAuthor->user->affiliation }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Co-Authors -->
                            <div class="bg-white rounded-xl shadow border border-gray-200 p-8">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                            <i class="fas fa-users mr-3 text-purple-600"></i>
                                            Co-Authors
                                        </h3>
                                        <p class="text-gray-600 mt-2">Manage the co-authors for this submission</p>
                                    </div>
                                    <button type="button" id="add-co-author-desktop" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-plus mr-2"></i> Add Co-Author
                                    </button>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliation</th>
                                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="co-authors-table-body-desktop" class="bg-white divide-y divide-gray-200">
                                            @foreach($submission->secondaryAuthors as $index => $author)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4">
                                                    <input type="hidden" name="co_authors[{{ $index }}][id]" value="{{ $author->id }}">
                                                    <input type="text" name="co_authors[{{ $index }}][first_name]"
                                                        value="{{ old('co_authors.$index.first_name', $author->user->firstName) }}"
                                                        class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" name="co_authors[{{ $index }}][last_name]"
                                                        value="{{ old('co_authors.$index.last_name', $author->user->lastName) }}"
                                                        class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="email" name="co_authors[{{ $index }}][email]"
                                                        value="{{ old('co_authors.$index.email', $author->user->email) }}"
                                                        class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" name="co_authors[{{ $index }}][affiliation]"
                                                        value="{{ old('co_authors.$index.affiliation', $author->user->affiliation) }}"
                                                        class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <button type="button" class="remove-co-author text-red-600 hover:text-red-900 focus:outline-none">
                                                        <i class="fas fa-trash mr-1"></i> Remove
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div id="no-coauthors-desktop" class="text-center py-12 text-gray-500 {{ count($submission->secondaryAuthors) > 0 ? 'hidden' : '' }}">
                                    <i class="fas fa-user-plus text-4xl mb-4"></i>
                                    <h4 class="text-lg font-medium mb-2">No co-authors added yet</h4>
                                    <p class="text-sm">Click "Add Co-Author" to add collaborators to this submission</p>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="bg-white rounded-xl shadow border border-gray-200 p-8">
                                <div class="flex justify-between items-center">
                                    <a href="/userDashboard?acronyme={{$submission->conference->acronyme}}&role=auteur"
                                        class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-times mr-2"></i> Cancel Changes
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                                        <i class="fas fa-check mr-2"></i> Update Submission
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom focus styles */
    input:focus, textarea:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Smooth transitions */
    input, textarea, button {
        transition: all 0.2s ease-in-out;
    }
    
    /* Hover effects */
    input:hover, textarea:hover {
        border-color: #93c5fd;
    }

    /* Co-author card animations */
    .co-author-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .co-author-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Table row hover */
    tbody tr:hover {
        background-color: #f9fafb;
    }

    /* File upload area styling */
    .file-uploaded {
        border-color: #10b981 !important;
        background-color: #ecfdf5 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize for all screen sizes
        const screenSizes = ['mobile', 'tablet', 'desktop'];
        let authorIndex = {{count($submission->secondaryAuthors) ?? 0}};

        screenSizes.forEach(size => {
            initializeCoAuthorManagement(size);
        });

        function initializeCoAuthorManagement(size) {
            const addButton = document.getElementById(`add-co-author-${size}`);
            const tableBody = document.getElementById(`co-authors-table-body-${size}`);
            const mobileContainer = document.getElementById('co-authors-mobile');
            const noCoauthorsElement = document.getElementById(`no-coauthors-${size}`);

            if (addButton) {
                addButton.addEventListener('click', function() {
                    if (size === 'mobile') {
                        addCoAuthorMobile();
                    } else {
                        addCoAuthorTable(size);
                    }
                    updateNoCoauthorsDisplay(size);
                });
            }

            // Remove co-author functionality
            const container = size === 'mobile' ? mobileContainer : tableBody;
            if (container) {
                container.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-co-author') || e.target.closest('.remove-co-author-mobile')) {
                        e.target.closest(size === 'mobile' ? '.co-author-card' : 'tr').remove();
                        updateNoCoauthorsDisplay(size);
                    }
                });
            }
        }

        function addCoAuthorMobile() {
            const container = document.getElementById('co-authors-mobile');
            const newCard = document.createElement('div');
            newCard.className = 'co-author-card bg-gray-50 rounded-lg p-3 border border-gray-200';
            
            newCard.innerHTML = `
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">First Name</label>
                            <input type="text" name="co_authors[${authorIndex}][first_name]" required
                                class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Last Name</label>
                            <input type="text" name="co_authors[${authorIndex}][last_name]" required
                                class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Email</label>
                        <input type="email" name="co_authors[${authorIndex}][email]" required
                            class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Affiliation</label>
                        <input type="text" name="co_authors[${authorIndex}][affiliation]" required
                            class="mt-1 block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="button" class="remove-co-author-mobile text-red-600 hover:text-red-900 text-sm">
                            <i class="fas fa-trash mr-1"></i> Remove
                        </button>
                    </div>
                </div>
            `;
            
            container.appendChild(newCard);
            authorIndex++;
        }

        function addCoAuthorTable(size) {
            const tableBody = document.getElementById(`co-authors-table-body-${size}`);
            const newRow = document.createElement('tr');
            newRow.className = 'hover:bg-gray-50';
            
            if (size === 'tablet') {
                newRow.innerHTML = `
                    <td class="px-4 py-3">
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="co_authors[${authorIndex}][first_name]" required
                                placeholder="First name"
                                class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <input type="text" name="co_authors[${authorIndex}][last_name]" required
                                placeholder="Last name"
                                class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <input type="email" name="co_authors[${authorIndex}][email]" required
                            class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </td>
                    <td class="px-4 py-3">
                        <input type="text" name="co_authors[${authorIndex}][affiliation]" required
                            class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </td>
                    <td class="px-4 py-3 text-right">
                        <button type="button" class="remove-co-author text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
            } else {
                newRow.innerHTML = `
                    <td class="px-6 py-4">
                        <input type="text" name="co_authors[${authorIndex}][first_name]" required
                            class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4">
                        <input type="text" name="co_authors[${authorIndex}][last_name]" required
                            class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4">
                        <input type="email" name="co_authors[${authorIndex}][email]" required
                            class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4">
                        <input type="text" name="co_authors[${authorIndex}][affiliation]" required
                            class="block w-full rounded-md border-gray-300 py-2 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" class="remove-co-author text-red-600 hover:text-red-900 focus:outline-none">
                            <i class="fas fa-trash mr-1"></i> Remove
                        </button>
                    </td>
                `;
            }

            tableBody.appendChild(newRow);
            authorIndex++;
        }

        function updateNoCoauthorsDisplay(size) {
            const noCoauthorsElement = document.getElementById(`no-coauthors-${size}`);
            const container = size === 'mobile' ? 
                document.getElementById('co-authors-mobile') : 
                document.getElementById(`co-authors-table-body-${size}`);
            
            if (noCoauthorsElement && container) {
                const hasCoauthors = container.children.length > 0;
                noCoauthorsElement.classList.toggle('hidden', hasCoauthors);
            }
        }

        // File upload enhancement for desktop
        const fileInput = document.getElementById('paper_fileDesktop');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const fileName = this.files[0]?.name;
                if (fileName) {
                    const uploadArea = this.closest('.border-dashed');
                    uploadArea.classList.add('file-uploaded');
                    uploadArea.querySelector('span').textContent = `Selected: ${fileName}`;
                }
            });
        }
    });
</script>
@endsection
