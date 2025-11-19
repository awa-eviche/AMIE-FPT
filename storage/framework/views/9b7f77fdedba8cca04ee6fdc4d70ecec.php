<div>
   
    <div class="">
        
        <div class="my-4 px-4">
            <label for="indicateur" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par Annee Academique</label>
            <select wire:model="selectedClasseAnnee" name="selectedClasseAnnee" wire:change="$refresh"
                class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                <option value="">Sélectionnez une année academique</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $academiques): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($academiques->id); ?>"><?php echo e($academiques->annee1); ?>-<?php echo e($academiques->annee2); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            </select>

        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-2 xl:grid-cols-4"> 
        
        
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $indicateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicateur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a wire:click="getRealisations('<?php echo e($indicateur->id); ?>','<?php echo e($indicateur->label); ?>')" href="#" class="element_sidebar_acitf flex items-center justify-between p-2 rounded-md dark:bg-darker">
            <div>
                <h6 class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light" style="color: white;">
                <?php echo e($indicateur->label); ?>

                </h6>
                
            </div>
            <div>
                <span>
                <svg class="w-12 h-12 text-gray-300 dark:text-primary-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                </span>
            </div>
            </a>
            

                        <!-- Main modal -->
                        <div tabindex="-1" aria-hidden="true"
                            class="flex justify-center bg-slate-700 bg-opacity-25 <?php echo e($realisations?'':'hidden'); ?>  overflow-y-auto overflow-x-hidden fixed z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-4xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class=" flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <div>
                                            <h1 class="font-bold text-lg">
                                                <i class="fa-solid fa-building-circle-check" style="color:green;"></i>
                                                    <?php echo e($nameIndicateur ?? ' - '); ?>

                                            </h1>
                                        </div>
                                        <button wire:click="close" type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="show-suiviindicateur-modal'<?php echo e($indicateur->id); ?>'">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <!--[if BLOCK]><![endif]--><?php if($realisations): ?>
                                    <div class="w-full p-3 overflow-hidden rounded-lg shadow-xs p-0">
                                        <div class="text-sm w-full overflow-x-scroll p-0">
                                            <table class="w-full border-t mb-3">
                                                <thead>
                                                    <tr
                                                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b bg-first-orange">
                                                        <th class="px-4 py-4">Nom Etalissement</th>
                                                        <th class="px-4 py-4">Valeur</th>
                                                        <th class="px-4 py-4">Date Ajout</th>

                                                    </tr>
                                                </thead>

                                                <tbody class="bg-white divide-y ">
                                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $realisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $realisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                                    <tr class="text-gray-700 ">
                                                        
                                                        <td class="px-6 py-3 border-b">
                                                            <?php echo e($realisation->etablissement->nom??' - '); ?>

                                                        </td>
                                                        <td class="px-6 py-3 border-b">
                                                            <?php echo e($realisation->valeurAtteinte ?? '-'); ?>

                                                        </td>
                                                        
                                                        <td class="px-6 py-3 border-b">
                                                            <?php echo e(date('d-m-y',strtotime($realisation->created_at)) ?? '-'); ?>

                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="6" class="px-6 py-4 font-bold text-lg text-center">
                                                            Aucune donnée disponible</td>
                                                    </tr>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </tbody>
                                            </table>

                                            <?php echo e($realisations->links()); ?>

                                        </div>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!-- Modal footer -->

                                </div>
                            </div>
                        </div>
                        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        
      </div>
      <?php echo e($indicateurs->links()); ?>

    


</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/dfpt/getallindiacteurs.blade.php ENDPATH**/ ?>