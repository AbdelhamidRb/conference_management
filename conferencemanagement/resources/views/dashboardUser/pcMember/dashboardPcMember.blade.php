@extends('layouts.appUser')

@section('nav')
<!-- Desktop Navigation - Visible on large screens -->
<div class="hidden lg:flex items-center gap-4">
    <!-- My Reviews Link -->
    <div class="border border-gray-200 rounded-lg px-4 py-2 bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
        <a href="{{ route('MyReviews', ['acronyme' => request('acronyme')]) }}"
            class="text-sm font-medium flex items-center gap-2 
              {{ request()->is('reviews/*') ? 'text-blue-600' : 'text-gray-700' }}">
            <i class="fas fa-list-check text-sm {{ request()->is('reviews/*') ? 'text-blue-600' : 'text-gray-700' }}"></i>
            My Reviews
        </a>
    </div>

    <!-- Return Link -->
    <div class="border border-gray-200 rounded-lg px-4 py-2 bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
        <a href="/"
            class="text-sm font-medium text-gray-700 flex items-center gap-2">
            <i class="fas fa-arrow-left text-sm"></i>
            Return
        </a>
    </div>
</div>

<!-- Mobile Hamburger Button - Visible on small screens -->
<div class="lg:hidden flex items-center">
    <button id="mobileMenuButton" class="p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none">
        <span class="block w-6 h-0.5 bg-gray-700 mb-1.5"></span>
        <span class="block w-6 h-0.5 bg-gray-700 mb-1.5"></span>
        <span class="block w-6 h-0.5 bg-gray-700"></span>
    </button>
</div>

<!-- Mobile Menu - Hidden by default -->
<div id="mobileMenu" class="hidden lg:hidden absolute top-16 left-0 right-0 bg-white shadow-lg z-50">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <!-- My Reviews Link Mobile -->
        <a href="{{ route('MyReviews', ['acronyme' => request('acronyme')]) }}"
            class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('reviews/*') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }} flex items-center gap-2">
            <i class="fas fa-list-check text-sm"></i>
            My Reviews
        </a>

        <!-- Return Link Mobile -->
        <a href="/"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2">
            <i class="fas fa-arrow-left text-sm"></i>
            Return
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && e.target !== mobileMenuButton) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
@endsection

@section('content')
<div class="container mx-auto p-6">
    @yield('content1')
</div>
@endsection