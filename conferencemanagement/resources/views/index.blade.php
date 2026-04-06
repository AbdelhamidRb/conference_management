@extends('layouts.app')

@section('title', 'FSTconference 2024 - Conference Management System')

@section('content')
<!-- Hero Section with Background Image -->
<section class="w-full py-20 md:py-32 lg:py-40 relative bg-gray-900 overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img
            src="https://th.bing.com/th/id/OIP.HyLJ7iXy2z3pUnzez71AoQHaE7?rs=1&pid=ImgDetMain"
            alt="Conference Background"
            class="w-full h-full object-cover opacity-50" />
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-blue-800/70"></div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 md:px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="space-y-6 text-white">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    FSTconference <span class="text-blue-400">2024</span>
                </h1>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Where innovation meets collaboration. Join the premier tech conference of the year.
                </p>

                @guest
                <div class="flex flex-wrap justify-center gap-4 mt-8">
                    <a href="/login"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        Get Started
                    </a>
                    <a href="/register"
                        class="px-6 py-3 bg-transparent border-2 border-white text-white hover:bg-white/10 font-medium rounded-lg transition-all duration-300">
                        Learn More
                    </a>
                </div>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection