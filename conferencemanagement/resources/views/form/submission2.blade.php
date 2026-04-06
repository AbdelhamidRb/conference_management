@extends('layouts.app')

@section('title', 'FSTconference 2024 - Author Information')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Banner -->
    <div class="w-full py-6 md:py-8 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
        <div class="container mx-auto px-4 md:px-6">
            <h1 class="text-2xl md:text-3xl font-bold text-center">Author Information</h1>
            <p class="mt-2 text-blue-100 text-center max-w-2xl mx-auto text-sm md:text-base">
                Provide author details for your submission
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center py-6 md:py-12 px-4">
        <div class="w-full max-w-7xl">
            <!-- Mobile View (Stacked Layout) - jusqu'à 768px -->
            <div class="block md:hidden">
                <!-- Progress Indicator -->
                <div class="mb-6 bg-white rounded-lg shadow border border-gray-200 p-4">
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                        <span>Step 2 of 2</span>
                        <span>100%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 100%;"></div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mb-4">
                    @php $conf = session('conference'); @endphp
                    <button onclick="window.location.href='/submission1?acronyme={{ $conf }}'"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>
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

                <!-- Info Card -->
                <div class="mb-4 rounded-md bg-blue-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Add all authors and select the corresponding author.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mb-4 bg-white rounded-lg shadow border border-gray-200 p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h3>
                    <div class="space-y-2">
                        <button type="button" id="addMeAsCorrespondingMobile" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                            <i class="fas fa-user-check mr-2"></i> Add Me as Corresponding
                        </button>
                        <button type="button" id="addMeButtonMobile" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700">
                            <i class="fas fa-user-plus mr-2"></i> Fill Form with My Info
                        </button>
                    </div>
                </div>

                <!-- Add Author Form -->
                <div class="bg-white rounded-lg shadow border border-gray-200 p-4 mb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add Author</h3>
                    <form id="addAuthorFormMobile" class="space-y-4">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="authorFirstNameMobile" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-user mr-1 text-blue-600"></i>
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="authorFirstNameMobile" required
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                    placeholder="First name">
                            </div>

                            <div>
                                <label for="authorLastNameMobile" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-user mr-1 text-blue-600"></i>
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="authorLastNameMobile" required
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                    placeholder="Last name">
                            </div>

                            <div>
                                <label for="authorEmailMobile" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-envelope mr-1 text-blue-600"></i>
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="authorEmailMobile" required
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                    placeholder="email@example.com">
                            </div>

                            <div>
                                <label for="authorAffiliationMobile" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-university mr-1 text-blue-600"></i>
                                    Affiliation <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="authorAffiliationMobile" required
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                    placeholder="University or organization">
                                <p class="mt-1 text-xs text-gray-500">University, company or organization</p>
                            </div>

                            <button type="button" id="addAuthorMobile" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i> Add Author
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Authors List Mobile -->
                <div id="authorsListMobile" class="mb-4">
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Authors List</h3>
                        <div id="authorsCardsMobile" class="space-y-3">
                            <!-- Author cards will be added here -->
                        </div>
                        <div id="noAuthorsMobile" class="text-center py-8 text-gray-500">
                            <i class="fas fa-users text-3xl mb-2"></i>
                            <p class="text-sm">No authors added yet</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Form Mobile -->
                <form id="submitAuthorsFormMobile" action="store2" enctype="multipart/form-data" method="post" class="hidden">
                    @csrf
                    <div id="authorsInputsContainerMobile">
                        <!-- Hidden inputs for authors will be added here -->
                    </div>

                    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                        <div class="flex flex-col space-y-3">
                            <button type="button" onclick="window.location.href='/submission1?acronyme={{ $conf }}'" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Previous
                            </button>
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                Submit Paper
                                <i class="fas fa-check ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tablet View (Two Column Layout) - 768px à 1024px -->
            <div class="hidden md:block lg:hidden">
                <div class="grid grid-cols-12 gap-6">
                    <!-- Sidebar -->
                    <div class="col-span-4">
                        <div class="space-y-6">
                            <!-- Progress Card -->
                            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 sticky top-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Submission Progress</h3>

                                <!-- Progress Steps -->
                                <div class="space-y-4 mb-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                            ✓
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-green-600">Paper Information</p>
                                            <p class="text-xs text-gray-500">Completed</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                            2
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-blue-600">Author Information</p>
                                            <p class="text-xs text-gray-500">Current step</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-6">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span>Progress</span>
                                        <span>100%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 100%;"></div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="space-y-3">
                                    <button type="button" id="addMeAsCorrespondingTablet" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                        <i class="fas fa-user-check mr-2"></i> Add Me as Corresponding
                                    </button>
                                    <button type="button" id="addMeButtonTablet" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700">
                                        <i class="fas fa-user-plus mr-2"></i> Fill Form with My Info
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-span-8">
                        <!-- Back Button -->
                        <div class="mb-6">
                            <button onclick="window.location.href='/submission1?acronyme={{ $conf }}'"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-arrow-left mr-2"></i> Back
                            </button>
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

                        <!-- Info Card -->
                        <div class="mb-6 rounded-md bg-blue-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Please specify the corresponding author and add all co-authors (including yourself if applicable).
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Add Author Form -->
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Add Author</h3>
                            <form id="addAuthorFormTablet" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="authorFirstNameTablet" class="block text-sm font-medium text-gray-700">
                                            First Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="authorFirstNameTablet" required
                                            class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="First name">
                                    </div>

                                    <div>
                                        <label for="authorLastNameTablet" class="block text-sm font-medium text-gray-700">
                                            Last Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="authorLastNameTablet" required
                                            class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Last name">
                                    </div>
                                </div>

                                <div>
                                    <label for="authorEmailTablet" class="block text-sm font-medium text-gray-700">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="authorEmailTablet" required
                                        class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="email@example.com">
                                </div>

                                <div>
                                    <label for="authorAffiliationTablet" class="block text-sm font-medium text-gray-700">
                                        Affiliation <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="authorAffiliationTablet" required
                                        class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="University or organization">
                                    <p class="mt-1 text-sm text-gray-500">University, company or organization</p>
                                </div>

                                <button type="button" id="addAuthorTablet" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i> Add Author
                                </button>
                            </form>
                        </div>

                        <!-- Authors Table -->
                        <div id="authorsListTablet" class="mb-6">
                            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                                <h3 class="text-lg font-medium mb-4">Authors</h3>
                                <div class="overflow-x-auto">
                                    <table id="authorsTableTablet" class="hidden min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Corresponding</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliation</th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="authorsTableBodyTablet" class="bg-white divide-y divide-gray-200">
                                            <!-- Authors will be added here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                                <div id="noAuthorsTablet" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-users text-3xl mb-2"></i>
                                    <p>No authors added yet</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Form -->
                        <form id="submitAuthorsFormTablet" action="store2" enctype="multipart/form-data" method="post" class="hidden">
                            @csrf
                            <div id="authorsInputsContainerTablet">
                                <!-- Hidden inputs for authors will be added here -->
                            </div>

                            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                                <div class="flex justify-between">
                                    <button type="button" onclick="window.location.href='/submission1?acronyme={{ $conf }}'" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Previous
                                    </button>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                        Submit Paper
                                        <i class="fas fa-check ml-2"></i>
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
                        <div class="space-y-6">
                            <!-- Progress Card -->
                            <div class="bg-white rounded-xl shadow border border-gray-200 p-6 sticky top-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-6">Submission Progress</h3>

                                <!-- Progress Steps -->
                                <div class="space-y-6 mb-8">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-medium">
                                            ✓
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-green-600">Paper Information</p>
                                            <p class="text-xs text-gray-500">Completed</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-medium">
                                            2
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-blue-600">Author Information</p>
                                            <p class="text-xs text-gray-500">Current step</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-8">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span>Progress</span>
                                        <span>100%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="bg-green-600 h-3 rounded-full transition-all duration-300" style="width: 100%;"></div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="space-y-3 mb-6">
                                    <button type="button" id="addMeAsCorrespondingDesktop" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                                        <i class="fas fa-user-check mr-2"></i> Add Me as Corresponding
                                    </button>
                                    <button type="button" id="addMeButtonDesktop" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                                        <i class="fas fa-user-plus mr-2"></i> Fill Form with My Info
                                    </button>
                                </div>

                                <!-- Guidelines -->
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Author Guidelines</h4>
                                    <ul class="text-xs text-gray-600 space-y-1">
                                        <li>• Add all contributing authors</li>
                                        <li>• Select one corresponding author</li>
                                        <li>• Verify email addresses</li>
                                        <li>• Include full affiliations</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-span-9">
                        <!-- Back Button -->
                        <div class="mb-8">
                            <button onclick="window.location.href='/submission1?acronyme={{ $conf }}'"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Paper Information
                            </button>
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

                        <!-- Info Card -->
                        <div class="mb-8 rounded-lg bg-blue-50 p-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800 mb-1">Author Information Required</h4>
                                    <p class="text-sm text-blue-700">
                                        Please specify the corresponding author and add all co-authors (including yourself if applicable). The corresponding author will receive all communication regarding this submission.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Add Author Form -->
                        <div class="bg-white rounded-xl shadow border border-gray-200 p-8 mb-8">
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-user-plus mr-3 text-blue-600"></i>
                                    Add Author
                                </h2>
                                <p class="text-gray-600 mt-2">Enter the details for each author of this paper</p>
                            </div>

                            <form id="addAuthorFormDesktop" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <label for="authorFirstNameDesktop" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-user mr-2 text-blue-600"></i>
                                            First Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="authorFirstNameDesktop" required
                                            class="mt-1 block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base"
                                            placeholder="Enter first name">
                                    </div>

                                    <div>
                                        <label for="authorLastNameDesktop" class="block text-sm font-medium text-gray-700">
                                            <i class="fas fa-user mr-2 text-blue-600"></i>
                                            Last Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="authorLastNameDesktop" required
                                            class="mt-1 block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base"
                                            placeholder="Enter last name">
                                    </div>
                                </div>

                                <div>
                                    <label for="authorEmailDesktop" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-envelope mr-2 text-blue-600"></i>
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="authorEmailDesktop" required
                                        class="mt-1 block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base"
                                        placeholder="email@example.com">
                                    <p class="mt-1 text-sm text-gray-500">This email will be used for all correspondence</p>
                                </div>

                                <div>
                                    <label for="authorAffiliationDesktop" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-university mr-2 text-blue-600"></i>
                                        Affiliation <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="authorAffiliationDesktop" required
                                        class="mt-1 block w-full rounded-md border-gray-300 py-4 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base"
                                        placeholder="University, company or organization">
                                    <p class="mt-1 text-sm text-gray-500">Full name of the institution or organization</p>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" id="addAuthorDesktop" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-plus mr-2"></i> Add Author
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Authors Table -->
                        <div id="authorsListDesktop" class="mb-8">
                            <div class="bg-white rounded-xl shadow border border-gray-200 p-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                    <i class="fas fa-users mr-3 text-blue-600"></i>
                                    Authors List
                                </h3>
                                <div class="overflow-x-auto">
                                    <table id="authorsTableDesktop" class="hidden min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Corresponding</th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliation</th>
                                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="authorsTableBodyDesktop" class="bg-white divide-y divide-gray-200">
                                            <!-- Authors will be added here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                                <div id="noAuthorsDesktop" class="text-center py-12 text-gray-500">
                                    <i class="fas fa-users text-4xl mb-4"></i>
                                    <h4 class="text-lg font-medium mb-2">No authors added yet</h4>
                                    <p class="text-sm">Add authors using the form above</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Form -->
                        <form id="submitAuthorsFormDesktop" action="store2" enctype="multipart/form-data" method="post" class="hidden">
                            @csrf
                            <div id="authorsInputsContainerDesktop">
                                <!-- Hidden inputs for authors will be added here -->
                            </div>

                            <div class="bg-white rounded-xl shadow border border-gray-200 p-8">
                                <div class="flex justify-between items-center">
                                    <button type="button" onclick="window.location.href='/submission1?acronyme={{ $conf }}'" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Previous Step
                                    </button>
                                    <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                                        Submit Paper
                                        <i class="fas fa-check ml-2"></i>
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
    input:focus,
    textarea:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Smooth transitions */
    input,
    textarea,
    button {
        transition: all 0.2s ease-in-out;
    }

    /* Hover effects */
    input:hover,
    textarea:hover {
        border-color: #93c5fd;
    }

    /* Author card animations */
    .author-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .author-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Table row hover */
    tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Progress bar animation */
    .progress-bar {
        transition: width 0.5s ease-in-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get user data from backend
        const userData = {
            firstName: "{{ auth()->user()->firstName ?? '' }}",
            lastName: "{{ auth()->user()->lastName ?? '' }}",
            email: "{{ auth()->user()->email ?? '' }}",
            affiliation: "{{ auth()->user()->affiliation ?? '' }}"
        };

        // Initialize for all screen sizes
        const screenSizes = ['Mobile', 'Tablet', 'Desktop'];
        let addedAuthors = [];
        let currentCorrespondingIndex = -1;

        screenSizes.forEach(size => {
            initializeAuthorManagement(size);
        });

        function initializeAuthorManagement(size) {
            const addMeButton = document.getElementById(`addMeButton${size}`);
            const addMeAsCorrespondingButton = document.getElementById(`addMeAsCorresponding${size}`);
            const addAuthorButton = document.getElementById(`addAuthor${size}`);
            const addAuthorForm = document.getElementById(`addAuthorForm${size}`);

            // Add Me Button - populates form fields
            if (addMeButton) {
                addMeButton.addEventListener('click', function() {
                    document.getElementById(`authorFirstName${size}`).value = userData.firstName;
                    document.getElementById(`authorLastName${size}`).value = userData.lastName;
                    document.getElementById(`authorEmail${size}`).value = userData.email;
                    document.getElementById(`authorAffiliation${size}`).value = userData.affiliation;
                });
            }

            // Add Me as Corresponding - directly adds to table
            if (addMeAsCorrespondingButton) {
                addMeAsCorrespondingButton.addEventListener('click', function() {
                    if (userData.firstName && userData.lastName && userData.email && userData.affiliation) {
                        // Check if user is already added
                        const isAlreadyAdded = addedAuthors.some(author => author.email === userData.email);

                        if (isAlreadyAdded) {
                            alert('You are already added as an author.');
                            return;
                        }

                        // Unset any previous corresponding author
                        if (currentCorrespondingIndex !== -1) {
                            addedAuthors[currentCorrespondingIndex].isCorresponding = false;
                        }

                        // Add user as corresponding author
                        addedAuthors.push({
                            firstName: userData.firstName,
                            lastName: userData.lastName,
                            email: userData.email,
                            affiliation: userData.affiliation,
                            isCorresponding: true
                        });

                        currentCorrespondingIndex = addedAuthors.length - 1;
                        updateAuthorsDisplay();
                    } else {
                        alert('Your user profile is missing some required information. Please complete your profile first.');
                    }
                });
            }

            // Add Author Button
            if (addAuthorButton) {
                addAuthorButton.addEventListener('click', function() {
                    const firstName = document.getElementById(`authorFirstName${size}`).value.trim();
                    const lastName = document.getElementById(`authorLastName${size}`).value.trim();
                    const email = document.getElementById(`authorEmail${size}`).value.trim();
                    const affiliation = document.getElementById(`authorAffiliation${size}`).value.trim();

                    if (firstName && lastName && email && affiliation) {
                        // Check if author with this email already exists
                        const isDuplicate = addedAuthors.some(author => author.email === email);

                        if (isDuplicate) {
                            alert('An author with this email already exists.');
                            return;
                        }

                        addedAuthors.push({
                            firstName,
                            lastName,
                            email,
                            affiliation,
                            isCorresponding: false
                        });

                        updateAuthorsDisplay();
                        if (addAuthorForm) addAuthorForm.reset();
                    } else {
                        alert('Please fill in all the required fields.');
                    }
                });
            }
        }

        function updateAuthorsDisplay() {
            // Update mobile view (cards)
            updateMobileAuthorsDisplay();

            // Update tablet and desktop views (tables)
            updateTableAuthorsDisplay('Tablet');
            updateTableAuthorsDisplay('Desktop');

            // Update hidden inputs for all forms
            updateHiddenInputs();
        }

        function updateMobileAuthorsDisplay() {
            const authorsCards = document.getElementById('authorsCardsMobile');
            const noAuthors = document.getElementById('noAuthorsMobile');
            const submitForm = document.getElementById('submitAuthorsFormMobile');

            if (!authorsCards) return;

            authorsCards.innerHTML = '';

            if (addedAuthors.length > 0) {
                noAuthors.classList.add('hidden');
                submitForm.classList.remove('hidden');

                addedAuthors.forEach((author, index) => {
                    const authorCard = document.createElement('div');
                    authorCard.className = 'author-card bg-gray-50 rounded-lg p-4 border border-gray-200';

                    authorCard.innerHTML = `
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <h4 class="font-medium text-gray-900">${author.firstName} ${author.lastName}</h4>
                                    ${author.isCorresponding ? '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-star mr-1"></i>Corresponding</span>' : ''}
                                </div>
                                <p class="text-sm text-gray-600 mb-1"><i class="fas fa-envelope mr-1"></i>${author.email}</p>
                                <p class="text-sm text-gray-600"><i class="fas fa-university mr-1"></i>${author.affiliation}</p>
                            </div>
                            <div class="flex flex-col space-y-2 ml-4">
                                <label class="flex items-center">
                                    <input type="radio" name="correspondingAuthorMobile" value="${index}" ${author.isCorresponding ? 'checked' : ''} 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500" onchange="setCorrespondingAuthor(${index})">
                                    <span class="ml-2 text-xs text-gray-600">Corresponding</span>
                                </label>
                                <button type="button" class="text-red-600 hover:text-red-900 text-sm" onclick="removeAuthor(${index})">
                                    <i class="fas fa-trash mr-1"></i>Remove
                                </button>
                            </div>
                        </div>
                    `;

                    authorsCards.appendChild(authorCard);
                });
            } else {
                noAuthors.classList.remove('hidden');
                submitForm.classList.add('hidden');
            }
        }

        function updateTableAuthorsDisplay(size) {
            const authorsTable = document.getElementById(`authorsTable${size}`);
            const authorsTableBody = document.getElementById(`authorsTableBody${size}`);
            const noAuthors = document.getElementById(`noAuthors${size}`);
            const submitForm = document.getElementById(`submitAuthorsForm${size}`);

            if (!authorsTable || !authorsTableBody) return;

            authorsTableBody.innerHTML = '';

            if (addedAuthors.length > 0) {
                authorsTable.classList.remove('hidden');
                if (noAuthors) noAuthors.classList.add('hidden');
                if (submitForm) submitForm.classList.remove('hidden');

                addedAuthors.forEach((author, index) => {
                    const row = authorsTableBody.insertRow();
                    row.classList.add('hover:bg-gray-50');

                    // Corresponding radio button cell
                    const correspondingCell = row.insertCell();
                    correspondingCell.classList.add('px-4', 'py-4', 'whitespace-nowrap', 'text-center', 'text-sm', 'text-gray-500');
                    correspondingCell.innerHTML = `
                        <input type="radio" name="correspondingAuthor${size}" value="${index}" ${author.isCorresponding ? 'checked' : ''} 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500" onchange="setCorrespondingAuthor(${index})">
                    `;

                    // First Name cell
                    const firstNameCell = row.insertCell();
                    firstNameCell.classList.add('px-4', 'py-4', 'whitespace-nowrap', 'text-sm', 'text-gray-900');
                    firstNameCell.textContent = author.firstName;

                    // Last Name cell
                    const lastNameCell = row.insertCell();
                    lastNameCell.classList.add('px-4', 'py-4', 'whitespace-nowrap', 'text-sm', 'text-gray-900');
                    lastNameCell.textContent = author.lastName;

                    // Email cell
                    const emailCell = row.insertCell();
                    emailCell.classList.add('px-4', 'py-4', 'text-sm', 'text-gray-900');
                    emailCell.innerHTML = `
                        <div class="flex items-center">
                            ${author.isCorresponding ? '<i class="fas fa-star text-yellow-500 mr-2"></i>' : ''}
                            ${author.email}
                        </div>
                    `;

                    // Affiliation cell
                    const affiliationCell = row.insertCell();
                    affiliationCell.classList.add('px-4', 'py-4', 'text-sm', 'text-gray-900');
                    affiliationCell.textContent = author.affiliation;

                    // Action cell
                    const actionCell = row.insertCell();
                    actionCell.classList.add('px-4', 'py-4', 'whitespace-nowrap', 'text-right', 'text-sm', 'font-medium');
                    actionCell.innerHTML = `
                        <button type="button" class="text-red-600 hover:text-red-900 focus:outline-none" onclick="removeAuthor(${index})">
                            <i class="fas fa-trash mr-1"></i> Remove
                        </button>
                    `;
                });
            } else {
                authorsTable.classList.add('hidden');
                if (noAuthors) noAuthors.classList.remove('hidden');
                if (submitForm) submitForm.classList.add('hidden');
            }
        }

        function updateHiddenInputs() {
            const containers = ['Mobile', 'Tablet', 'Desktop'];

            containers.forEach(size => {
                const container = document.getElementById(`authorsInputsContainer${size}`);
                if (!container) return;

                container.innerHTML = '';

                addedAuthors.forEach((author, index) => {
                    const authorPrefix = `authors[${index}]`;

                    const inputs = [{
                            name: `${authorPrefix}[first_name]`,
                            value: author.firstName
                        },
                        {
                            name: `${authorPrefix}[last_name]`,
                            value: author.lastName
                        },
                        {
                            name: `${authorPrefix}[email]`,
                            value: author.email
                        },
                        {
                            name: `${authorPrefix}[affiliation]`,
                            value: author.affiliation
                        },
                        {
                            name: `${authorPrefix}[is_corresponding]`,
                            value: author.isCorresponding ? '1' : '0'
                        }
                    ];

                    inputs.forEach(inputData => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = inputData.name;
                        input.value = inputData.value;
                        container.appendChild(input);
                    });
                });
            });
        }

        // Global functions for onclick handlers
        window.setCorrespondingAuthor = function(index) {
            if (currentCorrespondingIndex !== -1) {
                addedAuthors[currentCorrespondingIndex].isCorresponding = false;
            }
            currentCorrespondingIndex = index;
            addedAuthors[index].isCorresponding = true;
            updateAuthorsDisplay();
        };

        window.removeAuthor = function(index) {
            if (addedAuthors[index].isCorresponding) {
                currentCorrespondingIndex = -1;
            } else if (index < currentCorrespondingIndex) {
                currentCorrespondingIndex--;
            }
            addedAuthors.splice(index, 1);
            updateAuthorsDisplay();
        };

        // Form validation before submission
        const submitForms = ['submitAuthorsFormMobile', 'submitAuthorsFormTablet', 'submitAuthorsFormDesktop'];

        submitForms.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (addedAuthors.length === 0) {
                        e.preventDefault();
                        alert('Please add at least one author before submitting.');
                        return;
                    }

                    const hasCorresponding = addedAuthors.some(author => author.isCorresponding);
                    if (!hasCorresponding) {
                        e.preventDefault();
                        alert('Please select a corresponding author before submitting.');
                        return;
                    }
                });
            }
        });
    });
</script>
@endsection