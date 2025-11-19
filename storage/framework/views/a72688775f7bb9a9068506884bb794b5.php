<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <?php echo $__env->make('layouts.v1.partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="font-sans antialiased">
    <div class="relative h-screen overflow-hidden bg-[#E6E6E6] rounded-2xl">
        <div  x-data="{ isOpen: true }" class="flex items-start justify-between">
        
                <div  x-show="isOpen"
                
                class="md:block md:relative md:w-80 h-screen shadow-lg z-50 fixed"
                id="md_sidebar"
                >
                    <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

            
            <div class="flex flex-col w-full pl-0 md:space-y-4">
            <?php echo $__env->make('layouts.v1.partials._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="h-screen pt-6 pb-24 pl-6 pr-6 overflow-auto md:pt-6 md:pr-6 md:pl-6">
                    <?php echo $__env->make('layouts.v1.partials._alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>

            </div>
        </div>
    </div>
    </div>
    <?php echo $__env->make('layouts.v1.partials._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('myJS'); ?>
</body>

</html>
<?php /**PATH /var/www/html/pgi/resources/views/layouts/v1/default.blade.php ENDPATH**/ ?>