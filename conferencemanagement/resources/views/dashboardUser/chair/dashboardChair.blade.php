@extends('layouts.appUser')

@section('nav')
<!-- Navigation Container with No Scroll -->
<div class="w-full bg-white border-b border-gray-200 sticky top-0 z-40">
    <!-- Desktop Navigation - Adaptive Layout -->
    <div class="hidden lg:block px-2 xl:px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Main Navigation Items -->
            <div class="flex items-center space-x-1 xl:space-x-2 flex-1 min-w-0">
                <!-- Configuration -->
                <div class="flex-shrink-0">
                    <a href="/configuration?acronyme={{request('acronyme')}}"
                       class="inline-flex items-center px-2 xl:px-3 py-1.5 xl:py-2 text-xs xl:text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 transition-all duration-200 {{ request()->is('configuration') ? 'ring-2 ring-blue-300 bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        <i class="fas fa-cog text-xs mr-1 xl:mr-1.5"></i>
                        <span class="hidden md:inline">Config</span>
                        <span class="md:hidden">C</span>
                    </a>
                </div>

                <!-- Statistics -->
                <div class="flex-shrink-0">
                    <a href="/statistics?acronyme={{ request('acronyme') }}"
                       class="inline-flex items-center px-2 xl:px-3 py-1.5 xl:py-2 text-xs xl:text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 transition-all duration-200 {{ request()->is('statistics') ? 'ring-2 ring-blue-300 bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        <i class="fas fa-chart-bar text-xs mr-1 xl:mr-1.5"></i>
                        <span class="hidden md:inline">Stats</span>
                        <span class="md:hidden">S</span>
                    </a>
                </div>

                <!-- Final Decision -->
                <div class="flex-shrink-0">
                    <a href="/finalDecision?acronyme={{request('acronyme')}}"
                       class="inline-flex items-center px-2 xl:px-3 py-1.5 xl:py-2 text-xs xl:text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 transition-all duration-200 {{ request()->is('finalDecision') ? 'ring-2 ring-blue-300 bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        <i class="fas fa-check-circle text-xs mr-1 xl:mr-1.5"></i>
                        <span class="hidden md:inline">Decision</span>
                        <span class="md:hidden">D</span>
                    </a>
                </div>

                <!-- Evaluation -->
                <div class="flex-shrink-0">
                    <a href="/evaluation?acronyme={{request('acronyme')}}"
                       class="inline-flex items-center px-2 xl:px-3 py-1.5 xl:py-2 text-xs xl:text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 transition-all duration-200 {{ request()->is('evaluation') ? 'ring-2 ring-blue-300 bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        <i class="fas fa-clipboard-check text-xs mr-1 xl:mr-1.5"></i>
                        <span class="hidden md:inline">Eval</span>
                        <span class="md:hidden">E</span>
                    </a>
                </div>

                <!-- Assignment Dropdown -->
                <div class="relative flex-shrink-0" id="pcDropdownContainer">
                    <button id="pcDropdownButton" 
                            class="inline-flex items-center px-2 xl:px-3 py-1.5 xl:py-2 text-xs xl:text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 transition-all duration-200 {{ request()->routeIs('assignments.index') || request()->is('pc-members-assignments') || request()->is('Attribution') ? 'ring-2 ring-blue-300 bg-blue-50 text-blue-600' : 'text-gray-700' }}"
                            type="button"
                            aria-expanded="false"
                            aria-haspopup="true">
                        <i class="fas fa-users-cog text-xs mr-1 xl:mr-1.5"></i>
                        <span class="hidden md:inline">Assign</span>
                        <span class="md:hidden">A</span>
                        <svg class="w-3 h-3 ml-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="pcDropdown" class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                        <div class="py-1">
                            <a href="{{ route('assignments.index', ['acronyme' => request('acronyme')]) }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('assignments.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-user-plus text-xs mr-2"></i>
                                Overview
                            </a>
                            <a href="/Attribution?acronyme={{ request('acronyme') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->is('Attribution') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-users-cog text-xs mr-2"></i>
                                By Article
                            </a>
                            <a href="/pc-members-assignments?acronyme={{ request('acronyme') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->is('pc-members-assignments') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-users text-xs mr-2"></i>
                                By PC Member
                            </a>
                        </div>
                    </div>
                </div>

                <!-- PC Dropdown -->
                <div class="relative flex-shrink-0" id="chairsDropdownContainer">
                    <button id="chairsDropdownButton" 
                            class="inline-flex items-center px-2 xl:px-3 py-1.5 xl:py-2 text-xs xl:text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 transition-all duration-200 {{ request()->is('coChairs') || request()->is('pcMembers') ? 'ring-2 ring-blue-300 bg-blue-50 text-blue-600' : 'text-gray-700' }}"
                            type="button"
                            aria-expanded="false"
                            aria-haspopup="true">
                        <i class="fas fa-users text-xs mr-1 xl:mr-1.5"></i>
                        <span>PC</span>
                        <svg class="w-3 h-3 ml-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="chairsDropdown" class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                        <div class="py-1">
                            <a href="{{ route('pcMembers.list', ['acronyme' => request('acronyme')]) }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->is('pcMembers') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-users text-xs mr-2"></i>
                                View PC
                            </a>
                            <a href="{{ route('coChairs', ['acronyme' => request('acronyme')]) }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->is('coChairs') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-user-plus text-xs mr-2"></i>
                                Add PC
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Notifications Dropdown -->
                <div class="relative flex-shrink-0" id="notificationsDropdownContainer">
                    <button id="notificationsDropdownButton" 
                            class="inline-flex items-center px-2 xl:px-3 py-1.5 xl:py-2 text-xs xl:text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 transition-all duration-200 {{ request()->routeIs('chair.*') ? 'ring-2 ring-blue-300 bg-blue-50 text-blue-600' : 'text-gray-700' }}"
                            type="button"
                            aria-expanded="false"
                            aria-haspopup="true">
                        <i class="fas fa-envelope text-xs mr-1 xl:mr-1.5"></i>
                        <span class="hidden md:inline">Notify</span>
                        <span class="md:hidden">N</span>
                        <svg class="w-3 h-3 ml-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="notificationsDropdown" class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                        <div class="py-1">
                            <a href="{{ route('chair.pendingNotifications', ['acronyme' => request('acronyme')]) }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('chair.pendingNotifications') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-inbox text-xs mr-2"></i>
                                Pending
                            </a>
                            <a href="{{ route('chair.decisions.form', ['acronyme' => request('acronyme')]) }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('chair.decisions.form') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-paper-plane text-xs mr-2"></i>
                                Send Decisions
                            </a>
                            <a href="{{ route('chair.info.form', ['acronyme' => request('acronyme')]) }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('chair.info.form') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <i class="fas fa-info-circle text-xs mr-2"></i>
                                Inform Authors
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Return Button -->
            <div class="flex-shrink-0 ml-2">
                <a href="/" 
                   class="inline-flex items-center px-2 xl:px-3 py-1.5 xl:py-2 text-xs xl:text-sm font-medium rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 transition-all duration-200 text-gray-700">
                    <i class="fas fa-arrow-left text-xs mr-1 xl:mr-1.5"></i>
                    <span class="hidden md:inline">Return</span>
                    <span class="md:hidden">←</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="lg:hidden">
        <div class="flex items-center justify-between h-14 px-4">
            <!-- Mobile Menu Button -->
            <button id="mobileMenuButton" 
                    class="inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                    aria-label="Toggle navigation menu"
                    aria-expanded="false">
                <div class="w-6 h-6 relative">
                    <span class="absolute top-1 left-0 w-6 h-0.5 bg-current transform transition-all duration-300 ease-in-out" id="line1"></span>
                    <span class="absolute top-2.5 left-0 w-6 h-0.5 bg-current transform transition-all duration-300 ease-in-out" id="line2"></span>
                    <span class="absolute top-4 left-0 w-6 h-0.5 bg-current transform transition-all duration-300 ease-in-out" id="line3"></span>
                </div>
            </button>

            <!-- Mobile Title/Logo -->
            <div class="flex-1 text-center">
                <span class="text-lg font-semibold text-gray-900">Dashboard</span>
            </div>

            <!-- Mobile Return Button -->
            <a href="/" 
               class="inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
        </div>
    </div>
</div>

<!-- Mobile Menu (Fixed positioning to avoid black screen) -->
<div id="mobileMenuContainer" class="lg:hidden">
    <!-- Backdrop/Overlay -->
    <div id="mobileMenuOverlay" 
         class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 opacity-0 invisible transition-all duration-300 ease-in-out"></div>

    <!-- Mobile Menu Panel -->
    <div id="mobileMenu" 
         class="fixed top-0 left-0 w-80 max-w-[85vw] h-full bg-white shadow-xl z-50 transform -translate-x-full transition-transform duration-300 ease-in-out">
        
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between h-14 px-4 border-b border-gray-200 bg-gray-50">
            <span class="text-lg font-semibold text-gray-900">Navigation</span>
            <button id="closeMobileMenu" 
                    class="inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200"
                    aria-label="Close navigation menu">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Mobile Menu Content -->
        <div class="flex-1 overflow-y-auto py-4" style="height: calc(100vh - 3.5rem);">
            <nav class="px-4 space-y-2">
                <!-- Configuration -->
                <a href="/configuration?acronyme={{request('acronyme')}}" 
                   class="flex items-center px-4 py-3 text-base font-medium rounded-lg transition-colors duration-200 {{ request()->is('configuration') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-cog text-lg mr-3"></i>
                    Configuration
                </a>

                <!-- Statistics -->
                <a href="/statistics?acronyme={{ request('acronyme') }}" 
                   class="flex items-center px-4 py-3 text-base font-medium rounded-lg transition-colors duration-200 {{ request()->is('statistics') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-chart-bar text-lg mr-3"></i>
                    Statistics
                </a>

                <!-- Final Decision -->
                <a href="/finalDecision?acronyme={{request('acronyme')}}" 
                   class="flex items-center px-4 py-3 text-base font-medium rounded-lg transition-colors duration-200 {{ request()->is('finalDecision') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-check-circle text-lg mr-3"></i>
                    Final Decision
                </a>

                <!-- Evaluation -->
                <a href="/evaluation?acronyme={{request('acronyme')}}" 
                   class="flex items-center px-4 py-3 text-base font-medium rounded-lg transition-colors duration-200 {{ request()->is('evaluation') ? 'bg-blue-100 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-clipboard-check text-lg mr-3"></i>
                    Evaluation
                </a>

                <!-- Assignment Section -->
                <div class="space-y-1">
                    <button id="mobileAssignmentToggle" 
                            class="w-full flex items-center justify-between px-4 py-3 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                            aria-expanded="false">
                        <div class="flex items-center">
                            <i class="fas fa-users-cog text-lg mr-3"></i>
                            Assignment
                        </div>
                        <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="mobileAssignmentMenu" class="hidden pl-8 space-y-1">
                        <a href="{{ route('assignments.index', ['acronyme' => request('acronyme')]) }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('assignments.index') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-user-plus text-sm mr-2"></i>
                            Overview
                        </a>
                        <a href="/Attribution?acronyme={{ request('acronyme') }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->is('Attribution') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-users-cog text-sm mr-2"></i>
                            By Article
                        </a>
                        <a href="/pc-members-assignments?acronyme={{ request('acronyme') }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->is('pc-members-assignments') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-users text-sm mr-2"></i>
                            By PC Member
                        </a>
                    </div>
                </div>

                <!-- PC Section -->
                <div class="space-y-1">
                    <button id="mobilePcToggle" 
                            class="w-full flex items-center justify-between px-4 py-3 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                            aria-expanded="false">
                        <div class="flex items-center">
                            <i class="fas fa-users text-lg mr-3"></i>
                            PC Management
                        </div>
                        <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="mobilePcMenu" class="hidden pl-8 space-y-1">
                        <a href="{{ route('pcMembers.list', ['acronyme' => request('acronyme')]) }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->is('pcMembers') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-users text-sm mr-2"></i>
                            View PC
                        </a>
                        <a href="{{ route('coChairs', ['acronyme' => request('acronyme')]) }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->is('coChairs') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-user-plus text-sm mr-2"></i>
                            Add PC
                        </a>
                    </div>
                </div>

                <!-- Notifications Section -->
                <div class="space-y-1">
                    <button id="mobileNotificationsToggle" 
                            class="w-full flex items-center justify-between px-4 py-3 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                            aria-expanded="false">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-lg mr-3"></i>
                            Notifications
                        </div>
                        <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="mobileNotificationsMenu" class="hidden pl-8 space-y-1">
                        <a href="{{ route('chair.pendingNotifications', ['acronyme' => request('acronyme')]) }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('chair.pendingNotifications') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-inbox text-sm mr-2"></i>
                            Pending
                        </a>
                        <a href="{{ route('chair.decisions.form', ['acronyme' => request('acronyme')]) }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('chair.decisions.form') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-paper-plane text-sm mr-2"></i>
                            Send Decisions
                        </a>
                        <a href="{{ route('chair.info.form', ['acronyme' => request('acronyme')]) }}" 
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('chair.info.form') ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-info-circle text-sm mr-2"></i>
                            Inform Authors
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Utility functions
    const debounce = (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    // Desktop dropdown management
    function setupDesktopDropdown(containerId, buttonId, dropdownId) {
        const container = document.getElementById(containerId);
        const button = document.getElementById(buttonId);
        const dropdown = document.getElementById(dropdownId);
        const arrow = button?.querySelector('svg');

        if (!container || !button || !dropdown) return;

        let isOpen = false;
        let timeoutId;

        const openDropdown = () => {
            clearTimeout(timeoutId);
            dropdown.classList.remove('hidden');
            button.setAttribute('aria-expanded', 'true');
            if (arrow) arrow.style.transform = 'rotate(180deg)';
            isOpen = true;
        };

        const closeDropdown = () => {
            dropdown.classList.add('hidden');
            button.setAttribute('aria-expanded', 'false');
            if (arrow) arrow.style.transform = 'rotate(0deg)';
            isOpen = false;
        };

        const scheduleClose = () => {
            timeoutId = setTimeout(closeDropdown, 150);
        };

        // Mouse events
        button.addEventListener('mouseenter', openDropdown);
        dropdown.addEventListener('mouseenter', () => clearTimeout(timeoutId));
        container.addEventListener('mouseleave', scheduleClose);

        // Click events
        button.addEventListener('click', (e) => {
            e.preventDefault();
            isOpen ? closeDropdown() : openDropdown();
        });

        // Keyboard events
        button.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                isOpen ? closeDropdown() : openDropdown();
            } else if (e.key === 'Escape') {
                closeDropdown();
            }
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!container.contains(e.target)) {
                closeDropdown();
            }
        });
    }

    // Setup desktop dropdowns
    setupDesktopDropdown('pcDropdownContainer', 'pcDropdownButton', 'pcDropdown');
    setupDesktopDropdown('chairsDropdownContainer', 'chairsDropdownButton', 'chairsDropdown');
    setupDesktopDropdown('notificationsDropdownContainer', 'notificationsDropdownButton', 'notificationsDropdown');

    // Mobile menu management - FIXED
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const closeMobileMenu = document.getElementById('closeMobileMenu');
    const line1 = document.getElementById('line1');
    const line2 = document.getElementById('line2');
    const line3 = document.getElementById('line3');

    let mobileMenuOpen = false;

    const openMobileMenu = () => {
        mobileMenuOpen = true;
        
        // Show overlay with proper transition
        mobileMenuOverlay.classList.remove('invisible');
        mobileMenuOverlay.classList.remove('opacity-0');
        mobileMenuOverlay.classList.add('opacity-100');
        
        // Show menu panel
        mobileMenu.style.transform = 'translateX(0)';
        mobileMenuButton.setAttribute('aria-expanded', 'true');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Animate hamburger to X
        if (line1) line1.style.transform = 'rotate(45deg) translate(6px, 6px)';
        if (line2) line2.style.opacity = '0';
        if (line3) line3.style.transform = 'rotate(-45deg) translate(6px, -6px)';
    };

    const closeMobileMenuFunc = () => {
        mobileMenuOpen = false;
        
        // Hide overlay
        mobileMenuOverlay.classList.remove('opacity-100');
        mobileMenuOverlay.classList.add('opacity-0');
        
        // Hide menu panel
        mobileMenu.style.transform = 'translateX(-100%)';
        mobileMenuButton.setAttribute('aria-expanded', 'false');
        
        // Restore body scroll
        document.body.style.overflow = '';
        
        // Reset hamburger
        if (line1) line1.style.transform = '';
        if (line2) line2.style.opacity = '';
        if (line3) line3.style.transform = '';
        
        // Hide overlay completely after transition
        setTimeout(() => {
            if (!mobileMenuOpen) {
                mobileMenuOverlay.classList.add('invisible');
            }
        }, 300);
    };

    // Mobile menu event listeners
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            mobileMenuOpen ? closeMobileMenuFunc() : openMobileMenu();
        });
    }

    if (closeMobileMenu) {
        closeMobileMenu.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            closeMobileMenuFunc();
        });
    }

    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            closeMobileMenuFunc();
        });
    }

    // Mobile submenu toggles
    function setupMobileSubmenu(toggleId, menuId) {
        const toggle = document.getElementById(toggleId);
        const menu = document.getElementById(menuId);
        const arrow = toggle?.querySelector('svg');

        if (!toggle || !menu) return;

        let isOpen = false;

        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            isOpen = !isOpen;
            menu.classList.toggle('hidden');
            toggle.setAttribute('aria-expanded', isOpen.toString());
            
            if (arrow) {
                arrow.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    }

    setupMobileSubmenu('mobileAssignmentToggle', 'mobileAssignmentMenu');
    setupMobileSubmenu('mobilePcToggle', 'mobilePcMenu');
    setupMobileSubmenu('mobileNotificationsToggle', 'mobileNotificationsMenu');

    // Handle window resize
    const handleResize = debounce(() => {
        if (window.innerWidth >= 1024 && mobileMenuOpen) {
            closeMobileMenuFunc();
        }
    }, 250);

    window.addEventListener('resize', handleResize);

    // Handle escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenuOpen) {
            closeMobileMenuFunc();
        }
    });

    // Prevent dropdown overflow
    function adjustDropdownPosition() {
        const dropdowns = document.querySelectorAll('[id$="Dropdown"]:not(.hidden)');
        dropdowns.forEach(dropdown => {
            const rect = dropdown.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            
            if (rect.right > viewportWidth) {
                dropdown.style.left = 'auto';
                dropdown.style.right = '0';
            }
        });
    }

    // Adjust dropdown positions on scroll and resize
    window.addEventListener('scroll', debounce(adjustDropdownPosition, 100));
    window.addEventListener('resize', debounce(adjustDropdownPosition, 100));
});
</script>

<style>
/* Remove all scrollbars and ensure proper layout */
* {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

*::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

/* Ensure no horizontal overflow */
html, body {
    overflow-x: hidden;
    max-width: 100vw;
}

/* Mobile menu specific fixes */
#mobileMenuContainer {
    position: relative;
    z-index: 9999;
}

#mobileMenuOverlay {
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
}

#mobileMenu {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Desktop navigation responsive adjustments */
@media (min-width: 1024px) {
    .desktop-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 100%;
    }
    
    .nav-items {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
        min-width: 0;
        flex: 1;
    }
}

/* Compact mode for medium screens */
@media (min-width: 1024px) and (max-width: 1279px) {
    .nav-item {
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .nav-item i {
        margin-right: 0.25rem;
    }
}

/* Dropdown positioning */
.dropdown-menu {
    position: absolute;
    top: 100%;
    z-index: 50;
    min-width: 12rem;
    max-width: 20rem;
}

/* Prevent text selection on buttons */
button {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Focus styles for accessibility */
button:focus,
a:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .border-gray-200 {
        border-color: #000000;
    }
    
    .text-gray-700 {
        color: #000000;
    }
    
    .bg-gray-50 {
        background-color: #ffffff;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    * {
        transition: none !important;
        animation: none !important;
    }
}

/* Print styles */
@media print {
    #mobileMenuContainer,
    #mobileMenuButton {
        display: none !important;
    }
    
    .desktop-nav {
        display: flex !important;
    }
}

/* Very small screens */
@media (max-width: 320px) {
    #mobileMenu {
        width: 100vw;
        max-width: 100vw;
    }
    
    .nav-item {
        padding: 0.25rem 0.375rem;
        font-size: 0.625rem;
    }
}

/* Large screens optimization */
@media (min-width: 1536px) {
    .nav-item {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
}

/* Landscape phone optimization */
@media (max-height: 500px) and (orientation: landscape) {
    #mobileMenu {
        height: 100vh;
        overflow-y: auto;
    }
}

/* Ensure mobile menu is always on top */
@media (max-width: 1023px) {
    #mobileMenuContainer {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 9999;
    }
    
    #mobileMenuContainer.active {
        pointer-events: auto;
    }
    
    #mobileMenuOverlay.opacity-100 {
        pointer-events: auto;
    }
    
    #mobileMenu {
        pointer-events: auto;
    }
}
</style>
@endsection

@section('content')
<div class="w-full max-w-full overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @yield('content1')
        @stack('scripts')
    </div>
</div>
@endsection