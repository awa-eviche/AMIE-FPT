<?php $__env->startSection('content'); ?>
    <?php echo Form::model($role, ['method' =>'PATCH',
                    'route' => ['roles.update', $role], 'role' => 'form', 'class' => 'apix-form']); ?>

    <?php echo $__env->make('admin.roles.partials._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesAdditionnels'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('myJS'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/pgi/resources/views/admin/roles/edit.blade.php ENDPATH**/ ?>