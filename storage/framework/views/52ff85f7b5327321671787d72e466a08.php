<div>


    <div class="flex justify-between items-center mb-3 flex-wrap" >
        <div class="flex my-3">
            <p wire:click="resetAll" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white mr-2">Tous</p>
            
            <p class="flex items-center font-bold bg-white rounded py-1 px-3 text-sm cursor-pointer border-2 <?php echo e($filterByMyState ? 'border-first-orange text-first-orange' : ''); ?>" wire:click="toggleFilterByMyState">Me concernant</p>
            <p class="px-3">
                <select wire:change="setStatusDemandeFiltre($event.target.value)" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 text-gray-700 text-sm leading-tight focus:outline-none focus:border-first-orange enlever_shadow font-bold" id="status" name="status" required>
                    <option class="text-sm" value="">Par status</option>
                    <option class="text-sm" value="<?php echo e(App\Enums\StatusDemandeEnum::BROUILLON); ?>">Brouillon</option>
                    <option class="text-sm" value="<?php echo e(App\Enums\StatusDemandeEnum::COURS); ?>">En cours</option>
                    <option class="text-sm" value="<?php echo e(App\Enums\StatusDemandeEnum::REJETE); ?>">Rejeté</option>
                    <option class="text-sm" value="<?php echo e(App\Enums\StatusDemandeEnum::ATTENTE); ?>">A compléter</option>
                    <option class="text-sm" value="<?php echo e(App\Enums\StatusDemandeEnum::VALIDE); ?>">Validé</option>
                </select>

            </p>
            <p>
                <select wire:change="setTypeDemandeFiltreId($event.target.value)" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:border-first-orange enlever_shadow font-bold " id="status" name="status" required>
                    <option class="text-sm" value="0">Type de demande</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $typeDemandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeDemande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option class="text-sm" value="<?php echo e($typeDemande->id); ?>"><?php echo e($typeDemande->libelle); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </p>
            
        </div>
        <div class="h-full flex justify-end flex-1 ml-5">
            

            <div class="relative w-full focus-within:text-first-orange shadow">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path  fill-rule="evenodd"  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <form wire:submit.prevent="setSearch">
                    <input wire:model="search" class="border-2 border-gray-300 py-2 w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-white border-0 rounded focus:placeholder-gray-500 enlever_shadow form-input py-1" type="search" placeholder="Rechercher des demandes" aria-label="Search"/>

                </form>
            </div>
        </div>

    </div>

    <!--[if BLOCK]><![endif]--><?php if($demandes->count() > 0): ?>
        <div class="w-full overflow-hidden rounded-lg shadow-xs p-0">
            <div class="text-sm w-full overflow-x-scroll p-0">
                <table class="w-full border-t">
                    <thead>
                        <tr class="text-xs font-black tracking-wide text-left text-maquette-gris uppercase border-b bg-first-orange">
                            <th wire:click="setOrderField('id')" class="cursor-pointer flex items-center px-4 py-4 font-bold">
                                <span class="mr-3">
                                    N°
                                </span>
                                <!--[if BLOCK]><![endif]--><?php if($orderField == "id" && $orderDirection =="ASC"): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                        <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                    </svg>

                                <?php elseif($orderField =="id"): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                    </svg>

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            </th>
                            <th wire:click="setOrderField('libelle')" class="px-2 py-4 font-bold cursor-pointer">
                                <p class="flex items-center">
                                    <span class="mr-3">
                                        Libelle
                                    </span>
                                    <!--[if BLOCK]><![endif]--><?php if($orderField == "libelle" && $orderDirection =="ASC"): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                        </svg>

                                    <?php elseif($orderField =="libelle"): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                </p>
                            </th>
                            <th wire:click="setOrderField('type_demandes.libelle')" class="px-2 py-4 font-bold cursor-pointer">
                                <p class="flex items-center">
                                    <span class="mr-3">
                                        Type
                                    </span>
                                    <!--[if BLOCK]><![endif]--><?php if($orderField == "type_demandes.libelle" && $orderDirection =="ASC"): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                        </svg>

                                    <?php elseif($orderField =="type_demandes.libelle"): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </p>
                            </th>
                            <th wire:click="setOrderField('etablissements.nom')" class="px-2 py-4 font-bold cursor-pointer">
                                <p class="flex items-center">
                                    <span class="mr-3">
                                        Etablissement
                                    </span>
                                    <!--[if BLOCK]><![endif]--><?php if($orderField == "etablissements.nom" && $orderDirection =="ASC"): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                        </svg>

                                    <?php elseif($orderField =="etablissements.nom"): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                </p>
                            </th>
                            <th wire:click="setOrderField('etat_workflows.libelle')" class="px-2 py-4 font-bold cursor-pointer">Etat</th>
                            <th class="px-1 text-center py-4 font-bold">Actions</th>
                        </tr>

                    </thead>
                    <tbody class="bg-white divide-y">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $demandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-gray-700">
                                <td class="px-2 py-3 border-b font-bold"><?php echo e($demande->id ?? " "); ?></td>
                                <td class="px-2 py-3 border-b font-bold"><?php echo e($demande->libelle?? "- "); ?></td>
                                <td class="px-2 py-3 border-b font-bold"><?php echo e($demande->type_demande_libelle ?? " - "); ?></td>
                                <td class="px-2 py-3 border-b font-bold"><?php echo e($demande->nom_etablissement ?? "-"); ?></td>
                                <td class="px-2 py-3 border-b font-bold">
                                <!--[if BLOCK]><![endif]--><?php if($demande->est_rejete == true ): ?>
                                <span class="bg-red-200 py-1 px-2 rounded text-sm text-red-800 font-bold">Rejeté</span>
                                <?php else: ?>
                                    
                                    <span class="bg-green-200 py-1 px-2 rounded text-sm text-green-800 font-bold"><?php echo e($demande->etat_libelle?? " - "); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="px-4 py-3 border-b font-bold text-maquette-gris">
                                    <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                        <a href="<?php echo e(route('demande.show', $demande->id)); ?>" class="text-maquette-gris">
                                            <svg width="15" height="13" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>

                                        </a>
                                        <a href="<?php echo e(route('demande.edit', $demande->id)); ?>" class="text-purple-600">
                                            <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 9.5058L5 10.0458L5.5 7.0058L11.23 1.2958C11.323 1.20207 11.4336 1.12768 11.5554 1.07691C11.6773 1.02614 11.808 1 11.94 1C12.072 1 12.2027 1.02614 12.3246 1.07691C12.4464 1.12768 12.557 1.20207 12.65 1.2958L13.71 2.3558C13.8037 2.44876 13.8781 2.55936 13.9289 2.68122C13.9797 2.80308 14.0058 2.93379 14.0058 3.0658C14.0058 3.19781 13.9797 3.32852 13.9289 3.45037C13.8781 3.57223 13.8037 3.68284 13.71 3.7758L8 9.5058Z" stroke="#929EAE" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12.5 10.0059V13.0059C12.5 13.2711 12.3946 13.5254 12.2071 13.713C12.0196 13.9005 11.7652 14.0059 11.5 14.0059H2C1.73478 14.0059 1.48043 13.9005 1.29289 13.713C1.10536 13.5254 1 13.2711 1 13.0059V3.50586C1 3.24064 1.10536 2.98629 1.29289 2.79875C1.48043 2.61122 1.73478 2.50586 2 2.50586H5" stroke="#929EAE" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>

                                        </a>
                                        <form class="text-center" action="<?php echo e(route('demande.destroy', $demande->id)); ?>" method="POST">

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button title="supprimer" type="submit" class="text-purple-600">
                                                <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20 10.5V11H28V10.5C28 9.43913 27.5786 8.42172 26.8284 7.67157C26.0783 6.92143 25.0609 6.5 24 6.5C22.9391 6.5 21.9217 6.92143 21.1716 7.67157C20.4214 8.42172 20 9.43913 20 10.5ZM17.5 11V10.5C17.5 8.77609 18.1848 7.12279 19.4038 5.90381C20.6228 4.68482 22.2761 4 24 4C25.7239 4 27.3772 4.68482 28.5962 5.90381C29.8152 7.12279 30.5 8.77609 30.5 10.5V11H41.75C42.0815 11 42.3995 11.1317 42.6339 11.3661C42.8683 11.6005 43 11.9185 43 12.25C43 12.5815 42.8683 12.8995 42.6339 13.1339C42.3995 13.3683 42.0815 13.5 41.75 13.5H38.833L36.833 37.356C36.681 39.1676 35.854 40.856 34.5158 42.0866C33.1776 43.3172 31.426 44.0001 29.608 44H18.392C16.5742 43.9998 14.8228 43.3168 13.4848 42.0863C12.1468 40.8557 11.3199 39.1674 11.168 37.356L9.168 13.5H6.25C5.91848 13.5 5.60054 13.3683 5.36612 13.1339C5.1317 12.8995 5 12.5815 5 12.25C5 11.9185 5.1317 11.6005 5.36612 11.3661C5.60054 11.1317 5.91848 11 6.25 11H17.5ZM13.659 37.147C13.7585 38.3338 14.3003 39.4399 15.1769 40.2462C16.0535 41.0524 17.201 41.4999 18.392 41.5H29.608C30.7992 41.5002 31.9469 41.0528 32.8237 40.2465C33.7005 39.4403 34.2424 38.334 34.342 37.147L36.324 13.5H11.676L13.659 37.147ZM21.5 20.25C21.5 20.0858 21.4677 19.9233 21.4049 19.7716C21.342 19.62 21.25 19.4822 21.1339 19.3661C21.0178 19.25 20.88 19.158 20.7284 19.0951C20.5767 19.0323 20.4142 19 20.25 19C20.0858 19 19.9233 19.0323 19.7716 19.0951C19.62 19.158 19.4822 19.25 19.3661 19.3661C19.25 19.4822 19.158 19.62 19.0951 19.7716C19.0323 19.9233 19 20.0858 19 20.25V34.75C19 34.9142 19.0323 35.0767 19.0951 35.2284C19.158 35.38 19.25 35.5178 19.3661 35.6339C19.4822 35.75 19.62 35.842 19.7716 35.9049C19.9233 35.9677 20.0858 36 20.25 36C20.4142 36 20.5767 35.9677 20.7284 35.9049C20.88 35.842 21.0178 35.75 21.1339 35.6339C21.25 35.5178 21.342 35.38 21.4049 35.2284C21.4677 35.0767 21.5 34.9142 21.5 34.75V20.25ZM27.75 19C28.44 19 29 19.56 29 20.25V34.75C29 35.0815 28.8683 35.3995 28.6339 35.6339C28.3995 35.8683 28.0815 36 27.75 36C27.4185 36 27.1005 35.8683 26.8661 35.6339C26.6317 35.3995 26.5 35.0815 26.5 34.75V20.25C26.5 19.56 27.06 19 27.75 19Z" fill="#FF0000"/>
                                                </svg>

                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>

                <?php echo e($demandes->links()); ?>

            </div>
        </div>

    <?php else: ?>
        <p class="text-first-orange text-center text-lg font-bold py-4 bg-white">Il n'y a aucune demande </p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/demandes/liste-demande.blade.php ENDPATH**/ ?>