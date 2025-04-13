@extends('layouts.admin')

@section('title', 'Modification de l\'email')

@section('admin-content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md transition-all duration-300">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                Modification de l'email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                Veuillez entrer le code OTP reçu par email pour confirmer le changement
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST">
            @csrf

            <div class="rounded-md">
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Code OTP</label>
                    <input id="otp" name="otp" type="text" required 
                        class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white dark:bg-gray-700 focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm" 
                        placeholder="Entrez le code OTP">
                    @error('otp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                    Confirmer le changement
                </button>
            </div>
        </form>

        @if(session('message'))
            <div class="mt-6 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 rounded-md">
                {{ session('message') }}
            </div>
        @endif
    </div>
</div>
@endsection
