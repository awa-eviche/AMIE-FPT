<?php

namespace App\Http\Controllers;
use App\Enums\MarriageStatus;
use App\Models\Apprenant;
use App\Models\Commune;
use Illuminate\Validation\Rule;
use App\Models\User;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeAccesApprenantGenerated;
use App\Models\Classe;
use App\Models\Pays;
use App\Models\Inscription;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;




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
            'email' => 'required|email|unique:apprenants,email',
            'commune_id'=> 'required',
            'nationalite'=> 'required',
            'sexe'=> 'required',
            'matricule'=> 'required',
            'telephone' => 
                'required',
                // 'regex:/^(77|76|78|75|70)[0-9]{7}$/',
            
        ]);

        $classe = $request->input('name');
        
        try {

            $apprenant = Apprenant::create($request->all());


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
                ->with('success', 'L\'inscription de l\'apprenant a été faite avec succès.');
    
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
			
            'date_naissance' => 'required | date',
            'lieu_naissance' => 'required',
			'sexe'=>'required',
            'matricule'=>'required',
            'commune_id'=> 'required',
            'nationalite'=> 'required',
			'email' => 'required',
			'telephone'=> 'required',
            
        ]);

        $apprenant = Apprenant::findOrFail($id);
        $apprenant->update($request->only('prenom','nom' , 'date_naissance' , 'lieu_naissance' ,'nomTuteur' , 'prenomTuteur' , 'numTelTuteur','nationalite',
            'situationMatrimoniale' ,'prenomPere' ,'nomPere','prenomMere', 'nomMere', 'email' ,'telephone','dateInsertion','autoEmploi','emploiSalarie'));
        
        return view('apprenant.show', compact('apprenant'))
        // return redirect()->route('apprenant.index')
        ->with('success', 'L\'apprenant a été mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $apprenant = Apprenant::findOrFail($id);
        $this->logUserRepository->store([
            'action' => UserAction::DeleteApprenant, 'model' => Model::Apprenant,
            'old_object' => json_encode($apprenant)
        ]);
        $apprenant->update(['isDeleted' => true]);

        return redirect()->route('apprenant.index')
                         ->with('success', 'L\'apprenant a été supprimé avec succès.');
    }
}