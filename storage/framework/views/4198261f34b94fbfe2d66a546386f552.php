<?php $__env->startSection('content'); ?>
    <div class="flex justify-between mt-0">
        <div>
            <h1 class="text-2xl font-bold">Liste des permissions</h1>
        </div>
    </div>
    <div class="mt-4 pb-3">
                <a href="#" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    menus</a>
            </div>
    <div class="p-6 text-gray-900">
        <?php echo $__env->make('admin.permissions.partials._liste', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesAdditionnels'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('myJS'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/pgi/resources/views/admin/permissions/index.blade.php ENDPATH**/ ?>