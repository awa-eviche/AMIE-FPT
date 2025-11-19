<?php

namespace App\Http\Controllers\parametrage;
use App\Http\Controllers\Controller;
use App\Models\ElementCompetence;
use App\Models\Competence;
use App\Models\NiveauEtude;
use App\Models\Metier;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Enums\Model;
use App\Repositories\LogUserRepository;

class ElementCompetenceController extends Controller
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
        $elementcompetences = ElementCompetence::all();
        $competences = Competence::all();
        $metiers= Metier::all();
        $niveau=NiveauEtude::all();
        return view('parametrage.elementcompetence.index', compact('elementcompetences','competences','metiers','niveau'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $elementcompetences = ElementCompetence::all();
        $competences = Competence::all();
        $metiers= Metier::all();
        $niveau=NiveauEtude::all();
        
        return view('parametrage.elementcompetence.create', compact('elementcompetences','competences','metiers','niveau'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'competence_id' => 'required|string',
            'description' => 'required|string',
            'metier_id' => 'required|string',
            'niveau_etude_id' => 'required|string',

        ]);

        
        $elementcompetence = ElementCompetence::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddElementCompetence, 'model' => Model::ElementCompetence, 'new_object' => json_encode($elementcompetence)]);


        return redirect()->route('elementcompetence.index')
                        
                         ->with('success', 'element de competence créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ElementCompetence $elementcompetence)
    {
        return view('parametrage.elementcompetence.show', compact('elementcompetence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ElementCompetence $elementcompetence)
    {
        $competences = Competence::all();
        $metiers = Metier::all();
        return view('parametrage.elementcompetence.edit', compact('competences','elementcompetence','metiers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ElementCompetence $elementcompetence)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'competence_id' => 'required|string',
            'metier_id' => 'required|string',
            'description' => 'required|string',
        ]);

        $elementcompetence->update($request->all());

        return redirect()->route('elementcompetence.index')
                         ->with('success', 'Element de competence  mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ElementCompetence $elementcompetence)
    {
          //Logs
          $this->logUserRepository->store([
            'action' => UserAction::DeleteElementCompetence, 'model' => Model::ElementCompetence,
            'old_object' => json_encode($elementcompetence)
        ]);
        $elementcompetence->delete();

        return redirect()->route('elementcompetence.index')
                         ->with('success', 'Element de competence supprimé avec succès.');
    }
}
