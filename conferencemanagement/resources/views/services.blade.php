@extends('layouts.app')

@section('title', 'TechConf 2024 - Conference Management System')

@section('content')
<div class="flex min-h-screen flex-col items-center justify-center bg-gray-50 py-12">
    <div class="w-full max-w-7xl px-8">
        <div class="mb-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
            </div>
            <h1 class="mt-3 text-2xl font-bold text-gray-900">Our Services</h1>
            <p class="mt-2 text-sm text-gray-600">Discover how our system can revolutionize your event management experience.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200/50">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 mb-4">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">Event Planning</h3>
                <p class="text-sm text-gray-600 text-center">Organize your conferences from start to finish with an intuitive platform.</p>
            </div>

            <!-- Card 2 -->
            <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200/50">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 mb-4">
                    <i class="fas fa-microphone-alt text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">Speaker Management</h3>
                <p class="text-sm text-gray-600 text-center">Easily add, edit, or remove speakers and their topics.</p>
            </div>

            <!-- Card 3 -->
            <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200/50">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 mb-4">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">Tracking & Analytics</h3>
                <p class="text-sm text-gray-600 text-center">Track registrations, most popular sessions, and more with our dashboard.</p>
            </div>
        </div>
    </div>
</div>
@endsection