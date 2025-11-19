<?php
setlocale(LC_TIME, 'fr_FR.utf8');
$dateActuelle = strftime("%d %B %Y %H:%M");
?>


<header class="relative">
 <div class="flex items-center justify-between px-4 py-3">
        <!-- Mobile menu button -->
        <div class="flex items-center space-x-4">
            <button @click="isMobileMainMenuOpen = !isMobileMainMenuOpen"
                class="p-2 text-gray-600 rounded-md md:hidden hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                <span class="sr-only">Ouvrir le menu</span>
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Branding -->
            <div class="flex flex-col min-w-0">
                <?php if(Auth()->user()->personnel && Auth()->user()->personnel->etablissement): ?>
                    <h1 class="text-lg font-bold truncate md:text-xl text-primary-600">
                        <?php echo e(Auth()->user()->personnel->etablissement->nom); ?>

                    </h1>
                <?php endif; ?>
                
                <!-- Desktop - User info -->
                <div class="text-sm ">
                    <span class="text-gray-600">Bonjour, </span>
                    <span class="font-medium text-primary-500">
                        <?php echo e(Auth()->user()->prenom.' '.Auth()->user()->nom); ?>

                    </span>
                    <span class="ml-2 text-xs text-gray-500"><?php echo e($dateActuelle); ?></span>
                </div>
            </div>
        </div>

        <!-- Desktop marquee -->
        <div class="flex-1  mx-4">
            <div class="px-4 py-1 text-sm bg-gray-50 rounded-md">
                <marquee class="text-gray-600">Bienvenue sur AMIE FPT : Application de Management Intégré des Etablissements de Formation professionnelle et technique</marquee>
            </div>
        </div>

        <!-- Desktop navigation -->
        <div class="flex items-center space-x-3">
            <!-- Notifications -->
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('notification-menu', []);

$__html = app('livewire')->mount($__name, $__params, 'lw--1931726304-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

            <!-- User menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    id="user-menu" aria-haspopup="true">
                    <span class="sr-only">Profil utilisateur</span>
                    <img class="w-16 h-16 rounded-full" src="<?php echo e(asset('backofficeAssets/build/images/imagepgi.svg')); ?>" alt="Profil">
                </button>

                <!-- Dropdown menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    @click.away="open = false"
                    class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                    
                    <a href="/user/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        Profil
                    </a>
                    
                    <?php if(!auth()->user()->hasRole(config('constants.roles.superadmin')) && !auth()->user()->hasRole(config('constants.roles.ia')) && auth()->user()->can('visualiser_etablissement_info')): ?>
                    <a href="etablissement-info" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        Mon établissement
                    </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        Déconnexion
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile main manu -->
    <div class="border-b md:hidden bg-sp-green" x-show="isMobileMainMenuOpen"
        @click.away="isMobileMainMenuOpen = false">
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
                <a class="element_sidebar <?php echo e(request()->is('classe*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('classe.index')); ?>">
                    <span class="text-left">
                    <i class="menu-icon fa-regular fa-building"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Classes
                    </span>
                </a>
            <?php endif; ?>


          


            
            
            <?php if(auth()->user()->can('edit_inscription')): ?>
                <!-- <a class="element_sidebar <?php echo e(request()->is('inscription*') ? 'element_sidebar_acitf' : ''); ?> <?php echo e(request()->is('evaluation*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('inscription.index')); ?>">
                    <span class="text-left">
                    <i class="fas fa-user"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Gestions des Evaluations
                    </span>
                </a> -->
                <div x-data="{ open: <?php echo e(request()->is('parametrage*') ? 'true' : 'false'); ?> }">

<p type="button" class="element_sidebar relative
    <?php echo e(request()->is('parametrage*') ? 'element_sidebar_acitf' : ''); ?>" @click="open = !open">
    <span class="text-left">
        <i class="menu-icon fa-solid fa-gears"></i>
    </span>
    <span class="mx-4 text-base font-normal">
        <span> Gestion des Evaluations</span>
    </span>
    <i x-bind:class="{'fa-caret-down': open == false, 'fa-caret-up' : open == true }" class="fa-solid absolute right-0 mr-3"></i>

</p>

<div class="bg-gray-100 border-x border-2-maquette-gris rounded shadow-inner relative -top-2 overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="open ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : 'border:none'">
      <a class="element_sidebar <?php echo e(request()->is('inscription*') ? 'element_sidebar_acitf' : ''); ?> <?php echo e(request()->is('evaluation*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('inscription.index')); ?>">
                    <span class="text-left">
                    <i class="fas fa-user"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                     Evaluation PPO
                    </span>
                </a>
                <a class="element_sidebar" href="<?php echo e(route('competence.manage.index')); ?>">
                    <span class="text-left">
                    <i class="fas fa-user"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                     Evaluation APC
                    </span>
                </a>
   
   
</div>

</div>
            <?php endif; ?>


         
           
            
         

             <?php if(auth()->user()->hasRole(config('constants.roles.chef_etablissement'))): ?>
                
                <a class="element_sidebar <?php echo e(request()->is('admin*') ? 'element_sidebar_acitf' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                    <span class="text-left">
                        <i class="menu-icon fa-solid fa-users-gear"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Utilisateurs
                    </span>
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
                        Gestion des indicateurs
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
                                Matière
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
                                Type Indicateur
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
                                Critère
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
    </nav>

    </div>
</header>
<?php /**PATH /var/www/html/pgi/resources/views/layouts/header.blade.php ENDPATH**/ ?>