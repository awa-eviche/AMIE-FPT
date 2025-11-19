<?php

namespace App\Http\Controllers;

use App\Models\Indicateur;
use App\Http\Requests\StoreIndicateurRequest;
use App\Http\Requests\UpdateIndicateurRequest;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;
use App\Models\SuiviIndicateur;
use Carbon\Carbon;

class IndicateurController extends Controller
{
    protected $logUserRepository;
 
    public function __construct(
          LogUserRepository $logUserRepository
      ) {
          $this->logUserRepository = $logUserRepository;
      }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('indicateur.index');
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
    public function store(StoreIndicateurRequest $request)
    {
    //    dd($request->date_echeance);
       $indicateur =  Indicateur::create([
            'typeIndicateur_id'=>$request->typeIndicateur_id,
            'anneeAcademique_id'=>$request->anneeAcademique_id,
            'label'=>$request->libelle,
            'date_echeance'=>Carbon::parse($request->date_echeance)->format('Y-m-d'),
            'public'=>$request->public ?? 0,
            'cible'=>0,
        ]);

        $this->logUserRepository->store(['action' => UserAction::AddIndicateur, 'model' => Model::Indicateur, 'new_object' => json_encode($indicateur)]);


        return redirect()->route('indicateur.index')
        ->withMessage('Type indicateur ajouter avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Indicateur $indicateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Indicateur $indicateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreIndicateurRequest $request, Indicateur $indicateur)
    {
        $indicateur->update([
            'typeIndicateur_id'=>$request->typeIndicateur_id,
            'anneeAcademique_id'=>$request->anneeAcademique_id,
            'label'=>$request->libelle,
            'date_echeance'=>Carbon::parse($request->date_echeance)->format('Y-m-d'),
            'public'=>$request->public ?? 0,
            'cible'=>0
        ]);

        return redirect()->route('indicateur.index')
        ->withMessage('Type indicateur modifier avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Indicateur $indicateur)
    {
        SuiviIndicateur::destroy('indicateur_id',$indicateur->id);
        $indicateur->delete();
        return redirect()->route('indicateur.index')
            ->withMessage('Indicateur supprimé avec succès.');
    }
}
