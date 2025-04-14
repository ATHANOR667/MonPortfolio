<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Portfolio')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js via CDN -->
    <script defer src="https://cdn.alpinejs.dev/dist/cdn.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>

    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive-fixes.css')); ?>">
    <style>
        [x-cloak] { display: none !important; }

        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .slide-in {
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Dark mode styles */
        .dark {
            color-scheme: dark;
        }

        /* Prevent FOUC (Flash of Unstyled Content) */
        .no-js {
            visibility: hidden;
            opacity: 0;
        }

        .js-loaded {
            visibility: visible;
            opacity: 1;
            transition: opacity 0.3s ease-in;
        }
    </style>

    <!-- Dark/Light Mode Script -->
    <script>
        // Initialize theme based on localStorage or system preference
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        },
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="font-sans antialiased h-full bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300 no-js">
<script>
    // Add js-loaded class once DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.remove('no-js');
        document.body.classList.add('js-loaded');
    });

    // Fallback to ensure content is displayed even if DOMContentLoaded doesn't fire
    setTimeout(function() {
        if (document.body.classList.contains('no-js')) {
            document.body.classList.remove('no-js');
            document.body.classList.add('js-loaded');
        }
    }, 1500);
</script>
<div class="min-h-screen flex flex-col">
    <!-- Navigation principale - uniquement pour les pages publiques, pas pour l'admin -->
    <?php if(!request()->is('admin*')): ?>
        <header class="bg-white dark:bg-gray-800 shadow-sm fixed-nav">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="<?php echo e(route('profile.show')); ?>" class="text-xl font-bold text-primary-600 dark:text-primary-400">
                                <?php echo e(config('app.name', 'Portfolio')); ?>

                            </a>
                        </div>
                        <nav class="hidden sm:ml-6 sm:flex sm:space-x-8" aria-label="Navigation principale">
                            <a href="<?php echo e(route('projects.index')); ?>" class="<?php echo e(request()->routeIs('projects.*') ? 'border-primary-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-300">
                                Projets
                            </a>
                            <a href="<?php echo e(route('profile.show')); ?>" class="<?php echo e(request()->routeIs('profile.show') ? 'border-primary-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-300">
                                Mon Parcours
                            </a>
                            <a href="<?php echo e(route('contact.show')); ?>" class="<?php echo e(request()->routeIs('contact.*') ? 'border-primary-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-300">
                                Contact
                            </a>
                        </nav>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <!-- Bouton mode sombre/clair -->
                        <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors duration-300">
                            <svg id="theme-toggle-dark-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <!-- Bouton menu mobile -->
                        <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-3 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-colors duration-300 interactive-element" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Ouvrir le menu principal</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu mobile -->
            <div class="hidden mobile-menu sm:hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="<?php echo e(route('projects.index')); ?>" class="<?php echo e(request()->routeIs('projects.*') ? 'bg-primary-50 dark:bg-primary-900 border-primary-500 text-primary-700 dark:text-primary-300 active-nav-item' : 'border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-700 hover:text-gray-800 dark:hover:text-gray-200'); ?> block pl-3 pr-4 py-3 border-l-4 text-base font-medium transition-colors duration-300 interactive-element">
                        Projets
                    </a>
                    <a href="<?php echo e(route('profile.show')); ?>" class="<?php echo e(request()->routeIs('profile.show') ? 'bg-primary-50 dark:bg-primary-900 border-primary-500 text-primary-700 dark:text-primary-300 active-nav-item' : 'border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-700 hover:text-gray-800 dark:hover:text-gray-200'); ?> block pl-3 pr-4 py-3 border-l-4 text-base font-medium transition-colors duration-300 interactive-element">
                        Mon Parcours
                    </a>
                    <a href="<?php echo e(route('contact.show')); ?>" class="<?php echo e(request()->routeIs('contact.*') ? 'bg-primary-50 dark:bg-primary-900 border-primary-500 text-primary-700 dark:text-primary-300 active-nav-item' : 'border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-700 hover:text-gray-800 dark:hover:text-gray-200'); ?> block pl-3 pr-4 py-3 border-l-4 text-base font-medium transition-colors duration-300 interactive-element">
                        Contact
                    </a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center px-4">
                        <!-- Bouton mode sombre/clair mobile -->
                        <button id="theme-toggle-mobile" type="button" class="ml-auto text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors duration-300">
                            <svg id="theme-toggle-dark-icon-mobile" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg id="theme-toggle-light-icon-mobile" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <!-- Contenu principal -->
    <main class="flex-1 pt-16">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php if(!request()->is('admin*')): ?>
        <footer class="bg-white dark:bg-gray-800 shadow-inner">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- À propos -->
                    <div class="col-span-1 md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">À propos</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            Backend developer spécialisé en PHP/Laravel. Je crée des APIs web performantes, scalables et maintenables. Mon portfolio présente mes projets, compétences et parcours académique.
                        </p>
                        <div class="flex space-x-4">
                            <a href="https://www.linkedin.com/in/marc-aur%C3%A9lien-djiepmo-642051336" class="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 transition-colors duration-300">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="http://github.com/ATHANOR667" class="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 transition-colors duration-300">
                                <span class="sr-only">GitHub</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Liens rapides -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Navigation</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="<?php echo e(route('profile.show')); ?>" class="text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Mon parcours
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('projects.index')); ?>" class="text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Projets
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('contact.show')); ?>" class="text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Contact
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 transition-colors duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600 dark:text-primary-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <a href="mailto:mdjiepmo@gmail.com" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">mdjiepmo@gmail.com</a>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600 dark:text-primary-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <a href="tel:+237654378079" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">+237 654 378 079</a>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-600 dark:text-primary-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-gray-600 dark:text-gray-300">Yaoundé, Cameroun</span>
                            </li>
                        </ul>

                        <!-- Disponibilité -->
                        <div class="mt-6 bg-green-50 dark:bg-green-900/20 rounded-lg p-3">
                            <div class="flex items-center">
                                <div class="h-3 w-3 rounded-full bg-green-500 mr-2 animate-pulse"></div>
                                <p class="text-sm text-green-800 dark:text-green-300">Disponible pour contrat d'alternance</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Certifications et technologies -->
                <div class="mt-10 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 text-center">Technologies et certifications</h3>
                    <div class="flex flex-wrap justify-center gap-6 items-center">
                        <div class="flex items-center bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                            <span class="text-sm text-gray-800 dark:text-gray-200">PHP</span>
                        </div>
                        <div class="flex items-center bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                            <span class="text-sm text-gray-800 dark:text-gray-200">Laravel</span>
                        </div>
                        <div class="flex items-center bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                            <span class="text-sm text-gray-800 dark:text-gray-200">Git</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            © <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Portfolio')); ?>. Tous droits réservés.
                        </p>
                        <div class="mt-4 md:mt-0 flex items-center space-x-4">
                            <button id="theme-toggle-footer" type="button" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-primary-700 dark:text-primary-300 bg-primary-100 dark:bg-primary-900 hover:bg-primary-200 dark:hover:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                                <svg id="theme-toggle-dark-icon-footer" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <svg id="theme-toggle-light-icon-footer" class="h-4 w-4 mr-1 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span id="theme-toggle-text-footer">Mode sombre</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    <?php endif; ?>
</div>

<!-- Script pour le menu mobile et le thème -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Menu mobile
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                const menuIcons = mobileMenuButton.querySelectorAll('svg');
                menuIcons.forEach(icon => icon.classList.toggle('hidden'));
            });
        }

        // Theme toggle setup
        const toggles = [
            {
                button: document.getElementById('theme-toggle'),
                darkIcon: document.getElementById('theme-toggle-dark-icon'),
                lightIcon: document.getElementById('theme-toggle-light-icon')
            },
            {
                button: document.getElementById('theme-toggle-mobile'),
                darkIcon: document.getElementById('theme-toggle-dark-icon-mobile'),
                lightIcon: document.getElementById('theme-toggle-light-icon-mobile')
            },
            {
                button: document.getElementById('theme-toggle-footer'),
                darkIcon: document.getElementById('theme-toggle-dark-icon-footer'),
                lightIcon: document.getElementById('theme-toggle-light-icon-footer'),
                text: document.getElementById('theme-toggle-text-footer')
            }
        ];

        // Function to update UI based on theme
        function updateThemeUI(isDark) {
            toggles.forEach(toggle => {
                if (toggle.darkIcon && toggle.lightIcon) {
                    toggle.darkIcon.classList.toggle('hidden', isDark);
                    toggle.lightIcon.classList.toggle('hidden', !isDark);
                }
                if (toggle.text) {
                    toggle.text.textContent = isDark ? 'Mode clair' : 'Mode sombre';
                }
            });
        }

        // Initialize theme UI
        const isDark = document.documentElement.classList.contains('dark');
        updateThemeUI(isDark);

        // Theme toggle handler
        function toggleTheme() {
            const isDark = !document.documentElement.classList.contains('dark');
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeUI(isDark);
        }

        // Attach event listeners to all toggle buttons
        toggles.forEach(toggle => {
            if (toggle.button) {
                toggle.button.removeEventListener('click', toggleTheme); // Prevent duplicate listeners
                toggle.button.addEventListener('click', toggleTheme);
            }
        });
    });
</script>
</body>
</html><?php /**PATH C:\Users\MARCAU\PhpstormProjects\MonPortfolio\resources\views/layouts/app.blade.php ENDPATH**/ ?>