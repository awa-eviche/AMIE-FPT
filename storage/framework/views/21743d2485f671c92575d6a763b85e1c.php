<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('layouts.v1.partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/splide/css/splide.min.css')); ?>">
</head>

<body class="leading-normal tracking-normal text-black" style="font-family: poppins;overflow-x: hidden;font-size: 14px;">
    <?php echo $__env->make('partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="w-full bg-entreprise bg-no-repeat bg-cover bg-top flex flex-col sm:justify-between items-beetween sm:pt-0">
        <div class="flex flex-wrap">
            <div class="md:w-3/4 lg:w-4/4 xl:w-3/4 md:py-40 md:px-15 sm:py-10 sm:px-6 w-full">
                <div class="flex flex-col">
                    <div class="text-white font-bold text-2xl md:text-4xl pt-10">Liste des établissements</div>
                    <div class="text-white font-medium md:text-xl pt-10 flex items-center">
                        <span></span>
                        
                        <span class="font-bold"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="p-5">
                <div class="md:container md:mx-auto pt-10">
                    <h1 class="font-poppins_black text-first-orange text-center text-4xl sm:px-2 lg:px-4 pt-4 pb-2">
                        Voir la liste
                    </h1>
                    <h4 class="font-bold text-first-orange text-center text-md sm:px-2 lg:px-4 pb-2">
                        des établissements
                    </h4>
                    <div class="flex flex-col items-center justify-center">
                        <p class="text-center text-black w-1/3 text-sm">
                        </p>
                        <hr class="border-first-orange border w-1/6 m-5">
                    </div>
                    <?php echo $__env->make('layouts.v1.partials._alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="container p-2 rounded">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('Etablissements.front-liste-etablissement', []);

$__html = app('livewire')->mount($__name, $__params, 'lw--1378671572-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>

                </div>
        </div>
    </main>


<?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.v1.partials._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(asset('assets/libs/splide/js/splide.min.js')); ?>"></script>
<?php echo $__env->yieldPushContent('myJS'); ?>
</body>

</html>
<?php /**PATH /var/www/html/pgi/resources/views/etablissements.blade.php ENDPATH**/ ?>