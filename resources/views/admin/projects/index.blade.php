@extends('layouts.admin')

@section('title', 'Gestion des projets')

@section('admin-content')
    <div class="w-full max-w-screen-lg mx-auto px-3 sm:px-4 lg:px-6">
        @if (session('status'))
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-3 rounded-md mb-3">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-center mb-3 sm:mb-4 gap-2">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Projets</h2>
            <a href="{{ route('admin.projects.create') }}" class="py-1.5 px-3 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                Ajouter un projet
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md transition-all duration-300">
            @if($projects->isEmpty())
                <div class="p-4 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Aucun projet n'a été ajouté pour le moment.</p>
                    <a href="{{ route('admin.projects.create') }}" class="mt-2 inline-flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer votre premier projet
                    </a>
                </div>
            @else
                <div class="divide-y divide-gray-200 dark:divide-gray-700 sm:overflow-x-auto">
                    <!-- Mobile: Cartes -->
                    <div class="sm:hidden space-y-3 p-3">
                        @foreach($projects as $project)
                            <div class="bg-primary-50 dark:bg-gray-700 rounded-md shadow-sm p-3 hover:scale-[1.02] transition-transform duration-200">
                                <div class="flex items-start gap-3">
                                    <div class="h-16 w-16 rounded overflow-hidden bg-gray-100 dark:bg-gray-600 flex-shrink-0">
                                        @if($project->featured_image)
                                            <img src="{{ Storage::url($project->featured_image) }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-base font-medium text-gray-900 dark:text-white truncate">{{ $project->title }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ Str::limit($project->description, 20) }}</div>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @forelse($project->categories->take(1) as $category)
                                                <span class="px-1.5 py-0.5 text-xs rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                                    {{ $category->name }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Aucune catégorie</span>
                                            @endforelse
                                            @if($project->categories->count() > 1)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">+{{ $project->categories->count() - 1 }}</span>
                                            @endif
                                        </div>
                                        <div class="mt-1">
                                            <form action="{{ route('admin.projects.toggle-published', $project) }}" method="POST" class="toggle-form inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="flex items-center">
                                                    @if($project->is_published)
                                                        <span class="px-1.5 py-0.5 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Publié</span>
                                                    @else
                                                        <span class="px-1.5 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Masqué</span>
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 mt-2">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop: Table -->
                    <table class="hidden sm:table w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Titre</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Catégories</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vues</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($projects as $project)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="h-12 w-12 rounded overflow-hidden bg-gray-100 dark:bg-gray-600">
                                        @if($project->featured_image)
                                            <img src="{{ Storage::url($project->featured_image) }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($project->description, 40) }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1 max-w-[200px]">
                                        @forelse($project->categories->take(3) as $category)
                                            <span class="px-1.5 py-0.5 text-xs rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                                    {{ $category->name }}
                                                </span>
                                        @empty
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Aucune catégorie</span>
                                        @endforelse
                                        @if($project->categories->count() > 3)
                                            <span class="text-xs text-gray-500 dark:text-gray-400">+{{ $project->categories->count() - 3 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.projects.toggle-published', $project) }}" method="POST" class="toggle-form">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="flex items-center">
                                            @if($project->is_published)
                                                <span class="px-1.5 py-0.5 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Publié</span>
                                            @else
                                                <span class="px-1.5 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Masqué</span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $project->views_count }}
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $project->date ? $project->date->format('d/m/Y') : 'Non définie' }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-3 sm:px-4 py-3 flex justify-center">
                    {{ $projects->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection