<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Territoire;
use App\Models\Efpt;
use App\Models\Grade;
use App\Models\Departement;
use App\Models\Programms;
use App\Models\Etablissement;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\NiveauEtudeEtablissement;
class TerritoireController extends Controller
{
public function index()
{
      $departements = Departement::with([
        'etablissements.niveauEtudeEtablissements.niveauEtude.metier',
        'etablissements.niveauEtudeEtablissements.niveauEtude'
    ])->get();

    return view('carto', compact('departements'));
}




    
    public function store(Request $request)
    {
        $request->validate([
           
            'grade_id' => 'required|string|max:255',
            'efpt_id' => 'required|string',
            'nom' => 'required|string|max:255',
        ]);

        $prog = Programms::create($request->all());
        
        return redirect()->back()
        ->withMessage('programme enregistré');
    }
    public function create()
    {
        $efpt=Efpt::all();
        $grade=Grade::all();
        return view('territoire.create', compact('efpt','grade'));
      
    }

}
