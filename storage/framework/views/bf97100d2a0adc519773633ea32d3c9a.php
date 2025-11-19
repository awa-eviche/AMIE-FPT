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
            <?php echo e(__('Ajouter un critère')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="bg-transparent shadow rounded-sm w-full p-4">

        <div class="mt-2 mb-2">
            <a href="<?php echo e(route('critere.index')); ?>" class="text-blue-500 hover:underline">&larr; Retour à la liste des seuil de réussite</a>
        </div>
        <div class="w-full mx-auto">
            <form class="bg-white pt-6 pb-8 mb-4" action="<?php echo e(route('critere.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="md:container md:mx-auto">

                    <div class="w-full sm:px-2 lg:px-4 ">
                        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
                            <p>
                                <a href="/dashboard" class="text-maquette-black">Accueil</a>
                                  <span class="mx-2 text-maquette-gris">/</span>
                            </p><p> <a href="<?php echo e(route('critere.index')); ?>"> Seuil de réussite</a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p class="text-first-orange">Ajouter</p>
                            <p></p>
                        </div>
                        <div class="border border-gray-200">
                            <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                Formulaire d'ajout
                            </h3>
                            <div class="p-5">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('param.CreateCritere');

$__html = app('livewire')->mount($__name, $__params, 'lw-2075782575-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <!--div class="mb-4">
                                        <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code<span class="text-red-600 mx-2">*</span></label>
                                        <input type="text" value="<?php echo e(old('code') ?? ''); ?>" required class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="code" name="code" >
                                        <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <?php echo e($message); ?>

                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div-->
                                    <div class="mb-4">
                                        <label for="libelle" class="block text-gray-700 text-sm font-bold mb-2">Seuil de Reussite<span class="text-red-600 mx-2">*</span></label>
                                        <input type="text" value="<?php echo e(old('libelle') ?? ''); ?>" required class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="libelle" name="libelle" >
                                        <?php $__errorArgs = ['libelle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <?php echo e($message); ?>

                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <!--div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                        <textarea class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" name="description" id="description" cols="10" rows="5"></textarea>
                                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <?php echo e($message); ?>

                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div-->
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
<?php /**PATH /var/www/html/pgi/resources/views/criteres/create.blade.php ENDPATH**/ ?>