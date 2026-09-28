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
        'annee_academique_id' => 'nullable|exists:annee_academiques,id',
    ]);

    $user = auth()->user();

    $nomOriginal = trim($request->nom);
    $nomLower    = Str::lower(trim($nomOriginal));

    // Les ressources sont propres à une année académique (comme les affectations).
    $annee = \App\Services\AnneeDesNotes::courante($request);
    $parAnnee = fn ($q) => $q->when(\App\Services\AnneeDesNotes::aUneColonne('ressources'),
        fn ($q) => $q->where('annee_academique_id', $annee));


    $duplicateSame = Ressource::where('competence_id', $request->competence_id)
        ->where('classe_id', $request->classe_id)
        ->where('formateur_id', $user->id)
        ->whereRaw('LOWER(TRIM(nom)) = ?', [$nomLower])
        ->tap($parAnnee)
        ->exists();

    // Les doublons ne comptent que dans la même année : la discipline peut exister pour une autre année.
    $codeAnnee = \App\Models\AnneeAcademique::whereKey($annee)->value('code');
    $enAnnee = $codeAnnee ? " pour l'année $codeAnnee" : '';

    if ($duplicateSame) {
        return back()->with('error', "Vous avez déjà ajouté cette discipline pour cette compétence$enAnnee.");
    }

   
    $nameExistsInClass = Ressource::where('classe_id', $request->classe_id)
        ->whereRaw('LOWER(TRIM(nom)) = ?', [$nomLower])
        ->tap($parAnnee)
        ->exists();

    if ($nameExistsInClass) {
        return back()->with('error', "Cette discipline existe déjà dans cette classe$enAnnee.");
    }

    // ✅ Création
    Ressource::create([
        'nom'           => ucfirst($nomOriginal),
        'competence_id' => $request->competence_id,
        'classe_id'     => $request->classe_id,
        'formateur_id'  => $user->id,
    ] + \App\Services\AnneeDesNotes::attributs('ressources', $annee));

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
        // Unicité dans la même année académique uniquement (la même discipline peut exister d'une année à l'autre).
        $exists = Ressource::where('classe_id', $ressource->classe_id)
            ->whereRaw('LOWER(nom) = ?', [$normalizedNom])
            ->where('id', '!=', $ressource->id)
            ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $ressource->annee_academique_id,
                fn ($q) => $q->where('annee_academique_id', $ressource->annee_academique_id))
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
