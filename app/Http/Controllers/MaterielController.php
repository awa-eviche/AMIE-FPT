<?php

namespace App\Http\Controllers;

use App\Models\External\Asset;
use Illuminate\Http\Request;

class MaterielController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
       
        if (!$user->roles()->where('code', 'chef_etablissement')->exists()) {
            abort(403, 'Accès refusé. Vous n\'avez pas les autorisations nécessaires.');
        }
    
        $etablissement = \App\Models\Etablissement::where('email', $user->email)->first();
    
        if (!$etablissement) {
            abort(404, 'Établissement introuvable pour votre email.');
        }

        $materiels = \App\Models\External\Asset::where('etablissement_id', $etablissement->id)->get();
    
        return view('materiel.index', compact('materiels'));
    }
    

}
