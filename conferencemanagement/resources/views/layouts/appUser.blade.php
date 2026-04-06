<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Conference Management')</title>
    @vite('resources/css/app.css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navbar (Vide) -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto flex h-16 items-center justify-between px-4">
            <!-- Logo Section (Left) -->
            <div class="flex items-center gap-2">
                <i class="fas fa-calendar text-blue-600 text-xl"></i>
                <span class="text-xl font-bold text-gray-900">FST<span class="text-blue-600">conference</span></span>
            </div>

            @yield('nav')
    </nav>



    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-4 py-6">
        @yield('content')
    </main>
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