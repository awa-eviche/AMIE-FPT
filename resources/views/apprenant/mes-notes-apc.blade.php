<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mon Carnet de Compétences
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">

        {{-- En-tête apprenant --}}
        <div class="bg-white rounded-lg shadow p-5 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="rounded-full p-3" style="background-color: #e6f2ec;">
                        <i class="fa fa-user-graduate text-2xl" style="color: #236F46;"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">
                            {{ $inscription->apprenant->nom ?? '' }} {{ $inscription->apprenant->prenom ?? '' }}
                        </h1>
                        <div class="flex flex-wrap gap-3 mt-1 text-sm text-gray-500">
                            <span><i class="fa fa-school mr-1" style="color: #236F46;"></i>{{ $inscription->classe->libelle ?? '-' }}</span>
                            <span><i class="fa fa-calendar mr-1" style="color: #236F46;"></i>{{ $inscription->anneeAcademique->code ?? '-' }}</span>
                            <span><i class="fa fa-building mr-1" style="color: #236F46;"></i>{{ $inscription->classe->etablissement->nom ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                <a href="{{ url()->previous() }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm flex items-center gap-2">
                    <i class="fa fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        {{-- Filtre semestre --}}
        @php
            $semActif = request('semestre', '');
            $semestres = collect([1, 2]);
        @endphp

        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ request()->fullUrlWithQuery(['semestre' => '']) }}"
               class="px-4 py-2 rounded-full text-xs font-semibold transition"
               style="{{ $semActif === '' ? 'background-color: #236F46; color: white;' : 'background-color: #e5e7eb; color: #374151;' }}">
                Tous les semestres
            </a>
            @foreach($semestres as $sem)
            <a href="{{ request()->fullUrlWithQuery(['semestre' => $sem]) }}"
               class="px-4 py-2 rounded-full text-xs font-semibold transition"
               style="{{ $semActif == $sem ? 'background-color: #236F46; color: white;' : 'background-color: #e5e7eb; color: #374151;' }}">
                Semestre {{ $sem }}
            </a>
            @endforeach
        </div>

        {{-- Semestres à afficher --}}
        @php
            $semAafficher = $semActif !== '' ? [$semActif] : [1, 2];
        @endphp

        @foreach($semAafficher as $sem)
        @php
            $mccSem  = $mccByRessource->get((string)$sem) ?? collect();
            $evalSem = $evalByRessource->get((string)$sem) ?? collect();

            // Vérifier s'il y a des données pour ce semestre
            $hasData = false;
            foreach($competencesGenerales->merge($competencesParticulieres) as $comp) {
                foreach(($comp->ressources ?? collect()) as $res) {
                    if($mccSem->has($res->id) || $evalSem->has($res->id)) {
                        $hasData = true; break 2;
                    }
                }
            }
        @endphp

        <div class="mb-8 bg-white rounded-lg shadow overflow-hidden">
            {{-- Header semestre + bouton PDF --}}
            <div class="flex items-center justify-between px-5 py-4 text-white" style="background-color: #236F46;">
                <h2 class="font-bold text-base flex items-center gap-2">
                    <i class="fa fa-calendar-alt"></i> Semestre {{ $sem }}
                </h2>
                <a href="{{ route('inscription.pdf.apc', ['id' => $inscription->id, 'semestre' => $sem]) }}"
                   target="_blank"
                   class="flex items-center gap-2 px-3 py-1.5 bg-white text-xs font-semibold rounded-md hover:bg-gray-100"
                   style="color: #236F46;">
                    <i class="fa fa-file-pdf text-red-500"></i> Télécharger carnet S{{ $sem }}
                </a>
            </div>

            @if(!$hasData)
            <div class="text-center py-10">
                <i class="fa fa-clock text-gray-300 text-4xl"></i>
                <p class="text-gray-500 mt-3 font-semibold">Notes du Semestre {{ $sem }} non encore disponibles</p>
            </div>
            @else

            <div class="p-4">
                @include('apprenant.partials.tableau-apc-notes', [
                    'competences'   => $competencesGenerales,
                    'mccSem'        => $mccSem,
                    'evalSem'       => $evalSem,
                    'obsFromNote'   => $obsFromNote,
                    'titre'         => 'Compétences Générales',
                    'couleur'       => '#236F46',
                ])

                <div class="mt-6">
                    @include('apprenant.partials.tableau-apc-notes', [
                        'competences'   => $competencesParticulieres,
                        'mccSem'        => $mccSem,
                        'evalSem'       => $evalSem,
                        'obsFromNote'   => $obsFromNote,
                        'titre'         => 'Compétences Particulières',
                        'couleur'       => '#1a5c38',
                    ])
                </div>
            </div>
            @endif
        </div>
        @endforeach

    </div>
</x-app-layout>