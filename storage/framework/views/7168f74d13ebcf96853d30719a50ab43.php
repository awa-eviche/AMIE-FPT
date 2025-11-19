<div class="p-4">
    
    <!--[if BLOCK]><![endif]--><?php if(session('success')): ?>
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 5000)" 
            x-show="show"
            x-transition
            class="bg-green-200 text-green-800 p-3 rounded mb-4"
        >
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(session('warning')): ?>
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 5000)" 
            x-show="show"
            x-transition
            class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4"
        >
            <?php echo e(session('warning')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    
    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['apprenantsSelectionnes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
        <div class="bg-red-100 text-red-700 p-2 rounded mb-2">
            <?php echo e($message); ?>

        </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

    <div class="flex flex-col md:flex-row gap-4 mb-4">
    
    <div class="w-full md:w-1/2">
        <label class="block font-semibold mb-1">Classe :</label>
        <select wire:model="classe" wire:change="$refresh" class="border rounded p-2 w-full">
            <option value="">-- Choisir une classe --</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($c->id); ?>"><?php echo e($c->libelle); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>

    
    <div class="w-full md:w-1/2">
        <label class="block font-semibold mb-1">Année académique :</label>
        <select wire:model="annee_academique_id" wire:change="$refresh" class="border p-2 rounded w-full">
            <option value="">-- Choisir une année --</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($a->id); ?>"><?php echo e($a->code); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
</div>


    <!--[if BLOCK]><![endif]--><?php if($currentClasse && $annee_academique_id): ?>
        <h1 class="text-xl font-bold mb-4">
            Apprenants admis à réinscrire – <?php echo e($currentClasse->libelle); ?>

        </h1>

        <!--[if BLOCK]><![endif]--><?php if(count($admis) > 0): ?>
            
            <table class="table-auto w-full bg-white shadow rounded mb-6">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Prénom</th>
                        <th class="px-4 py-2">Matricule</th>
                        <th class="px-4 py-2">Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $admis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                <input type="checkbox" wire:model="apprenantsSelectionnes" value="<?php echo e($entry['inscription']->apprenant->id); ?>">
                            </td>
                            <td class="px-4 py-2"><?php echo e($entry['inscription']->apprenant->nom); ?></td>
                            <td class="px-4 py-2"><?php echo e($entry['inscription']->apprenant->prenom); ?></td>
                            <td class="px-4 py-2"><?php echo e($entry['inscription']->apprenant->matricule); ?></td>
                            <td class="px-4 py-2"><?php echo e($entry['moyenne']); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
            <label class="inline-flex items-center space-x-2 mt-2 mb-4">
    <input type="checkbox" id="selectAllCheckbox" onclick="toggleCheckboxes()" class="form-checkbox h-4 w-4 text-blue-600">
    <span class="text-sm text-blue-600 cursor-pointer">Tout cocher / décocher</span>
</label>



            
            <div class="mb-4">
                <label class="block font-semibold">Nouvelle classe :</label>
                <select wire:model="nouvelle_classe_id" wire:change="$refresh" class="border p-2 rounded w-full">
                    <option value="">-- Choisir --</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c->id); ?>"><?php echo e($c->libelle); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            
<div class="mb-4">
    <label class="block font-semibold">Année académique de réinscription :</label>
    <select wire:model="annee_reinscription_id" wire:change="$refresh" class="border p-2 rounded w-full">
        <option value="">-- Choisir une année --</option>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($a->id); ?>"><?php echo e($a->code); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </select>
</div>

            
            <button wire:click="reinscrire" 
                class="bg-green-600 text-white mt-6 px-6 py-2 rounded hover:bg-green-700">
                Réinscrire les apprenants sélectionnés
            </button>
        <?php else: ?>
            <p class="text-gray-600">Aucun apprenant admissible à la réinscription dans cette classe pour cette année académique.</p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<script>
    function toggleCheckboxes() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="apprenantsSelectionnes"]');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);

        checkboxes.forEach(cb => cb.checked = !allChecked);

        // Manuellement déclencher un événement 'input' pour Livewire
        checkboxes.forEach(cb => {
            cb.dispatchEvent(new Event('input', { bubbles: true }));
        });
    }
</script>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/reinscription/liste-admis.blade.php ENDPATH**/ ?>