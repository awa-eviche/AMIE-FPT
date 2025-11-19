<div class="h-full bg-white  overflow-auto flex flex-col justify-between px-3">
    <!-- l'image logo -->
    <div class="flex justify-end">
        <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="isOpen = !isOpen" aria-label="Menu">
        <a href="/dashboard">
        <img src="{{asset('assets/images/logopgi.png')}}" class="w-full object-cover" alt="Icon"/>
        </a>
    </button>

    </div>
    <div class="flex items-center justify-start pt-6">

        <h1 class="mt-0 ml-4 text-3xl font-bold">
            <div class="flex items-center justify-center overflow-hidden">
            <a href="/dashboard">
            <img src="{{asset('frontAssets2/images/logoamifpt.jpg')}}" class="w-full object-cover" alt="Icon"/>
            </div>
            </a>
        </h1>
    </div>
 
    <!-- les elements du sidebar -->
    <nav class="my-6">
        <div>
            {{-- tableau de bord --}}
            <a class="element_sidebar {{ request()->is('dashboard*') ? 'element_sidebar_acitf' : '' }}" href="/dashboard">
                <span class="text-left">
                    <i class="menu-icon fa-solid fa-gauge"></i>
                </span>
                <span class="mx-4 text-base font-normal">
                    Tableau de bord
                </span>
            </a>

            {{-- etablissements --}}
            @can('visualiser_etablissement')
                <a class="element_sidebar {{ request()->is('etablissement*') ? 'element_sidebar_acitf' : '' }}" href="{{route('etablissement.index')}}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-address-book"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Etablissements
                    </span>
                </a>
            @endcan

            @if(auth()->user()->can('visualiser_mes_filieres') and !auth()->user()->hasRole(config('constants.roles.superadmin')))
                <a class="element_sidebar {{ request()->is('niveauetudeetablissement*') ? 'element_sidebar_acitf' : '' }}" href="{{route('niveauetudeetablissement.index')}}">
                <span class="text-left">
                <i class="menu-icon fa-solid fa-at"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">

                        Programmes de formation
                    </span>
                </a>
            @endif

            {{-- @if(auth()->user()->can('visualiser_apprenant') and !auth()->user()->hasRole(config('constants.roles.superadmin')))
                <a class="element_sidebar {{ request()->is('apprenant*') ? 'element_sidebar_acitf' : '' }}" href="{{route('apprenant.index')}}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-address-book"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">

                        Apprenants
                    </span>
                </a>
            @endif --}}

            {{-- @if(auth()->user()->can('visualiser_classe_matiere') and !auth()->user()->hasRole(config('constants.roles.superadmin'))) --}}
            @if(auth()->user()->can('visualiser_classe_matiere'))
                <a class="element_sidebar {{ request()->is('classe*') ? 'element_sidebar_acitf' : '' }}" href="{{route('classe.index')}}">
                    <span class="text-left">
                    <i class="menu-icon fa-regular fa-building"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Classes
                    </span>
                </a>
            @endif


          


            
            {{-- @if(auth()->user()->can('visualiser_inscription') and !auth()->user()->hasRole(config('constants.roles.superadmin'))) --}}
            @if(auth()->user()->can('edit_inscription'))
                <!-- <a class="element_sidebar {{ request()->is('inscription*') ? 'element_sidebar_acitf' : '' }} {{ request()->is('evaluation*') ? 'element_sidebar_acitf' : '' }}" href="{{route('inscription.index')}}">
                    <span class="text-left">
                    <i class="fas fa-user"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Gestions des Evaluations
                    </span>
                </a> -->
                <div x-data="{ open: {{ request()->is('parametrage*') ? 'true' : 'false' }} }">

<p type="button" class="element_sidebar relative
    {{ request()->is('parametrage*') ? 'element_sidebar_acitf' : ''}}" @click="open = !open">
    <span class="text-left">
        <i class="menu-icon fa-solid fa-gears"></i>
    </span>
    <span class="mx-4 text-base font-normal">
        <span> Gestion des Evaluations</span>
    </span>
    <i x-bind:class="{'fa-caret-down': open == false, 'fa-caret-up' : open == true }" class="fa-solid absolute right-0 mr-3"></i>

</p>

<div class="bg-gray-100 border-x border-2-maquette-gris rounded shadow-inner relative -top-2 overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="open ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : 'border:none'">
      <a class="element_sidebar {{ request()->is('inscription*') ? 'element_sidebar_acitf' : '' }} {{ request()->is('evaluation*') ? 'element_sidebar_acitf' : '' }}" href="{{route('inscription.index')}}">
                    <span class="text-left">
                    <i class="fas fa-user"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                     Evaluation PPO
                    </span>
                </a>
		   <a class="element_sidebar {{ request()->is('inscription*') ? 'element_sidebar_acitf' : '' }} {{ request()->is('evaluation*') ? 'element_sidebar_acitf' : '' }}" href="{{route('competence.manage.index')}}">
                    <span class="text-left">
                    <i class="fas fa-user"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                     Evaluation APC
                    </span>
                </a>   
   
</div>

</div>
            @endif


         
           
            
         

              @if(auth()->check() && (
    auth()->user()->hasRole('chef_etablissement') ||
    auth()->user()->hasRole('assistante')
))
    <a class="element_sidebar {{ request()->is('admin*') ? 'element_sidebar_acitf' : '' }}" href="{{ route('users.index') }}">
        <span class="text-left"><i class="menu-icon fa-solid fa-users-gear"></i></span>
        <span class="mx-4 text-base font-normal">Utilisateurs</span>
    </a>
@endif

       

        
            @if(auth()->user()->hasRole(config('constants.roles.superadmin')))
            <a class="element_sidebar {{ request()->is('demande*') ? 'element_sidebar_acitf' : '' }}" href="{{route("demande.index")}}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-bookmark"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Demandes
                    </span>
                </a>
            @endif

            @if(auth()->user()->hasRole(config('constants.roles.chef_etablissement')))
            <a class="element_sidebar {{ request()->is('demande*') ? 'element_sidebar_acitf' : '' }}" href="{{ route('demande.demandebyEfpt', auth()->user()->personnel->etablissement_id) }}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-bookmark"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Demandes
                    </span>
                </a>
            @endif

            @if(auth()->user()->can('visualiser_demande') )
                {{-- demande --}}
                {{--    <a class="element_sidebar {{ request()->is('demande*') ? 'element_sidebar_acitf' : '' }}" href="{{route("demande.index")}}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-bookmark"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Demandes
                    </span>
                </a> --}}
                

                <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('indicateur.index')}}">
                    <span class="text-left">
                        <i class="menu-icon fa-solid fa-level-up"></i>

                    </span>
                    <span class="mx-4 text-base font-normal">
                        Suivi des survey
                    </span>
                </a>
            @endif
            @if(auth()->user()->can('gerer_administration') )
                {{-- administration --}}
                <a class="element_sidebar {{ request()->is('admin*') ? 'element_sidebar_acitf' : '' }}" href="{{ route('admin.index') }}">
                    <span class="text-left">
                        <i class="menu-icon fa-solid fa-users-gear"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Administration
                    </span>
                </a>
             @endif
            
                {{-- demande --}}
                <a class="element_sidebar {{ request()->is('document*') ? 'element_sidebar_acitf' : '' }}" href="{{ route('document.category') }}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-folder-open fa-sm fa-fw"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Espace documentaire
                    </span>
                </a>
                   @if(auth()->user()->hasRole('chef_etablissement'))
                <a class="element_sidebar {{ request()->is('materiel*') ? 'element_sidebar_acitf' : '' }}" href="{{ route('materiel.index') }}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-folder-open fa-sm fa-fw"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Matériels affectés
                    </span>
                </a>
             @endif
                 @if(auth()->user()->hasRole('superadmin'))
                <div x-data="{ open: {{ request()->is('parametrage*') ? 'true' : 'false' }} }">

                    <p type="button" class="element_sidebar relative
                        {{ request()->is('parametrage*') ? 'element_sidebar_acitf' : ''}}" @click="open = !open">
                        <span class="text-left">
                            <i class="menu-icon fa-solid fa-gears"></i>
                        </span>
                        <span class="mx-4 text-base font-normal">
                            <span>Paramètrage</span>
                        </span>
                        <i x-bind:class="{'fa-caret-down': open == false, 'fa-caret-up' : open == true }" class="fa-solid absolute right-0 mr-3"></i>

                    </p>

                    <div class="bg-gray-100 border-x border-2-maquette-gris rounded shadow-inner relative -top-2 overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="open ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : 'border:none'">
                        <a class="element_sidebar {{ request()->is('parametrage/workflow*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('workflow.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-recycle"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Flux de traitement des demandes
                            </span>
                        </a>
                        <a class="element_sidebar {{ request()->is('parametrage/type_demande*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('type_demande.index')}}">
                            <span class="text-left">
                                <i class="fa-regular fa-folder-open"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Type demande
                            </span>
                        </a>
                        <a class="element_sidebar {{ request()->is('parametrage/type_notification*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('type_notification.index')}}">
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
            @endif
                    
            @if(auth()->user()->can('gerer_parametrage') )
                <div x-data="{ open: {{ request()->is('referentiel*') ? 'true' : 'false' }} }">

                    <p type="button" class="element_sidebar relative
                        {{ request()->is('referentiel*') ? 'element_sidebar_acitf' : ''}}" @click="open = !open">
                        <span class="text-left">
                            <i class="menu-icon fa-solid fa-book"></i>
                        </span>
                        <span class="mx-4 text-base font-normal">
                            <span>Données de Base</span>
                        </span>
                        <i x-bind:class="{'fa-caret-down': open == false, 'fa-caret-up' : open == true }" class="fa-solid absolute right-0 mr-3"></i>

                    </p>

                    <div class="bg-gray-100 border-x border-2-maquette-gris rounded shadow-inner relative -top-2 overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container1" x-bind:style="open ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : 'border:none'">
                        
                    @can('visualiser_domaine')
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('secteur.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-layer-group"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Secteur
                            </span>
                        </a>
                    @endcan
                    
                       
                      
                    
                    @can('visualiser_filiere')
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('filiere.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-at"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Filière
                            </span>
                        </a>
                    @endcan
                    @can('visualiser_metier')
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('metier.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-binoculars"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Métier
                            </span>
                        </a>
                    @endcan
                    
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('matiere.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-road"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Matière
                            </span>
                        </a>
                    
                    
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('diplome.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-graduation-cap"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Diplôme
                            </span>
                        </a>
                    
                    @can('visualiser_niveau')
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('niveauetude.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-level-up"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Niveau
                            </span>
                        </a>
                    @endcan
                    @if (auth()->user()->hasRole(config('constants.roles.superadmin')))
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('typeIndicateur.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-level-up"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Type Survey
                            </span>
                        </a>
                   
                        
                    @endcan
                   

                 
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('competence.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-road"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Competence
                            </span>
                        </a>
                 

              
                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('elementcompetence.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-road"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Element de Competence
                            </span>
                        </a>
                   


                    <a class="element_sidebar {{ request()->is('referentiel/critere*') ? 'sous_menu_sidebar_actif' : '' }}"
                            href="{{ route('critere.index') }}">
                            <span class="text-left">
                                <i class="fa-solid fa-check-circle"></i>

                            </span>
                            <span class="mx-4 text-sm font-bold">
                                Critère
                            </span>
                        </a>


                         <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('region.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-map-location-dot"></i>


                            </span>
                            <span class="mx-4 text-base font-normal">
                                Région
                            </span>
                        </a>
                        
   <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('departement.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-location-dot"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Département
                            </span>
                        </a>

   <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('commune.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-map-pin"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Commune
                            </span>
                        </a>
                    
                     <a class="element_sidebar {{ request()->is('liste*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('liste.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-clipboard-list"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Liste
                            </span>
                        </a>

                    
                    <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('ia.index')}}">
                        <span class="text-left">
                            <i class="menu-icon fa-solid fa-map-pin"></i>

                        </span>
                        <span class="mx-4 text-base font-light">
                         IA
                        </span>
                    </a>

                    <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('ief.index')}}">
                        <span class="text-left">
                            <i class="menu-icon fa-solid fa-map-pin"></i>

                        </span>
                        <span class="mx-4 text-base font-light">
                         IEF
                        </span>
                    </a>

                        <a class="element_sidebar {{ request()->is('referentiel/*') ? 'sous_menu_sidebar_actif' : '' }}" href="{{route('anneeacademique.index')}}">
                            <span class="text-left">
                                <i class="menu-icon fa-solid fa-hourglass"></i>

                            </span>
                            <span class="mx-4 text-base font-normal">
                                Année Académique
                            </span>
                        </a>
                    
                    </div>
                </div>
            @endif



            {{-- actualite --}}
            @can('gerer_actualite_et_faq')
                <a class="element_sidebar {{ request()->is('page-acceuil/actualite*') ? 'element_sidebar_acitf' : '' }}" href="{{route('actualite.index')}}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-newspaper"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Actualités
                    </span>
                </a>

                {{-- FAQ --}}
                <!--a class="element_sidebar {{ request()->is('page-acceuil/faqs*') ? 'element_sidebar_acitf' : '' }}" href="{{route('faqs.index')}}">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-question"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                    FAQ
                    </span>
                </a-->
                @endcan



            {{-- forum --}}
                <!--a class="element_sidebar {{ request()->is('forum*') ? 'element_sidebar_acitf' : '' }}" href="{{route("forum")}}"  target="_blank">
                    <span class="text-left">
                        <i class="menu-icon fa-regular fa-bookmark"></i>
                    </span>
                    <span class="mx-4 text-base font-normal">
                        Accéder au forum
                    </span>
                </a-->

        </div>
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
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Se déconnecter
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </span>
    </div>
    <div class="mb-5 w-full flex items-center justify-start w-full text-gray-500 px-2 rounded-md">
        <span class="text-small font-bold pt-2">
            <a href="javascript:void(0);">
                @MFP_CI
            </a>
        </span>
    </div>
</div>
