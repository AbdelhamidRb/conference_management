@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Invitation</title>
</head>

<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <h1 class="mt-3 text-2xl font-bold">Member Invitation</h1>
                <p class="mt-2 text-sm text-gray-600">Add members to this conference.</p>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
            <div class="rounded-md bg-green-200 border-green-200 p-4 mt-4 mb-6 text-center">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 text-center">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                @php session()->forget('success') @endphp
            </div>
            @elseif (session('error'))
            <div class="rounded-md bg-red-200 border-red-200 p-4 mt-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800 text-center">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
                @php session()->forget('error') @endphp
            </div>
            @endif

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Section -->
                <div class="lg:col-span-1">
                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200/50 sticky top-4">
                        <h2 class="text-lg font-semibold mb-4">Add New Member</h2>

                        <div class="mb-4">
                            <label for="memberType" class="block text-sm font-medium mb-2">
                                Invitation Type <span class="text-red-500">*</span>
                            </label>
                            <select id="memberType" name="memberType" class="mt-1 block w-full rounded-md py-2 pl-3 pr-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border border-gray-300">
                                <option value="coChair">Co-Chair Invitation</option>
                                <option value="pcMember">PC Member Invitation</option>
                            </select>
                        </div>

                        <form id="addMemberForm" class="space-y-4">
                            @csrf
                            <input type="hidden" id="acronyme" name="acronyme" value="{{request('acronyme')}}">
                            <div>
                                <label for="firstName" class="block text-sm font-medium">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="firstName" id="firstName" required class="mt-1 block w-full rounded-md py-3 pl-3 pr-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border border-gray-300">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="lastName" id="lastName" required class="mt-1 block w-full rounded-md py-3 pl-3 pr-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border border-gray-300">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md py-3 pl-3 pr-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border border-gray-300">
                            </div>
                            <button type="button" id="addMember" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-2"></i> Add Member
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Tables Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Co-Chairs Section -->
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200/50">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium flex items-center">
                                <i class="fas fa-user-tie mr-2 text-blue-600"></i>
                                Co-Chairs to Invite
                                <span id="coChairsCount" class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">0</span>
                            </h3>
                        </div>

                        <!-- Mobile View for Co-Chairs -->
                        <div class="block lg:hidden" id="coChairsMobile">
                            <div id="coChairsMobileContainer" class="divide-y divide-gray-200">
                                <!-- Mobile cards will be inserted here -->
                            </div>
                            <div id="coChairsEmptyMobile" class="p-6 text-center text-gray-500">
                                <i class="fas fa-user-plus text-3xl text-gray-300 mb-2"></i>
                                <p>No co-chairs added yet</p>
                            </div>
                        </div>

                        <!-- Desktop View for Co-Chairs -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table id="coChairsTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="coChairsTableBody" class="bg-white divide-y divide-gray-200">
                                    <!-- Table rows will be inserted here -->
                                </tbody>
                            </table>
                            <div id="coChairsEmptyTable" class="p-6 text-center text-gray-500">
                                <i class="fas fa-user-plus text-3xl text-gray-300 mb-2"></i>
                                <p>No co-chairs added yet</p>
                            </div>
                        </div>
                    </div>

                    <!-- PC Members Section -->
                    <div class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200/50">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium flex items-center">
                                <i class="fas fa-users mr-2 text-green-600"></i>
                                PC Members to Invite
                                <span id="pcMembersCount" class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">0</span>
                            </h3>
                        </div>

                        <!-- Mobile View for PC Members -->
                        <div class="block lg:hidden" id="pcMembersMobile">
                            <div id="pcMembersMobileContainer" class="divide-y divide-gray-200">
                                <!-- Mobile cards will be inserted here -->
                            </div>
                            <div id="pcMembersEmptyMobile" class="p-6 text-center text-gray-500">
                                <i class="fas fa-user-plus text-3xl text-gray-300 mb-2"></i>
                                <p>No PC members added yet</p>
                            </div>
                        </div>

                        <!-- Desktop View for PC Members -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table id="pcMembersTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="pcMembersTableBody" class="bg-white divide-y divide-gray-200">
                                    <!-- Table rows will be inserted here -->
                                </tbody>
                            </table>
                            <div id="pcMembersEmptyTable" class="p-6 text-center text-gray-500">
                                <i class="fas fa-user-plus text-3xl text-gray-300 mb-2"></i>
                                <p>No PC members added yet</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200/50">
                        <form id="submitMembersForm" action="{{ route('coChairsPcMembersInvitation') }}" method="POST">
                            @csrf
                            <input type="hidden" name="acronyme" value="{{request('acronyme')}}">
                            <div id="coChairsInputsContainer"></div>
                            <div id="pcMembersInputsContainer"></div>

                            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <span id="totalMembersCount">0 members</span> ready to be invited
                                </div>
                                <button type="submit" id="submitBtn" disabled class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:bg-gray-300 disabled:cursor-not-allowed">
                                    Submit All Invitations <i class="fas fa-check ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const memberTypeSelect = document.getElementById('memberType');
            const addMemberBtn = document.getElementById('addMember');
            const addMemberForm = document.getElementById('addMemberForm');
            const submitMembersForm = document.getElementById('submitMembersForm');
            const submitBtn = document.getElementById('submitBtn');

            const firstNameInput = document.getElementById('firstName');
            const lastNameInput = document.getElementById('lastName');
            const emailInput = document.getElementById('email');

            let coChairMembers = [];
            let pcMembers = [];

            // Initialize
            updateCoChairsDisplay();
            updatePcMembersDisplay();
            updateCounts();

            addMemberBtn.addEventListener('click', function() {
                const firstName = firstNameInput.value.trim();
                const lastName = lastNameInput.value.trim();
                const email = emailInput.value.trim();

                if (firstName && lastName && email) {
                    const member = {
                        firstName,
                        lastName,
                        email
                    };
                    const memberType = memberTypeSelect.value;

                    if (memberType === 'coChair') {
                        coChairMembers.push(member);
                        updateCoChairsDisplay();
                    } else {
                        pcMembers.push(member);
                        updatePcMembersDisplay();
                    }

                    addMemberForm.reset();
                    updateCounts();
                } else {
                    alert('Please fill in all the fields.');
                }
            });

            function updateCoChairsDisplay() {
                updateCoChairsTable();
                updateCoChairsMobile();
                updateCoChairsInputs();
            }

            function updatePcMembersDisplay() {
                updatePcMembersTable();
                updatePcMembersMobile();
                updatePcMembersInputs();
            }

            function updateCoChairsTable() {
                const tableBody = document.getElementById('coChairsTableBody');
                const emptyState = document.getElementById('coChairsEmptyTable');

                tableBody.innerHTML = '';

                if (coChairMembers.length === 0) {
                    emptyState.style.display = 'block';
                } else {
                    emptyState.style.display = 'none';
                    coChairMembers.forEach((member, index) => {
                        const row = tableBody.insertRow();
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${member.firstName}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${member.lastName}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">${member.email}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" class="text-blue-600 hover:text-blue-800 mr-3" onclick="updateMember(${index}, 'coChair')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="removeMember(${index}, 'coChair')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                    });
                }
            }

            function updateCoChairsMobile() {
                const container = document.getElementById('coChairsMobileContainer');
                const emptyState = document.getElementById('coChairsEmptyMobile');

                container.innerHTML = '';

                if (coChairMembers.length === 0) {
                    emptyState.style.display = 'block';
                } else {
                    emptyState.style.display = 'none';
                    coChairMembers.forEach((member, index) => {
                        const card = document.createElement('div');
                        card.className = 'p-4 hover:bg-gray-50';
                        card.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">${member.firstName} ${member.lastName}</h4>
                                    <p class="text-sm text-gray-600">${member.email}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                        Co-Chair
                                    </span>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <button type="button" class="p-2 text-blue-600 hover:text-blue-800" onclick="updateMember(${index}, 'coChair')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="p-2 text-red-600 hover:text-red-800" onclick="removeMember(${index}, 'coChair')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        container.appendChild(card);
                    });
                }
            }

            function updatePcMembersTable() {
                const tableBody = document.getElementById('pcMembersTableBody');
                const emptyState = document.getElementById('pcMembersEmptyTable');

                tableBody.innerHTML = '';

                if (pcMembers.length === 0) {
                    emptyState.style.display = 'block';
                } else {
                    emptyState.style.display = 'none';
                    pcMembers.forEach((member, index) => {
                        const row = tableBody.insertRow();
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${member.firstName}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${member.lastName}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">${member.email}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button type="button" class="text-blue-600 hover:text-blue-800 mr-3" onclick="updateMember(${index}, 'pcMember')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="removeMember(${index}, 'pcMember')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                    });
                }
            }

            function updatePcMembersMobile() {
                const container = document.getElementById('pcMembersMobileContainer');
                const emptyState = document.getElementById('pcMembersEmptyMobile');

                container.innerHTML = '';

                if (pcMembers.length === 0) {
                    emptyState.style.display = 'block';
                } else {
                    emptyState.style.display = 'none';
                    pcMembers.forEach((member, index) => {
                        const card = document.createElement('div');
                        card.className = 'p-4 hover:bg-gray-50';
                        card.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">${member.firstName} ${member.lastName}</h4>
                                    <p class="text-sm text-gray-600">${member.email}</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                        PC Member
                                    </span>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <button type="button" class="p-2 text-blue-600 hover:text-blue-800" onclick="updateMember(${index}, 'pcMember')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="p-2 text-red-600 hover:text-red-800" onclick="removeMember(${index}, 'pcMember')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        container.appendChild(card);
                    });
                }
            }

            function updateCoChairsInputs() {
                const container = document.getElementById('coChairsInputsContainer');
                container.innerHTML = '';
                coChairMembers.forEach((member, index) => {
                    container.innerHTML += `
                        <input type="hidden" name="contacts1[${index}][firstName]" value="${member.firstName}">
                        <input type="hidden" name="contacts1[${index}][lastName]" value="${member.lastName}">
                        <input type="hidden" name="contacts1[${index}][email]" value="${member.email}">
                    `;
                });
            }

            function updatePcMembersInputs() {
                const container = document.getElementById('pcMembersInputsContainer');
                container.innerHTML = '';
                pcMembers.forEach((member, index) => {
                    container.innerHTML += `
                        <input type="hidden" name="contacts2[${index}][firstName]" value="${member.firstName}">
                        <input type="hidden" name="contacts2[${index}][lastName]" value="${member.lastName}">
                        <input type="hidden" name="contacts2[${index}][email]" value="${member.email}">
                    `;
                });
            }

            function updateCounts() {
                const coChairsCount = document.getElementById('coChairsCount');
                const pcMembersCount = document.getElementById('pcMembersCount');
                const totalMembersCount = document.getElementById('totalMembersCount');

                coChairsCount.textContent = coChairMembers.length;
                pcMembersCount.textContent = pcMembers.length;

                const total = coChairMembers.length + pcMembers.length;
                totalMembersCount.textContent = `${total} member${total !== 1 ? 's' : ''}`;

                submitBtn.disabled = total === 0;
            }

            // Global functions for button clicks
            window.removeMember = function(index, type) {
                if (type === 'coChair') {
                    coChairMembers.splice(index, 1);
                    updateCoChairsDisplay();
                } else {
                    pcMembers.splice(index, 1);
                    updatePcMembersDisplay();
                }
                updateCounts();
            };

            window.updateMember = function(index, type) {
                let member;
                if (type === 'coChair') {
                    member = coChairMembers[index];
                    coChairMembers.splice(index, 1);
                    updateCoChairsDisplay();
                } else {
                    member = pcMembers[index];
                    pcMembers.splice(index, 1);
                    updatePcMembersDisplay();
                }

                firstNameInput.value = member.firstName;
                lastNameInput.value = member.lastName;
                emailInput.value = member.email;
                memberTypeSelect.value = type;
                updateCounts();
            };
        });
    </script>
</body>

</html>
@endsection