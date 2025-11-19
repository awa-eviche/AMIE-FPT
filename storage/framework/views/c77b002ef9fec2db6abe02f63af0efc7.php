<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="mb-4">
            <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'filiere','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'filiere','class' => 'font-semibold text-black']); ?>
                Filière <span class="text-red-500">*</span>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
            <select wire:model="filiere" wire:change="onFiliereChange" wire:ignore class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="filiere_id">
                <option value="">Chosir une filière</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $filiereFromBD; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($filiere['id']); ?>" wire:key="<?php echo e($filiere['id']); ?>"><?php echo e($filiere['nom']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['filiere'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="text-xs text-red-500">
                <?php echo e($message); ?>

            </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div class="mb-4">
            <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'niveau','class' => 'font-semibold text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'niveau','class' => 'font-semibold text-black']); ?>
                Niveau <span class="text-red-500">*</span>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
            <select wire:model="niveau" wire:change="onNiveauChange" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="niveau_id">
                <option value="">Choisir un niveau</option>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveauFromBD; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $niveau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($niveau->id); ?>" wire:key="<?php echo e($niveau->id); ?>"><?php echo e($niveau->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </select>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['niveau'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="text-xs text-red-500">
                <?php echo e($message); ?>

            </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div class="mb-4">
            <p wire:click="add" class="cursor-pointer w-20 flex items-center bg-first-orange mt-5 py-2 px-3 rounded text-white text-sm">
                <i class="fa fa-plus"></i>
                <span class="font-normal">
                    Ajouter
                </span>
            </p>
        </div>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-2">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-100 text-gray-600 font-bold">
                    <th class="px-4 py-2 text-center">Filière</th>
                    <th class="px-4 py-2 text-center">Niveau</th>
                    <th class="px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
    <!--[if BLOCK]><![endif]--><?php if(isset($datasets) && is_array($datasets)): ?>
        <?php
            $num = 1;
        ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $datasets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donnee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-4 py-2 border border-gray-300 text-center text-black">
                    <?php echo e(isset($donnee['filiere']) && isset($donnee['filiere']['nom']) ? htmlspecialchars($donnee['filiere']['nom']) : 'Nom de filière non disponible'); ?>

                </td>
                <td class="px-4 py-2 border border-gray-300 text-center text-black">
                    <?php echo e(isset($donnee['niveau']) && isset($donnee['niveau']['nom']) ? htmlspecialchars($donnee['niveau']['nom']) : 'Nom de niveau non disponible'); ?>

                </td>
                <td class="px-4 py-2 border border-gray-300 text-center">
                    <i class="fa fa-trash text-orange-600" wire:click="remove(<?php echo e($num); ?>)" style="cursor: pointer;"></i>
                </td>
            </tr>
            <?php
                $num += 1;
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php else: ?>
        <p>Aucune donnée disponible.</p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</tbody>




        </table>

    </div>
</div><?php /**PATH /var/www/html/pgi/resources/views/livewire/param/demande-ouverture-etablissement.blade.php ENDPATH**/ ?>