<div class="reins">
    {{-- ✅ Messages --}}
    @if(session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition
            class="bg-green-200 text-green-800 p-3 rounded mb-4" >
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition
            class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4"
        >
            {{ session('warning') }}
        </div>
    @endif

    {{-- 🔺 Erreur de validation --}}
    @error('decisions')
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            {{ $message }}
        </div>
    @enderror

    {{-- Classe et année d'origine --}}
    <div class="reins-card reins-grid">
        <div>
            <label class="reins-label">Classe</label>
            <select wire:model="classe" wire:change="$refresh" class="reins-select">
                <option value="">-- Choisir une classe --</option>
                @foreach ($classes as $c)
                    <option value="{{ $c->id }}">{{ $c->libelle }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="reins-label">Année académique</label>
            {{-- Année d'origine fixée : seule l'avant-dernière année est proposée --}}
            <select wire:model="annee_academique_id" class="reins-select">
                @foreach ($annees as $a)
                    @continue($a->id != $annee_academique_id)
                    <option value="{{ $a->id }}">{{ $a->code }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($currentClasse && $annee_academique_id)
        @php
            $isApc = $currentClasse->modalite === 'APC';
            $aTraiter = collect($admis)->whereNull('suite');
            $nbPasse = $aTraiter->filter(fn($e) => ($decisions[$e['inscription']->apprenant_id] ?? '') === 'passe')->count();
            $nbRedouble = $aTraiter->filter(fn($e) => ($decisions[$e['inscription']->apprenant_id] ?? '') === 'redouble')->count();
            $nbSansDecision = $aTraiter->count() - $nbPasse - $nbRedouble;
            $nbPages = max(1, (int) ceil(count($admis) / $parPage));
            $pageCourante = min($page, $nbPages);
            $debut = ($pageCourante - 1) * $parPage;
        @endphp

        @if(count($admis) > 0)
            <div class="reins-card reins-card-flush">
                {{-- En-tête : titre et actions groupées --}}
                <div class="reins-head">
                    <div>
                        <div class="reins-title">{{ $currentClasse->libelle }}</div>
                        <div class="reins-sub">{{ count($admis) }} apprenant(s)</div>
                    </div>
                    <div class="reins-actions">
                        <button type="button" wire:click="toutMarquer('passe')" class="reins-bulk reins-bulk-passe">Tous passent</button>
                        <button type="button" wire:click="toutMarquer('redouble')" class="reins-bulk reins-bulk-redouble">Tous redoublent</button>
                        <button type="button" wire:click="toutMarquer('')" class="reins-bulk">Effacer</button>
                    </div>
                </div>

                {{-- Tableau des apprenants --}}
                <table class="reins-table">
                    <thead>
                        <tr>
                            <th style="width: 48px;">#</th>
                            <th>Apprenant</th>
                            <th>Matricule</th>
                            @unless($isApc)
                                <th>Moyenne</th>
                            @endunless
                            <th class="reins-right">Décision</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_slice($admis, $debut, $parPage) as $entry)
                            @php
                                $apprenantId = $entry['inscription']->apprenant_id;
                                $decision = $decisions[$apprenantId] ?? '';
                                $peutPasser = $isApc || $entry['admis'];
                            @endphp
                            <tr wire:key="reins-{{ $apprenantId }}" class="{{ $entry['suite'] ? 'reins-row-done' : 'reins-row-' . ($decision ?: 'aucune') }}">
                                <td class="reins-muted">{{ $debut + $loop->iteration }}</td>
                                <td>
                                    <span class="reins-name">{{ $entry['inscription']->apprenant->nom }} {{ $entry['inscription']->apprenant->prenom }}</span>
                                    {{-- Redoublant sur l'année affichée --}}
                                    @if($entry['inscription']->redoublant)
                                        <span class="reins-badge reins-badge-redouble">Redoublant</span>
                                    @endif
                                </td>
                                <td class="reins-muted">{{ $entry['inscription']->apprenant->matricule }}</td>
                                @unless($isApc)
                                    <td>
                                        @if($entry['moyenne'] === null)
                                            <span class="reins-muted">—</span>
                                        @else
                                            <span class="reins-badge {{ $entry['admis'] ? 'reins-badge-passe' : 'reins-badge-nonadmis' }}">{{ $entry['moyenne'] }}</span>
                                        @endif
                                    </td>
                                @endunless
                                <td class="reins-right">
                                    @if($entry['suite'])
                                        {{-- Déjà réinscrit sur une année postérieure --}}
                                        <span class="reins-badge {{ $entry['suite']['redoublant'] ? 'reins-badge-redouble' : 'reins-badge-passe' }}">
                                            {{ $entry['suite']['redoublant']
                                                ? 'Redouble en ' . $entry['suite']['annee']
                                                : $entry['suite']['classe'] . ' en ' . $entry['suite']['annee'] }}
                                        </span>
                                        {{-- Erreur de réinscription : on annule, puis on refait le bon choix --}}
                                        <button type="button" class="reins-undo"
                                            wire:click="annulerReinscription({{ $apprenantId }})"
                                            onclick="confirm('Annuler cette réinscription ? L\'apprenant pourra ensuite être réinscrit autrement.') || event.stopImmediatePropagation()">
                                            Annuler
                                        </button>
                                    @else
                                        <div class="reins-choix">
                                            <button type="button" wire:click="decider({{ $apprenantId }}, 'passe')"
                                                class="reins-option reins-option-passe {{ $decision === 'passe' ? 'is-on' : '' }}"
                                                @unless($peutPasser) disabled title="Non admis : ne peut que redoubler" @endunless>
                                                Passe
                                            </button>
                                            <button type="button" wire:click="decider({{ $apprenantId }}, 'redouble')"
                                                class="reins-option reins-option-redouble {{ $decision === 'redouble' ? 'is-on' : '' }}">
                                                Redouble
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($nbPages > 1)
                    <div class="reins-foot reins-pages">
                        <span class="reins-sub">
                            {{ $debut + 1 }} à {{ min($debut + $parPage, count($admis)) }} sur {{ count($admis) }}
                        </span>
                        <div class="reins-actions">
                            <button type="button" class="reins-bulk" wire:click="allerPage({{ $pageCourante - 1 }})" @disabled($pageCourante === 1)>Précédent</button>
                            @for ($p = 1; $p <= $nbPages; $p++)
                                <button type="button" wire:click="allerPage({{ $p }})"
                                    class="reins-bulk {{ $p === $pageCourante ? 'reins-page-on' : '' }}">{{ $p }}</button>
                            @endfor
                            <button type="button" class="reins-bulk" wire:click="allerPage({{ $pageCourante + 1 }})" @disabled($pageCourante === $nbPages)>Suivant</button>
                        </div>
                    </div>
                @endif

                {{-- Destination --}}
                <div class="reins-foot reins-grid">
                    <div>
                        <label class="reins-label">Année de réinscription</label>
                        {{-- Année de réinscription fixée : seule la dernière année est proposée --}}
                        <select wire:model="annee_reinscription_id" class="reins-select">
                            @foreach ($annees as $a)
                                @continue($a->id != $annee_reinscription_id)
                                <option value="{{ $a->id }}">{{ $a->code }}</option>
                            @endforeach
                        </select>
                        @error('annee_reinscription_id')
                            <p class="reins-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Classe d'accueil : seulement s'il y a des apprenants qui passent --}}
                    @if($nbPasse > 0)
                        <div>
                            <label class="reins-label">Classe d'accueil de ceux qui passent</label>
                            <select wire:model="nouvelle_classe_id" wire:change="$refresh" class="reins-select">
                                <option value="">-- Choisir --</option>
                                @foreach ($classes as $c)
                                    @continue($isApc && $c->modalite !== 'APC')
                                    @continue($c->id === $currentClasse->id)
                                    <option value="{{ $c->id }}">{{ $c->libelle }}</option>
                                @endforeach
                            </select>
                            @error('nouvelle_classe_id')
                                <p class="reins-error">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                {{-- Récapitulatif et validation --}}
                <div class="reins-foot reins-bar">
                    <div class="reins-chips">
                        <span class="reins-chip reins-badge-passe"><strong>{{ $nbPasse }}</strong> passent</span>
                        <span class="reins-chip reins-badge-redouble"><strong>{{ $nbRedouble }}</strong> redoublent</span>
                        <span class="reins-chip"><strong>{{ $nbSansDecision }}</strong> sans décision</span>
                    </div>
                    <button wire:click="reinscrire" wire:loading.attr="disabled" class="reins-submit">
                        Valider la réinscription
                    </button>
                </div>
            </div>
        @else
            <div class="reins-card reins-muted">
                Aucun apprenant inscrit dans cette classe pour cette année académique.
            </div>
        @endif
    @endif

    <style>
        .reins-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 2px rgba(15, 23, 42, .05); }
        .reins-card-flush { padding: 0; overflow: hidden; }
        .reins-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; }

        .reins-label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .reins-select { width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 14px; background-color: #fff; }
        .reins-select:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, .15); }
        .reins-error { font-size: 13px; color: #b91c1c; margin-top: 4px; }
        .reins-muted { color: #64748b; }

        .reins-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; padding: 16px 20px; }
        .reins-title { font-size: 17px; font-weight: 700; color: #0f172a; }
        .reins-sub { font-size: 13px; color: #64748b; }
        .reins-actions { display: flex; flex-wrap: wrap; gap: 8px; }
        .reins-bulk { border: 1px solid #cbd5e1; background: #fff; color: #475569; border-radius: 8px; padding: 6px 14px; font-size: 13px; font-weight: 500; cursor: pointer; }
        .reins-bulk:hover { background: #f1f5f9; }
        .reins-bulk-passe { border-color: #86efac; color: #166534; }
        .reins-bulk-passe:hover { background: #f0fdf4; }
        .reins-bulk-redouble { border-color: #fdba74; color: #9a3412; }
        .reins-bulk-redouble:hover { background: #fff7ed; }

        .reins-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .reins-table th { text-align: left; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #64748b; background: #f8fafc; padding: 10px 20px; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
        .reins-table td { padding: 10px 20px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .reins-table .reins-right { text-align: right; }
        .reins-name { font-weight: 600; color: #0f172a; }
        .reins-row-passe td:first-child { box-shadow: inset 3px 0 0 #16a34a; }
        .reins-row-redouble td:first-child { box-shadow: inset 3px 0 0 #ea580c; }
        .reins-row-passe { background: #f7fef9; }
        .reins-row-redouble { background: #fffaf5; }
        .reins-row-done { background: #f8fafc; }

        .reins-badge { display: inline-block; font-size: 12px; font-weight: 600; padding: 2px 10px; border-radius: 999px; background: #f1f5f9; color: #334155; }
        .reins-badge-passe { background: #dcfce7; color: #166534; }
        .reins-badge-redouble { background: #ffedd5; color: #9a3412; }
        .reins-badge-nonadmis { background: #fee2e2; color: #b91c1c; }

        .reins-choix { display: inline-flex; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; background: #fff; }
        .reins-option { border: 0; background: #fff; color: #475569; padding: 6px 16px; font-size: 13px; font-weight: 500; cursor: pointer; white-space: nowrap; }
        .reins-option + .reins-option { border-left: 1px solid #cbd5e1; }
        .reins-option:hover { background: #f1f5f9; }
        .reins-option-passe.is-on { background: #16a34a; color: #fff; font-weight: 600; }
        .reins-option-redouble.is-on { background: #ea580c; color: #fff; font-weight: 600; }
        .reins-option:disabled, .reins-option:disabled:hover { background: #f8fafc; color: #cbd5e1; cursor: not-allowed; }

        .reins-undo { margin-left: 8px; border: 1px solid #cbd5e1; background: #fff; color: #b91c1c; border-radius: 8px; padding: 4px 12px; font-size: 13px; font-weight: 500; cursor: pointer; }
        .reins-undo:hover { background: #fef2f2; border-color: #fca5a5; }

        .reins-foot { padding: 16px 20px; border-top: 1px solid #e2e8f0; }
        .reins-pages { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; border-top: 0; }
        .reins-page-on, .reins-page-on:hover { background: #4f46e5; border-color: #4f46e5; color: #fff; }
        .reins-bulk:disabled, .reins-bulk:disabled:hover { background: #f8fafc; color: #cbd5e1; cursor: not-allowed; }
        .reins-bar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; background: #f8fafc; }
        .reins-chips { display: flex; flex-wrap: wrap; gap: 8px; }
        .reins-chip { font-size: 13px; padding: 4px 12px; border-radius: 999px; background: #e2e8f0; color: #334155; }
        .reins-submit { background: #16a34a; color: #fff; border: 0; border-radius: 8px; padding: 10px 22px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .reins-submit:hover { background: #15803d; }
        .reins-submit:disabled { opacity: .6; cursor: wait; }
    </style>
</div>
