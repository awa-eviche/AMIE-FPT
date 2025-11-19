<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="md:container md:mx-auto">
            <h2 class="text-first-orange text-2xl">Détail historique</h2>
            <div class="mt-4">
                <a href="{{ route('users.logs') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste</a>
            </div>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white shadow overflow-hidden rounded-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Date : </strong>
                                <span class="text-gray-900">{{ $log->created_at }}</span>
                            </div>
                        </li>
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Action : </strong>
                                <span class="text-gray-900">{{ \App\Enums\UserAction::getDescription($log->action) }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="bg-white shadow overflow-hidden rounded-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <strong class="text-md font-medium text-gray-600 mr-3">Utilisateur :</strong>
                                <span class="text-gray-900">{{ $log->user->identite ?? '' }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-5">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-lg font-bold mb-2">Ancien Objet</h2>
                    <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ json_encode(json_decode($log->old_object), JSON_PRETTY_PRINT) }}</pre>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-lg font-bold mb-2">Nouvel Objet</h2>
                    <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ json_encode(json_decode($log->new_object), JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>