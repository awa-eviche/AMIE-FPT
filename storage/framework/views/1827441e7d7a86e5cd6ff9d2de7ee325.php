<!-- My Custom CSS -->
<link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet">



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'AMIE-FPT')); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('backofficeAssets/build/css/tailwind.css')); ?>" />
    

    <?php echo $__env->yieldContent('customCss'); ?>
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <!-- Styles -->
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo $__env->yieldContent('stylesAdditionnels'); ?>
    <!-- My Custom CSS -->
    <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpine-collective/alpine-magic-helpers@0.5.x/dist/component.min.js"></script>
   
<?php /**PATH /var/www/html/pgi/resources/views/layouts/v1/partials/_head.blade.php ENDPATH**/ ?>