<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Classe;
use App\Models\Etablissement;
use App\Models\ElementCompetence;
use App\Models\AnneeAcademique;
use App\Models\Apprenant;
use App\Models\Entreprise;
use App\Models\NiveauEtude;
use App\Models\Metier;
use App\Models\Filiere;
use App\Models\FiliereEtablissement;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Models\PersonnelEtablissement;
use App\Enums\Model;
use Illuminate\Support\Facades\DB;
use PDF;


class ClasseController extends Controller
{
    protected $logUserRepository;
    
    public function __construct(LogUserRepository $logUserRepository)
    {  
        $this->middleware('auth');
        $this->middleware('permission:visualiser_classe_matiere');
        $this->logUserRepository = $logUserRepository;
    }

    
    public function index()
    {
         
        return view('classe.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $idEtablissement = optional(auth()->user()->personnel)->etablissement_id;
        if($idEtablissement  == null)
        {
            return back()->withErrors('Il faut être associé à un établissement pour créer une classe');
        }

        $niveaux = NiveauEtude::all();
        $classes = Classe::all();
        $etablissements = Etablissement::all();
        $metiers= Metier::all();
      //  $anneeacademiques = AnneeAcademique::all();
        return view('classe.create', compact('niveaux','classes','metiers','etablissements'));
    }
    
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           
            'libelle' => 'required|string|max:255',
            'modalite' => 'required',
            'niveau_etude_id' => 'required|string',
           // 'annee_academique_id' => 'required|string',
            'etablissement_id' => 'required|string',
           

        ]);

        
        $classe = Classe::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddClasse, 'model' => Model::Classe, 'new_object' => json_encode($classe)]);

        return redirect()->route('classe.index')

                         ->withMessage('Classe créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function showboubakh(Classe $classe)
    {
//        $inscriptions = Inscription::where('classe_id', $classe->id)->get();
        $inscriptions = Inscription::where('classe_id', $classe->id)->paginate(10);
        $users =  collect();
        $entreprises =  collect();
        $usersWithEnterprises = [];
        session()->put('currentClasse',$classe->id);

        $classe0 = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $currentClasse = $classe0 ? Classe::find($classe0) : null;
        $classes = [$currentClasse]; 
          $competences = collect();
            $matieres = collect();
          
        if ($currentClasse && $currentClasse->niveau_etude) {
            if ($currentClasse->modalite === 'PPO') {
                $matieres = Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get();
            } elseif ($currentClasse->modalite === 'APC') {
                $competences = Competence::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get();
            }
        }


        foreach ($inscriptions as $inscription) {
            $apprenant_id = $inscription->apprenant_id;
            // $apprenant=Apprenant::find($apprenant_id);
            // dd($apprenant->user_id);
            // $user =User::firstWhere(['userable_type' => 'apprenant', 'userable_id' => $apprenant_id]);
            // $user->inscription = $inscription->id;

            $usersWithEnterprises[] = [
                'user' => $inscription,
            ];
        }


        return view('classe.show',[
            "usersWithEnterprises"=>$usersWithEnterprises,
            "matieres"=>$matieres,
            "classe"=>$classe,
	    "competences" => $competences,
            "inscriptions" => $inscriptions, // important
        ]);
    }


  
     public function show(Request $request, Classe $classe)
{
   
    $anneeAcademiques = AnneeAcademique::orderByDesc('id')->get();
    $anneeAcademiqueId = $request->input('annee_academique_id') ?? $anneeAcademiques->first()?->id;

    
    $inscriptions = Inscription::where('classe_id', $classe->id)
        ->when($anneeAcademiqueId, fn($q) => $q->where('annee_academique_id', $anneeAcademiqueId))
        ->with('apprenant')
        ->paginate(10)
        ->appends($request->only('annee_academique_id'));

    session()->put('currentClasse', $classe->id);

   
    $classe->loadMissing(['niveau_etude']);
    $matieres = collect();
    $competences = collect();
    $assignations = collect();

   
    if ($classe->niveau_etude) {
        if ($classe->modalite === 'PPO') {
           
            $matieres = Matiere::where('niveau_etude_id', $classe->niveau_etude->id)
                ->select('id', 'nom')
                ->get();

            $assignations = DB::table('classe_formateur_matiere')
                ->join('matieres', 'classe_formateur_matiere.matiere_id', '=', 'matieres.id')
                ->join('users', 'classe_formateur_matiere.formateur_id', '=', 'users.id')
                ->where('classe_formateur_matiere.classe_id', $classe->id)
                ->select(
                    'users.nom as formateur_nom',
                    'users.prenom as formateur_prenom',
                    'matieres.nom as matiere_nom',
                    'classe_formateur_matiere.formateur_id',
                    'classe_formateur_matiere.matiere_id'
                )
                ->get();

        }  elseif ($classe->modalite === 'APC') {
   
    $competences = Competence::where('niveau_etude_id', $classe->niveau_etude->id)
        ->select('id', 'nom', 'type')
        ->get();

   
    $assignations = DB::table('classe_formateur_competence')
        ->join('competences', 'classe_formateur_competence.competence_id', '=', 'competences.id')
        ->join('users', 'classe_formateur_competence.formateur_id', '=', 'users.id')
        ->where('classe_formateur_competence.classe_id', $classe->id)
        ->select(
            'users.nom as formateur_nom',
            'users.prenom as formateur_prenom',
            'competences.nom as competence_nom',
            'competences.type as competence_type',
            'classe_formateur_competence.formateur_id',
            'classe_formateur_competence.competence_id'
        )
        ->get();

 
    foreach ($assignations as $a) {
        if ($a->competence_type === 'generale') {
            $a->elements = ElementCompetence::where('competence_id', $a->competence_id)
                ->select('id', 'nom', 'competence_id')
                ->get();
        } else {
            $a->elements = collect();
        }
    }
}

        
    }

   
    $formateurs = DB::table('formateur_etablissement')
        ->join('personnel_etablissements', 'formateur_etablissement.personnel_etablissement_id', '=', 'personnel_etablissements.id')
        ->join('users', 'personnel_etablissements.user_id', '=', 'users.id')
        ->where('formateur_etablissement.classe_id', $classe->id)
        ->select('users.id', 'users.nom', 'users.prenom')
        ->distinct()
        ->get();

    
    $usersWithEnterprises = [];
    foreach ($inscriptions as $inscription) {
        $usersWithEnterprises[] = ['user' => $inscription];
    }
    return view('classe.show', [
        'usersWithEnterprises'      => $usersWithEnterprises,
        'matieres'                  => $matieres,
        'competences'               => $competences,
        'classe'                    => $classe,
        'formateurs'                => $formateurs,
        'assignations'              => $assignations,
        'inscriptions'              => $inscriptions,
        'anneeAcademiques'          => $anneeAcademiques,
        'selectedAnneeAcademiqueId' => $anneeAcademiqueId,
    ]);
}
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classe $classe)
    {
        
        $niveaux = NiveauEtude::all();
       
        $etablissements = Etablissement::all();
        $metiers= Metier::all();
        $anneeacademiques = AnneeAcademique::all();
        return view('classe.edit', compact('niveaux','classe','metiers','etablissements','anneeacademiques'));
    }
    

    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'modalite' => 'required|',
            'niveau_etude_id' => 'required|string',
           // 'annee_academique_id' => 'required|string',
            'etablissement_id' => 'required|string',
        ]);

        $classe->update($request->all());

        return redirect()->route('classe.index')
                         ->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroy(Classe $classe)
    {
        $this->logUserRepository->store([
            'action' => UserAction::DeleteClasse, 'model' => Model::Classe,
            'old_object' => json_encode($classe)
        ]);
        $classe->delete();

        return redirect()->route('classe.index')
                         ->withMessage('Classe supprimée avec succès.');
    }


    public function validated($id){
        $classe = Classe::findOrFail($id);
        $classe->update([
            'statut'=>'lance',
        ]);
        return redirect()->route('classe.index')
                         ->withMessage( 'Classe validée avec succès.');
    }


    public function exportPdf(Classe $classe)
    {
        $anneeAcademiqueId = request('annee_academique_id');
    
        if (!$anneeAcademiqueId) {
            return redirect()->back()
                ->with('error', 'Veuillez sélectionner une année académique pour pouvoir exporter la liste.');
        }
    
        $inscriptions = Inscription::with(['apprenant', 'anneeAcademique'])
            ->where('classe_id', $classe->id)
            ->where('annee_academique_id', $anneeAcademiqueId)
            ->get();
    
        if ($inscriptions->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Aucun apprenant trouvé pour cette année académique.');
        }
    
        // On récupère l'année académique pour l'affichage dans le PDF
        $anneeAcademique = $inscriptions->first()->anneeAcademique;
    
        $pdf = PDF::loadView('classe.pdf', [
            'classe' => $classe,
            'inscriptions' => $inscriptions,
            'anneeAcademique' => $anneeAcademique,
        ]);
    
        $filename = 'Liste_apprenants_' . $classe->libelle . '_annee_' . $anneeAcademique->code . '.pdf';
    
        return $pdf->download($filename);
    }
    
  public function assignBOUBOONEBI($classeId)
    {
        $classe = Classe::with('etablissement')->findOrFail($classeId);
    
        // Récupération des personnels de l’établissement qui ont la fonction "formateur"
        $formateurs = PersonnelEtablissement::where('etablissement_id', $classe->etablissement_id)
            ->where('fonction', 'formateur')
            ->with('user')
            ->get();
    
        // Récupération des formateurs déjà assignés à cette classe
        $formateursAssignes = $classe->formateurs()->pluck('personnel_etablissement_id')->toArray();
    
        return view('classe.assign-formateurs', compact('classe', 'formateurs', 'formateursAssignes'));
    }

 public function assign($classeId)
    {
        $classe = Classe::with('etablissement')->findOrFail($classeId);
    
        // 🔹 On récupère les personnels (table personnel_etablissements)
        //    rattachés à l’établissement de la classe,
        //    dont l’utilisateur associé a le rôle "formateur"
        $formateurs = \App\Models\PersonnelEtablissement::where('etablissement_id', $classe->etablissement_id)
            ->whereHas('user.roles', function ($q) {
                $q->where('name', 'formateur');
            })
            ->with('user')
            ->get();
    
        // 🔹 ID des personnels déjà assignés à cette classe
        $formateursAssignes = $classe->formateurs()->pluck('personnel_etablissement_id')->toArray();
    
        return view('classe.assign-formateurs', compact('classe', 'formateurs', 'formateursAssignes'));
    }
    
    
    
    public function storeAssign(Request $request, $classeId)
    {
        $classe = Classe::findOrFail($classeId);
    
        $validated = $request->validate([
            'formateurs' => 'array|required',
            'formateurs.*' => 'exists:personnel_etablissements,id',
        ]);
    
        $classe->formateurs()->sync($validated['formateurs']); // met à jour la table formateur_etablissement
    
        return redirect()->route('classe.show', $classeId)
            ->with('message', 'Les formateurs ont été assignés avec succès.');
    }





}
