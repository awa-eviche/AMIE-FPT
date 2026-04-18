<?php

namespace App\Http\Controllers;
use App\Models\Competence;
use App\Models\Evalute;
use App\Models\Inscription;
use App\Models\Absence;
use App\Models\Classe;
use App\Models\Apprenant;
use App\Models\AnneeAcademique;
use App\Models\Etablissement;
use App\Models\Matiere;
use App\Models\DevoirAPC;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class InscriptionController extends Controller
{
    protected $logUserRepository;

    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
        $this->logUserRepository = $logUserRepository;
    }

    public function index()
    {
     
        $userName = auth()->user()->nom;

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            $etablissementId = auth()->user()->personnel->etablissement_id;

            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }
            $classesIds = Classe::where('etablissement_id', $etablissementId)->pluck('id');
        } else {
            $classesIds = Classe::all()->pluck('id');
        }
        $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');

        $classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $currentClasse = $classe ? Classe::find($classe) : null;
        $classes = [$currentClasse];
        $matieres = $classe ? Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get() : [];

        $apprenants = Apprenant::whereIn('id', $apprenantsIds)->get();

        return view('inscription.index', compact('apprenants', 'matieres'));
    }

   
    public function create()
    {
        $annee_academiques = AnneeAcademique::all();

        $userName = auth()->user()->nom;

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            
           
            $etablissementId = auth()->user()->personnel->etablissement_id;

            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }
            $classes = Classe::where('etablissement_id', $etablissementId)->get();

            $apprenants = Apprenant::where('etablissement_id', $etablissementId)->get();
        } else {
            $classes = Classe::all();
            $classesIds = Classe::all()->pluck('id');
            $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');
            $apprenants = Apprenant::whereIn('apprenant_id', $apprenantsIds)->get();
        }

        return view('inscription.create', compact('classes', 'apprenants','annee_academiques'));
    }

    
    public function store(Request $request)
    {
        $request->validate([

            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',
            'annee_academique_id' => 'required|exists:annee_academiques,id',

        ]);


        $inscription = Inscription::create($request->all());
        $this->createUserForInscription($inscription);
        $this->logUserRepository->store(['action' => UserAction::AddInscription, 'model' => Model::Inscription, 'new_object' => json_encode($inscription)]);


        return redirect()->route('inscription.index')

            ->withMessage('Inscription créé avec succès.');
    }

   
     public function show(Inscription $inscription)
    {
        $classeId = session('currentClasse');
        $currentClasse = $classeId ? Classe::find($classeId) : null;
        $matieres = collect();
        $competences = collect();
        $apprenants = $classeId ? Inscription::where('classe_id', $classeId)->get() : collect();
    
        if ($currentClasse && $currentClasse->niveau_etude) {
            if ($currentClasse->modalite === 'PPO') {
                $matieres = Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get();
            } elseif ($currentClasse->modalite === 'APC') {
                $competences = Competence::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get();
            }
        }
    
        return view('inscription.show', [
            "inscription" => $inscription,
            "apprenants" => $apprenants,
            "classe" => $classeId,
            'matieres' => $matieres,
            'competences' => $competences,
            'currentClasse' => $currentClasse,
        ]);
    }
    
private function createUserForInscription($inscription)
{
    $exists = User::where('inscription_id', $inscription->id)->exists();

    if ($exists) {
        return;
    }

    // 🔥 CORRECTION ICI
    $apprenant = \App\Models\Apprenant::find($inscription->apprenant_id);

    if (!$apprenant) {
        return; // sécurité
    }

    User::create([
        'email' => $apprenant->matricule . '@amie-fpt.local',
        'prenom' => $apprenant->prenom,
        'nom' => $apprenant->nom,
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'inscription_id' => $inscription->id,
        'role_id' => 31,
    ]);
}
   
    public function edit(Inscription $inscription)
    {

        $classes = Classe::all();
        $apprenants = Apprenant::all();
        return view('inscription.edit', compact('inscription', 'classes', 'apprenants'));
    }


    public function update(Request $request, Inscription $inscription)
    {
        $request->validate([
            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',

        ]);

        $inscription->update($request->all());

        return redirect()->route('inscription.index')
            ->withMessage('Inscription mise à jour avec succès.');
    }

    public function destroy(Inscription $inscription)
    {

        $this->logUserRepository->store([
            'action' => UserAction::DeleteInscription, 'model' => Model::Inscription,
            'old_object' => json_encode($inscription)
        ]);
        $inscription->delete();

        return redirect()->route('inscription.index')
            ->withMessage('Inscription supprimé avec succès.');
    }

 function generateCompetenceClassePdf(string $id)
    {
        $inscriptions = Inscription::where('classe_id', $id)->get();
        $totalCompetence = Competence::where('niveau_etude_id', $inscriptions[0]->classe->niveau_etude_id)->get()->count();

        $legendes = [];
        array_push($legendes, '<li><span class="bold-exo">A</span> : Acquis</li>');
        array_push($legendes, '<li><span class="bold-exo">NA</span> : Non Acquis</li>');

        //Initialiser les compteurs et le output
        $cleCritere = 0;
        $ecKey = 0;
        $cptKey = 0;
        $start = 0;
        $end = 3;
        $body = '';
        $enteteKey = 0;

        while ($totalCompetence > $start) {
            $competences = Competence::where('niveau_etude_id', $inscriptions[0]->classe->niveau_etude_id)->offset($start)->limit($end)->get();

            $criteres = [];
            $rowspans = [];
            $labelsCompetences = '';
            foreach ($competences as $keyRow => $competence) {
                $labelsCompetences .= 'C' . ($enteteKey + 1);
                if ((sizeof($competences) - 1) > $keyRow) {
                    $labelsCompetences .= ' - ';
                }

                $rowspan = 0;
                foreach ($competence->elementCompetences as $ec) {
                    $rowspan += sizeof($ec->criteres);
                    $criteres = [...$criteres, ...$ec->criteres->toArray()];
                }
                $rowspans[$keyRow] = $rowspan;
                $enteteKey++;
            }

            $body .= '
            <p class="c-dispay">Compétences : ' . $labelsCompetences . '</p>
            <table class="full-table mb-1" style="margin-top: 1rem;font-size:80%" cellspacing="0">
            <tr style="page-break-before: avoid;">
                <td rowspan="3" align="center" class="border-td">Apprenants</td>';

            //Afficher la ligne des compétences
            foreach ($competences as $cptCompetence => $competence) {
                $body .= '
                        <td align="center" colspan="' . $rowspans[$cptCompetence] . '" class="border-td">C' . ($cptKey + 1) . '</td>
                ';
                array_push($legendes, '<li><span class="bold-exo">C' . ($cptKey + 1) . '</span> : ' . $competence->nom . '</li>');
                $cptKey++;
            }
            $body .= '
            </tr>
            ';

            $body .= '
            <tr style="page-break-before: avoid;">
            ';

            foreach ($competences as $key => $competence) {
                foreach ($competence->elementCompetences as $ec) {
                    $body .= '<td align="center" colspan="' . sizeof($ec->criteres) . '" class="border-td">EC' . ($ecKey + 1) . '</td>';
                    array_push($legendes, '<li><span class="bold-exo">EC' . ($ecKey + 1) . '</span> : ' . $ec->nom . '</li>');
                    $ecKey++;
                }

            }
            $body .= '
            </tr>
            ';

            $body .= '
            <tr style="page-break-before: avoid;">
            ';
            foreach ($competences as $key => $competence) {
                foreach ($competence->elementCompetences as $ec) {
                    foreach ($ec->criteres as $critereKey => $critere) {
                        $body .= '<td class="border-td">CRI' . ($cleCritere + 1) . '</td>';
                        array_push($legendes, '<li><span class="bold-exo">CRI' . ($cleCritere + 1) . '</span> : ' . $critere->libelle . '</li>');
                        $cleCritere++;
                    }
                }
            }
            $body .= '
            </tr>
            ';

            foreach ($inscriptions as $cleInscription => $inscription) {
                $rowspanCount = 0;
                $output = '';
                $evaluations = Evalute::where('inscription_id', $inscription->id)->get()->keyBy('id')->toArray();

                $body .= '
                <tr>
                    <td class="border-td">' . $inscription->apprenant->user->nom . ' ' . $inscription->apprenant->user->prenom . '</td>
                ';
                foreach ($competences as $key => $competence) {
                    foreach ($competence->elementCompetences as $ec) {
                        foreach ($ec->criteres as $critereKey => $critere) {
                            $findRow = null;
                            foreach ($evaluations as $evaluation) {
                                if ($evaluation['inscription_id'] == $inscription->id && $evaluation['critere_id'] == $critere->id) {
                                    $findRow = $evaluation;
                                    break;
                                }
                            }
                            if ($findRow) {
                                if ($findRow['acquis'])
                                    $body .= '<td class="border-td" align="center">A</td>';
                                elseif ($findRow['nonAcquis'])
                                    $body .= '<td class="border-td" align="center">NA</td>';
                            } else {
                                $body .= '<td class="border-td"></td>';
                            }
                        }
                    }
                }
                $body .= '
                </tr>
                ';
            }

            $body .= '
            </table>
            ';

            $start += 3;
        }

        $legende = '
        <div class="main-legend break" >
            <p align="center" class="bold-exo font-md">Légende</p><hr>
            <div class="legend-col" >
                <ul class="legende">';
        //Determiner la moyenne par colonne
        $limitBreak = intdiv(sizeof($legendes), 3);
        foreach ($legendes as $cleLegend => $legend) {
            $legende .= $legend;

            // Faire vérification pour passer à la deuxième colonne si nécessaire
            if ($cleLegend == ($limitBreak - 1)) {
                $legende .= '
                </ul>
                </div>
                <div class="legend-col">
                <ul class="legende">
                ';
            }

            // Faire vérification pour passer à la troisième colonne si nécessaire
            if ($cleLegend == ((2 * $limitBreak) - 1)) {
                $legende .= '
                </ul>
                </div>
                <div class="legend-col">
                <ul class="legende">
                ';
            }
        }
        $legende .= '</ul>
        </div><hr>';

        $entete = "Classe : " . $inscriptions[0]->classe->libelle .
            "<br><span>Niveau d'étude : " . $inscriptions[0]->classe->niveau_etude->libelle . "</span>
        <br><span>Métier : " . $inscriptions[0]->classe->niveau_etude->metier->libelle . "</span>
        <br><span>Année académique : " . $inscriptions[0]->classe->annee_academique->annee1 . " - " . $inscriptions[0]->classe->annee_academique->annee2 . "</span>";
        $template = file_get_contents('classe_competence.html');
        $template = str_replace('[BODY]', $body, $template);
        $template = str_replace('[LEGENDE]', $legende, $template);
        $template = str_replace('[DATE]', date('d/m/Y'), $template);
        $template = str_replace('[USER]', $entete, $template);
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->setFontCache(storage_path('fonts'));
        $options->set('isRemoteEnabled', true);
        $options->set('pdfBackend', 'CPDF');
        $options->setChroot([
            '/',
            storage_path('fonts'),
        ]);

        $dompdf->loadHTML($template);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $nom = 'Carnet_de_competence_classe.pdf';
        $dompdf->stream($nom, array("Attachment" => false));

    }


public function generateCompetencePdf(string $id)
{
 $semestre = session()->get('selectedsemestre1');
$semestreInt = $semestre ? (int) $semestre : null;

    $inscription = Inscription::with([
        'apprenant',
        'classe.niveau_etude',
        'classe.etablissement',
        'anneeAcademique',
    ])->findOrFail($id);

    $classeId = (int) $inscription->classe_id;
    $niveauId = (int) $inscription->classe->niveau_etude_id;

  

    $competencesGenerales = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->whereHas('ressources', function ($q) use ($classeId) {
            $q->where('classe_id', $classeId)
              ->whereNotNull('formateur_id'); // ✅ filtre ajouté
        })
        ->with(['ressources' => function ($q) use ($classeId) {
            $q->where('classe_id', $classeId)
              ->whereNotNull('formateur_id'); // ✅ filtre ajouté
        }])
        ->orderBy('nom')
        ->get();

    $competencesGenerales = $competencesGenerales
        ->groupBy('nom')
        ->map(function ($group) {
            $first = $group->first();
            $first->ressources = $group
                ->flatMap(fn($c) => $c->ressources)
                ->unique('id')
                ->values();
            return $first;
        })
        ->values();

  

    $competencesParticulieres = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'particuliere')
        ->whereHas('ressources', function ($q) use ($classeId) {
            $q->where('classe_id', $classeId)
              ->whereNotNull('formateur_id'); // ✅ filtre ajouté
        })
        ->with(['ressources' => function ($q) use ($classeId) {
            $q->where('classe_id', $classeId)
              ->whereNotNull('formateur_id'); // ✅ filtre ajouté
        }])
        ->orderBy('nom')
        ->get();

    $competencesParticulieres = $competencesParticulieres
        ->groupBy('nom')
        ->map(function ($group) {
            $first = $group->first();
            $first->ressources = $group
                ->flatMap(fn($c) => $c->ressources)
                ->unique('id')
                ->values();
            return $first;
        })
        ->values();


    // ✅ Toutes les ressources concernées (déjà filtrées par classe)
    $ressourceIds = $competencesGenerales
        ->merge($competencesParticulieres)
        ->flatMap(fn ($c) => ($c->ressources ?? collect())->pluck('id'))
        ->filter()
        ->unique()
        ->values()
        ->all();

    // ✅ Évaluations (intégration = composition) depuis evalutes (APC uniquement)
    $evalQuery = Evalute::query()
        ->where('inscription_id', (int) $inscription->id)
        ->whereIn('ressource_id', $ressourceIds);

    if ($semestreInt) {
        $evalQuery->where('semestre', $semestreInt);
    }

    $evalByRessource = $evalQuery
        ->get(['ressource_id', 'composition'])
        ->keyBy('ressource_id');

    // ✅ MCC = AVG(note) depuis DevoirAPC
    $mccQuery = DevoirAPC::query()
        ->where('inscription_id', (int) $inscription->id)
        ->whereIn('ressource_id', $ressourceIds)
        ->whereNotNull('note');

    if ($semestreInt) {
        $mccQuery->where('semestre', $semestreInt);
    }

    $mccRows = $mccQuery
        ->selectRaw('ressource_id, ROUND(AVG(note),2) as mcc')
        ->groupBy('ressource_id')
        ->get();

    $mccByRessource = [];
    foreach ($mccRows as $r) {
        $mccByRessource[(int) $r->ressource_id] = (float) $r->mcc;
    }

    // ✅ helper appréciation
    $obsFromNote = function ($note) {
        if (!is_numeric($note)) return '-';
        $note = (float) $note;
        if ($note < 10) return 'Insuffisant';
        if ($note < 12) return 'Passable';
        if ($note < 14) return 'Assez bien';
        if ($note < 16) return 'Bien';
        return 'Très bien';
    };

  
    $htmlGenerales = '';

    foreach ($competencesGenerales as $comp) {
        $ressources = ($comp->ressources ?? collect())->unique('id')->values();

        if ($ressources->isEmpty()) {
            $htmlGenerales .= "
            <tr>
                <td class='border-td bold-exo wrap' style='width:28%'>".htmlspecialchars($comp->nom, ENT_QUOTES, 'UTF-8')."</td>
                <td class='border-td wrap' style='width:32%'>Aucune discipline</td>
                <td class='border-td num' style='width:10%'>-</td>
                <td class='border-td num' style='width:12%'>-</td>
                <td class='border-td wrap' style='width:18%'>-</td>
            </tr>";
            continue;
        }

        $first = true;
        $rowspan = $ressources->count();

        foreach ($ressources as $res) {
            $mcc = $mccByRessource[$res->id] ?? null;

            $eval = $evalByRessource[$res->id] ?? null;
            $integrationRaw = $eval?->composition; // peut être null

            // ✅ règle générale : si pas d’intégration => MCC devient intégration
            $integrationEffective = ($integrationRaw === null || $integrationRaw === '')
                ? $mcc
                : (float) $integrationRaw;

            $app = $obsFromNote($integrationEffective);

            $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
            $intTxt = is_numeric($integrationEffective) ? number_format((float)$integrationEffective, 2) : '-';

            $htmlGenerales .= "<tr>";

            // ✅ MODIF ICI : correction du HTML cassé (guillemet manquant) -> sinon la colonne "Compétence" disparaît
            if ($first) {
                $htmlGenerales .= "
                <td rowspan='{$rowspan}' class='border-td bold-exo wrap' style='width:28%'>
                    ".htmlspecialchars($comp->nom, ENT_QUOTES, 'UTF-8')."
                </td>";
                $first = false;
            }

            $htmlGenerales .= "
                <td class='border-td wrap' style='width:32%'>".htmlspecialchars($res->nom, ENT_QUOTES, 'UTF-8')."</td>
                <td class='border-td num' style='width:10%'>{$mccTxt}</td>
                <td class='border-td num' style='width:12%'>{$intTxt}</td>
                <td class='border-td wrap' style='width:18%'>{$app}</td>
            </tr>";
        }
    }

    if (trim($htmlGenerales) === '') {
        $htmlGenerales = "
        <tr>
            <td colspan='5' class='border-td' align='center'>Aucune compétence générale</td>
        </tr>";
    }

   
    $htmlParticulieres = '';

    foreach ($competencesParticulieres as $comp) {
        $ressources = ($comp->ressources ?? collect())->unique('id')->values();

        if ($ressources->isEmpty()) {
            $htmlParticulieres .= "
            <tr>
                <td class='border-td bold-exo wrap' style='width:28%'>".htmlspecialchars($comp->nom, ENT_QUOTES, 'UTF-8')."</td>
                <td class='border-td wrap' style='width:32%'>Aucune discipline</td>
                <td class='border-td num' style='width:10%'>-</td>
                <td class='border-td num' style='width:12%'>-</td>
                <td class='border-td wrap' style='width:18%'>-</td>
            </tr>";
            continue;
        }

        $first = true;
        $rowspan = $ressources->count();

        foreach ($ressources as $res) {
            $mcc = $mccByRessource[$res->id] ?? null;

            $eval = $evalByRessource[$res->id] ?? null;
            $integration = $eval?->composition; // ici on affiche tel quel (si vide => '-')

            $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
            $intTxt = is_numeric($integration) ? number_format((float)$integration, 2) : '-';

            $app = is_numeric($integration) ? $obsFromNote((float)$integration) : '-';

            $htmlParticulieres .= "<tr>";

            if ($first) {
                $htmlParticulieres .= "
                <td rowspan='{$rowspan}' class='border-td bold-exo wrap' style='width:28%'>
                    ".htmlspecialchars($comp->nom, ENT_QUOTES, 'UTF-8')."
                </td>";
                $first = false;
            }

            $htmlParticulieres .= "
                <td class='border-td wrap' style='width:32%'>".htmlspecialchars($res->nom, ENT_QUOTES, 'UTF-8')."</td>
                <td class='border-td num' style='width:10%'>{$mccTxt}</td>
                <td class='border-td num' style='width:12%'>{$intTxt}</td>
                <td class='border-td wrap' style='width:18%'>{$app}</td>
            </tr>";
        }
    }

    if (trim($htmlParticulieres) === '') {
        $htmlParticulieres = "
        <tr>
            <td colspan='5' class='border-td' align='center'>Aucune compétence particulière</td>
        </tr>";
    }

    $absencesSemestre = Absence::where('inscription_id', (int) $inscription->id)
        ->when($semestreInt, fn($q) => $q->where('semestre', (int) $semestreInt))
        ->get();

    $hAbsJust = (float) $absencesSemestre->where('type','absence')->where('justifie', 1)->sum('nombre_heure_absence');

    $hAbsNon = (float) $absencesSemestre->where('type','absence')
        ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
        ->sum('nombre_heure_absence');

    $hRetJust = (float) $absencesSemestre->where('type','retard')->where('justifie', 1)->sum('nombre_heure_retard');

    $hRetNon = (float) $absencesSemestre->where('type','retard')
        ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
        ->sum('nombre_heure_retard');

    $hAbsTotal = $hAbsJust + $hAbsNon;
    $hRetTotal = $hRetJust + $hRetNon;

    // ✅ Template (chemin robuste)
    $templatePath = public_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = base_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = resource_path('views/competence.html');

    $template = file_get_contents($templatePath);

    // ✅ Inject CSS anti-débordement (Dompdf friendly)
    $antiOverflowCss = "
        .full-table{ width:100%; border-collapse:collapse; table-layout:fixed; }
        .border-td{ border:1px solid #000; padding:.25em; font-size:11px; vertical-align:top; white-space:normal; }
        .wrap{ word-wrap:break-word; overflow-wrap:break-word; }
        .num{ text-align:center; white-space:nowrap; }
    ";
    $template = str_replace('</style>', $antiOverflowCss . "\n</style>", $template);

    // Logo
    $logoPath = public_path('assets/images/titleHead.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }
    $template = str_replace('[LOGO]', $logoBase64, $template);

    // ✅ Blocs
    $template = str_replace('[BODYRESSOURCE]', $htmlGenerales, $template);
    $template = str_replace('[BODYCOMP]', $htmlParticulieres, $template);

    $fmt = fn($n) => rtrim(rtrim(number_format((float)$n, 2, '.', ''), '0'), '.');
    $template = str_replace('[NB_ABSENCES]', $fmt($hAbsTotal), $template);
    $template = str_replace('[NB_RETARDS]',  $fmt($hRetTotal), $template);

   
       
       $dateNow = \Carbon\Carbon::now()->format('d/m/Y');

    $anneeScolaire = $inscription->anneeAcademique->code
        ?? ($inscription->classe->annee_academique->code ?? '');

    $replace = [
        '[DATE]' => $dateNow,
        '[USER]' => $inscription->apprenant->nom . ' ' . $inscription->apprenant->prenom,
        '[DATENAISSANCE]' => $inscription->apprenant->date_naissance,
        '[LIEUNAISSANCE]' => $inscription->apprenant->lieu_naissance,
        '[TEL]' => $inscription->apprenant->telephone,
        '[EMAIL]' => $inscription->apprenant->email,
        '[SEMESTRE]' => $semestreInt ?: 'Tous',
        '[MATRICULE]' => $inscription->apprenant->matricule,
        '[CLASSE]' => $inscription->classe->libelle,
        '[ANNEE]' => $inscription->classe->niveau_etude->nom,
        '[ANNEESCOLAIRE]' => $anneeScolaire,
        '[EFPT]' => $inscription->classe->etablissement->nom,
        '[EFPTTEL]' => $inscription->classe->etablissement->telephone,
        '[EFPTMAIL]' => $inscription->classe->etablissement->email,
    ];

    $template = str_replace(array_keys($replace), array_values($replace), $template);

    // ✅ Dompdf
    $dompdf = new Dompdf();
    $dompdf->getOptions()->set('isRemoteEnabled', true);
    $dompdf->loadHtml($template);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Carnet_de_Competence.pdf"');
}


public function generateClassePdf(string $classe_id)
{
  $semestre = session()->get('selectedsemestre1');
 
    $semestreInt = $semestre ? (int) $semestre : null;

    $classe = Classe::with([
        'niveau_etude',
        'etablissement',
        'inscriptions.apprenant',
        'annee_academique',
    ])->findOrFail($classe_id);

    $niveauId = (int) $classe->niveau_etude_id;
    $classeId = (int) $classe->id;
    $competencesGenerales = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->whereHas('ressources', function ($q) use ($classeId) {
            $q->where(function ($query) use ($classeId) {
                $query->where('classe_id', $classeId)
                      ->orWhereNull('classe_id');
            })
            ->whereNotNull('formateur_id');
        })
        ->with('ressources')
        ->orderBy('nom')
        ->get();
    $competencesParticulieres = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'particuliere')
        ->whereHas('ressources', function ($q) use ($classeId) {
            $q->where(function ($query) use ($classeId) {
                $query->where('classe_id', $classeId)
                      ->orWhereNull('classe_id');
            })
            ->whereNotNull('formateur_id');
        })
        ->with('ressources')
        ->orderBy('nom')
        ->get();

   

    $filterRessourcesByClasse = function ($competences) use ($classeId) {
        foreach ($competences as $comp) {

            $ressources = collect($comp->ressources ?? []);

            $filtered = $ressources
                ->filter(function ($res) use ($classeId) {

                    $direct = (int) ($res->classe_id ?? 0);
                    $pivot  = (int) ($res->pivot->classe_id ?? 0);

                    return (
                        ($direct === $classeId || $pivot === $classeId)
                        && !is_null($res->formateur_id)
                    );
                })
                ->unique('id')
                ->values();

            $comp->setRelation('ressources', $filtered);
        }

        return $competences;
    };

    $competencesGenerales = $filterRessourcesByClasse($competencesGenerales);
    $competencesParticulieres = $filterRessourcesByClasse($competencesParticulieres);

    /*
    =========================================================
    RESTE DE LA LOGIQUE IDENTIQUE
    =========================================================
    */

    $ressourceIds = $competencesGenerales
        ->merge($competencesParticulieres)
        ->flatMap(fn ($c) => ($c->ressources ?? collect())->pluck('id'))
        ->filter()
        ->unique()
        ->values()
        ->all();

    $inscriptionIds = $classe->inscriptions->pluck('id')->filter()->values()->all();

    // helper appréciation
    $obsFromNote = function ($note) {
        if (!is_numeric($note)) return '-';
        $note = (float) $note;
        if ($note < 10) return 'Insuffisant';
        if ($note < 12) return 'Passable';
        if ($note < 14) return 'Assez bien';
        if ($note < 16) return 'Bien';
        return 'Très bien';
    };

    // ✅ Précharger intégrations (Evalute.composition)
    $evalMap = []; // [inscription_id][ressource_id] => composition
    if (!empty($inscriptionIds) && !empty($ressourceIds)) {
        $evalQuery = Evalute::query()
            ->whereIn('inscription_id', $inscriptionIds)
            ->whereIn('ressource_id', $ressourceIds);

        if ($semestreInt) {
            $evalQuery->where('semestre', $semestreInt);
        }

        $evalRows = $evalQuery->get(['inscription_id', 'ressource_id', 'composition']);
        foreach ($evalRows as $e) {
            $evalMap[(int)$e->inscription_id][(int)$e->ressource_id] = $e->composition;
        }
    }

    // ✅ Précharger MCC (AVG(note)) depuis DevoirAPC
    $mccMap = []; // [inscription_id][ressource_id] => mcc
    if (!empty($inscriptionIds) && !empty($ressourceIds)) {
        $mccQuery = DevoirAPC::query()
            ->whereIn('inscription_id', $inscriptionIds)
            ->whereIn('ressource_id', $ressourceIds)
            ->whereNotNull('note');

        if ($semestreInt) {
            $mccQuery->where('semestre', $semestreInt);
        }

        $mccRows = $mccQuery
            ->selectRaw('inscription_id, ressource_id, ROUND(AVG(note),2) as mcc')
            ->groupBy('inscription_id', 'ressource_id')
            ->get();

        foreach ($mccRows as $r) {
            $mccMap[(int)$r->inscription_id][(int)$r->ressource_id] = (float)$r->mcc;
        }
    }

    // ✅ Charger template
    $templatePath = public_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = base_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = resource_path('views/competence.html');

    $templateRaw = file_get_contents($templatePath);

    // ✅ Inject CSS anti-débordement dompdf
    $antiOverflowCss = "
        .full-table{ width:100%; border-collapse:collapse; table-layout:fixed; }
        .border-td{ border:1px solid #000; padding:.25em; font-size:11px; vertical-align:top; white-space:normal; }
        .wrap{ word-wrap:break-word; overflow-wrap:break-word; }
        .num{ text-align:center; white-space:nowrap; }
    ";
    $templateRaw = str_replace('</style>', $antiOverflowCss . "\n</style>", $templateRaw);

    // ✅ Logo (base64)
    $logoPath = public_path('assets/images/titleHead.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }
    $templateRaw = str_replace('[LOGO]', $logoBase64, $templateRaw);

    // ✅ format heures
    $fmt = fn($n) => rtrim(rtrim(number_format((float)$n, 2, '.', ''), '0'), '.');

    // ✅ Génération bulletins
    $bulletins = '';

    foreach ($classe->inscriptions as $inscription) {

        $inscId = (int) $inscription->id;

        // ----------- GÉNÉRALES -----------
        $htmlGenerales = '';

        foreach ($competencesGenerales as $comp) {
            $ressources = ($comp->ressources ?? collect())->unique('id')->values();

            if ($ressources->isEmpty()) {
                $htmlGenerales .= "
                <tr>
                    <td class='border-td bold-exo wrap' style='width:28%'>".htmlspecialchars($comp->nom, ENT_QUOTES, 'UTF-8')."</td>
                    <td class='border-td wrap' style='width:32%'>Aucune discipline</td>
                    <td class='border-td num' style='width:10%'>-</td>
                    <td class='border-td num' style='width:12%'>-</td>
                    <td class='border-td wrap' style='width:18%'>-</td>
                </tr>";
                continue;
            }

            $rowspan = $ressources->count();
            $first = true;

            foreach ($ressources as $res) {
                $resId = (int) $res->id;

                $mcc = $mccMap[$inscId][$resId] ?? null;
                $compositionRaw = $evalMap[$inscId][$resId] ?? null;

                // ✅ règle générale : si pas d’intégration => MCC
                $integrationEffective = ($compositionRaw === null || $compositionRaw === '')
                    ? $mcc
                    : (float) $compositionRaw;

                $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
                $intTxt = is_numeric($integrationEffective) ? number_format((float)$integrationEffective, 2) : '-';
                $app    = $obsFromNote($integrationEffective);

                $htmlGenerales .= "<tr>";

                if ($first) {
                    $htmlGenerales .= "
                        <td rowspan='{$rowspan}' class='border-td bold-exo wrap' style='width:28%'>
                            ".htmlspecialchars($comp->nom, ENT_QUOTES, 'UTF-8')."
                        </td>";
                    $first = false;
                }

                $htmlGenerales .= "
                    <td class='border-td wrap' style='width:32%'>".htmlspecialchars($res->nom, ENT_QUOTES, 'UTF-8')."</td>
                    <td class='border-td num' style='width:10%'>{$mccTxt}</td>
                    <td class='border-td num' style='width:12%'>{$intTxt}</td>
                    <td class='border-td wrap' style='width:18%'>{$app}</td>
                </tr>";
            }
        }

        if (trim($htmlGenerales) === '') {
            $htmlGenerales = "
            <tr>
                <td colspan='5' class='border-td' align='center'>Aucune compétence générale</td>
            </tr>";
        }

        // ----------- PARTICULIÈRES -----------
        $htmlParticulieres = '';

        foreach ($competencesParticulieres as $comp) {
            $ressources = ($comp->ressources ?? collect())->unique('id')->values();

            if ($ressources->isEmpty()) {
                $htmlParticulieres .= "
                <tr>
                    <td class='border-td bold-exo wrap' style='width:28%'>".htmlspecialchars($comp->nom, ENT_QUOTES, 'UTF-8')."</td>
                    <td class='border-td wrap' style='width:32%'>Aucune discipline</td>
                    <td class='border-td num' style='width:10%'>-</td>
                    <td class='border-td num' style='width:12%'>-</td>
                    <td class='border-td wrap' style='width:18%'>-</td>
                </tr>";
                continue;
            }

            $rowspan = $ressources->count();
            $first = true;

            foreach ($ressources as $res) {
                $resId = (int) $res->id;

                $mcc = $mccMap[$inscId][$resId] ?? null;
                $integration = $evalMap[$inscId][$resId] ?? null; 

                $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
                $intTxt = is_numeric($integration) ? number_format((float)$integration, 2) : '-';
                $app    = is_numeric($integration) ? $obsFromNote((float)$integration) : '-';

                $htmlParticulieres .= "<tr>";

                if ($first) {
                    $htmlParticulieres .= "
                        <td rowspan='{$rowspan}' class='border-td bold-exo wrap' style='width:28%'>
                            ".htmlspecialchars($comp->nom, ENT_QUOTES, 'UTF-8')."
                        </td>";
                    $first = false;
                }

                $htmlParticulieres .= "
                    <td class='border-td wrap' style='width:32%'>".htmlspecialchars($res->nom, ENT_QUOTES, 'UTF-8')."</td>
                    <td class='border-td num' style='width:10%'>{$mccTxt}</td>
                    <td class='border-td num' style='width:12%'>{$intTxt}</td>
                    <td class='border-td wrap' style='width:18%'>{$app}</td>
                </tr>";
            }
        }

        if (trim($htmlParticulieres) === '') {
            $htmlParticulieres = "
            <tr>
                <td colspan='5' class='border-td' align='center'>Aucune compétence particulière</td>
            </tr>";
        }
        $absencesSemestre = Absence::where('inscription_id', (int) $inscription->id)
            ->when($semestreInt, fn($q) => $q->where('semestre', (int) $semestreInt))
            ->get();

        $hAbsJust = (float) $absencesSemestre->where('type','absence')->where('justifie', 1)->sum('nombre_heure_absence');

        $hAbsNon = (float) $absencesSemestre->where('type','absence')
            ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
            ->sum('nombre_heure_absence');

        $hRetJust = (float) $absencesSemestre->where('type','retard')->where('justifie', 1)->sum('nombre_heure_retard');

        $hRetNon = (float) $absencesSemestre->where('type','retard')
            ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
            ->sum('nombre_heure_retard');

        $hAbsTotal = $hAbsJust + $hAbsNon;
        $hRetTotal = $hRetJust + $hRetNon;

        // ✅ Date FR
        // setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');
        
       $dateNow = \Carbon\Carbon::now()->format('d/m/Y');


        $anneeScolaire = $inscription->anneeAcademique->code
            ?? ($classe->annee_academique->code ?? '');
        $page = $templateRaw;
        $page = str_replace('[BODYRESSOURCE]', $htmlGenerales, $page);
        $page = str_replace('[BODYCOMP]', $htmlParticulieres, $page);

        $page = str_replace('[NB_ABSENCES]', $fmt($hAbsTotal), $page);
        $page = str_replace('[NB_RETARDS]',  $fmt($hRetTotal), $page);

        $replace = [
            '[DATE]' => $dateNow,
            '[USER]' => ($inscription->apprenant->nom ?? '') . ' ' . ($inscription->apprenant->prenom ?? ''),
            '[DATENAISSANCE]' => $inscription->apprenant->date_naissance ?? '',
            '[LIEUNAISSANCE]' => $inscription->apprenant->lieu_naissance ?? '',
            '[TEL]' => $inscription->apprenant->telephone ?? '',
            '[EMAIL]' => $inscription->apprenant->email ?? '',
            '[SEMESTRE]' => $semestreInt ?: 'Tous',
            '[MATRICULE]' => $inscription->apprenant->matricule ?? '',
            '[CLASSE]' => $classe->libelle ?? '',
            '[ANNEE]' => $classe->niveau_etude->nom ?? '',
            '[ANNEESCOLAIRE]' => $anneeScolaire,
            '[EFPT]' => $classe->etablissement->nom ?? '',
            '[EFPTTEL]' => $classe->etablissement->telephone ?? '',
            '[EFPTMAIL]' => $classe->etablissement->email ?? '',
        ];

        $page = str_replace(array_keys($replace), array_values($replace), $page);

        $bulletins .= $page . '<div style="page-break-after: always;"></div>';
    }
    $dompdf = new Dompdf();
    $dompdf->getOptions()->set('isRemoteEnabled', true);
    $dompdf->loadHtml($bulletins);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Carnets_Classe_'.$classe->libelle.'.pdf"');
}


public function suspendre($id)
{
    $inscription = Inscription::findOrFail($id);
    $nouveauStatut = $inscription->statut === 'suspendu' ? 'active' : 'suspendu';
    $inscription->update(['statut' => $nouveauStatut]);

    // Journaliser l’action
    $this->logUserRepository->store([
        'action' => UserAction::UpdateInscription,
        'model' => Model::Inscription,
        'old_object' => json_encode(['ancien_statut' => $inscription->statut]),
        'new_object' => json_encode(['nouveau_statut' => $nouveauStatut]),
    ]);

    return redirect()->back()->withMessage("L'inscription a été mise à jour : statut = {$nouveauStatut}");
}


public function abandonner($id)
{
    $inscription = Inscription::findOrFail($id);

    // 🔁 Changement de statut
    $nouveauStatut = $inscription->statut === 'abandonne' ? 'actif' : 'abandonne';
    $inscription->update(['statut' => $nouveauStatut]);

    // 🧾 Journalisation
    $this->logUserRepository->store([
        'action' => UserAction::UpdateInscription,
        'model' => Model::Inscription,
        'old_object' => json_encode(['ancien_statut' => $inscription->statut]),
        'new_object' => json_encode(['nouveau_statut' => $nouveauStatut]),
    ]);

    // ✅ Message de retour
    $message = $nouveauStatut === 'abandonne'
        ? "L'apprenant a été marqué comme ayant abandonné."
        : "L'apprenant a été réactivé avec succès.";

    return redirect()->back()->withMessage($message);
}

public function mesNotesAPC($inscriptionId)
{
    $inscription = \App\Models\Inscription::with([
        'apprenant',
        'classe.etablissement',
        'classe.niveau_etude',
        'anneeAcademique'
    ])->findOrFail($inscriptionId);

    $classeId = (int) $inscription->classe_id;
    $niveauId = (int) $inscription->classe->niveau_etude_id;

    // Compétences générales — même logique que generateCompetencePdf
    $competencesGenerales = \App\Models\Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->whereHas('ressources', function ($q) use ($classeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id');
        })
        ->with(['ressources' => function ($q) use ($classeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id');
        }])
        ->orderBy('nom')
        ->get()
        ->groupBy('nom')
        ->map(function ($group) {
            $first = $group->first();
            $first->ressources = $group->flatMap(fn($c) => $c->ressources)->unique('id')->values();
            return $first;
        })
        ->values();

    // Compétences particulières
    $competencesParticulieres = \App\Models\Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'particuliere')
        ->whereHas('ressources', function ($q) use ($classeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id');
        })
        ->with(['ressources' => function ($q) use ($classeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id');
        }])
        ->orderBy('nom')
        ->get()
        ->groupBy('nom')
        ->map(function ($group) {
            $first = $group->first();
            $first->ressources = $group->flatMap(fn($c) => $c->ressources)->unique('id')->values();
            return $first;
        })
        ->values();

    // Toutes les ressources
    $ressourceIds = $competencesGenerales
        ->merge($competencesParticulieres)
        ->flatMap(fn($c) => ($c->ressources ?? collect())->pluck('id'))
        ->filter()->unique()->values()->all();

    // MCC depuis DevoirAPC
    $mccByRessource = \App\Models\DevoirAPC::query()
        ->where('inscription_id', $inscriptionId)
        ->whereIn('ressource_id', $ressourceIds)
        ->whereNotNull('note')
        ->selectRaw('ressource_id, semestre, ROUND(AVG(note),2) as mcc')
        ->groupBy('ressource_id', 'semestre')
        ->get()
        ->groupBy('semestre')
        ->map(fn($rows) => $rows->keyBy('ressource_id'));

    // Intégrations (composition) depuis Evalute
    $evalByRessource = \App\Models\Evalute::query()
        ->where('inscription_id', $inscriptionId)
        ->whereIn('ressource_id', $ressourceIds)
        ->get()
        ->groupBy('semestre')
        ->map(fn($rows) => $rows->keyBy('ressource_id'));

    $obsFromNote = function ($note) {
        if (!is_numeric($note)) return '-';
        $note = (float) $note;
        if ($note < 10) return 'Insuffisant';
        if ($note < 12) return 'Passable';
        if ($note < 14) return 'Assez bien';
        if ($note < 16) return 'Bien';
        return 'Très bien';
    };

    return view('apprenant.mes-notes-apc', compact(
        'inscription',
        'competencesGenerales',
        'competencesParticulieres',
        'mccByRessource',
        'evalByRessource',
        'obsFromNote'
    ));
}


}
