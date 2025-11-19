<div class="h-full bg-white  overflow-auto flex flex-col justify-between px-3">
    <!-- l'image logo -->
    <div class="flex justify-end">
        <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="isOpen = !isOpen" aria-label="Menu">
        <a href="/dashboard">
        <img src="<?php echo e(asset('assets/images/logopgi.png')); ?>" class="w-full object-cover" alt="Icon"/>
        </a>
    </button>

    </div>
    <div class="flex items-center justify-start pt-6">

        <h1 class="mt-0 ml-4 text-3xl font-bold">
            <div class="flex items-center justify-center overflow-hidden">
            <a href="/dashboard">
            <img src="<?php echo e(asset('frontAssets2/images/logoamifpt.jpg')); ?>" class="w-full object-cover" alt="Icon"/>
            </div>
            </a>
        </h1>
    </div>
 
    <!-- les elements du sidebar -->
    <nav class="my-6">
        <div>
            
            <a class="element_sidebar <?php echo e(request()->is('dashboard*') ? 'element_sidebar_acitf' : ''); ?>" href="/dashboard">
                <span class="text-left">
                    <i class="menu-icon fa-solid fa-gauge"></i>
                </span>
                <span class="mx-4 text-base font-normal">
                    Tableau de bord
                </span>
            </a>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('visualiser_etablissement')): ?>
                <a class="element_sidebar <?php echo e(request()->is('etablissement*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('etablissement.index')); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-address-book"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Etablissements
                    </span>
                </a>
            <?php endif; ?>

            <?php if(auth()->user()->can('visualiser_mes_filieres') and !auth()->user()->hasRole(config('constants.roles.superadmin'))): ?>
                <a class="element_sidebar <?php echo e(request()->is('niveauetudeetablissement*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('niveauetudeetablissement.index')); ?>">
                <span class="text-left">
                <i class="menu-icon fa-solid fa-at"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">

                        Programmes de formation
                    </span>
                </a>
            <?php endif; ?>

            

            
            <?php if(auth()->user()->can('visualiser_classe_matiere')): ?>
            <div x-data="{ open: <?php echo e(request()->is('classe*') ? 'true' : 'false'); ?> }">
    <p type="button" class="element_sidebar relative <?php echo e(request()->is('classe*') ? 'element_sidebar_acitf' : ''); ?>" @click="open = !open">
        <span class="text-left">
            <i class="menu-icon fa-regular fa-building"></i>
        </span>
        <span class="mx-4 text-base font-normal">Classes</span>
        <i x-bind:class="{'fa-caret-down': !open, 'fa-caret-up' : open}" class="fa-solid absolute right-0 mr-3"></i>
    </p>

    <div class="bg-gray-100 border-x border-2-maquette-gris rounded shadow-inner relative -top-2 overflow-hidden transition-all max-h-0 duration-700"
         x-ref="classeContainer"
         x-bind:style="open ? 'max-height: ' + $refs.classeContainer.scrollHeight + 'px' : 'border:none'">

        
        <a class="element_sidebar <?php echo e(request()->is('classe') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('classe.index')); ?>">
            <span class="text-left">
                <i class="menu-icon fa-solid fa-list"></i>
            </span>
            <span class="mx-4 text-base font-normal">Liste des classes</span>
        </a>

        
<?php
    $user = auth()->user();
?>

<?php if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement')): ?>
    <a class="element_sidebar <?php echo e(request()->is('classe/admis/selection') ? 'element_sidebar_acitf' : ''); ?>"
       href="<?php echo e(route('classe.admis.selector')); ?>">
        <span class="text-left">
            <i class="menu-icon fa-solid fa-arrow-up-right-dots"></i>
        </span>
        <span class="mx-4 text-base font-normal">
            Réinscription des apprenants
        </span>
    </a>
<?php endif; ?>


    </div>
</div>

            <?php endif; ?>


          


            
            
            <?php if(auth()->user()->can('edit_inscription')): ?>
                <!-- <a class="element_sidebar <?php echo e(request()->is('inscription*') ? 'element_sidebar_acitf' : ''); ?> <?php echo e(request()->is('evaluation*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('inscription.index')); ?>">
                    <span class="text-left">
                    <i class="fas fa-user"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Gestions des notes
                    </span>
                </a> -->
                <div x-data="{ open: <?php echo e(request()->is('parametrage*') ? 'true' : 'false'); ?> }">

<p type="button" class="element_sidebar relative
    <?php echo e(request()->is('parametrage*') ? 'element_sidebar_acitf' : ''); ?>" @click="open = !open">
    <span class="text-left">
        <i class="menu-icon fa-solid fa-gears"></i>
    </span>
    <span class="mx-4 text-base font-normal">
        <span> Gestion des notes</span>
    </span>
    <i x-bind:class="{'fa-caret-down': open == false, 'fa-caret-up' : open == true }" class="fa-solid absolute right-0 mr-3"></i>

</p>

<div class="bg-gray-100 border-x border-2-maquette-gris rounded shadow-inner relative -top-2 overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="open ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : 'border:none'">
      <a class="element_sidebar <?php echo e(request()->is('inscription*') ? 'element_sidebar_acitf' : ''); ?> <?php echo e(request()->is('evaluation*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('inscription.index')); ?>">
                    <span class="text-left">
                    <i class="fas fa-graduation-cap"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                     Note PPO
                    </span>
                </a>
		   <a class="element_sidebar <?php echo e(request()->is('inscription*') ? 'element_sidebar_acitf' : ''); ?> <?php echo e(request()->is('evaluation*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('competence.manage.index')); ?>">
                    <span class="text-left">
                    <i class="fas fa-graduation-cap"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                     Note APC
                    </span>
                </a>   
   
</div>

</div>
            <?php endif; ?>


         
           
            
         

              <?php if(auth()->check() && (
    auth()->user()->hasRole('chef_etablissement') ||
    auth()->user()->hasRole('assistante')
)): ?>
    <a class="element_sidebar <?php echo e(request()->is('admin*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
        <span class="text-left"><i class="menu-icon fa-solid fa-users-gear"></i></span>
        <span class="mx-4 text-base font-normal">Utilisateurs</span>
    </a>
<?php endif; ?>

       

        
            <?php if(auth()->user()->hasRole(config('constants.roles.superadmin'))): ?>
            <a class="element_sidebar <?php echo e(request()->is('demande*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route("demande.index")); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-bookmark"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Demandes
                    </span>
                </a>
            <?php endif; ?>

            <?php if(auth()->user()->hasRole(config('constants.roles.chef_etablissement'))): ?>
            <a class="element_sidebar <?php echo e(request()->is('demande*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('demande.demandebyEfpt', auth()->user()->personnel->etablissement_id)); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-bookmark"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Demandes
                    </span>
                </a>
            <?php endif; ?>

            <?php if(auth()->user()->can('visualiser_demande') ): ?>
                
                
                

                <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('indicateur.index')); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-solid fa-level-up"></i>

                    </span>
                    <span class="mx-4 text-base font-normal">
                        Suivi des collectes
                    </span>
                </a>
            <?php endif; ?>
            <?php if(auth()->user()->can('gerer_administration') ): ?>
                
                <a class="element_sidebar <?php echo e(request()->is('admin*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('admin.index')); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-solid fa-users-gear"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Administration
                    </span>
                </a>
             <?php endif; ?>
            
                
                <a class="element_sidebar <?php echo e(request()->is('document*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('document.category')); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-folder-open fa-sm fa-fw"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Espace documentaire
                    </span>
                </a>
                   <?php if(auth()->user()->hasRole('chef_etablissement')): ?>
                <a class="element_sidebar <?php echo e(request()->is('materiel*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('materiel.index')); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-folder-open fa-sm fa-fw"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Matériels affectés
                    </span>
                </a>
             <?php endif; ?>
                 <?php if(auth()->user()->hasRole('superadmin')): ?>
                <div x-data="{ open: <?php echo e(request()->is('parametrage*') ? 'true' : 'false'); ?> }">

                    <p type="button" class="element_sidebar relative
                        <?php echo e(request()->is('parametrage*') ? 'element_sidebar_acitf' : ''); ?>" @click="open = !open">
                        <span class="text-left">
                            <i class="menu-icon fa-solid fa-gears"></i>
                        </span>
                        <span class="mx-4 text-base font-normal">
                            <span>Paramètrage</span>
                        </span>
                        <i x-bind:class="{'fa-caret-down': open == false, 'fa-caret-up' : open == true }" class="fa-solid absolute right-0 mr-3"></i>

                    </p>

                    <div class="bg-gray-100 border-x border-2-maquette-gris rounded shadow-inner relative -top-2 overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="open ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : 'border:none'">
                        <a class="element_sidebar <?php echo e(request()->is('parametrage/workflow*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('workflow.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-recycle"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Flux de traitement des demandes
                            </span>
                        </a>
                        <a class="element_sidebar <?php echo e(request()->is('parametrage/type_demande*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('type_demande.index')); ?>">
                            <span class="text-left">
                                <i class="fa-regular fa-folder-open"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Type demande
                            </span>
                        </a>
                        <a class="element_sidebar <?php echo e(request()->is('parametrage/type_notification*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('type_notification.index')); ?>">
                            <span class="text-left">
                                <span class="text-left">

                                    <i class="menu-icon fa-solid fa-database"></i>
                                </span>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Type de notification
                            </span>
                        </a>
                    </div>

                </div>
            <?php endif; ?>
                    
            <?php if(auth()->user()->can('gerer_parametrage') ): ?>
                <div x-data="{ open: <?php echo e(request()->is('referentiel*') ? 'true' : 'false'); ?> }">

                    <p type="button" class="element_sidebar relative
                        <?php echo e(request()->is('referentiel*') ? 'element_sidebar_acitf' : ''); ?>" @click="open = !open">
                        <span class="text-left">
                            <i class="menu-icon fa-solid fa-book"></i>
                        </span>
                        <span class="mx-4 text-base font-normal">
                            <span>Données de Base</span>
                        </span>
                        <i x-bind:class="{'fa-caret-down': open == false, 'fa-caret-up' : open == true }" class="fa-solid absolute right-0 mr-3"></i>

                    </p>

                    <div class="bg-gray-100 border-x border-2-maquette-gris rounded shadow-inner relative -top-2 overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="open ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : 'border:none'">
                        
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('visualiser_domaine')): ?>
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('secteur.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-layer-group"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Secteur
                            </span>
                        </a>
                    <?php endif; ?>
                    
                       
                      
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('visualiser_filiere')): ?>
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('filiere.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-at"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Filière
                            </span>
                        </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('visualiser_metier')): ?>
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('metier.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-binoculars"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Métier
                            </span>
                        </a>
                    <?php endif; ?>
                    
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('matiere.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-road"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Discipline
                            </span>
                        </a>
                    
                    
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('diplome.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-graduation-cap"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Diplôme
                            </span>
                        </a>
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('visualiser_niveau')): ?>
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('niveauetude.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-level-up"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Niveau
                            </span>
                        </a>
                    <?php endif; ?>
                    <?php if(auth()->user()->hasRole(config('constants.roles.superadmin'))): ?>
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('typeIndicateur.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-level-up"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Type Survey
                            </span>
                        </a>
                   
                        
                    <?php endif; ?>
                   

                 
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('competence.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-road"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Competence
                            </span>
                        </a>
                 

              
                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('elementcompetence.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-road"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Element de Competence
                            </span>
                        </a>
                   


                    <a class="element_sidebar <?php echo e(request()->is('referentiel/critere*') ? 'sous_menu_sidebar_actif' : ''); ?>"
                            href="<?php echo e(route('critere.index')); ?>">
                            <span class="text-left">
                                <i class="fa-solid fa-check-circle"></i>

                            </span>
                            <span class="mx-4 text-sm font-bold">
                                Seuil de réussite
                            </span>
                        </a>


                         <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('region.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-map-location-dot"></i>


                            </span>
                            <span class="mx-4 text-base font-normal">
                                Région
                            </span>
                        </a>
                        
   <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('departement.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-location-dot"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Département
                            </span>
                        </a>

   <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('commune.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-map-pin"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Commune
                            </span>
                        </a>
                    
                     <a class="element_sidebar <?php echo e(request()->is('liste*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('liste.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-clipboard-list"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Liste
                            </span>
                        </a>

                    
                    <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('ia.index')); ?>">
                        <span class="text-left">
                            <i class="menu-icon fa-solid fa-map-pin"></i>

                        </span>
                        <span class="mx-4 text-base font-light">
                         IA
                        </span>
                    </a>

                    <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('ief.index')); ?>">
                        <span class="text-left">
                            <i class="menu-icon fa-solid fa-map-pin"></i>

                        </span>
                        <span class="mx-4 text-base font-light">
                         IEF
                        </span>
                    </a>

                        <a class="element_sidebar <?php echo e(request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : ''); ?>" href="<?php echo e(route('anneeacademique.index')); ?>">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-hourglass"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Année Académique
                            </span>
                        </a>
                    
                    </div>
                </div>
            <?php endif; ?>



            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gerer_actualite_et_faq')): ?>
                <a class="element_sidebar <?php echo e(request()->is('page-acceuil/actualite*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('actualite.index')); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-newspaper"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Actualités
                    </span>
                </a>

                
                <!--a class="element_sidebar <?php echo e(request()->is('page-acceuil/faqs*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('faqs.index')); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-question"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                    FAQ
                    </span>
                </a-->
                <?php endif; ?>



            
                <!--a class="element_sidebar <?php echo e(request()->is('forum*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route("forum")); ?>"  target="_blank">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-bookmark"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Accéder au forum
                    </span>
                </a-->

        </div>

<!-- NOUVEAUX MODULES - UNIQUEMENT POUR LES ADMINISTRATEURS -->

<?php if(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin')): ?>
    <!-- Gestion insertion -->
    <div x-data="{ open: false }">
        <button type="button" class="element_sidebar group flex items-center justify-between w-full px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->is('insertion*') ? 'element_sidebar_acitf bg-first-orange text-white shadow-md' : 'text-gray-700 hover:bg-first-orange hover:text-white hover:shadow-md'); ?>" @click="open = !open">
            <div class="flex items-center">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-user-plus text-base"></i>
                </span>
                <span class="mx-4 text-base font-medium">
                    Gestion insertion
                </span>
            </div>
            <i x-bind:class="{'fa-caret-down': !open, 'fa-caret-up' : open}" class="fa-solid transition-transform duration-300"></i>
        </button>

        <div class="bg-gray-50 rounded-lg mt-1 shadow-inner overflow-hidden transition-all duration-500"
             x-ref="insertionContainer"
             x-bind:style="open ? 'max-height: ' + $refs.insertionContainer.scrollHeight + 'px' : 'max-height: 0'">
            
            <!-- Lien vers la vue de gestion des inscriptions -->
            <a class="sous_element_sidebar group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ml-4 <?php echo e(request()->is('insertion/inscriptions') ? 'sous_menu_sidebar_actif bg-orange-100 text-first-orange border-l-4 border-first-orange' : 'text-gray-600 hover:bg-orange-50 hover:text-first-orange'); ?>" href="#">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-user-graduate text-sm"></i>
                </span>
                <span class="mx-4 text-sm font-medium">Inscriptions</span>
            </a>

            <!-- Lien vers la vue de suivi des insertions -->
            <a class="sous_element_sidebar group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ml-4 <?php echo e(request()->is('insertion/suivi') ? 'sous_menu_sidebar_actif bg-orange-100 text-first-orange border-l-4 border-first-orange' : 'text-gray-600 hover:bg-orange-50 hover:text-first-orange'); ?>" href="#">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-chart-line text-sm"></i>
                </span>
                <span class="mx-4 text-sm font-medium">Suivi insertion</span>
            </a>
        </div>
    </div>

    <!-- Gestion de l'Orientation -->
    <div x-data="{ open: false }">
        <button type="button" class="element_sidebar group flex items-center justify-between w-full px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->is('orientation*') ? 'element_sidebar_acitf bg-first-orange text-white shadow-md' : 'text-gray-700 hover:bg-first-orange hover:text-white hover:shadow-md'); ?>" @click="open = !open">
            <div class="flex items-center">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-compass text-base"></i>
                </span>
                <span class="mx-4 text-base font-medium">
                    Orientation
                </span>
            </div>
            <i x-bind:class="{'fa-caret-down': !open, 'fa-caret-up' : open}" class="fa-solid transition-transform duration-300"></i>
        </button>

        <div class="bg-gray-50 rounded-lg mt-1 shadow-inner overflow-hidden transition-all duration-500"
             x-ref="orientationContainer"
             x-bind:style="open ? 'max-height: ' + $refs.orientationContainer.scrollHeight + 'px' : 'max-height: 0'">
            
            <!-- Lien vers la vue de conseil en orientation -->
            <a class="sous_element_sidebar group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ml-4 <?php echo e(request()->is('orientation/conseil') ? 'sous_menu_sidebar_actif bg-orange-100 text-first-orange border-l-4 border-first-orange' : 'text-gray-600 hover:bg-orange-50 hover:text-first-orange'); ?>" href="#">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-comments text-sm"></i>
                </span>
                <span class="mx-4 text-sm font-medium">Conseil orientation</span>
            </a>

            <!-- Lien vers la vue des filières disponibles -->
            <a class="sous_element_sidebar group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ml-4 <?php echo e(request()->is('orientation/filieres') ? 'sous_menu_sidebar_actif bg-orange-100 text-first-orange border-l-4 border-first-orange' : 'text-gray-600 hover:bg-orange-50 hover:text-first-orange'); ?>" href="#">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-road text-sm"></i>
                </span>
                <span class="mx-4 text-sm font-medium">Filières disponibles</span>
            </a>
        </div>
    </div>

    <!-- Gestion des bourses -->
    <div x-data="{ open: false }">
        <button type="button" class="element_sidebar group flex items-center justify-between w-full px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->is('bourse*') ? 'element_sidebar_acitf bg-first-orange text-white shadow-md' : 'text-gray-700 hover:bg-first-orange hover:text-white hover:shadow-md'); ?>" @click="open = !open">
            <div class="flex items-center">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-hand-holding-usd text-base"></i>
                </span>
                <span class="mx-4 text-base font-medium">
                    Suivi bourses
                </span>
            </div>
            <i x-bind:class="{'fa-caret-down': !open, 'fa-caret-up' : open}" class="fa-solid transition-transform duration-300"></i>
        </button>

        <div class="bg-gray-50 rounded-lg mt-1 shadow-inner overflow-hidden transition-all duration-500"
             x-ref="bourseContainer"
             x-bind:style="open ? 'max-height: ' + $refs.bourseContainer.scrollHeight + 'px' : 'max-height: 0'">
            
            <!-- Lien vers la vue des demandes de bourse -->
            <a class="sous_element_sidebar group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ml-4 <?php echo e(request()->is('bourse/demandes') ? 'sous_menu_sidebar_actif bg-orange-100 text-first-orange border-l-4 border-first-orange' : 'text-gray-600 hover:bg-orange-50 hover:text-first-orange'); ?>" href="#">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-file-alt text-sm"></i>
                </span>
                <span class="mx-4 text-sm font-medium">Demandes de bourse</span>
            </a>

            <!-- Lien vers la vue d'attribution des bourses -->
            <a class="sous_element_sidebar group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ml-4 <?php echo e(request()->is('bourse/attribution') ? 'sous_menu_sidebar_actif bg-orange-100 text-first-orange border-l-4 border-first-orange' : 'text-gray-600 hover:bg-orange-50 hover:text-first-orange'); ?>" href="#">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-award text-sm"></i>
                </span>
                <span class="mx-4 text-sm font-medium">Attribution bourses</span>
            </a>

            <!-- Lien vers la vue de suivi des bourses -->
            <a class="sous_element_sidebar group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 ml-4 <?php echo e(request()->is('bourse/suivi') ? 'sous_menu_sidebar_actif bg-orange-100 text-first-orange border-l-4 border-first-orange' : 'text-gray-600 hover:bg-orange-50 hover:text-first-orange'); ?>" href="#">
                <span class="text-left w-6">
                    <i class="menu-icon fa-solid fa-chart-bar text-sm"></i>
                </span>
                <span class="mx-4 text-sm font-medium">Suivi des bourses</span>
            </a>
        </div>
    </div>
<?php endif; ?>

<!-- FIN DES NOUVEAUX MODULES - UNIQUEMENT POUR LES ADMINISTRATEURS -->


    </nav>

    <div class="mb-1 mt-auto w-full flex items-center justify-start w-full text-gray-500 hover:bg-first-orange hover:text-white px-2 rounded-md">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
            <g id="Help">
                <path id="Vector" d="M14.167 2.74463H5.83366C3.33366 2.74463 1.66699 4.4113 1.66699 6.9113V11.9113C1.66699 14.4113 3.33366 16.078 5.83366 16.078V17.853C5.83366 18.5196 6.57533 18.9196 7.12533 18.5446L10.8337 16.078H14.167C16.667 16.078 18.3337 14.4113 18.3337 11.9113V6.9113C18.3337 4.4113 16.667 2.74463 14.167 2.74463ZM10.0003 12.8863C9.65033 12.8863 9.37533 12.603 9.37533 12.2613C9.37533 11.9196 9.65033 11.6363 10.0003 11.6363C10.3503 11.6363 10.6253 11.9196 10.6253 12.2613C10.6253 12.603 10.3503 12.8863 10.0003 12.8863ZM11.0503 9.42797C10.7253 9.64464 10.6253 9.7863 10.6253 10.0196V10.1946C10.6253 10.5363 10.342 10.8196 10.0003 10.8196C9.65866 10.8196 9.37533 10.5363 9.37533 10.1946V10.0196C9.37533 9.05296 10.0837 8.57796 10.3503 8.39463C10.6587 8.1863 10.7587 8.04463 10.7587 7.82796C10.7587 7.4113 10.417 7.06963 10.0003 7.06963C9.58366 7.06963 9.24199 7.4113 9.24199 7.82796C9.24199 8.16963 8.95866 8.45296 8.61699 8.45296C8.27533 8.45296 7.99199 8.16963 7.99199 7.82796C7.99199 6.71963 8.89199 5.81963 10.0003 5.81963C11.1087 5.81963 12.0087 6.71963 12.0087 7.82796C12.0087 8.77796 11.3087 9.25297 11.0503 9.42797Z" fill="#929EAE" />
            </g>
        </svg>

        <span class="mx-4 text-medium font-bold p-2">
            <a href="#">
                Aide
            </a>
        </span>
    </div>
    <div class="mb-1 w-full flex items-center justify-start w-full text-gray-500 hover:bg-first-orange hover:text-white px-2 rounded-md">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M6.56515 10.0583C6.56515 9.71663 6.84849 9.43329 7.19015 9.43329H11.7568V2.38329C11.7485 1.98329 11.4318 1.66663 11.0318 1.66663C6.12349 1.66663 2.69849 5.09163 2.69849 9.99996C2.69849 14.9083 6.12349 18.3333 11.0318 18.3333C11.4235 18.3333 11.7485 18.0166 11.7485 17.6166V10.675H7.19015C6.84015 10.6833 6.56515 10.4 6.56515 10.0583Z" fill="#929EAE" />
            <path d="M17.1179 9.6168L14.7512 7.24177C14.5096 7.0001 14.1096 7.0001 13.8679 7.24177C13.6262 7.48343 13.6262 7.88343 13.8679 8.1251L15.1679 9.42513H11.7512V10.6751H15.1596L13.8596 11.9751C13.6179 12.2168 13.6179 12.6168 13.8596 12.8585C13.9846 12.9835 14.1429 13.0418 14.3012 13.0418C14.4596 13.0418 14.6179 12.9835 14.7429 12.8585L17.1096 10.4835C17.3596 10.2501 17.3596 9.85847 17.1179 9.6168Z" fill="#929EAE" />
        </svg>

        <span class="mx-4 text-medium font-bold p-2">
            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Se déconnecter
            </a>

            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                <?php echo csrf_field(); ?>
            </form>

        </span>
    </div>
    <div class="mb-5 w-full flex items-center justify-start w-full text-gray-500 px-2 rounded-md">
        <span class="text-small font-bold pt-2">
            <a href="javascript:void(0);">
                @MEFPT_CI
            </a>
        </span>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/AMIE-FPT/resources/views/layouts/navigation.blade.php ENDPATH**/ ?>