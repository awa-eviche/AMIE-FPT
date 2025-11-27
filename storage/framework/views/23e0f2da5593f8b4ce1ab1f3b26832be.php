<div>
       <?php if(session('success')): ?>
    <div class="mb-4">
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm dark:bg-gray-800 dark:text-green-300 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2A1 1 0 1 1 7.707 9.293L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <span class="sr-only">Success</span>
            <div>
                <span class="font-medium">Succès !</span> <?php echo e(session('success')); ?>

            </div>
        </div>
    </div>
<?php endif; ?>
    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-black text-xl py-4">
                <?php echo e($currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée'); ?>

            </h2>
        </div>

        <div class="mb-4 flex gap-4">
            <!-- Classe -->
            <div>
                <label for="classe" class="block text-sm font-medium">Classe :</label>
                <select wire:model="classe" wire:change="$refresh" id="classe" class="rounded border-gray-300 text-sm">
                    <option value="">-- Choisir une classe ftp --</option>
                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cl->id); ?>"><?php echo e($cl->libelle); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label for="annee_academique_id" class="block text-sm font-medium">Année académique :</label>
                <select wire:model="annee_academique_id" wire:change="$refresh" id="annee_academique_id"
                    class="rounded border-gray-300 text-sm">
                    <option value="">-- Toutes les années --</option>
                    <?php $__currentLoopData = \App\Models\AnneeAcademique::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($annee->id); ?>"><?php echo e($annee->code); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>

    <?php if($currentClasse): ?>
        <!-- Informations classe -->
        <div class="py-2 px-4 m-2 shadow bg-vert2 border border-black rounded-md">
            <div class="grid sm:grid-cols-3 gap-2 py-2 text-md">
                <div><span class="text-gray-800">Année Scolaire :</span> <span
                        class="font-bold"><?php echo e($anneeAcademiqueLabel ?? 'N/A'); ?></span></div>
                <div><span class="text-gray-800">Centre de ressources :</span>
                    <span class="font-bold"><?php echo e($currentClasse->etablissement->nom); ?></span>
                </div>
                <div><span class="text-gray-800">Filière :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->filiere->nom); ?></span>
                </div>
                <div><span class="text-gray-800">Métier :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->nom); ?></span>
                </div>
                <div><span class="text-gray-800">Niveau d'études :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->nom); ?></span>
                </div>
                <div><span class="text-gray-800">Nombre apprenants :</span>
                    <span class="font-bold"><?php echo e($nombreApprenants); ?></span>
                </div>
            </div>
        </div>


                <?php
    $user = auth()->user();
?>
         <?php if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude')): ?>
 <div class="flex flex-col sm:flex-row items-center gap-4 px-4 pb-4">
    <form method="GET" action="<?php echo e(route('classe.bulletins.pdf', $currentClasse->id)); ?>" target="_blank" class="flex items-center gap-2">
        <select name="semestre" class="rounded border-gray-300 text-sm">
            <option value="">Tous les semestres</option>
            <option value="1">Premier semestre</option>
            <option value="2">Deuxième semestre</option>
        </select>

        <button type="submit"
            class="text-white bg-red-800 text-sm rounded-md shadow-md px-4 py-2 hover:bg-red-700">
            <i class="fa fa-file-pdf"></i>&nbsp;Télécharger les bulletins de la classe (PDF)
        </button>
    </form>
</div>
<?php endif; ?>


        
        <div class="w-full sm:px-2 lg:px-4">
            <div class="flex flex-col sm:flex-row py-2 gap-4">

    
                <div class="sm:w-1/2 p-4 border bg-gray border shadow rounded" style="min-height:50vh">
                    <h2 class="font-bold text-xl mb-4">Liste des apprenants (<?php echo e(sizeof($apprenants)); ?>)</h2>
                    <hr class="mb-2">
                    <div class="text-sm w-full overflow-x-auto">
                        <table class="w-full border-t mb-3">
                            <thead>
                                <tr class="text-xs font-black tracking-wide text-left text-maquette-gris border-b">
                                    <th class="p-2 text-gray-800">Matricule</th>
                                    <th class="p-2 text-gray-800">Nom Prénoms</th>
                                    <th class="p-2 text-gray-800 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                <?php $__empty_1 = true; $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr
                                        class="text-gray-700 <?php echo e($selectedApprenant == $inscription->id ? 'bg-green-600 text-white' : ''); ?>">
                                        <td wire:click="loadCompetences(<?php echo e($inscription->id); ?>)"
                                            class="px-2 font-bold cursor-pointer">
                                            <i class="fa fa-caret-right"></i>
                                            <?php echo e($inscription->apprenant->matricule ?? '-'); ?>

                                        </td>
                                        <td class="px-2">
                                            <?php echo e($inscription->apprenant->nom . ' ' . ($inscription->apprenant->prenom ?? '-')); ?>

                                        </td>
                                        <td class="px-2 text-center">
                                            <a href="#" wire:click="loadCompetences(<?php echo e($inscription->id); ?>)"
                                                class="text-green-700 hover:text-blue-900">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="px-2 font-bold text-xs text-center">
                                            Aucun apprenant n'est enregistré pour cette classe.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if($selectedApprenant): ?>
                    <div class="sm:w-1/2 p-4 border bg-gray-100 rounded border shadow">
                        <h2 class="font-bold text-xl mb-4">
                            Liste des compétences de
                            <?php echo e($currentApprenant->apprenant->matricule); ?>

                            <?php echo e($currentApprenant->apprenant->nom); ?>

                            <?php echo e($currentApprenant->apprenant->prenom); ?>

                        </h2>
                        <hr class="mb-2">
                        <div class="flex justify-between items-center mb-3">
                            <select wire:model="filtre" wire:change="$refresh"
                                class="border border-gray-300 p-2 w-1/2 rounded text-sm">
                                <option value="">Filtrer par compétence</option>
                                <?php $__currentLoopData = $filtres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($comp->id); ?>"><?php echo e($comp->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            
                     <?php
    $user = auth()->user();
?>

<?php if($user->hasRole('formateur')): ?>
    
    <a href="<?php echo e(route('evaluate.create', $currentApprenant->id)); ?>"
       class="text-white bg-blue-600 text-sm rounded-md shadow-md px-4 py-2 hover:bg-blue-700">
        <i class="fa fa-edit"></i>&nbsp;Évaluer
    </a>

<?php elseif($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude')): ?>

    
    <a href="<?php echo e(route('evaluate.create', $currentApprenant->id)); ?>"
       class="text-white bg-blue-600 text-sm rounded-md shadow-md px-4 py-2 hover:bg-green-700">
        <i class="fa fa-eye"></i>&nbsp;Voir les notes
    </a>
<?php endif; ?>

                        </div>

                        <!-- Sélection semestre -->
                        <div class="flex items-center justify-end mb-3">
                            <label for="selectedsemestre1" class="text-sm font-bold text-gray-700 mr-2">Semestre :</label>
                            <select wire:model.live="selectedsemestre1" id="selectedsemestre1" name="semestre"
                                class="border border-gray-300 rounded shadow-sm text-sm">
                                <option value="">Tous les semestres</option>
                                <option value="1">Premier semestre</option>
                                <option value="2">Deuxième semestre</option>
                            </select>                      
                <?php
    $user = auth()->user();
?>
         <?php if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude')): ?>
                              <a class="text-white bg-red-800 text-sm rounded-md shadow-md px-4 py-1" target="_blank" href="<?php echo e(route('competence.generate.pdf',$currentApprenant->id)); ?>">
                            <i class="fa fa-file-pdf"></i>&nbsp;Télecharger le Bulletin
                        </a>
<?php endif; ?>
                        </div>
                         <?php if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
): ?>
        <button type="button"
    onclick="openAbsenceModal()"
    class="text-white bg-green-600 text-sm rounded-md shadow-md px-4 py-2 hover:bg-green-700">
    <i class="fa fa-plus-circle"></i>&nbsp;Ajouter une absence
</button>
<div id="absenceModal"
    class="hidden fixed inset-0 z-50 bg-white/70 backdrop-blur-sm flex justify-center items-center p-4 transition duration-300 ease-in-out">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg relative">
        <div class="flex justify-between items-center border-b px-4 py-2 bg-black bg-opacity-25 hidden  hidden overflow-y-auto ">
            <h2 class="text-lg font-bold text-gray-800">Ajouter une absence</h2>
            <button onclick="closeAbsenceModal()" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        </div>
  <h4 class="font-bold text-xl mb-4">
                                Gestion des absences de <?php echo e($currentApprenant->apprenant->prenom); ?> <?php echo e($currentApprenant->apprenant->nom); ?> 
                            </h4>
        <form method="POST" action="<?php echo e(route('absences.store')); ?>" class="p-6">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="inscription_id" value="<?php echo e($currentApprenant->id ?? ''); ?>">

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date_absence" class="w-full border rounded p-2" required>
            </div>
 <div class="mb-3">
                <label for="semestre" class="block text-sm font-medium text-gray-700">Semestre</label>
                <select name="semestre" id="semestre" class="w-full border rounded p-2" required>
                    <option value="">-- Sélectionnez le semestre --</option>
                    <option value="1">Premier semestre</option>
                    <option value="2">Deuxième semestre</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Type</label>
                <select name="type" id="typeAbsence" class="w-full border rounded p-2">
                    <option value="">Selectionner un type</option>
                    <option value="absence">Absence</option>
                    <option value="retard">Retard</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-sm font-medium">Heure début</label>
                    <input type="time" name="heure_debut" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Heure fin</label>
                    <input type="time" name="heure_fin" class="w-full border rounded p-2">
                </div>
            </div>

            <div id="minutesRetardDiv" class="mb-3 hidden">
                <label class="block text-sm font-medium">Minutes de retard (si applicable)</label>
                <input type="number" name="minutes_retard" min="0" class="w-full border rounded p-2">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Motif</label>
                <textarea name="motif" rows="3" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="flex items-center gap-2 mb-4">
                <input type="checkbox" name="justifie" value="1" id="justifie">
                <label for="justifie" class="text-sm font-medium">Justifiée</label>
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeAbsenceModal()"
                    class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 rounded-md ms-2">
                    Annuler
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fa fa-save"></i>&nbsp;Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<button type="button"
    onclick="openAbsencesListModal()"
    class="text-white bg-blue-700 text-sm rounded-md shadow-md px-4 py-2 hover:bg-blue-800">
    <i class="fa fa-eye"></i>&nbsp;Voir les absences et retards
</button>

<div id="absencesListModal"
    class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex justify-center items-center p-4 transition duration-300 ease-in-out">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl relative">
        
        <div class="flex justify-between items-center border-b px-4 py-3 bg-gray-100 rounded-t-lg">
            <h2 class="text-lg font-bold text-gray-800">
                Absences et retards — 
                <span class="text-green-700">
                    <?php echo e($currentApprenant->apprenant->nom ?? ''); ?> <?php echo e($currentApprenant->apprenant->prenom ?? ''); ?>

                </span>
            </h2>
            <button onclick="closeAbsencesListModal()"
                class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
        </div>

        <!-- Contenu -->
        <div class="p-5 max-h-[75vh] overflow-y-auto">
           <?php if(!empty($absences)): ?>

                <div class="overflow-x-auto border rounded-md shadow">
                    <table class="min-w-full text-sm">
                        <thead class="bg-green-700 text-black uppercase text-xs">
                            <tr>
                                <th class="px-3 py-2 border">Date</th>
                                <th class="px-3 py-2 border">Semestre</th>
                                <th class="px-3 py-2 border">Type</th>
                                <th class="px-3 py-2 border">Heure début</th>
                                <th class="px-3 py-2 border">Heure fin</th>
                                <th class="px-3 py-2 border">Durée / Retard</th>
                                <th class="px-3 py-2 border">Justifiée</th>
                                <th class="px-3 py-2 border">Motif</th>
                                <th class="px-3 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php $__currentLoopData = $absences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 border"><?php echo e(\Carbon\Carbon::parse($abs->date_absence)->format('d/m/Y')); ?></td>
                                    <td class="px-3 py-2 border text-center"><?php echo e($abs->semestre ?? '-'); ?></td>
                                    <td class="px-3 py-2 border text-center">
                                        <?php if($abs->type === 'retard'): ?>
                                            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Retard</span>
                                        <?php else: ?>
                                            <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs font-semibold">Absence</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-3 py-2 border text-center"><?php echo e($abs->heure_debut ?? '-'); ?></td>
                                    <td class="px-3 py-2 border text-center"><?php echo e($abs->heure_fin ?? '-'); ?></td>
                                    <td class="px-3 py-2 border text-center">
                                        <?php if($abs->minutes_retard): ?>
                                            <?php echo e($abs->minutes_retard); ?> min
                                        <?php elseif($abs->duree): ?>
                                            <?php echo e($abs->duree); ?> h
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-3 py-2 border text-center">
                                        <?php if($abs->justifie): ?>
                                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-xs font-semibold">Oui</span>
                                        <?php else: ?>
                                            <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs">Non</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-3 py-2 border"><?php echo e($abs->motif ?? '-'); ?></td>
    <td class="px-3 py-2 border text-center">
    <button 
        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs shadow"
        onclick="openEditAbsenceModal(<?php echo e($abs->id); ?>, '<?php echo e($abs->date_absence); ?>', '<?php echo e($abs->semestre); ?>', '<?php echo e($abs->type); ?>', '<?php echo e($abs->heure_debut); ?>', '<?php echo e($abs->heure_fin); ?>', '<?php echo e($abs->minutes_retard); ?>', '<?php echo e($abs->motif); ?>', <?php echo e($abs->justifie ? 1 : 0); ?>)">
        <i class="fa fa-edit"></i> Modifier
    </button>
    
</td>


                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center text-gray-600 italic py-6">
                    Aucune absence ou retard enregistré pour cet apprenant.
                </div>
            <?php endif; ?>
        </div>

        <!-- Pied du modal -->
        <div class="flex justify-end border-t p-4 bg-gray-50 rounded-b-lg">
            <button onclick="closeAbsencesListModal()"
                class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Fermer
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<div id="editAbsenceModal" class="hidden fixed inset-0 bg-white bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 p-5">
        <h3 class="text-lg font-bold mb-4 text-gray-700">Modifier l'absence</h3>

        <form id="editAbsenceForm" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <input type="hidden" id="absenceId">

            <div class="mb-3">
                <label class="text-sm font-semibold text-gray-700">Date de l'absence</label>
                <input type="date" id="edit_date_absence" name="date_absence"
                       class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
            </div>

            <div class="mb-3">
                <label class="text-sm font-semibold text-gray-700">Semestre</label>
                <input type="text" id="edit_semestre" name="semestre"
                       class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
            </div>

            <div class="mb-3">
                <label class="text-sm font-semibold text-gray-700">Type</label>
                <select id="edit_type" name="type"
                        class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
                    <option value="absence">Absence</option>
                    <option value="retard">Retard</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Heure début</label>
                    <input type="time" id="edit_heure_debut" name="heure_debut"
                           class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Heure fin</label>
                    <input type="time" id="edit_heure_fin" name="heure_fin"
                           class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
                </div>
            </div>

            <div class="mb-3">
                <label class="text-sm font-semibold text-gray-700">Minutes de retard</label>
                <input type="number" id="edit_minutes_retard" name="minutes_retard"
                       class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
            </div>

            <div class="mb-3">
                <label class="text-sm font-semibold text-gray-700">Motif</label>
                <textarea id="edit_motif" name="motif"
                          class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600"
                          rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label class="text-sm font-semibold text-gray-700">Justifiée ?</label>
                <select id="edit_justifie" name="justifie"
                        class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>

            <div class="flex justify-end mt-4 space-x-2 border-t pt-4">
                <button type="button" onclick="closeEditAbsenceModal()"
                        class="bg-gray-300 px-3 py-2 rounded text-gray-800 hover:bg-gray-400">
                    Annuler
                </button>
                <button type="submit"
                        class="bg-green-600 px-3 py-2 rounded text-white hover:bg-green-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>


                       
                        <?php if($competences && $competences->count() > 0): ?> 
    <div class="overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead class="bg-green-600 text-white uppercase">
                <tr>
                    <th class="px-4 py-2 border text-center">COMPÉTENCE</th>
                    <th class="px-4 py-2 border text-center">ÉLÉMENT DE COMPÉTENCE</th>
                    <th class="px-4 py-2 border text-center">Seuil de reussite</th>

                    
                    
                    <th class="px-4 py-2 border text-center">ACQUIS</th>
                    <th class="px-4 py-2 border text-center">NON ACQUIS</th>

                    <th class="px-4 py-2 border text-center">DATE</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y">
                <?php $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php
                        if ($filtre && $comp->id != $filtre) continue;
                        $totalCriteres = $comp->elementCompetences->sum(fn($el) => $el->criteres->count());
                        $rowspan = max($totalCriteres, 1);
                        $firstRow = true;
                    ?>

                    <?php $__currentLoopData = $comp->elementCompetences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $el->criteres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $eval = $evaluations[$crit->id] ?? null;
                                $acquis = $eval['acquis'] ?? null;
                                $nonAcquis = $eval['nonAcquis'] ?? null;
                            ?>

                            <tr>
                                <?php if($firstRow): ?>
                                    <td rowspan="<?php echo e($rowspan); ?>"
                                        class="px-4 py-2 border font-semibold bg-gray-50 align-top">
                                        <?php echo e($comp->nom); ?>

                                    </td>
                                    <?php $firstRow = false; ?>
                                <?php endif; ?>

                                <td class="px-4 py-2 border"><?php echo e($el->nom); ?></td>
                                <td class="px-4 py-2 border text-center"><?php echo e($crit->libelle); ?></td>

                                
                                <td class="px-4 py-2 border text-center font-bold <?php echo e($acquis ? 'text-green-600' : 'text-gray-500'); ?>">
                                    <?php echo e($acquis ? '✔' : '-'); ?>

                                </td>

                                
                                <td class="px-4 py-2 border text-center font-bold <?php echo e($nonAcquis ? 'text-red-600' : 'text-gray-500'); ?>">
                                    <?php echo e($nonAcquis ? '✘' : '-'); ?>

                                </td>

                                <td class="px-4 py-2 border text-center">
                                    <?php echo e($eval['date'] ?? '-'); ?>

                                </td>
                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

<?php else: ?>
    <div class="text-center py-4 text-gray-500">
        Aucune compétence assignée ou évaluation disponible.
    </div>
<?php endif; ?>

                    </div>
                <?php else: ?>
                    <div class="sm:w-1/2 p-4 border bg-gray-100 rounded border shadow text-center">
                        <span class="text-red-600 text-lg">Aucun apprenant sélectionné !</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert bg-orange-100 flex p-4 rounded mt-4 p-10 m-10 justify-center items-center">
            <h3 class="text-2xl text-gray-700">
                Veuillez sélectionner une classe et une année académique !
            </h3>
        </div>
    <?php endif; ?>
</div>
<script>
    function openAbsenceModal() {
        document.getElementById('absenceModal').classList.remove('hidden');
    }

    function closeAbsenceModal() {
        document.getElementById('absenceModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const typeSelect = document.getElementById('typeAbsence');
        const retardDiv = document.getElementById('minutesRetardDiv');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'retard') {
                retardDiv.classList.remove('hidden');
            } else {
                retardDiv.classList.add('hidden');
            }
        });
    });
</script>
<script>
    function openAbsencesListModal() {
        const modal = document.getElementById('absencesListModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeAbsencesListModal() {
        const modal = document.getElementById('absencesListModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
<script>
    // 🔹 Fonction pour ouvrir le modal et pré-remplir les champs
    function openEditAbsenceModal(id, date, semestre, type, heureDebut, heureFin, minutesRetard, motif, justifie) {
        // Afficher le modal
        document.getElementById('editAbsenceModal').classList.remove('hidden');

        // Remplir les champs
        document.getElementById('absenceId').value = id;
        document.getElementById('edit_date_absence').value = date;
        document.getElementById('edit_semestre').value = semestre;
        document.getElementById('edit_type').value = type;
        document.getElementById('edit_heure_debut').value = heureDebut || '';
        document.getElementById('edit_heure_fin').value = heureFin || '';
        document.getElementById('edit_minutes_retard').value = minutesRetard || '';
        document.getElementById('edit_motif').value = motif || '';
        document.getElementById('edit_justifie').value = justifie;

        // Définir dynamiquement l’action du formulaire
        const form = document.getElementById('editAbsenceForm');
        form.action = `/absences/${id}`;
    }

    // 🔹 Fermer le modal
    function closeEditAbsenceModal() {
        document.getElementById('editAbsenceModal').classList.add('hidden');
    }

    // 🔹 Fermer le modal quand on clique en dehors de la boîte
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('editAbsenceModal');
        if (event.target === modal) {
            closeEditAbsenceModal();
        }
    });
</script>
<?php /**PATH /var/www/html/amie-fpt/resources/views/livewire/param/classe-switch.blade.php ENDPATH**/ ?>