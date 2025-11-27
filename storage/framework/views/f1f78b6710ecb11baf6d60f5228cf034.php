<?php $__env->startSection('content'); ?>
    <div class="flex justify-between mt-0 mb-2">
        <div class="mb-5">
            <h1 class="text-2xl font-bold"><?php echo e($title); ?></h1>
            <div class="mt-4">
                <?php if($fromUser == true): ?>
                <a href="<?php echo e(route('users.index')); ?>" class="text-blue-500 hover:underline">&larr; Retour à la liste</a>
                <?php endif; ?>
                <div class="mt-4 pb-3">
                <a href="<?php echo e(route('admin.index')); ?>" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    menu</a>
            </div>
            </div>
            
        </div>
    </div>
    <?php echo $__env->make('admin.users.partials._logs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('myJS'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/amie-fpt/resources/views/admin/users/index_logs.blade.php ENDPATH**/ ?>