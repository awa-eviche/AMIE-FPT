<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes Notes & Évaluations
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
            $semestres = $evaluations->pluck('semestre')->unique()->sort()->values();
            $semActif  = request('semestre', '');
            $filtered  = $semActif !== ''
                ? $evaluations->filter(fn($e) => (string)$e['semestre'] === (string)$semActif)->values()
                : $evaluations;
            $sem1 = $evaluations->filter(fn($e) => (string)$e['semestre'] === '1')->values();
            $sem2 = $evaluations->filter(fn($e) => (string)$e['semestre'] === '2')->values();
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

        @if($filtered->isEmpty())
            <div class="text-center py-16 bg-white rounded-lg shadow">
                <i class="fa fa-inbox text-gray-300 text-6xl"></i>
                <p class="text-gray-500 mt-4 font-semibold text-lg">
                    @if($semActif !== '')
                        Notes du Semestre {{ $semActif }} non encore disponibles
                    @else
                        Aucune évaluation trouvée.
                    @endif
                </p>
            </div>
        @else

            {{-- SEMESTRE 1 --}}
            @if($sem1->isNotEmpty() && ($semActif === '' || $semActif == '1'))
            <div class="mb-8 bg-white rounded-lg shadow overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 text-white" style="background-color: #236F46;">
                    <h2 class="font-bold text-base flex items-center gap-2">
                        <i class="fa fa-calendar-alt"></i> Semestre 1
                    </h2>
                    <a href="{{ route('inscription.pdf', ['id' => $inscription->id, 'semestre' => 1]) }}"
                       target="_blank"
                       class="flex items-center gap-2 px-3 py-1.5 bg-white text-xs font-semibold rounded-md hover:bg-gray-100"
                       style="color: #236F46;">
                        <i class="fa fa-file-pdf text-red-500"></i> Télécharger bulletin S1
                    </a>
                </div>
                <div class="p-4">
                    @include('apprenant.partials.tableau-notes', ['data' => $sem1])
                </div>
            </div>
            @endif

            {{-- SEMESTRE 2 --}}
            @if($sem2->isNotEmpty() && ($semActif === '' || $semActif == '2'))
            <div class="mb-8 bg-white rounded-lg shadow overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 text-white" style="background-color: #236F46;">
                    <h2 class="font-bold text-base flex items-center gap-2">
                        <i class="fa fa-calendar-alt"></i> Semestre 2
                    </h2>
                    <a href="{{ route('inscription.pdf', ['id' => $inscription->id, 'semestre' => 2]) }}"
                       target="_blank"
                       class="flex items-center gap-2 px-3 py-1.5 bg-white text-xs font-semibold rounded-md hover:bg-gray-100"
                       style="color: #236F46;">
                        <i class="fa fa-file-pdf text-red-500"></i> Télécharger bulletin S2
                    </a>
                </div>
                <div class="p-4">
                    @include('apprenant.partials.tableau-notes', ['data' => $sem2])
                </div>
            </div>
            @endif
        @endif
    </div>
</x-app-layout>