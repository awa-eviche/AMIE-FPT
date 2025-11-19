<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\NiveauEtude;
use App\Models\Metier;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;



class CompetenceController extends Controller
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
        $competences = Competence::all();
        $metiers= Metier::all();
        return view('parametrage.competence.index', compact('niveaux','competences','metiers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niveaux = NiveauEtude::all();
        $competences = Competence::all();
        $metiers= Metier::all();
        return view('parametrage.competence.create', compact('niveaux','competences','metiers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'type' => 'required|in:generale,particuliere',
         
            'niveau_etude_id' => 'required|string',
            'description' => 'required|string',
            'metier_id' => 'required|string',

        ]);

        
        $competence = Competence::create($request->all());
       // $this->logUserRepository->store(['action' => UserAction::AddCompetence, 'model' => Model::Competence, 'new_object' => json_encode($competence)]);


        return redirect()->route('competence.index')
                        
                         ->withMessage('Compétence créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Competence $competence)
    {
        return view('parametrage.competence.show', compact('competence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competence $competence)
    {
        
        $niveaux = NiveauEtude::all();
        $metiers = Metier::all();
        return view('parametrage.competence.edit', compact('niveaux','competence','metiers'));
    }

    public function update(Request $request, Competence $competence)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
        
            'niveau_etude_id' => 'required|string',
            'metier_id' => 'required|string',
            'description' => 'required|string',
        ]);

        $competence->update($request->all());

        return redirect()->route('competence.index')
                         ->withMessage('Competence mis à jour avec succès.');
    }

    public function destroy(Competence $competence)
    {
          //Logs
      //    $this->logUserRepository->store([
        //    'action' => UserAction::DeleteCompetence, 'model' => Model::Competence,
          //  'old_object' => json_encode($competence)
       // ]);
        $competence->delete();

        return redirect()->route('competence.index')
                         ->withMessage('Competence supprimé avec succès.');
    }

    function manage()
    {
        return view('competences.manage');
    }

}
