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
            <?php echo e(__('Detail type notification')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="<?php echo e(route("type_notification.index")); ?>"  class="text-maquette">Liste des type de notification</a>
        </p>
        <span class="mx-2 text-maquette">/</span>
        <p class="text-first-orange">Détail du type de notification</p>
    </div>


    <div class="flex flex-wrap bg-white p-3">
        <div class="w-full md:w-1/2 bg-white p-4">
            <div class="shadow h-full">
                <div class="flex items-center justify-between bg-gray-200 p-1 mt-2">
                    <p class="text-first-orange font-bold">État rejet</p>
                </div>
                <div class="container bg-white p-4 rounded">
                    <div class="mt-4 mb-2 flex text-sm">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Action :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-gray-700"><?php echo e($typeNotification->action); ?></span>
                        </div>
                    </div>
                    <hr>

                    <div class="mt-4 mb-2 flex text-sm">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Message :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-gray-700"><?php echo e($typeNotification->message); ?></span>
                        </div>
                    </div>


                    <div class="mt-12 flex items-center justify-between">
                        <a href="<?php echo e(route('type_notification.index')); ?>" class="bg-first-orange text-white py-1 px-4 rounded">Retour</a>
                        <a href="<?php echo e(route('type_notification.edit', $typeNotification->id)); ?>" class="bg-first-orange text-white py-1 px-4 rounded">Modifier</a>
                    </div>
                </div>

            </div>

        </div>


        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('manage-notify-profil', ['typeNotification' => $typeNotification]);

$__html = app('livewire')->mount($__name, $__params, 'lw--656347089-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
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
<?php /**PATH /var/www/html/amie-fpt/resources/views/parametrage/type_notification/show.blade.php ENDPATH**/ ?>