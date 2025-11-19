<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-white uppercase bg-first-orange dark:bg-first-orange dark:text-white">
        <tr>
            <th scope="col" class="px-6 py-3 text-center">#ID</th>
            <th scope="col" class="px-6 py-3 text-center">Nom</th>
            <th scope="col" class="px-6 py-3 text-center">Description</th>
            <th scope="col" class="px-6 py-3 text-center">Actions</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        <?php if($permissions->count() == 0): ?>
            <tr>
                <td colspan="6"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center hover:border-l-8 border-first-orange">
                    Aucune permission à afficher.
                </td>
            </tr>
        <?php endif; ?>
        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="bg-white border-b dark:bg-white dark:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-100">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    <?php echo e($permission->id); ?>

                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    <?php echo e($permission->name); ?>

                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    <?php echo e($permission->description); ?>

                </td>
                <td class="px-6 py-4 text-center">
                    <a href="<?php echo e(route('permissions.edit', $permission)); ?>" class="text-black-50 mr-2"
                       data-toggle="tooltip" title="Modifier">
                        <i class="fas fa-edit text-black-50"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="p-2">
        <?php echo e($permissions->links('pagination::tailwind')); ?>

    </div>
</div><?php /**PATH /var/www/html/pgi/resources/views/admin/permissions/partials/_liste.blade.php ENDPATH**/ ?>