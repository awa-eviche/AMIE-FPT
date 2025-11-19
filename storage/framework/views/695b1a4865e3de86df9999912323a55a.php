<nav class="flex" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($loop->last): ?>
                <li class="text-first-orange">
                   <?php echo e($breadcrumb['name']); ?>

                </li>
              
            <?php else: ?>
                <li class="text-gray-500">
                <a href="<?php echo e($breadcrumb['url']); ?>" class="text-gray-500"><?php echo e($breadcrumb['name']); ?></a>
                </li>
                <li>
                   <span><i class="font-bold">/</i></span>
                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>
<?php /**PATH /var/www/html/pgi/resources/views/components/breadcrumb.blade.php ENDPATH**/ ?>