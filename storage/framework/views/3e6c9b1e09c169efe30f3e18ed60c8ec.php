<root class="w-full">
    <div class="flex-grow mb-4 mr-2">
        <label for="selectedSecteur">Sélectionner un secteur:</label>
        <select  id="selectedSecteur" wire:model="selectedSecteur" wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2"  name="selectedSecteur">
            <option value="">Choisir un secteur</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($secteur->id); ?>"><?php echo e($secteur->libelle); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
    <div class="flex-grow mb-4 mr-2">
        <label for="selectedFiliere">Sélectionner une filière :</label>
        <select id="selectedFiliere" wire:model="selectedFiliere" wire:change="$refresh"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2" name="selectedFiliere">
            <option value="">Choisir une filière</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($filiere->id); ?>"><?php echo e($filiere->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
    <div class="flex-grow mb-4 mr-2">
        <label for="selectedMetier">Sélectionner un métier:</label>
        <select  id="selectedMetier" wire:model="selectedMetier" wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2"  name="selectedMetier">
            <option value="">Choisir un métier</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $metiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($metier->id); ?>"><?php echo e($metier->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>

    <div class="flex-grow mb-4 mr-2">
        <label for="selectedNiveau">Sélectionner un niveau:</label>
        <select  id="selectedNiveau" wire:model="selectedNiveau"  wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2"  name="selectedNiveau">
            <option value="">Choisir un niveau</option>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveauetudes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveauetude): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($niveauetude->id); ?>"><?php echo e($niveauetude->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
    </div>
</root><?php /**PATH /var/www/html/pgi/resources/views/livewire/common/level.blade.php ENDPATH**/ ?>