<?php $__env->startSection('title', 'Gestion des commentaires'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="max-w-7xl mx-auto">
    <?php if(session('status')): ?>
        <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 rounded-md mb-6">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Commentaires</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-300">
        <?php if($comments->isEmpty()): ?>
            <div class="p-6 text-center">
                <p class="text-gray-500 dark:text-gray-400">Aucun commentaire n'a été reçu pour le moment.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Auteur</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Projet</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Commentaire</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 comment-row" data-comment-id="<?php echo e($comment->id); ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($comment->name); ?></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($comment->email); ?></div>
                                    <?php if($comment->website): ?>
                                        <div class="text-xs text-primary-600 dark:text-primary-400">
                                            <a href="<?php echo e($comment->website); ?>" target="_blank" rel="noopener noreferrer"><?php echo e($comment->website); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="<?php echo e(route('admin.projects.edit', $comment->project)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                        <?php echo e($comment->project->title); ?>

                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        <?php echo e(Str::limit($comment->content, 100)); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($comment->created_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($comment->is_approved): ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Approuvé</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">En attente</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" class="view-comment-btn text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" data-comment-id="<?php echo e($comment->id); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <?php if(!$comment->is_approved): ?>
                                            <form action="<?php echo e(route('admin.comments.approve', $comment)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('admin.comments.reject', $comment)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('admin.comments.destroy', $comment)); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');" class="inline">
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
            <div class="px-6 py-4">
                <?php echo e($comments->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal pour afficher le commentaire complet -->
<div id="comment-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Détails du commentaire</h3>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center mb-2">
                    <span class="font-semibold text-gray-700 dark:text-gray-300 mr-2">Auteur:</span>
                    <span id="modal-author" class="text-gray-900 dark:text-white"></span>
                </div>
                <div class="flex items-center mb-2">
                    <span class="font-semibold text-gray-700 dark:text-gray-300 mr-2">Email:</span>
                    <span id="modal-email" class="text-gray-900 dark:text-white"></span>
                </div>
                <div id="modal-website-container" class="flex items-center mb-2 hidden">
                    <span class="font-semibold text-gray-700 dark:text-gray-300 mr-2">Site web:</span>
                    <a id="modal-website" href="#" target="_blank" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"></a>
                </div>
                <div class="flex items-center mb-2">
                    <span class="font-semibold text-gray-700 dark:text-gray-300 mr-2">Projet:</span>
                    <a id="modal-project" href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"></a>
                </div>
                <div class="flex items-center mb-2">
                    <span class="font-semibold text-gray-700 dark:text-gray-300 mr-2">Date:</span>
                    <span id="modal-date" class="text-gray-900 dark:text-white"></span>
                </div>
                <div class="flex items-center mb-4">
                    <span class="font-semibold text-gray-700 dark:text-gray-300 mr-2">Statut:</span>
                    <span id="modal-status" class="px-2 py-1 text-xs rounded-full"></span>
                </div>
            </div>
            
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Contenu du commentaire:</h4>
                <div id="modal-content" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-gray-900 dark:text-white"></div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button id="modal-approve-btn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors hidden">
                    Approuver
                </button>
                <button id="modal-reject-btn" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors hidden">
                    Rejeter
                </button>
                <button id="modal-delete-btn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentModal = document.getElementById('comment-modal');
        const closeModal = document.getElementById('close-modal');
        const viewButtons = document.querySelectorAll('.view-comment-btn');
        const modalAuthor = document.getElementById('modal-author');
        const modalEmail = document.getElementById('modal-email');
        const modalWebsiteContainer = document.getElementById('modal-website-container');
        const modalWebsite = document.getElementById('modal-website');
        const modalProject = document.getElementById('modal-project');
        const modalDate = document.getElementById('modal-date');
        const modalStatus = document.getElementById('modal-status');
        const modalContent = document.getElementById('modal-content');
        const modalApproveBtn = document.getElementById('modal-approve-btn');
        const modalRejectBtn = document.getElementById('modal-reject-btn');
        const modalDeleteBtn = document.getElementById('modal-delete-btn');
        
        let currentCommentId = null;
        
        // Ouvrir la modal lors du clic sur le bouton de visualisation
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const row = document.querySelector(`.comment-row[data-comment-id="${commentId}"]`);
                
                if (row) {
                    currentCommentId = commentId;
                    
                    // Remplir les informations de la modal
                    const author = row.querySelector('td:nth-child(1) div:nth-child(1)').textContent;
                    const email = row.querySelector('td:nth-child(1) div:nth-child(2)').textContent;
                    const websiteLink = row.querySelector('td:nth-child(1) div:nth-child(3) a');
                    const project = row.querySelector('td:nth-child(2) a').textContent.trim();
                    const projectLink = row.querySelector('td:nth-child(2) a').getAttribute('href');
                    const content = row.querySelector('td:nth-child(3) div').textContent.trim();
                    const date = row.querySelector('td:nth-child(4)').textContent.trim();
                    const isApproved = row.querySelector('td:nth-child(5) span').textContent.includes('Approuvé');
                    
                    modalAuthor.textContent = author;
                    modalEmail.textContent = email;
                    
                    if (websiteLink) {
                        modalWebsiteContainer.classList.remove('hidden');
                        modalWebsite.textContent = websiteLink.textContent;
                        modalWebsite.setAttribute('href', websiteLink.getAttribute('href'));
                    } else {
                        modalWebsiteContainer.classList.add('hidden');
                    }
                    
                    modalProject.textContent = project;
                    modalProject.setAttribute('href', projectLink);
                    modalDate.textContent = date;
                    
                    if (isApproved) {
                        modalStatus.textContent = 'Approuvé';
                        modalStatus.className = 'px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                        modalApproveBtn.classList.add('hidden');
                        modalRejectBtn.classList.remove('hidden');
                    } else {
                        modalStatus.textContent = 'En attente';
                        modalStatus.className = 'px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                        modalApproveBtn.classList.remove('hidden');
                        modalRejectBtn.classList.add('hidden');
                    }
                    
                    modalContent.textContent = content;
                    
                    // Configurer les formulaires pour les boutons d'action
                    modalApproveBtn.onclick = function() {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/comments/${commentId}/approve`;
                        form.innerHTML = `
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    };
                    
                    modalRejectBtn.onclick = function() {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/comments/${commentId}/reject`;
                        form.innerHTML = `
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    };
                    
                    modalDeleteBtn.onclick = function() {
                        if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/admin/comments/${commentId}`;
                            form.innerHTML = `
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    };
                    
                    // Afficher la modal
                    commentModal.classList.remove('hidden');
                }
            });
        });
        
        // Fermer la modal
        closeModal.addEventListener('click', function() {
            commentModal.classList.add('hidden');
            currentCommentId = null;
        });
        
        // Fermer la modal en cliquant en dehors
        commentModal.addEventListener('click', function(e) {
            if (e.target === commentModal) {
                commentModal.classList.add('hidden');
                currentCommentId = null;
            }
        });
        
        // Fermer la modal avec la touche Echap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !commentModal.classList.contains('hidden')) {
                commentModal.classList.add('hidden');
                currentCommentId = null;
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MARCAU\PhpstormProjects\MonPortfolio\resources\views/admin/comments/index.blade.php ENDPATH**/ ?>