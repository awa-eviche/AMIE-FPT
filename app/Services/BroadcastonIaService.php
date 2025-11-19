<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Models\Ia;
use App\Models\Commune;
use App\Models\Inspecteur;
use Illuminate\Support\Facades\DB;








class BroadcastonIaService
{

    public function __construct()
    {
    }

    public function findBroadcastIA($idCommune = null)
    {
        $users = [];
        $commune = Commune::find($idCommune);
        $ia =  DB::select('
        SELECT *
        FROM ias
        JOIN departement_ias ON ias.id = departement_ias.ia_id
        WHERE departement_ias.departement_id = :departement_id
    ', ['departement_id' => $commune->departement->id]);

        $a = (!empty($ia)) ?  $ia[0]->id : null ;
        $users = Inspecteur::where('ia_id', $a)->with('user')->get()->pluck('user');

        Log::info("U");
        Log::info($users);
    
        return $users;
    }
}
