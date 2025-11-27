<?php $__env->startSection('content'); ?>

    <?php echo Form::model($projet, ['method' =>'PUT', 'route' => ['projet.update', $id], 'role' => 'form',
    'class' => 'apix-form', 'files' => 'true']); ?>

    <?php echo $__env->make('projet.partials._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('stylesAdditionnels'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('myJS'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/amie-fpt/resources/views/projet/edit.blade.php ENDPATH**/ ?>