<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size:10px; color:#1a1a2e; background:#fff; }
    .page { padding:16px 18px; }

    /* En-tête */
    .entete { display:table; width:100%; border-bottom:3px solid #1a56db; padding-bottom:10px; margin-bottom:12px; }
    .entete-titre { display:table-cell; text-align:center; vertical-align:middle; }
    .entete-titre h1 { font-size:15px; font-weight:900; color:#1a56db; text-transform:uppercase; letter-spacing:1px; }
    .entete-titre h2 { font-size:11px; font-weight:700; color:#374151; margin-top:3px; }
    .entete-titre .periode { font-size:10px; color:#6b7280; margin-top:2px; }
    .entete-meta { display:table-cell; width:110px; text-align:right; vertical-align:middle; font-size:8px; color:#6b7280; }

    /* Badge type */
    .badge-type { display:inline-block; padding:2px 10px; border-radius:10px; font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }
    .badge-hebdo { background:#dbeafe; color:#1d4ed8; border:1px solid #93c5fd; }
    .badge-semest { background:#dcfce7; color:#15803d; border:1px solid #86efac; }

    /* Info bar */
    .info-bar { display:table; width:100%; background:#f0f9ff; border:1px solid #bae6fd; border-radius:5px; padding:7px 12px; margin-bottom:10px; }
    .info-cell { display:table-cell; padding-right:16px; }
    .info-cell label { font-size:7.5px; font-weight:700; text-transform:uppercase; color:#0369a1; letter-spacing:.4px; display:block; }
    .info-cell span { font-size:9.5px; font-weight:700; color:#1e3a5f; }

    /* Grille */
    .grille { width:100%; border-collapse:collapse; font-size:8px; }
    .grille th { background:#1e3a5f; color:#fff; padding:5px 3px; text-align:center; font-weight:700; font-size:7.5px; text-transform:uppercase; letter-spacing:.3px; border:1px solid #334155; }
    .grille td { border:1px solid #e2e8f0; padding:2px; vertical-align:top; min-height:18px; }
    .heure-col { background:#f8fafc; color:#475569; font-weight:700; text-align:center; font-size:7.5px; width:38px; }
    .grille tr:nth-child(even) td { background:#fafbff; }
    .grille tr:nth-child(even) .heure-col { background:#f1f5f9; }

    /* Créneau */
    .creneau { border-radius:3px; padding:2px 4px; margin-bottom:2px; }
    .c-ppo { background:#dbeafe; border-left:3px solid #2563eb; }
    .c-apc { background:#dcfce7; border-left:3px solid #16a34a; }
    .c-titre { font-weight:700; font-size:7.5px; line-height:1.3; }
    .c-ppo .c-titre { color:#1d4ed8; }
    .c-apc .c-titre { color:#15803d; }
    .c-sub  { font-size:6.5px; color:#374151; margin-top:1px; }
    .c-time { font-size:6.5px; color:#6b7280; }

    /* Footer */
    .footer { display:table; width:100%; margin-top:12px; border-top:1.5px solid #e2e8f0; padding-top:6px; font-size:7.5px; color:#9ca3af; }
    .footer-right { display:table-cell; text-align:right; vertical-align:bottom; width:100%; }
    .footer-right .sig-line { border-top:1px solid #374151; width:150px; margin:16px 0 3px auto; }
</style>
</head>
<body>
<div class="page">

    {{-- EN-TÊTE --}}
    <div class="entete">
        <div class="entete-titre">
            <h1>EMPLOI DU TEMPS</h1>
            <h2>{{ $etablissement->nom }}</h2>
            <div class="periode">
                @if($emploiDuTemps->type_planning === 'hebdomadaire')
                    Semaine {{ $emploiDuTemps->semaine }} — Année {{ $annee->annee1 }}/{{ $annee->annee2 }}
                @else
                    Semestre {{ $emploiDuTemps->semestre }} — Année {{ $annee->annee1 }}/{{ $annee->annee2 }}
                @endif
            </div>
            <span class="badge-type {{ $emploiDuTemps->type_planning === 'hebdomadaire' ? 'badge-hebdo' : 'badge-semest' }}">
                {{ $emploiDuTemps->type_planning === 'hebdomadaire' ? 'Planning Hebdomadaire' : 'Planning Semestriel' }}
            </span>
        </div>
        <div class="entete-meta">
            AMIE-FPT
        </div>
    </div>

    {{-- INFOS CLASSE --}}
    <div class="info-bar">
        <div class="info-cell">
            <label>Classe</label>
            <span>{{ $classe->libelle }}</span>
        </div>
        <div class="info-cell">
            <label>Modalité</label>
            <span>{{ $classe->modalite }}</span>
        </div>
        <div class="info-cell">
            <label>Type planning</label>
            <span>{{ ucfirst($emploiDuTemps->type_planning) }}</span>
        </div>
        <div class="info-cell">
            <label>Période</label>
            <span>
                @if($emploiDuTemps->type_planning === 'hebdomadaire')
                    Semaine {{ $emploiDuTemps->semaine }}
                @else
                    Semestre {{ $emploiDuTemps->semestre }}
                @endif
            </span>
        </div>
        <div class="info-cell">
            <label>Total créneaux</label>
            <span>{{ $emploiDuTemps->creneaux->count() }}</span>
        </div>
    </div>

    {{-- GRILLE HORAIRE --}}
    @php
        $heures = ['07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00'];
        $jours  = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
        $parJour = $emploiDuTemps->creneaux->groupBy('jour');
    @endphp

    <table class="grille">
        <thead>
            <tr>
                <th style="width:38px">Heure</th>
                @foreach($jours as $j)
                    <th>{{ ucfirst($j) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($heures as $h)
                <tr>
                    <td class="heure-col">{{ $h }}</td>
                    @foreach($jours as $j)
                        <td>
                            @foreach($parJour->get($j, collect()) as $cr)
                                @if(substr($cr->heure_debut,0,2) === substr($h,0,2))
                                    <div class="creneau {{ $cr->matiere_id ? 'c-ppo' : 'c-apc' }}">
                                        <div class="c-titre">{{ $cr->contenu ?: '—' }}</div>
                                        <div class="c-sub">
                                            {{ optional(optional($cr->formateur)->user)->prenom }}
                                            {{ optional(optional($cr->formateur)->user)->nom }}
                                        </div>
                                        <div class="c-time">
                                            {{ substr($cr->heure_debut,0,5) }}–{{ substr($cr->heure_fin,0,5) }}
                                            @if($cr->salle) | {{ $cr->salle }} @endif
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

    {{-- PIED DE PAGE --}}
    <div class="footer">
        <div class="footer-right">
            <div class="sig-line"></div>
            Signature &amp; Cachet
        </div>
    </div>

</div>
</body>
</html>
