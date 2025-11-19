<?php
namespace App\Http\Controllers;
use App\Models\Ressource;
use App\Models\ElementCompetence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RessourceController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'element_competence_id' => 'required|exists:element_competences,id',
        'classe_id' => 'required|exists:classes,id',
    ]);

    $normalizedNom = Str::lower(Str::ascii(trim($request->nom)));

    $exists = Ressource::where('classe_id', $request->classe_id)
        ->whereRaw('LOWER(nom) = ?', [$normalizedNom])
        ->exists();

    if ($exists) {
        return back()->with('error', 'Cette ressource existe déjà dans cette classe.');
    }

    Ressource::create([
        'nom' => ucfirst(trim($request->nom)),
        'element_competence_id' => $request->element_competence_id,
        'classe_id' => $request->classe_id,
    ]);

    return back()->with('success', 'Ressource enregistrée avec succès.');
}

   public function update(Request $request, Ressource $ressource)
{
    $request->validate([
        'nom' => 'required|string|max:255',
    ]);

    $normalizedNom = Str::lower(Str::ascii(trim($request->nom)));

    $classeId = $ressource->classe_id;

    if (!$classeId) {
        return back()->with('error', 'Aucune classe associée à cette ressource.');
    }

    $exists = Ressource::where('classe_id', $classeId)
        ->whereRaw('LOWER(nom) = ?', [$normalizedNom])
        ->where('id', '!=', $ressource->id)
        ->exists();

    if ($exists) {
        return back()->with('error', 'Cette ressource existe déjà dans cette classe.');
    }

    
    $ressource->update([
        'nom' => ucfirst(trim($request->nom)),
    ]);

    return back()->with('success', 'Ressource mise à jour avec succès.');
}


}
