<root>
        <div class="relative z-0 w-full mb-6 group">
            <label for="roles1" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Profil</label>
            <?php echo Form::select('roles[]', $roles, $role, ['id' => 'roles1', 'class' => $inputClass, 'required' => 'true',
            'data-control' => 'select2', 'data-allow-clear' => 'true', 'placeholder' => 'Choisir...', 'wire:model' => 'role',
            'wire:change'=>'$refresh']); ?>

        </div>

        <?php if($role == config('constants.roles.ia') || $role == config('constants.roles.ief')): ?>
        <div class="relative z-0 w-full mb-6 group">
            <label for="roles2" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">IA</label>
            <?php echo Form::select('roles[]', $roles, $role, ['id' => 'roles2', 'class' => $inputClass, 'required' => 'true',
            'data-control' => 'select2', 'data-allow-clear' => 'true', 'placeholder' => 'Choisir...', 'wire:model' => 'role',
            'wire:change'=>'$refresh']); ?>

        </div> 
        <?php endif; ?>
    
        <?php if($role == config('constants.roles.ief')): ?>
        <div class="relative z-0 w-full mb-6 group">
            <label for="roles3" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">IEF</label>
            <?php echo Form::select('roles[]', $roles, $role, ['id' => 'roles3', 'class' => $inputClass, 'required' => 'true',
            'data-control' => 'select2', 'data-allow-clear' => 'true', 'placeholder' => 'Choisir...', 'wire:model' => 'role',
            'wire:change'=>'$refresh']); ?>

        </div>
        <?php endif; ?>
</root><?php /**PATH /var/www/html/amie-fpt/resources/views/livewire/admin/create-user.blade.php ENDPATH**/ ?>