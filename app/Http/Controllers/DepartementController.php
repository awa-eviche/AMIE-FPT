<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Region;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class DepartementController extends Controller
{
    protected $logUserRepository;
 
  public function __construct(
        LogUserRepository $logUserRepository
    ) {
        $this->logUserRepository = $logUserRepository;
    }
    public function index()
    {
        return view('departements.index');
    }

    public function create(Departement $departement)
    {
        $regions = Region::all();

        return view('departements.create', compact('departement','regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'=> 'required|string|max:191',
            'libelle' => 'required|string|max:191',
            'region_id' => 'required|exists:regions,id',
        ]);
        Departement::create([
            'code' => $request->code,
            'libelle' => $request->libelle,
            'region_id' => $request->region_id,
        ]);
        $lastDep = Departement::where('code', $request->code)->first();
        if ($lastDep) {
            if (Region::where('id', $request->region_id)->exists()) {
                $lastDep->region_id = $request->region_id;
                $lastDep->save();
                $this->logUserRepository->store(['action' => UserAction::AddDepartement, 'model' => Model::Departement, 'new_object' => json_encode($lastDep)]);
                return redirect()->route('departement.index')
                         ->withMessage('Département créé avec succès.');
            } else {
                return redirect()->route('departement.index')
                         ->withMessage('Département sélectionné n\'existe pas.');
            }
        } else {
            return redirect()->route('departement.index')
                         ->withMessage('Aucun enregistrement n\'a été effectué.');
        }
    }

    public function show($id)
    {
        $departement = Departement::findOrFail($id);
        return view('departements.show', compact('departement'));
    }

    public function edit($id)
    {
        $departement = Departement::findOrFail($id);
        $regions = Region::all();
        return view('departements.edit', compact('departement', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'code'=> 'required|string|max:191',
            'libelle' => 'required|string|max:191',
            'region_id' => 'required|exists:regions,id',
            
        ]);
        

        $departement = Departement::findOrFail($id);
        $departement->update($request->only(['code',"libelle","region_id"]));

        return redirect()->route('departement.index')
                         ->withMessage('Département mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $departement = Departement::findOrFail($id);
        $departement->update(['isDeleted' => true]);
        $this->logUserRepository->store([
            'action' => UserAction::DeleteDepartement, 'model' => Model::Departement,
            'old_object' => json_encode($departement)
        ]);

        return redirect()->route('departement.index')
                         ->withMessage('Département supprimé avec succès.');
    }
}
