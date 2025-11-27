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
    <!-- ... -->

     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('reunion')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="flex mb-4 text-sm font-bold">
        <p>
            <a href="<?php echo e(route("reunion.index")); ?>"  class="text-maquette-gris">Liste des reunions</a>
        </p>
        <span class="mx-2 text-maquette-gris">/</span>
        <p class="text-first-orange">réunion <?php echo e($reunion->code ?? ""); ?></p>
    </div>

    <div x-data="{step : 1}" class="rounded w-full bg-white shadow h-full mb-4 overflow-hidden">
        
        <div class="bg-white">
            <!-- component -->
            <div class="grid grid-flow-col justify-stretch text-base text-gray-600">
                
                <div
                    @click="step=1"
                    class="cursor-pointer text-center border-b-2 p-2 hover:bg-gray-100"
                    x-bind:class="{'border-b-first-orange':step == 1, 'border-b-gray-200' : step !=1}"
                >
                    <p class="px-3 font-black w-full "
                        x-bind:class="{'text-first-orange border-first-orange': step == 1 }"
                    >Général</p>
                </div>

                

                <div
                    @click="step=2"
                    class="cursor-pointer text-center border-b-2 p-2 hover:bg-gray-100"
                    x-bind:class="{'border-b-first-orange':step == 2, 'border-b-gray-200' : step !=2}"
                >
                    <p class="px-3 font-black w-full "
                        x-bind:class="{'text-first-orange border-first-orange': step == 2 }"
                    >
                        Demandes
                    </p>
                </div>
            </div>
        </div>


        <div class="flex flex-wrap mt-3 px-3 h-full" x-show="step == 1">
            
            <div class="w-full sm-1/2 md:w-1/2 lg:w-1/2 pr-0 md:pr-4 mb-1 max-h-full overflow-auto">


                <div class="flex font-semibold mb-4 bg-gray-200 p-1 text-first-orange justify-between">
                    <h3 class="text-xl" >Détails de la réunion</h3>
                    <?php if(Auth::user()->profil->code == "rbo"): ?>
                        <div class="flex items-center text-sm">
                            <a href="<?php echo e(route('reunion.edit', $reunion->id)); ?>" class="flex items-center bg-first-orange text-white rounded px-3 py-1 hover:bg-cyan-700">

                                <span class="mr-2">Modifier</span>
                                <svg width="12" height="16" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.09868 0.23645C4.37895 0.23645 3.76665 0.73733 3.53973 1.43645H1.79266C0.879723 1.43645 0.139648 2.24233 0.139648 3.23645V17.6365C0.139648 18.6305 0.879723 19.4365 1.79266 19.4365H4.55096C4.55899 19.2995 4.57862 19.1606 4.6108 19.0203L4.79077 18.2365H1.79266C1.48835 18.2365 1.24166 17.9678 1.24166 17.6365V3.23645C1.24166 2.90508 1.48835 2.63645 1.79266 2.63645H3.53973C3.76665 3.33557 4.37895 3.83645 5.09868 3.83645H8.4047C9.12442 3.83645 9.7367 3.33557 9.9636 2.63645H11.7107C12.015 2.63645 12.2617 2.90508 12.2617 3.23645V8.91447C12.6137 8.75022 12.9875 8.65875 13.3637 8.64005V3.23645C13.3637 2.24233 12.6236 1.43645 11.7107 1.43645H9.9636C9.7367 0.73733 9.12442 0.23645 8.4047 0.23645H5.09868ZM4.54768 2.03645C4.54768 1.70508 4.79437 1.43645 5.09868 1.43645H8.4047C8.70897 1.43645 8.9557 1.70508 8.9557 2.03645C8.9557 2.36782 8.70897 2.63645 8.4047 2.63645H5.09868C4.79437 2.63645 4.54768 2.36782 4.54768 2.03645ZM6.72937 16.2891L12.0515 10.4938C12.8563 9.61734 14.1613 9.61734 14.9661 10.4938C15.7708 11.3702 15.7708 12.7911 14.9661 13.6676L9.64402 19.4629C9.33369 19.8008 8.94491 20.0404 8.5192 20.1563L6.8685 20.6057C6.15061 20.8011 5.50037 20.0931 5.67985 19.3114L6.09251 17.5139C6.19895 17.0504 6.41908 16.627 6.72937 16.2891Z" fill="white"/>
                                </svg>

                            </a>
                        </div>

                    <?php endif; ?>

                </div>
                <div class="p-3 mt-3">
                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Code :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-maquette-gris"><?php echo e($reunion->code ?? ""); ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">date prévue :</strong>
                        </div>
                        <div class="w-2/3">
                            
                            <span class="text-maquette-gris"><?php echo e(date('d-m-Y',strtotime($reunion->date_prevue) ?? " ")); ?></span>

                        </div>
                    </div>
                    <hr>
                    
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('reunions.mettre-date-effective', ['reunion' => $reunion]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1799299983-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Chargé de suivi :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-maquette-gris"><?php echo e($reunion->chargeSuivi->prenom ?? " - "); ?> <?php echo e($reunion->chargeSuivi->nom  ?? "pas encore"); ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Etat :</strong>
                        </div>
                        <div class="w-2/3">
                            <?php switch($reunion->etat):
                                case (App\Enums\ReunionEtatEnum::PREPARATION): ?>
                                    <span class="bg-gray-200 py-1 px-2 rounded text-sm text-gray-800 font-bold">En préparation</span>
                                    <?php break; ?>
                                <?php case (App\Enums\ReunionEtatEnum::TRANSMISE): ?>
                                    <span class="bg-blue-200 py-1 px-2 rounded text-sm text-blue-800 font-bold">Transmis</span>
                                    <?php break; ?>
                                    <?php case (App\Enums\ReunionEtatEnum::FAITE): ?>
                                    <span class="bg-blue-200 py-1 px-2 rounded text-sm text-blue-800 font-bold">Déjà eu lieu</span>
                                    <?php break; ?>
                                    <?php case (App\Enums\ReunionEtatEnum::PV): ?>
                                    <span class="bg-blue-200 py-1 px-2 rounded text-sm text-blue-800 font-bold">PV généré</span>
                                    <?php break; ?>
                                    <?php case (App\Enums\ReunionEtatEnum::ASIGNE): ?>
                                    <span class="bg-blue-200 py-1 px-2 rounded text-sm text-blue-800 font-bold"> attente de signature</span>
                                    <?php break; ?>
                                <?php case (App\Enums\ReunionEtatEnum::CLOSE): ?>
                                    <span class="bg-green-200 py-1 px-2 rounded text-sm text-green-800 font-bold">close</span>
                                    <?php break; ?>
                            <?php endswitch; ?>

                        </div>
                    </div>


                </div>

                <div class="flex justify-end">
                    <?php if($reunion->demandes->count() > 0
                        // && Auth::user()->checkAccessRights($reunion->demandes[0])
                        && $reunion->etat == App\Enums\ReunionEtatEnum::PREPARATION): ?>

                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('reunions.transmettre-ordre-jour', ['reunion' => $reunion]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1799299983-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                    <?php endif; ?>
                </div>

                <div>
                  <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('reunions.upload-pv', ['reunion' => $reunion]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1799299983-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?> 
                </div>

            </div>

            
            <div class="w-full sm-1/2 md:w-1/2 lg:w-1/2 pl-0 md:pl-4 max-h-full overflow-auto">
                <?php if($reunion->etat != App\Enums\ReunionEtatEnum::PREPARATION && $reunion->etat != App\Enums\ReunionEtatEnum::TRANSMISE): ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('reunions.manage-membre-comite-reunion', ['reunion' => $reunion,'allMembres' => $allComite]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1799299983-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php else: ?>
                    <div class="overflow-hidden sm:rounded-lg mt-0">
                        <h3 class="text-md font-bold mb-0 text-black p-1">Les membre du comité</h3>
                        <div class="mt-4">
                            <?php if($allComite->count() > 0): ?>

                                <div class="relative overflow-scroll shadow-md sm:rounded-lg">
                                    <table class="w-full bg-white text-sm text-left text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase">
                                            <tr class="text-white">
                                                <th scope="col" class="px-3 py-3 bg-first-orange">
                                                    N°
                                                </th>
                                                <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                                    prénom-nom
                                                </th>
                                                <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                                    email
                                                </th>

                                                <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                                    interne
                                                </th>
                                                <th scope="col" class="px-3 py-3 bg-first-orange">

                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $allComite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membreComite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="border-b border-gray-200">
                                                    <td
                                                        class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                                        <?php echo e($membreComite->id); ?>

                                                    </td>
                                                    <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                                        <p class="text-center">
                                                            <?php echo e($membreComite->prenom); ?>

                                                        </p>
                                                        <p class="text-center">
                                                            <?php echo e($membreComite->nom); ?>

                                                        </p>
                                                    </td>
                                                    <td
                                                        class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                                        <?php echo e($membreComite->email); ?>

                                                    </td>
                                                    <td class="px-3 py-3 text-center">
                                                        <?php if($membreComite->userable_type == "App\\Models\\Agent"): ?>
                                                            <span
                                                                class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded ">
                                                                Interne
                                                            </span>
                                                        <?php else: ?>
                                                            <span
                                                                class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded">
                                                                Externe
                                                            </span>
                                                        <?php endif; ?>

                                                    </td>

                                                    <td class="px-1 py-2">
                                                        <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                                            <a href="#" class="text-maquette-gris">
                                                                <svg width="15" height="13" viewBox="0 0 18 15" fill="none">
                                                                    <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>

                                                            </a>
                                                        </div>
                                                    </td>


                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-center">Pas de membre de comité pour l'instant dans le système.</p>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="flex mt-3" x-show="step== 2">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('reunions.manage-reunion-demande', ['reunion' => $reunion]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1799299983-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
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
<?php /**PATH /var/www/html/amie-fpt/resources/views/reunions/show.blade.php ENDPATH**/ ?>