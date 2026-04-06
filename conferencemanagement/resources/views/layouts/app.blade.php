<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Conference Management System')</title>
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js - Une seule fois -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-gray-50 flex flex-col" x-data="{ mobileMenuOpen: false }">
    <!-- Header -->
    <header class="sticky top-0 z-50 w-full border-b border-gray-200 bg-white/95 backdrop-blur shadow-sm">
        <div class="container mx-auto flex h-16 items-center justify-between px-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-calendar text-blue-600 text-xl"></i>
                <span class="text-xl font-bold text-gray-900">FST<span class="text-blue-600">conference</span></span>
            </div>

            <!-- Navigation Desktop -->
            <nav class="hidden lg:flex items-center gap-6">
                @guest
                <a href="/" class="text-sm font-medium hover:text-blue-600 {{ request()->is('/') ? 'text-blue-600' : 'text-gray-700' }}">Home</a>
                <a href="/services" class="text-sm font-medium hover:text-blue-600 {{ request()->is('services') ? 'text-blue-600' : 'text-gray-700' }}">Services</a>
                <a href="/about" class="text-sm font-medium hover:text-blue-600 {{ request()->is('about') ? 'text-blue-600' : 'text-gray-700' }}">About</a>
                @endguest
            </nav>

            <!-- Boutons Auth/User -->
            <div class="flex items-center gap-4">
                @guest
                <div class="hidden lg:flex gap-4">
                    <a href="/login" class="px-4 py-2 rounded-md bg-white border border-blue-600 text-sm font-medium hover:bg-blue-50 text-blue-600">Login</a>
                    <a href="/register" class="px-4 py-2 rounded-md bg-blue-600 text-sm font-medium hover:bg-blue-700 text-white shadow-sm">Sign Up</a>
                </div>
                @else
                <!-- Dropdown User Desktop -->
                <div class="hidden lg:ml-6 lg:flex lg:items-center">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-1 text-sm font-medium px-3 py-2 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            <div class="py-1">
                                <a href="/createConference" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-plus-circle mr-3 text-gray-400"></i>
                                    New Conference
                                </a>
                                <a href="/myRoles" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-tag mr-3 text-gray-400"></i>
                                    My Roles
                                </a>
                                <a href="/all-pending-invitations" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-envelope-open-text mr-3 text-gray-400"></i>
                                    Invitations
                                </a>
                                <a href="/" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-home mr-3 text-gray-400"></i>
                                    Home
                                </a>
                                <a href="/services" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-concierge-bell mr-3 text-gray-400"></i>
                                    Services
                                </a>
                                <a href="/about" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-info-circle mr-3 text-gray-400"></i>
                                    About
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endguest

                <!-- Bouton Menu Mobile -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            @click.away="mobileMenuOpen = false"
            class="lg:hidden bg-white shadow-lg absolute w-full left-0 border-t border-gray-200">
            <div class="px-2 pt-2 pb-4 space-y-1">
                @guest
                <a href="/" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('/') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">Home</a>
                <a href="/services" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('services') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">Services</a>
                <a href="/about" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('about') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">About</a>
                <div class="pt-2 border-t border-gray-200">
                    <a href="/login" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:bg-blue-50">Login</a>
                    <a href="/register" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium bg-blue-600 text-white hover:bg-blue-700">Sign Up</a>
                </div>
                @else
                <div class="px-3 py-2 flex items-center bg-blue-50 rounded-md">
                    <i class="fas fa-user-circle text-blue-600 text-xl mr-3"></i>
                    <span class="font-medium">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</span>
                </div>
                <a href="/createConference" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('createConference') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-plus-circle mr-3 text-gray-400"></i> New Conference
                </a>
                <a href="/myRoles" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('myRoles') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-user-tag mr-3 text-gray-400"></i> My Roles
                </a>
                <a href="/all-pending-invitations" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('show.invitations') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-envelope-open-text mr-3 text-gray-400"></i> Invitations
                </a>
                <div class="border-t border-gray-200 pt-2">
                    <a href="/" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('/') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i class="fas fa-home mr-3 text-gray-400"></i> Home
                    </a>
                    <a href="/services" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('services') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i class="fas fa-concierge-bell mr-3 text-gray-400"></i> Services
                    </a>
                    <a href="/about" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('about') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <i class="fas fa-info-circle mr-3 text-gray-400"></i> About
                    </a>
                </div>
                <form method="POST" action="/logout" class="border-t border-gray-200 pt-2">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
                @endguest
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-gray-200 bg-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar text-blue-600 text-2xl"></i>
                        <span class="text-xl font-bold text-gray-900">FST<span class="text-blue-600">conference</span></span>
                    </div>
                    <p class="text-sm text-gray-600">
                        Where innovation meets collaboration. Join the premier tech conference of the year.
                    </p>
                    <div class="flex space-x-4 pt-2">
                        <a href="#" class="text-gray-500 hover:text-blue-600" target="_blank"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-gray-500 hover:text-blue-600" target="_blank"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-gray-500 hover:text-blue-600" target="_blank"><i class="fab fa-github fa-lg"></i></a>
                    </div>
                </div>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Links</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/" class="hover:text-blue-600 text-gray-600 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-blue-600"></i> Home</a></li>
                        <li><a href="/services" class="hover:text-blue-600 text-gray-600 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-blue-600"></i> Services</a></li>
                        <li><a href="/about" class="hover:text-blue-600 text-gray-600 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-blue-600"></i> About</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Legal</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-blue-600 text-gray-600 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-blue-600"></i> Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-blue-600 text-gray-600 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-blue-600"></i> Terms of Service</a></li>
                        <li><a href="#" class="hover:text-blue-600 text-gray-600 flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-blue-600"></i> Code of Conduct</a></li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Contact</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-globe text-blue-600"></i>
                            <a href="https://fst-usmba.ac.ma" target="_blank" class="hover:text-blue-600">Fst fes</a>
                        </li>
                        <li class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-phone text-blue-600"></i>
                            <a href="tel:+212535608014" target="_blank" class="hover:text-blue-600">+212535608014</a>
                        </li>
                        <li class="flex items-start gap-2 text-gray-600">
                            <i class="fas fa-map-marker-alt text-blue-600 mt-1"></i>
                            <span>Faculté des Sciences et Techniques de Fès</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-6 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} FSTconference. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>