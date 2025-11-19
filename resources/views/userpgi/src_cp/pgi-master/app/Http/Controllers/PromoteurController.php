<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Document;
use Illuminate\Http\Request;

class PromoteurController extends Controller
{
    //
    function index()
    {
        return view('promoteurs.index');
    }

    function demande($demande)
    {
        $demandeDetails = Demande::join('entreprises', 'demandes.entreprise_id', '=', 'entreprises.id')
                ->join('type_demandes', 'demandes.type_demande_id', '=', 'type_demandes.id')
                ->join('etat_workflows', 'demandes.etat_id', '=', 'etat_workflows.id')
                ->join('projets', 'demandes.projet_id', '=', 'projets.id')
                ->where('demandes.id',$demande)
                ->select('demandes.*','projets.*', 'entreprises.nom_entreprise as nom_entreprise', 'type_demandes.libelle as type_demande_libelle', 'etat_workflows.libelle as etat_libelle')
                ->first();

        $documents = Document::where('documentable_id',$demande)->get();
        return view('promoteurs.demande',compact('demandeDetails','documents'));
    }

    function demandes()
    {
        return view('promoteurs.demandes');
    }
}
