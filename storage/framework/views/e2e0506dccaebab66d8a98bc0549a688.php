<?php $__env->startSection('title', 'Gestion des projets'); ?>

<?php $__env->startSection('admin-content'); ?>
    <div class="w-full max-w-screen-lg mx-auto px-3 sm:px-4 lg:px-6">
        <?php if(session('status')): ?>
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-3 rounded-md mb-3">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-3 sm:mb-4 gap-2">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Projets</h2>
            <a href="<?php echo e(route('admin.projects.create')); ?>" class="py-1.5 px-3 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                Ajouter un projet
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md transition-all duration-300">
            <?php if($projects->isEmpty()): ?>
                <div class="p-4 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Aucun projet n'a été ajouté pour le moment.</p>
                    <a href="<?php echo e(route('admin.projects.create')); ?>" class="mt-2 inline-flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer votre premier projet
                    </a>
                </div>
            <?php else: ?>
                <div class="divide-y divide-gray-200 dark:divide-gray-700 sm:overflow-x-auto">
                    <!-- Mobile: Cartes -->
                    <div class="sm:hidden space-y-3 p-3">
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-primary-50 dark:bg-gray-700 rounded-md shadow-sm p-3 hover:scale-[1.02] transition-transform duration-200">
                                <div class="flex items-start gap-3">
                                    <div class="h-16 w-16 rounded overflow-hidden bg-gray-100 dark:bg-gray-600 flex-shrink-0">
                                        <?php if($project->featured_image): ?>
                                            <img src="<?php echo e(Storage::url($project->featured_image)); ?>" alt="<?php echo e($project->title); ?>" class="h-full w-full object-cover">
                                        <?php else: ?>
                                            <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-base font-medium text-gray-900 dark:text-white truncate"><?php echo e($project->title); ?></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 truncate"><?php echo e(Str::limit($project->description, 20)); ?></div>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <?php $__empty_1 = true; $__currentLoopData = $project->categories->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <span class="px-1.5 py-0.5 text-xs rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                                    <?php echo e($category->name); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Aucune catégorie</span>
                                            <?php endif; ?>
                                            <?php if($project->categories->count() > 1): ?>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">+<?php echo e($project->categories->count() - 1); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-1">
                                            <form action="<?php echo e(route('admin.projects.toggle-published', $project)); ?>" method="POST" class="toggle-form inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="flex items-center">
                                                    <?php if($project->is_published): ?>
                                                        <span class="px-1.5 py-0.5 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Publié</span>
                                                    <?php else: ?>
                                                        <span class="px-1.5 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Masqué</span>
                                                    <?php endif; ?>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 mt-2">
                                    <a href="<?php echo e(route('admin.projects.edit', $project)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="<?php echo e(route('admin.projects.destroy', $project)); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Desktop: Table -->
                    <table class="hidden sm:table w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Image</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Titre</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Catégories</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vues</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="h-12 w-12 rounded overflow-hidden bg-gray-100 dark:bg-gray-600">
                                        <?php if($project->featured_image): ?>
                                            <img src="<?php echo e(Storage::url($project->featured_image)); ?>" alt="<?php echo e($project->title); ?>" class="h-full w-full object-cover">
                                        <?php else: ?>
                                            <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($project->title); ?></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(Str::limit($project->description, 40)); ?></div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1 max-w-[200px]">
                                        <?php $__empty_1 = true; $__currentLoopData = $project->categories->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <span class="px-1.5 py-0.5 text-xs rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                                    <?php echo e($category->name); ?>

                                                </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Aucune catégorie</span>
                                        <?php endif; ?>
                                        <?php if($project->categories->count() > 3): ?>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">+<?php echo e($project->categories->count() - 3); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <form action="<?php echo e(route('admin.projects.toggle-published', $project)); ?>" method="POST" class="toggle-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="flex items-center">
                                            <?php if($project->is_published): ?>
                                                <span class="px-1.5 py-0.5 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Publié</span>
                                            <?php else: ?>
                                                <span class="px-1.5 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Masqué</span>
                                            <?php endif; ?>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                    <?php echo e($project->views_count); ?>

                                </td>
                                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                    <?php echo e($project->date ? $project->date->format('d/m/Y') : 'Non définie'); ?>

                                </td>
                                <td class="px-4 py-3 text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="<?php echo e(route('admin.projects.edit', $project)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="<?php echo e(route('admin.projects.destroy', $project)); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="px-3 sm:px-4 py-3 flex justify-center">
                    <?php echo e($projects->links('pagination::tailwind')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MARCAU\PhpstormProjects\MonPortfolio\resources\views/admin/projects/index.blade.php ENDPATH**/ ?>