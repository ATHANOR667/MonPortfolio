@extends('layouts.admin')

@section('title', 'Statistiques')

@section('admin-content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Tableau de bord des statistiques</h2>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-primary-100 dark:bg-primary-900 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Visites totales</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalVisits }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Projets</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalProjects }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 dark:bg-green-900 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Commentaires</h3>
                    <div class="flex items-center">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalComments }}</p>
                        @if($pendingComments > 0)
                            <span class="ml-2 px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">{{ $pendingComments }} en attente</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Messages</h3>
                    <div class="flex items-center">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalMessages }}</p>
                        @if($unreadMessages > 0)
                            <span class="ml-2 px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">{{ $unreadMessages }} non lu(s)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Graphique des visites -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Visites des 30 derniers jours</h3>
            <div class="h-80">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>

        <!-- Top projets -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Projets les plus consultés</h3>
            @if($topProjects->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">Aucune donnée disponible</p>
            @else
                <ul class="space-y-4">
                    @foreach($topProjects as $project)
                        <li class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($project->featured_image)
                                    <div class="h-10 w-10 rounded overflow-hidden bg-gray-100 dark:bg-gray-700 mr-3">
                                        <img src="{{ Storage::url($project->featured_image) }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <div class="h-10 w-10 rounded overflow-hidden bg-gray-100 dark:bg-gray-700 flex items-center justify-center mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <a href="{{ route('admin.projects.edit', $project) }}" class="text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 truncate max-w-[150px]">{{ $project->title }}</a>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">{{ $project->views_count }} vues</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Visiteurs par pays -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Visiteurs par pays</h3>
            @if($visitorsByCountry->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">Aucune donnée disponible</p>
            @else
                <div class="space-y-4">
                    @foreach($visitorsByCountry as $visitor)
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                <div class="bg-primary-600 dark:bg-primary-500 h-4 rounded-full" style="width: {{ ($visitor->count / $visitorsByCountry->max('count')) * 100 }}%"></div>
                            </div>
                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300 min-w-[100px]">{{ $visitor->country }} ({{ $visitor->count }})</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Visiteurs récents -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Visiteurs récents</h3>
            @if($recentVisitors->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">Aucune donnée disponible</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">IP</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pays</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Page</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($recentVisitors as $visitor)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $visitor->ip_address }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $visitor->country ?? 'Inconnu' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $visitor->page_visited }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $visitor->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitsChart').getContext('2d');
        
        const dates = @json($dates);
        const counts = @json($counts);
        
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Nombre de visites',
                    data: counts,
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Update chart colors based on theme
        function updateChartColors() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            
            chart.options.scales.x.grid.color = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            chart.options.scales.y.grid.color = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            chart.options.scales.x.ticks.color = isDarkMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)';
            chart.options.scales.y.ticks.color = isDarkMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.7)';
            
            chart.update();
        }
        
        // Initial update
        updateChartColors();
        
        // Listen for theme changes
        window.addEventListener('themeChanged', updateChartColors);
    });
</script>
@endpush
@endsection
