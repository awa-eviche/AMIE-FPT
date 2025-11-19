<div>

    
        


   
    <div class="flex justify-between items-center mb-3 flex-wrap" >
        <div class="flex my-3">
            <p wire:click="resetAll" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white mr-2">Tous</p>
            
            <p class="px-3">
                <select wire:change="filterFunction($event.target.value)" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 text-gray-700 text-sm leading-tight focus:outline-none focus:border-first-orange enlever_shadow font-bold" id="status" name="status" required>
                    <option class="text-sm" value="">Par status</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $fonctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fonction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option class="text-sm" value="<?php echo e($fonction->fonction); ?>"><?php echo e($fonction->fonction); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>

            </p>
            <p>
                

            </p>
            
        </div>
        <div class="h-full flex justify-end flex-1 ml-5">
            

            <div class="relative w-1/4 focus-within:text-first-orange shadow">
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

    <!--[if BLOCK]><![endif]--><?php if($users->count() > 0): ?>
        <div class="w-full overflow-hidden rounded-lg shadow-xs p-0">
            <div class="text-sm w-full overflow-x-scroll p-0">
                <table class="w-full border-t mb-3">
                    <thead>
                        <tr class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b bg-first-orange">
                            <th class="px-4 py-3">Nom </th>
                            <th class="px-4 py-4">Prenom</th>
                            <th class="px-4 py-4">Email</th>
                            <th class="px-4 py-4">Téléphone</th>
                            <th class="px-4 py-4">Fonction</th>
                            <th class="px-4 py-4">Adresse</th>
                            <th class="px-4 py-4">Date Naissance</th>
                            <th class="px-4 py-4 w-[60px]">Lieu Naissance</th>
                        </tr>
                    </thead>
    
                    <tbody class="bg-white divide-y ">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        
                            <tr class="text-gray-700 ">
                                <td class="px-6 py-3 border-b"><?php echo e($user->nom ?? ' - '); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo e($user->prenom ?? '-'); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo e($user->email ?? '-'); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo e($user->telephone ?? '-'); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo e($user->personnel->fonction ?? '-'); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo e($user->adresse ?? '-'); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo e($user->date_naissance ?? '-'); ?></td>
                                <td class="px-6 py-3 border-b"><?php echo e($user->lieu_naissance ?? '-'); ?></td>
    
                               
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="px-6 py-4 font-bold text-lg text-center">Aucune donnée disponible</td></tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>

                <?php echo e($users->links()); ?>

            </div>
        </div>

    <?php else: ?>
        <p class="text-first-orange text-center text-lg font-bold py-4 bg-white">Il n'y a aucune demande </p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div>
<?php /**PATH /var/www/html/pgi/resources/views/livewire/etablissements/get-all-personnel.blade.php ENDPATH**/ ?>