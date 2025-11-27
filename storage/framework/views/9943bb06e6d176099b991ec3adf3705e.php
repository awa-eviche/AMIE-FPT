<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex justify-between items-center">
            <span class="text-first-orange font-bold text-sm">
                <a href="<?php echo e(route('ief.index')); ?>">Liste des iefs </a>
                / <span class="text-orange-600">
                    <?php echo e($ief->libelle); ?></span></span>
        </div>
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="flex md:w-full  flex-col">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">

                <div class="border border-gray-200">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Détails de l'ief
                        <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1" href="<?php echo e(route('ief.edit', $ief->id)); ?>" style='position:relative;left: 80%;'>
                            Modifier
                        </a>
                    </h3>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">
                        <div>
                            <span>Nom : </span>
                            <span>
                                <b><?php echo e($ief->nom ?? ' - '); ?></b>
                            </span>
                        </div>
                        <div>
                            <span>Email : </span>
                            <span>
                                <b><?php echo e($ief->email ?? ' -'); ?></b>
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">

                        <div>
                            <span>Telephone : </span>
                            <span>
                                <b><?php echo e($ief->telephone ?? ' -'); ?></b>
                            </span>
                        </div>
                        <div>
                            <span>Adresse : </span>
                            <span>
                                <b><?php echo e($ief->adresse ?? ' -'); ?></b>
                            </span>
                        </div>

                    </div>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">

                        <div>
                            <span>IA : </span>
                            <span>
                                <b><?php echo e($ief->ia->nom ?? ' -'); ?></b>
                            </span>
                        </div>
                        
                    </div>
                    <div class="text-black mt-3 text-sm">
                    <span>Zone de couverture :  <?php $__currentLoopData = $ief->communes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commune): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($commune->libelle); ?>   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </span>
                    </div>

                </div>
            </div>
        </div>

    </div><?php /**PATH /var/www/html/amie-fpt/resources/views/livewire/ief/detail-ief.blade.php ENDPATH**/ ?>