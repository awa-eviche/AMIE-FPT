<div>
    <div class="flex items-centerflex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
            </svg>
              
        </div>
          <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
            Filières
          </p>
          <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            <span class="siffre" style="color:rgba(227, 142, 24, 1);">(<?php echo e($count); ?>)</span>

          </p>             
    </div>
    <div class="w-full mr-4 border bg-gray-100 border-1 shadow p-2 rounded bg-light">
        <div class="flex justify-between items-center bg-gray-100">
            <div>
                <p wire:click="resetAll" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white">Tous</p>
            </div>
                <div class="flex items-baseline my-4">
                    <label for="selectedNiveau" class="sr-only">Niveaux</label>
                    <select id="selectedNiveau" wire:model="selectedNiveau" wire:change="$refresh" name="selectedNiveau"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                        <option selected>Choisir une Niveaux</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($niveau->id); ?>"><?php echo e($niveau->nom); ?></option> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
    
                </div>
    
                <div class="flex items-baseline my-4">
                    <label for="selectedClasse" class="sr-only">Classe</label>
                    <select id="selectedClasse" wire:model="selectedClasse" wire:change="$refresh" name="selectedClasse"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                        <option selected>Choisir une Classe</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($classe->id); ?>"><?php echo e($classe->libelle); ?></option> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
                <div class="flex items-baseline my-4">
                    <label for="selectedSecteurs" class="sr-only">Secteur</label>
                    <select id="selectedSecteurs" wire:model="selectedSecteurs" wire:change="$refresh" name="selectedSecteurs"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                        <option selected>Choisir un secteur</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($secteur->id); ?>"><?php echo e($secteur->libelle); ?></option> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
            
            
        </div>
        
        <div class="p-2 w-full bg-white">
            <table class="w-full mb-3">
                <thead>
                    <tr
                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b">
                        
                        <th class="px-1 text-gray-800">filières</th>
                        <th class="px-1 text-gray-800">classes</th>
                        <th class="px-1 text-gray-800">Secteurs</th>
                        <th class="px-1 text-gray-800">Niveaux</th>
                        
                    </tr>
                </thead>
                <tbody class="bg-white divide-y ">
                        <tr class="text-gray-700 ">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $filieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                             <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($filiere->filiereName ?? ' - '); ?>

                            </td>
                             
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($filiere->nom ?? ' - '); ?>

                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($filiere->secteurName ?? ' - '); ?>

                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($filiere->niveauName ?? ' - '); ?>

                            </td>
                            
                            

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="px-2 py-2 font-bold text-xs text-center">Aucun apprenant n'est enregistré pour cette classe.</td></tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
        
    </div>
    <?php echo e($filieres->links()); ?>

</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/etablissements/get-all-filliere.blade.php ENDPATH**/ ?>