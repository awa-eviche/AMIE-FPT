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

    <div class="bg-transparent shadow rounded-sm w-full p-4">

        <div class="mt-2 mb-2">
            <a href="<?php echo e(route('inscription.show',$inscription->id)); ?>" class="text-blue-500 hover:underline">&larr; Retour au détails de l'apprenant</a>
        </div>
        <div class="w-full mx-auto">
            <form class="bg-white pt-6 pb-8 mb-4" action="<?php echo e(route('evaluate.store',$inscription->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="md:container md:mx-auto">

                    <div class="w-full sm:px-2 lg:px-4 ">
                        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
                            <p>
                                <a href="<?php echo e(!(str_contains(auth()->user()->userable_type,'Entreprise')) ? '/dashboard' : 'javascript:void(0);'); ?>" class="text-maquette-gris">Accueil</a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p>
                                <a href="<?php echo e(route('classes.index')); ?>">Classes  </a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p>
                                <a href="javascript:void(0);">Apprenants  </a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p>
                                <a href="javascript:void(0);">Visualiser  </a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p class="text-first-orange">Faire une évaluation</p>
                            <p></p>
                        </div>
                        <div class="border border-gray-200">
                            <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                Evaluation
                            </h3>

                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('apprenants.competence.evaluer',['inscription'=>$inscription,'competences'=>$competences,'message'=>isset($message) ? $message : '']);

$__html = app('livewire')->mount($__name, $__params, 'lw-1467590171-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                        </div>
                        <button type="submit" class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>

                    </div>
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
<?php /**PATH /var/www/html/amie-fpt/resources/views/evaluations/evaluate.old.blade.php ENDPATH**/ ?>