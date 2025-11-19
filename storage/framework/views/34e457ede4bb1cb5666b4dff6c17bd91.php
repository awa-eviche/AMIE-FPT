<div>
<div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner un métier
        </label>
        <select wire:model="metier" id="metier_id"  wire:change="$refresh" name="metier_id" required
                class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez un métier</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $metiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->id); ?>"><?php echo e($m->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>

<div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="niveauetude_id">
            Sélectionner un niveau d'etude
        </label>
        <select wire:model="niveau" id="niveau_etude_id" wire:change="$refresh" name="niveau_etude_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez un niveau d'etude</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($niv->id); ?>"><?php echo e($niv->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner une compétence
        </label>
        <select wire:model="competence" id="competence_id" wire:change="$refresh"  name="competence_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez une competence</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($comp->id); ?>"><?php echo e($comp->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>

    <!--[if BLOCK]><![endif]--><?php if(!empty($competences)): ?>
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="element">
            Sélectionner un ou plusieurs éléments de compétence
        </label>
        <select id="element" name="element[]" multiple required
                class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $elt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($elt->id); ?>"><?php echo e($elt->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/param/create-critere.blade.php ENDPATH**/ ?>