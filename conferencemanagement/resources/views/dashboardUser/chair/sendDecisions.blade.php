@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-2 sm:p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 text-center px-4">
        <div class="mx-auto flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
            <i class="fas fa-envelope text-blue-600 dark:text-blue-400 text-lg sm:text-xl"></i>
        </div>
        <h1 class="mt-3 text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white break-words">
            {{ $mode === 'decision' ? 'Send Decision Notifications' : 'Send Info to Authors' }}
        </h1>
        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed break-words">
            {{ $mode === 'decision' ? 'Notify authors about their submission decisions' : 'Send information to submission authors' }}
        </p>
    </div>

    @if($submissions->isEmpty())
        <!-- Empty State -->
        <div class="mx-4 sm:mx-0 mb-4 rounded-lg bg-blue-100 dark:bg-blue-900/20 px-4 sm:px-6 py-4 text-sm text-blue-800 dark:text-blue-300 shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2 flex-shrink-0"></i>
                <span class="break-words">
                    No submissions {{ $mode === 'decision' ? 'requiring notification' : 'available' }} at this time.
                </span>
            </div>
        </div>
    @else
        <!-- Filter Section -->
        <div class="mx-4 sm:mx-0 mb-6 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="bg-gray-100 dark:bg-gray-700 px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-filter mr-2 text-blue-500"></i>
                        Filter Submissions
                    </h3>
                    <div class="grid grid-cols-2 sm:flex gap-2 sm:gap-4">
                        <label class="flex items-center gap-2 cursor-pointer p-2 sm:p-0 rounded hover:bg-gray-200 dark:hover:bg-gray-600 sm:hover:bg-transparent transition-colors">
                            <input type="radio" name="status_filter" value="accepted" class="status-filter text-blue-600 focus:ring-blue-500">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Accepted</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-2 sm:p-0 rounded hover:bg-gray-200 dark:hover:bg-gray-600 sm:hover:bg-transparent transition-colors">
                            <input type="radio" name="status_filter" value="rejected" class="status-filter text-blue-600 focus:ring-blue-500">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Rejected</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-2 sm:p-0 rounded hover:bg-gray-200 dark:hover:bg-gray-600 sm:hover:bg-transparent transition-colors">
                            <input type="radio" name="status_filter" value="borderline" class="status-filter text-blue-600 focus:ring-blue-500">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Borderline</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-2 sm:p-0 rounded hover:bg-gray-200 dark:hover:bg-gray-600 sm:hover:bg-transparent transition-colors">
                            <input type="radio" name="status_filter" value="all" checked class="status-filter text-blue-600 focus:ring-blue-500">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">All</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile & Tablet Cards (visible on screens smaller than 1280px) -->
        <div class="block xl:hidden mx-4 sm:mx-0 space-y-4">
            <!-- Select All Card -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="selectAllMobile" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                    <div class="flex items-center">
                        <i class="fas fa-check-square mr-2 text-blue-500"></i>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Select All Visible</span>
                    </div>
                </label>
            </div>

            <!-- Submission Cards -->
            @foreach($submissions as $submission)
            <div class="submission-row bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                 data-status="{{ strtolower($submission->statut) }}">
                
                <!-- Header with Checkbox and Status -->
                <div class="flex items-start justify-between mb-4">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="submissions[]" 
                               value="{{ $submission->idSubmission }}"
                               class="submission-checkbox rounded text-blue-600 focus:ring-blue-500 mr-3"
                               data-status="{{ strtolower($submission->statut) }}">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Select for notification</span>
                    </label>
                    
                    @if($submission->statut === 'accepted')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-300 flex-shrink-0 ml-2">
                            <i class="fas fa-check-circle mr-1"></i>
                            Accepted
                        </span>
                    @elseif($submission->statut === 'rejected')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-300 flex-shrink-0 ml-2">
                            <i class="fas fa-times-circle mr-1"></i>
                            Rejected
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-300 flex-shrink-0 ml-2">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Borderline
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h3 class="text-base font-medium text-gray-900 dark:text-white mb-4 break-words leading-tight">
                    {{ $submission->titre }}
                </h3>

                <!-- Author Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 border-t border-gray-100 dark:border-gray-600 pt-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                            <i class="fas fa-user mr-1"></i>
                            Author:
                        </p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white break-words">
                            {{ $submission->primaryAuthor->user->firstName }} {{ $submission->primaryAuthor->user->lastName }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 flex items-center">
                            <i class="fas fa-envelope mr-1"></i>
                            Email:
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 break-words">
                            {{ $submission->primaryAuthor->user->email }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Mobile Action Button -->
            <div class="sticky bottom-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                <button type="button" id="composeBtnMobile"
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-edit mr-2"></i>
                    Compose Email
                    <span id="selectedCountMobile" class="ml-2 bg-blue-500 px-2 py-1 rounded-full text-xs hidden">0</span>
                </button>
            </div>
        </div>

        <!-- Desktop Table (visible on screens 1280px and larger) -->
        <div class="hidden xl:block">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-blue-600 text-white">
                                <th class="px-4 py-4 text-left font-semibold text-sm w-1/8">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="selectAll" class="rounded text-blue-200 focus:ring-blue-500 mr-3">
                                        <i class="fas fa-check-square mr-2"></i>
                                        Select
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left font-semibold text-sm w-2/5">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        Title
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left font-semibold text-sm w-1/6">
                                    <div class="flex items-center">
                                        <i class="fas fa-user mr-2"></i>
                                        Author
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left font-semibold text-sm w-1/5">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope mr-2"></i>
                                        Email
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left font-semibold text-sm w-1/8">
                                    <div class="flex items-center">
                                        <i class="fas fa-gavel mr-2"></i>
                                        Decision
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($submissions as $submission)
                            <tr class="submission-row {{ $loop->even ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200"
                                data-status="{{ strtolower($submission->statut) }}">
                                <td class="px-4 py-6">
                                    <input type="checkbox" 
                                           name="submissions[]" 
                                           value="{{ $submission->idSubmission }}"
                                           class="submission-checkbox rounded text-blue-600 focus:ring-blue-500"
                                           data-status="{{ strtolower($submission->statut) }}">
                                </td>
                                <td class="px-4 py-6 text-sm text-gray-900 dark:text-white font-medium break-words">
                                    {{ $submission->titre }}
                                </td>
                                <td class="px-4 py-6 text-sm text-gray-600 dark:text-gray-300 break-words">
                                    {{ $submission->primaryAuthor->user->firstName }} {{ $submission->primaryAuthor->user->lastName }}
                                </td>
                                <td class="px-4 py-6 text-sm text-gray-600 dark:text-gray-300 break-words">
                                    {{ $submission->primaryAuthor->user->email }}
                                </td>
                                <td class="px-4 py-6">
                                    @if($submission->statut === 'accepted')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-300">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Accepted
                                        </span>
                                    @elseif($submission->statut === 'rejected')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-300">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-300">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            Borderline
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Desktop Action Button -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <span id="selectedCount">0</span> submission(s) selected
                        </div>
                        <button type="button" id="composeBtn"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-edit mr-2"></i>
                            Compose Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Email Composition Modal -->
<div id="emailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-2 sm:p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-6xl h-full sm:h-5/6 flex flex-col animate-in fade-in duration-200">
        <!-- Modal Header -->
        <div class="flex justify-between items-center px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 rounded-t-lg">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-envelope mr-2 text-blue-500"></i>
                Compose Notification Email
            </h3>
            <button id="closeModalBtn" 
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg shadow text-sm font-medium transition-colors duration-200">
                <i class="fas fa-times mr-1"></i>
                Close
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="flex-1 overflow-hidden">
            <iframe id="emailFormFrame" src="" class="w-full h-full border-0"></iframe>
        </div>
    </div>
</div>

<script>
// Make closeEmailModal globally accessible
function closeEmailModal() {
    const modal = document.getElementById('emailModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

document.addEventListener('DOMContentLoaded', function () {
    // Get all necessary elements
    const filterRadios = document.querySelectorAll('input[name="status_filter"]');
    const checkboxes = document.querySelectorAll('.submission-checkbox');
    const selectAll = document.getElementById('selectAll');
    const selectAllMobile = document.getElementById('selectAllMobile');
    const composeBtn = document.getElementById('composeBtn');
    const composeBtnMobile = document.getElementById('composeBtnMobile');
    const emailModal = document.getElementById('emailModal');
    const emailFormFrame = document.getElementById('emailFormFrame');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const selectedCount = document.getElementById('selectedCount');
    const selectedCountMobile = document.getElementById('selectedCountMobile');

    // Close modal event listener
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeEmailModal);
    }

    // Update UI based on selections
    function updateUI() {
        const visibleCheckboxes = getVisibleCheckboxes();
        const checkedBoxes = visibleCheckboxes.filter(cb => cb.checked);
        const checkedCount = checkedBoxes.length;
        const hasSelection = checkedCount > 0;
        
        // Update compose buttons
        if (composeBtn) composeBtn.disabled = !hasSelection;
        if (composeBtnMobile) composeBtnMobile.disabled = !hasSelection;
        
        // Update counters
        if (selectedCount) selectedCount.textContent = checkedCount;
        if (selectedCountMobile) {
            selectedCountMobile.textContent = checkedCount;
            selectedCountMobile.classList.toggle('hidden', checkedCount === 0);
        }
        
        // Update select all checkboxes
        const allChecked = checkedCount === visibleCheckboxes.length && visibleCheckboxes.length > 0;
        const someChecked = checkedCount > 0 && checkedCount < visibleCheckboxes.length;
        
        [selectAll, selectAllMobile].forEach(checkbox => {
            if (checkbox) {
                checkbox.checked = allChecked;
                checkbox.indeterminate = someChecked;
            }
        });
    }

    // Get visible checkboxes based on current filter
    function getVisibleCheckboxes() {
        return Array.from(checkboxes).filter(cb => {
            const row = cb.closest('.submission-row');
            return row && row.style.display !== 'none';
        });
    }

    // Apply status filter
    function applyFilter(status) {
        const rows = document.querySelectorAll('.submission-row');
        
        rows.forEach(row => {
            const checkbox = row.querySelector('.submission-checkbox');
            const shouldShow = status === 'all' || checkbox.dataset.status === status;
            
            row.style.display = shouldShow ? '' : 'none';
            
            // Auto-select visible items
            if (shouldShow) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
        
        updateUI();
    }

    // Handle select all functionality
    function handleSelectAll(selectAllCheckbox) {
        const shouldCheck = selectAllCheckbox.checked;
        const visibleCheckboxes = getVisibleCheckboxes();
        
        visibleCheckboxes.forEach(cb => {
            cb.checked = shouldCheck;
        });
        
        // Sync both select all checkboxes
        [selectAll, selectAllMobile].forEach(checkbox => {
            if (checkbox && checkbox !== selectAllCheckbox) {
                checkbox.checked = shouldCheck;
                checkbox.indeterminate = false;
            }
        });
        
        updateUI();
    }

    // Event listeners for filters
    filterRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            applyFilter(this.value);
        });
    });

    // Event listeners for select all
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            handleSelectAll(this);
        });
    }

    if (selectAllMobile) {
        selectAllMobile.addEventListener('change', function () {
            handleSelectAll(this);
        });
    }

    // Event listeners for individual checkboxes
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateUI);
    });

    // Compose button functionality
    function handleCompose() {
        const selectedSubmissions = getVisibleCheckboxes()
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (selectedSubmissions.length === 0) {
            alert('Please select at least one submission');
            return;
        }
        
        const emailFormBaseUrl = "{{ route('chair.email-form', ['acronyme' => request('acronyme'), 'mode' => $mode]) }}";
        emailFormFrame.src = emailFormBaseUrl + "?submissions=" + encodeURIComponent(selectedSubmissions.join(','));

        emailModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Event listeners for compose buttons
    if (composeBtn) {
        composeBtn.addEventListener('click', handleCompose);
    }

    if (composeBtnMobile) {
        composeBtnMobile.addEventListener('click', handleCompose);
    }

    // Handle messages from iframe
    window.addEventListener('message', function(event) {
        if (event.data === 'closeModal') {
            closeEmailModal();
        } else if (event.data.action === 'notificationsSent') {
            closeEmailModal();
            alert(event.data.message);
            window.location.reload();
        }
    });

    // Handle escape key for modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('emailModal');
            if (!modal.classList.contains('hidden')) {
                closeEmailModal();
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        // Close modal on mobile if screen becomes too small
        if (window.innerWidth < 640) {
            const modal = document.getElementById('emailModal');
            if (!modal.classList.contains('hidden')) {
                closeEmailModal();
            }
        }
    });

    // Initialize with all submissions selected
    applyFilter('all');
    updateUI();
});
</script>

<style>
/* Smooth animations */
.animate-in {
    animation: slideIn 0.2s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Custom scrollbar for webkit browsers */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Dark mode scrollbar */
.dark .overflow-y-auto::-webkit-scrollbar-track {
    background: #374151;
}

.dark .overflow-y-auto::-webkit-scrollbar-thumb {
    background: #6b7280;
}

.dark .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

/* Focus styles for accessibility */
input:focus,
button:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .bg-gray-50 {
        background-color: #ffffff;
    }
    .text-gray-600 {
        color: #000000;
    }
    .border-gray-200 {
        border-color: #000000;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    .transition-colors,
    .transition-all,
    .animate-in {
        transition: none;
        animation: none;
    }
}

/* Print styles */
@media print {
    .sticky {
        position: static;
    }
    .shadow-lg,
    .shadow-xl {
        box-shadow: none;
    }
    #emailModal {
        display: none !important;
    }
}

/* Very small screens */
@media (max-width: 320px) {
    .px-4 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    .text-xl {
        font-size: 1.125rem;
    }
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
}

/* Large screens optimization */
@media (min-width: 1536px) {
    .max-w-6xl {
        max-width: 80rem;
    }
}

/* Landscape phone optimization */
@media (max-height: 500px) and (orientation: landscape) {
    .h-full {
        height: 95vh;
    }
    .sm\:h-5\/6 {
        height: 90vh;
    }
}

/* Touch feedback for mobile */
@media (hover: none) and (pointer: coarse) {
    .cursor-pointer:active {
        transform: scale(0.98);
    }
}
</style>
@endsection

@push('scripts')
<script>
// Additional global functions if needed by iframe
window.parentCloseModal = closeEmailModal;
</script>
@endpush