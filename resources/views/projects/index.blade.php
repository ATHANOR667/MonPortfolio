@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-8 text-center">Mes Projets</h1>

        <!-- Filtres de catégories -->
        <nav class="mb-8 flex flex-wrap justify-center gap-2" aria-label="Filtre par catégorie">
            <!-- Bouton "Tous" -->
            <a href="{{ route('projects.index') }}"
               class="category-filter px-4 py-2 rounded-full transition-colors text-sm sm:text-base
                  {{ !$category || !$category->id ? 'bg-primary-600 text-white hover:bg-primary-700' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600' }}"
               data-category="all" aria-current="{{ !$category || !$category->id ? 'true' : 'false' }}">
                Tous
            </a>

            <!-- Boucle sur les catégories -->
            @foreach($categories as $categoryItem)
                <a href="{{ route('projects.index', $categoryItem) }}"
                   class="category-filter px-4 py-2 rounded-full transition-colors text-sm sm:text-base
                      {{ $category && $category->id === $categoryItem->id ? 'bg-primary-600 text-white hover:bg-primary-700' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600' }}"
                   data-category="{{ $categoryItem->id }}"
                   aria-current="{{ $category && $category->id === $categoryItem->id ? 'true' : 'false' }}">
                    {{ $categoryItem->name }}
                </a>
            @endforeach
        </nav>

        <!-- Grille de projets adaptative -->
        @php
            $projectCount = $projects->count();
            $gridClass = 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3';
            $imageHeightClass = 'h-48 sm:h-56 lg:h-64';
            $cardPaddingClass = 'p-4 sm:p-5';

            if ($projectCount === 1) {
                $gridClass = 'grid-cols-1 max-w-lg mx-auto';
            } elseif ($projectCount === 2) {
                $gridClass = 'grid-cols-1 sm:grid-cols-2';
                $imageHeightClass = 'h-56 sm:h-64';
            } elseif ($projectCount <= 4) {
                $gridClass = 'grid-cols-1 sm:grid-cols-2';
                $imageHeightClass = 'h-52 sm:h-60';
            }
        @endphp

        <div class="grid {{ $gridClass }} gap-4 sm:gap-6" role="list">
            @forelse($projects as $project)
                <article class="project-card bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md transition-transform hover:scale-105 flex flex-col"
                         data-categories="{{ $project->categories->pluck('id')->join(',') }}"
                         role="listitem">
                    <a href="{{ route('projects.show', ['project' => $project]) }}" class="flex flex-col flex-grow">
                        @if($project->featured_image)
                            <img src="{{ Storage::url($project->featured_image) }}"
                                 alt="{{ $project->title }}"
                                 class="w-full {{ $imageHeightClass }} object-cover"
                                 loading="lazy"
                                 decoding="async">
                        @else
                            <div class="w-full {{ $imageHeightClass }} bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Aucune image</span>
                            </div>
                        @endif
                        <div class="{{ $cardPaddingClass }} flex flex-col flex-grow">
                            <h3 class="text-base sm:text-lg font-semibold mb-2 line-clamp-2">{{ $project->title }}</h3>
                            <div class="flex flex-wrap items-center mb-3 gap-2">
                                @foreach($project->categories as $category)
                                    <span class="px-2 py-1 text-xs rounded-full bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200">
                                    {{ $category->name }}
                                </span>
                                @endforeach
                                <span class="ml-auto text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ $project->views_count ?? 0 }}</span>
                            </span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 text-sm flex-grow line-clamp-3">
                                {{ Str::limit($project->description, $projectCount <= 3 ? 200 : 120) }}
                            </p>

                            @if($projectCount <= 3)
                                <footer class="mt-4 flex justify-between items-center">
                                    <time class="text-sm text-gray-500 dark:text-gray-400" datetime="{{ $project->date ? $project->date->format('Y-m-d') : '' }}">
                                        {{ $project->date ? $project->date->format('d/m/Y') : '' }}
                                    </time>
                                    <span class="inline-flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 text-sm">
                                    Voir le projet
                                    <svg class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                                </footer>
                            @endif
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="h-12 sm:h-14 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-base sm:text-lg">Aucun projet à afficher pour le moment.</p>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Revenez bientôt pour découvrir mes nouveaux projets.</p>
                </div>
            @endforelse
        </div>

        @if($projectCount > 0 && $projectCount < 3)
            <section class="mt-12 text-center bg-primary-50 dark:bg-primary-900/20 p-6 rounded-lg">
                <h3 class="text-lg sm:text-xl font-semibold text-primary-700 dark:text-primary-300 mb-2">Explorez mes projets en détail</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base max-w-xl mx-auto">
                    Cliquez sur un projet pour découvrir plus d'informations, des images supplémentaires et laisser vos commentaires.
                </p>
            </section>
        @endif

        @if($projects->hasPages())
            <nav class="mt-8 flex justify-center" aria-label="Pagination">
                {{ $projects->links() }}
            </nav>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterLinks = document.querySelectorAll('.category-filter');
            const projectCards = document.querySelectorAll('.project-card');
            const grid = document.querySelector('.grid');

            filterLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault(); // Empêche le rechargement si JavaScript est utilisé
                    const category = link.getAttribute('data-category');

                    // Mise à jour des styles des filtres
                    filterLinks.forEach(l => {
                        l.classList.remove('bg-primary-600', 'text-white');
                        l.classList.add('bg-gray-200', 'dark:bg-gray-700');
                        l.setAttribute('aria-current', 'false');
                    });
                    link.classList.add('bg-primary-600', 'text-white');
                    link.classList.remove('bg-gray-200', 'dark:bg-gray-700');
                    link.setAttribute('aria-current', 'true');

                    // Filtrage des projets
                    let visibleProjects = 0;
                    projectCards.forEach(card => {
                        const categories = card.getAttribute('data-categories').split(',');
                        if (category === 'all' || categories.includes(category)) {
                            card.classList.remove('hidden');
                            card.classList.add('flex');
                            visibleProjects++;
                        } else {
                            card.classList.add('hidden');
                            card.classList.remove('flex');
                        }
                    });

                    // Gestion de l'état vide
                    const emptyState = grid.querySelector('.empty-state');
                    if (visibleProjects === 0 && !emptyState) {
                        const emptyStateDiv = document.createElement('div');
                        emptyStateDiv.className = 'col-span-full text-center py-12 empty-state';
                        emptyStateDiv.innerHTML = `
                        <p class="text-gray-500 dark:text-gray-400 text-base sm:text-lg">Aucun projet dans cette catégorie.</p>
                    `;
                        grid.appendChild(emptyStateDiv);
                    } else if (visibleProjects > 0 && emptyState) {
                        emptyState.remove();
                    }
                });
            });
        });
    </script>
@endsection