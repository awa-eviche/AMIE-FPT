<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\EtatWorkflow;
use App\Models\Workflow;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;

class EtatWorkflowController extends Controller
{
    // public function index($workflow_id)
    // {
    //     $etats = EtatWorkflow::where('workflow_id', $workflow_id)->get();
    //     return view('etats.index', compact('etats'));
    // }



    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_permission');
        $this->middleware(['role:superadmin|admin']);
    }

    public function show($etat_id)
    {
        $etatWorkflow = EtatWorkflow::findOrFail($etat_id);
        $roles = $etatWorkflow->roles;
        return view('parametrage.etats.show', compact('etatWorkflow', "roles"));
    }

    public function create(Workflow $workflow)
    {

        return view('parametrage.etats.create', compact('workflow'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'workflow_id' => 'required|exists:workflows,id',
            'code' => 'required|string|max:255',
            'libelle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            // 'bouton_suivant' => 'nullable|string|max:255',
            // 'bouton_rejet' => 'nullable|string|max:255',
            // 'est_rejetable' => 'nullable|boolean',
            // 'libelle_rejet' => 'nullable|string|max:255',
            'est_fin' => 'nullable|boolean',
            'status' => 'required|string',
        ]);

        EtatWorkflow::create($request->all());

        return redirect()->route('workflow.show', $request->input('workflow_id'))->with('success', 'État créé avec succès!');
    }

    public function edit($id)
    {
        $etat = EtatWorkflow::findOrFail($id);
        return view('parametrage.etats.edit', compact('etat'));
    }

    public function update(Request $request, EtatWorkflow $etatWorkflow)
    {
        $request->validate([
            'position' => 'required',
            'code' => 'required',
            'libelle' => 'nullable',
            'est_fin' => 'nullable',
            'description' => 'nullable',
            'status' => 'required|string',
        ]);

        $data = [
            'position' => $request->position,
            'code' => $request->code,
            'libelle' => $request->libelle,
            'est_fin' => $request->est_fin,
            'description' => $request->description,
            'est_rejetable' => $request->est_rejetable ? true : false,
            'etat_rejet_id' => $request->est_rejetable ? $etatWorkflow->etat_rejet_id : null,
            'bouton_rejet' => $request->est_rejetable ? $etatWorkflow->bouton_rejet : null,
            'etat_suivant_id' => $request->est_fin ? null : $etatWorkflow->etat_suivant_id,
            'bouton_suivant' => $request->est_fin ? null : $etatWorkflow->bouton_suivant,
            'status' => $request->status,
        ];

        $etatWorkflow->update($data);

        // return redirect()->route('etat_workflow.show', $etatWorkflow->id)->with('success', 'État de Workflow mis à jour avec succès.');









        return redirect()->route('etat_workflow.show', $etatWorkflow->id)->with('success', 'État de Workflow mis à jour avec succès.');
    }
}
