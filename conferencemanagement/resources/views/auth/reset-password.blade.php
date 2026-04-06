@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="flex min-h-screen flex-col items-center justify-center bg-gray-50 py-12">
    <div class="w-full max-w-md px-8">
        <div class="mb-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <i class="fas fa-unlock-alt text-blue-600 text-xl"></i>
            </div>
            <h1 class="mt-3 text-2xl font-bold text-gray-900">Change your password</h1>
            <p class="mt-2 text-sm text-gray-600">Enter your new password below.</p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200/50">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="••••••••"
                            required>
                    </div>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="••••••••"
                            required>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-md bg-blue-600 py-2 px-4 text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Change Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection