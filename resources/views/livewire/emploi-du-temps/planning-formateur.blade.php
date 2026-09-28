<div>

{{-- ===== EN-TÊTE ===== --}}
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">
            <i class="fa-regular fa-calendar-check text-green-700 me-2"></i>Mon planning
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            {{ $typePlanning === 'hebdomadaire' ? 'Semaine '.$semaine : 'Semestre '.$semestre }}
            @if($creneaux->isNotEmpty())
                — {{ $creneaux->count() }} classe(s)
            @endif
        </p>
    </div>
    @if($creneaux->isNotEmpty())
        <a href="{{ route('emploi-du-temps.formateur.pdf', [
                'annee'    => $anneeAcademiqueId,
                'mode'     => $typePlanning,
                'semaine'  => $semaine,
                'semestre' => $semestre,
           ]) }}"
           target="_blank"
           style="background-color:#006D3A"
           class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-4 py-2 inline-flex items-center gap-2">
            <i class="fa-solid fa-file-pdf"></i> Télécharger PDF
        </a>
    @endif
</div>

{{-- ===== FILTRES ===== --}}
<div class="border border-gray-200 rounded-lg mb-6 bg-gray-50 overflow-hidden">
    <div class="p-5">

    {{-- Type de planning --}}
    <div class="mb-4">
        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Type d'emploi du temps</label>
        <div class="inline-flex rounded-md border border-gray-300 overflow-hidden">
            <button type="button" wire:click="$set('typePlanning', 'hebdomadaire')"
                    @if($typePlanning === 'hebdomadaire') style="background-color:#006D3A" @endif
                    class="px-4 py-2 text-sm font-semibold {{ $typePlanning === 'hebdomadaire' ? 'bg-green-700 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                <i class="fa-regular fa-calendar-week me-1"></i> Hebdomadaire
            </button>
            <button type="button" wire:click="$set('typePlanning', 'semestriel')"
                    @if($typePlanning === 'semestriel') style="background-color:#006D3A" @endif
                    class="px-4 py-2 text-sm font-semibold border-l border-gray-300 {{ $typePlanning === 'semestriel' ? 'bg-green-700 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                <i class="fa-regular fa-calendar-days me-1"></i> Semestriel
            </button>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 items-end">

        <div>
            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Année académique</label>
            <select class="border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:border-blue-500 focus:ring-blue-500" wire:model.live="anneeAcademiqueId">
                @foreach($annees as $annee)
                    <option value="{{ $annee->id }}">{{ $annee->annee1 }}-{{ $annee->annee2 }}</option>
                @endforeach
            </select>
        </div>

        @if($typePlanning === 'hebdomadaire')
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Plage de semaines</label>
                <div class="flex items-center gap-2">
                    <input type="number" class="w-20 border border-gray-300 rounded-md shadow-sm text-sm px-2 py-2 text-center focus:border-blue-500 focus:ring-blue-500"
                           wire:model.live="semaineMin" min="1" max="53" placeholder="Deb" title="Semaine de début">
                    <span class="text-gray-400 font-bold">→</span>
                    <input type="number" class="w-20 border border-gray-300 rounded-md shadow-sm text-sm px-2 py-2 text-center focus:border-blue-500 focus:ring-blue-500"
                           wire:model.live="semaineMax" min="1" max="53" placeholder="Fin" title="Semaine de fin">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Semaine</label>
                <div class="flex items-center gap-2">
                    <button class="w-9 h-9 rounded-md border border-gray-300 bg-white hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed"
                            wire:click="semainePrecedente" @if($semaine <= $semaineMin) disabled @endif>
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <span class="px-3 py-1.5 bg-green-100 border border-green-300 rounded-md font-bold text-green-800 text-sm min-w-[52px] text-center">S{{ $semaine }}</span>
                    <button class="w-9 h-9 rounded-md border border-gray-300 bg-white hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed"
                            wire:click="semaineSuivante" @if($semaine >= $semaineMax) disabled @endif>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        @else
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Semestre</label>
                <select class="border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:border-blue-500 focus:ring-blue-500 min-w-[150px]" wire:model.live="semestre">
                    <option value="1">Semestre 1</option>
                    <option value="2">Semestre 2</option>
                </select>
            </div>
        @endif
    </div>
    </div>
</div>

{{-- ===== STATS ===== --}}
@php
    $totalCreneaux = $creneaux->sum(fn($d) => $d['parJour']->flatten()->count());
    $nbClasses     = $creneaux->count();
    $nbJours       = $creneaux->flatMap(fn($d) => $d['parJour']->keys())->unique()->count();
@endphp

@if($totalCreneaux > 0)
    <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-700">{{ $totalCreneaux }}</div>
            <div class="text-xs text-gray-500 uppercase font-semibold">Cours</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-700">{{ $nbJours }}</div>
            <div class="text-xs text-gray-500 uppercase font-semibold">Jours actifs</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-cyan-700">{{ $nbClasses }}</div>
            <div class="text-xs text-gray-500 uppercase font-semibold">Classe(s)</div>
        </div>
    </div>
@endif

{{-- ===== PLANNING PAR CLASSE ===== --}}
@if($creneaux->isEmpty())
    <div class="text-center py-16 px-5 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
        <i class="fa-regular fa-calendar-xmark text-5xl text-gray-400 mb-3"></i>
        <p class="text-gray-500 font-semibold">
            Aucun cours planifié pour {{ $typePlanning === 'hebdomadaire' ? 'la semaine '.$semaine : 'le semestre '.$semestre }}
        </p>
        <p class="text-gray-400 text-sm mt-1">Vérifiez que cet emploi du temps a été publié.</p>
    </div>
@else
    @foreach($creneaux as $classeId => $data)
        <div class="mb-7">
            <div class="flex items-center gap-3 mb-3 px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg">
                <i class="fa-solid fa-users text-gray-500"></i>
                <h4 class="font-bold text-gray-800">{{ $data['classe']?->libelle ?? 'Classe inconnue' }}</h4>
                @if($data['classe']?->modalite)
                    <span class="bg-gray-200 text-gray-700 rounded px-2 py-0.5 text-xs font-semibold">{{ $data['classe']->modalite }}</span>
                @endif
                <span class="ml-auto text-xs text-gray-500">
                    {{ $data['parJour']->flatten()->count() }} créneau(x)
                </span>
            </div>

            <div class="border border-gray-300 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr>
                                <th class="px-2 py-2 border border-gray-300 bg-gray-100 text-xs font-bold text-gray-600 uppercase w-14">Heure</th>
                                @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j)
                                    <th class="px-2 py-2 border border-green-800 text-xs font-bold text-white uppercase min-w-[150px]" style="background-color:#006D3A">{{ $j }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $heures    = ['07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00'];
                                $joursKeys = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
                                $parJour   = $data['parJour'];
                            @endphp
                            @foreach($heures as $h)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-2 py-2 border border-gray-300 bg-gray-50 text-xs font-semibold text-gray-500 text-center align-top">{{ $h }}</td>
                                    @foreach($joursKeys as $jour)
                                        <td class="p-1 border border-gray-300 align-top">
                                            @foreach($parJour->get($jour, collect()) as $cr)
                                                @if(substr($cr->heure_debut,0,2) === substr($h,0,2))
                                                    <div class="rounded p-2 mb-1 text-xs {{ $cr->matiere_id ? 'bg-blue-50 border-l-4 border-blue-600' : 'bg-green-50 border-l-4 border-green-600' }}">
                                                        <div class="font-bold {{ $cr->matiere_id ? 'text-blue-800' : 'text-green-800' }}">
                                                            {{ $cr->contenu ?: '—' }}
                                                        </div>
                                                        <div class="text-gray-500">
                                                            {{ substr($cr->heure_debut,0,5) }}–{{ substr($cr->heure_fin,0,5) }}
                                                            @if($cr->salle)
                                                                &nbsp;<i class="fa-solid fa-location-dot fa-xs"></i> {{ $cr->salle }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@endif

</div>
