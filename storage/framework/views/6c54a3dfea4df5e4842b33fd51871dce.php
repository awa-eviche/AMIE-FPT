<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo $__env->make('admin.users.partials._detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('myJS'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/pgi/resources/views/admin/users/show.blade.php ENDPATH**/ ?>