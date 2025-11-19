<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Liste;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class ListeController extends Controller
{
    protected $logUserRepository;
 
  public function __construct(
        LogUserRepository $logUserRepository
    ) {
        $this->logUserRepository = $logUserRepository;
    }
    public function index()
    {
        return view('listes.index');
    }

    public function create(Liste $liste)
    {

        return view('listes.create', compact('liste'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle'=> 'required|string|max:191',
            'valeur' => 'required|string|max:191',
            'description' => 'required|string|max:2000',
        ]);
            $liste = liste::create($request->all());
            $this->logUserRepository->store(['action' => UserAction::AddListe, 'model' => Model::Liste, 'new_object' => json_encode($liste)]);

        return redirect()->route('liste.index')
                         ->withMessage('Région créée avec succès.');
    }

    public function show($id)
    {
        $liste = Liste::findOrFail($id);
        return view('listes.show', compact('liste'));
    }

    public function edit($id)
    {
        $liste = Liste::findOrFail($id);
        return view('listes.edit', compact('liste'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'libelle'=> 'required|string|max:191',
            'valeur' => 'required|string|max:191',
            'description' => 'required|string|max:2000',
            
        ]);

        $liste = Liste::findOrFail($id);
        $liste->update($request->only(["libelle","valeur","description"]));

        return redirect()->route('liste.index')
                         ->withMessage('Région mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $liste = Liste::findOrFail($id);
        $liste->update(['isDeleted' => true]);
        $this->logUserRepository->store([
            'action' => UserAction::DeleteListe, 'model' => Model::Liste,
            'old_object' => json_encode($liste)
        ]);

        return redirect()->route('liste.index')
                         ->withMessage('Région supprimée avec succès.');
    } 
}
