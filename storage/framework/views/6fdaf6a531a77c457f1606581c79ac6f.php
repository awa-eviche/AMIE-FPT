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
            <?php echo e(__('Modifier le Type de Notification')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="bg-white shadow rounded-sm w-full p-4">
        <h2 class="font-bold text-maquette-gris text-xl">
            Edition Type notification
        </h2>

    <div class="w-full max-w-md mx-auto">
        <form action="<?php echo e(route('type_notification.update', $typeNotification->id)); ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-4">
                <label for="action" class="block text-first-orange font-bold mb-2">Action :</label>
                <input type="text" id="action" name="action" class="form-input rounded-sm border-gray-200 shadow-sm mt-1 block w-full" value="<?php echo e($typeNotification->action); ?>" required>
            </div>

            <div class="mb-4">
                <label for="message" class="block text-first-orange font-bold mb-2">Message :</label>
                <input type="text" id="message" name="message" class="form-input rounded-sm border-gray-200 shadow-sm mt-1 block w-full" value="<?php echo e($typeNotification->message); ?>" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Enregistrer
                </button>
                <a href="<?php echo e(route('type_notification.index')); ?>" class="text-gray-600 hover:text-gray-900">
                    Annuler
                </a>
            </div>
        </form>
    </div>


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
<?php /**PATH /var/www/html/amie-fpt/resources/views/parametrage/type_notification/edit.blade.php ENDPATH**/ ?>