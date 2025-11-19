<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Classe;
use App\Models\Etablissement;
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
use App\Enums\Model;



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
        $anneeacademiques = AnneeAcademique::all();
        return view('classe.create', compact('niveaux','classes','metiers','etablissements','anneeacademiques'));
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
            'annee_academique_id' => 'required|string',
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
    public function show(Classe $classe)
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
            'annee_academique_id' => 'required|string',
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

}
