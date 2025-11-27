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
            <?php echo e(__('Créer un Type de Demande')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="bg-white shadow rounded-sm w-full p-4">
        <h2 class="font-bold text-maquette-gris text-xl">
            Edition
        </h2>
        <div class="w-full mx-auto">
            <form class="bg-white shadow-md rounded pt-6 pb-8 mb-4" action="<?php echo e(route('entreprise.update', $entreprise->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mt-5 pb-12 pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 bg-white shadow-xl w-full rounded-sm">

                    <div class="max-w-7xl sm:px-2 lg:px-4 shadow-xl">
                        <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                            Edition de l'investisseur
                        </h3>
                        <div class="border border-gray-200 p-4">
                            <?php echo method_field('PUT'); ?>
                            <div class="p-5">
                                <div class="mb-4">
                                    <label for="nom_entreprise" class="block text-gray-700 text-sm font-bold mb-2">Nom de l'entreprise</label>
                                    <input type="text" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="nom_entreprise" name="nom_entreprise" value="<?php echo e($entreprise->nom_entreprise); ?>">
                                    <?php $__errorArgs = ['nom_entreprise'];
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

                                <div class="mb-4">
                                    <label for="ninea" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">NINEA</label>
                                    <input type="text" class="border border-gray-300 p-2 w-full" id="ninea" name="ninea" value="<?php echo e($entreprise->ninea); ?>">
                                    <?php $__errorArgs = ['ninea'];
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

                                <div class="mb-4">
                                    <label for="effectif" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Effectif</label>
                                    <input type="number" class="border border-gray-300 p-2 w-full" id="effectif" name="effectif" value="<?php echo e($entreprise->effectif); ?>">
                                    <?php $__errorArgs = ['effectif'];
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

                                <div class="mb-4">
                                    <label for="email_entreprise" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Email de l'entreprise</label>
                                    <input type="email" class="border border-gray-300 p-2 w-full" id="email_entreprise" name="email_entreprise" value="<?php echo e($entreprise->email_entreprise); ?>">
                                    <?php $__errorArgs = ['email_entreprise'];
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

                                <div class="mb-4">
                                    <label for="date_creation" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Date de création</label>
                                    <input type="date" class="border border-gray-300 p-2 w-full" id="date_creation" name="date_creation" value="<?php echo e($entreprise->date_creation); ?>">
                                    <?php $__errorArgs = ['date_creation'];
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

                        </div>

                    </div>
                    <div class="max-w-7xl sm:px-2 lg:px-4 shadow-xl">
                        <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                            Information du compte
                        </h3>
                        <div class="border-gray-200 border p-4">

                            <div class="p-5">
                                <div class="mb-4">
                                    <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Prénom</label>
                                    <input type="text" class="border border-gray-300 p-2 w-full" id="prenom" name="prenom" value="<?php echo e($entreprise->user->prenom); ?>">
                                </div>
                                <div class="mb-4">
                                    <label for="nom" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Nom</label>
                                    <input type="text" class="border border-gray-300 p-2 w-full" id="nom" name="nom" value="<?php echo e($entreprise->user->nom); ?>">
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Email</label>
                                    <input type="email" class="border border-gray-300 p-2 w-full" id="email" name="email" value="<?php echo e($entreprise->user->email); ?>">
                                </div>

                                <div class="mb-4">
                                    <label for="date_naissance" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Date de naissance </label>
                                    <input type="date" class="border border-gray-300 p-2 w-full" id="date_naissance" name="date_naissance" value="<?php echo e($entreprise->user->date_naissance); ?>">
                                </div>

                                <div class="mb-4">
                                    <label for="lieu_naissance" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Lieu de naissance </label>
                                    <input type="text" class="border border-gray-300 p-2 w-full" id="lieu_naissance" name="lieu_naissance" value="<?php echo e($entreprise->user->lieu_naissance); ?>">
                                </div>

                                <div class="mb-4">
                                    <label for="adresse" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Adresse </label>
                                    <input type="text" class="border border-gray-300 p-2 w-full" id="adresse" name="adresse" value="<?php echo e($entreprise->user->adresse); ?>">
                                </div>

                                <div class="mb-4">
                                    <label for="telephone" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Téléphone </label>
                                    <input type="text" class="border border-gray-300 p-2 w-full" id="telephone" name="telephone" value="<?php echo e($entreprise->user->telephone); ?>">
                                </div>
                            </div>

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
<?php /**PATH /var/www/html/amie-fpt/resources/views/entreprises/edit.blade.php ENDPATH**/ ?>