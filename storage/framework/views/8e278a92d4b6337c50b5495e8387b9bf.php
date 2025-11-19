<div class="bg-transparent">

    <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm pl-4">
        <p>
            <a href="/dashboard" class="text-maquette">Accueil</a>
            <span class="mx-2 text-maquette">/</span>
        </p>
        <p> <a href="<?php echo e(route('indicateur.index')); ?>">Survey </a>

            <span class="mx-2 text-maquette">/</span>
        </p>
        <p class="text-first-orange">Liste</p>
        <p></p>
    </div>
    <div class="flex mb-5 justify-between pl-4">
        <div class="flex">
            <span href="#"
                class="bg-transparent border-transparent px-4  py-2 flex text-black text-sm text-center  bg-white items-center">
                <svg class="w-6 h-6 text-first-orange font-bold" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" wire:model="search" wire:keydown="$refresh" placeholder="Rechercher"
                class="form-input text-sm px-4 py-3 w-max shadow-sm border-white">
        </div>
        <div class="flex">
            <!--[if BLOCK]><![endif]--><?php if(auth()->user()->hasRole(config('constants.roles.superadmin'))): ?>
                <a href="#" data-modal-target="indicateur-modal" data-modal-toggle="indicateur-modal"
                    class="px-3 rounded-md py-3 flex text-white text-sm text-center bg-first-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                            <path id="Vector"
                                d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_705_6988">
                                <rect width="20" height="20" fill="white" />
                            </clipPath>
                        </defs>
                    </svg><span class="mx-2">Ajouter un survey</span>
                </a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <!-- Main modal -->
        <div id="indicateur-modal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="indicateur-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('indicateur.create-indicateur');

$__html = app('livewire')->mount($__name, $__params, 'lw--421866554-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>

                </div>
            </div>
        </div>
        <div id="realisation-modal" tabindex="-1" aria-hidden="true"
            class=" bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center md:inset-0 h-[calc(100%-1rem)] w-50 h-50 mx-auto max-w-full max-h-full ">
            <div class="relative w-full max-w-6xl max-h-full mx-8">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Enregister réalisation
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="realisation-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <div class="p-4 md:p-5 space-y-4">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('suiviindicateur.liste_suiviindicateur');

$__html = app('livewire')->mount($__name, $__params, 'lw--421866554-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="realisattion-modal" type="button"
                            class=" flex self-end py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="flex mb-5 justify-between px-4">
        <div class="grid md:grid-cols-1 md:gap-6 pt-2">
            <div class="mb-4">
                <label for="indicateur" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par Annee Academique</label>
                <select wire:model="selectedClasseAnnee" name="selectedClasseAnnee" wire:change="$refresh"
                    class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option value="">Sélectionnez une année academique</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $academiques): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($academiques->id); ?>"><?php echo e($academiques->annee1); ?>-<?php echo e($academiques->annee2); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                </select>

            </div>
        </div>
    </div>


    <div class="w-full bg-transparent rounded-lg shadow-xs p-0 flex flex-wrap items-center">

        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $indicateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicateur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="sm:w-1/3 w-full p-4">
            <div class="rounded-lg shadow-md p-4 bg-white2">
                <div class="flex justify-between items-center">
                    <h1 class="font-bold text-lg">
                        <i class="fa-solid fa-building-circle-check" style="color:green;"></i>
                         <?php echo e($indicateur->label ?? ' - '); ?>

                    </h1>
                    <a wire:click="getRealisation('<?php echo e($indicateur->id); ?>','<?php echo e($indicateur->label); ?>')" href="#"
                        data-modal-target="show-suiviindicateur-modal'<?php echo e($indicateur->id); ?>'"
                        data-modal-toggle="show-suiviindicateur-modal'<?php echo e($indicateur->id); ?>'">
                        <i class="fa fa-eye" aria-hidden="true" style="color:green;"></i>
                    </a>

                </div>

                <hr class="my-2" />
                <div class="flex mb-4 items-center">
                    <div class="px-4 flex-1">

                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-location"></i>&nbsp;Type survey :
                            <span class="font-bold"><?php echo e($indicateur->typeIndicateur->libelle?? ' - '); ?></span>
                        </h3>
                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-location"></i>&nbsp;Année academique :
                            <span class="font-bold"><?php echo e($indicateur->anneeacademique->annee1); ?>-<?php echo e($indicateur->anneeacademique->annee2); ?></span>
                        </h3>

                        

                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-check"></i> &nbsp; Date réalisation:
                            <span class="font-bold"><?php echo e(date('d-m-y', strtotime($indicateur->created_at))); ?></span>
                        </h3>
                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-check"></i> &nbsp; Date échéance:
                            <span class="font-bold"><?php echo e($indicateur->date_echeance? date('d-m-y', strtotime($indicateur->date_echeance)) : ' - '); ?></span>
                        </h3>
                    </div>
                    <div clas s="px-4 flex items-end">

                    </div>
                </div>
                <hr>
                <div class="mt-4">
                    
                    <div class="flex justify-between items-center mt-3">
                        <!--[if BLOCK]><![endif]--><?php if(auth()->user()->hasRole(config('constants.roles.superadmin'))): ?>
                            <a href="#" data-modal-target="suiviindicateur-edit-modal'<?php echo e($indicateur->id); ?>'"
                                data-modal-toggle="suiviindicateur-edit-modal'<?php echo e($indicateur->id); ?>'"
                                class=" items-center justify-center px-1 rounded-md py-1 border flex text-orange-600 text-sm text-center bg-white border-orange-600 hover:bg-orange-600 hover:text-white">
                                <i class="fa fa-edit"></i>
                                
                            </a>
                            
                            <button data-modal-target="delete-indicateur'<?php echo e($indicateur->id); ?>'" data-modal-toggle="delete-indicateur'<?php echo e($indicateur->id); ?>'" class=" items-center justify-center px-1 rounded-md py-1 border flex text-orange-600 text-sm text-center bg-white border-orange-600 hover:bg-orange-600 hover:text-white" type="button">
                                <i class="fa fa-trash"></i>
                            </button>
                            
                            <div id="delete-indicateur'<?php echo e($indicateur->id); ?>'" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-indicateur'<?php echo e($indicateur->id); ?>'">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Êtes vous sûres !!</h3>
                                            <div class="flex justify-between">
                                                <form class="text-center" action="<?php echo e(route('indicateur.destroy', $indicateur->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button data-modal-hide="delete-indicateur'<?php echo e($indicateur->id); ?>'" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        Oui
                                                    </button>
                                                </form>
                                                <button data-modal-hide="delete-indicateur'<?php echo e($indicateur->id); ?>'" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Non</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                        <!--[if BLOCK]><![endif]--><?php if((auth()->user()->personnel && auth()->user()->personnel->etablissement_id) && (\Carbon\Carbon::now()->lt($indicateur->date_echeance) )): ?>
                                <a data-modal-target="suiviindicateur-modal'<?php echo e($indicateur->id); ?>'"
                                    data-modal-toggle="suiviindicateur-modal'<?php echo e($indicateur->id); ?>'"
                                    class=" items-center px-1 rounded-md py-1 border flex text-green-600 text-sm text-center bg-white border-green-600 hover:bg-green-600 hover:text-white">
                                    <i class="fa fa-plus"></i>
                                    <span class="mx-2">Enregistrer réalisation</span>
                                </a>
                        
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        

                        <!-- Main modal -->
                        <div tabindex="-1" aria-hidden="true"
                            class="flex justify-center bg-slate-700 bg-opacity-25 <?php echo e($realisations?'':'hidden'); ?>  overflow-y-auto overflow-x-hidden fixed z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-4xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class=" flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <div>
                                            <h1 class="font-bold text-lg">
                                                <i class="fa-solid fa-building-circle-check" style="color:green;"></i>
                                                <?php echo e($nameIndicateur ?? ' - '); ?>

                                            </h1>
                                        </div>
                                        <button wire:click="close" type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="show-suiviindicateur-modal'<?php echo e($indicateur->id); ?>'">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <!--[if BLOCK]><![endif]--><?php if($realisations): ?>
                                    <div class="w-full p-3 overflow-hidden rounded-lg shadow-xs p-0">
                                        <div class="text-sm w-full overflow-x-scroll p-0">
                                            <table class="w-full border-t mb-3">
                                                <thead>
                                                    <tr
                                                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b bg-first-orange">
                                                        <th class="px-4 py-4">Etalissement</th>
                                                        <th class="px-4 py-4">Valeur</th>
                                                        <th class="px-4 py-4">Date Ajout</th>

                                                    </tr>
                                                </thead>

                                                <tbody class="bg-white divide-y ">
                                                    <!--[if BLOCK]><![endif]--><?php $__empty_2 = true; $__currentLoopData = $realisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $realisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>

                                                    <tr class="text-gray-700 ">
                                                        
                                                        <td class="px-6 py-3 border-b">
                                                            <?php echo e($realisation->etablissement->nom??' - '); ?>

                                                        </td>
                                                        <td class="px-6 py-3 border-b">
                                                            <?php echo e($realisation->valeurAtteinte ?? '-'); ?>

                                                        </td>
                                                        
                                                        <td class="px-6 py-3 border-b">
                                                            <?php echo e(date('d-m-y',strtotime($realisation->created_at)) ?? '-'); ?>

                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                    <tr>
                                                        <td colspan="6" class="px-6 py-4 font-bold text-lg text-center">
                                                            Aucune donnée disponible</td>
                                                    </tr>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </tbody>
                                            </table>

                                            <?php echo e($realisations->links()); ?>

                                        </div>
                                    </div>
                                    
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!-- Modal footer -->

                                </div>
                            </div>
                        </div>
                        
                        


                        <!-- Main modal -->
                        <div id="suiviindicateur-edit-modal'<?php echo e($indicateur->id); ?>'" tabindex="-1" aria-hidden="true"
                            class="bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class=" flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="suiviindicateur-edit-modal'<?php echo e($indicateur->id); ?>'">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5 space-y-4">
                                        <form class="bg-white pt-6 pb-8 mb-4"
                                            action="<?php echo e(route('indicateur.update',$indicateur->id)); ?>" method="POST"
                                            enctype="multipart/form-data">
                                            <?php echo method_field('PUT'); ?>
                                            <?php echo csrf_field(); ?>
                                            <div class="border border-gray-200">
                                                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                                    Modification d'un nouveau survey

                                                </h3>
                                                <div class="p-5">


                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                                        <div class="mb-4">
                                                            <label for="typeindicateur"
                                                                class="block text-gray-700 text-sm font-bold mb-2">Type
                                                                d'indicateur</label>
                                                            <select id="typeindicateur_id"
                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                id="typeindicateur_id" name="typeIndicateur_id" required
                                                                id="typeindicateur_id">
                                                                <option value="">Sélectionnez un type indicateur
                                                                </option>
                                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $typeIndicateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($type->id); ?>" <?php if($indicateur->
                                                                    typeIndicateur->id == $type->id): echo 'selected'; endif; ?>><?php echo e($type->libelle); ?>

                                                                </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            </select>
                                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['libelle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <?php echo e($message); ?>

                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>



                                                        <div class="mb-4">
                                                            <label for="libelle"
                                                                class="block text-gray-700 text-sm font-bold mb-2">Année
                                                                academique</label>
                                                            <select id="annee_academiques_id"
                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                id="annee_academiques_id" name="anneeAcademique_id"
                                                                required id="annee_academiques_id">
                                                                <option value="">Sélectionnez une année academique
                                                                </option>
                                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $annees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $academiques): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($academiques->id); ?>"
                                                                    <?php if($indicateur->anneeacademique->id ==
                                                                    $academiques->id ): echo 'selected'; endif; ?>><?php echo e($academiques->annee1); ?>-<?php echo e($academiques->annee2); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            </select>
                                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['annee_academiques_id '];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <?php echo e($message); ?>

                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                    </div>
                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                                        <div class="mb-4">
                                                            <label for="libelle" class="block text-gray-700 text-sm font-bold mb-2">Libellé</label>
                                                            <input value="<?php echo e($indicateur->label); ?>" type="text"
                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                id="libelle" name="libelle">
                                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['libelle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <?php echo e($message); ?>

                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="date_echeance"class="block text-gray-700 text-sm font-bold mb-2">Date Echéance</label>
                                                            
                                                                <div class="relative max-w-sm">
                                                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                                    </svg>
                                                                    </div>
                                                                    <input datepicker name="date_echeance" type="text" value="<?php echo e(date('M/d/Y',
                                                                    strtotime($indicateur->date_echeance ))); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="choisir une date d'échéance">
                                                                </div>
                              
                                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['date_echeance '];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <?php echo e($message); ?>

                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                    </div>
                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">


                                                        <div class="mb-4 flex items-center">
                                                            <input <?php echo e($indicateur->public==1?"checked":""); ?> id="checked-checkbox" name="public" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Visible au niveau du dashbord</label>
                                                        </div>
                                                        







                                                    </div>

                                                </div>
                                                <div class="w-full sm:px-2 lg:px-4 py-4">

                                                    <button type="submit"
                                                        class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Modifier</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->

                                </div>
                            </div>
                        </div>

                        
                        <div id="suiviindicateur-modal'<?php echo e($indicateur->id); ?>'" tabindex="-1" aria-hidden="true"
                            class=" bg-black bg-opacity-25 hidden  fixed top-0 right-0 left-0 z-50 justify-center items-center  md:inset-0 h-[calc(100%-1rem)] w-50 h-50 mx-auto max-w-full max-h-full">
                            <div class="relative p-4 w-full max-w-6xl max-h-full mx-8">


                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Enregister réalisation
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="suiviindicateur-modal'<?php echo e($indicateur->id); ?>'">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>

                                    <div class="p-4 md:p-5 space-y-4">


                                        <div class="bg-transparent shadow rounded-sm w-full p-4 ">

                                            <div class="w-full mx-8">

                                                <form class="bg-white pt-6 pb-8 mb-4"
                                                    action="<?php echo e(route('suiviIndicateur.store')); ?>" method="POST"
                                                    enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="md:container md:mx-auto">

                                                        <div class="w-full sm:px-2 lg:px-4 ">

                                                            <div class="border border-gray-200">
                                                                <h3
                                                                    class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                                                    Creation d'un nouveau réalisation

                                                                </h3>
                                                                <div class="p-5">


                                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                                                        <input type="hidden" value="<?php echo e($indicateur->id); ?>"
                                                                            name="indicateur_id">
                                                                        <?php if(auth()->user()->personnel): ?>
                                                                        <input type="hidden"
                                                                            value="<?php echo e(auth()->user()->personnel->etablissement_id); ?>"
                                                                            name="etablissement_id">
                                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                                            <div class="mb-4">
                                                                                <label
                                                                                    class="block text-gray-700 text-sm font-bold"
                                                                                    for="cible">
                                                                                    Code
                                                                                </label>
                                                                                <input
                                                                                    class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                    value="<?php echo e($indicateur->typeIndicateur->code); ?>"
                                                                                    disabled>

                                                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['valide'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                                <?php echo e($message); ?>

                                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                                            </div>

                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-gray-700 text-sm font-bold"
                                                                                for="cible">
                                                                                Libellé
                                                                            </label>
                                                                            <input
                                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                value="<?php echo e($indicateur->label); ?> "
                                                                                disabled>

                                                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['libelle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                            <?php echo e($message); ?>

                                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>
                                                                        
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-gray-700 text-sm font-bold"
                                                                                for="code">
                                                                                Année Académique
                                                                            </label>
                                                                            <input
                                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                id="code"
                                                                                value="<?php echo e($indicateur->anneeacademique->code); ?>"
                                                                                required disabled>

                                                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                            <?php echo e($message); ?>

                                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                    </div>

                                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                                                        

                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-gray-700 text-sm font-bold"
                                                                                for="cible">
                                                                                Valeur atteinte
                                                                            </label>
                                                                            <input type="number"
                                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                id="valeurAtteinte"
                                                                                name="valeurAtteinte" required>

                                                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['valeurAtteinte'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                            <?php echo e($message); ?>

                                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>
                                                                    </div>


                                                                    <div class="mb-4">
                                                                        <label
                                                                            class="block text-gray-700 text-sm font-bold"
                                                                            for="cible">
                                                                            Observation
                                                                        </label>

                                                                        <textarea
                                                                            class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                            id="observation" name="observation" required
                                                                            cols="30" rows="2"></textarea>
                                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['observation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <?php echo e($message); ?>

                                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="w-full sm:px-2 lg:px-4 py-4">

                                                        <button type="submit"
                                                            class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>

                                                    </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div
                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button data-modal-hide="suiviindicateur-modal'<?php echo e($indicateur->id); ?>'" type="button"
                                        class=" flex self-end py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Fermer</button>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="w-full justify-center">
            <h3 class="font-bold text-xl py-4 text-center">Aucune donnée disponible</h3>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    </div>
    <?php echo e($indicateurs->links()); ?>


</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/indicateur/liste-indicateur.blade.php ENDPATH**/ ?>