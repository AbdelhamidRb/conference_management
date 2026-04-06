@extends('layouts.app')

@section('title', 'FSTconference 2024 - Register')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Banner with Gradient - Version améliorée -->
    <div class="w-full py-12 bg-gradient-to-r from-blue-900 to-blue-800 text-white shadow-md">
        <div class="container mx-auto px-4 md:px-6">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-bold tracking-tight">Create an Account</h1>
                <p class="mt-3 text-blue-100/90 text-lg leading-6">
                    Join the conference and get access to all features.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Form Container - Optimisé pour le responsive -->
    <div class="flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200/80">
                <!-- Error Messages - Style amélioré -->
                @if ($errors->any())
                <div class="bg-red-50/80 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="p-8 sm:p-10">
                    <form method="POST" action="register" class="space-y-6" x-data="passwordStrengthMeter()">
                        @csrf

                        <!-- Personal Information - Groupes améliorés -->
                        <div class="space-y-5">
                            <!-- First & Last Name Group -->
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1.5">First Name</label>
                                    <input type="text" id="firstName" name="firstName" value="{{ old('firstName') }}"
                                        class="block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                                        placeholder="John" required autofocus>
                                </div>

                                <div>
                                    <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1.5">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}"
                                        class="block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                                        placeholder="Doe" required>
                                </div>
                            </div>

                            <!-- Affiliation & Country -->
                            <div>
                                <label for="affiliation" class="block text-sm font-medium text-gray-700 mb-1.5">Affiliation</label>
                                <input type="text" id="affiliation" name="affiliation" value="{{ old('affiliation') }}"
                                    class="block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                                    placeholder="University or Organization" required>
                            </div>

                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-1.5">Country</label>
                                <input type="text" id="country" name="country" value="{{ old('country') }}"
                                    class="block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                                    placeholder="Country" required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="block w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                                    placeholder="you@example.com" required>
                            </div>
                        </div>

                        <!-- Password Section - Amélioré avec Alpine.js -->
                        <div class="space-y-5 pt-2">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="password" id="password" name="password" x-model="password" @input="calculateStrength()"
                                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                                        placeholder="••••••••" required>
                                    <button type="button" @click="toggleVisibility('password', $refs.passwordToggle)"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                        <svg x-ref="passwordToggle" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Password Strength Meter - Version améliorée -->
                                <div x-show="password.length > 0" x-transition class="mt-3 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium" x-text="strengthText"></span>
                                        <span class="text-xs font-semibold"
                                            :class="{
                                                'text-red-500': strength <= 25,
                                                'text-yellow-500': strength > 25 && strength <= 50,
                                                'text-yellow-400': strength > 50 && strength <= 75,
                                                'text-green-500': strength > 75
                                            }"
                                            x-text="strength + '%'"></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full transition-all duration-500 ease-out"
                                            :class="{
                                                'bg-red-500': strength <= 25,
                                                'bg-yellow-500': strength > 25 && strength <= 50,
                                                'bg-yellow-400': strength > 50 && strength <= 75,
                                                'bg-green-500': strength > 75
                                            }"
                                            :style="'width: ' + strength + '%'"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                                        placeholder="••••••••" required>
                                    <button type="button" @click="toggleVisibility('password_confirmation', $refs.confirmPasswordToggle)"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                        <svg x-ref="confirmPasswordToggle" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Terms & Conditions - Style amélioré -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" id="terms" name="terms"
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">
                                    I agree to the
                                    <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline">Terms of Service</a>
                                    and
                                    <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline">Privacy Policy</a>.
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button - Style amélioré -->
                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Create Account
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center text-sm">
                            <p class="text-gray-600">
                                Already have an account?
                                <a href="/login" class="font-medium text-blue-600 hover:text-blue-800 hover:underline">Sign in</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Alpine.js Component - Version améliorée
    function passwordStrengthMeter() {
        return {
            password: '',
            strength: 0,
            strengthText: 'Weak',

            calculateStrength() {
                let score = 0;

                // Length check
                if (this.password.length >= 8) score += 25;
                if (this.password.length >= 12) score += 10;

                // Character variety
                if (/[a-z]/.test(this.password)) score += 10;
                if (/[A-Z]/.test(this.password)) score += 15;
                if (/[0-9]/.test(this.password)) score += 15;
                if (/[^A-Za-z0-9]/.test(this.password)) score += 25;

                // Sequential characters penalty
                if (/(.)\1{2,}/.test(this.password)) score -= 15;

                this.strength = Math.min(100, Math.max(0, score));

                // Update strength text
                if (this.strength <= 25) this.strengthText = 'Weak';
                else if (this.strength <= 50) this.strengthText = 'Fair';
                else if (this.strength <= 75) this.strengthText = 'Good';
                else this.strengthText = 'Strong';
            },

            toggleVisibility(fieldId, iconRef) {
                const field = document.getElementById(fieldId);
                if (field.type === 'password') {
                    field.type = 'text';
                    iconRef.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
                } else {
                    field.type = 'password';
                    iconRef.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                }
            }
        }
    }
</script>
@endsection