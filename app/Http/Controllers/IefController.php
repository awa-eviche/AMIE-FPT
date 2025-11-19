<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Models\Ief;
use App\Models\Ia;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class IefController extends Controller
{
    protected $logUserRepository;
 
  
    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
       
        $this->logUserRepository = $logUserRepository;
    }

    public function index()
    {
        return view('ief.index');
    }

    public function create(Ief $ief)
    {
       
        $ias = Ia::all();
        $communes = Commune::all();
        return view('ief.create', compact('ief','ias', 'communes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'=> 'required|string|max:191',
            'email' => 'required|email|max:191',
            'telephone' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'ia_id' => 'required|exists:ias,id',
            'communes' => 'sometimes|array',
        ]);
           $ief =  Ief::create($request->all())->syncCommunes($request->communes);
           $this->logUserRepository->store(['action' => UserAction::AddIEF, 'model' => Model::IEF, 'new_object' => json_encode($ief)]);

        return redirect()->route('ief.index')
                         ->withMessage('IEF créée avec succès.');
    }

    public function show($id)
    {
        $ief = Ief::findOrFail($id);
        $communes = Commune::all();
        return view('ief.show', compact('ief', 'communes'));
    }

    public function edit($id)
    {
        $ief = ief::findOrFail($id);
        $ias = Ia::all();
        $communes = Commune::all();
        return view('ief.edit', compact('ief','ias', 'communes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'nom'=> 'required|string|max:191',
            'email' => 'required|email|max:191',
            'telephone' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'ia_id' => 'required|exists:ias,id',
            'communes' => 'sometimes|array',
        ]);

       

        $ief = Ief::findOrFail($id);

        if ($ief) {
            $ief->syncCommunes($request->communes);
            $ief->update($request->only(['nom','email','telephone','adresse', 'ia_id']));
        }

        return redirect()->route('ief.index')
                         ->withMessage('Ief mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $ief = ief::findOrFail($id);
        $ief->update(['isDeleted' => true]);
        $this->logUserRepository->store([
            'action' => UserAction::DeleteIEF, 'model' => Model::IEF,
            'old_object' => json_encode($ief)
        ]);

        return redirect()->route('ief.index')
                         ->withMessage('Ief supprimée avec succès.');
    } 
}
