<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Assigner des formateurs à la classe <?php echo e($classe->libelle); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form method="POST" action="<?php echo e(route('classe.formateurs.storeAssign', $classe->id)); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <h3 class="font-bold text-lg text-gray-700 mb-3">
                    Sélectionnez les formateurs de l’établissement
                    <span class="text-blue-700"><?php echo e($classe->etablissement->nom); ?></span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <?php $__currentLoopData = $formateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formateur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center space-x-2 border rounded p-2 hover:bg-gray-50">
                            <input type="checkbox" name="formateurs[]" value="<?php echo e($formateur->id); ?>"
                                   <?php echo e(in_array($formateur->id, $formateursAssignes) ? 'checked' : ''); ?>

                                   class="text-blue-600 focus:ring-blue-500">
                            <span><?php echo e($formateur->user->prenom ?? ''); ?> <?php echo e($formateur->user->nom ?? ''); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="<?php echo e(route('classe.show', $classe->id)); ?>"
                   class="bg-gray-400 text-white px-5 py-2 rounded hover:bg-gray-500 mr-2">Annuler</a>
                <button type="submit"
                        class="bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800">Enregistrer</button>
            </div>
        </form>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/pgi/resources/views/classe/assign-formateurs.blade.php ENDPATH**/ ?>