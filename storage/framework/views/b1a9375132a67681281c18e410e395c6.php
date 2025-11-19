<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="flex justify-between mt-0 mb-2">
        <div class="mb-5 ml-5">
            <h1 class="text-2xl font-bold">Nouvelles notifications</h1>
        </div>
        <div>
            
            <p>
                <?php if($onlyUnread): ?>
                    <a href="<?php echo e(route('notifications.all')); ?>" class="px-4 py-2 bg-first-orange text-white rounded-md">
                        Toutes les notifications
                    </a>

                <?php else: ?>
                <a href="<?php echo e(route('notifications.index')); ?>" class="px-4 py-2 bg-first-orange text-white rounded-md">
                    Uniquement les non lues
                </a>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div id="content" class="bg-white rounded pb-10">
        <!-- Course content -->

        <div class="inbox-wrapper full">
            <div class="filter-wrapper">
                
        </div>

        <br>

        

        <p>
            <span class="no-more hidden">Plus de notifications à charger</span>
        </p>


        <?php if(count($notifications) > 0): ?>
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="my-5 mb-5 flex justify-center">
            <?php echo e($notifications->links()); ?>

        </div>
        <?php else: ?>
        <p class="text-first-orange mt-2 ml-5 text-xl">
          Aucune nouvelle notification
        </p>
        <?php endif; ?>
    </div>


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/pgi/resources/views/notifications/index.blade.php ENDPATH**/ ?>