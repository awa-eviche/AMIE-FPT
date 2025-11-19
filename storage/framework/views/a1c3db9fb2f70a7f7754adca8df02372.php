<div>
    
    <div class="w-full mr-4 border bg-gray-100 border-1 shadow p-2 rounded bg-light">
        <div class="flex w-1/5 items-center p-2 my-2 bg-white rounded-md dark:bg-darker">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                  </svg>
                  
              </div>
              <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Apprenants
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    <span class="siffre" style="color:rgba(227, 142, 24, 1);"><?php echo e($count); ?></span>&thinsp;&thinsp; &thinsp; &thinsp; <span class="prctg" style="font-size: 10px;">
      
                  </p>           
              </div>
            
        </div>
        <div class="w-1/6 flex items-center">
            <p wire:click="resetAll" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white">Tous</p>
        </div>
        <div class="flex justify-between items-center bg-gray-100">
             <div class="flex items-baseline my-2 w-full">
    <label for="selectedAnnee" class="sr-only">Année académique</label>
    <select id="selectedAnnee" wire:model="selectedAnnee" wire:change="$refresh" name="selectedAnnee"
        class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 text-sm font-bold">
        <option value="">Choisir une année académique</option>
        <!--[if BLOCK]><![endif]--><?php if($annees): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($annee->id); ?>"><?php echo e($annee->code); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </select>
</div>
        <div class="flex items-baseline my-2 w-full">
    <label for="selectedEtablissement" class="sr-only">Établissement</label>
    <select id="selectedEtablissement" wire:model="selectedEtablissement" wire:change="$refresh" 
            name="selectedEtablissement"
            class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
        <option value="">Choisir un établissement</option>
        <!--[if BLOCK]><![endif]--><?php if($etablissements): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $etablissements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etablissement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($etablissement->id); ?>"><?php echo e($etablissement->sigle ?? $etablissement->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php else: ?>
            <option value="">Aucun établissement trouvé</option>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </select>
</div>

            <div class="flex items-baseline my-2 w-full">
                <label for="selectedCommune" class="sr-only">Départemant</label>
                <select id="selectedDepartemant" wire:model="selectedDepartemant" wire:change="$refresh" name="selectedDepartemant"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir un Départemant</option>
                    <!--[if BLOCK]><![endif]--><?php if($departements): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($departement->id); ?>"><?php echo e($departement->libelle ?? ''); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <option value="">Aucun département trouvé</option>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedCommune" class="sr-only">Commune</label>
                <select id="selectedCommune" wire:model="selectedCommune" wire:change="$refresh" name="selectedCommune"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Commune</option>
                    <!--[if BLOCK]><![endif]--><?php if($communes): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $communes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commune): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($commune->id); ?>"><?php echo e($commune->libelle); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <option value="">Aucune commune trouvée</option>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            
            
        </div>
        <div class="flex justify-between items-center bg-gray-100">
            
            
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedNiveau" class="sr-only">Niveaux</label>
                <select id="selectedNiveau" wire:model="selectedNiveau" wire:change="$refresh" name="selectedNiveau"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une Niveaux</option>
                    <!--[if BLOCK]><![endif]--><?php if($niveaux): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($niveau->id); ?>"><?php echo e($niveau->nom); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <option value="">Aucun niveau trouvé</option>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>

            
            <div class="flex items-baseline my-2 w-full">
                <label for="selectedFiliere" class="sr-only">Filiere</label>
                <select id="selectedFiliere" wire:model="selectedFiliere" wire:change="$refresh" name="selectedFiliere"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option selected>Choisir une filiere</option>
                    <!--[if BLOCK]><![endif]--><?php if($filieres): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($filiere->id); ?>"><?php echo e($filiere->nom); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <option value="">Aucune filière trouvée</option>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </div>
            <div class="flex items-baseline my-2 w-full">
                
                <select wire:model="selectedsexe" name="selectedsexe" wire:change="$refresh"  class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                <option >Filtrer par sexe</option>
                <option value="M">Masculin</option>
                <option value="F">Feminin</option>
                </select>
            </div>
        </div>
        
        <div class="p-2 w-full bg-white">
            <table class="w-full mb-3">
                <thead>
                    <tr
                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b">
                        
                        <th class="px-1 text-gray-800">Identifiant</th>
                        <th class="px-1 text-gray-800">Nom et Prénoms</th>
                        <th class="px-1 text-gray-800">Commune</th>
                        <th class="px-1 text-gray-800">Etablissment</th>
                        <th class="px-1 text-gray-800">Niveau</th>
                        <th class="px-1 text-gray-800">Sexe</th>
                        
                    </tr>
                </thead>
                <tbody class="bg-white divide-y ">
                    <!--[if BLOCK]><![endif]--><?php if($apprenants): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apprenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="text-gray-700 ">
                        
                             <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($apprenant->matricule ?? ' - '); ?>

                            </td>
                          
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($apprenant->nom ?? ' - '); ?> <?php echo e($apprenant->prenom?? ' - '); ?>

                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($apprenant->commune->libelle ?? ' - '); ?>

                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                
                                <?php echo e($apprenant->etablissementSigle ?? ' - '); ?>

                            </td>
                            
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($apprenant->niveauName ?? ' - '); ?>

                            </td>
                            <td class="p-2 border-b text-gray-500 ">
                                <?php echo e($apprenant->sexe ?? ' - '); ?>

                            </td>
                            
                        
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucun apprenant trouvé</td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
        
    </div>
    <!--[if BLOCK]><![endif]--><?php if($apprenants): ?>
        <?php echo e($apprenants->links()); ?>

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/ia/getallapprenants.blade.php ENDPATH**/ ?>