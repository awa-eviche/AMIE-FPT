<?php

namespace App\Http\Controllers;

use App\Models\SuiviIndicateur;
use App\Http\Requests\StoreSuiviIndicateurRequest;
use App\Http\Requests\UpdateSuiviIndicateurRequest;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class SuiviIndicateurController extends Controller
{
    protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository) {$this->logUserRepository = $logUserRepository;}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuiviIndicateurRequest $request)
    {
        $suiviIndicateur = SuiviIndicateur::create([
            'etablissement_id'=>$request->etablissement_id,
            'indicateur_id'=>$request->indicateur_id,
            'valeurAtteinte'=>$request->valeurAtteinte,
            'observation'=>$request->observation,
            'valide'=>true,
        ]);
        $this->logUserRepository->store(['action' => UserAction::AddSuiviIndicateur, 'model' => Model::SuiviIndicateur, 'new_object' => json_encode($suiviIndicateur)]);

        return redirect()->route('indicateur.index')
        ->withMessage('Réalisation ajouter avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuiviIndicateur $suiviIndicateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuiviIndicateur $suiviIndicateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuiviIndicateurRequest $request, SuiviIndicateur $suiviIndicateur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuiviIndicateur $suiviIndicateur)
    {
        //
    }
}
