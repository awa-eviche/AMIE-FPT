<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mutations des personnels
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded shadow">

                <form method="GET" class="grid md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Recherche</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Nom, prénom, email"
                               class="w-full border rounded px-3 py-2 text-sm">
                    </div>

                    @if($isSuperAdmin)
                        <div>
                            <label class="block text-sm font-medium mb-1">Établissement</label>
                            <select name="etablissement_id" class="w-full border rounded px-3 py-2 text-sm">
                                <option value="">Tous</option>
                                @foreach($etablissements as $e)
                                    <option value="{{ $e->id }}" @selected(request('etablissement_id') == $e->id)>
                                        {{ $e->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="flex items-end">
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded text-sm">
                            Filtrer
                        </button>
                    </div>
                </form>

                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Personnel</th>
                            <th class="p-3 text-left">Établissement actuel</th>
                            <th class="p-3 text-left">Fonction</th>
                           
                            <th class="p-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personnels as $p)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $p->user?->prenom }} {{ $p->user?->nom }}
                                    <div class="text-xs text-gray-500">{{ $p->user?->email }}</div>
                                </td>
                                <td class="p-3">{{ $p->etablissement?->nom ?? '—' }}</td>
                                <td class="p-3">{{ $p->fonction }}</td>
                               
                                <td class="p-3 text-right">
                                <a href="{{ route('personnel.muter', $p->id) }}"
   class="px-3 py-1 bg-orange-600 text-white rounded text-xs font-bold">
    Muter
</a>
                                    <a href="{{ route('personnel.historique', $p->user_id) }}"
                                       class="px-3 py-1 bg-gray-200 rounded text-xs">
                                        Historique
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">
                                    Aucun personnel actif.
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