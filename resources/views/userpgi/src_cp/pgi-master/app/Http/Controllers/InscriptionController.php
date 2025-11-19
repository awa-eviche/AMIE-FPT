<?php

namespace App\Http\Controllers;


use App\Models\Inscription;
use App\Models\Classe;
use App\Models\Apprenant;
use App\Models\Etablissement;
use App\Models\Matiere;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class InscriptionController extends Controller
{
    protected $logUserRepository;

    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
        $this->logUserRepository = $logUserRepository;
        //  $this->middleware('permission:visualiser_inscription');

    }

    public function index()
    {
        // Récupérer le nom de l'utilisateur
        $userName = auth()->user()->nom;

        // Récupérer l'établissement correspondant au nom de l'utilisateur
        // $etablissement = Etablissement::where('nom', $userName)->first();

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            $etablissementId = auth()->user()->personnel->etablissement_id;

            // Vérifier si l'établissement est valide
            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }

            // Récupérer les IDs des classes associées à l'établissement actuel
            $classesIds = Classe::where('etablissement_id', $etablissementId)->pluck('id');
        } else {
            // Récupérer les IDs des classes de toutes les classes
            $classesIds = Classe::all()->pluck('id');
        }
        // Récupérer les IDs des apprenants associés à ces classes
        $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');

        $classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $currentClasse = $classe ? Classe::find($classe) : null;
        $classes = [$currentClasse];
        $matieres = $classe ? Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get() : [];

        // Récupérer les apprenants associés à ces IDs
        $apprenants = Apprenant::whereIn('id', $apprenantsIds)->get();

        return view('inscription.index', compact('apprenants', 'matieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer le nom de l'utilisateur
        $userName = auth()->user()->nom;

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            // Récupérer l'établissement correspondant au nom de l'utilisateur
            // $etablissement = Etablissement::where('nom', $userName)->first();
            $etablissementId = auth()->user()->personnel->etablissement_id;

            // Vérifiez si l'établissement est valide
            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }
            // Récupérer les classes associées à l'établissement actuel
            $classes = Classe::where('etablissement_id', $etablissementId)->get();

            // Récupérer les apprenants associés à l'établissement actuel
            $apprenants = Apprenant::where('etablissement_id', $etablissementId)->get();
        } else {
            // Récupérer toutes les classes 
            $classes = Classe::all();
            $classesIds = Classe::all()->pluck('id');

            // Récupérer les apprenants associés à l'établissement actuel
            $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');
            $apprenants = Apprenant::whereIn('apprenant_id', $apprenantsIds)->get();
        }

        return view('inscription.create', compact('classes', 'apprenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',



        ]);


        $inscription = Inscription::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddInscription, 'model' => Model::Inscription, 'new_object' => json_encode($inscription)]);


        return redirect()->route('inscription.index')

            ->with('success', 'inscription créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inscription $inscription)
    {
        $classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $currentClasse = $classe ? Classe::find($classe) : null;
        $classes = [$currentClasse];
        $apprenants = $classe ? Inscription::where('classe_id', session()->get('currentClasse'))->get() : [];
        $matieres = $classe ? Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get() : [];

        return view('inscription.show', [
            "inscription" => $inscription,
            "apprenants" => $apprenants,
            "classe" => $classe,
            'classes' => $classes,
            'matieres' => $matieres,
            'currentClasse' => $currentClasse,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscription $inscription)
    {

        $classes = Classe::all();
        $apprenants = Apprenant::all();
        return view('inscription.edit', compact('inscription', 'classes', 'apprenants'));
    }


    public function update(Request $request, Inscription $inscription)
    {
        $request->validate([
            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',

        ]);

        $inscription->update($request->all());

        return redirect()->route('inscription.index')
            ->with('success', 'inscription mis à jour avec succès.');
    }

    public function destroy(Inscription $inscription)
    {

        $this->logUserRepository->store([
            'action' => UserAction::DeleteInscription, 'model' => Model::Inscription,
            'old_object' => json_encode($inscription)
        ]);
        $inscription->delete();

        return redirect()->route('inscription.index')
            ->with('success', 'inscription supprimé avec succès.');
    }
}
