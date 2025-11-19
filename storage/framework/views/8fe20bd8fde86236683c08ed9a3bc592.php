<div class="p-6 bg-white rounded-lg shadow-lg">
    

    <!--[if BLOCK]><![endif]--><?php if(session('success')): ?>
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <form wire:submit.prevent="update" class="space-y-5">

        
        <div>
            <label for="metier" class="block text-sm font-semibold text-gray-700">Métier</label>
            <select id="metier" wire:model="selectedMetier" class="border-gray-300 rounded-md w-full p-2">
                <option value="">-- Choisir un métier --</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $metiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($metier->id); ?>"><?php echo e($metier->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>

        
        <div>
            <label for="niveau" class="block text-sm font-semibold text-gray-700">Niveau</label>
            <select id="niveau" wire:model="selectedNiveau" class="border-gray-300 rounded-md w-full p-2" <?php echo e(empty($niveaux) ? 'disabled' : ''); ?>>
                <option value="">-- Choisir un niveau --</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($niveau->id); ?>"><?php echo e($niveau->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>

        
        <div>
            <label for="competence" class="block text-sm font-semibold text-gray-700">Compétence</label>
            <select id="competence" wire:model="selectedCompetence" class="border-gray-300 rounded-md w-full p-2" <?php echo e(empty($competences) ? 'disabled' : ''); ?>>
                <option value="">-- Choisir une compétence --</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($competence->id); ?>"><?php echo e($competence->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
        </div>

        
        <div>
            <label for="element" class="block text-sm font-semibold text-gray-700">Élément de compétence</label>
            <select id="element" wire:model="selectedElement" class="border-gray-300 rounded-md w-full p-2" <?php echo e(empty($elements) ? 'disabled' : ''); ?>>
                <option value="">-- Choisir un élément --</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($element->id); ?>"><?php echo e($element->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['selectedElement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        
        <div>
            <label for="libelle" class="block text-sm font-semibold text-gray-700">Libellé du critère</label>
            <input type="text" id="libelle" wire:model="libelle" class="border-gray-300 rounded-md w-full p-2" placeholder="Libellé du critère">
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['libelle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        
        <div class="flex justify-end gap-3 mt-6">
          
            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 text-sm">
                 Modifier le critère
            </button>
        </div>
    </form>
</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/param/edit-critere.blade.php ENDPATH**/ ?>