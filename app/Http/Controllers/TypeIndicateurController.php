<?php

namespace App\Http\Controllers;

use App\Models\TypeIndicateur;
use App\Http\Requests\StoreTypeIndicateurRequest;
use App\Http\Requests\UpdateTypeIndicateurRequest;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;
use App\Models\Indicateur;

class TypeIndicateurController extends Controller
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
        $typeIndicateurs = TypeIndicateur::query()->paginate(10);
        return view('typeIndicateur.index', compact('typeIndicateurs'));
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
    public function store(StoreTypeIndicateurRequest $request)
    {
        $typeIndicateur = TypeIndicateur::create([
            'code' => $request->code,
            'libelle' => $request->libelle,
            'description' => $request->description,
            'unite' => '',
        ]);

        $this->logUserRepository->store(['action' => UserAction::AddTypeIndicateur, 'model' => Model::TypeIndicateur, 'new_object' => json_encode($typeIndicateur)]);


        return redirect()->route('typeIndicateur.index')
            ->withMessage('Type indicateur crée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeIndicateur $typeIndicateur)
    {
        $indicateurs = $typeIndicateur->indicateur()->get();
        return;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeIndicateur $typeIndicateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeIndicateurRequest $request, TypeIndicateur $typeIndicateur)
    {
        $typeIndicateur->update([
            'code' => $request->code,
            'libelle' => $request->libelle,
            'description' => $request->description,
            'unite' => '',
        ]);
        return redirect()->route('typeIndicateur.index')
            ->withMessage('Type indicateur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeIndicateur $typeIndicateur)
    {
        Indicateur::destroy('typeIndicateur_id', $typeIndicateur->id);
        $typeIndicateur->delete();
        return redirect()->route('typeIndicateur.index')
            ->withMessage('Type indicateur supprimé avec succès.');
    }
}
