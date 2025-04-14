@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Bouton retour -->
            <a href="{{ route('projects.index') }}"
               class="inline-flex items-center mb-6 text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors text-sm sm:text-base"
               aria-label="Retour à la liste des projets">
                <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux projets
            </a>

            <!-- En-tête du projet -->
            <article class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md mb-8">
                @if($project->featured_image)
                    <img src="{{ Storage::url($project->featured_image) }}"
                         alt="{{ $project->title }}"
                         class="w-full h-48 sm:h-64 lg:h-80 object-cover"
                         loading="lazy"
                         decoding="async">
                @endif

                <div class="p-4 sm:p-6">
                    <header class="flex flex-wrap items-center mb-4">
                        @foreach($project->categories as $category)
                            <span class="px-2 py-1 text-xs sm:text-sm rounded-full bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 mr-2 mb-2">
                                {{ $category->name }}
                            </span>
                        @endforeach
                        <span class="ml-auto text-sm text-gray-500 dark:text-gray-400 flex items-center">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>{{ $project->views_count }} vues</span>
                        </span>
                    </header>

                    <h1 class="text-2xl sm:text-3xl font-bold mb-4">{{ $project->title }}</h1>

                    <div class="flex flex-wrap items-center text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-6 gap-2">
                        <time datetime="{{ $project->created_at->format('Y-m-d') }}">
                            Publié le {{ $project->created_at->format('d/m/Y') }}
                        </time>
                        @if($project->created_at != $project->updated_at)
                            <span class="hidden sm:inline">•</span>
                            <time datetime="{{ $project->updated_at->format('Y-m-d') }}">
                                Mis à jour le {{ $project->updated_at->format('d/m/Y') }}
                            </time>
                        @endif
                    </div>

                    <div class="text-gray-600 dark:text-gray-300 text-sm sm:text-base overflow-x-auto">
                        {!! nl2br(e($project->description)) !!}
                    </div>

                    @if($project->content)
                        <div class="text-gray-600 dark:text-gray-300 text-sm sm:text-base mt-6 overflow-x-auto">
                            {!! nl2br(e($project->content)) !!}
                        </div>
                    @endif

                    <dl class="mt-6 space-y-2 text-sm sm:text-base">
                        @if($project->client)
                            <div>
                                <dt class="inline font-semibold">Client :</dt>
                                <dd class="inline">{{ $project->client }}</dd>
                            </div>
                        @endif
                        @if($project->date)
                            <div>
                                <dt class="inline font-semibold">Date de mise en production :</dt>
                                <dd class="inline">
                                    <time datetime="{{ $project->date->format('Y-m-d') }}">
                                        {{ $project->date->format('d/m/Y') }}
                                    </time>
                                </dd>
                            </div>
                        @endif
                    </dl>

                    @if($project->url)
                        <div class="mt-6">
                            <a href="{{ $project->url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors text-sm sm:text-base">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Voir le projet en ligne
                            </a>
                        </div>
                    @endif
                </div>
            </article>

            <!-- Galerie d'images améliorée -->
            @if($project->images && $project->images->count() > 0)
                <section class="mb-8">
                    <h2 class="text-xl sm:text-2xl font-bold mb-4">Galerie</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($project->images as $index => $image)
                            <figure class="relative bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm transition-transform hover:scale-105">
                                <a href="{{ Storage::url($image->path) }}"
                                   class="block"
                                   data-lightbox="gallery"
                                   data-title="Image {{ $index + 1 }} du projet {{ $project->title }}">
                                    <img src="{{ Storage::url($image->path) }}"
                                         alt="Image {{ $index + 1 }} du projet {{ $project->title }}"
                                         class="w-full h-40 sm:h-48 object-cover transition-opacity hover:opacity-90"
                                         loading="lazy"
                                         decoding="async">
                                </a>
                            </figure>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Vidéo du projet -->
            @if($project->video_url)
                <section class="mb-8">
                    <h2 class="text-xl sm:text-2xl font-bold mb-4">Vidéo</h2>
                    <div class="relative aspect-[16/9] rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                        @php
                            $videoId = null;
                            $videoType = null;

                            // Gestion robuste des URLs YouTube
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $project->video_url, $matches)) {
                                $videoType = 'youtube';
                                $videoId = $matches[1];
                            }
                            // Gestion robuste des URLs Vimeo
                            elseif (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|)(\d+)(?:$|\/|\?)/i', $project->video_url, $matches)) {
                                $videoType = 'vimeo';
                                $videoId = $matches[1];
                            }
                        @endphp

                        @if($videoType === 'youtube' && $videoId)
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}?rel=0"
                                    title="Vidéo YouTube du projet {{ $project->title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    class="absolute inset-0 w-full h-full"></iframe>
                        @elseif($videoType === 'vimeo' && $videoId)
                            <iframe src="https://player.vimeo.com/video/{{ $videoId }}?title=0&byline=0&portrait=0"
                                    title="Vidéo Vimeo du projet {{ $project->title }}"
                                    frameborder="0"
                                    allow="autoplay; fullscreen; picture-in-picture"
                                    allowfullscreen
                                    class="absolute inset-0 w-full h-full"></iframe>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">
                                    Impossible d'afficher la vidéo.
                                    <a href="{{ $project->video_url }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                        Cliquez ici pour la voir
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <!-- Commentaires -->
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-8">
                <!-- Messages de statut -->
                @if (session('comment_status'))
                    <div class="bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 p-4 rounded-md mb-6 text-sm sm:text-base">
                        {{ session('comment_status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 p-4 rounded-md mb-6 text-sm sm:text-base">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Compteur de commentaires approuvés -->
                <h2 class="text-xl sm:text-2xl font-bold mb-6">
                    Commentaires ({{ $project->comments->where('is_approved', true)->count() }})
                </h2>

                <!-- Formulaire de commentaire -->
                <form action="{{ route('comments.store', $project) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium mb-1">Nom</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               required
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 @error('name') border-red-500 @enderror"
                               aria-describedby="name-error">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1" id="name-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium mb-1">Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               required
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 @error('email') border-red-500 @enderror"
                               aria-describedby="email-error">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1" id="email-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="website" class="block text-sm font-medium mb-1">Site web (optionnel)</label>
                        <input type="url"
                               name="website"
                               id="website"
                               value="{{ old('website') }}"
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 @error('website') border-red-500 @enderror"
                               aria-describedby="website-error">
                        @error('website')
                        <p class="text-red-500 text-xs mt-1" id="website-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium mb-1">Commentaire</label>
                        <textarea name="content"
                                  id="content"
                                  rows="4"
                                  required
                                  class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 @error('content') border-red-500 @enderror"
                                  aria-describedby="content-error">{{ old('content') }}</textarea>
                        @error('content')
                        <p class="text-red-500 text-xs mt-1" id="content-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <button type="submit"
                                class="px-4 py-2 sm:px-6 sm:py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors text-sm sm:text-base">
                            Publier le commentaire
                        </button>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                            Votre commentaire sera visible après modération.
                        </p>
                    </div>
                </form>

                <!-- Liste des commentaires approuvés -->
                <div class="space-y-6">
                    @php
                        $approvedComments = $project->comments->where('is_approved', true);
                    @endphp
                    @forelse($approvedComments as $comment)
                        <article class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
                            <header class="flex items-center mb-2">
                                <h3 class="font-semibold text-sm sm:text-base">{{ $comment->name }}</h3>
                                <time class="ml-auto text-xs sm:text-sm text-gray-500 dark:text-gray-400"
                                      datetime="{{ $comment->created_at->format('Y-m-d H:i') }}">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                </time>
                            </header>
                            <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">{{ $comment->content }}</p>
                            @if($comment->website)
                                <a href="{{ $comment->website }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="text-xs sm:text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 mt-2 inline-block">
                                    {{ parse_url($comment->website, PHP_URL_HOST) }}
                                </a>
                            @endif
                        </article>
                    @empty
                        <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                            Aucun commentaire pour le moment. Soyez le premier à commenter !
                        </p>
                    @endforelse
                </div>
            </section>

            <!-- Projets connexes -->
            @if($relatedProjects->count() > 0)
                <section>
                    <h2 class="text-xl sm:text-2xl font-bold mb-4">Projets similaires</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @foreach($relatedProjects as $relatedProject)
                            <article class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm transition-transform hover:scale-105">
                                <a href="{{ route('projects.show', $relatedProject) }}" class="block">
                                    @if($relatedProject->featured_image)
                                        <img src="{{ Storage::url($relatedProject->featured_image) }}"
                                             alt="{{ $relatedProject->title }}"
                                             class="w-full h-36 sm:h-40 object-cover"
                                             loading="lazy"
                                             decoding="async">
                                    @else
                                        <div class="w-full h-36 sm:h-40 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">Aucune image</span>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h3 class="text-base sm:text-lg font-semibold mb-2 line-clamp-2">{{ $relatedProject->title }}</h3>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-2">
                                            {{ Str::limit($relatedProject->description, 80) }}
                                        </p>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>

    @push('scripts')
        <style>
            .custom-lightbox {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                z-index: 9999;
                justify-content: center;
                align-items: center;
            }

            .custom-lightbox.active {
                display: flex;
            }

            .lightbox-content {
                position: relative;
                max-width: 90%;
                max-height: 90vh;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .lightbox-img {
                max-width: 100%;
                max-height: 80vh;
                object-fit: contain;
                border-radius: 8px;
            }

            .close-btn {
                position: absolute;
                top: -40px;
                right: -10px;
                color: white;
                background: rgba(0, 0, 0, 0.7);
                font-size: 28px;
                font-weight: bold;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                cursor: pointer;
                z-index: 10000;
                transition: all 0.2s;
                border: none;
            }

            .close-btn:hover {
                background: rgba(255, 255, 255, 0.9);
                color: black;
            }

            .lightbox-title {
                color: white;
                margin-top: 10px;
                text-align: center;
                max-width: 80%;
            }

            body.lightbox-open {
                overflow: hidden;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Création de la lightbox
                const lightbox = document.createElement('div');
                lightbox.className = 'custom-lightbox';
                lightbox.innerHTML = `
                <div class="lightbox-content">
                    <button class="close-btn" aria-label="Fermer la lightbox">&times;</button>
                    <img class="lightbox-img" src="" alt="">
                    <div class="lightbox-title"></div>
                </div>
            `;
                document.body.appendChild(lightbox);

                const lightboxImg = lightbox.querySelector('.lightbox-img');
                const lightboxTitle = lightbox.querySelector('.lightbox-title');
                const closeBtn = lightbox.querySelector('.close-btn');

                // Gestion des clics sur les images de la galerie
                document.querySelectorAll('[data-lightbox="gallery"]').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        lightboxImg.src = this.href;
                        lightboxTitle.textContent = this.dataset.title || '';

                        // Ouvrir la lightbox
                        lightbox.classList.add('active');
                        document.body.classList.add('lightbox-open');

                        // Focus sur le bouton de fermeture pour les utilisateurs clavier
                        closeBtn.focus();
                    });
                });

                // Fermer la lightbox
                function closeLightbox() {
                    lightbox.classList.remove('active');
                    document.body.classList.remove('lightbox-open');
                    lightboxImg.src = '';
                    lightboxTitle.textContent = '';
                }

                // Bouton de fermeture
                closeBtn.addEventListener('click', closeLightbox);

                // Fermer en cliquant à l'extérieur de l'image
                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox) {
                        closeLightbox();
                    }
                });

                // Fermer avec la touche Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                        closeLightbox();
                    }
                });

                // Empêcher la fermeture quand on clique sur l'image
                lightboxImg.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        </script>
    @endpush
@endsection