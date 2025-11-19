    <div
        x-data="{ linkActive: <?php if ((object) ('linkActive') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('linkActive'->value()); ?>')<?php echo e('linkActive'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('linkActive'); ?>')<?php endif; ?> }"
        class="relative mx-6 text-gray-600 hover:text-gray-700 cursor-pointer"
    >
        <!-- start::Main link -->
        <div
            @click="linkActive = !linkActive"
            class="cursor-pointer flex"
        >
            <svg class="w-6 h-6 cursor-pointer hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <sub>
                <span id="notification-counter" class="bg-first-orange text-gray-100 px-1.5 py-0.5 rounded-full -ml-1">
                    <?php echo e($unreadNotificationsCount); ?>

                </span>
            </sub>
        </div>
        <!-- end::Main link -->

        <!-- start::Submenu -->
        <div
            x-show="linkActive"
            @click.away="linkActive = false"
            x-cloak
            class="absolute right-0 w-96 top-11 border border-gray-300 z-10"
        >
            <!-- start::Submenu content -->
            <div class="bg-white rounded max-h-96 overflow-y-scroll custom-scrollbar">
                <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right']); ?>
                     <?php $__env->slot('trigger', null, []); ?> 
                        <p class="flex justify-end mx-3 mt-1">
                            <span class="w-min py-1 px-2 bg-gray-100 rounded">
                                <svg width="15" height="10" viewBox="0 0 18 4" fill="none"
                                    >
                                    <g id="Iconly/Light-Outline/More-Circle"><g id="More-Circle">
                                        <g id="Combined-Shape">
                                            <path d="M17.5 2C17.5 1.06211 16.7419 0.303986 15.804 0.303986H15.787C14.8508 0.303986 14.0995 1.06211 14.0995 2C14.0995 2.9379 14.8661 3.69602 15.804 3.69602C16.7419 3.69602 17.5 2.9379 17.5 2Z" fill="#f37930" />
                                            <path d="M10.6995 2C10.6995 1.06211 9.94138 0.303986 9.00348 0.303986H8.98822C8.05032 0.303986 7.30068 1.06211 7.30068 2C7.30068 2.9379 8.06559 3.69602 9.00348 3.69602C9.94138 3.69602 10.6995 2.9379 10.6995 2Z" fill="#f37930" />
                                            <path d="M3.90051 2C3.90051 1.06211 3.14239 0.303986 2.2045 0.303986H2.18923C1.25134 0.303986 0.5 1.06211 0.5 2C0.5 2.9379 1.2666 3.69602 2.2045 3.69602C3.14239 3.69602 3.90051 2.9379 3.90051 2Z" fill="#f37930" />
                                        </g>
                                    </g></g>
                                </svg>

                            </span>
                        </p>
                     <?php $__env->endSlot(); ?>

                     <?php $__env->slot('content', null, []); ?> 
                        <div class="border shadow-xl p-2 py-3">
                            <p class="py-1 flex items-center hover:bg-gray-100 px-2 py-1" wire:click ="toggleChargeUnread">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#f37930" class="bi bi-bell-slash mr-2" viewBox="0 0 16 16">
                                    <path d="M5.164 14H15c-.299-.199-.557-.553-.78-1-.9-1.8-1.22-5.12-1.22-6 0-.264-.02-.523-.06-.776l-.938.938c.02.708.157 2.154.457 3.58.161.767.377 1.566.663 2.258H6.164zm5.581-9.91a3.986 3.986 0 0 0-1.948-1.01L8 2.917l-.797.161A4.002 4.002 0 0 0 4 7c0 .628-.134 2.197-.459 3.742-.05.238-.105.479-.166.718l-1.653 1.653c.02-.037.04-.074.059-.113C2.679 11.2 3 7.88 3 7c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0c.942.19 1.788.645 2.457 1.284l-.707.707zM10 15a2 2 0 1 1-4 0zm-9.375.625a.53.53 0 0 0 .75.75l14.75-14.75a.53.53 0 0 0-.75-.75z"/>
                                  </svg>
                                <span class="text-xs">
                                    <?php echo e($chargeUnread ? 'Les plus récentes' : 'Les non lues'); ?>

                                </span>

                            </p>
                            <hr>
                            <p class="py-1 flex items-center hover:bg-gray-100  px-2 py-1" >
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3" fill ="#f37930" height="12" width="12" viewBox="0 0 512 512">
                                    <path d="M160 96a96 96 0 1 1 192 0A96 96 0 1 1 160 96zm80 152V512l-48.4-24.2c-20.9-10.4-43.5-17-66.8-19.3l-96-9.6C12.5 457.2 0 443.5 0 427V224c0-17.7 14.3-32 32-32H62.3c63.6 0 125.6 19.6 177.7 56zm32 264V248c52.1-36.4 114.1-56 177.7-56H480c17.7 0 32 14.3 32 32V427c0 16.4-12.5 30.2-28.8 31.8l-96 9.6c-23.2 2.3-45.9 8.9-66.8 19.3L272 512z"/>
                                </svg>
                                <a class="text-xs" href="<?php echo e(route('notifications.index')); ?>">
                                    Toutes les notifications
                                </a>

                            </p>
                        </div>

                     <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>

                <!-- start::Submenu header -->
                <div class="flex items-center justify-between px-4 py-2">
                    <span class="font-bold">Notifications</span>
                    <a href="<?php echo e(route('notifications.index')); ?>">
                        <span class="text-xs px-1.5 py-0.5 bg-first-orange text-gray-100 rounded">
                            <?php echo e($unreadNotificationsCount); ?> Nouvelles
                        </span>
                    </a>
                </div>
                <hr>
                <!-- end::Submenu header -->

                <!-- start::Submenu link -->
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        // Assuming $n->data is already an array
                        $data_decoded = json_decode($notification->data['data'], true);
                    ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('one-notification', ['dataDecoded' => $data_decoded,'notification' => $notification,'data_decoded' => $data_decoded]);

$__html = app('livewire')->mount($__name, $__params, $notification->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                
                <!-- end::Submenu link -->
            </div>
            <!-- end::Submenu content -->
        </div>
        <!-- end::Submenu -->
    </div>

<?php /**PATH /var/www/html/pgi/resources/views/livewire/notification-menu.blade.php ENDPATH**/ ?>