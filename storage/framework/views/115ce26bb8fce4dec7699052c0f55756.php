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
            <?php echo e(__('Ajout multiple de matières')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <!-- Fil d’Ariane -->
    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="<?php echo e(route('matiere.index')); ?>" class="text-maquette">Accueil</a>
            <span class="mx-2 text-maquette">/</span>
            <a href="<?php echo e(route('matiere.index')); ?>" class="text-maquette">Référentiel</a>
            <span class="mx-2 text-maquette">/</span>
            <a href="<?php echo e(route('matiere.index')); ?>">Matière</a>
            <span class="mx-2 text-maquette">/</span>
            <span class="text-first-orange">Ajout Multiple</span>
        </p>
    </div>

    <!-- Composant Livewire -->
    <div class="max-w-5xl mx-auto mt-6">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('parametrage.matiere.multiple-create-matiere');

$__html = app('livewire')->mount($__name, $__params, 'lw--1660710203-0', $__slots ?? [], get_defined_vars());

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
<?php /**PATH /var/www/html/pgi/resources/views/parametrage/matiere/create.blade.php ENDPATH**/ ?>