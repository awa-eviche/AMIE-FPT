<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Diplome;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Enums\Model;
use App\Repositories\LogUserRepository;



class DiplomeController extends Controller
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
        $diplomes = Diplome::all();
        return view('parametrage.diplome.index', compact('diplomes'));
    }

    public function create()
    {
        $diplomes = Diplome::all();
        return view('parametrage.diplome.create', compact('diplomes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|unique:diplomes,nom|max:255',
            'description' => 'required|string',

        ]);

        
        $diplome = Diplome::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddDiplome, 'model' => Model::Diplome, 'new_object' => json_encode($diplome)]);


        return redirect()->route('diplome.index')
                        
                         ->with('success', 'diplome créé avec succès.');
    }

    public function show(Diplome $diplome)
    {
        return view('parametrage.diplome.show', compact('diplome'));
    }

    public function edit(Diplome $diplome)
    {
        
  
        return view('parametrage.diplome.edit', compact('diplome'));
    }

    public function update(Request $request, Diplome $diplome)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $diplome->update($request->all());

        return redirect()->route('diplome.index')
                         ->with('success', 'diplome mis à jour avec succès.');
    }

    public function destroy(Diplome $diplome)
    {
          //Logs
          $this->logUserRepository->store([
            'action' => UserAction::DeleteDiplome, 'model' => Model::Diplome,
            'old_object' => json_encode($diplome)
        ]);
        $diplome->delete();

        return redirect()->route('diplome.index')
                         ->with('success', 'Diplome supprimé avec succès.');
    }
}
