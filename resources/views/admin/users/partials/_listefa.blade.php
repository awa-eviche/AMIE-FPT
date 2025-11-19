<div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-600">
        <thead class="text-xs text-white uppercase bg-first-orange dark:bg-first-orange dark:text-white">
            <tr>
                <th scope="col" class="px-6 py-3 text-center"></th>
                @if(optional(optional(Auth()->user()->personnel)->etablissement)->id == null)
                <th scope="col" class="px-6 py-3 text-center">Etablissement</th>
                @endif
                <th scope="col" class="px-6 py-3 text-center">Nom</th>
                <th scope="col" class="px-6 py-3 text-center">Prénom</th>
                <th scope="col" class="px-6 py-3 text-center">Courrier</th>
                <th scope="col" class="px-6 py-3 text-center">Téléphone</th>
                {{--<th scope="col" class="px-6 py-3 text-center">Adresse</th>--}}
                <th scope="col" class="px-6 py-3 text-center">Profil</th>
                <th scope="col" class="px-6 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @if ($users->count() == 0)
            <tr>

                <td @if(optional(optional(Auth()->user()->personnel)->etablissement)->id == null) colspan="8" @else colspan="7" @endif class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center hover:border-l-8 border-first-orange">
                    Aucun utilisateur à afficher.
                </td>
            </tr>
            @endif
            @foreach ($users as $user)
            <tr class="bg-white border-b dark:bg-white dark:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-100">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center hover:border-l-8 border-first-orange">
                    <img class="min-avatar" src="{{ !empty($user->profile_photo_path) ? asset('storage/avatars/'.$user->profile_photo_path) : asset('assets/images/user.png') }}" alt="user">
                </td>
                @if(optional(optional(Auth()->user()->personnel)->etablissement)->id == null)
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    {{ optional(optional($user->personnel)->etablissement)->nom }}
                </td>
                @endif
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    {{ $user->nom }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    {{ $user->prenom }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    {{ $user->telephone }}
                </td>
                {{--<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    {{ $user->adresse}}
                </td>--}}
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500 text-center">
                    @foreach($user->roles as $role)
                    <span class="inline-block px-3 py-1 mb-2 mr-1 text-sm font-bold text-white bg-gray rounded-lg">
                        {{ $role->description ?? 'Non renseigné' }}
                    </span>
                    @endforeach
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('users.show', $user) }}" class="text-blue-500 mr-2 hover:text-blue-200 focus:text-blue-200" data-toggle="tooltip" title="Détail">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </a>
                    <a href="{{ route('users.accessForum', $user) }}" class="text-blue-500 mr-2 hover:text-blue-200 focus:text-blue-200" data-toggle="tooltip" title="Accès forum">
                        <i class="fas fa-globe text-green-500"></i>
                    </a>
                    {!! Form::open(array(
                    'method' => 'PATCH',
                    'class' => 'apix-form',
                    'style' => 'display: inline;',
                    'route' => array('users.activation', $user->id))) !!}
                    {{ csrf_field() }}
                    @if($user->isActive())
                    <a href="#" class="text-yellow-500 mr-2 apix-confirm" data-toggle="tooltip" title="Désactiver">
                        <i class="fas fa-lock text-yellow-500"></i>
                    </a>
                    @else
                    <a href="#" class="text-green-500 mr-2 apix-confirm" data-toggle="tooltip" title="Activer">
                        <i class="fas fa-check text-green-500"></i>
                    </a>
                    @endif
                    {!! Form::close() !!}
                    <a href="{{ route('users.edit', $user) }}" class="text-black-50 mr-2 hover:text-black-200 focus:text-black-200" data-toggle="tooltip" title="Modifier">
                        <i class="fas fa-edit text-black-50"></i>
                    </a>
                    {!! Form::open(array(
                    'method' => 'PATCH',
                    'class' => 'apix-form',
                    'style' => 'display: inline;',
                    'route' => array('users.resetPassword', $user->id))) !!}
                    {{ csrf_field() }}
                    <a href="#" class="text-red-500 mr-2 apix-confirm" data-toggle="tooltip" title="Réinitialiser mot de passe">
                        <i class="fas fa-refresh text-red-500"></i>
                    </a>
                    {!! Form::close() !!}
                     @if($isDeletable)
                        {!! Form::open(array(
                                            'method' => 'DELETE',
                                            'class' => 'delete-form',
                                            'style' => 'display: inline;',
                                            'route' => array('users.destroy', $user))) !!}
                        {{ csrf_field() }}
                    <a href="#delete" class="text-danger apix-delete" data-toggle="tooltip" title="Supprimer">
                        <i class="fas fa-trash text-red-500"></i>
                    </a>
                    {!! Form::close() !!}
                    @endif 
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-2">
        {{ $users->links('pagination::tailwind') }}
    </div>
</div>
