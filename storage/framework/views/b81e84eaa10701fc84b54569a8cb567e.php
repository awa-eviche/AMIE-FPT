<?php 
    $apprenant=$inscription->apprenant; 
?>

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
            <?php echo e(__("Gestion des apprenants")); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-gris text-xl py-4">
                <?php echo e($currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée'); ?>

            </h2>
        </div>
        <div class="flex-1">
            <select wire:model="classe" wire:change="$refresh" class="border bg-white3 font-bold text-md border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-md">
                <option value="<?php echo e($inscription->classe->id); ?>"><?php echo e($inscription->classe->libelle); ?></option>
            </select>
        </div>
    </div>

    <?php if($currentClasse): ?>
            <div class="py-2 px-4 m-2 shadow bg-vert2 rounded shadow border border-black">
                <div class="grid grid-cols-3 gap-2 py-2 text-md">
                    <div class="flex items-center">
                        <span class="text-gray-800">Année Scolaire :</span>
                        <span class="font-bold"><?php echo e($inscription->anneeAcademique->code ?? 'N/A'); ?></span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-800">Filiere :</span>
                        <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->filiere->nom); ?></span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-800">Métier :</span>
                        <span class="font-bold"><?php echo e($currentClasse->niveau_etude->metier->nom); ?></span>
                        &nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;
                        <span class="text-gray-800">Modalite :</span>
                        <span class="font-bold"><?php echo e($currentClasse->modalite); ?></span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-800">Niveau d'études :</span>
                        <span class="font-bold"><?php echo e($currentClasse->niveau_etude->nom); ?></span>
                    </div>

                    <div class="flex items-center">
                        <span class="text-gray-800">Etat classe :</span>
                        <span class="font-bold"><?php echo e(strval( $currentClasse->statut)=="" ?'Non Validé' : (!($currentClasse->etat_classe) ? 'Validé' : 'Lancé')); ?></span>
                    </div>

                    <div class="flex items-center">
                        <span class="text-gray-800">Nombre apprenants :</span>
                        <span class="font-bold"><?php echo e(count($apprenants)); ?></span>
                    </div>
                    
                </div>
            </div> 
<?php endif; ?>

<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex flex-col lg:flex-row">
            <!-- Première colonne -->
            <div class="lg:w-full flex items-center px-4 py-2">
                <div>
                    <div class="col text-gray-700 font-bold text-lg font-medium">
                    <a href="<?php echo e(route('classe.show', $currentClasse->id)); ?>">
    <span><i class="fa fa-angle-left"></i></span> 
    <span class="text-gray-600 text-md pl-2">
        Retour à la liste des apprenants
    </span>
</a>

                    </div>

                                      
                </div>
            </div>
        </div>
        <div class="mx-4" align="right">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_evaluation')): ?>
                        
              
                    <?php endif; ?>  

        </div>
    </div>

    <div class="flex md:flex-wrap justify-between  m-4">
        <div class="flex md:w-full">
            <div class="rounded-lg border bg-gray shadow px-8 py-2 mr-2 bg-white sm:w-2/3 ">
            <div class="flex justify-between text-black items-center">
    <span class="text-first-orange font-bold text-xl">
        Fiche détaillée de l'apprenant <?php echo e($apprenant->nom); ?> <?php echo e($apprenant->prenom); ?>

    </span>
    
    <div class="flex items-center justify-end space-x-2 mt-2">
	    <?php
    $user = auth()->user();
?>
    <?php if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
): ?>
    <?php if($inscription->statut === 'actif'): ?>
        
        <form action="<?php echo e(route('inscription.abandonner', $inscription->id)); ?>"
              method="POST"
              onsubmit="return confirm('Voulez-vous vraiment marquer cet apprenant comme ayant abandonné ?');"
              class="inline">
            <?php echo csrf_field(); ?>
            <button type="submit"
                    class="px-4 py-1 text-sm text-red-700 bg-red-100 hover:bg-red-200 rounded-md shadow">
                Abandonner
            </button>
        </form>
    <?php elseif($inscription->statut === 'abandonne'): ?>
        
        <form action="<?php echo e(route('inscription.abandonner', $inscription->id)); ?>"
              method="POST"
              onsubmit="return confirm('Voulez-vous réactiver cet apprenant ?');"
              class="inline">
            <?php echo csrf_field(); ?>
            <button type="submit"
                    class="px-4 py-1 text-sm text-green-700 bg-green-100 hover:bg-green-200 rounded-md shadow">
                Réactiver
            </button>
        </form>
    <?php endif; ?>

    
    <a href="<?php echo e(route('apprenant.edit', $apprenant->id)); ?>"
       class="px-4 py-1 text-sm text-orange-700 bg-orange-100 hover:bg-orange-200 rounded-md shadow">
        Modifier
    </a>

    
    <form action="<?php echo e(route('apprenant.destroy', $apprenant->id)); ?>"
          method="POST"
          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet apprenant ?');"
          class="inline">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit"
                class="px-4 py-1 text-sm text-orange-700 bg-orange-100 hover:bg-orange-200 rounded-md shadow">
            Supprimer
        </button>
    </form>
<?php endif; ?>
</div>

</div>


                <div class="flex justify-between text-black items-center text-md">
                <div class="w-full sm:w-1/2 px-2">
                            <div class="my-2">
                                    <span>Nom : </span>
                                    <span>
                                        <b><?php echo e($apprenant->nom ?? '-'); ?></b>
                                    </span>
                            </div>
                            <div class="my-2">
                                    <span>Prenom : </span>
                                    <span>
                                        <b><?php echo e($apprenant->prenom ?? 'Non renseigné'); ?></b>
                                    </span>
                            </div>

                            <div class="my-2">
                                     <span>Date de naissance : </span>
                                <span>
                                    <b><?php echo e(date('d-m-Y',strtotime($apprenant->date_naissance) ?? " ")); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Lieu de naissance : </span>
                                <span>
                                    <b><?php echo e($apprenant->lieu_naissance ?? ' <span class="text-sm font-normal">Non renseigné</span> '); ?></b>
                                </span>
                            </div>
                            <div class="my-2">
                                <span>Matricule: </span>
                                <span>
                                    <b><?php echo e($apprenant->matricule ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Adresse: </span>
                                <span>
                                    <b><?php echo e($apprenant->adresse ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Commune: </span>
                                <span>
                                    <b><?php echo e($apprenant->commune->libelle ?? '-'); ?></b>
                                </span>
                            </div>
                            <div class="my-2">
                                <span>Nationalité: </span>
                                <span>
                                    <b><?php echo e($apprenant->nationalite ?? '-'); ?></b>
                                </span>
                            </div>
                            <div class="my-2">
                                <span>Nom du tuteur : </span>
                                <span>
                                    <b><?php echo e($apprenant->nomTuteur ?? "-"); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Prenom du tuteur : </span>
                                <span>
                                    <b><?php echo e($apprenant->prenomTuteur ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Numero Tel Tuteur : </span>
                                <span>
                                    <b><?php echo e($apprenant->numTelTuteur ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Situation Matrimoniale : </span>
                                <span>
                                    <b><?php echo e($apprenant->situationMatrimoniale ?? '-'); ?></b>
                                </span>
                            </div>


                        </div>

                            <div class="w-full sm:w-1/2 px-2 pb-5">
                            <div class="my-2">
                                <span>Prenom Pere: </span>
                                <span>
                                    <b><?php echo e($apprenant->prenomPere ?? '-'); ?></b>
                                </span>
                            </div>
                            <div class="my-2">
                                <span>Prenom Mere: </span>
                                <span>
                                    <b><?php echo e($apprenant->prenomMere ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>nom Mere: </span>
                                <span>
                                    <b><?php echo e($apprenant->nomMere ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Email: </span>
                                <span>
                                    <b><?php echo e($apprenant->email ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Telephone: </span>
                                <span>
                                    <b><?php echo e($apprenant->telephone ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Date d'insertion: </span>
                                <span>
                                    <b><?php echo e($apprenant->dateInsertion ?? '-'); ?></b>
                                </span>
                            </div>

                            <div class="my-2">
                            AutoEmploi
                                <span>Auto Emploi: </span>
                                <b><?php echo e($apprenant->autoEmploi == 1 ? "OUI" : "NON"); ?></b>
                            </div>

                            <div class="my-2">
                                <span>Emploi Salarie: </span>
                                <b><?php echo e($apprenant->emploiSalarie == 1 ? "OUI" : "NON"); ?></b>
                                
                            </div>

                        </div>
                            
                            

                </div>

            </div>
            <div class="rounded-lg border shadow-sm px-8 py-2 sm:w-1/3 ">
                <h3 class="text-first-orange font-bold text-xl mb-4">Compétences à acquérir</h3>
                 <?php if($currentClasse && $currentClasse->modalite === 'PPO'): ?>
    <?php $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center my-2">
            <i class="fa fa-star text-gray text-xs me-2"></i> 
            <span class="font-normal">
                <span class="font-bold"><?php echo e($matiere->code); ?></span>: <?php echo e($matiere->nom); ?>

            </span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php elseif($currentClasse && $currentClasse->modalite === 'APC'): ?>
    <?php $__currentLoopData = $competences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center my-2">
            <i class="fa fa-check text-green-500 text-xs me-2"></i> 
            <span class="font-normal">
                <span class="font-bold"><?php echo e($competence->code); ?></span>: <?php echo e($competence->nom); ?>

            </span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

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
<?php /**PATH /var/www/html/pgi/resources/views/inscription/show.blade.php ENDPATH**/ ?>