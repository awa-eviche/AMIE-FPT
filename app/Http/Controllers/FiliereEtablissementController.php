<?php

namespace App\Http\Controllers;

use App\Models\FiliereEtablissement;
use Illuminate\Http\Request;

use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\NiveauEtude;
use Illuminate\Support\Facades\Log;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;







class FiliereEtablissementController extends Controller
{
    protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
        $this->middleware('permission:visualiser_mes_filieres');
        $this->logUserRepository = $logUserRepository;
    
    }

    
    public function index()
    {
        $filiereetablissements = [];
        if(auth()->user()->can('visualiser_mes_filieres') || auth()->user()->can('edit_mes_filieres'))
        {
            if(auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
                $idEtablissement = auth()->user()->personnel->etablissement_id ;
                $filiereetablissements = FiliereEtablissement::where('etablissement_id','=', 2)->get();
            }
        }
        return view('filiereetablissement.index', compact('filiereetablissements'));
    }

   public function create()
    {
        $filiereetablissements = FiliereEtablissement::all();
        $etablissements = Etablissement::all();
        $filieres = Filiere::all();
        
        return view('filiereetablissement.create', compact('etablissements','filieres','filiereetablissements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'etablissement_id' => 'required|exists:etablissements,id',
            'filiere_id' => 'required|exists:filieres,id',
        ]);
   
        $existingEntry = FiliereEtablissement::where('etablissement_id', $request->etablissement_id)
                                              ->where('filiere_id', $request->filiere_id)
                                              ->exists();
    
        if ($existingEntry) {
            return redirect()->route('filiereetablissement.index')
            ->withMessage('Vous avez déjà choisi cette filière.');
        }
    
        $filiereetablissement = FiliereEtablissement::create([
            'etablissement_id' => $request->etablissement_id,
            'filiere_id' => $request->filiere_id,
        ]);

        $this->logUserRepository->store(['action' => UserAction::AddFiliereEtablissement, 'model' => Model::FiliereEtablissement, 'new_object' => json_encode($filiereetablissement)]);

    
        return redirect()->route('filiereetablissement.index')->with('success', 'Association ajoutée avec succès.');
    }

    
    
    public function show(FiliereEtablissement $filiereetablissement)
    {
        // Récupération de la filière associée à cet enregistrement de FiliereEtablissement
        $filiere = $filiereetablissement->filiere;
        $startLimit = 0;
        $count=0;
    
        // Récupération des métiers associés à la filière choisie
        $metiers = Metier::whereHas('filiere', function ($query) use ($filiere) {
            $query->where('id', $filiere->id);
        })->get();
    
        // Passez les données à la vue pour l'affichage
        return view('filiereetablissement.show', compact('filiereetablissement', 'metiers','startLimit','count'));
    }
    
    public function edit(FiliereEtablissement $filiereetablissement)
    {
        $etablissements = Etablissement::all();
        $filieres = Filiere::all();

       
        return view('filiereetablissement.edit', compact('etablissements','filieres','filiereetablissements'));
    }

    public function update(Request $request, FiliereEtablissement $filiereetablissement)
    {
        $request->validate([
            'etablissement_id' => 'required|string|max:25',
            'filiere_id' => 'required|string',
        ]);

        $filiereetablissement->update($request->all());

        return redirect()->route('filiereetablissement.index')
                         ->withMessage('Filière mise à jour avec succès.');
    }

    public function destroy(FiliereEtablissement $filiereetablissement)
    {
        $this->logUserRepository->store([
            'action' => UserAction::DeleteFiliereEtablissement, 'model' => Model::FiliereEtablissement,
            'old_object' => json_encode($filiereetablissement)
        ]);
        $filiereetablissement->delete();

        return redirect()->route('filiereetablissement.index')
                         ->withMessage('Filière supprimée avec succès.');
    }
}