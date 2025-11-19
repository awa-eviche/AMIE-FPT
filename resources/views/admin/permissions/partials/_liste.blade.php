<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-white uppercase bg-first-orange dark:bg-first-orange dark:text-white">
        <tr>
            <th scope="col" class="px-6 py-3 text-center">#ID</th>
            <th scope="col" class="px-6 py-3 text-center">Nom</th>
            <th scope="col" class="px-6 py-3 text-center">Description</th>
            <th scope="col" class="px-6 py-3 text-center">Actions</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        @if ($permissions->count() == 0)
            <tr>
                <td colspan="6"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center hover:border-l-8 border-first-orange">
                    Aucune permission à afficher.
                </td>
            </tr>
        @endif
        @foreach ($permissions as $permission)
            <tr class="bg-white border-b dark:bg-white dark:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-100">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $permission->id}}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $permission->name}}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $permission->description}}
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('permissions.edit', $permission) }}" class="text-black-50 mr-2"
                       data-toggle="tooltip" title="Modifier">
                        <i class="fas fa-edit text-black-50"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="p-2">
        {{ $permissions->links('pagination::tailwind') }}
    </div>
</div>