<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 transition-all duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Formation</h2>
            <button type="button" wire:click="toggleForm" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                {{ $showForm ? 'Annuler' : 'Ajouter une formation' }}
            </button>
        </div>
        
        @if (session('status'))
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 rounded-md mb-6">
                {{ session('status') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 p-4 rounded-md mb-6">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Formulaire d'ajout/édition de formation -->
        @if($showForm)
            <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    {{ $isEditing ? 'Modifier la formation' : 'Ajouter une formation' }}
                </h3>
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="institution" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Établissement</label>
                            <input type="text" id="institution" wire:model="institution" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('institution') border-red-500 @enderror">
                            @error('institution')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="degree" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Diplôme</label>
                            <input type="text" id="degree" wire:model="degree" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('degree') border-red-500 @enderror">
                            @error('degree')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="field_of_study" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Domaine d'étude</label>
                        <input type="text" id="field_of_study" wire:model="field_of_study" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('field_of_study') border-red-500 @enderror">
                        @error('field_of_study')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de début</label>
                            <input type="date" id="start_date" wire:model="start_date" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('start_date') border-red-500 @enderror">
                            @error('start_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date de fin</label>
                            <input type="date" id="end_date" wire:model="end_date" @if($is_current) disabled @endif class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('end_date') border-red-500 @enderror">
                            @error('end_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lieu</label>
                        <input type="text" id="location" wire:model="location" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('location') border-red-500 @enderror">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea id="description" wire:model="description" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror"></textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_current" wire:model="is_current" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_current" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Formation en cours</label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" wire:click="toggleForm" class="py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                            Annuler
                        </button>
                        <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                            {{ $isEditing ? 'Mettre à jour' : 'Ajouter' }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
        
        <!-- Liste des formations -->
        <div class="space-y-6">
            @if($educations->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Aucune formation ajoutée pour le moment.</p>
            @else
                @foreach($educations as $edu)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $edu->degree }}</h3>
                                <p class="text-gray-600 dark:text-gray-400">{{ $edu->institution }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500">
                                    {{ \Carbon\Carbon::parse($edu->start_date)->format('M Y') }} - 
                                    @if($edu->is_current)
                                        Présent
                                    @else
                                        {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('M Y') : 'Non spécifié' }}
                                    @endif
                                    @if($edu->location)
                                        · {{ $edu->location }}
                                    @endif
                                </p>
                                @if($edu->field_of_study)
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $edu->field_of_study }}</p>
                                @endif
                                @if($edu->description)
                                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $edu->description }}</p>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" wire:click="edit({{ $edu->id }})" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" wire:click="delete({{ $edu->id }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette formation ?" class="p-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
