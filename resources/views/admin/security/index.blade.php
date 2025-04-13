@extends('layouts.admin')

@section('title', 'Sécurité')

@section('admin-content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 transition-all duration-300">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Options de sécurité</h2>
        
        <div class="space-y-6">
            @if(session('message'))
                <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 rounded-md mb-6">
                    {{ session('message') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 p-4 rounded-md mb-6">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($default)
                <div class="bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 p-4 rounded-md mb-6">
                    <p class="font-medium">Attention !</p>
                    <p>Vous utilisez actuellement les identifiants par défaut. Pour des raisons de sécurité, il est fortement recommandé de les modifier.</p>
                </div>
                
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Modifier les identifiants par défaut</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Cette action vous permettra de remplacer le mot de passe par défaut (0000) et de définir une adresse email pour votre compte.</p>
                    <a href="{{ route('admin.otp_request_default_erase') }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Modifier les identifiants par défaut
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Modifier le mot de passe</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Vous pouvez modifier votre mot de passe à tout moment pour renforcer la sécurité de votre compte.</p>
                        <a href="{{ route('admin.password_reset_init') }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Modifier le mot de passe
                        </a>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Modifier l'adresse email</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Vous pouvez mettre à jour l'adresse email associée à votre compte administrateur.</p>
                        <a href="{{ route('admin.email_reset_otp_request') }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Modifier l'adresse email
                        </a>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">
                                Adresse email actuelle : <strong>{{ $user->email ?? 'Non définie' }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Conseils de sécurité</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-600 dark:text-gray-300">
                    <li>Utilisez un mot de passe fort contenant au moins 8 caractères, incluant des lettres majuscules, minuscules, des chiffres et des caractères spéciaux.</li>
                    <li>Ne partagez jamais vos identifiants avec d'autres personnes.</li>
                    <li>Changez régulièrement votre mot de passe pour une sécurité optimale.</li>
                    <li>Assurez-vous que votre adresse email est sécurisée, car elle sera utilisée pour la récupération de compte.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
