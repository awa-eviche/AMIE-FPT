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
            <?php echo e(__('Détails du niveau')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div>
    <div class="max-w-10xl mx-auto">
    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="<?php echo e(route('niveauetude.index')); ?>"  class="text-maquette">Accueil</a>
              <span class="mx-2 text-maquette">/</span>
            <a href="<?php echo e(route('niveauetude.index')); ?>"  class="text-maquette">Référentiel</a>
              <span class="mx-2 text-maquette">/</span>
        <p> <a href="<?php echo e(route('niveauetude.index')); ?>" >Niveau d'Etude  </a>
            
            <span class="mx-2 text-maquette">/</span>
        </p>

        <p class="text-first-orange">Détail du Niveau d'Etude</p>
        </p>
      
    </div>
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="w-full mx-auto max-w-6xl">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
            <div class="border border-gray-200">
             <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                Détails du Niveau d'Etude
                                <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1"
                        href="<?php echo e(route('niveauetude.edit', $niveauetude->id)); ?>" style='position:relative;left: 77%;'>
                        Modifier
                    </a>
                            </h3>
                </div>
                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>Code du niveau : </span>
                        <span>
                            <b><?php echo e($niveauetude->code ?? ' - '); ?></b>
                        </span>
                    </div>
                    <div>
                        <span>Libellé du niveau : </span>
                        <span>
                            <b><?php echo e($niveauetude->nom ?? ' -'); ?></b>
                        </span>
                    </div>
                </div>
                <br>
                       <div>
                        <span>Description du niveau : </span>
                        <span>
                            <b><?php echo e($niveauetude->description ?? ' -'); ?></b>
                        </span>
                    </div>
            </div>
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
<?php /**PATH /var/www/html/amie-fpt/resources/views/parametrage/niveauetude/show.blade.php ENDPATH**/ ?>