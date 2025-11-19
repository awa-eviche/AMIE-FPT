<div>
    <!-- Région (sur toute la ligne) -->
    <div class="flex flex-wrap">
        <div class="w-full  px-2 pb-5">
            <label for="region" class="block text-gray-700 text-sm font-bold mb-2">
                Région <span class="text-red-600">*</span>
            </label>
            <select value="<?php echo e(old('region') ?? ''); ?>" wire:model="region" wire:change="loadDepartements()"
                class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 "
                id="region" name="region">
                <option value="">Sélectionner la région</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $regions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($region->id); ?>"><?php echo e($region->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['region'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    <!-- Département et Commune (sur une seule ligne, côte à côte) -->
    <div class="flex flex-wrap">
        <!-- Département -->
        <div class="w-full sm:w-1/2 px-2 pb-5">
            <label for="departement" class="block text-gray-700 text-sm font-bold mb-2">
                Département <span class="text-red-600">*</span>
            </label>
            <select value="<?php echo e(old('departement') ?? ''); ?>" wire:model="departement" wire:change="loadCommunes()"
                class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 "
                id="departement" name="departement">
                <option value="">Sélectionner le département</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departements ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dep->id); ?>"><?php echo e($dep->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['departement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Commune -->
        <div class="w-full sm:w-1/2 px-2 pb-5">
            <label for="commune_id" class="block text-gray-700 text-sm font-bold mb-2">
                Commune <span class="text-red-600">*</span>
            </label>
            <select value="<?php echo e(old('commune_id') ?? ''); ?>" wire:model="commune"
                class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 "
                id="commune_id" name="commune_id">
                <option value="">Sélectionner la commune</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $communes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($com->id); ?>"><?php echo e($com->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['commune_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/param/localisation.blade.php ENDPATH**/ ?>