<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="md:container md:mx-auto">
            <h2 class="text-first-orange text-2xl">Editer un rôle</h2>
            <div class="mt-4 mb-2">
                <a href="<?php echo e(route('roles.index')); ?>" class="text-blue-500 hover:underline">&larr; Retour à la liste des rôles</a>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="name"
                           class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-500">Nom</label>
                    <?php echo Form::text('name', null, ['id' => 'name', 'class' => 'my-input bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 dark:bg-white dark:border-gray-400  dark:text-gray-600 dark:focus:ring-gray-400 dark:focus:border-gray-400', 'required' => '', 'placeholder' => 'Nom',
                        (isset($role) && !$role->isDeletable()) ? 'readonly' : '']); ?>

                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="description"
                           class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-500">Descritpion</label>
                    <?php echo Form::text('description', null, ['id' => 'description', 'class' => 'bg-white border border-gray-400 text-gray-500 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 dark:bg-white dark:border-gray-400  dark:text-gray-500 dark:focus:ring-gray-400 dark:focus:border-gray-400', 'required' => '', 'placeholder' => 'Description']); ?>

                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="permissions"
                           class="block mb-2 text-sm font-medium text-gray-500 dark:text-black">Permissions</label>
                    <?php echo Form::select('permissions[]', $permissions, null, ['id' => 'permissions', 'class' => 'select2 bg-white border border-gray-400 text-gray-500 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 dark:bg-white dark:border-gray-400  dark:text-gray-500 dark:focus:ring-gray-400 dark:focus:border-gray-400',
                    'data-control' => 'select2', 'data-allow-clear' => 'true', 'data-placeholder' => 'Choisir...', 'multiple' => 'multiple']); ?>

                </div>
                <?php if(isset($role)): ?>
                    <?php echo Form::hidden('role_id', $role->id); ?>

                <?php endif; ?>
            </div>
            <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                <div class="relative z-0 w-full mb-6 group">
                    <button type="submit"
                            class="text-white bg-first-orange hover:bg-first-orange focus:ring-4 focus:ring-first-orange  font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-first-orange  dark:hover:bg-first-orange focus:outline-none dark:focus:bg-first-orange">
                        Enregistrer
                    </button>
                    <a href="<?php echo e(route('roles.index')); ?>"
                       class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-3 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        Annuler </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('stylesAdditionnels'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('stylesAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.select2._style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scriptsAdditionnels'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scriptsAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.select2._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.v1.partials.parsley._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('myJS'); ?>
    <script>
        $(document).ready(
            function () {
                'use strict';
                $('.select2').select2();
                $(".apix-form").parsley()
            }
        );
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/html/pgi/resources/views/admin/roles/partials/_form.blade.php ENDPATH**/ ?>