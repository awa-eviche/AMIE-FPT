<div class="py-4">
    <div class="w-full rounded-lg shadow-xs p-0">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <div class="font-bold text-lg text-red-600">
                <!--[if BLOCK]><![endif]--><?php if($apprenant && $apprenant->apprenant): ?>
                    Évaluation de :
                    <?php echo e($apprenant->apprenant->prenom.' '.$apprenant->apprenant->nom); ?>

                    [<?php echo e($apprenant->apprenant->matricule ?? '-'); ?>]
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!--[if BLOCK]><![endif]--><?php if(auth()->user()->hasRole('formateur')): ?>
                <button type="button"
                        onclick="gatherInfos()"
                        class="bg-first-orange px-4 py-2 text-white hover:bg-orange-600 rounded-md shadow">
                    <i class="fa fa-save"></i>&nbsp; Enregistrer les changements
                </button>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-2">
                <?php echo e(session('message')); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="flex items-center justify-end mb-4">
            <label class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
            <select wire:model.live="selectedsemestre"
                    id="selectedsemestre"
                    class="border border-gray-300 rounded shadow-sm text-sm">
                <option value="">Sélectionnez un semestre</option>
                <option value="1">Premier semestre</option>
                <option value="2">Deuxième semestre</option>
            </select>
        </div>

        
        <h2 class="font-bold text-lg mb-2">Compétences Générales</h2>
        <table class="w-full border mb-6">
            <thead>
                <tr class="bg-first-orange text-white text-xs uppercase border-b">
                    <th class="px-4 py-2 border">Compétence</th>
                    <th class="px-4 py-2 border">Élément</th>
                    <th class="px-4 py-2 border">Ressource</th>
                    <th class="px-4 py-2 border">Note /20</th>
                    <th class="px-4 py-2 border">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $competencesGenerales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $totalRows = $rowspansGenerales[$idx] ?? 1; $rowspanCount = 0; ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $comp->elementCompetences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $el->ressource()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rIndex => $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $findRow = $evaluations[$res->id] ?? null; ?>
                            <tr class="ressourceRow" id="<?php echo e($res->id); ?>">
                                <!--[if BLOCK]><![endif]--><?php if($rowspanCount == 0): ?>
                                    <td rowspan="<?php echo e($totalRows); ?>" class="border px-4 py-2 font-bold align-top"><?php echo e($comp->nom); ?></td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($rIndex == 0): ?>
                                    <td rowspan="<?php echo e($el->ressource()->count()); ?>" class="border px-4 py-2 font-semibold align-top"><?php echo e($el->nom); ?></td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <td class="border px-4 py-2"><?php echo e($res->nom); ?></td>
                                <td class="border text-center">
                                    <input type="number" min="0" max="20" step="0.5"
                                           class="noteRessource border border-gray-300 p-1 w-full text-center"
                                           value="<?php echo e($findRow['note'] ?? ''); ?>">
                                </td>
                                <td class="border text-center">
                                    <input type="date"
                                           class="ressourceDate border border-gray-300 p-1 w-full"
                                           value="<?php echo e($findRow['date'] ?? ''); ?>">
                                </td>
                            </tr>
                            <?php $rowspanCount++; if ($rowspanCount == $totalRows) $rowspanCount = 0; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center py-3">Aucune donnée disponible</td></tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>

        
        <h2 class="font-bold text-lg mb-2">Compétences Particulières </h2>
        <table class="w-full border">
            <thead>
                <tr class="bg-first-orange text-white text-xs uppercase border-b">
                    <th class="px-4 py-2 border">Compétence</th>
                    <th class="px-4 py-2 border">Élément</th>
                    <th class="px-4 py-2 border">Seuil de reussite</th>
                    <th class="px-4 py-2 border">Note /20</th>
                    <th class="px-4 py-2 border">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $competencesParticulieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $totalRows = $rowspansParticulieres[$idx] ?? 1; $rowspanCount = 0; ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $comp->elementCompetences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $el->criteres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cIndex => $crit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $findRow = $evaluations[$crit->id] ?? null; ?>
                            <tr class="critereRow" id="<?php echo e($crit->id); ?>">
                                <!--[if BLOCK]><![endif]--><?php if($rowspanCount == 0): ?>
                                    <td rowspan="<?php echo e($totalRows); ?>" class="border px-4 py-2 font-bold align-top"><?php echo e($comp->nom); ?></td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($cIndex == 0): ?>
                                    <td rowspan="<?php echo e($el->criteres->count()); ?>" class="border px-4 py-2 font-semibold align-top"><?php echo e($el->nom); ?></td>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <td class="border px-4 py-2"><?php echo e($crit->libelle); ?></td>
                                <td class="border text-center">
                                    <input type="number" min="0" max="20" step="0.5"
                                           class="noteCritere border border-gray-300 p-1 w-full text-center"
                                           value="<?php echo e($findRow['note'] ?? ''); ?>">
                                </td>
                                <td class="border text-center">
                                    <input type="date"
                                           class="critereDate border border-gray-300 p-1 w-full"
                                           value="<?php echo e($findRow['date'] ?? ''); ?>">
                                </td>
                            </tr>
                            <?php $rowspanCount++; if ($rowspanCount == $totalRows) $rowspanCount = 0; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center py-3">Aucune donnée disponible</td></tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </tbody>
        </table>
    </div>
</div>

<?php $__env->startSection('scriptsAdditionnels'); ?>
<?php echo $__env->make('layouts.v1.partials.swal._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
function gatherInfos() {
    Swal.fire({
        title: 'Enregistrer les évaluations ?',
        text: "Confirmez la sauvegarde des données.",
        icon: "question",
        confirmButtonColor: '#16A34A',
        showCancelButton: true,
        confirmButtonText: 'Oui, enregistrer',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.value) {
            let datas = [];

            document.querySelectorAll('.ressourceRow').forEach(row => {
                datas.push({
                    id: row.id,
                    note: parseFloat(row.querySelector('.noteRessource')?.value || 0),
                    date: row.querySelector('.ressourceDate')?.value || '',
                    type: 'ressource'
                });
            });

            document.querySelectorAll('.critereRow').forEach(row => {
                datas.push({
                    id: row.id,
                    note: parseFloat(row.querySelector('.noteCritere')?.value || 0),
                    date: row.querySelector('.critereDate')?.value || '',
                    type: 'critere'
                });
            });

            Livewire.dispatch('saveDatas', {
                datas: JSON.stringify(datas),
                semestre: document.getElementById('selectedsemestre').value
            });
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/apprenant/competence/evaluation.blade.php ENDPATH**/ ?>