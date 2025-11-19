<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Secteur;
use Illuminate\Http\Request;

class SecteurController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
       // $this->middleware('permission:gerer_permission');
       // $this->middleware(['role:superadmin|admin']);
    }

    
    public function index()
    {
        $secteurs = Secteur::all();
        return view('parametrage.secteurs.index', compact('secteurs'));
    }

    public function create()
    {
        return view('parametrage.secteurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'libelle' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $secteur = Secteur::create($request->all());

        return redirect()->route('secteur.index')
                         ->withMessage('Secteur créé avec succès.');
    }

    public function show(Secteur $secteur)
    {
        return view('parametrage.secteurs.show', compact('secteur'));
    }

    public function edit(Secteur $secteur)
    {
        return view('parametrage.secteurs.edit', compact('secteur'));
    }

    public function update(Request $request, Secteur $secteur)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'libelle' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $secteur->update($request->all());

        return redirect()->route('secteur.index')
                         ->withMessage('Secteur mis à jour avec succès.');
    }

    public function destroy(Secteur $secteur)
    {
        $secteur->delete();

        return redirect()->route('secteur.index')
                         ->withMessage('Secteur supprimé avec succès.');
    }
}
