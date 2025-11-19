<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Territoire;
use App\Models\Efpt;
use App\Models\Grade;
use App\Models\Programms;
class TerritoireController extends Controller
{
    public function index()
    {
        $departements = Territoire::with([
            'efpts.programms' => function($query) {
                $query->whereHas('grade'); 
            },
            'efpts.programms', 
            'efpts.programms.grade' 
        ])->get();

        $efpt=Efpt::all();
        $grade=Grade::all();
        return view('/carto', compact('departements','efpt','grade'));
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
