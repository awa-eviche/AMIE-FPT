<?php

namespace App\Http\Controllers;

use App\Livewire\PageAcceuil\Actualite;
use App\Mail\ContactMail;
use App\Models\Entreprise;
use App\Models\Faq;
use App\Models\Filiere;
use App\Models\Liste;
use App\Models\OffreFormation;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    //
    function index()
    {
        $faqs = Faq::orderBy('priority', 'asc')->get();
        $actualites = \App\Models\Actualite::orderBy('id', 'desc')->limit(5)->get();
        return view("welcome", compact('faqs', 'actualites'));
    }

  /*  function contactSend()
    {

        $user = json_decode(json_encode([
            'identite' => request('name'),
            'email' => request('email'),
            'message' => request('message')
        ]));

        Mail::to(getenv('APP_SUPPORT'))->send(new ContactMail($user));
        return back()->withMessage('Votre message est envoyé avec succès.');
    }*/

    function contact()
    {
        return view('contact');
    }


    function contactSend()
    {

        $user = json_decode(json_encode([
            'identite' => request('name'),
            'email' => request('email'),
            'message' => request('message')
        ]));

        Mail::to(getenv('APP_SUPPORT'))->send(new ContactMail($user));
        return back()->withMessage('Votre message est envoyé avec succès.');
    }

    function etablissements()
    {
        return view('etablissements');
    }
 function programmes()
    {
        return view('programmes');
    }

    function actualites()
    {
        $actualites = \App\Models\Actualite::all();
        return view("actualite", compact('actualites',));
    }

    function show_actualite($id)
    {
        $actualite = \App\Models\Actualite::find($id);
        return view("actualite_show", compact('actualite',));
    }

   
    function suscribe()
    {

    }


}
