<div>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 rounded px-4 py-2 mb-4 text-sm font-semibold flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

{{-- ===== EN-TÊTE ===== --}}
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">
            <i class="fa-regular fa-calendar-days text-green-700 me-2"></i>Gestion des emplois du temps
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            @if($classeCourante)
                {{ $classeCourante->libelle }}
                <span class="bg-gray-200 text-gray-700 rounded px-2 py-0.5 text-xs font-semibold ml-1">{{ $classeCourante->modalite }}</span>
            @else
                Sélectionnez une classe pour commencer
            @endif
        </p>
    </div>
    <div class="flex items-center gap-4 text-xs font-semibold">
        <span class="flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-full px-3 py-1"><span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span> PPO</span>
        <span class="flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 rounded-full px-3 py-1"><span class="w-2.5 h-2.5 rounded-full bg-green-600 inline-block"></span> APC</span>
    </div>
</div>

{{-- ===== FILTRES ===== --}}
<div class="border border-gray-200 rounded-lg mb-6 bg-gray-50 overflow-hidden">
    <div class="p-5">

    {{-- Type de planning --}}
    <div class="mb-4">
        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Type d'emploi du temps</label>
        <div class="flex items-center gap-3 flex-wrap">
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
            <span class="text-xs text-gray-500">
                @if($typePlanning === 'hebdomadaire')
                    Un planning différent pour chaque semaine (S1 à S52).
                @else
                    Un planning-type unique, valable pour tout le semestre.
                @endif
            </span>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 items-end">

        <div class="flex-1 min-w-[160px]">
            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Année académique</label>
            <select class="w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:border-blue-500 focus:ring-blue-500" wire:model.live="anneeAcademiqueId">
                <option value="">-- Choisir --</option>
                @foreach($annees as $annee)
                    <option value="{{ $annee->id }}">{{ $annee->annee1 }}-{{ $annee->annee2 }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Classe</label>
            <select class="w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:border-blue-500 focus:ring-blue-500" wire:model.live="classeId">
                <option value="">-- Choisir --</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->libelle }}</option>
                @endforeach
            </select>
        </div>

        @if($typePlanning === 'hebdomadaire')
            {{-- Navigation semaine --}}
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Semaine</label>
                <div class="flex items-center gap-2">
                    <button class="w-9 h-9 rounded-md border border-gray-300 bg-white hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed"
                            wire:click="semainePrecedente" title="Semaine précédente"
                            @if($semaine <= $semaineMin) disabled @endif>
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <span class="px-3 py-1.5 bg-green-100 border border-green-300 rounded-md font-bold text-green-800 text-sm min-w-[52px] text-center">S{{ $semaine }}</span>
                    <button class="w-9 h-9 rounded-md border border-gray-300 bg-white hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed"
                            wire:click="semaineSuivante" title="Semaine suivante"
                            @if($semaine >= $semaineMax) disabled @endif>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-2 rounded-md"
                            wire:click="allerSemaineActuelle" title="Revenir à la semaine actuelle">
                        <i class="fa-regular fa-clock"></i> Aujourd'hui
                    </button>
                </div>
            </div>
        @else
            {{-- Sélection semestre --}}
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">Semestre</label>
                <select class="border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:border-blue-500 focus:ring-blue-500 min-w-[150px]" wire:model.live="semestre">
                    <option value="1">Semestre 1</option>
                    <option value="2">Semestre 2</option>
                </select>
            </div>
        @endif
    </div>

    @if(!$classeId || !$anneeAcademiqueId)
        <p class="text-xs text-gray-500 mt-3">
            <i class="fa-regular fa-circle-question me-1"></i>Choisissez une année académique et une classe pour afficher ou créer un emploi du temps.
        </p>
    @endif
    </div>
</div>

@if($emploiCourant)

    {{-- ===== BARRE D'ACTIONS ===== --}}
    <div class="flex justify-between items-center flex-wrap gap-3 mb-4">
        <span class="text-sm text-gray-500">
            <i class="fa-regular fa-calendar me-1"></i>{{ $emploiCourant->libellePeriode }}
            &nbsp;•&nbsp; {{ $emploiCourant->creneaux->count() }} créneau(x)
        </span>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('emploi-du-temps.pdf', $emploiCourant->id) }}" target="_blank"
               style="background-color:#006D3A"
               class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-4 py-2 inline-flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Télécharger PDF
            </a>
            @if($estAutorise)
                <button wire:click="ouvrirModalCreneau"
                        style="background-color:#006D3A"
                        class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-4 py-2 inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Ajouter un créneau
                </button>
            @endif
        </div>
    </div>

    {{-- ===== GRILLE HORAIRE ===== --}}
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
                        $parJour   = $emploiCourant->creneaux->groupBy('jour');
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
                                                <div class="text-gray-600 mt-0.5">
                                                    <i class="fa-solid fa-user-tie fa-xs text-gray-400"></i>
                                                    {{ optional(optional($cr->formateur)->user)->prenom }}
                                                    {{ optional(optional($cr->formateur)->user)->nom }}
                                                </div>
                                                <div class="text-gray-500">
                                                    {{ substr($cr->heure_debut,0,5) }}–{{ substr($cr->heure_fin,0,5) }}
                                                    @if($cr->salle) &nbsp;<i class="fa-solid fa-location-dot fa-xs"></i> {{ $cr->salle }} @endif
                                                </div>
                                                @if($estAutorise)
                                                    <div class="flex gap-1 mt-1">
                                                        <button class="bg-green-100 text-green-700 hover:bg-green-200 rounded px-1.5 py-0.5 text-[10px]"
                                                                wire:click="ouvrirModalCreneau({{ $cr->id }})">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>
                                                        <button class="bg-red-100 text-red-700 hover:bg-red-200 rounded px-1.5 py-0.5 text-[10px]"
                                                                wire:click="supprimerCreneau({{ $cr->id }})"
                                                                onclick="return confirm('Supprimer ce créneau ?')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @endif
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

@else
    <div class="text-center py-16 px-5 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
        <i class="fa-regular fa-calendar-days text-5xl text-gray-400 mb-3"></i>
        <p class="text-gray-500 font-semibold">Sélectionnez une classe et une année académique</p>
    </div>
@endif

{{-- ===== MODAL ===== --}}
@if($showModal)
    <div class="fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center p-4" wire:click.self="fermerModal">
        <div class="bg-white rounded-lg shadow-xl w-[600px] max-w-full max-h-[90vh] overflow-y-auto">
            <div class="p-4 border-b bg-gray-50 flex items-center justify-between">
                <h5 class="font-bold text-lg text-green-700">
                    <i class="fa-regular fa-clock me-2"></i>
                    {{ $creneauId ? 'Modifier le créneau' : 'Nouveau créneau' }}
                </h5>
                <button wire:click="fermerModal" class="text-red-600 font-bold text-lg leading-none">✕</button>
            </div>
            <div class="p-5">

                @if($errors->any())
                    <div class="bg-red-50 border border-red-300 rounded-md px-4 py-3 mb-4">
                        <p class="font-bold text-red-700 text-xs mb-1">
                            <i class="fa-solid fa-circle-exclamation me-1"></i> Veuillez corriger les erreurs :
                        </p>
                        @foreach($errors->all() as $err)
                            <p class="text-red-700 text-xs">• {{ $err }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            <i class="fa-regular fa-calendar-days text-green-700 me-1"></i> Jour <span class="text-red-600">*</span>
                        </label>
                        <select class="w-full border rounded-md shadow-sm text-sm px-3 py-2 focus:border-green-500 focus:ring-green-500 {{ $errors->has('jour') ? 'border-red-500' : 'border-gray-300' }}"
                                wire:model.live="jour">
                            @foreach(['lundi','mardi','mercredi','jeudi','vendredi','samedi'] as $j)
                                <option value="{{ $j }}" {{ $jour === $j ? 'selected' : '' }}>
                                    {{ ucfirst($j) }}
                                </option>
                            @endforeach
                        </select>
                        @error('jour')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            <i class="fa-regular fa-clock text-green-700 me-1"></i> Début <span class="text-red-600">*</span>
                        </label>
                        <input type="time" class="w-full border rounded-md shadow-sm text-sm px-3 py-2 focus:border-green-500 focus:ring-green-500 {{ $errors->has('heureDebut') ? 'border-red-500' : 'border-gray-300' }}"
                               wire:model.live="heureDebut">
                        @error('heureDebut')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            <i class="fa-regular fa-clock text-green-700 me-1"></i> Fin <span class="text-red-600">*</span>
                        </label>
                        <input type="time" class="w-full border rounded-md shadow-sm text-sm px-3 py-2 focus:border-green-500 focus:ring-green-500 {{ $errors->has('heureFin') ? 'border-red-500' : 'border-gray-300' }}"
                               wire:model.live="heureFin">
                        @error('heureFin')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            <i class="fa-solid fa-user-tie text-green-700 me-1"></i> Formateur <span class="text-red-600">*</span>
                        </label>
                        <select class="w-full border rounded-md shadow-sm text-sm px-3 py-2 focus:border-green-500 focus:ring-green-500 {{ $errors->has('formateurId') ? 'border-red-500' : 'border-gray-300' }}"
                                wire:model.live="formateurId">
                            <option value="">-- Sélectionner --</option>
                            @foreach($formateurs as $f)
                                <option value="{{ $f->id }}">
                                    {{ optional($f->user)->prenom }} {{ optional($f->user)->nom }}
                                </option>
                            @endforeach
                        </select>
                        @if($formateurs->isEmpty())
                            <p class="text-yellow-600 text-xs mt-1">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                Aucun formateur assigné à cette classe.
                            </p>
                        @endif
                        @error('formateurId')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            <i class="fa-solid fa-location-dot text-green-700 me-1"></i> Salle
                        </label>
                        <input type="text" class="w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:border-green-500 focus:ring-green-500"
                               wire:model="salle" placeholder="Ex: Salle A1">
                    </div>
                </div>

                <div>
                    @if($classeCourante?->modalite === 'APC')
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            <i class="fa-solid fa-star text-green-700 me-1"></i> Compétence / Ressource
                        </label>
                        <select class="w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:border-green-500 focus:ring-green-500" wire:model="apcContenu"
                                @if(!$formateurId) disabled @endif>
                            <option value="">-- Sélectionner --</option>
                            @if(($contenus['ressources'] ?? collect())->isNotEmpty())
                                <optgroup label="Ressources">
                                    @foreach($contenus['ressources'] as $r)
                                        <option value="ressource:{{ $r->id }}">{{ $r->nom }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                            @if(($contenus['particulieres'] ?? collect())->isNotEmpty())
                                <optgroup label="Compétences (sans ressource)">
                                    @foreach($contenus['particulieres'] as $c)
                                        <option value="competence:{{ $c->id }}">{{ $c->code }} – {{ $c->nom }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                        @if(!$formateurId)
                            <p class="text-gray-400 text-xs mt-1">Sélectionnez d'abord un formateur.</p>
                        @elseif(($contenus['ressources'] ?? collect())->isEmpty() && ($contenus['particulieres'] ?? collect())->isEmpty())
                            <p class="text-yellow-600 text-xs mt-1">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                Aucune compétence assignée à ce formateur pour cette classe.
                            </p>
                        @endif
                    @else
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1.5">
                            <i class="fa-solid fa-book text-green-700 me-1"></i> Matière
                        </label>
                        <select class="w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2 focus:border-green-500 focus:ring-green-500" wire:model="matiereId"
                                @if(!$formateurId) disabled @endif>
                            <option value="">-- Sélectionner --</option>
                            @foreach($contenus as $m)
                                <option value="{{ $m->id }}">{{ $m->nom }}</option>
                            @endforeach
                        </select>
                        @if(!$formateurId)
                            <p class="text-gray-400 text-xs mt-1">Sélectionnez d'abord un formateur.</p>
                        @elseif($contenus->isEmpty())
                            <p class="text-yellow-600 text-xs mt-1">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                Aucune matière assignée à ce formateur pour cette classe.
                            </p>
                        @endif
                    @endif
                </div>
            </div>

            <div class="px-5 pb-5 flex justify-end gap-2">
                <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg text-sm px-4 py-2"
                        wire:click="fermerModal">Annuler</button>
                <button wire:click="sauvegarderCreneau"
                        wire:loading.attr="disabled"
                        wire:target="sauvegarderCreneau"
                        style="background-color:#006D3A"
                        class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-4 py-2 min-w-[130px] flex items-center justify-center">
                    <span wire:loading.remove wire:target="sauvegarderCreneau">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Enregistrer
                    </span>
                    <span wire:loading wire:target="sauvegarderCreneau">
                        <i class="fa-solid fa-spinner fa-spin me-1"></i> Enregistrement…
                    </span>
                </button>
            </div>
        </div>
    </div>
@endif

</div>
