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
            <?php echo e(__('Modifier un critère')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="bg-transparent shadow rounded-sm w-full p-4">

        
        <div class="mt-2 mb-4">
            <a href="<?php echo e(route('critere.index')); ?>" class="text-blue-500 hover:underline">
                &larr; Retour à la liste des  seuil de réussite
            </a>
        </div>

        
        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
            <p>
                <a href="/dashboard" class="text-maquette-black">Accueil</a>
                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p>
                <a href="<?php echo e(route('critere.index')); ?>" class="text-maquette-black"> Seuil de réussite</a>
                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p class="text-first-orange">Modifier</p>
        </div>

        
        <div class="border border-gray-200 bg-white rounded-sm">
        

            <div class="p-5">
                
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('param.edit-critere', ['id' => $critere->id]);

$__html = app('livewire')->mount($__name, $__params, 'lw-971461466-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
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
<?php /**PATH /var/www/html/pgi/resources/views/criteres/edit.blade.php ENDPATH**/ ?>