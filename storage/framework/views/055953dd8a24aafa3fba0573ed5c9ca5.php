<div>
    <div class="flex justify-end mt-6 font-bold">
        <!--[if BLOCK]><![endif]--><?php if($etat->est_rejetable): ?>
            <button wire:click="decision" class="flex items-center bg-red-800 hover:bg-red-900 hover:shadow-xl text-white py-2 px-4 text-sm rounded mx-2" <?php echo e($disabled ? 'disabled' : ''); ?>>
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 11L1 1M1 11L11 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <span class="ml-3">
                    <?php echo e($etat->bouton_rejet); ?>

                </span>
            </button>

        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if(!$etat->est_fin): ?>
        <button wire:click="next" class="hover:bg-green-900 hover:shadow-xl flex items-center bg-cyan-700 text-white py-2 px-4 text-sm rounded mx-2" <?php echo e($disabled ? 'disabled' : ''); ?>>
            <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.5917 0.508339C11.5142 0.430232 11.4221 0.368237 11.3205 0.32593C11.219 0.283622 11.11 0.261841 11 0.261841C10.89 0.261841 10.7811 0.283622 10.6796 0.32593C10.578 0.368237 10.4858 0.430232 10.4084 0.508339L4.20004 6.72501L1.59171 4.10834C1.51127 4.03064 1.41632 3.96955 1.31227 3.92854C1.20823 3.88754 1.09713 3.86743 0.985308 3.86937C0.873491 3.8713 0.76315 3.89524 0.660584 3.93982C0.558019 3.9844 0.465238 4.04874 0.387539 4.12917C0.309841 4.20961 0.248746 4.30456 0.207742 4.4086C0.166739 4.51265 0.14663 4.62375 0.148565 4.73557C0.150499 4.84739 0.174439 4.95773 0.219017 5.06029C0.263595 5.16286 0.327938 5.25564 0.408373 5.33334L3.60837 8.53334C3.68584 8.61145 3.77801 8.67344 3.87956 8.71575C3.98111 8.75806 4.09003 8.77984 4.20004 8.77984C4.31005 8.77984 4.41897 8.75806 4.52052 8.71575C4.62207 8.67344 4.71424 8.61145 4.79171 8.53334L11.5917 1.73334C11.6763 1.6553 11.7438 1.56059 11.79 1.45518C11.8361 1.34976 11.86 1.23592 11.86 1.12084C11.86 1.00575 11.8361 0.891917 11.79 0.786501C11.7438 0.681084 11.6763 0.586375 11.5917 0.508339Z" fill="white"/>
            </svg>

            <span class="ml-3">
                <?php echo e($etat->bouton_suivant); ?>

            </span>
        </button>


        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['wire:model' => 'refused','maxWidth' => '7xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'refused','maxWidth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('7xl')]); ?>
        <div class="px-10 min-h-96 py-10">
            <p class="text-first-orange text-black my-10 text-xl text-uppdercase">Veuillez mettre le motif de rejet !</p>
            <div class="mb-4 mx-auto w-full">
                <label class="block text-gray-700 text-sm font-bold" for="description">
                    Motif de rejet
                </label>
                <textarea class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="description" wire:model="motifRejet" rows="6" placeholder="Motif de rejet"></textarea>
                <div class="flex justify-end mt-10">
                    <button class="bg-gray-300 hover:bg-gray-500 hover:shadow-xl px-3 py-1 rounded text-sm-center">
                        Annuler
                    </button>

                    <button wire:click="rejet" class="hover:bg-red-900 hover:shadow-xl flex items-center bg-red-700 text-white py-2 px-4 text-sm rounded mx-2" <?php echo e($disabled ? 'disabled' : ''); ?>>
                        <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.5917 0.508339C11.5142 0.430232 11.4221 0.368237 11.3205 0.32593C11.219 0.283622 11.11 0.261841 11 0.261841C10.89 0.261841 10.7811 0.283622 10.6796 0.32593C10.578 0.368237 10.4858 0.430232 10.4084 0.508339L4.20004 6.72501L1.59171 4.10834C1.51127 4.03064 1.41632 3.96955 1.31227 3.92854C1.20823 3.88754 1.09713 3.86743 0.985308 3.86937C0.873491 3.8713 0.76315 3.89524 0.660584 3.93982C0.558019 3.9844 0.465238 4.04874 0.387539 4.12917C0.309841 4.20961 0.248746 4.30456 0.207742 4.4086C0.166739 4.51265 0.14663 4.62375 0.148565 4.73557C0.150499 4.84739 0.174439 4.95773 0.219017 5.06029C0.263595 5.16286 0.327938 5.25564 0.408373 5.33334L3.60837 8.53334C3.68584 8.61145 3.77801 8.67344 3.87956 8.71575C3.98111 8.75806 4.09003 8.77984 4.20004 8.77984C4.31005 8.77984 4.41897 8.75806 4.52052 8.71575C4.62207 8.67344 4.71424 8.61145 4.79171 8.53334L11.5917 1.73334C11.6763 1.6553 11.7438 1.56059 11.79 1.45518C11.8361 1.34976 11.86 1.23592 11.86 1.12084C11.86 1.00575 11.8361 0.891917 11.79 0.786501C11.7438 0.681084 11.6763 0.586375 11.5917 0.508339Z" fill="white"/>
                        </svg>

                        <span class="ml-3">
                            Envoyer
                        </span>
                    </button>

                </div>
            </div>

        </div>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>

</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/demandes/set-etat-demande.blade.php ENDPATH**/ ?>