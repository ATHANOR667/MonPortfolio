@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen p-4">
    <div class="max-w-3xl w-full mx-auto text-center fade-in">
        <h1 class="text-4xl font-bold mb-6 slide-in">Portfolio Dynamique</h1>
        <p class="text-xl mb-8 slide-in">Bienvenue sur votre portfolio professionnel</p>
        
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('projects.index') }}" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                Voir les projets
            </a>
            <a href="{{ route('contact.show') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-lg transition-all duration-300 transform hover:scale-105">
                Me contacter
            </a>
        </div>
        
        <div class="mt-8">
            <button 
                x-data="{}" 
                @click="document.documentElement.classList.toggle('dark'); localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light'"
                class="flex items-center justify-center p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300"
                aria-label="Toggle dark mode"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection
