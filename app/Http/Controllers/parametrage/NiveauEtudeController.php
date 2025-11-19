<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Metier;
use App\Models\Diplome;
use App\Models\NiveauEtude;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class NiveauEtudeController extends Controller
{
    protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
//        $this->middleware('permission:gerer_permission');
 //       $this->middleware(['role:superadmin|admin']);
        $this->logUserRepository = $logUserRepository;
    }


    public function index()
    {
        $niveauetudes = NiveauEtude::all();
        $metiers = Metier::all();
        $diplomes = Diplome::all();
        return view('parametrage.niveauetude.index', compact('niveauetudes', 'metiers', 'diplomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niveauetudes = NiveauEtude::all();
        $metiers = Metier::all();
        $diplomes = Diplome::all();
        return view('parametrage.niveauetude.create', compact('niveauetudes', 'metiers', 'diplomes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'metier_id' => 'required|string',
            'diplome_id' => 'required|string',
            'description' => 'required|string',

        ]);

        if ($request->annee !== null) {
            $request->merge(['nom' => $request->nom . '' . $request->annee]);
        }


        $niveauetude = NiveauEtude::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddNiveauEtude, 'model' => Model::NiveauEtude, 'new_object' => json_encode($niveauetude)]);


        return redirect()->route('niveauetude.index')

            ->withMessage('Niveau créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NiveauEtude $niveauetude)
    {
        return view('parametrage.niveauetude.show', compact('niveauetude'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NiveauEtude $niveauetude)
    {

        $metier = Metier::all();
        $diplomes = Diplome::all();
        return view('parametrage.niveauetude.edit', compact('niveauetude', 'metier', 'diplomes'));
    }

    public function update(Request $request, NiveauEtude $niveauetude)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'metier_id' => 'required|string',
            'diplome_id' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($request->annee !== null) {
            $request->merge(['nom' => $request->nom . '' . $request->annee]);
        }
        $niveauetude->update($request->all());

        return redirect()->route('niveauetude.index')
            ->withMessage('Niveau étude mis à jour avec succès.');
    }

    public function destroy(NiveauEtude $niveauetude)
    {

              //Logs
              $this->logUserRepository->store([
                'action' => UserAction::DeleteNiveauEtude, 'model' => Model::NiveauEtude,
                'old_object' => json_encode($niveauetude)
            ]);
        $niveauetude->delete();

        return redirect()->route('niveauetude.index')
            ->withMessage('Niveau supprimé avec succès.');
    }
}
