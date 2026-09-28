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
    /**
     * CSS anti-débordement pour le carnet de compétences. $scale va de 1.0
     * (tailles d'origine du template) à 0.55 (compaction maximale). Couvre
     * tout ce qui peut pousser le contenu sur une 2e page : le tableau des
     * ressources, l'en-tête, le bandeau de titre et le bloc mentions/
     * observations (qui avaient des tailles figées, jamais réduites avant).
     */
    private function antiOverflowCssFor(float $scale, string $scope = ''): string
    {
        $scale = max(0.55, min(1.0, $scale));

        $bodyFont     = round(12 * $scale, 2);
        $tdFont       = round(12 * $scale, 2);
        $tdPad        = round(0.3 * $scale, 3);
        $mentionsFont = round(9.5 * $scale, 2);
        $obsHeight    = max(18, round(70 * $scale));
        $h1           = round(20 * $scale, 1);
        $h2           = round(16 * $scale, 1);
        $pFont        = round(13 * $scale, 1);
        $titleFont    = max(11, round(18 * $scale, 1));

        // ✅ Si $scope est fourni (ex: ".bulletin-42"), chaque règle est
        // limitée à ce sous-arbre : indispensable quand plusieurs bulletins
        // (avec chacun leur propre échelle de compaction) sont regroupés dans
        // un même document PDF — sinon des règles non préfixées (body,
        // .border-td...) s'appliqueraient à tout le document et écraseraient
        // la compaction des autres bulletins.
        $root = $scope !== '' ? $scope : 'body';
        $d    = $scope !== '' ? $scope . ' ' : '';

        return "
            {$root} { font-size: {$bodyFont}px !important; }
            .full-table{ width:100%; border-collapse:collapse; table-layout:fixed; }
            .wrap{ word-wrap:break-word; overflow-wrap:break-word; }
            .num{ text-align:center; white-space:nowrap; }
            {$d}.border-td{ border:1px solid #000; padding:{$tdPad}em !important; font-size:{$tdFont}px !important; vertical-align:top; white-space:normal; }
            {$d}header h1 { font-size: {$h1}px !important; }
            {$d}header h2 { font-size: {$h2}px !important; }
            {$d}header p { font-size: {$pFont}px !important; margin: 1px 0 !important; }
            {$d}header { margin-bottom: 4px !important; }
            {$d}.title-band { font-size: {$titleFont}px !important; padding: 3px 8px !important; margin: 3px 0 5px 0 !important; }
            {$d}.p-small { margin-top: 2px !important; }
            {$d}.bloc-mentions table { font-size: {$mentionsFont}px !important; margin-top: 2px !important; }
            {$d}.obs-box { min-height: {$obsHeight}px !important; }
        ";
    }

    /**
     * Injecte la CSS anti-débordement dans $templateBase (marqueur </style>
     * encore intact) puis rend le PDF ; si le résultat déborde sur plusieurs
     * pages, recommence avec une compaction plus forte, jusqu'à ce que tout
     * tienne sur une seule page (ou que la compaction max soit atteinte).
     * Retourne le HTML final et l'échelle retenue, pour pouvoir la réutiliser
     * sans re-mesurer (ex : tous les bulletins d'une même classe).
     *
     * Si $scope est fourni (ex: ".bulletin-42", pour un carnet de classe où
     * plusieurs élèves sont regroupés dans un même document), la mesure est
     * faite sur la structure EXACTEMENT telle qu'elle sera assemblée dans le
     * document final (contenu isolé dans un <div class="...">) : mesurer sur
     * <body> directement puis extraire le fragment donnerait une échelle
     * légèrement optimiste, le <div> supplémentaire pouvant suffire à faire
     * déborder un ajustement pile-poil.
     */
    private function fitContentOnePage(string $templateBase, \Dompdf\Options $options, string $scope = ''): array
    {
        $scale = 1.0;
        $html  = $templateBase;

        for ($attempt = 0; $attempt < 4; $attempt++) {
            $html = str_replace('</style>', $this->antiOverflowCssFor($scale, $scope) . '</style>', $templateBase);

            if ($scope !== '') {
                $scopeClass = ltrim($scope, '.');
                $wrapped = '<div class="' . $scopeClass . '">' . $this->extractBodyContent($html) . '</div>';
                $html = $this->injectBodyContent($html, $wrapped);
            }

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $pages = $dompdf->getCanvas()->get_page_count();
            if ($pages <= 1 || $scale <= 0.55) {
                break;
            }

            $scale = max(0.55, $scale - 0.12 * $pages);
        }

        return [$html, $scale];
    }

    /**
     * Extrait uniquement le contenu de <body>...</body> d'un document HTML
     * complet. Utilisé pour regrouper plusieurs bulletins dans un seul
     * document final au lieu de concaténer des <html>/<body> complets (que
     * Dompdf aplatit en un seul <body>, faisant "fuir" les <style> de l'un
     * sur les autres).
     */
    private function extractBodyContent(string $html): string
    {
        $bodyOpenPos = strpos($html, '<body');
        if ($bodyOpenPos === false) {
            return $html;
        }
        $bodyOpenEnd = strpos($html, '>', $bodyOpenPos) + 1;

        $bodyClosePos = strpos($html, '</body>');
        if ($bodyClosePos === false) {
            return substr($html, $bodyOpenEnd);
        }

        return substr($html, $bodyOpenEnd, $bodyClosePos - $bodyOpenEnd);
    }

    /**
     * Remplace le contenu de <body>...</body> de $template par $bodyContent.
     */
    private function injectBodyContent(string $template, string $bodyContent): string
    {
        $bodyOpenPos = strpos($template, '<body');
        if ($bodyOpenPos === false) {
            return $template . $bodyContent;
        }
        $bodyOpenEnd = strpos($template, '>', $bodyOpenPos) + 1;

        $bodyClosePos = strpos($template, '</body>');
        if ($bodyClosePos === false) {
            return substr($template, 0, $bodyOpenEnd) . $bodyContent;
        }

        return substr($template, 0, $bodyOpenEnd) . $bodyContent . substr($template, $bodyClosePos);
    }

    /**
     * Bloc mentions : la mention (Félicitations...) reste toujours en 1ère position.
     * En 2e position : mentions de travail (Travail excellent...) au 1er semestre,
     * décision du conseil (passage/redoublement/exclusion) au 2e semestre.
     */
    // ✅ Affiche un nombre d'heures sans décimales inutiles (2 au lieu de 2.00, 2.5 au lieu de 2.50)
    private function formatHeures($valeur): string
    {
        return rtrim(rtrim(number_format((float) $valeur, 2, '.', ''), '0'), '.') ?: '0';
    }

    private function blocMentionsHtml(?int $semestre): string
    {
        $mention = '
            <table class="full-table" cellspacing="0">
                <tr><td class="border-td">Félicitations</td><td class="border-td" style="width:22px;"></td></tr>
                <tr><td class="border-td">Encouragements</td><td class="border-td"></td></tr>
                <tr><td class="border-td">Tableau d\'honneur</td><td class="border-td"></td></tr>
                <tr><td class="border-td">Passable</td><td class="border-td"></td></tr>
                <tr><td class="border-td">Doit redoubler d\'effort</td><td class="border-td"></td></tr>
                <tr><td class="border-td">Avertissement</td><td class="border-td"></td></tr>
                <tr><td class="border-td">Blâme</td><td class="border-td"></td></tr>
            </table>
        ';

        if ($semestre === 2) {
            $second = '
                <table class="full-table" cellspacing="0">
                    <tr><td class="border-td bg-grey bold-exo centered" colspan="2">Décision du Conseil</td></tr>
                    <tr><td class="border-td">Admis(e) en classe supérieure</td><td class="border-td" style="width:22px;"></td></tr>
                    <tr><td class="border-td">Autorisé(e) à redoubler</td><td class="border-td"></td></tr>
                    <tr><td class="border-td">Exclusion</td><td class="border-td"></td></tr>
                </table>
            ';
        } else {
            $second = '
                <table class="full-table" cellspacing="0">
                    <tr><td class="border-td">Travail excellent</td><td class="border-td" style="width:22px;"></td></tr>
                    <tr><td class="border-td">Satisfaisant doit continuer</td><td class="border-td"></td></tr>
                    <tr><td class="border-td">Peut mieux faire</td><td class="border-td"></td></tr>
                    <tr><td class="border-td">Insuffisant</td><td class="border-td"></td></tr>
                    <tr><td class="border-td">Risque de redoubler</td><td class="border-td"></td></tr>
                    <tr><td class="border-td">Risque l\'exclusion</td><td class="border-td"></td></tr>
                </table>
            ';
        }

        return '
            <table class="full-table" cellspacing="0">
                <tr>
                    <td style="width:50%; vertical-align:top; padding:0 4px 0 0;">' . $mention . '</td>
                    <td style="width:50%; vertical-align:top; padding:0 0 0 4px;">' . $second . '</td>
                </tr>
            </table>
        ';
    }

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
    
public function createUserForInscription($inscription)
{
    $exists = User::where('inscription_id', $inscription->id)->exists();

    if ($exists) {
        return;
    }

    
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


public function generateCompetencePdf(string $id, $semestre = null)
{
    // Paramètre direct prioritaire sur la session
    $semestre = $semestre ?? session()->get('selectedsemestre1');
    $semestreInt = $semestre ? (int) $semestre : null;

    $inscription = Inscription::with([
        'apprenant',
        'classe.niveau_etude',
        'classe.etablissement',
        'anneeAcademique',
    ])->findOrFail($id);

    $classeId = (int) $inscription->classe_id;
    $niveauId = (int) $inscription->classe->niveau_etude_id;
    $anneeId = $inscription->annee_academique_id;

  

    $competencesGenerales = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->whereHas('ressources', function ($q) use ($classeId, $anneeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id')
              ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId));
        })
        ->with(['ressources' => function ($q) use ($classeId, $anneeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id')
              ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId));
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
        ->whereHas('ressources', function ($q) use ($classeId, $anneeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id')
              ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId));
        })
        ->with(['ressources' => function ($q) use ($classeId, $anneeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id')
              ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId));
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

        // Garder les disciplines ayant au moins MCC ou composition pour ce semestre
        $ressources = $ressources->filter(function ($res) use ($evalByRessource, $mccByRessource) {
            $eval = $evalByRessource[$res->id] ?? null;
            $mcc  = $mccByRessource[$res->id] ?? null;
            return is_numeric($eval?->composition) || is_numeric($mcc);
        })->values();

        if ($ressources->isEmpty()) continue;

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

        // Garder les disciplines ayant au moins MCC ou composition pour ce semestre
        $ressources = $ressources->filter(function ($res) use ($evalByRessource, $mccByRessource) {
            $eval = $evalByRessource[$res->id] ?? null;
            $mcc  = $mccByRessource[$res->id] ?? null;
            return is_numeric($eval?->composition) || is_numeric($mcc);
        })->values();

        if ($ressources->isEmpty()) continue;

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

    // ✅ "justifie" est prioritaire : une ligne ne doit jamais être comptée à la
    // fois comme justifiée et non justifiée, même si "nonjustifie" est resté à 1
    // par erreur (cf. bug de case à cocher non réinitialisée en édition).
    $hAbsJust = (float) $absencesSemestre->where('type','absence')->where('justifie', 1)->sum('nombre_heure_absence');

    $hAbsNon = (float) $absencesSemestre->where('type','absence')
        ->where('justifie', '!=', 1)
        ->sum('nombre_heure_absence');

    $hRetJust = (float) $absencesSemestre->where('type','retard')->where('justifie', 1)->sum('nombre_heure_retard');

    $hRetNon = (float) $absencesSemestre->where('type','retard')
        ->where('justifie', '!=', 1)
        ->sum('nombre_heure_retard');

    $hAbsTotal = $hAbsJust + $hAbsNon;
    $hRetTotal = $hRetJust + $hRetNon;

    $retTotal = $absencesSemestre->where('type', 'retard')->count();

    $absTotal = $absencesSemestre->where('type', 'absence')->count();
    $absJustifiees = $absencesSemestre->where('type', 'absence')->where('justifie', 1)->count();
    $absNonJustifiees = $absencesSemestre->where('type', 'absence')
        ->where('justifie', '!=', 1)
        ->count();

    // ✅ Template (chemin robuste)
    $templatePath = public_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = base_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = resource_path('views/competence.html');

    $template = file_get_contents($templatePath);

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
    $template = str_replace('[BLOC_MENTIONS]', $this->blocMentionsHtml($semestreInt), $template);

    // absences / retards (en heures, cohérent avec la saisie "Nombre d'heures d'absence")
    $template = str_replace('[RET_TOTAL]', $this->formatHeures($hRetTotal), $template);
    $template = str_replace('[ABS_TOTAL]', $this->formatHeures($hAbsTotal), $template);
    $template = str_replace('[ABS_JUSTIFIEES]', $this->formatHeures($hAbsJust), $template);
    $template = str_replace('[ABS_NON_JUSTIFIEES]', $this->formatHeures($hAbsNon), $template);

   
       
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

    // ✅ Dompdf, avec compaction adaptative pour tenir sur une seule page
    // quel que soit le nombre de disciplines/ressources.
    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true);

    [$finalHtml, ] = $this->fitContentOnePage($template, $options);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($finalHtml);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Carnet_de_Competence.pdf"');
}


public function generateClassePdf(string $classe_id)
{
    set_time_limit(300);

    // Priorité au paramètre GET du formulaire, sinon fallback session
    $semestre = request()->input('semestre') ?: session()->get('selectedsemestre1');

    $semestreInt = $semestre ? (int) $semestre : null;

    $classe = Classe::with([
        'niveau_etude',
        'etablissement',
        'inscriptions.apprenant',
        'inscriptions.anneeAcademique',
        'annee_academique',
    ])->findOrFail($classe_id);

    // Bulletins de l'année choisie uniquement (une classe est réutilisée d'une année à l'autre).
    $anneeId = \App\Services\AnneeDesNotes::pourClasse((int) $classe->id, request());
    $classe->setRelation('inscriptions', $classe->inscriptions->when($anneeId, fn ($i) => $i->where('annee_academique_id', $anneeId))->values());

    $niveauId = (int) $classe->niveau_etude_id;
    $classeId = (int) $classe->id;
    $competencesGenerales = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->whereHas('ressources', function ($q) use ($classeId, $anneeId) {
            $q->where(function ($query) use ($classeId) {
                $query->where('classe_id', $classeId)
                      ->orWhereNull('classe_id');
            })
            ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId))
            ->whereNotNull('formateur_id');
        })
        ->with('ressources')
        ->orderBy('nom')
        ->get();
    $competencesParticulieres = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'particuliere')
        ->whereHas('ressources', function ($q) use ($classeId, $anneeId) {
            $q->where(function ($query) use ($classeId) {
                $query->where('classe_id', $classeId)
                      ->orWhereNull('classe_id');
            })
            ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId))
            ->whereNotNull('formateur_id');
        })
        ->with('ressources')
        ->orderBy('nom')
        ->get();

   

    $filterRessourcesByClasse = function ($competences) use ($classeId, $anneeId) {
        foreach ($competences as $comp) {

            $ressources = collect($comp->ressources ?? []);

            $filtered = $ressources
                ->filter(function ($res) use ($classeId, $anneeId) {

                    $direct = (int) ($res->classe_id ?? 0);
                    $pivot  = (int) ($res->pivot->classe_id ?? 0);

                    $memeAnnee = !\App\Services\AnneeDesNotes::aUneColonne('ressources') || !$anneeId
                        || (int) ($res->annee_academique_id ?? 0) === (int) $anneeId;

                    return (
                        ($direct === $classeId || $pivot === $classeId)
                        && !is_null($res->formateur_id)
                        && $memeAnnee
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

    // ✅ Logo (base64)
    $logoPath = public_path('assets/images/titleHead.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }
    $templateRaw = str_replace('[LOGO]', $logoBase64, $templateRaw);

    // ✅ Génération bulletins
    $bulletins = '';

    // ✅ CSS de compaction accumulée, scopée par élève (voir plus bas).
    $allCss = '';

    // ✅ Options Dompdf pour la mesure/compaction (une par élève : le nombre
    // de lignes visibles diffère selon les notes disponibles).
    $pdfOptions = new \Dompdf\Options();
    $pdfOptions->set('isRemoteEnabled', true);

    foreach ($classe->inscriptions as $inscription) {

        $inscId = (int) $inscription->id;

        // ----------- GÉNÉRALES -----------
        $htmlGenerales = '';

        foreach ($competencesGenerales as $comp) {
            // Garder les disciplines ayant au moins MCC ou composition pour cet étudiant ce semestre
            $ressources = ($comp->ressources ?? collect())->filter(function ($res) use ($inscId, $evalMap, $mccMap) {
                $composition = $evalMap[$inscId][(int)$res->id] ?? null;
                $mcc         = $mccMap[$inscId][(int)$res->id] ?? null;
                return is_numeric($composition) || is_numeric($mcc);
            })->values();

            if ($ressources->isEmpty()) continue;

            $rowspan = $ressources->count();
            $first = true;

            foreach ($ressources as $res) {
                $resId = (int) $res->id;

                $mcc = $mccMap[$inscId][$resId] ?? null;
                $compositionRaw = $evalMap[$inscId][$resId] ?? null;

                $integrationEffective = (float) $compositionRaw;

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
            // Garder les disciplines ayant au moins MCC ou composition pour cet étudiant ce semestre
            $ressources = ($comp->ressources ?? collect())->filter(function ($res) use ($inscId, $evalMap, $mccMap) {
                $composition = $evalMap[$inscId][(int)$res->id] ?? null;
                $mcc         = $mccMap[$inscId][(int)$res->id] ?? null;
                return is_numeric($composition) || is_numeric($mcc);
            })->values();

            if ($ressources->isEmpty()) continue;

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

        // ✅ "justifie" est prioritaire : une ligne ne doit jamais être comptée à la
        // fois comme justifiée et non justifiée, même si "nonjustifie" est resté à 1
        // par erreur (cf. bug de case à cocher non réinitialisée en édition).
        $hAbsJust = (float) $absencesSemestre->where('type','absence')->where('justifie', 1)->sum('nombre_heure_absence');

        $hAbsNon = (float) $absencesSemestre->where('type','absence')
            ->where('justifie', '!=', 1)
            ->sum('nombre_heure_absence');

        $hRetJust = (float) $absencesSemestre->where('type','retard')->where('justifie', 1)->sum('nombre_heure_retard');

        $hRetNon = (float) $absencesSemestre->where('type','retard')
            ->where('justifie', '!=', 1)
            ->sum('nombre_heure_retard');

        $hAbsTotal = $hAbsJust + $hAbsNon;
        $hRetTotal = $hRetJust + $hRetNon;

        $retTotal = $absencesSemestre->where('type', 'retard')->count();

        $absTotal = $absencesSemestre->where('type', 'absence')->count();
        $absJustifiees = $absencesSemestre->where('type', 'absence')->where('justifie', 1)->count();
        $absNonJustifiees = $absencesSemestre->where('type', 'absence')
            ->where('justifie', '!=', 1)
            ->count();

        // ✅ Date FR
        // setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');
        
       $dateNow = \Carbon\Carbon::now()->format('d/m/Y');


        $anneeScolaire = $inscription->anneeAcademique->code
            ?? ($classe->annee_academique->code ?? '');
        $page = $templateRaw;

        $page = str_replace('[BODYRESSOURCE]', $htmlGenerales, $page);
        $page = str_replace('[BODYCOMP]', $htmlParticulieres, $page);
        $page = str_replace('[BLOC_MENTIONS]', $this->blocMentionsHtml($semestreInt), $page);

        // absences / retards (en heures, cohérent avec la saisie "Nombre d'heures d'absence")
        $page = str_replace('[RET_TOTAL]', $this->formatHeures($hRetTotal), $page);
        $page = str_replace('[ABS_TOTAL]', $this->formatHeures($hAbsTotal), $page);
        $page = str_replace('[ABS_JUSTIFIEES]', $this->formatHeures($hAbsJust), $page);
        $page = str_replace('[ABS_NON_JUSTIFIEES]', $this->formatHeures($hAbsNon), $page);

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

        // ✅ Compaction adaptative mesurée pour CHAQUE élève : le nombre de
        // lignes visibles varie d'un élève à l'autre (les disciplines sans
        // note sont masquées), donc une échelle calibrée sur un seul élève
        // ne convient pas forcément aux autres. Concaténer plusieurs
        // documents <html>/<body> complets dans un seul PDF fait que le
        // parser HTML de Dompdf ne garde qu'un seul <body> : un <style> par
        // élève "fuit" alors sur tous les autres. On extrait donc uniquement
        // le contenu de chaque bulletin, on le scope avec une classe unique,
        // et on regroupe toute la CSS de compaction dans l'unique <style>
        // partagé du document final.
        $scopeClass = 'bulletin-' . $inscId;
        [$fittedDoc, $scale] = $this->fitContentOnePage($page, $pdfOptions, '.' . $scopeClass);

        $allCss .= $this->antiOverflowCssFor($scale, '.' . $scopeClass);
        $bulletins .= $this->extractBodyContent($fittedDoc) . '<div style="page-break-after: always;"></div>';
    }

    // ✅ Un seul document final : le <head>/<style> du template (avec toute
    // la CSS de compaction scopée par élève) + le contenu de tous les
    // bulletins en <body>, au lieu de N documents complets concaténés.
    $finalDocument = str_replace('</style>', $allCss . '</style>', $templateRaw);
    $finalDocument = $this->injectBodyContent($finalDocument, $bulletins);

    $dompdf = new Dompdf($pdfOptions);
    $dompdf->loadHtml($finalDocument);
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
    $anneeId = $inscription->annee_academique_id;

    // Compétences générales — même logique que generateCompetencePdf
    $competencesGenerales = \App\Models\Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->whereHas('ressources', function ($q) use ($classeId, $anneeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id')
              ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId));
        })
        ->with(['ressources' => function ($q) use ($classeId, $anneeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id')
              ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId));
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
        ->whereHas('ressources', function ($q) use ($classeId, $anneeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id')
              ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId));
        })
        ->with(['ressources' => function ($q) use ($classeId, $anneeId) {
            $q->where('classe_id', $classeId)->whereNotNull('formateur_id')
              ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $anneeId, fn ($qq) => $qq->where('annee_academique_id', $anneeId));
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
