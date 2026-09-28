<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Secteur;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Enums\Model;
use App\Repositories\LogUserRepository;
use Barryvdh\DomPDF\Facade\Pdf;


class FiliereController extends Controller
{
    protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
       // $this->middleware('permission:gerer_permission');
      //  $this->middleware(['role:superadmin|admin']);
        $this->logUserRepository = $logUserRepository;
    }

    
    public function index()
    {
        $filieres = Filiere::all();
        $secteur = Secteur::all();
        return view('parametrage.filiere.index', compact('filieres','secteur'));
    }

    public function create()
    {
        $filieres = Filiere::all();
        $secteur = Secteur::all();
        return view('parametrage.filiere.create', compact('filieres','secteur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'secteur_id' => 'required|string',
            'description' => 'required|string',

        ]);

        
        $filiere = Filiere::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddFiliere, 'model' => Model::Filiere, 'new_object' => json_encode($filiere)]);


        return redirect()->route('filiere.index')
                        
                         ->with('success', 'Filiere créé avec succès.');
    }

    public function show(Filiere $filiere)
    {
        return view('parametrage.filiere.show', compact('filiere'));
    }

    public function edit(Filiere $filiere)
    {
        
        $secteur = Secteur::all();
        return view('parametrage.filiere.edit', compact('filiere','secteur'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'secteur_id' => 'required|string',
            'description' => 'required|string',
        ]);

        $filiere->update($request->all());

        return redirect()->route('filiere.index')
                         ->with('success', 'Filiere mis à jour avec succès.');
    }

    public function exportPdf(Request $request)
    {
        $qry = Filiere::with('secteur')->orderBy('nom');

        if ($request->filled('secteur_id')) {
            $qry->where('secteur_id', $request->secteur_id);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $qry->where(fn($q) => $q->where('nom', 'like', "%$s%")->orWhere('code', 'like', "%$s%"));
        }

        $filieres = $qry->get();
        $pdf = Pdf::loadView('parametrage.filiere.export-pdf', compact('filieres'))->setPaper('A4', 'portrait');

        return $pdf->stream('liste_filieres_' . date('d-m-Y') . '.pdf');
    }

    public function destroy(Filiere $filiere)
    {
          //Logs
          $this->logUserRepository->store([
            'action' => UserAction::DeleteFiliere, 'model' => Model::Filiere,
            'old_object' => json_encode($filiere)
        ]);
        $filiere->delete();

        return redirect()->route('filiere.index')
                         ->with('success', 'Filiere supprimé avec succès.');
    }
}
