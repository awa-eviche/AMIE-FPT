<?php $__env->startSection('content'); ?>

    <?php echo Form::model(new \App\Models\Actualite(), ['route' => ['actualite.update',$actualite->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'apix-form', 'files' => 'true']); ?>

    <?php
        $pClass = " p-2.5";
        $tclass = " p-2.5";
        $inputClass = "bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full dark:bg-white dark:border-gray-400 dark:text-gray-400 dark:focus:ring-gray-600 dark:focus:border-gray-600";
    ?>

    <div class="mt-4 mx-2 my-2">
        <a href="<?php echo e(route('actualite.index')); ?>" class="text-blue-500 hover:underline">&larr; Retour à la
            liste des
            actualités</a>
    </div>
    <?php echo method_field('PUT'); ?>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="md:container md:mx-auto">
                <h2 class="text-first-orange text-1xl py-2">Modifier une actualité</h2>
                <hr>

                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="titre"
                               class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Titre</label>
                        <?php echo Form::text('title', $actualite->title, ['id' => 'title', 'class' => $inputClass.$pClass, 'required' => 'true', 'placeholder' => 'Titre']); ?>

                    </div>
                </div>

                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="main_pic"
                               class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Image
                            principale</label>
                        <?php echo Form::file('image', ['id' => 'image', 'class' => $inputClass.$tclass, 'placeholder'=>'Choisir une image']); ?>

                        <?php if(!empty($actualite->image)): ?>
                            <img class="thumbnail-slider py-4" src="<?php echo e(asset('storage/'. $actualite->image)); ?>"
                                 alt="<?php echo e($actualite->activite_main_pic); ?>"/>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="corps"
                               class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Contenu</label>
                        <?php echo Form::text('contenu', $actualite->content, ['id' => 'richEd', 'class' => $inputClass.$pClass, 'required' => 'true', 'placeholder' => 'Titre']); ?>

                    </div>
                </div>

                <div class="relative z-0 w-full mb-3 group">
                    <label for="status" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Status</label>
                    <?php echo Form::select('status',['published'=>'Publié','draft'=>'Non publié'], $actualite->status, ['id' => 'status', 'class' => $inputClass.$pClass, 'required' => 'true']); ?>

                </div>

                <div class="grid md:grid-cols-1 md:gap-6 pt-4">
                    <div class="relative z-0 w-full mb-6 group">
                        <button type="submit"
                                class="text-white bg-first-orange hover:bg-first-orange focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-first-orange dark:hover:bg-first-orange focus:outline-none dark:focus:bg-first-orange">
                            Enregistrer
                        </button>
                        <a href="<?php echo e(route('actualite.index')); ?>"
                           class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-3 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            Annuler </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>


    <?php $__env->startSection('stylesAdditionnels'); ?>
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet"/>
        <?php echo \Illuminate\View\Factory::parentPlaceholder('stylesAdditionnels'); ?>
        
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('scriptsAdditionnels'); ?>
        <?php echo \Illuminate\View\Factory::parentPlaceholder('scriptsAdditionnels'); ?>
        <?php echo $__env->make('layouts.v1.partials.select2._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.v1.partials.richEditor._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.v1.partials.richEditor._style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.v1.partials.parsley._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
        <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('myJS'); ?>
        <script>
            var files;
            var pond;

            $(document).ready(
                function () {
                    'use strict';
                    $('.select2').select2();
                    $(".apix-form").parsley();
                    var richEd = new RichTextEditor("#richEd");

                    const filesElement = document.getElementById('actualite_galleries');
                    pond = FilePond.create(filesElement);
                    pond.labelIdle = 'Télécharger vos fichiers ici';
                }
            );
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.v1.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/amie-fpt/resources/views/actualite/edit.blade.php ENDPATH**/ ?>