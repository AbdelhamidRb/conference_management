@extends('layouts.app')

@section('title', 'TechConf 2024 - Conference Management System')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">Invitation à rejoindre la conférence</h2>

        <form method="POST" action="/invitation/response" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="flex justify-around gap-4">
                <button type="submit" name="accept"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300">
                    Accepter l'invitation
                </button>

                <button type="submit" name="refuse"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300">
                    Refuser l'invitation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection