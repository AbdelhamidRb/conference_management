@extends('layouts.app')

@section('title', 'FSTconference 2024 - Conference Management System')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <!-- Header Banner with Gradient -->
    <div class="w-full py-8 bg-gradient-to-r from-blue-900 to-blue-800 text-white mb-10">
        <div class="container mx-auto px-4 md:px-6">
            <h1 class="text-3xl font-bold text-center">Success!</h1>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 mb-10">
            <h1 class="text-2xl text-center font-bold text-blue-600 mb-6">Conference Created Successfully!</h1>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="border border-blue-500 px-4 py-3 text-left font-semibold">Field</th>
                            <th class="border border-blue-500 px-4 py-3 text-left font-semibold">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Title</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step1.title') }}</td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Acronym</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step1.acronyme') }}</td>
                        </tr>
                        <tr class="bg-white hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Venue</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step1.venue') }}</td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Country</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step1.country') }}</td>
                        </tr>
                        <tr class="bg-white hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">City</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step1.city') }}</td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Conference Web Page</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step2.conferenceWebPage') }}</td>
                        </tr>
                        <tr class="bg-white hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Estimated Submissions</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step2.estimatedNumberSubmission') }}</td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">First Day</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step2.firstDay') }}</td>
                        </tr>
                        <tr class="bg-white hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Last Day</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step2.lastDay') }}</td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Submission Deadline</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step2.submissionDeadLine') }}</td>
                        </tr>
                        <tr class="bg-white hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Organizer</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step3.organizer') }}</td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Organizer Web Page</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step3.organizerWebPage') }}</td>
                        </tr>
                        <tr class="bg-white hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Organizer Phone</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step3.organizerPhoneNumber') }}</td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Primary Area</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step3.primaryArea') }}</td>
                        </tr>
                        <tr class="bg-white hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Secondary Area</td>
                            <td class="border border-gray-200 px-4 py-3">{{ session('conference.step3.secondaryArea') }}</td>
                        </tr>
                        <tr class="bg-gray-50 hover:bg-blue-50">
                            <td class="border border-gray-200 px-4 py-3 font-medium text-gray-700">Topics</td>
                            <td class="border border-gray-200 px-4 py-3">

                                @foreach (session('conference.step3.topics') as $topic)
                                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium mr-2 mb-2 px-3 py-1 rounded-full">
                                    {{ $topic }}
                                </span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-center space-x-6">
                <form action="/creerConference" method="post">
                    @csrf
                    <input type="submit" value="Confirm" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-md transition-colors duration-300 shadow-md hover:shadow-lg">
                </form>

                <a href="/createConference" class="inline-flex items-center justify-center bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-8 rounded-md transition-colors duration-300 shadow hover:shadow-md">
                    Update
                </a>
            </div>
        </div>
    </div>
</div>
@endsection