<?php

namespace App\Http\Controllers;

use App\Models\Critere;
use App\Models\ElementCompetence;
use App\Models\Competence;
use App\Models\NiveauEtude;
use Illuminate\Http\Request;

class CritereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('criteres.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $competence=Competence::all();
        $niveau=NiveauEtude::all();
        $elements = ElementCompetence::all();
        return view('criteres.create',compact('elements','competence','niveau'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'code' => 'required|string|max:191',
        'libelle' => 'required|string|max:191',
        'element' => 'required|array',
        'element.*' => 'exists:element_competences,id',
        'competence_id' => 'required|exists:element_competences,id',
        'niveau_etude_id' => 'required|exists:niveau_etudes,id',
    ]);

    foreach ($request->element as $elementId) {
        Critere::create([
            'code' => $request->code,
            'libelle' => $request->libelle,
            'element_competence_id' => $elementId,
            'description' => $request->description,
            'competence_id' => $request->competence_id,
            'niveau_etude_id' => $request->niveau_etude_id,
        ]);
    }

    return redirect()->route('critere.index')
        ->withMessage('Critère(s) enregistré(s) avec succès.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $critere = Critere::find($id);
        return view('criteres.show',compact('critere'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $critere = Critere::find($id);
        $elements = ElementCompetence::all();
        $competences=Competence::all();
        $niveau=NiveauEtude::all();
        return view('criteres.edit',compact('elements','critere','competences','niveau'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'code' => 'required',
            'libelle' => 'required|string|max:191',
            'element' => 'required',
            'competence_id'=>'required',
              'niveau_etude_id'=>'required'
        ]);
        $critere = Critere::find($id);

        if($critere->update(['code'=>request('code'),'libelle'=>request('libelle'),'element_competence_id'=>request('element'),'description'=>request('description'),'competence_id'=>request('competence_id'),'niveau_etude_id'=>request('niveau_etude_id')]))
        {
            return redirect()->route('critere.index')
                        ->withMessage('Critère modifié avec succès.');
        }
        return back()->withMessage('Une erreur est survenue.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $critere = Critere::findOrFail($id);
        $critere->delete();

        return redirect()->route('critere.index')
                         ->withMessage( 'Critère supprimé avec succès.');
    }
}
