<div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-600">
        <thead class="text-xs text-white uppercase bg-first-orange dark:bg-first-orange dark:text-white">
            <tr>
                <th scope="col" class="px-6 py-3 text-center"></th>
                <?php if(optional(optional(Auth()->user()->personnel)->etablissement)->id == null): ?>
                <th scope="col" class="px-6 py-3 text-center">Etablissement</th>
                <?php endif; ?>
                <th scope="col" class="px-6 py-3 text-center">Nom</th>
                <th scope="col" class="px-6 py-3 text-center">Prénom</th>
                <th scope="col" class="px-6 py-3 text-center">Courrier</th>
                <th scope="col" class="px-6 py-3 text-center">Téléphone</th>
                
                <th scope="col" class="px-6 py-3 text-center">Profil</th>
                <th scope="col" class="px-6 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php if($users->count() == 0): ?>
            <tr>

                <td <?php if(optional(optional(Auth()->user()->personnel)->etablissement)->id == null): ?> colspan="8" <?php else: ?> colspan="7" <?php endif; ?> class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center hover:border-l-8 border-first-orange">
                    Aucun utilisateur à afficher.
                </td>
            </tr>
            <?php endif; ?>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="bg-white border-b dark:bg-white dark:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-100">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center hover:border-l-8 border-first-orange">
                    <img class="min-avatar" src="<?php echo e(!empty($user->profile_photo_path) ? asset('storage/avatars/'.$user->profile_photo_path) : asset('assets/images/user.png')); ?>" alt="user">
                </td>
                <?php if(optional(optional(Auth()->user()->personnel)->etablissement)->id == null): ?>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    <?php echo e(optional(optional($user->personnel)->etablissement)->nom); ?>

                </td>
                <?php endif; ?>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    <?php echo e($user->nom); ?>

                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    <?php echo e($user->prenom); ?>

                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    <?php echo e($user->email); ?>

                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    <?php echo e($user->telephone); ?>

                </td>
                
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="inline-block px-3 py-1 mb-2 mr-1 text-sm font-bold text-white bg-gray rounded-lg">
                        <?php echo e($role->description ?? 'Non renseigné'); ?>

                    </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="<?php echo e(route('users.show', $user)); ?>" class="text-blue-500 mr-2 hover:text-blue-200 focus:text-blue-200" data-toggle="tooltip" title="Détail">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </a>
                    <a href="<?php echo e(route('users.accessForum', $user)); ?>" class="text-blue-500 mr-2 hover:text-blue-200 focus:text-blue-200" data-toggle="tooltip" title="Accès forum">
                        <i class="fas fa-globe text-green-500"></i>
                    </a>
                    <?php echo Form::open(array(
                    'method' => 'PATCH',
                    'class' => 'apix-form',
                    'style' => 'display: inline;',
                    'route' => array('users.activation', $user->id))); ?>

                    <?php echo e(csrf_field()); ?>

                    <?php if($user->isActive()): ?>
                    <a href="#" class="text-yellow-500 mr-2 apix-confirm" data-toggle="tooltip" title="Désactiver">
                        <i class="fas fa-lock text-yellow-500"></i>
                    </a>
                    <?php else: ?>
                    <a href="#" class="text-green-500 mr-2 apix-confirm" data-toggle="tooltip" title="Activer">
                        <i class="fas fa-check text-green-500"></i>
                    </a>
                    <?php endif; ?>
                    <?php echo Form::close(); ?>

                    <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-black-50 mr-2 hover:text-black-200 focus:text-black-200" data-toggle="tooltip" title="Modifier">
                        <i class="fas fa-edit text-black-50"></i>
                    </a>
                    <?php echo Form::open(array(
                    'method' => 'PATCH',
                    'class' => 'apix-form',
                    'style' => 'display: inline;',
                    'route' => array('users.resetPassword', $user->id))); ?>

                    <?php echo e(csrf_field()); ?>

                    <a href="#" class="text-red-500 mr-2 apix-confirm" data-toggle="tooltip" title="Réinitialiser mot de passe">
                        <i class="fas fa-refresh text-red-500"></i>
                    </a>
                    <?php echo Form::close(); ?>

                     <?php if($isDeletable): ?>
                        <?php echo Form::open(array(
                                            'method' => 'DELETE',
                                            'class' => 'delete-form',
                                            'style' => 'display: inline;',
                                            'route' => array('users.destroy', $user))); ?>

                        <?php echo e(csrf_field()); ?>

                    <a href="#delete" class="text-danger apix-delete" data-toggle="tooltip" title="Supprimer">
                        <i class="fas fa-trash text-red-500"></i>
                    </a>
                    <?php echo Form::close(); ?>

                    <?php endif; ?> 
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="p-2">
        <?php echo e($users->links('pagination::tailwind')); ?>

    </div>
</div>
<?php /**PATH /var/www/html/amie-fpt/resources/views/admin/users/partials/_listefa.blade.php ENDPATH**/ ?>