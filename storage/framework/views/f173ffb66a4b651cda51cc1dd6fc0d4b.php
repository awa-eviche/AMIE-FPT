<div>


    <!--[if BLOCK]><![endif]--><?php if(session('success')): ?>
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
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->



    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-gris text-xl py-4">
                <?php echo e($currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée'); ?>

            </h2>
        </div>
        <div class="flex gap-4 items-center px-4">
            <!-- Select Classe -->
            <select wire:model="classe" wire:change="$refresh" class="border border-gray-300 p-2 rounded text-sm w-1/2">
                <option value="">Sélectionner la classe</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>

            <!-- Select Année académique -->
            <select wire:model="anneeAcademique" wire:change="$refresh" class="border border-gray-300 p-2 rounded text-sm w-1/2">
                <option value="">Sélectionner l’année académique</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $anneeAcademiques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($a->id); ?>"><?php echo e($a->code); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>
    </div>

    <!--[if BLOCK]><![endif]--><?php if($currentClasse): ?>
        <div class="py-2 px-4 m-2 shadow bg-vert2 rounded shadow border border-black">
            <div class="grid grid-cols-3 gap-2 py-2 text-md">
                <div class="flex items-center">
                    <span class="text-gray-800">Année Scolaire :</span>
                    <span class="font-bold"><?php echo e($anneeAcademiqueLabel ?? 'N/A'); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Filière :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->filiere->nom); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Métier :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->nom); ?></span>
                    &nbsp;&nbsp;&nbsp;
                    <span class="text-gray-800">Modalité :</span>
                    <span class="font-bold"><?php echo e($currentClasse->modalite); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Niveau d'études :</span>
                    <span class="font-bold"><?php echo e($currentClasse->niveau_etude->nom); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">État classe :</span>
                    <span class="font-bold">
                        <?php echo e(strval($currentClasse->statut) == "" ? 'Non Validé' : (!($currentClasse->etat_classe) ? 'Validé' : 'Lancé')); ?>

                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Nombre apprenants :</span>
                    <span class="font-bold"><?php echo e(count($apprenants)); ?></span>
                </div>
            </div>
        </div>
        <br />
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="w-full sm:px-2 lg:px-4">
        <div class="">
            <!--[if BLOCK]><![endif]--><?php if($currentClasse): ?>
                <div class="flex py-2">
                    <div class="w-1/2 me-2 p-4 border bg-gray border shadow rounded" style="min-height:50vh">
                        <h2 class="font-bold text-xl mb-4">Liste des apprenants</h2>
                        <hr class="w-50">
                        <div class="py-2 ">
                            <table class="w-full mb-3">
                                <tbody class="bg-white divide-y ">
                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apprenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="text-gray-700 <?php echo e(($selectedApprenant == $apprenant->id) ? 'bg-green-600' : ''); ?>">
                                            <td wire:click="loadCompetences(<?php echo e($apprenant->id); ?>)"
                                                class="pt px-2 font-bold border-b <?php echo e(($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-600'); ?>">
                                                <i class="fa fa-caret-right"></i>
                                                <?php echo e($apprenant->apprenant->user->matricule ?? '-'); ?>

                                            </td>
                                            <td class="px-2 border-b <?php echo e(($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-500'); ?>">
                                                <?php echo e(($apprenant->apprenant->nom.' '.$apprenant->apprenant->prenom) ?? '-'); ?>

                                            </td>
                                            <td class="px-2 text-center border-b <?php echo e(($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-500'); ?>">
                                                <a href="#" wire:click="loadCompetences(<?php echo e($apprenant->id); ?>)" class="text-green-600">
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
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($selectedApprenant): ?>
                    <?php
    $user = auth()->user();
    $personnel = $user?->personnel;
    $isFormateurAssigné = false;

    if ($personnel && $currentClasse) {
        $isFormateurAssigné = \Illuminate\Support\Facades\DB::table('formateur_etablissement')
            ->where('classe_id', $currentClasse->id)
            ->where('personnel_etablissement_id', $personnel->id)
            ->exists();
    }
?>


                        <div class="w-1/2 p-4 border bg-gray-100 rounded border shadow">
                            <h2 class="font-bold text-xl mb-4">
                                Liste des matières et détails d'évaluation <?php echo e($currentApprenant->apprenant->matricule); ?>

                                <?php echo e($currentApprenant->apprenant->nom); ?> <?php echo e($currentApprenant->apprenant->prenom); ?>

                            </h2>
                            <hr class="w-50">
                            <div class="mt-4 flex gap-4 ">
                            <?php
    $user = auth()->user();
?>

<!--[if BLOCK]><![endif]--><?php if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
): ?>
                                <a class="text-white bg-green-600 text-sm rounded-md shadow-md px-2 py-2"
                                   target="_blank" href="<?php echo e(route('evaluation.pdf', $currentApprenant->id)); ?>">
                                    <i class="fa fa-file-pdf"></i>&nbsp;Télécharger le bulletin
                                </a>

                               <a href="<?php echo e(route('evaluation.classe.preview', ['id' => $currentClasse->id, 'semestre' => $selectedsemestre ?: 1])); ?>"
   target="_blank"
   class="bg-green-600 text-white px-2 py-2 rounded-md shadow hover:bg-green-700">
   <i class="fa fa-print"></i> Imprimer les bulletins de la classe
</a>




                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="flex items-center justify-end">
                                    <label for="selectedsemestre" class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
                                    <select wire:model="selectedsemestre" id="selectedsemestre" name="semestre"
                                            class="block w-auto border border-gray-300 rounded shadow-sm focus:border-first-orange enlever_shadow text-sm"
                                            wire:change="$refresh">
                                        <option value="">Tous les semestres</option>
                                        <option value="1">Premier semestre</option>
                                        <option value="2">Deuxième semestre</option>
                                    </select>

                                </div>
                            <?php
    $user = auth()->user();
?>
     <!--[if BLOCK]><![endif]--><?php if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
): ?>
   <button type="button"
    onclick="openAbsenceModal()"
    class="text-white bg-green-600 text-sm rounded-md shadow-md px-2 py-2 hover:bg-green-700">
    <i class="fa fa-plus-circle"></i>&nbsp;Ajouter une absence
</button>
<div id="absenceModal"
    class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden  hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg relative">
        <div class="flex justify-between items-center border-b px-4 py-2 bg-black bg-opacity-25 hidden  hidden overflow-y-auto ">
            <h2 class="text-lg font-bold text-gray-800">Ajouter une absence</h2>
            <button onclick="closeAbsenceModal()" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        </div>
  <h4 class="font-bold text-xl mb-4">
                                Gestion des absences de     <?php echo e($currentApprenant->apprenant->prenom); ?> <?php echo e($currentApprenant->apprenant->nom); ?> 
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
                    class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 rounded-md mr-2">
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
    class="text-white bg-blue-700 text-sm rounded-md shadow-md px-2 py-2 hover:bg-blue-800">
    <i class="fa fa-eye"></i>&nbsp;Voir les absences et retards
</button>

<div id="absencesListModal"
    class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex justify-center items-center p-4 transition duration-300 ease-in-out">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl relative">
        <!-- En-tête -->
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
           <!--[if BLOCK]><![endif]--><?php if(!empty($absences)): ?>

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
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $absences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 border"><?php echo e(\Carbon\Carbon::parse($abs->date_absence)->format('d/m/Y')); ?></td>
                                    <td class="px-3 py-2 border text-center"><?php echo e($abs->semestre ?? '-'); ?></td>
                                    <td class="px-3 py-2 border text-center">
                                        <!--[if BLOCK]><![endif]--><?php if($abs->type === 'retard'): ?>
                                            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Retard</span>
                                        <?php else: ?>
                                            <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs font-semibold">Absence</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <td class="px-3 py-2 border text-center"><?php echo e($abs->heure_debut ?? '-'); ?></td>
                                    <td class="px-3 py-2 border text-center"><?php echo e($abs->heure_fin ?? '-'); ?></td>
                                    <td class="px-3 py-2 border text-center">
                                        <!--[if BLOCK]><![endif]--><?php if($abs->minutes_retard): ?>
                                            <?php echo e($abs->minutes_retard); ?> min
                                        <?php elseif($abs->duree): ?>
                                            <?php echo e($abs->duree); ?> h
                                        <?php else: ?>
                                            -
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <td class="px-3 py-2 border text-center">
                                        <!--[if BLOCK]><![endif]--><?php if($abs->justifie): ?>
                                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-xs font-semibold">Oui</span>
                                        <?php else: ?>
                                            <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs">Non</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <td class="px-3 py-2 border"><?php echo e($abs->motif ?? '-'); ?></td>
					   <td class="px-3 py-2 border text-center">
    <button 
        class="bg-blue-600 hover:bg-blue-700 text-black px-3 py-1 rounded text-xs shadow"
        onclick="openEditAbsenceModal(<?php echo e($abs->id); ?>, '<?php echo e($abs->date_absence); ?>', '<?php echo e($abs->semestre); ?>', '<?php echo e($abs->type); ?>', '<?php echo e($abs->heure_debut); ?>', '<?php echo e($abs->heure_fin); ?>', '<?php echo e($abs->minutes_retard); ?>', '<?php echo e($abs->motif); ?>', <?php echo e($abs->justifie ? 1 : 0); ?>)">
        <i class="fa fa-edit"></i> Modifier
    </button>
    
</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center text-gray-600 italic py-6">
                    Aucune absence ou retard enregistré pour cet apprenant.
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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



                            </div>

                            <div class="py-2 text-xs">
                                <table class="w-full mb-3">
                                    <thead>
                                        <tr class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b">
                                            <th class="p-2 border text-center text-gray-800">Matière</th>
                                            <th class="p-2 border text-center text-gray-800">Coef</th>
                                            <th class="p-2 border text-center text-gray-800">Note CC</th>
                                            <th class="p-2 border text-center text-gray-800">Note Composition</th>
                                            <th class="p-2 border text-center text-gray-800">Moyenne</th>
                                            <th class="p-2 border text-center text-gray-800">Semestre</th>
                                            <th class="p-2 border text-center text-gray-800">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y">
                                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php
                                                $evaluation = $evalu->where('matiere_id', $matiere->id)
                                                                    ->where('semestre', $selectedsemestre)
                                                                    ->first();
                                            ?>
                                            <tr>
                                                <td class="p-2 border text-center font-bold"><?php echo e($matiere->nom); ?></td>
                                                <td class="p-2 border text-center"><?php echo e($matiere->coef); ?></td>
                                                <td class="p-2 border text-center"><?php echo e($evaluation->note_cc ?? '-'); ?></td>
                                                <td class="p-2 border text-center"><?php echo e($evaluation->note_composition ?? '-'); ?></td>
                                                <td class="p-2 border text-center">
                                                    <!--[if BLOCK]><![endif]--><?php if($evaluation): ?>
                                                        <?php echo e($this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition)); ?>

                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </td>
                                                <td class="p-2 border text-center"><?php echo e($evaluation->semestre ?? '-'); ?></td>
                                                <td class="p-2 border text-center">

    
    <!--[if BLOCK]><![endif]--><?php if($evaluation): ?>
        
        <!--[if BLOCK]><![endif]--><?php if($user->hasRole('superadmin') || $user->hasRole('chef_de_travaux') || $user->hasRole('directeur_etude') || $user->hasRole('chef_etablissement')): ?>

            <!-- Bouton Modifier -->
            <a href="#" data-modal-target="default-modal-edit<?php echo e($matiere->id); ?>" data-modal-toggle="default-modal-edit<?php echo e($matiere->id); ?>">
                <i class="fa fa-edit text-green-600"></i>
            </a>
    <!-- Modal Modifier -->
    <div id="default-modal-edit<?php echo e($matiere->id); ?>" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Modification de l'évaluation de la matière <?php echo e($matiere->nom); ?>

                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal-edit<?php echo e($matiere->id); ?>">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <form action="<?php echo e(route('evaluation.update', ['evaluation' => $evaluation->id])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="semestre" value="<?php echo e($selectedsemestre); ?>">
                                <input type="hidden" name="matiere_id" value="<?php echo e($evaluation->matiere_id); ?>">

                                <div class="flex flex-wrap w-full justify-evenly mb-4">
                                    <div class="flex-grow mr-2">
                                        <label for="note_cc" class="block text-sm font-bold text-gray-700">Note Contrôle Continu :</label>
                                        <input type="text" name="note_cc" id="note_cc"
                                               class="form-input rounded-md shadow-sm mt-1 block w-full"
                                               value="<?php echo e($evaluation->note_cc); ?>" />
                                    </div>

                                    <div class="flex-grow mr-2">
                                        <label for="note_composition" class="block text-sm font-bold text-gray-700">Note Composition :</label>
                                        <input type="text" name="note_composition" id="note_composition"
                                               class="form-input rounded-md shadow-sm mt-1 block w-full"
                                               value="<?php echo e($evaluation->note_composition); ?>" />
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Enregistrer les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            &nbsp;&nbsp;&nbsp;

            <!-- Bouton Historique -->
            <a href="#" data-modal-target="default-modal-edit-note<?php echo e($matiere->id); ?>" data-modal-toggle="default-modal-edit-note<?php echo e($matiere->id); ?>">
                <i class="fa fa-eye text-orange-500"></i>
            </a>

                <div id="default-modal-edit-note<?php echo e($matiere->id); ?>" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Historique de modification de la note <?php echo e($matiere->nom); ?>

                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal-edit-note<?php echo e($matiere->id); ?>">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <?php
                                $historiques = App\Models\HistoryNote::where('evaluation_id', $evaluation->id)->get();
                            ?>
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-200 text-left">
                                        <th class="py-2 px-4 border-b">Auteur</th>
                                        <th class="py-2 px-4 border-b">Modification</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php $__empty_2 = true; $__currentLoopData = $historiques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <tr class="hover:bg-gray-100">
                                            <td class="py-2 px-4 border-b">
                                                <?php echo e($h->user->nom.' '.$h->user->prenom); ?>

                                                <i class="text-xs">(<?php echo e($h->created_at->format('d-m-y H:i')); ?>)</i>
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <!--[if BLOCK]><![endif]--><?php if($h->old_note_cc == null && $h->old_note_composition == null): ?>
                                                    Nouvelle note ajoutée
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if($h->old_note_cc != null && $h->old_note_composition != null): ?>
                                                    Respectivement <?php echo e($h->old_note_cc); ?> et <?php echo e($h->old_note_composition); ?>

                                                    avant la modification.
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if($h->old_note_cc != null && $h->old_note_composition == null): ?>
                                                    Note de contrôle continue modifiée (<?php echo e($h->old_note_cc); ?>)
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if($h->old_note_cc == null && $h->old_note_composition != null): ?>
                                                    Note de composition modifiée (<?php echo e($h->old_note_composition); ?>)
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <tr>
                                            <td colspan="3" class="p-2 font-bold text-lg text-center">Pas d'historique.</td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            &nbsp;&nbsp;&nbsp;

            <!-- Bouton Supprimer -->
            <?php echo Form::open([
                'method' => 'DELETE',
                'class' => 'delete-form',
                'style' => 'display: inline;',
                'route' => ['evaluation.destroy', $evaluation->id]
            ]); ?>

                <?php echo e(csrf_field()); ?>

                <button class="text-red-500 mr-2 apix-delete" data-id="<?php echo e($evaluation->id); ?>" title="Supprimer">
                    <i class="fas fa-trash-alt mr-1"></i>
                </button>
            <?php echo Form::close(); ?>

        <?php else: ?>
            <span class="text-gray-400 text-xs italic">Non autorisé</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    
    <?php else: ?>
        
        <!--[if BLOCK]><![endif]--><?php if($isFormateurAssigné): ?>
            <a href="#" data-modal-target="default-modal<?php echo e($matiere->id); ?>" data-modal-toggle="default-modal<?php echo e($matiere->id); ?>">
                <i class="fa fa-plus-circle text-green-600"></i>
            </a>
              <!-- Modal Ajouter -->
              <div id="default-modal<?php echo e($matiere->id); ?>" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Évaluation de la matière <?php echo e($matiere->nom); ?>

                            </h3>
                            <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="default-modal<?php echo e($matiere->id); ?>">
                                ✕
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <form action="<?php echo e(route('evaluation.store', ['inscriptionId' => $inscriptionId])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="inscription_id" value="<?php echo e($inscriptionId); ?>">
                                <input type="hidden" name="matiere_id" value="<?php echo e($matiere->id); ?>">
                                <input type="hidden" name="semestre" value="<?php echo e($selectedsemestre); ?>">

                                <div class="flex flex-wrap w-full justify-evenly">
                                    <div class="flex-grow mb-4 mr-2">
                                        <label for="note_cc" class="block text-sm font-bold text-gray-700">Note Contrôle Continu :</label>
                                        <input type="text" name="note_cc" id="note_cc" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                                    </div>

                                    <div class="flex-grow mb-4 mr-2">
                                        <label for="note_composition" class="block text-sm font-bold text-gray-700">Note Composition :</label>
                                        <input type="text" name="note_composition" id="note_composition" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <span class="text-gray-400 text-xs italic">Non autorisé</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</td>


                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="7" class="p-2 font-bold text-lg text-center">Aucune matière disponible pour ce semestre.</td>
                                            </tr>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="w-full items-center text-md m-3 text-center text-red-600">
                            Aucun apprenant sélectionné !
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php else: ?>
                <div class="flex p-10 justify-center items-center">
                    <h3 class="text-2xl">Aucune donnée disponible</h3>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
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
   
    function openEditAbsenceModal(id, date, semestre, type, heureDebut, heureFin, minutesRetard, motif, justifie) {
       
        document.getElementById('editAbsenceModal').classList.remove('hidden');

       
        document.getElementById('absenceId').value = id;
        document.getElementById('edit_date_absence').value = date;
        document.getElementById('edit_semestre').value = semestre;
        document.getElementById('edit_type').value = type;
        document.getElementById('edit_heure_debut').value = heureDebut || '';
        document.getElementById('edit_heure_fin').value = heureFin || '';
        document.getElementById('edit_minutes_retard').value = minutesRetard || '';
        document.getElementById('edit_motif').value = motif || '';
        document.getElementById('edit_justifie').value = justifie;

    
        const form = document.getElementById('editAbsenceForm');
        form.action = `/absences/${id}`;
    }

    
    function closeEditAbsenceModal() {
        document.getElementById('editAbsenceModal').classList.add('hidden');
    }

  
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('editAbsenceModal');
        if (event.target === modal) {
            closeEditAbsenceModal();
        }
    });
</script>
<?php /**PATH C:\wamp64\www\AMIE-FPT\resources\views/livewire/inscription/liste-inscription.blade.php ENDPATH**/ ?>