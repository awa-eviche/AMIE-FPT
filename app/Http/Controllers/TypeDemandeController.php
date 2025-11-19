<?php

namespace App\Http\Controllers;

use App\Models\TypeDemande;
use App\Models\Workflow;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class TypeDemandeController extends Controller
{
    protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository) {$this->logUserRepository = $logUserRepository;}

    public function index()
    {
        $typeDemandes = TypeDemande::all();
        return view('parametrage.type_demande.index', compact('typeDemandes'));
    }

    public function create()
    {

        return view('parametrage.type_demande.create',[
            "typeDemandeParents"=>TypeDemande::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
            'code' => 'required',
            'description' => 'required',
        ]);

        $typeDemande = new TypeDemande();

        $typeDemande->libelle = $request->input('libelle');
        $typeDemande->code = $request->input('code');
        $typeDemande->description = $request->input('description');
        $typeDemande->type_demande_id = $request->input('type_demande_id') == 0 ? null : $request->input('type_demande_id');

        $typeDemande->save();


        return redirect()->route('type_demande.index')
            ->withMessage('Type de demande créé avec succès.');
    }

    // Affiche les détails d'un type de demande
    public function show(TypeDemande $typeDemande)
    {
        return view('parametrage.type_demande.show', compact('typeDemande'));
    }

    // Affiche le formulaire de modification d'un type de demande
    public function edit(TypeDemande $typeDemande)
    {
        $typeDemandeParents = TypeDemande::all();
        return view('parametrage.type_demande.edit', compact('typeDemande', "typeDemandeParents"));
    }

    // Met à jour un type de demande dans la base de données
    public function update(Request $request, TypeDemande $typeDemande)
    {
        $request->validate([
            'libelle' => 'required',
            'code' => 'required',
            'description' => 'required',
        ]);

        $typeDemande->libelle = $request->input('libelle');
        $typeDemande->code = $request->input('code');
        $typeDemande->description = $request->input('description');
        if($request->input('type_demande_id') == -1){
            $typeDemande->type_demande_id = null;
        }else if($request->input('type_demande_id') != 0){
            $typeDemande->type_demande_id = $request->input('type_demande_id');
        }

        $typeDemande->save();

        return redirect()->route('type_demande.index')
            ->withMessage('Type de demande mis à jour avec succès.');
    }

    // Supprime un type de demande de la base de données
    public function destroy(TypeDemande $typeDemande)
    {
        $typeDemande->delete();

        return redirect()->route('type_demande.index')
            ->withMessage('Type de demande supprimé avec succès.');
    }
}
