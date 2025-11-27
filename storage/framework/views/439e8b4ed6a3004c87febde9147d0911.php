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
            <?php echo e(__('Détails du Type de Demande')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="<?php echo e(route("type_demande.index")); ?>"  class="text-maquette">Liste des type de demandes</a>
        </p>
        <span class="mx-2 text-maquette">/</span>
        <p class="text-first-orange">Détail type de demande</p>
    </div>


    <div class="mt-5 pb-12 pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 bg-white shadow-xl w-full rounded-sm">
        <div class="max-w-7xl sm:px-2 lg:px-2">
            <div class="bg-white shadow rounded-sm w-full p-4">
                <h2 class="font-bold text-maquette text-xl">
                    Détail de type de demande
                </h2>

                <div class="w-full max-w-md mx-auto shadow mt-2">
                    <div class="flex items-center justify-between bg-gray-200 p-1 mt-2">
                        <p class="font-bold text-first-orange">Détails</p>
                    </div>
                    <div class="p-2">
                        <div class="mt-4 mb-2 flex text-sm">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">libelle :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-gray-700"><?php echo e($typeDemande->libelle); ?></span>
                            </div>
                        </div>

                        <div class="mt-4 mb-2 flex text-sm">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">code :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-gray-700"><?php echo e($typeDemande->code); ?></span>
                            </div>
                        </div>

                        <div class="mt-4 mb-2 flex text-sm">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">Type demande parent :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-maquette-gris"><?php echo e($typeDemande->typeDemandeParent->libelle ?? ' - '); ?></span>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <strong class="text-black font-bold">
                                Description
                            </strong>
                            <p class="shadow border p-2 text-maquette rounded-sm mb-2">
                                <?php echo e($typeDemande->description); ?>

                            </p>

                        </div>


                        <div class="flex justify-end mt-6">
                            <a href="<?php echo e(route('type_demande.edit', $typeDemande->id)); ?>" class="bg-first-orange hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">
                                Modifier
                            </a>
                        </div>

                    </div>


                </div>
            </div>


        </div>

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('manage-type-demande-documents', ['entite' => $typeDemande]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1679747723-0', $__slots ?? [], get_defined_vars());

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
<?php /**PATH /var/www/html/amie-fpt/resources/views/parametrage/type_demande/show.blade.php ENDPATH**/ ?>