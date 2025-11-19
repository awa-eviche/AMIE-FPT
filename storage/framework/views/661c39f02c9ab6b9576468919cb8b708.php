<div class="pr-5">
<div class="flex mb-5 justify-between">
        <div class="flex">
            <span href="#" class="bg-transparent border-transparent px-4  py-2 flex text-black text-sm text-center  bg-white items-center">
                <svg class="w-6 h-6 text-first-orange font-bold" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" wire:model="search" wire:keydown="$refresh" placeholder="Rechercher" class="form-input text-sm px-4 py-3 w-max shadow-sm border-white">
        </div>
        <div class="flex">
            <a href="#" class="mx-2 px-5 rounded-md py-0 flex text-orange-400 text-xs font-bold text-center shadow-md bg-white items-center">
                <span><i class="fa fa-download"></i></span>
                <span class="mx-2">Télécharger liste</span>
            </a>
            <a href="#" class="mx-2 px-5 rounded-md py-0 flex text-white text-xs font-bold text-center shadow-md bg-orange-400 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <g id="uil:sliders-v">
                        <path id="Vector" d="M5.00033 14.1667V15H2.50033C2.27931 15 2.06735 15.0878 1.91107 15.2441C1.75479 15.4004 1.66699 15.6124 1.66699 15.8334C1.66699 16.0544 1.75479 16.2663 1.91107 16.4226C2.06735 16.5789 2.27931 16.6667 2.50033 16.6667H5.00033V17.5C5.00033 17.7211 5.08812 17.933 5.2444 18.0893C5.40068 18.2456 5.61264 18.3334 5.83366 18.3334C6.05467 18.3334 6.26663 18.2456 6.42291 18.0893C6.57919 17.933 6.66699 17.7211 6.66699 17.5V14.1667C6.66699 13.9457 6.57919 13.7337 6.42291 13.5775C6.26663 13.4212 6.05467 13.3334 5.83366 13.3334C5.61264 13.3334 5.40068 13.4212 5.2444 13.5775C5.08812 13.7337 5.00033 13.9457 5.00033 14.1667ZM8.33366 15.8334C8.33366 16.0544 8.42146 16.2663 8.57774 16.4226C8.73402 16.5789 8.94598 16.6667 9.16699 16.6667H17.5003C17.7213 16.6667 17.9333 16.5789 18.0896 16.4226C18.2459 16.2663 18.3337 16.0544 18.3337 15.8334C18.3337 15.6124 18.2459 15.4004 18.0896 15.2441C17.9333 15.0878 17.7213 15 17.5003 15H9.16699C8.94598 15 8.73402 15.0878 8.57774 15.2441C8.42146 15.4004 8.33366 15.6124 8.33366 15.8334ZM15.0003 10C15.0003 10.2211 15.0881 10.433 15.2444 10.5893C15.4007 10.7456 15.6126 10.8334 15.8337 10.8334H17.5003C17.7213 10.8334 17.9333 10.7456 18.0896 10.5893C18.2459 10.433 18.3337 10.2211 18.3337 10C18.3337 9.77903 18.2459 9.56707 18.0896 9.41079C17.9333 9.25451 17.7213 9.16671 17.5003 9.16671L15.8337 9.16671C15.6126 9.16671 15.4007 9.25451 15.2444 9.41079C15.0881 9.56707 15.0003 9.77903 15.0003 10ZM8.33366 2.50004V3.33337H2.50033C2.27931 3.33337 2.06735 3.42117 1.91107 3.57745C1.75479 3.73373 1.66699 3.94569 1.66699 4.16671C1.66699 4.38772 1.75479 4.59968 1.91107 4.75596C2.06735 4.91224 2.27931 5.00004 2.50033 5.00004H8.33366V5.83337C8.33366 6.05439 8.42146 6.26635 8.57774 6.42263C8.73402 6.57891 8.94598 6.66671 9.16699 6.66671C9.38801 6.66671 9.59997 6.57891 9.75625 6.42263C9.91253 6.26635 10.0003 6.05439 10.0003 5.83337L10.0003 2.50004C10.0003 2.27903 9.91253 2.06706 9.75625 1.91079C9.59997 1.75451 9.38801 1.66671 9.16699 1.66671C8.94598 1.66671 8.73402 1.75451 8.57774 1.91079C8.42146 2.06706 8.33366 2.27903 8.33366 2.50004ZM11.667 4.16671C11.667 4.38772 11.7548 4.59968 11.9111 4.75596C12.0674 4.91224 12.2793 5.00004 12.5003 5.00004L17.5003 5.00004C17.7213 5.00004 17.9333 4.91224 18.0896 4.75596C18.2459 4.59968 18.3337 4.38772 18.3337 4.16671C18.3337 3.94569 18.2459 3.73373 18.0896 3.57745C17.9333 3.42117 17.7213 3.33337 17.5003 3.33337L12.5003 3.33337C12.2793 3.33337 12.0674 3.42117 11.9111 3.57745C11.7548 3.73373 11.667 3.94569 11.667 4.16671ZM11.667 8.33337V9.16671H2.50033C2.27931 9.16671 2.06735 9.25451 1.91107 9.41079C1.75479 9.56707 1.66699 9.77903 1.66699 10C1.66699 10.2211 1.75479 10.433 1.91107 10.5893C2.06735 10.7456 2.27931 10.8334 2.50033 10.8334H11.667V11.6667C11.667 11.8877 11.7548 12.0997 11.9111 12.256C12.0674 12.4122 12.2793 12.5 12.5003 12.5C12.7213 12.5 12.9333 12.4122 13.0896 12.256C13.2459 12.0997 13.3337 11.8877 13.3337 11.6667V8.33337C13.3337 8.11236 13.2459 7.9004 13.0896 7.74412C12.9333 7.58784 12.7213 7.50004 12.5003 7.50004C12.2793 7.50004 12.0674 7.58784 11.9111 7.74412C11.7548 7.9004 11.667 8.11236 11.667 8.33337Z" fill="white" />
                    </g>
                </svg>
                <span class="mx-2">Filtres</span>
            </a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gerer_parametrage')): ?>
            <a href="<?php echo e(route('region.create')); ?>" class="px-3 rounded-md py-3 flex text-white text-xs font-bold text-center bg-orange-400 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                        <path id="Vector" d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z" fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_705_6988">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg><span class="mx-2">Ajouter une region</span>

            </a>
            <?php endif; ?>
        </div>
    </div>
<!--[if BLOCK]><![endif]--><?php if($count): ?>
<div class="mb-2"><span class="bg-green-100 font-bold p-1 px-2 rounded"><?php echo e($count); ?> régions trouvées</span></div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <div class="w-full rounded-lg shadow-xs p-0">
        <div class="text-sm w-full p-0">
            <table class="w-full border-t mb-3">
                <thead>
                    <tr
                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b bg-first-orange">
                        <th class="px-4 py-3">N° </th>
                        <th class="px-4 py-4">Code</th>
                        <th class="px-4 py-4">Nom</th>
                        <th class="px-4 py-4 w-[60px]">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y ">
                    <?php
                        $num = 1;
                    ?>
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="text-gray-700 ">
                            
                            <td class="px-6 py-3 border-b"><?php echo e($num); ?></td>
                            <td class="px-6 py-3 border-b"><?php echo e($region->code ?? ' - '); ?></td>
                
                            <td class="px-6 py-3 border-b"><?php echo e($region->libelle ?? '-'); ?></td>

                            <td class="px-6 py-3 border-b flex">
                                <div class="relative" x-data="{ open: false }" @click.away="open = false"
                                    @close.stop="open = false">
                                    <div @click="open = ! open">
                                        <button
                                            class="bg-dark hover:first-orange text-white font-semibold py-2 px-6 rounded inline-flex items-center justify-end">

                                            <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="Iconly/Light-Outline/More-Circle">
                                                    <g id="More-Circle">
                                                        <g id="Combined-Shape">
                                                            <path
                                                                d="M17.5 2C17.5 1.06211 16.7419 0.303986 15.804 0.303986H15.787C14.8508 0.303986 14.0995 1.06211 14.0995 2C14.0995 2.9379 14.8661 3.69602 15.804 3.69602C16.7419 3.69602 17.5 2.9379 17.5 2Z"
                                                                fill="#1A4085" />
                                                            <path
                                                                d="M10.6995 2C10.6995 1.06211 9.94138 0.303986 9.00348 0.303986H8.98822C8.05032 0.303986 7.30068 1.06211 7.30068 2C7.30068 2.9379 8.06559 3.69602 9.00348 3.69602C9.94138 3.69602 10.6995 2.9379 10.6995 2Z"
                                                                fill="#1A4085" />
                                                            <path
                                                                d="M3.90051 2C3.90051 1.06211 3.14239 0.303986 2.2045 0.303986H2.18923C1.25134 0.303986 0.5 1.06211 0.5 2C0.5 2.9379 1.2666 3.69602 2.2045 3.69602C3.14239 3.69602 3.90051 2.9379 3.90051 2Z"
                                                                fill="#1A4085" />
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>

                                        </button>
                                    </div>

                                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute z-50 mt-1 w-48 rounded-md shadow-lg origin-top-right right-0"
                                        @click="open = false" style="display: none;">
                                        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
                                            <div class="border shadow-md py-2 text-center">
                                                <a href="<?php echo e(route('region.show', $region->id)); ?>"
                                                    class="text-purple-600">Voir
                                                </a>
                                            </div>
                                            <div class="border shadow-md py-2 text-center">
                                                <a href="<?php echo e(route('region.edit', $region->id)); ?>" class="text-purple-600">
                                                    Modifier
                                                </a>
                                            </div>
                                            <div class="border shadow-md py-2 text-center">
                                            <?php echo Form::open(array(
                    'method' => 'DELETE',
                    'class' => 'delete-form',
                    'style' => 'display: inline;',
                    'route' => array('region.destroy', $region->id))); ?>

                    <?php echo e(csrf_field()); ?>

                    <a href="#" class="text-red-500 mr-2 apix-delete" data-toggle="tooltip" title="Supprimer">
                    <span class="text-purple-600">Supprimer</span>
                    </a>
                    <?php echo Form::close(); ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            </td>
                            <?php
                                $num += 1;
                            ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="px-6 py-4 font-bold text-lg text-center">Aucune donnée disponible</td></tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
            <div class="flex justify-start items-center mt-5">
                <button <?php echo e($startLimit == 0 ? 'disabled' : ''); ?> wire:click="prev" type="button" class="bg-white px-6 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none">
                        <path id="Polygon 1" d="M0.982423 8.69351C-0.0296571 7.89277 -0.0296574 6.35734 0.982422 5.55659L7.00906 0.788418C8.32029 -0.249004 10.25 0.684883 10.25 2.35688V11.8932C10.25 13.5652 8.32029 14.4991 7.00906 13.4617L0.982423 8.69351Z" fill="black"/>
                    </svg>
                </button>
                <span class="text-md text-black mx-3"><?php echo e(min($count,$startLimit+1)); ?> à <?php echo e(min($startLimit+10,$count)); ?> sur <?php echo e($count); ?></span>
                <button wire:click="next" <?php echo e(($startLimit+10) >= $count ? 'disabled' : ''); ?> type="button" class="bg-white px-6 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
                    <svg class="w-4 h-4" width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path id="Polygon 1" d="M10.0176 5.55649C11.0297 6.35723 11.0297 7.89266 10.0176 8.69341L3.99094 13.4616C2.67971 14.499 0.75 13.5651 0.75 11.8931L0.75 2.35677C0.75 0.684774 2.67971 -0.249114 3.99094 0.788308L10.0176 5.55649Z" fill="black"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/regions/liste-region.blade.php ENDPATH**/ ?>