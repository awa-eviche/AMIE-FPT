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

    <div class="bg-transparent shadow rounded-sm w-full p-4">
        <div class="bg-white pb-4 w-full mx-auto md:container md:mx-auto">

            <h2 class="font-bold text-xl sm:px-2 lg:px-4 py-4"><?php echo e($classe->libelle); ?></h2>

            <div class="flex justify-between items-center sm:px-2 lg:px-4">
                <a href="<?php echo e(route('classe.index')); ?>" class="text-blue-500 hover:underline">
                    &larr; Retour à la liste des classes
                </a>
<?php
    $user = auth()->user();
?>

<?php if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement')): ?>
<div onclick="window.location='<?php echo e(route('classe.formateurs.assign', $classe->id)); ?>'"
     style="background-color:#0E7490; cursor: pointer; width: fit-content;"
     class="bg-cyan-700 text-white hover:bg-cyan-800 rounded-lg text-sm px-4 py-2 cursor-pointer" >  <i class="fa fa-user-plus"></i>
    Assigner des formateurs
</div>
<?php endif; ?> 

                <div class="flex gap-2">
               <form id="exportForm" method="GET" action="<?php echo e(route('classe.exportPdf', $classe->id)); ?>">
    <input type="hidden" name="annee_academique_id" id="annee_academique_export">
    <div onclick="exportPdf()" style="background-color:#1E3A8A; cursor: pointer; width: fit-content;"
         class="bg-blue-700 text-white hover:bg-blue-800 rounded-lg text-sm px-4 py-2 cursor-pointer">
        Exporter la liste des apprennats en PDF
    </div>
</form>

<script>
function exportPdf() {
    const selectedAnnee = document.getElementById('annee_academique_id').value;
    if(!selectedAnnee){
        alert('Veuillez sélectionner une année académique pour pouvoir exporter la liste.');
        return;
    }
    document.getElementById('annee_academique_export').value = selectedAnnee;
    document.getElementById('exportForm').submit();
}
</script>
<?php
    $user = auth()->user();
?>

<?php if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement')): ?>
                    <div onclick="window.location='<?php echo e(route('classe.edit', $classe->id)); ?>'" style="background-color:#006D3A; cursor: pointer;"
                         class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-5 py-2.5 cursor-pointer">
                        Modifier
                    </div>
                    <?php endif; ?>

                    <?php
    $user = auth()->user();
?>               
     

                    <?php if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement')): ?>       
                    <form action="<?php echo e(route('classe.destroy', $classe->id)); ?>" method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="bg-red-600 text-white hover:bg-red-700 rounded-lg text-sm px-5 py-2.5">
                            Supprimer
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-6 border border-gray-200 rounded-lg p-4">
                <h3 class="bg-gray-100 p-2 text-md font-bold text-orange-600">
                    Détails de la classe : <?php echo e($classe->libelle); ?>

                </h3>

                <div class="flex flex-col lg:flex-row gap-6 mt-4">
                    <!-- Informations générales -->
                    <div class="lg:w-1/3 border shadow p-4 rounded bg-gray-50">
                        <h3 class="font-bold text-xl mb-4">Informations générales</h3>
                        <hr>

                        <div class="grid grid-cols-2 gap-2 py-2 text-sm">
                            <div class="text-gray-800">Etablissement :</div>
                            <div class="font-bold"><?php echo e($classe->etablissement->nom); ?></div>

                            <div class="text-gray-800">Filière :</div>
                            <div class="font-bold"><?php echo e($classe->niveau_etude->metier->filiere->nom); ?></div>

                            <div class="text-gray-800">Métier :</div>
                            <div class="font-bold"><?php echo e($classe->niveau_etude->metier->nom); ?></div>

                            <div class="text-gray-800">Niveau d'études :</div>
                            <div class="font-bold"><?php echo e($classe->niveau_etude->nom); ?></div>

                            <div class="text-gray-800">Modalité :</div>
                            <div class="font-bold"><?php echo e($classe->modalite); ?></div>
                        </div>

                        <hr class="my-4">

                        <h3 class="font-bold text-lg mb-2">Disciplines au programme</h3>
                               <div class="pl-2 text-sm">
    <?php if(($classe->modalite ?? null) === 'PPO'): ?>
        <?php $__empty_1 = true; $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center mb-2">
                <i class="fa fa-star text-gray-400 text-xs mr-2"></i>
                <span><strong><?php echo e($matiere->code); ?></strong> : <?php echo e($matiere->nom); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-gray-500">Aucune matière pour ce niveau.</div>
        <?php endif; ?>

    <?php elseif(($classe->modalite ?? null) === 'APC'): ?>
        <?php $__empty_1 = true; $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center mb-2">
                <i class="fa fa-check text-green-500 text-xs mr-2"></i>
                <span><strong><?php echo e($competence->code); ?></strong> : <?php echo e($competence->nom); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-gray-500">Aucune compétence pour ce niveau.</div>
        <?php endif; ?>

    <?php else: ?>
        <div class="text-gray-500">Modalité non définie pour cette classe.</div>
    <?php endif; ?>
</div>
                    </div>

                    <!-- Liste des apprenants -->
                    <div class="lg:w-2/3 border shadow p-4 rounded bg-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-xl">Liste des apprenants</h3>

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

                           <!-- Ajouter un apprenant -->
<div onclick="window.location='<?php echo e(route('apprenant.create', $classe->id)); ?>'"
     style="background-color:#006D3A; cursor: pointer; width: fit-content;"
     class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-4 py-2 cursor-pointer">
    Ajouter un apprenant
</div>


                            <!-- Importer un fichier Excel -->
                            <form action="<?php echo e(route('apprenant.import', ['classe' => $classe->id])); ?>"
      method="POST"
      enctype="multipart/form-data"
      class="flex flex-col gap-2 items-start bg-white p-4 rounded shadow w-full sm:w-full">
    <?php echo csrf_field(); ?>

    <!-- Ligne contenant les deux champs côte à côte -->
    <div class="flex flex-col sm:flex-row gap-4 w-full">
        <!-- Sélecteur année -->
        <div class="flex flex-col w-full sm:w-1/3">
            <label for="annee_academique_id" class="text-sm font-medium">Année Scolaire :</label>
            <select name="annee_academique_id" id="annee_academique_id" required
                    class="rounded border-gray-300 text-sm w-full">
                <option value="">-- Choisir une année --</option>
                <?php $__currentLoopData = $anneeAcademiques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $annee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($annee->id); ?>"><?php echo e($annee->code); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Champ fichier -->
        <div class="flex flex-col w-full sm:w-2/3">
            <label for="file" class="text-sm font-medium">Fichier Excel :</label>
            <input type="file" name="file" accept=".xlsx, .xls"
                   class="rounded border-gray-300 text-sm w-full" required>
        </div>
    </div>

    <!-- Bouton -->
    <button type="submit" style="background-color:#006D3A; cursor: pointer;"
            class="text-white hover:bg-green-800 rounded-lg text-sm px-5 py-2.5 mt-4 self-start">
        Importer des apprenants
    </button>
</form>


                        </div>

                        <hr class="mb-4">

                        <!-- Tableau des apprenants -->
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
                                        <td class="px-2 py-2">
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

                        <!-- Pagination -->
                        <div class="mt-4">
                        <?php echo e($inscriptions->appends(['annee_academique_id' => request('annee_academique_id')])->links()); ?>


                        </div>
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
<?php /**PATH /var/www/html/amie-fpt/resources/views/classe/show171025.blade.php ENDPATH**/ ?>