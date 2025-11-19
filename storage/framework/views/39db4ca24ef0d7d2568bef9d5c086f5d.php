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
            <?php echo e(__('Faire une evaluation')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php $__env->startSection('stylesAdditionnels'); ?>
        <?php echo $__env->make('layouts.v1.partials.swal._style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <style>
            input[type='checkbox']{
                color: #16A34A;
            }
        </style>
    <?php $__env->stopSection(); ?>

    <div class="bg-transparent shadow rounded-sm w-full p-4">
        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm pl-4">
            <p>
                <a href="/dashboard" class="text-maquette-gris">Accueil</a>
                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p> <a href="<?php echo e(route('classe.index')); ?>">Classes </a>

                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p> <a href="javascript:void(0);">Apprenants </a>

                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p> <a href="javascript:void(0);">Compétences </a>

                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p class="text-first-orange">Evaluer </p>
            <p></p>
        </div>
        <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasAnyRole', ['agent','superadmin','responsable_technique'])): ?>
        <div class="mt-2 mb-2">
            <a href="<?php echo e(route('competence.manage.index')); ?>" class="text-blue-500 hover:underline">&larr; Retour à la gestion de compétences</a>
        </div>
        <?php endif; ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Apprenants.Competence.Evaluation',['inscription_id'=>$inscription->id]);

$__html = app('livewire')->mount($__name, $__params, 'lw-55156288-0', $__slots ?? [], get_defined_vars());

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
<?php /**PATH /var/www/html/pgi/resources/views/evaluations/evaluate.blade.php ENDPATH**/ ?>