<div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-white uppercase bg-first-orange dark:bg-first-orange dark:text-white">
        <tr>
            <th scope="col" class="px-6 py-3 text-center">#ID</th>
            <th scope="col" class="px-6 py-3 text-center">Nom</th>
            <th scope="col" class="px-6 py-3 text-center">Description</th>
            <th scope="col" class="px-6 py-3 text-center">Permissions</th>
            <th scope="col" class="px-6 py-3 text-center">Actions</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        @if ($roles->count() == 0)
            <tr>
                <td colspan="6"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center hover:border-l-8 border-first-orange">
                    Aucun rôle à afficher.
                </td>
            </tr>
        @endif
        @foreach ($roles as $role)
            <tr class="bg-white border-b dark:bg-white dark:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-100">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $role->id}}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $role->name}}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $role->description}}
                </td>
                <td>
                    @foreach($role->permissions as $permission)
                        <span class="inline-block px-3 py-1 mb-2 mr-1 text-sm font-bold text-white bg-indigo-500 rounded-lg">{{ $permission->description }}</span>
                    @endforeach
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('roles.edit', $role) }}" class="text-black-50 mr-2"
                       data-toggle="tooltip" title="Modifier">
                        <i class="fas fa-edit text-black-50"></i>
                    </a>
                    {!! Form::open(array(
                                        'method' => 'DELETE',
                                        'class' => 'delete-form',
                                        'style' => 'display: inline;',
                                        'route' => array('roles.destroy', $role))) !!}
                    {{ csrf_field() }}
                    <a href="#delete" class="text-danger apix-delete" data-toggle="tooltip" title="Supprimer">
                        <i class="fas fa-trash text-red-500"></i>
                    </a>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="p-2">
        {{ $roles->links('pagination::tailwind') }}
    </div>
</div>