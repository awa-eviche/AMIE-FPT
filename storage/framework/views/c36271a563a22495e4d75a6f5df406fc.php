<div>
    <form class="bg-white pt-6 pb-8 mb-4" action="<?php echo e(route('indicateur.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
                    <div class="border border-gray-200">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Creation d'un nouveau indicateur

                    </h3>
                    <div class="p-5">


                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-4">
                                <label for="typeindicateur_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Type d'indicateur</label>
                                    <select id="typeindicateur_id"  class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="typeindicateur_id" name="typeIndicateur_id" required  id="typeindicateur_id">
                                    <option value="">Sélectionnez un type indicateur</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $typeIndicateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->libelle); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['libelle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <?php echo e($message); ?>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="mb-4">
                                <label for="libelle"class="block text-gray-700 text-sm font-bold mb-2">Année academique</label>
                                <select id="annee_academiques_id"  class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="annee_academiques_id" name="anneeAcademique_id" required  id="annee_academiques_id">
                                    <option value="">Sélectionnez une année academique</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $academiques): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($academiques->id); ?>"><?php echo e($academiques->annee1); ?>-<?php echo e($academiques->annee2); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['annee_academiques_id '];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <?php echo e($message); ?>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-4">
                                <label for="libelle" class="block text-gray-700 text-sm font-bold mb-2">Libellé</label>
                                <input value="<?php echo e(old('libelle') ?? ''); ?>" type="text"
                                    class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                    id="libelle" name="libelle">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['libelle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <?php echo e($message); ?>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="mb-4">
                                <label for="date_echeance"class="block text-gray-700 text-sm font-bold mb-2">Date Echéance</label>
                                
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                        </div>
                                        <input datepicker name="date_echeance" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="choisir une date d'échéance">
                                    </div>
  
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date_echeance '];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <?php echo e($message); ?>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">



                        <div class="mb-4 flex items-center">
                            <input checked id="checked-checkbox" name="public" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Visible au niveau du dashbord</label>
                        </div>







                </div>

            </div>
            <div class="w-full sm:px-2 lg:px-4 py-4">

                <button type="submit"
                class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>

            </div>
           </div>
    </form>
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/indicateur/create-indicateur.blade.php ENDPATH**/ ?>