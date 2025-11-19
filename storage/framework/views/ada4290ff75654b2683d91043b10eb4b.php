<?php
use Collective\Html\FormFacade as Form;
?>




<?php $__env->startSection('content'); ?>


    <?php echo Form::model($permission, ['method' =>'PATCH',
                    'route' => ['permissions.update', $permission], 'role' => 'form', 'class' => 'apix-form']); ?>

    <?php echo $__env->make('admin.permissions.partials._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesAdditionnels'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('myJS'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/pgi/resources/views/admin/permissions/edit.blade.php ENDPATH**/ ?>