<div>
    <div class="mt-4 mb-2 flex">
        <div class="w-1/3 flex items-end justify-end pr-2">
            <strong class="text-black">date effective :</strong>
        </div>
        <?php if($reunion->date_effective ||
            // $reunion->etat == App\Enums\ReunionEtatEnum::TRANSMISE ||
            $reunion->etat == App\Enums\ReunionEtatEnum::PREPARATION): ?>
            <div class="w-2/3">
                <span class="text-maquette-gris"><?php echo e(date('d-m-Y',strtotime($reunion->date_effective) ?? " ")); ?></span>

            </div>
        <?php else: ?>
            <div class="">
                <button class="bg-green-200 hover:bg-green-300 hover:shadow-xl text-green-900 rounded px-3 py-1 text-bold" wire:click="toggleIsModifying">Renseigner</button>
            </div>
        <?php endif; ?>
    </div>
    <?php if($isModifying): ?>
        <div class="text-center mt-2">
            <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['wire:model' => 'dateEffective','id' => 'dateEffective','class' => 'block mx-auto focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 w-96','type' => 'date','name' => 'dateEffective','value' => old('dateEffective'),'autofocus' => true,'autocomplete' => 'dateEffective']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'dateEffective','id' => 'dateEffective','class' => 'block mx-auto focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 w-96','type' => 'date','name' => 'dateEffective','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('dateEffective')),'autofocus' => true,'autocomplete' => 'dateEffective']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
            <?php $__errorArgs = ['dateEffective'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-xs text-red-500 block mt-1">
                    <?php echo e($message); ?>

                </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex justify-end my-3">
            <button class ="mr-3 bg-red-800 text-white px-3 py-1 rounded hover:bg-red-900 hover:shadow-xl" wire:click="toggleIsModifying">Annuler</button>
            <button class="bg-green-800 text-white px-3 py-1 rounded hover:bg-green-900 hover:shadow-xl" wire:click="changerDateEffective">Valider</button>

        </div>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/amie-fpt/resources/views/livewire/reunions/mettre-date-effective.blade.php ENDPATH**/ ?>