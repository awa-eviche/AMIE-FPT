<div class="row mb-10">
    <?php if(Session::has('message')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative alert" role="alert">
            <strong class="font-bold">Succès!</strong>
            <span class="block sm:inline"><?php echo e(Session::get('message')); ?></span>
            <button type="button" class="absolute top-0 right-0 mt-3 mr-2">
                <span class="sr-only">Fermer</span>
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 5.652a.999.999 0 1 0-1.414 1.414L11.414 8l-1.52 1.52a.999.999 0 1 0 1.414 1.414L12.828 9l1.52 1.52a.999.999 0 1 0 1.414-1.414L14.242 8l1.52-1.52a.999.999 0 1 0-1.414-1.414L13.828 7l-1.48-1.48z"/>
                </svg>
            </button>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.alert').remove();
            }, 3000);
        </script>
    <?php endif; ?>
    <?php if(count($errors) > 0): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative alert" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <span class="block sm:inline">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </span>
            <button type="button" class="absolute top-0 right-0 mt-3 mr-2">
                <span class="sr-only">Fermer</span>
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 5.652a.999.999 0 1 0-1.414 1.414L11.414 8l-1.52 1.52a.999.999 0 1 0 1.414 1.414L12.828 9l1.52 1.52a.999.999 0 1 0 1.414-1.414L14.242 8l1.52-1.52a.999.999 0 1 0-1.414-1.414L13.828 7l-1.48-1.48z"/>
                </svg>
            </button>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.alert').remove();
            }, 8000);
        </script>
    <?php endif; ?>
</div><?php /**PATH /var/www/html/pgi/resources/views/layouts/v1/partials/_alert.blade.php ENDPATH**/ ?>