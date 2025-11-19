<?php

namespace App\Http\Controllers;
use App\Models\Apprenant;
use App\Models\Commune;
use App\Models\Etablissement; // Cette ligne doit être ici, avec les autres 'use'
use App\Models\User;
use App\Models\Classe;
use App\Models\AnneeAcademique;
use App\Models\Pays;
use App\Models\Inscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeAccesApprenantGenerated;
use App\Repositories\UserRepository;
use App\Repositories\LogUserRepository;
use App\Enums\UserAction;
use App\Enums\Model;
use App\Enums\MarriageStatus;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ApprenantsImport;



class ApprenantController extends Controller
{
    protected $logUserRepository;
    protected $userRepository;

    public function __construct(UserRepository $userRepository, LogUserRepository $logUserRepository)
    {
        $this->userRepository = $userRepository;
        $this->logUserRepository = $logUserRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('classe.show');
    }

    public function create(Apprenant $apprenant)
    {

        
        $classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $currentClasse = $classe ? Classe::find($classe) : null;
        $classes = [$currentClasse]; 
        $apprenants = $classe ? Inscription::where('classe_id',session()->get('currentClasse'))->get() : [];
        $communes  = Commune::all();
        $pays  = Pays::all();
        $anneeAcademiques = \App\Models\AnneeAcademique::all();

       
        return view('apprenant.create', [
            "apprenant" => $apprenants,
            "communes" => $communes,
            "pays" => $pays,
            'anneeAcademiques' => $anneeAcademiques,
            "apprenants" => $apprenants,
            "classe" => $classe,
            'classes'=>$classes,
            'currentClasse' => $currentClasse,
        ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'adresse' => 'required',
            'email' => 'nullable|email|unique:apprenants,email',
            'commune_id' => 'required',
            'nationalite' => 'required',
            'sexe' => 'required',
            'annee_academique_id' => 'required|exists:annee_academiques,id',
            'telephone' => 'required',
            'classe_id' => 'required|exists:classes,id',
        ]);
    
        try {
            // Création de l'apprenant (on enlève annee_academique_id et classe_id)
            $apprenantData = $request->except(['annee_academique_id', 'classe_id']);
            $apprenant = Apprenant::create($apprenantData);
    
            // Génération du matricule
            $apprenant->matricule = $this->genererMatricule($request);
            $apprenant->save();
    
            // Création de l'inscription
          //  $inscription = Inscription::create([
              //  'apprenant_id' => $apprenant->id,
              //  'classe_id' => $request->classe_id,
              //  'annee_academique_id' => $request->annee_academique_id,
               // 'dateInscription' => Carbon::now()->format('Y-m-d'),
              //  'createdAt' => Carbon::now(),
           // ]);
    
// Récupération du currentClasse et annee_academique_id
$classeId = session('currentClasse');
$anneeAcademiqueId = $request->annee_academique_id;

// Vérification de doublon
$exists = Inscription::where([
    ['apprenant_id', '=', $apprenant->id],
    ['classe_id', '=', $classeId],
    ['annee_academique_id', '=', $anneeAcademiqueId],
])->exists();

if ($exists) {
    return back()->withErrors(['error' => "Cet apprenant est déjà inscrit dans cette classe pour cette année académique."]);
}

// Inscription uniquement si pas de doublon
$inscription = Inscription::create([
    'apprenant_id' => $apprenant->id,
    'classe_id' => $classeId,
    'annee_academique_id' => $anneeAcademiqueId,
    'dateInscription' => Carbon::now()->format('Y-m-d'),
    'createdAt' => Carbon::now(),
]);


            // Logging
            $this->logUserRepository->store([
                'action' => UserAction::AddApprenant,
                'model' => Model::Apprenant,
                'new_object' => json_encode($apprenant)
            ]);
            $this->logUserRepository->store([
                'action' => UserAction::AddInscription,
                'model' => Model::Inscription,
                'new_object' => json_encode($inscription)
            ]);
    
            return redirect()->route('classe.show', $request->classe_id)
                ->withMessage("L'inscription a été faite avec succès.");
        } catch (\Exception $e) {
            Log::error($e);
            return back()->withInput()->withErrors(['error' => "Une erreur est survenue lors de l'inscription."]);
        }
    }
    

    public function edit($id)
    {
        $communes  = Commune::all();
        $apprenant = Apprenant::findOrFail($id);
        $pays  = Pays::all();
        $annees = AnneeAcademique::all(); // ✅ Ajouté ici
        $inscription = Inscription::where('apprenant_id', $apprenant->id)->first();
    
        return view('apprenant.edit', compact('apprenant','communes', 'pays', 'annees', 'inscription'));
    }
    

    public function update(Request $request, $id)
{
    $request->validate([
        'date_naissance' => 'required|date',
        'lieu_naissance' => 'required',
        'sexe' => 'required',
        'commune_id' => 'required',
        'nationalite' => 'required',
        'telephone' => 'required',
        'email' => 'nullable|email|max:255',
        'annee_academique_id' => 'required|exists:annee_academiques,id', // ✅ validée ici
    ]);

    $apprenant = Apprenant::findOrFail($id);

    // Vérifie si le sexe a été modifié
    $ancienSexe = $apprenant->sexe;
    $nouveauSexe = $request->sexe;

    $data = $request->only(
        'prenom', 'nom', 'date_naissance', 'lieu_naissance', 'nomTuteur',
        'prenomTuteur', 'numTelTuteur', 'nationalite', 'situationMatrimoniale', 'email',
        'prenomPere', 'nomPere', 'prenomMere', 'nomMere',
        'telephone', 'dateInsertion', 'autoEmploi', 'emploiSalarie', 'commune_id', 'sexe'
    );

    // Si le sexe change, régénérer le matricule
    if ($ancienSexe !== $nouveauSexe) {
        $data['matricule'] = $this->genererMatricule($request);
    }

    // Mise à jour de l'apprenant
    $apprenant->update($data);

    // Mise à jour de l'inscription liée à l'apprenant
    $inscription = Inscription::where('apprenant_id', $apprenant->id)->first();

    if ($inscription) {
        $inscription->annee_academique_id = $request->annee_academique_id;
        $inscription->save();

        return redirect()->route('classe.show', $inscription->classe_id)
            ->with('success', 'L\'apprenant a été mis à jour avec succès.');
    }

    return redirect()->back()->with('error', 'Inscription non trouvée pour cet apprenant.');
}


public function destroy($id)
{
    $apprenant = Apprenant::findOrFail($id);

    // Récupérer l'inscription liée à l'apprenant
    $inscription = Inscription::where('apprenant_id', $apprenant->id)->first();

    // Récupérer l'ID de la classe pour la redirection
    $classeId = $inscription ? $inscription->classe_id : session('currentClasse');

    // Log de l'action avant suppression
    $this->logUserRepository->store([
        'action' => UserAction::DeleteApprenant,
        'model' => Model::Apprenant,
        'old_object' => json_encode($apprenant)
    ]);

    // Suppression logique de l'apprenant
    $apprenant->delete();

    // Suppression physique de l'inscription (si elle existe)
    if ($inscription) {
        $inscription->delete();
    }

    // Redirection vers la page de la classe
    return redirect()->route('classe.show', $classeId)
                     ->withMessage('L\'apprenant a été supprimé avec succès.');
}

public function genererMatricule($request)
{
    $annee = date('Y');
    $annee2 = substr($annee, -2); // Ex: "25" pour 2025

   // Assure la robustesse du champ sexe
   $sexe = match (strtolower($request->sexe)) {
    'm', 'homme' => '1',
    'f', 'femme' => '2',
    default => throw new \Exception("Genre invalide : " . $request->sexe),
};

    $prefix = $annee2 . $sexe;

    // Recherche du dernier matricule correspondant au sexe + année
    $last = \App\Models\Apprenant::where('matricule', 'LIKE', $prefix . '%')
        ->orderByDesc('matricule')
        ->first();

    if ($last) {
        $ordreStr = substr($last->matricule, 3, 6); // extrait les 6 chiffres
        $ordre = str_pad(((int) $ordreStr) + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $ordre = '000001';
    }

    $matriculeBase = $prefix . $ordre;

    // Calcul du checksum (lettre finale)
    $pairs = $impairs = 0;
    foreach (str_split($matriculeBase) as $i => $chiffre) {
        $chiffre = (int) $chiffre;
        if ($i % 2 == 0) {
            $pairs += $chiffre;
        } else {
            $impairs += $chiffre;
        }
    }

    $checksumIndex = abs($pairs - $impairs) % 26;
    $lettre = range('A', 'Z')[$checksumIndex];

    return $matriculeBase . $lettre;
}


public function import(Request $request, $classeId)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    // On récupère la classe passée en paramètre
    $classe = Classe::find($classeId);

    if (!$classe) {
        return back()->withErrors(['classe' => 'Classe introuvable.']);
    }

    try {
        Excel::import(new ApprenantsImport($classe), $request->file('file'));
        return redirect()->route('classe.show', $classe->id)->withMessage('Importation réussie des apprenants.');
    } catch (\Exception $e) {
        \Log::error($e);
        return back()->withErrors(['file' => $e->getMessage()]);
    }
}



}
