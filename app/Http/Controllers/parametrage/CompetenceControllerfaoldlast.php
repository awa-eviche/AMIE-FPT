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
use Illuminate\Support\Str;


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
        'nom' => [
            'required',
            'string',
            'max:255',
            function ($attribute, $value, $fail) use ($request) {
                $normalized = Str::of($value)
                    ->lower()
                    ->squish()
                    ->ascii()
                    ->value();

                $niveauIds = (array) $request->niveau_etude_id;

                foreach ($niveauIds as $niveauId) {
                    $niveau = NiveauEtude::find($niveauId);
                    if (!$niveau) {
                        $fail("Niveau d'étude invalide (id: $niveauId).");
                        continue;
                    }

                    $niveauNom = Str::of($niveau->nom)
                        ->lower()
                        ->squish()
                        ->ascii()
                        ->value();

                    $exists = Competence::where('niveau_etude_id', $niveauId)
                        ->get()
                        ->contains(function ($competence) use ($normalized) {
                            $existingNormalized = Str::of($competence->nom)
                                ->lower()
                                ->squish()
                                ->ascii()
                                ->value();
                            return $existingNormalized === $normalized;
                        });

                    if ($exists) {
                        $fail("La compétence '$value' existe déjà dans le niveau d'étude '{$niveau->nom}'.");
                    }
                }
            },
        ],
        'type' => 'required|in:generale,particuliere',
        'niveau_etude_id' => 'required|array',
        'niveau_etude_id.*' => 'exists:niveau_etudes,id', // ✅ correction ici
        'description' => 'required|string',
        'metier_id' => 'required|exists:metiers,id',
    ]);

    foreach ($request->niveau_etude_id as $niveauId) {
        Competence::create([
            'code' => $request->code,
            'nom' => $request->nom,
            'type' => $request->type,
            'description' => $request->description,
            'metier_id' => $request->metier_id,
            'niveau_etude_id' => $niveauId,
        ]);
    }

    return redirect()->route('competence.index')
        ->withMessage('Compétence créée avec succès pour les niveaux sélectionnés.');
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
