<?php

namespace App\Http\Controllers;
use App\Models\Apprenant;
use App\Models\Commune;
use App\Models\Etablissement; // Cette ligne doit être ici, avec les autres 'use'
use App\Models\User;
use App\Models\Classe;
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
       
        return view('apprenant.create', [
            "apprenant" => $apprenants,
            "communes" => $communes,
            "pays" => $pays,
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
            //'email' => 'required|email|unique:apprenants,email',
            'email' => 'nullable|email|unique:apprenants,email',

            'commune_id'=> 'required',
            'nationalite'=> 'required',
            'sexe'=> 'required',
            'telephone' => 
                'required',
                // 'regex:/^(77|76|78|75|70)[0-9]{7}$/',
            
        ]);

        $classe = $request->input('name');
        
        try {

            $apprenant = Apprenant::create($request->all());

    // Génération du matricule
        $apprenant->matricule = $this->genererMatricule($request);

        // Sauvegarde de l'apprenant avec le matricule
        $apprenant->save();



            $classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';

           $inscription =  Inscription::create([
                'apprenant_id' => $apprenant->id,
                'classe_id' => $classe,
                'dateInscription' => Carbon::now()->format('Y-m-d'),
                'createdAt' => Carbon::now(),
            ]);

            $this->logUserRepository->store(['action' => UserAction::AddApprenant, 'model' => Model::Apprenant, 'new_object' => json_encode($apprenant)]);
            $this->logUserRepository->store(['action' => UserAction::AddInscription, 'model' => Model::Inscription, 'new_object' => json_encode($inscription)]);

            return redirect()->route('classe.show', $classe)
                ->withMessage('L\'inscription de l\'apprenant a été faite avec succès.');
    
        } catch (\Exception $e) {
            Log::info($e);
            return back()->withInput()->withErrors(['error' => 'Une erreur est survenue lors de la création de l\'apprenant. Veuillez réessayer.']);
        }

       
    }

    public function show($id)
    {
        $apprenant = Apprenant::findOrFail($id);
       
        return view('apprenant.show', compact('apprenant'));
    }

    public function edit($id)
    {
        $communes  = Commune::all();
        $apprenant = Apprenant::findOrFail($id);
        $pays  = Pays::all();
        return view('apprenant.edit', compact('apprenant','communes', 'pays'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'date_naissance' => 'required|date',
        'lieu_naissance' => 'required',
        'sexe' => 'required',
        'commune_id' => 'required',
        'nationalite' => 'required',
         'email' => 'nullable|email|max:255',
        'telephone' => 'required',
    ]);

    $apprenant = Apprenant::findOrFail($id);
    $apprenant->update($request->only(
        'prenom', 'nom', 'date_naissance', 'lieu_naissance', 'nomTuteur',
        'prenomTuteur', 'numTelTuteur', 'nationalite', 'situationMatrimoniale',
        'prenomPere', 'nomPere', 'prenomMere', 'nomMere',
        'email', 'telephone', 'dateInsertion', 'autoEmploi', 'emploiSalarie'
    ));

    // Récupérer l'inscription de l'apprenant pour obtenir la classe
    $inscription = Inscription::where('apprenant_id', $apprenant->id)->first();
    if ($inscription && $inscription->classe_id) {
        return redirect()->route('classe.show', $inscription->classe_id)
            ->with('success', 'L\'apprenant a été mis à jour avec succès.');
    }

    // Fallback au cas où aucune inscription n'est trouvée
    return redirect()->back()->with('error', 'Classe non trouvée pour cet apprenant.');
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
   // $apprenant->update(['isDeleted' => true]);
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
        $annee1 = substr($annee, -2);
    
        // Sélection du genre (avec fallback)
        $sexe = match ($request->sexe) {
            'Homme' => '1',
            'Femme' => '2',
            default => throw new \Exception("Genre invalide"),
        };
    
        // Compter le nombre d'apprenants pour l'année en cours pour l'ordre (plus fiable que id max)
        $ordre = Apprenant::whereYear('created_at', $annee)->count() + 1;
        $ordre = str_pad($ordre, 6, '0', STR_PAD_LEFT); // 6 chiffres au lieu de 5
    
        // Concaténation
        $matriculeBase = $annee1 . $sexe . $ordre;
    
        // Calcul du checksum
        $pairs = $impairs = 0;
        foreach (str_split($matriculeBase) as $i => $chiffre) {
            $chiffre = (int)$chiffre;
            if ($i % 2 == 0) {
                $pairs += $chiffre;
            } else {
                $impairs += $chiffre;
            }
        }
    
        // Valeur absolue de la différence, réduite à 0-25
        $checksumIndex = abs($pairs - $impairs) % 26;
    
        // Lettre correspondante
        $lettresAlphabet = range('A', 'Z');
        $checksumLettre = $lettresAlphabet[$checksumIndex];
    
        // Matricule final
        return $matriculeBase . $checksumLettre;
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
