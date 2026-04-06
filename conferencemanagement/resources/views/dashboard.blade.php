@extends('layouts.app')

@section('title', 'Dashboard - Conference Management System')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <p class="text-dark-400">Welcome back, {{ Auth::user()->name }}</p>
        </div>
        
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="card rounded-lg border border-dark-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-dark-400">Upcoming Sessions</p>
                        <h2 class="text-3xl font-bold">12</h2>
                    </div>
                    <div class="rounded-full bg-primary-500/20 p-3 text-primary-500">
                        <i class="fas fa-calendar text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="card rounded-lg border border-dark-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-dark-400">My Submissions</p>
                        <h2 class="text-3xl font-bold">3</h2>
                    </div>
                    <div class="rounded-full bg-green-500/20 p-3 text-green-500">
                        <i class="fas fa-file-alt text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="card rounded-lg border border-dark-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-dark-400">Notifications</p>
                        <h2 class="text-3xl font-bold">7</h2>
                    </div>
                    <div class="rounded-full bg-yellow-500/20 p-3 text-yellow-500">
                        <i class="fas fa-bell text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="card rounded-lg border border-dark-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-dark-400">Days Until Conference</p>
                        <h2 class="text-3xl font-bold">42</h2>
                    </div>
                    <div class="rounded-full bg-purple-500/20 p-3 text-purple-500">
                        <i class="fas fa-hourglass-half text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="card rounded-lg border border-dark-700 p-6">
                    <h2 class="mb-4 text-xl font-bold">My Schedule</h2>
                    <div class="space-y-4">
                        @foreach([
                            ['title' => 'Opening Keynote', 'time' => 'Sep 15, 9:00 AM', 'location' => 'Main Hall'],
                            ['title' => 'The Future of AI', 'time' => 'Sep 15, 11:00 AM', 'location' => 'Room A'],
                            ['title' => 'Web Development Workshop', 'time' => 'Sep 16, 10:00 AM', 'location' => 'Room B'],
                            ['title' => 'Networking Lunch', 'time' => 'Sep 16, 12:30 PM', 'location' => 'Dining Hall'],
                            ['title' => 'Panel Discussion: Tech Ethics', 'time' => 'Sep 17, 2:00 PM', 'location' => 'Main Hall']
                        ] as $event)
                            <div class="flex items-center justify-between rounded-lg border border-dark-700 bg-dark-800 p-4">
                                <div>
                                    <h3 class="font-medium">{{ $event['title'] }}</h3>
                                    <p class="text-sm text-dark-400">{{ $event['time'] }} • {{ $event['location'] }}</p>
                                </div>
                                <button class="text-primary-500 hover:text-primary-400">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-sm text-primary-500 hover:text-primary-400">View Full Schedule</a>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="card rounded-lg border border-dark-700 p-6">
                    <h2 class="mb-4 text-xl font-bold">Recent Notifications</h2>
                    <div class="space-y-4">
                        @foreach([
                            ['message' => 'Your paper "Modern Web Development" has been accepted', 'time' => '2 hours ago', 'icon' => 'fa-check-circle', 'color' => 'text-green-500'],
                            ['message' => 'New session added to your schedule', 'time' => '1 day ago', 'icon' => 'fa-calendar-plus', 'color' => 'text-primary-500'],
                            ['message' => 'Reminder: Complete your speaker profile', 'time' => '2 days ago', 'icon' => 'fa-user-edit', 'color' => 'text-yellow-500']
                        ] as $notification)
                            <div class="flex gap-3 rounded-lg border border-dark-700 bg-dark-800 p-4">
                                <div class="{{ $notification['color'] }}">
                                    <i class="fas {{ $notification['icon'] }} text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm">{{ $notification['message'] }}</p>
                                    <p class="text-xs text-dark-400">{{ $notification['time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-sm text-primary-500 hover:text-primary-400">View All Notifications</a>
                    </div>
                </div>
                
                <div class="card mt-6 rounded-lg border border-dark-700 p-6">
                    <h2 class="mb-4 text-xl font-bold">Quick Actions</h2>
                    <div class="grid gap-2">
                        <a href="#" class="flex items-center gap-2 rounded-lg border border-dark-700 bg-dark-800 p-3 hover:bg-dark-700">
                            <i class="fas fa-file-upload text-primary-500"></i>
                            <span>Submit a Paper</span>
                        </a>
                        <a href="#" class="flex items-center gap-2 rounded-lg border border-dark-700 bg-dark-800 p-3 hover:bg-dark-700">
                            <i class="fas fa-user-edit text-primary-500"></i>
                            <span>Update Profile</span>
                        </a>
                        <a href="#" class="flex items-center gap-2 rounded-lg border border-dark-700 bg-dark-800 p-3 hover:bg-dark-700">
                            <i class="fas fa-calendar-alt text-primary-500"></i>
                            <span>Customize Schedule</span>
                        </a>
                        <a href="#" class="flex items-center gap-2 rounded-lg border border-dark-700 bg-dark-800 p-3 hover:bg-dark-700">
                            <i class="fas fa-users text-primary-500"></i>
                            <span>Find Attendees</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection