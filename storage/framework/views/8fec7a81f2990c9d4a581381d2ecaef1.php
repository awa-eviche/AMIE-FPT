<div class="py-4">
    <div class="w-full rounded-lg shadow-xs p-0">
        <div class="flex flex-col sm:flex-row w-full justify-between sm:items-center">
            
            <div class="text-poppins_black font-bold text-lg">
                <?php if($apprenant?->apprenant?->user): ?>
                    <?php echo e($apprenant->apprenant->user->prenom.' '.$apprenant->apprenant->user->nom); ?>

                    [<?php echo e($apprenant->apprenant->user->matricule ?? '-'); ?>]
                <?php else: ?>
                    <span class="text-red-600">Aucun apprenant trouvé.</span>
                <?php endif; ?>
            </div>

            
            <button type="button"
                    wire:click="saveDatas"
                    class="w-max bg-first-orange px-4 py-2 text-white rounded-md">
                <i class="fa fa-save"></i> Enregistrer les changements
            </button>
        </div>

        
        <?php if(session()->has('message')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-2">
                <?php echo e(session('message')); ?>

            </div>
        <?php endif; ?>
        <?php if(session()->has('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-2">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <div class="flex items-center justify-end mb-4">
            <label for="selectedsemestre" class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
            <select wire:model="selectedsemestre" id="selectedsemestre" name="semestre"
                    class="block w-auto border border-gray-300 rounded shadow-sm focus:border-first-orange text-sm">
                <option value="">-- Sélectionner un semestre --</option>
                <option value="1">Premier semestre</option>
                <option value="2">Deuxième semestre</option>
            </select>
        </div>

        
        <div class="text-sm w-full p-0 relative overflow-x-auto my-2">
            <h2 class="font-bold text-lg mb-2">Compétences Générales</h2>
            <table class="w-full border-t mb-3">
                <thead>
                <tr class="text-xs font-black tracking-wide text-left text-white uppercase border-b bg-first-orange">
                    <th class="px-4 py-4 border border-black">Compétence</th>
                    <th class="px-4 py-4 border border-black">Critère</th>
                    <th class="px-4 py-4 border border-black">Note /20</th>
                    <th class="px-4 py-4 border border-black">Date Eva</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y">
                <?php $__currentLoopData = $competencesGenerales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $critere = null;
                        foreach ($competence->elementCompetences as $ec) {
                            if ($ec->criteres->count() > 0) {
                                $critere = $ec->criteres->first();
                                break;
                            }
                        }
                    ?>

                    <?php if($critere): ?>
                        <tr wire:key="row-g-<?php echo e($critere->id); ?>-sem-<?php echo e($selectedsemestre ?? 'x'); ?>">
                            <td class="px-4 py-3 border border-black font-bold"><?php echo e($competence->nom ?? '-'); ?></td>
                            <td class="px-4 py-3 border border-black"><?php echo e($critere->libelle ?? '-'); ?></td>

                            
                            <td class="px-4 py-3 border border-black text-center">
                                <input type="number" min="0" max="20" step="0.5"
                                       class="border border-gray-300 p-1 w-full text-center"
                                       wire:model.defer="evaluationData.<?php echo e($critere->id); ?>.note">
                            </td>

                            
                            <td class="px-4 py-3 border border-black text-center">
                                <input type="date"
                                       class="border border-gray-300 p-1 w-full"
                                       wire:model.defer="evaluationData.<?php echo e($critere->id); ?>.date">
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($competencesGenerales->isEmpty()): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-4 font-bold text-center">Aucune donnée disponible</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="text-sm w-full p-0 relative overflow-x-auto my-2">
            <h2 class="font-bold text-lg mb-2">Compétences Particulières</h2>
            <table class="w-full border-t mb-3">
                <thead>
                <tr class="text-xs font-black tracking-wide text-left text-white uppercase border-b bg-first-orange">
                    <th class="px-4 py-4 border border-black">Compétence</th>
                    <th class="px-4 py-4 border border-black">Critère</th>
                    <th class="px-4 py-4 border border-black">Note /20</th>
                    <th class="px-4 py-4 border border-black">Date Eva</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y">
                <?php $__currentLoopData = $competencesParticulieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $critere = null;
                        foreach ($competence->elementCompetences as $ec) {
                            if ($ec->criteres->count() > 0) {
                                $critere = $ec->criteres->first();
                                break;
                            }
                        }
                    ?>

                    <?php if($critere): ?>
                        <tr wire:key="row-p-<?php echo e($critere->id); ?>-sem-<?php echo e($selectedsemestre ?? 'x'); ?>">
                            <td class="px-4 py-3 border border-black font-bold"><?php echo e($competence->nom ?? '-'); ?></td>
                            <td class="px-4 py-3 border border-black"><?php echo e($critere->libelle ?? '-'); ?></td>

                            
                            <td class="px-4 py-3 border border-black text-center">
                                <input type="number" min="0" max="20" step="0.5"
                                       class="border border-gray-300 p-1 w-full text-center"
                                       wire:model.defer="evaluationData.<?php echo e($critere->id); ?>.note">
                            </td>

                            
                            <td class="px-4 py-3 border border-black text-center">
                                <input type="date"
                                       class="border border-gray-300 p-1 w-full"
                                       wire:model.defer="evaluationData.<?php echo e($critere->id); ?>.date">
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($competencesParticulieres->isEmpty()): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-4 font-bold text-center">Aucune donnée disponible</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $__env->startSection('scriptsAdditionnels'); ?>
    <?php echo $__env->make('layouts.v1.partials.swal._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
function gatherInfos(btn) {
    const semestre = document.getElementById('selectedsemestre').value;

    if (!semestre) {
        Swal.fire({ icon:'warning', title:'Semestre requis', text:'Veuillez sélectionner un semestre.' });
        return;
    }

    const rows  = document.querySelectorAll('tr.cptRow');
    const datas = [];

    rows.forEach(row => {
        const critereId = row.getAttribute('data-critere');
        const noteEl    = row.querySelector('.noteCritere');
        const dateEl    = row.querySelector('.critereDate');

        if (noteEl && noteEl.value !== '') {
            const note = parseFloat(noteEl.value);
            if (!isNaN(note)) {
                datas.push({
                    id: critereId,
                    note: note,
                    date: dateEl ? dateEl.value : null
                });
            }
        }
    });

    if (datas.length === 0) {
        Swal.fire({ icon:'warning', title:'Aucune note', text:'Saisissez au moins une note.' });
        return;
    }

    const compRoot = btn.closest('[wire\\:id]') || document.querySelector('[wire\\:id]');
    const compId   = compRoot ? compRoot.getAttribute('wire:id') : null;

    if (compId && window.Livewire) {
        Livewire.find(compId).call('saveDatas', datas, semestre);
    } else {
        Swal.fire({ icon:'error', title:'Livewire introuvable', text:'Rechargez la page.' });
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php /**PATH /var/www/html/amie-fpt/resources/views/livewire/apprenant/competence/evaluation081025.blade.php ENDPATH**/ ?>