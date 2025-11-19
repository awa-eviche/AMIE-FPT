<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use App\Models\NiveauEtude;
use App\Models\Metier;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;



class MatiereController extends Controller
{
    protected $logUserRepository;
     public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
//        $this->middleware('permission:gerer_permission');
  //      $this->middleware(['role:superadmin|admin']);
        $this->logUserRepository = $logUserRepository;
    }

    
    public function index()
    {
        $niveaux = NiveauEtude::all();
        $matieres = Matiere::all();
        $metiers= Metier::all();
        return view('parametrage.matiere.index', compact('niveaux','matieres','metiers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niveaux = NiveauEtude::all();
        $matieres = Matiere::all();
        $metiers= Metier::all();
        return view('parametrage.matiere.create', compact('niveaux','matieres','metiers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'coef' => str_replace(',', '.', $request->coef)
        ]);
    
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'coef' => 'required|regex:/^\d+([,.]\d{1,2})?$/', // autorise 1, 1.5, 2,75
            'niveau_etude_id' => 'required|string',
            'description' => 'required|string',
            'metier_id' => 'required|string',
        ]);
    
        $matiere = Matiere::create($request->all());
    
        $this->logUserRepository->store([
            'action' => UserAction::AddMatiere,
            'model' => Model::Matiere,
            'new_object' => json_encode($matiere)
        ]);
    
        return redirect()->route('matiere.index')
                         ->withMessage('Matière créée avec succès.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Matiere $matiere)
    {
        return view('parametrage.matiere.show', compact('matiere'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matiere $matiere)
    {
        
        $niveaux = NiveauEtude::all();
        $metiers = Metier::all();
        return view('parametrage.matiere.edit', compact('niveaux','matiere','metiers'));
    }

    
public function update(Request $request, Matiere $matiere)
{
    $request->merge([
        'coef' => str_replace(',', '.', $request->coef)
    ]);

    $request->validate([
        'code' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'coef' => 'required|regex:/^\d+([,.]\d{1,2})?$/',
        'niveau_etude_id' => 'required|string',
        'metier_id' => 'required|string',
        'description' => 'required|string',
    ]);

    $matiere->update($request->all());

    return redirect()->route('matiere.index')
                     ->withMessage('Matière mise à jour avec succès.');
}
    public function destroy(Matiere $matiere)
    {
          //Logs
          $this->logUserRepository->store([
            'action' => UserAction::DeleteMatiere, 'model' => Model::Matiere,
            'old_object' => json_encode($matiere)
        ]);
        $matiere->delete();

        return redirect()->route('matiere.index')
                         ->withMessage('Matiere supprimé avec succès.');
    }
}
