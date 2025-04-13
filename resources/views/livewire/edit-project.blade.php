<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à la liste des projets
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Modifier le projet</h2>

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-md">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="update" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
                    <input type="text" id="title" wire:model="title" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug (optionnel)</label>
                    <input type="text" id="slug" wire:model="slug" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('slug') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Laissez vide pour générer automatiquement à partir du titre</p>
                    @error('slug')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description courte</label>
                <textarea id="description" wire:model="description" rows="3" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contenu détaillé</label>
                <textarea id="content" wire:model="content" rows="6" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('content') border-red-500 @enderror"></textarea>
                @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="client" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client</label>
                    <input type="text" id="client" wire:model="client" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('client') border-red-500 @enderror">
                    @error('client')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date du projet</label>
                    <input type="date" id="date" wire:model="date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('date') border-red-500 @enderror">
                    @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL du projet</label>
                <input type="url" id="url" wire:model="url" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('url') border-red-500 @enderror">
                @error('url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL de la vidéo (YouTube, Vimeo, etc.)</label>
                <input type="url" id="video_url" wire:model="video_url" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('video_url') border-red-500 @enderror">
                @error('video_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégories</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($allCategories as $category)
                        <div class="flex items-center">
                            <input type="checkbox" id="category_{{ $category->id }}" wire:model="categories" value="{{ $category->id }}" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="category_{{ $category->id }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('categories')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image principale -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image principale actuelle</label>
                @if($project->featured_image)
                    <div class="mt-2 mb-4">
                        <img src="{{ Storage::url($project->featured_image) }}" alt="Image principale du projet" class="h-48 w-auto rounded-md">
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Aucune image principale</p>
                @endif

                <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4 mb-1">Remplacer l'image principale</label>
                <input type="file" id="featured_image" wire:model="featured_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('featured_image') border-red-500 @enderror">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Taille maximale : 2 Mo (JPEG, PNG, JPG, GIF)</p>
                @error('featured_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <button wire:click="updateFeaturedImage" class="mt-2 px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Mettre à jour l'image principale
                </button>
            </div>

            <!-- Images supplémentaires -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Images supplémentaires actuelles</label>
                @if($existing_images->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2 mb-4">
                        @foreach($existing_images as $image)
                            <div class="relative group">
                                <img src="{{ Storage::url($image->path) }}" alt="{{ $image->alt ?? 'Image du projet' }}" class="h-32 w-full object-cover rounded-md">
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <button wire:click="deleteImage({{ $image->id }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette image ?" class="p-2 bg-red-600 rounded-full text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Aucune image supplémentaire</p>
                @endif

                <label for="additional_images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4 mb-1">Ajouter des images supplémentaires</label>
                <input type="file" id="additional_images" wire:model="additional_images" accept="image/*" multiple class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('additional_images.*') border-red-500 @enderror">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Vous pouvez sélectionner plusieurs images (max 2 Mo par image)</p>
                @error('additional_images.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <button wire:click="addAdditionalImages" class="mt-2 px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Ajouter les images supplémentaires
                </button>
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="is_published" wire:model="is_published" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="is_published" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Projet publié</label>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                    Mettre à jour le projet
                </button>
            </div>
        </form>
    </div>
</div>