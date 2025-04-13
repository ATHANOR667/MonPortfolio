@extends('layouts.admin')

@section('title', 'Connexion')

@section('admin-content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md transition-all duration-300">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                Connexion Administrateur
            </h2>
        </div>
        
        <form class="mt-8 space-y-6" method="POST">
            @csrf

            <div class="rounded-md -space-y-px">
                <div>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input id="password" name="password" type="password" required 
                        class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white dark:bg-gray-700 focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm" 
                        placeholder="Mot de passe">
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                    Se connecter
                </button>
            </div>
        </form>

        @if(!$default)
            <div class="mt-6 text-center">
                <a href="{{ route('admin.password_reset_init_while_dissconnected') }}" 
                    class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 transition-colors duration-300">
                    Mot de passe oublié ?
                </a>
            </div>
        @endif

        @if(session('message'))
            <div class="mt-6 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 rounded-md">
                {{ session('message') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mt-6 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 p-4 rounded-md">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
@endsection
