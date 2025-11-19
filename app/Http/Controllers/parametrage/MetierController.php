<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Metier;
use App\Models\Filiere;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;

use Illuminate\Http\Request;


class MetierController extends Controller
{
    protected $logUserRepository;
    public function __construct(
        LogUserRepository $logUserRepository
    ) {
        $this->middleware('auth');
 //       $this->middleware('permission:gerer_permission');
   //     $this->middleware(['role:superadmin|admin']);
        $this->logUserRepository = $logUserRepository;
    }


    public function index()
    {
        $metiers = Metier::all();
        $filieres = Filiere::all();

        return view('parametrage.metier.index', compact('metiers', 'filieres'));
    }

    public function create()
    {
        $metiers = Metier::all();
        $filieres = Filiere::all();

        return view('parametrage.metier.create', compact('filieres', 'metiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'filiere_id' => 'required|string',

            'description' => 'required|string',

        ]);


        $metier = Metier::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddMetier, 'model' => Model::Metier, 'new_object' => json_encode($metier)]);


        return redirect()->route('metier.index')

            ->with('success', 'metier créé avec succès.');
    }

    public function show(Metier $metier)
    {
        return view('parametrage.metier.show', compact('metier'));
    }

    public function edit(Metier $metier)
    {

        $filieres = Filiere::all();

        return view('parametrage.metier.edit', compact('metier', 'filieres'));
    }

    public function update(Request $request, Metier $metier)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'filiere_id' => 'required|string',

            'description' => 'required|string',

  'modalite' => 'required|in:APC,PPO',
            'statut_programme' => 'required|in:achevé,révisé',
        ]);

        $metier->update($request->all());

        return redirect()->route('metier.index')
            ->withMessage('Metier mis à jour avec succès.');
    }

    public function destroy(Metier $metier)
    {

          //Logs
          $this->logUserRepository->store([
            'action' => UserAction::DeleteMetier, 'model' => Model::Metier,
            'old_object' => json_encode($metier)
        ]);
        $metier->delete();

        return redirect()->route('metier.index')
            ->withMessage('Metier supprimé avec succès.');
    }
}
