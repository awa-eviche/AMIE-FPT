<div>
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner un métier
        </label>
        <select wire:model="metier" id="metier_id" wire:change="$refresh"  name="metier" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez un métier</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $metiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($id); ?>"><?php echo e($nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>

   
    <!--[if BLOCK]><![endif]--><?php if(!empty($niveaux)): ?>
        <div class="mb-4 mx-auto w-full">
            <label class="block text-gray-700 text-sm font-bold" for="description">
                Sélectionner un niveau
            </label>
            <select id="niveau_etude_id" name="niveau_etude_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
                <option value="">Sélectionnez un niveau</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($nivo->id); ?>"><?php echo e($nivo->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/classe/create-classe.blade.php ENDPATH**/ ?>