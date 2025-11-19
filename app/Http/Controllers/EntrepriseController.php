<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class EntrepriseController extends Controller
{
    protected $logUserRepository;
 
    public function __construct(
          LogUserRepository $logUserRepository
      ) {
          $this->logUserRepository = $logUserRepository;
      }
  
    public function index()
    {
        return view('entreprises.index');
    }

    public function show($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        return view('entreprises.show', compact('entreprise'));
    }

    public function edit($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        return view('entreprises.edit', compact('entreprise'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:191',
            'ninea' => 'required|string|max:191',
            'effectif' => 'required|integer',
            'email_entreprise' => 'required|email',
            // 'est_actif' => 'required|boolean',
            'date_creation' => 'required|date',
        ]);

        $entreprise = Entreprise::findOrFail($id);
        $entreprise->update($request->only(['nom_entreprise', 'ninea', 'effectif', 'email_entreprise', 'date_creation']));

        $entreprise->user->update($request->only(['telephone', "nom", "prenom", "email", "date_naissance", "lieu_naissance", "adresse", "telephone" ]));

        return redirect()->route('entreprise.index')
                         ->with('success', 'Entreprise mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        $entreprise->delete();

        return redirect()->route('entreprise.index')
                         ->with('success', 'Entreprise supprimée avec succès.');
    }
}
