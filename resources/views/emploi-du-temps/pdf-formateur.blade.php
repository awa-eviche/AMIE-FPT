<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size:10px; color:#1a1a2e; }
    .page { padding:16px 20px; }

    /* En-tête */
    .entete { display:table; width:100%; border-bottom:3px solid #0e9f6e; padding-bottom:10px; margin-bottom:12px; }
    .entete-logo { display:table-cell; width:65px; vertical-align:middle; }
    .entete-titre { display:table-cell; text-align:center; vertical-align:middle; }
    .entete-titre h1 { font-size:15px; font-weight:900; color:#0e9f6e; text-transform:uppercase; }
    .entete-titre h2 { font-size:11px; color:#374151; margin-top:3px; font-weight:700; }
    .entete-titre .periode { font-size:10px; color:#6b7280; margin-top:2px; }
    .entete-meta { display:table-cell; width:110px; text-align:right; vertical-align:middle; font-size:8px; color:#6b7280; }

    /* Info bar */
    .info-bar { display:table; width:100%; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:5px; padding:7px 12px; margin-bottom:10px; }
    .info-cell { display:table-cell; padding-right:16px; }
    .info-cell label { font-size:7.5px; font-weight:700; text-transform:uppercase; color:#15803d; letter-spacing:.4px; display:block; }
    .info-cell span  { font-size:9.5px; font-weight:700; color:#1e3a5f; }

    /* Légende */
    .legende { display:table; margin-bottom:8px; }
    .leg-item { display:table-cell; padding-right:16px; font-size:8px; color:#374151; vertical-align:middle; }
    .leg-dot { display:inline-block; width:9px; height:9px; border-radius:2px; margin-right:4px; vertical-align:middle; }
    .leg-ppo { background:#2563eb; }
    .leg-apc { background:#16a34a; }

    /* Titre de classe */
    .classe-titre { background:#1e3a5f; color:#fff; padding:5px 10px; border-radius:4px; margin-bottom:6px; margin-top:14px; font-size:10px; font-weight:800; }
    .badge-modalite { background:rgba(255,255,255,.25); border-radius:3px; padding:1px 7px; font-size:8px; margin-left:8px; }

    /* Grille */
    .grille { width:100%; border-collapse:collapse; font-size:8px; margin-bottom:6px; }
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
    .c-time { font-size:6.5px; color:#6b7280; }

    /* Footer */
    .footer { display:table; width:100%; margin-top:12px; border-top:1.5px solid #e2e8f0; padding-top:6px; font-size:7.5px; color:#9ca3af; }
    .footer-left  { display:table-cell; vertical-align:bottom; }
    .footer-right { display:table-cell; text-align:right; vertical-align:bottom; }
    .footer-right .sig-line { border-top:1px solid #374151; width:150px; margin:16px 0 3px auto; }
</style>
</head>
<body>
<div class="page">

    {{-- EN-TÊTE --}}
    <div class="entete">
        <div class="entete-logo">
            @if($etablissement->logo)
                <img src="{{ public_path('storage/' . $etablissement->logo) }}"
                     style="width:55px;height:55px;object-fit:contain">
            @else
                <div style="width:55px;height:55px;background:#0e9f6e;border-radius:7px;text-align:center;line-height:55px;color:#fff;font-weight:900;font-size:13px">
                    {{ strtoupper(substr($etablissement->sigle ?? $etablissement->nom, 0, 2)) }}
                </div>
            @endif
        </div>
        <div class="entete-titre">
            <h1>MON PLANNING</h1>
            <h2>
                {{ optional(optional($formateur)->user)->prenom }}
                {{ optional(optional($formateur)->user)->nom }}
            </h2>
            <div class="periode">
                {{ $periodeLabel }} — Année {{ $annee->annee1 }}/{{ $annee->annee2 }}
            </div>
        </div>
        <div class="entete-meta">
            {{ $etablissement->nom }}<br>
            Généré le {{ now()->format('d/m/Y') }}<br>
            AMIE-FPT
        </div>
    </div>

    {{-- INFOS --}}
    @php $totalCreneaux = $creneaux->sum(fn($d) => $d['parJour']->flatten()->count()); @endphp
    <div class="info-bar">
        <div class="info-cell">
            <label>Formateur</label>
            <span>{{ optional(optional($formateur)->user)->prenom }} {{ optional(optional($formateur)->user)->nom }}</span>
        </div>
        <div class="info-cell">
            <label>Établissement</label>
            <span>{{ $etablissement->nom }}</span>
        </div>
        <div class="info-cell">
            <label>{{ $mode === 'hebdomadaire' ? 'Semaine' : 'Semestre' }}</label>
            <span>{{ $mode === 'hebdomadaire' ? 'S'.$semaine : $semestre }}</span>
        </div>
        <div class="info-cell">
            <label>Nb classes</label>
            <span>{{ $creneaux->count() }}</span>
        </div>
        <div class="info-cell">
            <label>Total créneaux</label>
            <span>{{ $totalCreneaux }}</span>
        </div>
    </div>

    {{-- LÉGENDE --}}
    <div class="legende">
        <div class="leg-item"><span class="leg-dot leg-ppo"></span> PPO – Matière</div>
        <div class="leg-item"><span class="leg-dot leg-apc"></span> APC – Élément de compétence</div>
    </div>

    @php
        $heures = ['07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00'];
        $jours  = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
    @endphp

    {{-- GRILLE PAR CLASSE --}}
    @foreach($creneaux as $classeId => $data)
        <div class="classe-titre">
            {{ $data['classe']?->libelle ?? 'Classe inconnue' }}
            @if($data['classe']?->modalite)
                <span class="badge-modalite">{{ $data['classe']->modalite }}</span>
            @endif
            <span style="font-weight:400;font-size:8px;margin-left:10px;opacity:.8">
                {{ $data['parJour']->flatten()->count() }} créneau(x)
            </span>
        </div>

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
                                @foreach($data['parJour']->get($j, collect()) as $cr)
                                    @if(substr($cr->heure_debut,0,2) === substr($h,0,2))
                                        <div class="creneau {{ $cr->matiere_id ? 'c-ppo' : 'c-apc' }}">
                                            <div class="c-titre">{{ $cr->contenu ?: '—' }}</div>
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
    @endforeach

    {{-- PIED DE PAGE --}}
    <div class="footer">
        <div class="footer-left">{{ $etablissement->nom }} — AMIE-FPT</div>
        <div class="footer-right">
            <div class="sig-line"></div>
            Signature du formateur
        </div>
    </div>

</div>
</body>
</html>
