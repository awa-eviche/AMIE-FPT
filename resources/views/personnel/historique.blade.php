<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historique des affectations
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                {{-- Lien retour --}}
                <div class="mb-6">
                    <a href="{{ route('personnel.muter.index') }}" class="text-blue-500 text-sm">
                        &larr; Retour à la liste des mutations
                    </a>
                </div>

                {{-- Titre --}}
                <h3 class="text-lg font-bold mb-6">
                    {{ $user->prenom }} {{ $user->nom }}
                    <span class="text-sm text-gray-500">({{ $user->email }})</span>
                </h3>

                {{-- Tableau --}}
                @if($historique->isEmpty())
                    <p class="text-gray-500">Aucun historique d'affectation.</p>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">Établissement</th>
                                <th class="p-3 text-left">Fonction</th>
                                <th class="p-3 text-left">Du</th>
                                <th class="p-3 text-left">Au</th>
                                <th class="p-3 text-left">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historique as $h)
                                <tr class="border-t">
                                    <td class="p-3">{{ $h->etablissement?->nom ?? '—' }}</td>
                                    <td class="p-3">{{ $h->fonction ?? '—' }}</td>
                                    <td class="p-3">{{ $h->date_debut?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="p-3">{{ $h->date_fin?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="p-3">
                                        @if($h->actif)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                                Actif
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                                                Clôturé
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>