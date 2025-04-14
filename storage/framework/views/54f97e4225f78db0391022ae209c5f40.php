<?php $__env->startSection('title', 'Messages de contact'); ?>

<?php $__env->startSection('admin-content'); ?>
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if(session('status')): ?>
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-3 rounded-md mb-3 sm:mb-6">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-3 sm:mb-6 gap-2">
            <h2 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">Messages de contact</h2>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md transition-all duration-300">
            <?php if($messages->isEmpty()): ?>
                <div class="p-4 sm:p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Aucun message de contact n'a été reçu pour le moment.</p>
                </div>
            <?php else: ?>
                <!-- Table pour écrans moyens et grands (adaptée de la version projets) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Expéditeur</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sujet</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($message->is_read ? '' : 'bg-blue-50 dark:bg-blue-900/20'); ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($message->name); ?></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($message->email); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white"><?php echo e(Str::limit($message->subject, 50)); ?></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e(Str::limit($message->message, 50)); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($message->created_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <?php if($message->is_read): ?>
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Lu</span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">Non lu</span>
                                        <?php endif; ?>
                                        <?php if($message->attachment): ?>
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                    </svg>
                                                    Pièce
                                                </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="<?php echo e(route('admin.contacts.show', $message)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300" aria-label="Voir le message de <?php echo e($message->name); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <?php if($message->is_read): ?>
                                            <form action="<?php echo e(route('admin.contacts.mark-as-unread', $message)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" aria-label="Marquer le message de <?php echo e($message->name); ?> comme non lu">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('admin.contacts.mark-as-read', $message)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" aria-label="Marquer le message de <?php echo e($message->name); ?> comme lu">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                                    </svg>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('admin.contacts.destroy', $message)); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" aria-label="Supprimer le message de <?php echo e($message->name); ?>">
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

                <!-- Card layout pour écrans mobiles (dernière version messages) -->
                <div class="block md:hidden space-y-3 p-3">
                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm p-4 border border-gray-200 dark:border-gray-600 <?php echo e($message->is_read ? '' : 'bg-blue-100 dark:bg-blue-900/30'); ?> hover:shadow-md transition-shadow duration-200">
                            <div class="flex justify-between items-start mb-2">
                                <div class="max-w-[70%]">
                                    <div class="text-base font-medium text-gray-900 dark:text-white truncate"><?php echo e($message->name); ?></div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 truncate"><?php echo e($message->email); ?></div>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <?php if($message->is_read): ?>
                                        <span class="px-1 py-0.5 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">Lu</span>
                                    <?php else: ?>
                                        <span class="px-1 py-0.5 text-xs rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">Non lu</span>
                                    <?php endif; ?>
                                    <?php if($message->attachment): ?>
                                        <span class="px-1 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-300 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Pièce
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-sm text-gray-900 dark:text-white truncate">
                                <span class="font-medium">Sujet :</span> <?php echo e(Str::limit($message->subject, 40)); ?>

                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1 truncate">
                                <span class="font-medium">Message :</span> <?php echo e(Str::limit($message->message, 80)); ?>

                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span class="font-medium">Date :</span> <?php echo e($message->created_at->format('d/m/Y H:i')); ?>

                            </div>
                            <div class="flex justify-end space-x-2 mt-3">
                                <a href="<?php echo e(route('admin.contacts.show', $message)); ?>" class="p-2 bg-gray-100 dark:bg-gray-600 rounded-full text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 hover:scale-105 transition-transform duration-200" aria-label="Voir le message de <?php echo e($message->name); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <?php if($message->is_read): ?>
                                    <form action="<?php echo e(route('admin.contacts.mark-as-unread', $message)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="p-2 bg-gray-100 dark:bg-gray-600 rounded-full text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:scale-105 transition-transform duration-200" aria-label="Marquer le message de <?php echo e($message->name); ?> comme non lu">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.contacts.mark-as-read', $message)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" class="p-2 bg-gray-100 dark:bg-gray-600 rounded-full text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 hover:scale-105 transition-transform duration-200" aria-label="Marquer le message de <?php echo e($message->name); ?> comme lu">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                            </svg>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <form action="<?php echo e(route('admin.contacts.destroy', $message)); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 bg-gray-100 dark:bg-gray-600 rounded-full text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:scale-105 transition-transform duration-200" aria-label="Supprimer le message de <?php echo e($message->name); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="px-4 py-4 sm:px-6 sm:py-4 flex justify-center">
                    <?php echo e($messages->links('pagination::tailwind')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MARCAU\PhpstormProjects\MonPortfolio\resources\views/admin/contacts/index.blade.php ENDPATH**/ ?>