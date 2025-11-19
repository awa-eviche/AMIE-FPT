<?php

namespace App\Http\Controllers;
use App\Models\Competence;
use App\Models\Evalute;
use App\Models\Inscription;
use App\Models\Classe;
use App\Models\Apprenant;
use App\Models\Etablissement;
use App\Models\Matiere;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;
use Dompdf\Dompdf;

class InscriptionController extends Controller
{
    protected $logUserRepository;

    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
        $this->logUserRepository = $logUserRepository;
        //  $this->middleware('permission:visualiser_inscription');

    }

    public function index()
    {
        // Récupérer le nom de l'utilisateur
        $userName = auth()->user()->nom;

        // Récupérer l'établissement correspondant au nom de l'utilisateur
        // $etablissement = Etablissement::where('nom', $userName)->first();

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            $etablissementId = auth()->user()->personnel->etablissement_id;

            // Vérifier si l'établissement est valide
            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }

            // Récupérer les IDs des classes associées à l'établissement actuel
            $classesIds = Classe::where('etablissement_id', $etablissementId)->pluck('id');
        } else {
            // Récupérer les IDs des classes de toutes les classes
            $classesIds = Classe::all()->pluck('id');
        }
        // Récupérer les IDs des apprenants associés à ces classes
        $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');

        $classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $currentClasse = $classe ? Classe::find($classe) : null;
        $classes = [$currentClasse];
        $matieres = $classe ? Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get() : [];

        // Récupérer les apprenants associés à ces IDs
        $apprenants = Apprenant::whereIn('id', $apprenantsIds)->get();

        return view('inscription.index', compact('apprenants', 'matieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer le nom de l'utilisateur
        $userName = auth()->user()->nom;

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            // Récupérer l'établissement correspondant au nom de l'utilisateur
            // $etablissement = Etablissement::where('nom', $userName)->first();
            $etablissementId = auth()->user()->personnel->etablissement_id;

            // Vérifiez si l'établissement est valide
            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }
            // Récupérer les classes associées à l'établissement actuel
            $classes = Classe::where('etablissement_id', $etablissementId)->get();

            // Récupérer les apprenants associés à l'établissement actuel
            $apprenants = Apprenant::where('etablissement_id', $etablissementId)->get();
        } else {
            // Récupérer toutes les classes 
            $classes = Classe::all();
            $classesIds = Classe::all()->pluck('id');

            // Récupérer les apprenants associés à l'établissement actuel
            $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');
            $apprenants = Apprenant::whereIn('apprenant_id', $apprenantsIds)->get();
        }

        return view('inscription.create', compact('classes', 'apprenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',



        ]);


        $inscription = Inscription::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddInscription, 'model' => Model::Inscription, 'new_object' => json_encode($inscription)]);


        return redirect()->route('inscription.index')

            ->withMessage('Inscription créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
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

        //Faire un controle pour afficher 03 compétences au plus par table
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

            //Afficher la ligne des elements de compétences
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

            //Afficher la ligne des critères
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

        //Afficher les elements de legende stockés dans le tableau legendes
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

    function generateCompetencePdf(string $id)
    {
        //
        $inscription = Inscription::find($id);
        $evaluations = Evalute::where('inscription_id', $inscription->id)->get()->keyBy('id')->toArray();
        $competences = Competence::where('niveau_etude_id', $inscription->classe->niveau_etude_id)->get();
        $criteres = [];
        $rowspans = [];
        foreach ($competences as $key => $competence) {
            $rowspan = 0;
            foreach ($competence->elementCompetences as $ec) {
                $rowspan += sizeof($ec->criteres);
                $criteres = [...$criteres, ...$ec->criteres->toArray()];
            }
            $rowspans[$key] = $rowspan;
        }

        $output = '';

        $rowspanCount = 0;
        foreach ($competences as $cptCompetence => $competence) {
            foreach ($competence->elementCompetences as $elementCompetence) {
                foreach ($elementCompetence->criteres as $cpt => $critere) {
                    $output .= '<tr>';
                    if ($rowspanCount == 0)
                        $output .= ' <td rowspan="' . $rowspans[$cptCompetence] . '" class="border-td">' . ($competence->nom ?? '-') . '</td>';
                    if ($cpt == 0)
                        $output .= ' <td rowspan="' . sizeof($elementCompetence->criteres) . '" class="border-td">' . ($elementCompetence->nom ?? '-') . '</td>';
                    $output .= '<td class="border-td">' . ($critere->libelle ?? '-') . '</td>';
                    $output .= '
                            <td class="border-td" align="center">';

                    $findRow = null;
                    foreach ($evaluations as $evaluation) {
                        if ($evaluation['inscription_id'] == $inscription->id && $evaluation['critere_id'] == $critere->id) {
                            $findRow = $evaluation;
                            break;
                        }
                    }

                    if ($findRow) {
                        if ($findRow['acquis'])
                            $output .= 'X';
                    }

                    $output .= '
                            </td>
                            <td class="border-td" align="center">';

                    if ($findRow) {
                        if ($findRow['enCours'])
                            $output .= 'X';
                    }

                    $output .= '
                            </td>
                            <td class="border-td" align="center">';

                    if ($findRow) {
                        if ($findRow['nonAcquis'])
                            $output .= 'X';
                    }

                    $output .= '
                            </td>
                            <td class="border-td" align="center" >';

                    if ($findRow) {
                        if ($findRow['date'])
                            $output .= date('d-m-Y', strtotime($findRow['date']));
                    }

                    $output .= '
                            </td>
                    ';
                    $output .= '</tr>';
                    $rowspanCount++;
                    if ($rowspanCount == $rowspans[$cptCompetence])
                        $rowspanCount = 0;
                }
            }
        }

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->setFontCache(storage_path('fonts'));
        $options->set('isRemoteEnabled', true);
        $options->set('pdfBackend', 'CPDF');
        $options->setChroot([
            '/',
            storage_path('fonts'),
        ]);

        $template = file_get_contents('competence.html');
            $template = str_replace('[BODY]', $output, $template);
        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $date = strftime('%e %B %Y');
        $template = str_replace('[DATE]', $date, $template);
        $template = str_replace('[USER]', $inscription->apprenant->nom . ' ' . $inscription->apprenant->prenom, $template);
        $template = str_replace('[DATENAISSANCE]', $inscription->apprenant->date_naissance, $template);

        $template = str_replace('[LIEUNAISSANCE]', $inscription->apprenant->lieu_naissance, $template);
        $template = str_replace('[TEL]', $inscription->apprenant->telephone, $template);
        $template = str_replace('[EMAIL]', $inscription->apprenant->email, $template);
        $template = str_replace('[CLASSE]', isset($inscription->classe->libelle) ? $inscription->classe->libelle : '', $template);
        $template = str_replace('[ANNEE]', isset($inscription->classe->niveau_etude->nom) ? $inscription->classe->niveau_etude->nom : '', $template);
        $template = str_replace('[ANNEESCOLAIRE]', isset($inscription->classe->annee_academique->code) ? $inscription->classe->annee_academique->code : '', $template);
        $template = str_replace('[EFPT]', isset($inscription->classe->etablissement->nom) ? $inscription->classe->etablissement->nom : '', $template);
        $template = str_replace('[EFPTTEL]', isset($inscription->classe->etablissement->telephone) ? $inscription->classe->etablissement->telephone : '', $template);

        $dompdf->loadHTML($template);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output the generated PDF to Browser
        $nom = 'Carnet de Competence.pdf';
       // $dompdf->stream($nom, array("Attachment" => false));
return response($dompdf->output(), 200)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'inline; filename="' . $nom . '"');

    }


}
