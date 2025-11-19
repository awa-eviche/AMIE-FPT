<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ia;
use App\Models\Region;
use App\Models\Departement;
use Illuminate\Support\Facades\Log;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;




class IaController extends Controller
{
    
      protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
       
        $this->logUserRepository = $logUserRepository;
    }

    public function index()
    {
        return view('ia.index');
    }

    public function create(Ia $ia)
    {
        $departements = Departement::all();
        return view('ia.create', compact('departements'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nom' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'telephone' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'departements' => 'sometimes|array',

        ]);
       $ia =  Ia::create($request->all())->syncDepartements($request->departements);
        $this->logUserRepository->store(['action' => UserAction::AddIA, 'model' => Model::IA, 'new_object' => json_encode($ia)]);

        return redirect()->route('ia.index')
            ->withMessage('Ia créée avec succès.');
    }

    public function show($id)
    {
        $ia = Ia::findOrFail($id);
        return view('ia.show', compact('ia'));
    }

    public function edit($id)
    {
        $ia = Ia::findOrFail($id);
        $departements = Departement::all();
        // $regions = Region::all();
        return view('ia.edit', compact('ia', 'departements'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'nom' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'telephone' => 'required|string|max:191',
            'departements' => 'sometimes|array',
        ]);

        $ia = Ia::findOrFail($id);

        if ($ia) {
            $ia->syncDepartements($request->departements);
            $ia->update($request->only(['nom', 'email', 'telephone', 'adresse']));
        }

        return redirect()->route('ia.index')
            ->withMessage('Ia mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $ia = Ia::findOrFail($id);
        $ia->update(['isDeleted' => true]);

        $this->logUserRepository->store([
            'action' => UserAction::DeleteIA, 'model' => Model::IA,
            'old_object' => json_encode($ia)
        ]);

        return redirect()->route('ia.index')
            ->withMessage('Ia supprimée avec succès.');
    }
}
