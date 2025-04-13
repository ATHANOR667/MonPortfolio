@extends('layouts.admin')

@section('title', 'Gestion du profil')

@section('admin-content')
    <div class="max-w-7xl mx-auto">
        <!-- Messages de statut -->
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

        @if($profile)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 transition-all duration-300">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Informations personnelles</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Photo de profil -->
                    <div class="md:col-span-1">
                        <div class="flex flex-col items-center">
                            <div class="w-48 h-48 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700 mb-4">
                                @if($profile->photo)
                                    <img src="{{ Storage::url($profile->photo) }}" alt="{{ $profile->full_name ?? 'Photo de profil' }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('admin.profile.photo') }}" method="POST" enctype="multipart/form-data" class="w-full">
                                @csrf
                                <div class="mb-4">
                                    <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Photo de profil</label>
                                    <input type="file" id="photo" name="photo" accept="image/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('photo') border-red-500 @enderror">
                                    @error('photo')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                                    Mettre à jour la photo
                                </button>
                            </form>

                            <div class="w-full mt-6">
                                <form action="{{ route('admin.profile.cv') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="cv" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CV (PDF, DOC, DOCX)</label>
                                        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('cv') border-red-500 @enderror">
                                        @error('cv')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                                        Mettre à jour le CV
                                    </button>
                                </form>

                                @if($profile->cv_path)
                                    <div class="mt-4 text-center">
                                        <a href="{{ Storage::url($profile->cv_path) }}" target="_blank" class="inline-flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Voir le CV actuel
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informations de profil -->
                    <div class="md:col-span-2">
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom complet</label>
                                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('full_name') border-red-500 @enderror">
                                    @error('full_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre / Profession</label>
                                    <input type="text" id="title" name="title" value="{{ old('title', $profile->title ?? '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror">
                                    @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Biographie</label>
                                <textarea id="bio" name="bio" rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('bio') border-red-500 @enderror">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                @error('bio')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email public</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $profile->email ?? '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('email') border-red-500 @enderror">
                                    @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('phone') border-red-500 @enderror">
                                    @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Localisation</label>
                                <input type="text" id="location" name="location" value="{{ old('location', $profile->location ?? '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('location') border-red-500 @enderror">
                                @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site web</label>
                                    <input type="url" id="website" name="website" value="{{ old('website', $profile->website ?? '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('website') border-red-500 @enderror">
                                    @error('website')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">LinkedIn</label>
                                    <input type="url" id="linkedin" name="linkedin" value="{{ old('linkedin', $profile->linkedin ?? '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('linkedin') border-red-500 @enderror">
                                    @error('linkedin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label for="github" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">GitHub</label>
                                    <input type="url" id="github" name="github" value="{{ old('github', $profile->github ?? '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('github') border-red-500 @enderror">
                                    @error('github')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Twitter</label>
                                    <input type="url" id="twitter" name="twitter" value="{{ old('twitter', $profile->twitter ?? '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('twitter') border-red-500 @enderror">
                                    @error('twitter')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 p-4 rounded-md mb-6">
                Aucun profil trouvé. Veuillez créer un profil pour continuer.
            </div>
        @endif

        <!-- Formation avec Livewire -->
        @livewire('profile-education', ['profile' => $profile])

        <!-- Expérience professionnelle avec Livewire -->
        @livewire('profile-experience', ['profile' => $profile])
    </div>
@endsection