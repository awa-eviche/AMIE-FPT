<div>
    <!-- Sélection du métier -->
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner un métier
        </label>
        <select wire:model="metier" id="metier_id" name="metier_id" wire:change="$refresh" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez un métier</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $metiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metierItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($metierItem->id); ?>" <?php echo e($metier == $metierItem->id ? 'selected' : ''); ?>>
                    <?php echo e($metierItem->nom); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>

    <!-- Sélection du niveau -->
    <!--[if BLOCK]><![endif]--><?php if(!empty($niveauEtudes)): ?>
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="niveau">
            Sélectionner un niveau d’étude
        </label>
        <select wire:model="niveau" id="niveau" wire:change="$refresh" class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700">
            <option value="">Sélectionnez un niveau d’étude</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveauEtudes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveauEtude): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($niveauEtude->id); ?>" <?php echo e($niveau == $niveauEtude->id ? 'selected' : ''); ?>>
                    <?php echo e($niveauEtude->nom); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Sélection de la compétence -->
    <!--[if BLOCK]><![endif]--><?php if(!empty($competences)): ?>
        <!-- Champs cachés pour soumission dans le formulaire principal -->
        <input type="hidden" name="metier_id" value="<?php echo e($metier); ?>">
        <input type="hidden" name="niveau_etude_id" value="<?php echo e($niveau); ?>">

        <div class="mb-4 mx-auto w-full">
            <label class="block text-gray-700 text-sm font-bold" for="competence_id">
                Sélectionner une compétence
            </label>
            <select id="competence_id" name="competence_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
                <option value="">Sélectionnez une compétence</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($comp->id); ?>" <?php echo e($competence == $comp->id ? 'selected' : ''); ?>>
                        <?php echo e($comp->nom); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/parametrage/elementcompetence/edit-elementcompetence.blade.php ENDPATH**/ ?>