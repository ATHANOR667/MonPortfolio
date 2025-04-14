<?php $__env->startSection('title', 'Modifier un projet'); ?>

<?php $__env->startSection('admin-content'); ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('edit-project', ['project' => $project]);

$__html = app('livewire')->mount($__name, $__params, 'lw-8025645-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MARCAU\PhpstormProjects\MonPortfolio\resources\views/admin/projects/edit.blade.php ENDPATH**/ ?>