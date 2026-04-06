@extends('layouts.app')

@section('title', 'Reset Password - Conference Management System')

@section('content')
<div class="flex min-h-screen flex-col items-center justify-center bg-gray-50 py-12">
    <div class="w-full max-w-md px-8">
        <div class="mb-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <i class="fas fa-envelope text-blue-600 text-xl"></i>
            </div>
            <h1 class="mt-3 text-2xl font-bold text-gray-900">Forgot your password?</h1>
            <p class="mt-2 text-sm text-gray-600">Enter your email address and we will send you a reset link.</p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200/50">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-4 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="you@example.com"
                            required>
                    </div>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{$message}}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full rounded-md bg-blue-600 py-2 px-4 text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Send Reset Link
                </button>

                @if (session('status'))
                <p class="mt-4 text-sm text-green-600 text-center">{{ session('status') }}</p>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection