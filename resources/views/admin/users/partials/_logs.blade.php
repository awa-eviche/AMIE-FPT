<div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-white uppercase bg-first-orange dark:bg-first-orange dark:text-white">
        <tr>
            <th scope="col" class="px-6 py-3 text-center">Date</th>
            <th scope="col" class="px-6 py-3 text-center">Action</th>
            <th scope="col" class="px-6 py-3 text-center">Utilisateur</th>
            {{--<th scope="col" class="px-6 py-3 text-center">Description</th>--}}
            <th scope="col" class="px-6 py-3 text-center">Actions</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        @if ($logs->count() == 0)
            <tr>
                <td colspan="7"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center hover:border-l-8 border-first-orange">
                    Aucun historique à afficher.
                </td>
            </tr>
        @endif
        @foreach ($logs as $log)
            <tr class="bg-white border-b dark:bg-white dark:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-100">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $log->created_at }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ \App\Enums\UserAction::getDescription($log->action) }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $log->user->identite ?? '' }}
                </td>
                {{--<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-regal-black text-center">
                    {{ $user->description }}
                </td>--}}
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('users.logs.detail', $log) }}"
                       class="text-blue-500 mr-2 hover:text-blue-200 focus:text-blue-200" data-toggle="tooltip"
                       title="Détail">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="p-2">
        {{ $logs->links('pagination::tailwind') }}
    </div>
</div>