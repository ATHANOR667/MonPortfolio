<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Portfolio Admin')); ?></title>

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

        /* Smooth theme transition */
        html {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

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

        /* Prevent FOUC */
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

    <!-- Apply Theme Before Rendering -->
    <script>
        (function() {
            try {
                // Vérifier d'abord localStorage, puis la préférence système
                const theme = localStorage.getItem('theme') ||
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

                document.documentElement.classList.remove('dark'); // Réinitialiser
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
                localStorage.setItem('theme', theme);
                console.log('Thème initial appliqué :', theme); // Log pour débogage
            } catch (e) {
                console.error('Erreur lors de l\'initialisation du thème :', e);
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

    // Fallback to ensure content is displayed
    setTimeout(function() {
        if (document.body.classList.contains('no-js')) {
            document.body.classList.remove('no-js');
            document.body.classList.add('js-loaded');
        }
    }, 1500);
</script>
<div class="min-h-screen flex flex-col">
    <div class="min-h-screen flex bg-gray-50 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-md hidden md:block transition-all duration-300">
            <div class="p-6">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">Portfolio Admin</h1>
            </div>
            <nav class="mt-6">
                <div class="px-4 space-y-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Tableau de bord</span>
                    </a>

                    <a href="<?php echo e(route('admin.profile.edit')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.profile.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Profil</span>
                    </a>

                    <a href="<?php echo e(route('admin.projects.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.projects.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span>Projets</span>
                    </a>

                    <a href="<?php echo e(route('admin.comments.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.comments.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span>Commentaires</span>
                    </a>

                    <a href="<?php echo e(route('admin.contacts.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.contacts.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Messages</span>
                    </a>

                    <a href="<?php echo e(route('admin.statistics.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.statistics.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Statistiques</span>
                    </a>

                    <a href="<?php echo e(route('admin.security.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.security.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Sécurité</span>
                    </a>

                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Mobile menu button -->
        <div class="md:hidden fixed bottom-4 right-4 z-50">
            <button id="mobile-menu-button" class="p-3 rounded-full bg-primary-600 text-white shadow-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-300 interactive-element">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden">
            <div class="absolute right-0 top-0 h-full w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300">
                <div class="p-6 flex justify-between items-center">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Menu</h1>
                    <button id="close-mobile-menu" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <nav class="mt-6">
                    <div class="px-4 space-y-1">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Tableau de bord</span>
                        </a>

                        <a href="<?php echo e(route('admin.profile.edit')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.profile.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Profil</span>
                        </a>

                        <a href="<?php echo e(route('admin.projects.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.projects.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>Projets</span>
                        </a>

                        <a href="<?php echo e(route('admin.comments.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.comments.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <span>Commentaires</span>
                        </a>

                        <a href="<?php echo e(route('admin.contacts.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.contacts.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Messages</span>
                        </a>

                        <a href="<?php echo e(route('admin.statistics.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 <?php echo e(request()->routeIs('admin.statistics.*') ? 'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : ''); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Statistiques</span>
                        </a>

                        <a href="<?php echo e(route('admin.security.index')); ?>" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span>Sécurité</span>
                        </a>

                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm z-10 transition-all duration-300 fixed-nav">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-xl font-semibold text-gray-900 dark:text-white"><?php echo $__env->yieldContent('title', 'Tableau de bord'); ?></h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Dark mode toggle -->
                            <button
                                    id="admin-theme-toggle"
                                    class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300 interactive-element"
                                    aria-label="Toggle dark mode"
                            >
                                <svg id="admin-theme-toggle-dark-icon" class="h-5 w-5 text-gray-800 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg id="admin-theme-toggle-light-icon" class="h-5 w-5 text-gray-800 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>

                            <!-- Preview site button -->
                            <a href="/" target="_blank" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300 interactive-element" aria-label="Preview site">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <!-- User dropdown -->
                            <div class="relative">
                                <button
                                        class="admin-dropdown-toggle flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-md"
                                        aria-label="User menu"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div id="user-dropdown" class="admin-dropdown-menu absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 transition-all duration-300 hidden">
                                    <a href="<?php echo e(route('admin.security.index')); ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Paramètres</a>
                                    <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 pt-20 transition-all duration-300">
                <?php echo $__env->yieldContent('admin-content'); ?>
            </main>

            <!-- Admin footer -->
            <footer class="bg-white dark:bg-gray-800 shadow-inner">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="mb-4 md:mb-0">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                © <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Portfolio')); ?>. Tous droits réservés.
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="/" target="_blank" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-300">
                                Voir le site
                            </a>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-300">
                                Tableau de bord
                            </a>
                            <a href="<?php echo e(route('admin.profile.edit')); ?>" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors duration-300">
                                Profil
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- Script for Mobile Menu, Theme Toggle, and Dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Theme Toggle
        const adminThemeToggle = document.getElementById('admin-theme-toggle');
        const adminDarkIcon = document.getElementById('admin-theme-toggle-dark-icon');
        const adminLightIcon = document.getElementById('admin-theme-toggle-light-icon');

        if (adminThemeToggle && adminDarkIcon && adminLightIcon) {
            // Fonction pour mettre à jour les icônes
            const updateIcons = (isDark) => {
                adminDarkIcon.style.display = isDark ? 'block' : 'none';
                adminLightIcon.style.display = isDark ? 'none' : 'block';
                console.log('Icônes mises à jour : dark=', isDark); // Log pour débogage
            };

            // Initialiser les icônes
            const isDark = document.documentElement.classList.contains '

            System: (dark');
            updateIcons(isDark);
            console.log('État initial du thème :', isDark ? 'dark' : 'light');

            // Gérer le clic sur le toggle
            adminThemeToggle.addEventListener('click', function() {
                try {
                    // Basculer la classe dark
                    document.documentElement.classList.toggle('dark');

                    // Déterminer le nouvel état après le basculement
                    const isDark = document.documentElement.classList.contains('dark');

                    // Mettre à jour localStorage
                    const newTheme = isDark ? 'dark' : 'light';
                    localStorage.setItem('theme', newTheme);

                    // Mettre à jour les icônes
                    updateIcons(isDark);

                    console.log('Thème basculé vers :', newTheme);
                    console.log('Classe dark présente :', isDark);
                } catch (e) {
                    console.error('Erreur lors du basculement du thème :', e);
                }
            });

            // Écouter les changements de préférence système
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('theme')) {
                    const isDark = e.matches;
                    document.documentElement.classList.toggle('dark', isDark);
                    updateIcons(isDark);
                    console.log('Préférence système changée :', isDark ? 'dark' : 'light');
                }
            });
        } else {
            console.warn('Éléments du thème non trouvés');
        }

        // Mobile Menu
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenuButton = document.getElementById('close-mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });

            if (closeMobileMenuButton) {
                closeMobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            }

            mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768 && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        }

        // User Dropdown
        const userDropdownToggle = document.querySelector('.admin-dropdown-toggle');
        const userDropdown = document.getElementById('user-dropdown');

        if (userDropdownToggle && userDropdown) {
            userDropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            userDropdownToggle.addEventListener('mouseenter', function() {
                userDropdown.classList.remove('hidden');
            });

            userDropdown.addEventListener('mouseenter', function() {
                userDropdown.classList.remove('hidden');
            });

            userDropdownToggle.addEventListener('mouseleave', function(e) {
                const rect = userDropdown.getBoundingClientRect();
                const isInDropdown = e.clientX >= rect.left && e.clientX <= rect.right &&
                    e.clientY >= rect.top && e.clientY <= rect.bottom;

                if (!isInDropdown) {
                    setTimeout(() => {
                        if (!userDropdown.matches(':hover')) {
                            userDropdown.classList.add('hidden');
                        }
                    }, 100);
                }
            });

            userDropdown.addEventListener('mouseleave', function() {
                userDropdown.classList.add('hidden');
            });

            document.addEventListener('click', function() {
                userDropdown.classList.add('hidden');
            });
        }
    });
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html><?php /**PATH C:\Users\MARCAU\PhpstormProjects\MonPortfolio\resources\views/layouts/admin.blade.php ENDPATH**/ ?>