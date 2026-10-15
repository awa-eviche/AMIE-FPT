<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historique des personnels
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <h3 class="text-lg font-bold mb-4">
                    Sélectionnez un personnel pour voir son historique
                </h3>

                <form method="GET" class="mb-6">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Rechercher un personnel…"
                           class="w-full md:w-1/3 border rounded px-3 py-2 text-sm">
                    <button type="submit"
                            class="px-4 py-2 bg-orange-500 text-white rounded text-sm ml-2">
                        Rechercher
                    </button>
                </form>

                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Personnel</th>
                            <th class="p-3 text-left">Établissement actuel</th>
                            <th class="p-3 text-left">Fonction</th>
                            <th class="p-3 text-left">Statut</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personnels as $p)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3">
                                    {{ $p->user?->prenom }} {{ $p->user?->nom }}
                                    <div class="text-xs text-gray-500">{{ $p->user?->email }}</div>
                                </td>
                                <td class="p-3">{{ $p->etablissement?->nom ?? '—' }}</td>
                                <td class="p-3">{{ $p->fonction ?? '—' }}</td>
                                <td class="p-3">
                                    @if($p->actif)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Actif</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">Clôturé</span>
                                    @endif
                                </td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('personnel.historique', $p->user_id) }}"
                                       class="px-3 py-1 bg-blue-600 text-white rounded text-xs">
                                        Voir l'historique
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">
                                    Aucun personnel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $personnels->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>