@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invite PC Members</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
    <div class="min-h-screen py-6 md:py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <h1 class="mt-3 text-2xl md:text-3xl font-bold">Invite PC Members</h1>
                <p class="mt-2 text-sm md:text-base text-gray-600 dark:text-gray-400">Add PC Members to this conference.</p>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
            <div class="rounded-md bg-green-200 border-green-200 dark:bg-green-900/30 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                @php session()->forget('success') @endphp
            </div>
            @endif

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Section -->
                <div class="lg:col-span-1">
                    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-200/50 dark:ring-gray-700/50 sticky top-6">
                        <h2 class="text-lg font-semibold mb-4 flex items-center">
                            <i class="fas fa-user-plus mr-2 text-blue-600 dark:text-blue-400"></i>
                            Add New PC Member
                        </h2>

                        <form id="addPCMemberForm" class="space-y-4" method="POST" action="pcMembersInvitation">
                            @csrf
                            <input type="hidden" id="acronyme" name="acronyme" value="{{ request('acronyme') }}">

                            <div>
                                <label for="firstName" class="block text-sm font-medium mb-2">
                                    <i class="fas fa-user mr-1 text-gray-500"></i>
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="firstName"
                                    id="firstName"
                                    required
                                    placeholder="Enter first name"
                                    class="mt-1 block w-full rounded-md py-3 pl-3 pr-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 border border-gray-300 dark:border-gray-600 transition-colors">
                            </div>

                            <div>
                                <label for="lastName" class="block text-sm font-medium mb-2">
                                    <i class="fas fa-user mr-1 text-gray-500"></i>
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="lastName"
                                    id="lastName"
                                    required
                                    placeholder="Enter last name"
                                    class="mt-1 block w-full rounded-md py-3 pl-3 pr-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 border border-gray-300 dark:border-gray-600 transition-colors">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium mb-2">
                                    <i class="fas fa-envelope mr-1 text-gray-500"></i>
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    required
                                    placeholder="Enter email address"
                                    class="mt-1 block w-full rounded-md py-3 pl-3 pr-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 border border-gray-300 dark:border-gray-600 transition-colors">
                            </div>

                            <button
                                type="button"
                                id="addPCMember"
                                class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Add PC Member
                            </button>
                        </form>
                    </div>
                </div>

                <!-- PC Members List Section -->
                <div class="lg:col-span-2">
                    <div class="rounded-lg bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-200/50 dark:ring-gray-700/50">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium flex items-center">
                                <i class="fas fa-users mr-2 text-green-600 dark:text-green-400"></i>
                                PC Members to Invite
                                <span id="pcMembersCount" class="ml-2 px-2 py-1 text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">0</span>
                            </h3>
                        </div>

                        <!-- Mobile View (Cards) -->
                        <div class="block lg:hidden" id="pcMembersMobile">
                            <div id="pcMembersMobileContainer" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Mobile cards will be inserted here -->
                            </div>
                            <div id="pcMembersEmptyMobile" class="p-6 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-user-plus text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                <p>No PC members added yet</p>
                                <p class="text-xs mt-1">Use the form to add PC members</p>
                            </div>
                        </div>

                        <!-- Desktop View (Table) -->
                        <div class="hidden lg:block">
                            <table id="pcMembersTable" class="hidden w-full text-left">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-user mr-1"></i>
                                            First Name
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-user mr-1"></i>
                                            Last Name
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-envelope mr-1"></i>
                                            Email
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="fas fa-cogs mr-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="pcMembersTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                </tbody>
                            </table>

                            <div id="pcMembersEmptyTable" class="p-6 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-user-plus text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                <p>No PC members added yet</p>
                                <p class="text-xs mt-1">Use the form to add PC members</p>
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div id="submitSection" class="hidden border-t border-gray-200 dark:border-gray-700 p-6 bg-gray-50 dark:bg-gray-700/50">
                            <form id="submitPCMembersForm" action="pcMembersInvitation" method="POST">
                                @csrf
                                <input type="hidden" name="acronyme" value="{{ request('acronyme') }}">
                                <div id="pcMembersInputsContainer"></div>

                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        <span id="totalMembersText">0 PC members</span> ready to be invited
                                    </div>
                                    <button
                                        type="submit"
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                        Submit All Invitations <i class="fas fa-check ml-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom focus styles */
        input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Smooth transitions */
        input,
        button {
            transition: all 0.2s ease-in-out;
        }

        /* Hover effects */
        input:hover {
            border-color: #93c5fd;
        }

        /* Animation for adding members */
        .member-card {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addPCMemberBtn = document.getElementById('addPCMember');
            const pcMembersTable = document.getElementById('pcMembersTable');
            const pcMembersTableBody = document.getElementById('pcMembersTableBody');
            const pcMembersEmptyTable = document.getElementById('pcMembersEmptyTable');
            const pcMembersMobileContainer = document.getElementById('pcMembersMobileContainer');
            const pcMembersEmptyMobile = document.getElementById('pcMembersEmptyMobile');
            const submitSection = document.getElementById('submitSection');
            const pcMembersInputsContainer = document.getElementById('pcMembersInputsContainer');
            const addPCMemberForm = document.getElementById('addPCMemberForm');
            const pcMembersCount = document.getElementById('pcMembersCount');
            const totalMembersText = document.getElementById('totalMembersText');

            let addedPCMembers = [];

            addPCMemberBtn.addEventListener('click', function() {
                const firstNameInput = document.getElementById('firstName');
                const lastNameInput = document.getElementById('lastName');
                const emailInput = document.getElementById('email');

                const firstName = firstNameInput.value.trim();
                const lastName = lastNameInput.value.trim();
                const email = emailInput.value.trim();

                if (firstName && lastName && email) {
                    // Check for duplicates
                    const isDuplicate = addedPCMembers.some(member =>
                        member.email.toLowerCase() === email.toLowerCase()
                    );

                    if (isDuplicate) {
                        alert('A PC member with this email has already been added.');
                        return;
                    }

                    addedPCMembers.push({
                        firstName,
                        lastName,
                        email
                    });
                    updatePCMembersDisplay();
                    addPCMemberForm.reset();
                } else {
                    alert('Please fill in all the fields.');
                }
            });

            function updatePCMembersDisplay() {
                updatePCMembersTable();
                updatePCMembersMobile();
                updatePCMembersInputs();
                updateCounts();
            }

            function updatePCMembersTable() {
                pcMembersTableBody.innerHTML = '';

                if (addedPCMembers.length > 0) {
                    pcMembersTable.classList.remove('hidden');
                    pcMembersEmptyTable.style.display = 'none';

                    addedPCMembers.forEach((member, index) => {
                        const row = pcMembersTableBody.insertRow();
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${member.firstName}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${member.lastName}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">${member.email}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mr-3" onclick="editMember(${index})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" onclick="removeMember(${index})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                    });
                } else {
                    pcMembersTable.classList.add('hidden');
                    pcMembersEmptyTable.style.display = 'block';
                }
            }

            function updatePCMembersMobile() {
                pcMembersMobileContainer.innerHTML = '';

                if (addedPCMembers.length > 0) {
                    pcMembersEmptyMobile.style.display = 'none';

                    addedPCMembers.forEach((member, index) => {
                        const card = document.createElement('div');
                        card.className = 'p-4 hover:bg-gray-50 dark:hover:bg-gray-700 member-card';
                        card.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">${member.firstName} ${member.lastName}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">${member.email}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 mt-1">
                                        PC Member
                                    </span>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <button type="button" class="p-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" onclick="editMember(${index})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="p-2 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" onclick="removeMember(${index})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        pcMembersMobileContainer.appendChild(card);
                    });
                } else {
                    pcMembersEmptyMobile.style.display = 'block';
                }
            }

            function updatePCMembersInputs() {
                pcMembersInputsContainer.innerHTML = '';

                addedPCMembers.forEach((member, index) => {
                    pcMembersInputsContainer.innerHTML += `
                        <input type="hidden" name="contacts[${index}][firstName]" value="${member.firstName}">
                        <input type="hidden" name="contacts[${index}][lastName]" value="${member.lastName}">
                        <input type="hidden" name="contacts[${index}][email]" value="${member.email}">
                    `;
                });
            }

            function updateCounts() {
                const count = addedPCMembers.length;
                pcMembersCount.textContent = count;
                totalMembersText.textContent = `${count} PC member${count !== 1 ? 's' : ''}`;

                if (count > 0) {
                    submitSection.classList.remove('hidden');
                } else {
                    submitSection.classList.add('hidden');
                }
            }

            // Global functions for button clicks
            window.removeMember = function(index) {
                if (confirm('Are you sure you want to remove this PC member?')) {
                    addedPCMembers.splice(index, 1);
                    updatePCMembersDisplay();
                }
            };

            window.editMember = function(index) {
                const member = addedPCMembers[index];

                document.getElementById('firstName').value = member.firstName;
                document.getElementById('lastName').value = member.lastName;
                document.getElementById('email').value = member.email;

                // Remove the member from the list so they can re-add with changes
                addedPCMembers.splice(index, 1);
                updatePCMembersDisplay();
            };

            // Initialize display
            updatePCMembersDisplay();
        });
    </script>
</body>

</html>
@endsection