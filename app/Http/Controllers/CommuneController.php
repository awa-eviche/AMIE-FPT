<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commune;
use App\Models\Departement;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class CommuneController extends Controller
{
    protected $logUserRepository;
    public function __construct(
        LogUserRepository $logUserRepository
    ) {
        $this->logUserRepository = $logUserRepository;
    }
    public function index()
    {
        return view('communes.index');
    }

    public function create(Commune $commune)
    {
        $departements = Departement::all();
        return view('communes.create', compact('commune', 'departements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'=> 'required|string|max:191',
            'libelle' => 'required|string|max:191',
            'departement_id' => 'required|exists:departements,id',
        ]);
        $commune = Commune::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddCommune, 'model' => Model::Commune, 'new_object' => json_encode($commune)]);
        return redirect()->route('commune.index')
                         ->withMessage('Commune créée avec succès.');
    }

    public function show($id)
    {
        $commune = Commune::findOrFail($id);
        return view('communes.show', compact('commune'));
    }

    public function edit($id)
    {
        $commune = Commune::findOrFail($id);
        $departements = Departement::all();
        return view('communes.edit', compact('commune', 'departements'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'code'=> 'required|string|max:191',
            'libelle' => 'required|string|max:191',
            'departement_id' => 'required|exists:departements,id',
            
        ]);

        $commune = Commune::findOrFail($id);
        $commune->update($request->only(['code',"libelle",'departement_id']));

        return redirect()->route('commune.index')
                         ->withMessage('Commune mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $commune = Commune::findOrFail($id);
        $commune->update(['isDeleted' => true]);
        $this->logUserRepository->store([
            'action' => UserAction::DeleteCommune, 'model' => Model::Commune,
            'old_object' => json_encode($commune)
        ]);

        return redirect()->route('commune.index')
                         ->withMessage('Commune supprimée avec succès.');
    } 
}
