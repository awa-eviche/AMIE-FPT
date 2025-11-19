<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActualiteController extends Controller
{
    public function index()
    {
        return view('actualite.index');
    }

    public function create()
    {
        return view('actualite.create');
    }


    public function store(Request $request)
    {
        // Valider les données entrantes
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image', // 2MB max, you can adjust this value
            'contenu' => 'required|string',
        ]);

        // Upload de l'image
        $imagePath = $request->file('image')->store('actualite_images', 'public');

        $actualite = new Actualite();
        $actualite->title = $request->title;
        $actualite->image = $imagePath;
        $actualite->content = $request->contenu;;
        $actualite->creator_id = Auth::id();

        // Rediriger avec un message de succès
        if ($actualite->save()) {
            return redirect()->route('actualite.index')
                ->withMessage('Actualité enregistrée avec succès.');
        }

        return back()->withMessage('Une erreur est survenue.');
    }


    public function edit(string $id)
    {
        $actualite = Actualite::find($id);
        return view('actualite.edit', compact('actualite'));
    }

    public function update(Request $request, $id)
    {
        // Récupérer l'actualité à mettre à jour
        $actualite = Actualite::findOrFail($id);

        // Valider les données entrantes
        $request->validate([
            'title' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        // Mettre à jour le titre et le contenu de l'actualité
        $actualite->title = $request->title;
        $actualite->content = $request->contenu;
        $actualite->status = $request->status;

        // Vérifier si une nouvelle image a été fournie
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Supprimer l'ancienne image si elle existe
            if ($actualite->image) {
                Storage::disk('public')->delete($actualite->image);
            }

            // Upload de la nouvelle image
            $imagePath = $request->file('image')->store('actualite_images', 'public');
            $actualite->image = $imagePath;
        }

        // Rediriger avec un message de succès si l'actualité est mise à jour avec succès
        if ($actualite->save()) {
            return redirect()->route('actualite.index')
                ->withMessage('Actualité mise à jour avec succès.');
        }

        // Retourner en arrière avec un message d'erreur si l'actualité n'a pas pu être mise à jour
        return back()->withMessage('Une erreur est survenue lors de la mise à jour de l\'actualité.');
    }


    public function destroy(string $id)
    {
        //
        $actualite = Actualite::findOrFail($id);
        $actualite->delete();

        return redirect()->route('actualite.index')
            ->withMessage('Actualité supprimée avec succès.');
    }

    public function publier(string $id)
    {
        // Trouver l'actualité correspondante
        $actualite = Actualite::findOrFail($id);

        // Mettre à jour le champ de statut pour le publier
        $actualite->status = ($actualite->status == "published") ? "draft" : "published";
        $actualite->save();


        // Redirection avec un message de succès
        return redirect()->route('actualite.index')->with('success', 'L\'actualité a été publiée avec succès.');
    }

}
