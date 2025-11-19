@php
    $breadcrumbs = [
            ['url' => '/admin/users', 'name' => 'Liste des utilisateurs'],
            ['url' => '', 'name' => 'Détail de l\'utilisateur'],  
];
  @endphp

<h2 class="text-gray-800 font-bold text-2xl md:pb-8">Détails utilisateur</h2>
<div class="flex justify-start pb-10">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
</div>
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="md:container md:mx-auto">
            <div class="mt-4 text-gray-800 font-bold text-sm">
                Informations de l'utilisateur
            </div>
            <div class="flex flex-row justify-center">
                @if(!empty($user->avatar))
                <div class="w-1/4">
                    <div class="w-64 h-64 rounded-full overflow-hidden">
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="avatar" class="object-cover w-full h-full">
                    </div>
                </div>
                @endif
            </div>
            <div class="flex flex-row justify-end">
                <div class="">
                    <a href="{{route('users.logs', $user->id)}}" class="text-white bg-first-orange  hover:bg-first-orange focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-2"><span><i class="fa fa-check pr-1"></i></span>Historique de l'utilisateur</a>
                </div>
                <div class="">
                    <a href="{{ route('users.edit', $user) }}" class="text-white bg-first-orange  hover:bg-first-orange focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5">Modifier</a>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white shadow overflow-hidden rounded-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Nom : </strong>
                                <span class="text-gray-900">{{ $user->nom }}</span>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Prénom :</strong>
                                <span class="text-gray-900">{{ $user->prenom }}</span>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Date de naissance : </strong>
                                <span class="text-gray-900">{{ $user->date_naissance}}</span>
                            </div>
                        </li>
                        @if($user->roles->count() > 0)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Rôle :</strong>
                                <span class="text-gray-900">
                                    @foreach($user->roles as $role)
                                    <span class="px-2 py-1 bg-blue-500 rounded text-white text-xs mr-2">{{ $role->description }}</span>
                                    @endforeach
                                </span>
                            </div>
                        </li>
                        @endif
                        @if((auth()->user()->hasRole(config('constants.roles.chef_etablissement'))) && auth()->user()->can('edit_personnel'))
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Dernier diplôme académique : </strong>
                                <span class="text-gray-900">{{ optional($user->personnel)->dernierDiplomeAcademique ?? "Non renseigné"}}</span>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Fonction : </strong>
                                <span class="text-gray-900">{{ optional($user->personnel)->fonction ?? "Non renseigné"}}</span>
                            </div>
                        </li>
                        @endif

                    </ul>
                </div>
                <div class="bg-white shadow overflow-hidden rounded-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Email :</strong>
                                <span class="text-gray-900">{{ $user->email }}</span>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Adresse :</strong>
                                <span class="text-gray-900">{{ $user->adresse }}</span>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Sexe :</strong>
                                <span class="text-gray-900">{{ $user->sexe }}</span>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Téléphone :</strong>
                                <span class="text-gray-900">{{ $user->telephone }}</span>
                            </div>
                        </li>
            
                        @if((auth()->user()->hasRole(config('constants.roles.chef_etablissement'))) && auth()->user()->can('edit_personnel'))
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Dernier diplôme professionnel : </strong>
                                <span class="text-gray-900">{{ optional($user->personnel)->dernierDiplomeProfessionnel ?? "Non renseigné"}}</span>
                            </div>
                        </li> <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Interne :</strong>
                                <span class="text-gray-900">{{ optional($user->personnel)->interne ? "Oui" : "Non"}}</span>
                            </div>
                        </li>
                        @endif

                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Date d'ajout :</strong>
                                <span class="text-gray-900">{!! $user->created_at->format('d/m/Y H:i:s') !!}</span>
                            </div>
                        </li>

                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>