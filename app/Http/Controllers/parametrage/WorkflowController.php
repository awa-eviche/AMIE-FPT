<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\TypeDemande;
use App\Models\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_permission');
        $this->middleware(['role:superadmin|admin']);
    }
    
    public function index()
    {
        $workflows = Workflow::all();
        return view('parametrage.workflows.index', compact('workflows'));
    }

    public function create()
    {
        $typeDemandes = TypeDemande::all();
        return view('parametrage.workflows.create', compact("typeDemandes"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'libelle' => 'required',
            'description' => 'required',
            "type_demande_id" => "required"
        ]);

        Workflow::create($request->all());

        return redirect()->route('workflow.index')
                         ->with('message','Workflow créé avec succès.');
    }

    public function show(Workflow $workflow)
    {
        return view('parametrage.workflows.show', compact('workflow'));
    }

    public function edit(Workflow $workflow)
    {
        $typeDemandes = TypeDemande::all();
        return view('parametrage.workflows.edit', compact('workflow', "typeDemandes"));
    }

    public function update(Request $request, Workflow $workflow)
    {
        $request->validate([
            'code' => 'required',
            'libelle' => 'required',
            'description' => 'required',
            "type_demande_id" => "required|exists:type_demandes,id"
        ]);

        $workflow->update($request->all());

        return redirect()->route('workflow.index')
                         ->with('message','Workflow mis à jour avec succès.');
    }

    public function destroy(Workflow $workflow)
    {
        $workflow->delete();

        return redirect()->route('workflow.index')
                         ->with('message','Workflow supprimé avec succès.');
    }
}
