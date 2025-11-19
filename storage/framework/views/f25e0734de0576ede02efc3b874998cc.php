<div>
    <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
        <p>
            <a href="/dashboard" class="">Accueil</a>
            <span class="mx-2 ">/</span>
        </p>
        <p><a href="<?php echo e(route('actualite.index')); ?>">Page d'acceuil</a>

            <span class="mx-2 ">/</span>
        </p>
        <p class="text-first-orange">Actualité</p>
        <p></p>
    </div>


    <div class="flex mb-5 justify-between">
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
            <a href="<?php echo e(route('actualite.create')); ?>"
               class="px-3 rounded-md py-3 flex text-white text-sm text-center bg-first-orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                        <path id="Vector"
                              d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z"
                              fill="white"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_705_6988">
                            <rect width="20" height="20" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
                <span class="mx-2">Ajouter une actualité</span>
            </a>
        </div>
    </div>


    <div class="w-full rounded-lg shadow-xs p-0">

        <div class="text-sm w-full p-0 overflow-x-auto">
            <table class="w-full border-t mb-3">
                <thead>
                <tr
                    class="text-xs font-black tracking-wide text-left text-white font-bold uppercase border-b bg-first-orange">
                    
                    <th class="px-4 py-4 text-white">Image</th>
                    <th class="px-4 py-4 text-white">Titre</th>
                    <th class="px-4 py-4 text-white">Statut</th>
                    <th class="px-4 py-4 text-white">Date de création</th>
                    <th class="px-4 py-4 text-end">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y ">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $actualites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actualite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 border-b">
                            <a target="_blank"
                               href="<?php echo e(asset('storage/'.$actualite->image)); ?>"><img
                                    class="w-20"
                                    src="<?php echo e(asset('storage/'. $actualite->image)); ?>"
                                    alt="avatar"/></a>
                        </td>
                        <td class="px-4 py-3 border-b">
                            <?php echo e($actualite->title ?? ' - '); ?></td>
                        <td class="px-4 py-3 border-b"><span
                                class="px-2 py-1 <?php echo e(($actualite->status != "published") ? 'bg-red-100 text-red' : 'bg-green-100 text-green'); ?> rounded"><?php echo e($actualite->status == "published" ? 'Publié' : 'Non Publié'); ?></span>
                        </td>

                        <td class="px-4 py-3 border-b "><?php echo e(date('d-m-Y',strtotime($actualite->created_at)) ?? '-'); ?></td>

                        <td class="px-4 py-3 border-b text-end">
                            <div class="relative" x-data="{ open: false }" @click.away="open = false"
                                 @close.stop="open = false">
                                <div @click="open = ! open">
                                    <button
                                        class="bg-dark hover:first-orange text-white font-semibold py-2 px-4 rounded inline-flex items-center justify-end">

                                        <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g id="Iconly/Light-Outline/More-Circle">
                                                <g id="More-Circle">
                                                    <g id="Combined-Shape">
                                                        <path
                                                            d="M17.5 2C17.5 1.06211 16.7419 0.303986 15.804 0.303986H15.787C14.8508 0.303986 14.0995 1.06211 14.0995 2C14.0995 2.9379 14.8661 3.69602 15.804 3.69602C16.7419 3.69602 17.5 2.9379 17.5 2Z"
                                                            fill="#1A4085"/>
                                                        <path
                                                            d="M10.6995 2C10.6995 1.06211 9.94138 0.303986 9.00348 0.303986H8.98822C8.05032 0.303986 7.30068 1.06211 7.30068 2C7.30068 2.9379 8.06559 3.69602 9.00348 3.69602C9.94138 3.69602 10.6995 2.9379 10.6995 2Z"
                                                            fill="#1A4085"/>
                                                        <path
                                                            d="M3.90051 2C3.90051 1.06211 3.14239 0.303986 2.2045 0.303986H2.18923C1.25134 0.303986 0.5 1.06211 0.5 2C0.5 2.9379 1.2666 3.69602 2.2045 3.69602C3.14239 3.69602 3.90051 2.9379 3.90051 2Z"
                                                            fill="#1A4085"/>
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
                                            <form class="text-center"
                                                  action="<?php echo e(route('actualite.publier', $actualite->id)); ?>"
                                                  method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('POST'); ?>
                                                <button title="Supprimer" type="submit" class="text-purple-600">
                                                    <?php echo e($actualite->status == "published" ? "Dépublier" : "Publier"); ?>

                                                </button>
                                            </form>
                                        </div>
                                        <div class="border shadow-md py-2 text-center">
                                            <a href="<?php echo e(route('actualite.edit', $actualite->id)); ?>"
                                               class="text-purple-600">
                                                Modifier
                                            </a>
                                        </div>

                                        <div class="border shadow-md py-2 text-center">
                                            <?php echo Form::open(array(
                                                'method' => 'DELETE',
                                                'class' => 'delete-form',
                                                'style' => 'display: inline;',
                                                'route' => array('actualite.destroy', $actualite->id))); ?>

                                            <?php echo e(csrf_field()); ?>

                                            <a href="#delete" class="text-purple-600 apix-delete" data-toggle="tooltip"
                                               title="Supprimer cette actualité">
                                                Supprimer
                                            </a>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-4 py-4 font-bold text-lg text-center">Aucune donnée disponible</td>
                    </tr>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
            <!--[if BLOCK]><![endif]--><?php if($count > 10): ?>
                <div class="flex justify-start items-center mt-5">
                    <button <?php echo e($startLimit == 0 ? 'disabled' : ''); ?> wire:click="prev" type="button"
                            class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="11" height="14"
                             viewBox="0 0 11 14" fill="none">
                            <path id="Polygon 1"
                                  d="M0.982423 8.69351C-0.0296571 7.89277 -0.0296574 6.35734 0.982422 5.55659L7.00906 0.788418C8.32029 -0.249004 10.25 0.684883 10.25 2.35688V11.8932C10.25 13.5652 8.32029 14.4991 7.00906 13.4617L0.982423 8.69351Z"
                                  fill="black"/>
                        </svg>
                    </button>
                    <span class="text-md text-black mx-3"><?php echo e(min($count,$startLimit+1)); ?> à <?php echo e(min($startLimit+10,$count)); ?> sur <?php echo e($count); ?></span>
                    <button wire:click="next" <?php echo e(($startLimit+10) >= $count ? 'disabled' : ''); ?> type="button"
                            class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
                        <svg class="w-4 h-4" width="11" height="14" viewBox="0 0 11 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path id="Polygon 1"
                                  d="M10.0176 5.55649C11.0297 6.35723 11.0297 7.89266 10.0176 8.69341L3.99094 13.4616C2.67971 14.499 0.75 13.5651 0.75 11.8931L0.75 2.35677C0.75 0.684774 2.67971 -0.249114 3.99094 0.788308L10.0176 5.55649Z"
                                  fill="black"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/page-acceuil/actualite.blade.php ENDPATH**/ ?>