@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Email Verification Required</h1>
            <p class="text-gray-600 mb-6">
                We have sent a verification link to <span class="font-semibold">{{ session('email') }}</span>.
                Please click on that link to complete your registration.
            </p>

            @if (session('status'))
            <div class="mb-4 text-green-600 text-center">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('verification.resend') }}" class="mt-4">
                @csrf
                @unless(auth()->check())
                <input type="hidden" name="email" value="{{ session('email') }}">
                @endunless
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    Resend Verification Link
                </button>
            </form>
        </div>
    </div>
</div>
@endsection