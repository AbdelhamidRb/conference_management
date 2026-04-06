@extends('dashboardUser.chair.dashboardChair')

@section('content1')
<div class="min-h-screen bg-gray-50 p-2 sm:p-4 lg:p-6">
    <!-- Header Section -->
    <div class="mb-4 sm:mb-6 lg:mb-8">
        <div class="text-center lg:flex lg:items-center lg:justify-between lg:text-left">
            <div class="flex-1 min-w-0">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold leading-tight text-gray-900 break-words">Conference Statistics</h1>
                <p class="mt-1 text-xs sm:text-sm lg:text-base text-gray-600">Comprehensive overview of conference metrics and performance</p>
            </div>
            <div class="mt-3 lg:mt-0 lg:ml-4 flex-shrink-0">
                <div class="inline-flex items-center px-3 sm:px-4 py-2 border border-gray-300 rounded-md shadow-sm text-xs sm:text-sm font-medium text-gray-700 bg-white">
                    <i class="fas fa-id-badge mr-2 text-blue-500"></i>
                    <span class="break-words">Conference ID: {{ $conferenceId ?? 1 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile & Tablet View (up to 1024px) -->
    <div class="block lg:hidden space-y-4">
        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6">
            <!-- Total Submissions -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-lg p-2 sm:p-3">
                        <i class="fas fa-file-alt text-white text-base sm:text-lg"></i>
                    </div>
                    <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                        <div class="text-xs sm:text-sm font-medium text-gray-500">Total Submissions</div>
                        <div class="text-lg sm:text-2xl font-bold text-gray-900">{{ $totalArticles }}</div>
                        <div class="text-xs text-gray-400 mt-1 hidden sm:block">All submitted papers</div>
                    </div>
                </div>
            </div>

            <!-- Acceptance Rate -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-lg p-2 sm:p-3">
                        <i class="fas fa-check-circle text-white text-base sm:text-lg"></i>
                    </div>
                    <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                        <div class="text-xs sm:text-sm font-medium text-gray-500">Acceptance Rate</div>
                        <div class="text-lg sm:text-2xl font-bold text-green-600">{{ round($acceptanceRate->acceptance_rate, 1) }}%</div>
                        <div class="text-xs text-gray-400 mt-1 hidden sm:block">{{ $totalArticlesAccepted }} accepted</div>
                    </div>
                </div>
            </div>

            <!-- Average Reviews -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-lg p-2 sm:p-3">
                        <i class="fas fa-star text-white text-base sm:text-lg"></i>
                    </div>
                    <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                        <div class="text-xs sm:text-sm font-medium text-gray-500">Avg. Reviews</div>
                        <div class="text-lg sm:text-2xl font-bold text-yellow-600">{{ $moyenneReviews->moyenne_evaluations_par_article }}</div>
                        <div class="text-xs text-gray-400 mt-1 hidden sm:block">Reviews per paper</div>
                    </div>
                </div>
            </div>

            <!-- PC Members -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-lg p-2 sm:p-3">
                        <i class="fas fa-users text-white text-base sm:text-lg"></i>
                    </div>
                    <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                        <div class="text-xs sm:text-sm font-medium text-gray-500">PC Members</div>
                        <div class="text-lg sm:text-2xl font-bold text-purple-600">{{ $nombrePC }}</div>
                        <div class="text-xs text-gray-400 mt-1 hidden sm:block">Program committee</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Status Chart -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-3 sm:p-4">
                <h2 class="text-sm sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-blue-500"></i>
                    <span class="break-words">Submission Status</span>
                </h2>
                <div class="relative h-48 sm:h-64">
                    <canvas id="statusChartMobile"></canvas>
                </div>
            </div>

            <!-- Reviews Chart -->
            <div class="bg-white rounded-lg shadow border border-gray-200 p-3 sm:p-4">
                <h2 class="text-sm sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-green-500"></i>
                    <span class="break-words">Review Metrics</span>
                </h2>
                <div class="relative h-48 sm:h-64">
                    <canvas id="reviewsChartMobile"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Stats -->
        <div class="bg-white rounded-lg shadow border border-gray-200 p-3 sm:p-4">
            <h3 class="text-sm sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center">
                <i class="fas fa-list-ul mr-2 text-indigo-500"></i>
                <span class="break-words">Detailed Statistics</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Submission Stats -->
                <div>
                    <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-3 border-b border-gray-200 pb-2">Submission Statistics</h4>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex justify-between items-center p-2 bg-green-50 rounded border border-green-200">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 break-words">Accepted</span>
                            <span class="text-xs sm:text-sm font-bold text-green-600 flex-shrink-0 ml-2">{{ $totalArticlesAccepted }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-red-50 rounded border border-red-200">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 break-words">Rejected</span>
                            <span class="text-xs sm:text-sm font-bold text-red-600 flex-shrink-0 ml-2">{{ $totalArticlesRejected }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-purple-50 rounded border border-purple-200">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 break-words">Withdrawn</span>
                            <span class="text-xs sm:text-sm font-bold text-purple-600 flex-shrink-0 ml-2">{{ $totalArticlesWithdrawn }}</span>
                        </div>
                    </div>
                </div>

                <!-- Review Stats -->
                <div>
                    <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-3 border-b border-gray-200 pb-2">Review Statistics</h4>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex justify-between items-center p-2 bg-blue-50 rounded border border-blue-200">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 break-words">Total Reviews</span>
                            <span class="text-xs sm:text-sm font-bold text-blue-600 flex-shrink-0 ml-2">{{ $totalReviews->total_reviews }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-yellow-50 rounded border border-yellow-200">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 break-words">Avg. per Paper</span>
                            <span class="text-xs sm:text-sm font-bold text-yellow-600 flex-shrink-0 ml-2">{{ $moyenneReviews->moyenne_evaluations_par_article }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-indigo-50 rounded border border-indigo-200">
                            <span class="text-xs sm:text-sm font-medium text-gray-700 break-words">PC Members</span>
                            <span class="text-xs sm:text-sm font-bold text-indigo-600 flex-shrink-0 ml-2">{{ $nombrePC }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop View (1024px and larger) -->
    <div class="hidden lg:block">
        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Submissions -->
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Submissions</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $totalArticles }}</div>
                            </dd>
                            <div class="text-xs text-gray-400 mt-1">All submitted papers</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acceptance Rate -->
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-sm font-medium text-gray-500 truncate">Acceptance Rate</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-green-600">{{ round($acceptanceRate->acceptance_rate, 1) }}%</div>
                            </dd>
                            <div class="text-xs text-gray-400 mt-1">{{ $totalArticlesAccepted }} accepted papers</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Avg Reviews per Paper -->
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <i class="fas fa-star text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-sm font-medium text-gray-500 truncate">Avg. Reviews</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-yellow-600">{{ $moyenneReviews->moyenne_evaluations_par_article }}</div>
                            </dd>
                            <div class="text-xs text-gray-400 mt-1">Reviews per paper</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PC Members -->
            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-sm font-medium text-gray-500 truncate">PC Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-purple-600">{{ $nombrePC }}</div>
                            </dd>
                            <div class="text-xs text-gray-400 mt-1">Program committee</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Submission Status Pie Chart -->
            <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-blue-500"></i>
                    Submission Status Distribution
                </h2>
                <div class="relative h-64">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Reviews Metrics -->
            <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-green-500"></i>
                    Review Metrics Overview
                </h2>
                <div class="relative h-64">
                    <canvas id="reviewsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Metrics Section -->
        <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <i class="fas fa-analytics mr-2 text-indigo-500"></i>
                    Detailed Conference Statistics
                </h3>
                <p class="mt-1 text-sm text-gray-500">Comprehensive breakdown of all conference metrics and performance indicators</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-file-signature mr-2 text-blue-500"></i>
                            Submission Statistics
                        </h4>
                        <div class="space-y-4">
                            <div class="flex justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                                <span class="text-sm font-medium text-gray-700">Accepted Papers</span>
                                <span class="text-sm font-semibold text-green-600">{{ $totalArticlesAccepted }} ({{ round($acceptanceRate->acceptance_rate, 1) }}%)</span>
                            </div>
                            <div class="flex justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                                <span class="text-sm font-medium text-gray-700">Rejected Papers</span>
                                <span class="text-sm font-semibold text-red-600">{{ $totalArticlesRejected }} ({{ round($rejectionRate->rejection_rate, 1) }}%)</span>
                            </div>
                            <div class="flex justify-between p-3 bg-purple-50 rounded-lg border border-purple-200">
                                <span class="text-sm font-medium text-gray-700">Withdrawn Papers</span>
                                <span class="text-sm font-semibold text-purple-600">{{ $totalArticlesWithdrawn }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-star-half-alt mr-2 text-yellow-500"></i>
                            Review Statistics
                        </h4>
                        <div class="space-y-4">
                            <div class="flex justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <span class="text-sm font-medium text-gray-700">Total Reviews</span>
                                <span class="text-sm font-semibold text-blue-600">{{ $totalReviews->total_reviews }}</span>
                            </div>
                            <div class="flex justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <span class="text-sm font-medium text-gray-700">Avg. Reviews per Paper</span>
                                <span class="text-sm font-semibold text-yellow-600">{{ $moyenneReviews->moyenne_evaluations_par_article }}</span>
                            </div>
                            <div class="flex justify-between p-3 bg-indigo-50 rounded-lg border border-indigo-200">
                                <span class="text-sm font-medium text-gray-700">Program Committee Members</span>
                                <span class="text-sm font-semibold text-indigo-600">{{ $nombrePC }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart configuration
    const chartData = {
        statusData: [{{ $totalArticlesAccepted }}, {{ $totalArticlesRejected }}, {{ $totalArticlesWithdrawn }}],
        reviewsData: [{{ $totalReviews->total_reviews }}, {{ $moyenneReviews->moyenne_evaluations_par_article }}, {{ $nombrePC }}]
    };

    const chartColors = {
        status: {
            backgrounds: ['rgba(34, 197, 94, 0.7)', 'rgba(239, 68, 68, 0.7)', 'rgba(168, 85, 247, 0.7)'],
            borders: ['rgba(34, 197, 94, 1)', 'rgba(239, 68, 68, 1)', 'rgba(168, 85, 247, 1)']
        },
        reviews: {
            backgrounds: ['rgba(59, 130, 246, 0.7)', 'rgba(234, 179, 8, 0.7)', 'rgba(139, 92, 246, 0.7)'],
            borders: ['rgba(59, 130, 246, 1)', 'rgba(234, 179, 8, 1)', 'rgba(139, 92, 246, 1)']
        }
    };

    // Common chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    font: {
                        size: 12
                    }
                }
            }
        }
    };

    // Create charts for different screen sizes
    function createStatusChart(canvasId, position = 'bottom') {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;

        return new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Accepted', 'Rejected', 'Withdrawn'],
                datasets: [{
                    data: chartData.statusData,
                    backgroundColor: chartColors.status.backgrounds,
                    borderColor: chartColors.status.borders,
                    borderWidth: 2
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    legend: {
                        position: position,
                        labels: {
                            padding: 10,
                            usePointStyle: true,
                            font: {
                                size: window.innerWidth < 640 ? 10 : 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    function createReviewsChart(canvasId) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;

        return new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Total Reviews', 'Avg. Reviews', 'PC Members'],
                datasets: [{
                    label: 'Count',
                    data: chartData.reviewsData,
                    backgroundColor: chartColors.reviews.backgrounds,
                    borderColor: chartColors.reviews.borders,
                    borderWidth: 2
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            font: {
                                size: window.innerWidth < 640 ? 10 : 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: window.innerWidth < 640 ? 10 : 12
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Initialize charts when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Desktop charts
        createStatusChart('statusChart', 'right');
        createReviewsChart('reviewsChart');

        // Mobile/Tablet charts
        createStatusChart('statusChartMobile', 'bottom');
        createReviewsChart('reviewsChartMobile');
    });

    // Handle window resize for responsive charts
    window.addEventListener('resize', function() {
        // Destroy and recreate charts on significant size changes
        const charts = Chart.getChart('statusChart') || Chart.getChart('statusChartMobile');
        if (charts) {
            setTimeout(() => {
                location.reload();
            }, 100);
        }
    });
</script>

<style>
    /* Custom animations */
    .hover\:shadow-lg:hover {
        transition: box-shadow 0.3s ease-in-out;
    }

    /* Chart container improvements */
    canvas {
        max-height: 300px;
    }

    /* Responsive text adjustments */
    @media (max-width: 640px) {
        .text-2xl {
            font-size: 1.25rem;
        }
        
        .text-3xl {
            font-size: 1.5rem;
        }
    }

    /* Loading state for charts */
    .chart-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 200px;
        color: #6b7280;
    }

    /* Ensure proper text wrapping */
    .break-words {
        word-wrap: break-word;
        word-break: break-word;
    }
</style>

@endsection
