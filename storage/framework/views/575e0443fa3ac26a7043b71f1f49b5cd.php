<div class="p-4">
    <div class="grid md:grid-cols-1 md:gap-6 pt-2">
        <div class="mb-4">
            <label for="competence" class="block text-gray-700 text-sm font-bold mb-2">Compétence<span class="text-red-600 mx-2">*</span></label>
            <select value="<?php echo e(old('competence') ?? ''); ?>" wire:model="competence" wire:change="loadEcompetences()" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="competence" name="competence" >
                <option value="">Sélectionner la compétence</option>
                <?php $__currentLoopData = $competences ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($competence->id); ?>"><?php echo e($competence->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['competence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <?php echo e($message); ?>

            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
        <div class="mb-4">
            <label for="ecompetence" class="block text-gray-700 text-sm font-bold mb-2">Element de compétence<span class="text-red-600 mx-2">*</span></label>
            <select value="<?php echo e(old('ecompetence') ?? ''); ?>" wire:model="ecompetence" wire:change="loadCriteres()" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="ecompetence" name="ecompetence" >
                <option value="">Sélectionner l'élément de compétence</option>
                <?php $__currentLoopData = $ecompetences ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ec->id); ?>"><?php echo e($ec->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['ecompetence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <?php echo e($message); ?>

            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label for="critere" class="block text-gray-700 text-sm font-bold mb-2">Critère<span class="text-red-600 mx-2">*</span></label>
            <select value="<?php echo e(old('critere') ?? ''); ?>" wire:model="commune" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="critere" name="critere" >
                <option value="">Sélectionner le critère</option>
                <?php $__currentLoopData = $criteres ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $critere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($critere->id); ?>"><?php echo e($critere->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['critere'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <?php echo e($message); ?>

            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>


    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
        <div class="mb-4">
            <label for="evaluation" class="block text-gray-700 text-sm font-bold mb-2">Evaluation<span class="text-red-600 mx-2">*</span></label>
            <select value="<?php echo e(old('evaluation') ?? ''); ?>" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="evaluation" name="evaluation" >
                <option value="">Selectionner un statut</option>
                <option value="A">Acquis</option>
                <option value="NA">Non Acquis</option>
            </select>
            <?php $__errorArgs = ['evaluation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <?php echo e($message); ?>

            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date<span class="text-red-600 mx-2">*</span></label>
            <input type="date" value="<?php echo e(old('date') ?? ''); ?>" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="date" name="date" >
            <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <?php echo e($message); ?>

            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/amie-fpt/resources/views/apprenant/competence/evaluer.blade.php ENDPATH**/ ?>