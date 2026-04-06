@extends('layouts.app')

@section('title', 'FSTconference 2024 - Paper Submission')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Banner -->
    <div class="w-full py-6 md:py-8 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="container mx-auto px-4 md:px-6">
            <h1 class="text-2xl md:text-3xl font-bold text-center">Paper Submission</h1>
            <p class="mt-2 text-blue-100 text-center max-w-2xl mx-auto text-sm md:text-base">
                Submit your paper for <span class="font-bold">{{ $conference->acronyme }}</span>
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center py-6 md:py-12 px-4">
        <div class="w-full max-w-5xl">
            <!-- Mobile View (Stacked Layout) - jusqu'à 768px -->
            <div class="block md:hidden">
                <!-- Progress Indicator -->
                <div class="mb-6 bg-white rounded-lg shadow border border-gray-200 p-4">
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                        <span>Step 1 of 2</span>
                        <span>50%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 50%;"></div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
                @endif

                <!-- Form Card -->
                <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-semibold">1</div>
                            <h3 class="text-lg font-semibold text-gray-900">Paper Information</h3>
                        </div>
                        <p class="text-sm text-gray-600">Please provide the details of your paper submission</p>
                    </div>

                    <form id="paperSubmissionFormMobile" action="/store1" enctype="multipart/form-data" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="conference" value="{{ $conference->acronyme }}">

                        <!-- Title -->
                        <div class="space-y-2">
                            <label for="paperTitleMobile" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-heading mr-1 text-blue-600"></i>
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="paperTitleMobile" 
                                name="title" 
                                required
                                class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                placeholder="Enter your paper title" 
                                value="{{ old('title') }}"
                            >
                            @error('title')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Abstract -->
                        <div class="space-y-2">
                            <label for="paperAbstractMobile" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-align-left mr-1 text-blue-600"></i>
                                Abstract <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="paperAbstractMobile" 
                                name="abstract" 
                                rows="4" 
                                required
                                class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                placeholder="Enter your abstract"
                            >{{ old('abstract') }}</textarea>
                            @error('abstract')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Keywords -->
                        <div class="space-y-2">
                            <label for="paperKeywordsMobile" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-tags mr-1 text-blue-600"></i>
                                Keywords <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="paperKeywordsMobile" 
                                name="keywords" 
                                required
                                class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                placeholder="keyword1, keyword2, keyword3" 
                                value="{{ old('keywords') }}"
                            >
                            <p class="mt-1 text-xs text-gray-500">Separate keywords with commas</p>
                            @error('keywords')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-file-pdf mr-1 text-blue-600"></i>
                                Paper File <span class="text-red-500">*</span>
                            </label>
                            <div id="fileUploadAreaMobile" class="mt-1 flex justify-center px-4 pt-4 pb-4 border-2 border-gray-300 border-dashed rounded-md transition-colors hover:border-blue-500">
                                <div class="space-y-2 text-center">
                                    <i class="fas fa-file-pdf mx-auto text-2xl text-gray-400"></i>
                                    <div class="text-sm text-gray-600">
                                        <label for="paperFileMobile" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>Choose file</span>
                                            <input id="paperFileMobile" name="paper_file" type="file" class="sr-only" accept=".pdf" required>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF up to 20MB</p>
                                    <div id="fileNameMobile" class="mt-2 text-sm font-medium text-gray-900 hidden"></div>
                                </div>
                            </div>
                            @error('paper_file')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full flex justify-center items-center rounded-md border border-transparent bg-blue-600 py-3 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Next: Author Information
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tablet View (Two Column Layout) - 768px à 1024px -->
            <div class="hidden md:block lg:hidden">
                <div class="grid grid-cols-12 gap-6">
                    <!-- Progress Sidebar -->
                    <div class="col-span-4">
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 sticky top-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Submission Progress</h3>
                            
                            <!-- Progress Steps -->
                            <div class="space-y-4 mb-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                        1
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-blue-600">Paper Information</p>
                                        <p class="text-xs text-gray-500">Current step</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">
                                        2
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-400">Author Information</p>
                                        <p class="text-xs text-gray-400">Next step</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-6">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Progress</span>
                                    <span>50%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 50%;"></div>
                                </div>
                            </div>

                            <!-- Conference Info -->
                            <div class="p-4 bg-blue-50 rounded-lg">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Conference</h4>
                                <p class="text-sm text-blue-700 font-semibold">{{ $conference->acronyme }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="col-span-8">
                        <!-- Alert Messages -->
                        @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ session('error') }}
                            </div>
                        </div>
                        @endif

                        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-file-alt mr-3 text-blue-600"></i>
                                    Paper Information
                                </h2>
                                <p class="text-gray-600 mt-2">Please provide the details of your paper submission</p>
                            </div>

                            <form id="paperSubmissionFormTablet" action="/store1" enctype="multipart/form-data" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="conference" value="{{ $conference->acronyme }}">

                                <!-- Title -->
                                <div class="space-y-2">
                                    <label for="paperTitleTablet" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-heading mr-2 text-blue-600"></i>
                                        Title <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="paperTitleTablet" 
                                        name="title" 
                                        required
                                        class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Enter your paper title" 
                                        value="{{ old('title') }}"
                                    >
                                    @error('title')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Abstract -->
                                <div class="space-y-2">
                                    <label for="paperAbstractTablet" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-align-left mr-2 text-blue-600"></i>
                                        Abstract <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        id="paperAbstractTablet" 
                                        name="abstract" 
                                        rows="5" 
                                        required
                                        class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Enter your abstract"
                                    >{{ old('abstract') }}</textarea>
                                    @error('abstract')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Keywords -->
                                <div class="space-y-2">
                                    <label for="paperKeywordsTablet" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-tags mr-2 text-blue-600"></i>
                                        Keywords <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="paperKeywordsTablet" 
                                        name="keywords" 
                                        required
                                        class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="keyword1, keyword2, keyword3" 
                                        value="{{ old('keywords') }}"
                                    >
                                    <p class="mt-1 text-sm text-gray-500">Separate keywords with commas (e.g., machine learning, artificial intelligence)</p>
                                    @error('keywords')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- File Upload -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-file-pdf mr-2 text-blue-600"></i>
                                        Paper File <span class="text-red-500">*</span>
                                    </label>
                                    <div id="fileUploadAreaTablet" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md transition-colors hover:border-blue-500">
                                        <div class="space-y-1 text-center">
                                            <i class="fas fa-file-pdf mx-auto text-3xl text-gray-400"></i>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="paperFileTablet" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                                    <span>Upload a file</span>
                                                    <input id="paperFileTablet" name="paper_file" type="file" class="sr-only" accept=".pdf" required>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF up to 20MB</p>
                                            <div id="fileNameTablet" class="mt-2 text-sm font-medium text-gray-900 hidden"></div>
                                        </div>
                                    </div>
                                    @error('paper_file')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end pt-6 border-t border-gray-200">
                                    <button type="submit" class="flex justify-center items-center rounded-md border border-transparent bg-blue-600 py-3 px-6 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                        Next: Author Information
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop View (Enhanced Layout) - 1024px et plus -->
            <div class="hidden lg:block">
                <div class="grid grid-cols-12 gap-8">
                    <!-- Progress Sidebar -->
                    <div class="col-span-3">
                        <div class="bg-white rounded-xl shadow border border-gray-200 p-6 sticky top-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Submission Progress</h3>
                            
                            <!-- Progress Steps -->
                            <div class="space-y-6 mb-8">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-medium">
                                        1
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-blue-600">Paper Information</p>
                                        <p class="text-xs text-gray-500">Current step</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-medium">
                                        2
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-400">Author Information</p>
                                        <p class="text-xs text-gray-400">Next step</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-8">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Progress</span>
                                    <span>50%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: 50%;"></div>
                                </div>
                            </div>

                            <!-- Conference Info -->
                            <div class="p-4 bg-blue-50 rounded-lg mb-6">
                                <h4 class="text-sm font-medium text-blue-900 mb-2 flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>
                                    Conference
                                </h4>
                                <p class="text-sm text-blue-700 font-semibold">{{ $conference->acronyme }}</p>
                            </div>

                            <!-- Help Section -->
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Submission Guidelines</h4>
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <li>• PDF format only</li>
                                    <li>• Maximum file size: 20MB</li>
                                    <li>• Include all required information</li>
                                    <li>• Review before submission</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="col-span-9">
                        <!-- Alert Messages -->
                        @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-8">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                                <div>
                                    <h4 class="font-medium">Submission Error</h4>
                                    <p class="text-sm">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="bg-white rounded-xl shadow border border-gray-200 p-8">
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-file-alt mr-3 text-blue-600"></i>
                                    Paper Information
                                </h2>
                                <p class="text-gray-600 mt-2">Please provide the details of your paper submission for {{ $conference->acronyme }}</p>
                            </div>

                            <form id="paperSubmissionFormDesktop" action="/store1" enctype="multipart/form-data" method="POST" class="space-y-8">
                                @csrf
                                <input type="hidden" name="conference" value="{{ $conference->acronyme }}">

                                <!-- Title -->
                                <div class="space-y-2">
                                    <label for="paperTitleDesktop" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-heading mr-2 text-blue-600"></i>
                                        Paper Title <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="paperTitleDesktop" 
                                        name="title" 
                                        required
                                        class="block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base"
                                        placeholder="Enter your paper title" 
                                        value="{{ old('title') }}"
                                    >
                                    <p class="text-xs text-gray-500">Choose a clear and descriptive title for your paper</p>
                                    @error('title')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Abstract -->
                                <div class="space-y-2">
                                    <label for="paperAbstractDesktop" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-align-left mr-2 text-blue-600"></i>
                                        Abstract <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        id="paperAbstractDesktop" 
                                        name="abstract" 
                                        rows="6" 
                                        required
                                        class="block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base"
                                        placeholder="Enter your abstract"
                                    >{{ old('abstract') }}</textarea>
                                    <p class="text-xs text-gray-500">Provide a concise summary of your research (recommended: 150-300 words)</p>
                                    @error('abstract')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Keywords -->
                                <div class="space-y-2">
                                    <label for="paperKeywordsDesktop" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-tags mr-2 text-blue-600"></i>
                                        Keywords <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="paperKeywordsDesktop" 
                                        name="keywords" 
                                        required
                                        class="block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base"
                                        placeholder="keyword1, keyword2, keyword3" 
                                        value="{{ old('keywords') }}"
                                    >
                                    <p class="text-xs text-gray-500">Separate keywords with commas (e.g., machine learning, artificial intelligence, data mining)</p>
                                    @error('keywords')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- File Upload -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-file-pdf mr-2 text-blue-600"></i>
                                        Paper File <span class="text-red-500">*</span>
                                    </label>
                                    <div id="fileUploadAreaDesktop" class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-lg transition-colors hover:border-blue-500 hover:bg-blue-50">
                                        <div class="space-y-2 text-center">
                                            <i class="fas fa-file-pdf mx-auto text-4xl text-gray-400"></i>
                                            <div class="flex text-base text-gray-600">
                                                <label for="paperFileDesktop" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="paperFileDesktop" name="paper_file" type="file" class="sr-only" accept=".pdf" required>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-sm text-gray-500">PDF up to 20MB</p>
                                            <div id="fileNameDesktop" class="mt-3 text-base font-medium text-gray-900 hidden"></div>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500">Upload your paper in PDF format. Ensure all fonts are embedded and the file is complete.</p>
                                    @error('paper_file')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end pt-8 border-t border-gray-200">
                                    <button type="submit" class="flex justify-center items-center rounded-md border border-transparent bg-blue-600 py-4 px-8 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                        Continue to Author Information
                                        <i class="fas fa-arrow-right ml-3"></i>
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

    /* File upload area styling */
    .file-uploaded {
        border-color: #10b981 !important;
        background-color: #ecfdf5 !important;
    }

    /* Progress bar animation */
    .progress-bar {
        transition: width 0.5s ease-in-out;
    }
</style>

<script>
    // Handle file upload display for all screen sizes
    function setupFileUpload(fileInputId, fileNameId, uploadAreaId) {
        const fileInput = document.getElementById(fileInputId);
        const fileNameDiv = document.getElementById(fileNameId);
        const fileUploadArea = document.getElementById(uploadAreaId);
        
        if (!fileInput || !fileNameDiv || !fileUploadArea) return;

        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2); // Size in MB
                
                fileNameDiv.innerHTML = `
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-file-pdf text-green-600"></i>
                        <span>${fileName}</span>
                        <span class="text-xs text-gray-500">(${fileSize} MB)</span>
                    </div>
                `;
                fileNameDiv.classList.remove('hidden');

                // Update the upload area appearance
                fileUploadArea.classList.add('file-uploaded');
                fileUploadArea.classList.remove('border-gray-300');
            } else {
                fileNameDiv.classList.add('hidden');
                fileUploadArea.classList.remove('file-uploaded');
                fileUploadArea.classList.add('border-gray-300');
            }
        });

        // Drag and drop functionality
        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-blue-500', 'bg-blue-50');
        });

        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-50');
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0 && files[0].type === 'application/pdf') {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
    }

    // Initialize file upload for all screen sizes
    document.addEventListener('DOMContentLoaded', function() {
        setupFileUpload('paperFileMobile', 'fileNameMobile', 'fileUploadAreaMobile');
        setupFileUpload('paperFileTablet', 'fileNameTablet', 'fileUploadAreaTablet');
        setupFileUpload('paperFileDesktop', 'fileNameDesktop', 'fileUploadAreaDesktop');
    });

    // Form validation
    function validateForm(formId) {
        const form = document.getElementById(formId);
        if (!form) return true;

        const title = form.querySelector('input[name="title"]').value.trim();
        const abstract = form.querySelector('textarea[name="abstract"]').value.trim();
        const keywords = form.querySelector('input[name="keywords"]').value.trim();
        const file = form.querySelector('input[name="paper_file"]').files[0];

        if (!title || !abstract || !keywords || !file) {
            alert('Please fill in all required fields and upload a PDF file.');
            return false;
        }

        if (file && file.type !== 'application/pdf') {
            alert('Please upload a PDF file only.');
            return false;
        }

        if (file && file.size > 20 * 1024 * 1024) { // 20MB
            alert('File size must be less than 20MB.');
            return false;
        }

        return true;
    }

    // Add form validation to all forms
    document.addEventListener('DOMContentLoaded', function() {
        const forms = ['paperSubmissionFormMobile', 'paperSubmissionFormTablet', 'paperSubmissionFormDesktop'];
        
        forms.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateForm(formId)) {
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>
@endsection
