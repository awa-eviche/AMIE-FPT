<?php

namespace App\Services;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Models\Ia;





class BroadcastonIaService
{

    public function __construct()
    {
    }


    /**
     * The params required are following like this:
     *
     * @var array<User>,
     * @var message,
     * @var type
     */
    public function findBroadcastIA($idCommune = null)
    {
       if($idCommune != null)
       {
        
       }
    }

 
}
