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
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Visualiser un critère')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php $__env->startSection('stylesAdditionnels'); ?>
        <?php echo $__env->make('layouts.v1.partials.swal._style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <style>
            input{
                border:none;
            }
            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
            }

            .tab-div{
                border-bottom:2px solid  rgb(22 163 74 / var(--tw-text-opacity));
            }

            .tab-button{
                cursor: pointer;
                margin-right:2px;
                border:0px;
                border-top-right-radius: 4px;
                border-top-left-radius: 4px;;
                background-color: #eee;
                color:#666;
                font-weight: normal;
            }
            .tab-button:hover{
                color:rgb(22 163 74 / var(--tw-text-opacity));
            }
            .tab-button.active{
                /* border-bottom: .2rem solid rgb(22 163 74 / var(--tw-text-opacity)); */
                border:0px;
                border-bottom:0px;
                background-color: rgb(22 163 74 / var(--tw-text-opacity));;
                /* position:relative; 
                top:1px; */
                color:#FFFFFF;
                font-weight: bold;
            }
        </style>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('scriptsAdditionnels'); ?>
        <?php echo $__env->make('layouts.v1.partials.swal._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <script>
            function switchTab(event) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Deactivate all tab buttons
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('active');
                });

                // Get target tab content and button, then activate them
                const targetId = event.target.getAttribute('data-target');
                const targetContent = document.getElementById(targetId);
                const targetButton = event.target;

                targetContent.classList.add('active');
                targetButton.classList.add('active');
            }

            // Add click event listener to each tab button
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', switchTab);
            });
        </script>
    <?php $__env->stopSection(); ?>

    <div class="bg-transparent shadow rounded-sm w-full p-4">

        <div class="mt-2 mb-2">
            <a href="<?php echo e(route('critere.index')); ?>" class="text-blue-500 hover:underline">&larr; Retour à la liste des critères</a>
        </div>
        <div class="w-full mx-auto">
            <div class="bg-white pt-6 pb-8 mb-4">
                <div class="md:container md:mx-auto">

                    <div class="w-full sm:px-2 lg:px-4 ">
                        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
                            <p>
                                <a href="/dashboard" class="text-maquette-black">Accueil</a>
                                  <span class="mx-2 text-maquette-gris">/</span>
                            </p><p> <a href="<?php echo e(route('critere.index')); ?>">Critères</a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p class="text-first-orange">Modifier</p>
                            <p></p>
                        </div>
                        <div class="border border-gray-200">
                            <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                Formulaire d'ajout
                            </h3>
                            <div class="p-5">

                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="element" class="block text-gray-700 text-sm font-bold mb-2">Elément de compétence : &nbsp;<span class="font-light"><?php echo e($critere->elementCompetence->libelle); ?></span></label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code : &nbsp;<span class="font-light"><?php echo e($critere->code); ?></span></label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="libelle" class="block text-gray-700 text-sm font-bold mb-2">Libellé : &nbsp;<span class="font-light"><?php echo e($critere->libelle); ?></span></label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                        <textarea class="border readonly border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" name="description" id="description" cols="10" rows="5"><?php echo e(old('description') ?? $critere->description); ?></textarea>
                                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <?php echo e($message); ?>

                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="<?php echo e(route('critere.edit', $critere->id)); ?>" class="px-3 rounded-md py-2 flex items-center w-min text-white text-sm text-center bg-first-orange">
                                        <i class="fa fa-edit"></i>&nbsp;Modifier
                                    </a>
                                    <?php echo Form::open(array(
                                        'method' => 'DELETE',
                                        'class' => 'delete-form',
                                        'style' => 'display: inline;',
                                        'route' => array('critere.destroy', $critere->id))); ?>

                                        <?php echo e(csrf_field()); ?>

                                        <a href="#delete" class="flex items-center w-max text-white bg-red-600 text-sm rounded-md shadow-md px-4 py-2 apix-delete" data-toggle="tooltip" title="Supprimer cette critere">
                                            <i class="fa fa-trash"></i>&nbsp;Supprimer
                                        </a>
                                    <?php echo Form::close(); ?>

                                </div>

                            </div>

                        </div>
                    </div>
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
<?php endif; ?>
<?php /**PATH /var/www/html/pgi/resources/views/criteres/show.blade.php ENDPATH**/ ?>