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
            <?php echo e(__('Créer un Type de Notification')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="<?php echo e(route("type_notification.index")); ?>"  class="text-maquette-gris">Liste des type de notification</a>
        </p>
        <span class="mx-2 text-maquette-gris">/</span>
        <p class="text-first-orange">Nouveau type de notification</p>
    </div>

    <div class="bg-white shadow rounded-sm w-full p-4">


        <div class="w-full max-w-md mx-auto text-sm">
            <form action="<?php echo e(route('type_notification.store')); ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label for="action" class="block text-first-orange font-bold mb-2">Action :</label>
                    <input type="text" id="action" name="action" class="form-input rounded-sm border-2 border-gray-200 shadow-sm mt-1 block w-full" required>
                </div>

                
                <div class="mb-4 mx-auto w-full">
                    <label class="block text-first-orange text-sm font-bold" for="message">
                        Message
                    </label>
                    <textarea class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="message" name="message" required rows="8" placeholder="message"></textarea>
                </div>


                <div class="flex items-center justify-between">
                    <a href="<?php echo e(route('type_notification.index')); ?>" class="bg-maquette-gris py-2 px-4 rounded text-first-orange hover:text-gray-900">
                        Annuler
                    </a>
                    <button type="submit" class="bg-first-orange hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">
                        Enregistrer
                    </button>
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
<?php /**PATH /var/www/html/amie-fpt/resources/views/parametrage/type_notification/create.blade.php ENDPATH**/ ?>