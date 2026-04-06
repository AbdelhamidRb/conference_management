@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-2 sm:p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 text-center px-4">
        <div class="mx-auto flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
            <i class="fas fa-envelope text-blue-600 dark:text-blue-400 text-lg sm:text-xl"></i>
        </div>
        <h1 class="mt-3 text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white break-words">
            Pending Notifications
        </h1>
        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed break-words">
            Select PC members to notify about all their assigned articles
        </p>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="hidden mb-4 mx-4 sm:mx-0 rounded-lg bg-green-100 px-4 sm:px-6 py-4 text-sm text-green-800 shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2 flex-shrink-0"></i>
            <p>Notifications sent successfully!</p>
        </div>
    </div>

    <!-- Error Message -->
    @if(session('error'))
    <div class="mb-4 mx-4 sm:mx-0 rounded-lg bg-red-100 px-4 sm:px-6 py-4 text-sm text-red-800 shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2 flex-shrink-0"></i>
            <span class="break-words">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    @if(count($pendingAssignments) > 0)
    <form id="notificationsForm" class="mx-4 sm:mx-0">
        @csrf
        
        <!-- Mobile & Tablet Cards (visible on screens smaller than 1280px) -->
        <div class="block xl:hidden space-y-4">
            <!-- Select All Card -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="selectAllMobile" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                    <div class="flex items-center">
                        <i class="fas fa-check-square mr-2 text-blue-500"></i>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Select All PC Members</span>
                    </div>
                </label>
            </div>

            <!-- PC Member Cards -->
            @foreach($pendingAssignments as $pcMemberId => $assignments)
            @php $pcMember = $assignments->first()->pcMember; @endphp
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <!-- Header with Checkbox and Status -->
                <div class="flex items-start justify-between mb-4">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="pc_members[]" 
                               value="{{ $pcMember->id }}"
                               class="pc-member-checkbox rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Select for notification</span>
                    </label>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-300 flex-shrink-0 ml-2">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $assignments->count() }} pending
                    </span>
                </div>

                <!-- PC Member Info -->
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <div class="text-base font-medium text-gray-900 dark:text-white break-words">
                            {{ $pcMember->user->firstName }} {{ $pcMember->user->lastName }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 break-words">
                            {{ $pcMember->user->email }}
                        </div>
                    </div>
                </div>

                <!-- Pending Articles -->
                <div class="border-t border-gray-100 dark:border-gray-600 pt-4">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                        Pending Articles
                    </h4>
                    <div class="space-y-2 max-h-32 overflow-y-auto">
                        @foreach($assignments as $assignment)
                        <div class="text-xs text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded break-words">
                            {{ Str::limit($assignment->submission->titre, 60) }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Mobile Action Button -->
            <div class="sticky bottom-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                <button type="button" 
                        onclick="openEmailComposer()"
                        id="sendButtonMobile"
                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send Notifications
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
                                <th class="px-4 py-4 text-left font-semibold text-sm w-1/6">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="selectAll" class="rounded text-blue-200 focus:ring-blue-500 mr-3">
                                        <i class="fas fa-check-square mr-2"></i>
                                        Select All
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left font-semibold text-sm w-2/5">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        PC Member
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-left font-semibold text-sm w-2/5">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        Pending Articles
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($pendingAssignments as $pcMemberId => $assignments)
                            @php $pcMember = $assignments->first()->pcMember; @endphp
                            <tr class="{{ $loop->even ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200">
                                <!-- Checkbox Column -->
                                <td class="px-4 py-6">
                                    <input type="checkbox" 
                                           name="pc_members[]" 
                                           value="{{ $pcMember->id }}"
                                           class="pc-member-checkbox rounded text-blue-600 focus:ring-blue-500">
                                </td>
                                
                                <!-- PC Member Column -->
                                <td class="px-4 py-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div class="ml-4 min-w-0 flex-1">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white break-words">
                                                {{ $pcMember->user->firstName }} {{ $pcMember->user->lastName }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 break-words">
                                                {{ $pcMember->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Articles Column -->
                                <td class="px-4 py-6">
                                    <div class="mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-300">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $assignments->count() }} articles pending
                                        </span>
                                    </div>
                                    <div class="space-y-1 max-h-32 overflow-y-auto">
                                        @foreach($assignments as $assignment)
                                        <div class="text-xs text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded break-words">
                                            {{ Str::limit($assignment->submission->titre, 80) }}
                                        </div>
                                        @endforeach
                                    </div>
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
                            <span id="selectedCount">0</span> PC member(s) selected
                        </div>
                        <button type="button" 
                                onclick="openEmailComposer()"
                                id="sendButton"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Notifications
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @else
    <!-- Empty State -->
    <div class="mx-4 sm:mx-0 bg-white dark:bg-gray-800 p-8 sm:p-12 rounded-lg shadow border border-gray-200 dark:border-gray-700 text-center">
        <div class="flex flex-col items-center">
            <i class="fas fa-inbox text-gray-400 dark:text-gray-500 text-4xl sm:text-5xl mb-4"></i>
            <h3 class="text-lg sm:text-xl font-medium text-gray-900 dark:text-white mb-2">No Pending Notifications</h3>
            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 max-w-md break-words">
                All PC members have been notified about their assignments, or there are no assignments to notify about.
            </p>
        </div>
    </div>
    @endif
</div>

<!-- Email Composition Modal -->
<div id="emailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-2 sm:p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-4xl h-full sm:h-5/6 flex flex-col animate-in fade-in duration-200">
        <!-- Modal Header -->
        <div class="flex justify-between items-center px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 rounded-t-lg">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-envelope mr-2 text-blue-500"></i>
                Compose Notification Email
            </h3>
            <button onclick="closeEmailModal()" 
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg shadow text-sm font-medium transition-colors duration-200">
                <i class="fas fa-times mr-1"></i>
                Close
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6">
            <form id="emailForm" class="space-y-4 sm:space-y-6">
                @csrf
                <input type="hidden" name="pc_members" id="pcMembersInput">

                <!-- Subject Field -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-tag mr-1 text-blue-500"></i>
                        Email Subject
                    </label>
                    <input type="text" name="subject" id="subject" 
                           value="Article Review Assignment for {{ $conference->acronyme }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                </div>

                <!-- Message Field -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-edit mr-1 text-blue-500"></i>
                        Email Content
                    </label>
                    <textarea name="message" id="message" rows="10" 
                              class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base resize-none">Dear [PC Member Name],

You have been assigned to review the following articles for {{ $conference->title }} ({{ $conference->acronyme }}):

[Article List]

Please log in to the conference system to access the articles and submit your reviews by the deadline.

Best regards,
{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
Conference Chair</textarea>
                    
                    <!-- Help Text -->
                    <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300">
                            <i class="fas fa-info-circle mr-1"></i>
                            Use <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded text-xs">[PC Member Name]</code> and <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded text-xs">[Article List]</code> as placeholders
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" onclick="closeEmailModal()" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white text-sm font-medium rounded-lg shadow transition duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="button" onclick="submitEmailForm()"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Notifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all necessary elements
    const selectAll = document.getElementById('selectAll');
    const selectAllMobile = document.getElementById('selectAllMobile');
    const checkboxes = document.querySelectorAll('.pc-member-checkbox');
    const sendButton = document.getElementById('sendButton');
    const sendButtonMobile = document.getElementById('sendButtonMobile');
    const selectedCount = document.getElementById('selectedCount');
    const selectedCountMobile = document.getElementById('selectedCountMobile');

    // Update button states and counters
    function updateUI() {
        const checkedBoxes = document.querySelectorAll('.pc-member-checkbox:checked');
        const checkedCount = checkedBoxes.length;
        const totalCount = checkboxes.length;
        
        // Update send buttons
        const hasSelection = checkedCount > 0;
        if (sendButton) sendButton.disabled = !hasSelection;
        if (sendButtonMobile) sendButtonMobile.disabled = !hasSelection;
        
        // Update counters
        if (selectedCount) selectedCount.textContent = checkedCount;
        if (selectedCountMobile) {
            selectedCountMobile.textContent = checkedCount;
            selectedCountMobile.classList.toggle('hidden', checkedCount === 0);
        }
        
        // Update select all checkboxes
        const allChecked = checkedCount === totalCount && totalCount > 0;
        const someChecked = checkedCount > 0 && checkedCount < totalCount;
        
        [selectAll, selectAllMobile].forEach(checkbox => {
            if (checkbox) {
                checkbox.checked = allChecked;
                checkbox.indeterminate = someChecked;
            }
        });
    }

    // Handle select all functionality
    function handleSelectAll(selectAllCheckbox) {
        const shouldCheck = selectAllCheckbox.checked;
        checkboxes.forEach(checkbox => {
            checkbox.checked = shouldCheck;
        });
        
        // Sync both select all checkboxes
        [selectAll, selectAllMobile].forEach(checkbox => {
            if (checkbox && checkbox !== selectAllCheckbox) {
                checkbox.checked = shouldCheck;
            }
        });
        
        updateUI();
    }

    // Event listeners
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            handleSelectAll(this);
        });
    }

    if (selectAllMobile) {
        selectAllMobile.addEventListener('change', function() {
            handleSelectAll(this);
        });
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateUI);
    });

    // Initialize UI
    updateUI();
});

// Modal functions
function openEmailComposer() {
    const formData = new FormData(document.getElementById('notificationsForm'));
    const pcMembers = formData.getAll('pc_members[]');
    
    if (pcMembers.length === 0) {
        alert('Please select at least one PC member');
        return;
    }
    
    document.getElementById('pcMembersInput').value = JSON.stringify(pcMembers);
    
    const modal = document.getElementById('emailModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeEmailModal() {
    const modal = document.getElementById('emailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

function submitEmailForm() {
    const form = document.getElementById('emailForm');
    const formData = new FormData(form);
    
    // Disable the send button to prevent double submission
    const sendBtns = document.querySelectorAll('#emailForm button[onclick="submitEmailForm()"]');
    sendBtns.forEach(btn => {
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
        btn.dataset.originalText = originalText;
    });
    
    fetch("{{ route('notifications.send', $conference->acronyme) }}", {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeEmailModal();
            
            // Show success message
            const successMessage = document.getElementById('successMessage');
            successMessage.classList.remove('hidden');
            successMessage.classList.add('flex');

            // Hide the message after 3 seconds and reload
            setTimeout(() => {
                successMessage.classList.add('hidden');
                successMessage.classList.remove('flex');
                window.location.reload();
            }, 3000);
        } else {
            alert('Failed to send notifications: ' + (data.message || 'Unknown error.'));
            // Re-enable buttons
            sendBtns.forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = btn.dataset.originalText;
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while sending notifications.');
        // Re-enable buttons
        sendBtns.forEach(btn => {
            btn.disabled = false;
            btn.innerHTML = btn.dataset.originalText;
        });
    });
}

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
textarea:focus,
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
}

/* Large screens optimization */
@media (min-width: 1536px) {
    .max-w-4xl {
        max-width: 72rem;
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
</style>
@endsection