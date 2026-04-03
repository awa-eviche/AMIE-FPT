<?php

namespace App\Http\Controllers;

use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RessourceController extends Controller
{
    /**
     * =========================
     * AJOUT RESSOURCE
     * =========================
     */


public function store(Request $request)
{
    $request->validate([
        'nom'           => 'required|string|max:255',
        'competence_id' => 'required|exists:competences,id',
        'classe_id'     => 'required|exists:classes,id',
    ]);

    $user = auth()->user();

    $nomOriginal = trim($request->nom);
    $nomLower    = Str::lower(trim($nomOriginal));

  
    $duplicateSame = Ressource::where('competence_id', $request->competence_id)
        ->where('classe_id', $request->classe_id)
        ->where('formateur_id', $user->id)
        ->whereRaw('LOWER(TRIM(nom)) = ?', [$nomLower])
        ->exists();

    if ($duplicateSame) {
        return back()->with('error', 'Vous avez déjà ajouté cette discipline pour cette compétence.');
    }

   
    $nameExistsInClass = Ressource::where('classe_id', $request->classe_id)
        ->whereRaw('LOWER(TRIM(nom)) = ?', [$nomLower])
        ->exists();

    if ($nameExistsInClass) {
        return back()->with('error', 'Cette discipline existe déjà dans cette classe.');
    }

    // ✅ Création
    Ressource::create([
        'nom'           => ucfirst($nomOriginal),
        'competence_id' => $request->competence_id,
        'classe_id'     => $request->classe_id,
        'formateur_id'  => $user->id,
    ]);

    return back()->with('success', 'Discipline enregistrée avec succès.');
}


    /**
     * =========================
     * MODIFICATION RESSOURCE
     * =========================
     */
    public function update(Request $request, Ressource $ressource)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        // 🔐 Sécurité : seul le propriétaire ou admin
        if (
            $user->hasRole('formateur') &&
            $ressource->formateur_id !== $user->id
        ) {
            abort(403);
        }

        $normalizedNom = Str::lower(Str::ascii(trim($request->nom)));

        // 🔒 Unicité du NOM dans la classe (hors ressource courante)
        $exists = Ressource::where('classe_id', $ressource->classe_id)
            ->whereRaw('LOWER(nom) = ?', [$normalizedNom])
            ->where('id', '!=', $ressource->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Cette discipline existe déjà dans cette classe.');
        }

        $ressource->update([
            'nom' => ucfirst(trim($request->nom)),
        ]);

        return back()->with('success', 'discipline mise à jour avec succès.');
    }

    /**
     * =========================
     * SUPPRESSION RESSOURCE
     * =========================
     */
    public function destroy($id)
    {
        $ressource = Ressource::findOrFail($id);
        $user = auth()->user();

        // 🔐 Sécurité : seul le propriétaire ou admin
        if (
            $user->hasRole('formateur') &&
            $ressource->formateur_id !== $user->id
        ) {
            abort(403);
        }

        $ressource->delete();

        return back()->with('success', 'discipline supprimée.');
    }
}
