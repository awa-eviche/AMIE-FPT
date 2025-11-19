<?php $__env->startSection('content'); ?>

    <div class="flex justify-between mt-0 mb-2">
        <div class="mb-5 ml-5">
            <h1 class="text-2xl font-bold">Liste des utilisateurs</h1>
            
        </div>
    </div>
    <div class="mt-4 pb-3">
                <a href="<?php echo e(route('admin.index')); ?>" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    menu</a>
            </div>
    <?php echo $__env->make('admin.users.partials._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.users.partials._liste', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('myJS'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/pgi/resources/views/admin/users/index.blade.php ENDPATH**/ ?>