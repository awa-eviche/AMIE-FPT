<div class="bg-transparent">
    <div class="flex mb-5 justify-between px-4 flex-col sm:flex-row">
        <div class="flex">
            <span href="#" class="bg-transparent border-transparent px-4  py-2 flex text-black text-sm text-center  bg-white items-center">
                <svg class="w-6 h-6 text-first-orange font-bold" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" wire:model="search" wire:keydown="$refresh" placeholder="Rechercher" class="form-input text-sm px-4 py-3 w-full sm:w-max shadow-sm border border-first-orange">
        </div>
    </div>

    <div class="flex mb-0 justify-end px-4 flex-col sm:flex-row">
        <div class="grid md:grid-cols-1 md:gap-6 pt-2 sm:mr-4">
            <div class="mb-4">
                <label for="sigle" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par Région</label>
                <select  wire:model="selectedRegion" wire:change="$refresh" id="selectRegion"  class="border border-gray-300 p-3 w-full focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold text-black">
                    <option value="">Sélectionnez une région</option>
                    <?php if($regions): ?>
                    <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($region->id); ?>"><?php echo e($region->libelle); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
                <?php $__errorArgs = ['region
                '];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-3 block "><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="grid md:grid-cols-1 md:gap-6 pt-2 sm:mr-4">
            <div class="mb-4">
                <label for="sigle" class="block text-gray-700 text-sm font-bold mb-2 ">Filtre Par Département</label>
                <select <?php if(!$selectedRegion): ?> disabled <?php endif; ?> wire:model="selectedDepartement" wire:change="$refresh" class="border border-gray-300 p-3 w-full sm:max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold text-black">
                    <option value="">Sélectionnez un département</option>
                    <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($departement->id); ?>"><?php echo e($departement->libelle); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['departement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-3 block "><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="grid md:grid-cols-1 md:gap-6 pt-2">
            <div class="mb-4">
                <label for="sigle" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par commune</label>
                <select <?php if(!$selectedDepartement): ?> disabled <?php endif; ?> wire:model="selectedCommune" wire:change="$refresh" class="border border-gray-300 p-3 w-full sm:max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold text-black ">
                    <option value="">Sélectionnez une commune</option>
                    <?php $__currentLoopData = $communes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commune): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($commune->id); ?>"><?php echo e($commune->libelle); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['commune'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-3 block "><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

     </div>



     <?php if($count): ?>
         <div class="my-0 py-0"><span class="mx-4 bg-first-orange font-bold p-1 px-2 rounded text-white"><?php echo e($count); ?> efpt(s) trouvés</span></div>
     <?php endif; ?>
    <div class="w-full bg-transparent rounded-lg shadow-xs p-0 flex flex-wrap">

        <?php $__empty_1 = true; $__currentLoopData = $etablissements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etablissement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="sm:w-1/3 w-full p-4 text-black">
            <div class="rounded-lg shadow-md p-4 bg-white3">
                <h1 class="font-bold text-lg"><i class="fa-solid fa-building text-first-orange"></i> <?php echo e($etablissement->nom); ?></h1>
                <hr class="my-2" />
                <div class="flex flex-col sm:flex-row mb-4 sm:items-center">
                    <img class="rounded-lg sm:w-1/3 w-1/2 px-4" src="<?php echo e(asset('storage/etablissements/'. $etablissement->logo)); ?>" alt="Logo" />
                    <div class="px-4 flex-1 py-3 sm:py-0">
                        <h3 class="text-sm py-1"><i class="text-first-orange fa fa-location"></i>&nbsp;Région : <span class="font-bold"><?php echo e($etablissement->commune->departement->region->libelle ?? ' - '); ?></span></h3>
                        <h3 class="text-sm py-1"><i class="text-first-orange fa fa-list"></i>&nbsp;Etablissement : <span class="font-bold"><?php echo e($etablissement->nom ?? ' - '); ?></span></h3>
                        <h3 class="text-sm py-1"><i class="text-first-orange fa fa fa-list"></i>&nbsp;Type : <span class="font-bold"><?php echo e($etablissement->statut ?? ' - '); ?></span></h3>
                        <h3 class="text-sm py-1"><i class="text-first-orange fa fa-envelope"></i>&nbsp;Email : <span class="font-bold"><?php echo e($etablissement->email ?? ' - '); ?></span></h3>

                       
                    </div>
                    <div class="px-4 flex items-end py-1 sm:py-0">
                        <div class="flex items-center <?php echo e($etablissement->is_active ? 'bg-green-100' : 'bg-red-100'); ?> px-4 py-1 rounded-lg">
                        <i class="fa fa-circle <?php echo e($etablissement->is_active ? 'text-orange-600' : 'text-red-600'); ?> text-xs pr-3"></i>
                            <h3><?php echo e($etablissement->is_active ? 'Actif' : 'Inactif'); ?></h3>
                        </div>
                    </div>
                </div>
                <hr>
                
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="w-full justify-center">
            <h3 class="font-bold text-xl py-4 text-center">Aucune donnée disponible</h3>
        </div>
        <?php endif; ?>

    </div>

    <?php if($count > 12): ?>
    <div class="flex justify-start items-center mt-5 px-4 pb-4">
        <button <?php echo e($startLimit == 0 ? 'disabled' : ''); ?> wire:click="prev" type="button" class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none">
                <path id="Polygon 1" d="M0.982423 8.69351C-0.0296571 7.89277 -0.0296574 6.35734 0.982422 5.55659L7.00906 0.788418C8.32029 -0.249004 10.25 0.684883 10.25 2.35688V11.8932C10.25 13.5652 8.32029 14.4991 7.00906 13.4617L0.982423 8.69351Z" fill="black" />
            </svg>
        </button>
        <span class="text-md text-black mx-3"><?php echo e(min($count,$startLimit+1)); ?> à <?php echo e(min($startLimit+12,$count)); ?> sur <?php echo e($count); ?></span>
        <button wire:click="next" <?php echo e(($startLimit+12) >= $count ? 'disabled' : ''); ?> type="button" class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
            <svg class="w-4 h-4" width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path id="Polygon 1" d="M10.0176 5.55649C11.0297 6.35723 11.0297 7.89266 10.0176 8.69341L3.99094 13.4616C2.67971 14.499 0.75 13.5651 0.75 11.8931L0.75 2.35677C0.75 0.684774 2.67971 -0.249114 3.99094 0.788308L10.0176 5.55649Z" fill="black" />
            </svg>
        </button>
    </div>
    <?php endif; ?>

    

</div>
<?php /**PATH /var/www/html/amie-fpt/resources/views/livewire/etablissements/2front-liste-etablissement.blade.php ENDPATH**/ ?>