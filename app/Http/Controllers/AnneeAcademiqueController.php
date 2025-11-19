<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Enums\Model;
use App\Repositories\LogUserRepository;

class AnneeAcademiqueController extends Controller
{
    protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository) {
        $this->logUserRepository = $logUserRepository;
    }
   
    public function index()
    {
        $anneesacademiques = AnneeAcademique::all();
        return view('anneeacademique.index', compact('anneesacademiques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anneesacademiques = AnneeAcademique::all();
        return view('anneeacademique.create', compact('anneesacademiques'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateDebut' => 'required|string|max:255',
            'dateFin' => 'required|string|max:255',
            'annee1' => 'required|string|max:255',
            'annee2' => 'required|string|max:255',
            'code' => 'required|string|max:255',
           

        ]);

        
        $anneeacademique = AnneeAcademique::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddAnneeAcademique, 'model' => Model::AnneeAcademique, 'new_object' => json_encode($anneeacademique)]);


        return redirect()->route('anneeacademique.index')
                        
                         ->withMessage('Année académique créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnneeAcademique $anneeacademique)
    {
        return view('anneeacademique.show', compact('anneeacademique'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnneeAcademique $anneeacademique)
    {
        
  
        return view('anneeacademique.edit', compact('anneeacademique'));
    }

    public function update(Request $request, AnneeAcademique $anneeacademique)
    {
        $request->validate([
            'dateDebut' => 'required|string|max:255',
            'dateFin' => 'required|string|max:255',
            
            ]);
        
        $anneeacademique->update($request->all());
       

        return redirect()->route('anneeacademique.index')
                         ->withMessage('Année académique mis à jour avec succès.');
    }

    public function destroy(AnneeAcademique $anneeacademique)
    {
        $this->logUserRepository->store([
            'action' => UserAction::DeleteAnneeAcademique, 'model' => Model::AnneeAcademique,
            'old_object' => json_encode($anneeacademique)
        ]);
        $anneeacademique->delete();

        return redirect()->route('anneeacademique.index')
                         ->withMessage('Année Académique supprimé avec succès.');
    }
}