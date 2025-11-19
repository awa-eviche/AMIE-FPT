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
  <div class="py-12">
    <div class="max-full mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <?php echo e(__("Menu")); ?>

        </div>
      </div>
      <div class="flex flex-wrap justify-center">
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">
          <a href="<?php echo e(route('users.index')); ?>">
            <div class="bg-white rounded-lg shadow-lg text-center py-12 text-first-orange hover:bg-first-orange hover:text-white transition duration-300">
              <span class="h-12 w-12 mx-auto mb-4"><i class="fa fa-2x fa-users"></i></span>
              <h3 class="text-xl font-semibold">Utilisateurs</h3>
            </div>
          </a>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">
          <a href="<?php echo e(route('roles.index')); ?>">
            <div class="bg-white rounded-lg shadow-lg text-center py-12 text-first-orange hover:bg-first-orange hover:text-white transition duration-300">
              <span class="h-12 w-12 mx-auto mb-4"><i class="fa fa-2x fa-puzzle-piece"></i></span>
              <h3 class="text-xl font-semibold">Roles</h3>
            </div>
          </a>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">
          <a href="<?php echo e(route('permissions.index')); ?>">
            <div class="bg-white rounded-lg shadow-lg text-center py-12 text-first-orange hover:bg-first-orange hover:text-white transition duration-300">
              <span class="h-12 w-12 mx-auto mb-4"><i class="fa fa-2x fa-lock"></i></span>
              <h3 class="text-xl font-semibold">Permissions</h3>
            </div>
          </a>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-4">
          <a href="<?php echo e(route('users.logs')); ?>">
            <div class="bg-white rounded-lg shadow-lg text-center py-12 text-first-orange hover:bg-first-orange hover:text-white transition duration-300">
              <span class="h-12 w-12 mx-auto mb-4"><i class="fa fa-2x fa-eye"></i></span>
              <h3 class="text-xl font-semibold">Historiques</h3>
            </div>
          </a>
        </div>
      </div>
    </div>
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
<?php endif; ?><?php /**PATH /var/www/html/pgi/resources/views/admin/index.blade.php ENDPATH**/ ?>