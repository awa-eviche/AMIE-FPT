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

    /**
     * Liste des classes (page d’index).
     */
    public function index()
    {
        return view('classe.index');
    }

    /**
     * Formulaire de création d’une classe.
     */
    public function create()
    {
        $idEtablissement = optional(auth()->user()->personnel)->etablissement_id;
        if ($idEtablissement === null) {
            return back()->withErrors('Il faut être associé à un établissement pour créer une classe');
        }

        $niveaux        = NiveauEtude::all();
        $classes        = Classe::all();
        $etablissements = Etablissement::all();
        $metiers        = Metier::all();

        return view('classe.create', compact('niveaux', 'classes', 'metiers', 'etablissements'));
    }

    /**
     * Enregistrement d’une nouvelle classe.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle'          => 'required|string|max:255',
            'modalite'         => 'required',
            'niveau_etude_id'  => 'required|string',
            'etablissement_id' => 'required|string',
  'classe_examen' => 'required|boolean',
        ]);

        // Si tu as d’autres colonnes (ex: is_examen), tu peux les ajouter ici.
        $classe = Classe::create($request->all());

        $this->logUserRepository->store([
            'action'     => UserAction::AddClasse,
            'model'      => Model::Classe,
            'new_object' => json_encode($classe),
        ]);

        return redirect()
            ->route('classe.index')
            ->withMessage('Classe créée avec succès.');
    }

    /**
     * Affichage d’une classe (ancienne route showboubakh).
     * Conserve une version simple (sans filtre année).
     */
    public function showboubakh(Classe $classe)
    {
        // Inscriptions
        $inscriptions = Inscription::where('classe_id', $classe->id)
            ->with('apprenant')
            ->paginate(10);

        // Conserver la classe dans la session (si utilisé ailleurs)
        session()->put('currentClasse', $classe->id);

        // Charger niveau_etude si nécessaire
        $classe->loadMissing('niveau_etude');

        // Matières / Compétences selon la modalité
        $matieres    = collect();
        $competences = collect();

        if ($classe->niveau_etude) {
            if ($classe->modalite === 'PPO') {
                $matieres = Matiere::where('niveau_etude_id', $classe->niveau_etude->id)->get();
            } elseif ($classe->modalite === 'APC') {
                $competences = Competence::where('niveau_etude_id', $classe->niveau_etude->id)->get();
            }
        }

        // Adapter si tu dois réellement combiner user/entreprise
        $usersWithEnterprises = [];
        foreach ($inscriptions as $inscription) {
            $usersWithEnterprises[] = ['user' => $inscription];
        }

        return view('classe.show', [
            'usersWithEnterprises' => $usersWithEnterprises,
            'matieres'             => $matieres,
            'competences'          => $competences,
            'classe'               => $classe,
            'inscriptions'         => $inscriptions,
            // Pas d’années ici (cette action reste minimaliste)
            'anneeAcademiques'       => collect(),
            'selectedAnneeAcademiqueId' => null,
        ]);
    }

    /**
     * Affichage d’une classe (version principale) avec filtre Année Académique.
     */
    public function show(Request $request, Classe $classe)
    {
        // 1) Années pour le select
        $anneeAcademiques = AnneeAcademique::orderByDesc('id')->get();

        // 2) Année sélectionnée (GET) ou 1ère par défaut
        $anneeAcademiqueId = $request->input('annee_academique_id') ?? $anneeAcademiques->first()?->id;

        // 3) Inscriptions filtrées par classe + année
        $inscriptions = Inscription::where('classe_id', $classe->id)
            ->when($anneeAcademiqueId, fn($q) => $q->where('annee_academique_id', $anneeAcademiqueId))
            ->with('apprenant')
            ->paginate(10)
            ->appends($request->only('annee_academique_id')); // conserve le filtre à la pagination

        // 4) Conserver la classe en session (si le reste du système l’utilise)
        session()->put('currentClasse', $classe->id);

        // 5) Charger niveau_etude si nécessaire
        $classe->loadMissing('niveau_etude');

        // 6) Matières / Compétences selon la modalité
        $matieres    = collect();
        $competences = collect();

        if ($classe->niveau_etude) {
            if ($classe->modalite === 'PPO') {
                $matieres = Matiere::where('niveau_etude_id', $classe->niveau_etude->id)->get();
            } elseif ($classe->modalite === 'APC') {
                $competences = Competence::where('niveau_etude_id', $classe->niveau_etude->id)->get();
            }
        }

        // 7) Préparer structure usersWithEnterprises (si besoin d’étendre après)
        $usersWithEnterprises = [];
        foreach ($inscriptions as $inscription) {
            $usersWithEnterprises[] = ['user' => $inscription];
        }

        // 8) Vue
        return view('classe.show', [
            'usersWithEnterprises'      => $usersWithEnterprises,
            'matieres'                  => $matieres,
            'competences'               => $competences,
            'classe'                    => $classe,
            'inscriptions'              => $inscriptions,
            'anneeAcademiques'          => $anneeAcademiques,
            'selectedAnneeAcademiqueId' => $anneeAcademiqueId,
        ]);
    }

    /**
     * Formulaire d’édition d’une classe.
     */
    public function edit(Classe $classe)
    {
        $niveaux         = NiveauEtude::all();
        $etablissements  = Etablissement::all();
        $metiers         = Metier::all();
        $anneeacademiques = AnneeAcademique::all();

        return view('classe.edit', compact('niveaux', 'classe', 'metiers', 'etablissements', 'anneeacademiques'));
    }

    /**
     * Mise à jour d’une classe.
     */
    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'libelle'          => 'required|string|max:255',
            'modalite'         => 'required',
            'niveau_etude_id'  => 'required|string',
            'etablissement_id' => 'required|string',
  'classe_examen' => 'required|boolean',
        ]);

        $classe->update($request->all());

        return redirect()
            ->route('classe.index')
            ->with('success', 'Classe mise à jour avec succès.');
    }

    /**
     * Suppression d’une classe.
     */
    public function destroy(Classe $classe)
    {
        $this->logUserRepository->store([
            'action'     => UserAction::DeleteClasse,
            'model'      => Model::Classe,
            'old_object' => json_encode($classe),
        ]);

        $classe->delete();

        return redirect()
            ->route('classe.index')
            ->withMessage('Classe supprimée avec succès.');
    }

    /**
     * Validation / lancement d’une classe.
     */
    public function validated($id)
    {
        $classe = Classe::findOrFail($id);
        $classe->update(['statut' => 'lance']);

        return redirect()
            ->route('classe.index')
            ->withMessage('Classe validée avec succès.');
    }
}
