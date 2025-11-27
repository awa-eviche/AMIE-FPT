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
            <?php echo e(__('Informations détaillées de la classe')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="p-4">
        <div class="bg-white shadow rounded-lg p-6">

            
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold"><?php echo e($classe->libelle); ?></h2>
                    <a href="<?php echo e(route('classe.index')); ?>" class="text-blue-600 hover:underline text-sm">
                        &larr; Retour à la liste des classes
                    </a>
                </div>
                <?php
    $user = auth()->user();
?>

<?php if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
): ?>
<div onclick="window.location='<?php echo e(route('classe.formateurs.assign', $classe->id)); ?>'"
     style="background-color:#0E7490; cursor: pointer; width: fit-content;"
     class="bg-cyan-700 text-white hover:bg-cyan-800 rounded-lg text-sm px-4 py-2 cursor-pointer" >  <i class="fa fa-user-plus"></i>
    Assigner des formateurs
</div>
<?php endif; ?> 
                <div class="flex flex-wrap gap-2 mt-3 sm:mt-0">
                    <form id="exportForm" method="GET" action="<?php echo e(route('classe.exportPdf', $classe->id)); ?>">
                        <input type="hidden" name="annee_academique_id" id="annee_academique_export">
                        <button type="button" onclick="exportPdf()"
                            class="bg-blue-700 text-white text-sm px-4 py-2 rounded hover:bg-blue-800">
                            Exporter la liste PDF
                        </button>
                    </form>

                    <?php $user = auth()->user(); ?>
                    <?php if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement')||
                    $user->hasRole('directeur_etude')): ?>
                        <button onclick="window.location='<?php echo e(route('classe.edit', $classe->id)); ?>'" style="background-color:#006D3A; cursor: pointer;"
                            class="bg-green-700 text-white text-sm px-4 py-2 rounded hover:bg-green-800 cursor-pointer">
                            Modifier
                        </button>
                        <form action="<?php echo e(route('classe.destroy', $classe->id)); ?>" method="POST"
                            onsubmit="return confirm('Supprimer cette classe ?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="border border-gray-200 rounded-lg p-5 mb-8 bg-gray-50 w-full">
    <h3 class="bg-gray-100 p-2 text-md font-bold text-orange-600 mb-4">
        Détails de la classe : <?php echo e($classe->libelle); ?>

    </h3>

    <div class="flex flex-col lg:flex-row gap-8">
       
        <div class="lg:w-1/2 w-full bg-white shadow-sm rounded-md p-4 border border-gray-100">
            <h4 class="font-bold text-lg mb-3 text-gray-800 border-b pb-2">Informations générales</h4>
            <div class="grid grid-cols-2 text-sm gap-y-2">
                <span class="text-gray-600">Établissement :</span>
                <span class="font-semibold text-gray-900"><?php echo e($classe->etablissement->nom); ?></span>

                <span class="text-gray-600">Filière :</span>
                <span class="font-semibold text-gray-900"><?php echo e($classe->niveau_etude->metier->filiere->nom); ?></span>

                <span class="text-gray-600">Métier :</span>
                <span class="font-semibold text-gray-900"><?php echo e($classe->niveau_etude->metier->nom); ?></span>

                <span class="text-gray-600">Niveau :</span>
                <span class="font-semibold text-gray-900"><?php echo e($classe->niveau_etude->nom); ?></span>

                <span class="text-gray-600">Modalité :</span>
                <span class="font-semibold text-gray-900"><?php echo e($classe->modalite); ?></span>
            </div>
        </div>

        
        <div class="lg:w-1/2 w-full bg-white shadow-sm rounded-md p-4 border border-gray-100">
            <h4 class="font-bold text-lg mb-3 text-gray-800 border-b pb-2">
                <?php echo e($classe->modalite === 'PPO' ? 'Matières au programme' : 'Compétences au programme'); ?>

            </h4>

            <div class="text-sm grid grid-cols-1 md:grid-cols-2 gap-x-6">
                <?php if($classe->modalite === 'PPO'): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center mb-1">
                            <i class="fa fa-star text-gray-400 mr-2"></i>
                            <span><strong><?php echo e($matiere->code); ?></strong> — <?php echo e($matiere->nom); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500">Aucune matière définie.</p>
                    <?php endif; ?>
                <?php elseif($classe->modalite === 'APC'): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center mb-1">
                            <i class="fa fa-check text-green-500 mr-2"></i>
                            <span><strong><?php echo e($comp->code); ?></strong> — <?php echo e($comp->nom); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500">Aucune compétence définie.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


         <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <?php
        $user = auth()->user();
    ?>

    <?php if(
        $user->hasRole('chef_de_travaux') ||
        $user->hasRole('chef_etablissement') ||
        $user->hasRole('directeur_etude') ||
        $user->hasRole('formateur')
    ): ?>
        <?php if(($classe->modalite === 'PPO' && isset($matieres)) || ($classe->modalite === 'APC' && isset($competences))): ?>
        <div class="border rounded-lg p-4 bg-white shadow-sm">
            
            
            <?php if(!$user->hasRole('formateur')): ?>
                <div class="flex justify-between items-center mb-3">
                    <div id="toggleAssignationForm"
                        class="bg-cyan-700 text-white hover:bg-cyan-800 rounded-lg text-sm px-4 py-2 cursor-pointer inline-flex items-center gap-2">
                        <i class="fa fa-user-plus"></i>
                        <?php echo e($classe->modalite === 'PPO'
                            ? 'Assigner des matières aux formateurs de la classe'
                            : 'Assigner des compétences aux formateurs de la classe'); ?>

                    </div>
                </div>

                
                <form method="POST" action="<?php echo e(route('classe.assign.store', $classe->id)); ?>" class="mb-4">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-3 gap-3 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Choisissez un formateur
                            </label>
                            <select name="formateur_id" required
                                class="w-full border-gray-300 focus:ring-first-orange focus:border-first-orange rounded-md p-2 text-sm">
                                <option value="">-- Sélectionner un formateur --</option>
                                <?php $__currentLoopData = $formateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($f->id); ?>"><?php echo e($f->prenom); ?> <?php echo e($f->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <?php echo e($classe->modalite === 'PPO' ? 'Choisissez une matière' : 'Choisissez une compétence'); ?>

                            </label>
                            <select 
                                name="<?php echo e($classe->modalite === 'PPO' ? 'matiere_id' : 'competence_id'); ?>" 
                                required
                                class="w-full border-gray-300 focus:ring-first-orange focus:border-first-orange rounded-md p-2 text-sm">
                                <option value="">
                                    -- <?php echo e($classe->modalite === 'PPO' ? 'Sélectionner une matière' : 'Sélectionner une compétence'); ?> --
                                </option>

                                <?php if($classe->modalite === 'PPO'): ?>
                                    <?php $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($m->id); ?>"><?php echo e($m->nom); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($c->id); ?>"><?php echo e($c->nom); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div>
                            <button type="submit"
                                class="bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700">
                                Assigner
                            </button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
  <?php if(session('success')): ?>
            <div class="mb-3 p-2 bg-green-100 text-green-700 rounded text-sm">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-3 p-2 bg-red-100 text-red-700 rounded text-sm">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
            
         <table class="w-full text-sm border border-gray-300 rounded-md">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-3 py-2 text-left border">Formateur</th>
            <th class="px-3 py-2 text-left border">
                <?php echo e($classe->modalite === 'PPO' ? 'Matière' : 'Compétence'); ?>

            </th>

            <?php if($classe->modalite === 'APC'): ?>
                <th class="px-3 py-2 text-left border">Éléments de compétence</th>
            <?php endif; ?>

            <th class="px-3 py-2 text-center border">Action</th>
        </tr>
    </thead>

    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $assignations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $elements = $a->elements ?? collect();
                $rowspan = max($elements->count(), 1);
            ?>

            
            <?php if($classe->modalite === 'PPO'): ?>
                <?php if(!$user->hasRole('formateur') || $user->id === $a->formateur_id): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2 border"><?php echo e($a->formateur_prenom); ?> <?php echo e($a->formateur_nom); ?></td>
                        <td class="px-3 py-2 border font-semibold text-gray-800"><?php echo e($a->matiere_nom ?? '-'); ?></td>
                        <td class="px-3 py-2 border text-center">
                            
                            <?php if(!$user->hasRole('formateur')): ?>
                                <form method="POST"
                                      action="<?php echo e(route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->matiere_id])); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                                        Supprimer
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs italic">Aucune action disponible</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>

            
            <?php elseif($classe->modalite === 'APC'): ?>

                
                <?php if($a->competence_type === 'generale' && $elements->count() > 0): ?>
                    <?php if(!$user->hasRole('formateur') || $user->id === $a->formateur_id): ?>
                        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                
                                <?php if($index === 0): ?>
                                    <td class="px-3 py-2 border align-top" rowspan="<?php echo e($rowspan); ?>">
                                        <?php echo e($a->formateur_prenom); ?> <?php echo e($a->formateur_nom); ?>

                                    </td>
                                    <td class="px-3 py-2 border align-top font-semibold text-gray-800" rowspan="<?php echo e($rowspan); ?>">
                                        <?php echo e($a->competence_nom); ?>

                                        <div class="text-xs text-gray-500">(Compétence générale)</div>
                                    </td>
                                <?php endif; ?>

                                <td class="px-3 py-2 border text-gray-800">
                                    <?php echo e($el->nom); ?>

                                </td>

                                <td class="px-3 py-2 border text-center flex justify-center items-center gap-2">
                                                                       <?php if($el->ressource && ($user->hasRole('formateur') || $user->hasRole('chef_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude'))): ?>
                                            <button onclick="openViewRessourceModal('<?php echo e($el->ressource->nom); ?>', '<?php echo e($el->nom); ?>')"
                                                    class="bg-cyan-700 text-white text-xs px-2 py-1 rounded hover:bg-cyan-700">
                                                Voir
                                            </button>  
					 <?php endif; ?>
					    <?php if($el->ressource && $user->hasRole('formateur')): ?>
                                            <button onclick="openEditRessourceModal(<?php echo e($el->ressource->id); ?>, '<?php echo e($el->ressource->nom); ?>')"
                                                    class="bg-blue-700 text-white text-xs px-2 py-1 rounded hover:bg-blue-700">
                                                Modifier
                                            </button>
                                             <?php endif; ?>
                                         <?php if(!$el->ressource && $user->hasRole('formateur')): ?>
                                            <button onclick="openRessourceModal(<?php echo e($el->id); ?>, '<?php echo e($el->nom); ?>')"
                                                    class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700">
                                                + Ressource
                                            </button>
                                        <?php endif; ?>
                                    

                                    <?php if(!$user->hasRole('formateur') && $index === 0): ?>
                                        <form method="POST" class="inline-block"
                                              action="<?php echo e(route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->competence_id])); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                                                Supprimer
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                
                <?php elseif($a->competence_type === 'particuliere'): ?>
                    <?php if(!$user->hasRole('formateur') || $user->id === $a->formateur_id): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-3 py-2 border"><?php echo e($a->formateur_prenom); ?> <?php echo e($a->formateur_nom); ?></td>
                            <td class="px-3 py-2 border font-semibold text-gray-800">
                                <?php echo e($a->competence_nom); ?>

                                <div class="text-xs text-gray-500">(Compétence particulière)</div>
                            </td>
                            <td class="px-3 py-2 border text-center text-gray-400">—</td>
                            <td class="px-3 py-2 border text-center">
                                <?php if(!$user->hasRole('formateur')): ?>
                                    <form method="POST"
                                          action="<?php echo e(route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->competence_id])); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                                            Supprimer
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
           
            <tr>
                <td colspan="4" class="text-center py-3 text-gray-500 italic">
                    Aucune assignation enregistrée.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


</div>

    <?php endif; ?>
    <?php endif; ?>
 
    
<div id="ressourceModal" class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden  hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Ajouter une ressource à <span id="elementNom" class="text-green-600"></span>
        </h3>

      

        <form method="POST" action="<?php echo e(route('ressources.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="element_competence_id" id="elementId">
             <input type=�"hidden" name="classe_id" value="<?php echo e($classe->id); ?>" >
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nom de la ressource :
            </label>
            <input type="text" name="nom" required
                   class="w-full border rounded p-2 text-sm focus:ring-green-500 focus:border-green-500"
                   placeholder="Ex :Anglais"/>

            <div class="flex justify-end mt-4 gap-2">
                <button type="button"
                        onclick="closeRessourceModal()"
                        class="bg-gray-300 px-3 py-1 rounded hover:bg-gray-400 text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
    
</div>

<div id="viewRessourceModal"
     class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden  hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">
            Ressource enregistrée
        </h2>

        <div class="space-y-2">
            <p class="text-sm text-gray-700">
                <strong>Élément de compétence :</strong>
                <span id="viewRessourceElement" class="text-gray-900 font-medium"></span>
            </p>
            <p class="text-sm text-gray-700">
                <strong>Nom de la ressource :</strong>
                <span id="viewRessourceName" class="text-green-700 font-semibold"></span>
            </p>
        </div>

        <div class="mt-5 text-right">
            <button onclick="closeViewRessourceModal()"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Fermer
            </button>
        </div>
    </div>
</div>
        <div id="editRessourceModal"
     class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden  hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Modifier la ressource
        </h2>

        <form id="editRessourceForm" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-4">
                <label for="editRessourceNom" class="block text-sm font-medium text-gray-700 mb-1">
                    Nom de la ressource
                </label>
                <input type="text" id="editRessourceNom" name="nom"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-first-orange focus:border-first-orange"
                       required>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeEditRessourceModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">
                    Annuler
                </button>
                <button type="submit"
                        class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>



                
                <div class="lg:w-full border shadow p-4 rounded bg-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl">Liste des apprenants</h3>
                                   <?php
    $user = auth()->user();
?>

<?php if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
): ?>

                        <form method="GET" action="<?php echo e(route('classe.show', $classe->id)); ?>" class="flex items-center gap-2">
                            <label for="annee_academique_id" class="text-sm font-medium">Année académique :</label>
                            <select name="annee_academique_id" id="annee_academique_id" onchange="this.form.submit()"
                                    class="rounded border-gray-300 text-sm">
                                <?php $__currentLoopData = $anneeAcademiques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($annee->id); ?>" <?php echo e(request('annee_academique_id') == $annee->id ? 'selected' : ''); ?>>
                                        <?php echo e($annee->code); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>
                    </div>

                    <div class="flex items-start gap-6 mb-6">
                        
                        <div onclick="window.location='<?php echo e(route('apprenant.create', $classe->id)); ?>'" style="background-color:#006D3A; cursor: pointer;"
                             class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-4 py-2 cursor-pointer">
                            Ajouter un apprenant
                        </div>

                      
                      <form action="<?php echo e(route('apprenant.import', ['classe' => $classe->id])); ?>"
      method="POST" enctype="multipart/form-data"
      class="bg-white p-4 rounded shadow w-full sm:w-full">
    <?php echo csrf_field(); ?>

    <div class="flex flex-col sm:flex-row items-center gap-3 w-full">
        
        <?php
            $annee = $anneeAcademiques->firstWhere('code', '2025-2026');
        ?>

        <?php if($annee): ?>
            <input type="hidden" name="annee_academique_id" value="<?php echo e($annee->id); ?>">
            <input type="hidden" value="<?php echo e($annee->code); ?>" readonly>
        <?php else: ?>
            <p class="text-red-500 text-sm">⚠️ Année 2025-2026 introuvable</p>
        <?php endif; ?>

        
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <label for="file" class="text-sm font-medium whitespace-nowrap">Fichier Excel :</label>

            <input type="file" name="file" id="file" accept=".xlsx, .xls"
                   class="rounded border-gray-300 text-sm w-full sm:w-64" required>

            <button type="submit"
                    style="background-color:#006D3A;"
                    class="text-white hover:bg-green-800 rounded-lg text-sm px-5 py-2.5 whitespace-nowrap">
                Importer des apprenants
            </button>
        </div>
    </div>
</form>
<?php endif; ?>

                    </div>

                    <hr class="mb-4">

                    
                    <table class="w-full text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2 text-left">Matricule</th>
                                <th class="px-2 py-2 text-left">Nom & Prénoms</th>
                                <th class="px-2 py-2 text-left">Date de naissance</th>
                                <th class="px-2 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            <?php $__empty_1 = true; $__currentLoopData = $usersWithEnterprises; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-2 py-2"><?php echo e($entry['user']->apprenant->matricule ?? '-'); ?></td>
                                    <td class="px-2 py-2">
                                        <?php echo e($entry['user']->apprenant->nom ?? '-'); ?>

                                        <?php echo e($entry['user']->apprenant->prenom ?? ''); ?>

                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <?php echo e(optional($entry['user']->apprenant)->date_naissance ? \Carbon\Carbon::parse($entry['user']->apprenant->date_naissance)->format('d-m-Y') : '-'); ?>

                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <a href="<?php echo e(route('inscription.show', $entry['user']->id)); ?>" class="text-green-600 hover:text-green-800">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 font-semibold text-gray-500">
                                        Aucun apprenant inscrit pour cette classe.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    
                    <div class="mt-4">
                        <?php echo e($inscriptions->appends(['annee_academique_id' => request('annee_academique_id')])->links()); ?>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function exportPdf() {
            const selectedAnnee = document.getElementById('annee_academique_id').value;
            if (!selectedAnnee) {
                alert('Veuillez sélectionner une année académique.');
                return;
            }
            document.getElementById('annee_academique_export').value = selectedAnnee;
            document.getElementById('exportForm').submit();
        }
    </script>
    <script>
function openRessourceModal(id, nom) {
    document.getElementById('elementId').value = id;
    document.getElementById('elementNom').textContent = nom;
    document.getElementById('ressourceModal').classList.remove('hidden');
}
function closeRessourceModal() {
    document.getElementById('ressourceModal').classList.add('hidden');
}
</script>
<script>
    function openViewRessourceModal(nomRessource, nomElement) {
        document.getElementById('viewRessourceModal').classList.remove('hidden');
        document.getElementById('viewRessourceElement').textContent = nomElement;
        document.getElementById('viewRessourceName').textContent = nomRessource;
    }

    function closeViewRessourceModal() {
        document.getElementById('viewRessourceModal').classList.add('hidden');
    }
</script>
<script>
    // Ouvrir le modal prérempli
    function openEditRessourceModal(id, nom) {
        const modal = document.getElementById('editRessourceModal');
        const form = document.getElementById('editRessourceForm');
        const inputNom = document.getElementById('editRessourceNom');

        form.action = `/ressources/${id}`; // ✅ route update dynamique
        inputNom.value = nom;

        modal.classList.remove('hidden');
    }

    // Fermer le modal
    function closeEditRessourceModal() {
        document.getElementById('editRessourceModal').classList.add('hidden');
    }
</script>
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
<?php /**PATH /var/www/html/amie-fpt/resources/views/classe/show.blade.php ENDPATH**/ ?>