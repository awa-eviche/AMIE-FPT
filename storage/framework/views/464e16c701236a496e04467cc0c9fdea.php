<?php $__env->startSection('content'); ?>
    <div class="flex justify-between mt-0 mb-2">
        <div class="mb-3">
            <h1 class="text-2xl font-bold">Liste des rôles</h1>
        </div>
    </div>
    <div class="mt-4 pb-3">
                <a href="#" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    menus</a>
            </div>
    <div class="flex flex-row-reverse mt-0 mb-2">
        <a href="<?php echo e(route('roles.create')); ?>">
            <button class="text-white bg-green-500 hover:bg-green-500 focus:ring-4 focus:ring-bg-green-500 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-500 dark:hover:bg-green-500 focus:outline-none dark:focus:bg-green-500">
                <i class="fas fa-plus mr-1"></i> Nouveau rôle
            </button>
        </a>
    </div>
    <?php echo $__env->make('admin.roles.partials._liste', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/pgi/resources/views/admin/roles/index.blade.php ENDPATH**/ ?>