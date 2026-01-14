<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DroitInscriptionController extends Controller
{
    /**
     * Liste des droits d’inscription
     */
    public function index()
    {
        $droits = DroitInscription::with('inscription')->get();

        return response()->json($droits);
    }

    /**
     * Formulaire de création (si web)
     */
    public function create()
    {
        $inscriptions = Inscription::all();
        return view('droit_inscription.create', compact('inscriptions'));
    }

    /**
     * Enregistrer un droit d’inscription
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'montant'        => 'required|integer|min:0',
            'statut'         => 'nullable|boolean',
        ]);

        $droit = DroitInscription::create([
            'inscription_id' => $validated['inscription_id'],
            'montant'        => $validated['montant'],
            'statut'         => $validated['statut'] ?? false,
        ]);

        return response()->json([
            'message' => 'Droit d’inscription créé avec succès',
            'data'    => $droit
        ], 201);
    }

    /**
     * Afficher un droit d’inscription
     */
    public function show($id)
    {
        $droit = DroitInscription::with('inscription')->findOrFail($id);

        return response()->json($droit);
    }

    /**
     * Formulaire d’édition (si web)
     */
    public function edit($id)
    {
        $droit = DroitInscription::findOrFail($id);
        $inscriptions = Inscription::all();

        return view('droit_inscription.edit', compact('droit', 'inscriptions'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, $id)
    {
        $droit = DroitInscription::findOrFail($id);

        $validated = $request->validate([
            'montant' => 'required|integer|min:0',
            'statut'  => 'required|boolean',
        ]);

        $droit->update($validated);

        return response()->json([
            'message' => 'Droit d’inscription mis à jour',
            'data'    => $droit
        ]);
    }

    /**
     * Suppression
     */
    public function destroy($id)
    {
        $droit = DroitInscription::findOrFail($id);
        $droit->delete();

        return response()->json([
            'message' => 'Droit d’inscription supprimé'
        ]);
    }
}

