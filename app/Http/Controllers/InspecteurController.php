<?php

namespace App\Http\Controllers;

use App\Models\Inspecteur;
use App\Models\User;
use App\Models\Ia;
use App\Models\Ief;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeAccesinspecteurGenerated;
use App\Mail\SuppressionAccesInspecteur;
use Illuminate\Support\Str;
use App\Enums\Model;




class InspecteurController extends Controller
{

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        
        $this->middleware('auth');

        $this->middleware('permission:visualiser_etablissement');
       
        $this->middleware('permission:visualiser_apprenant');
    }

    public function index()
    {
        return view('inspecteur.index');
    }

    public function create(Inspecteur $inspecteur)
    {
        
        $ias = Ia::all();
		$iefs = Ief::all();
		$users = User::all();

        return view('inspecteur.create', compact('inspecteur', 'ias', 'iefs', 'users'));
    }

    public function store(Request $request)
    {

        try {

            Log::info("Creation Inspecteur");
            Log::info($request->all());
            

            DB::beginTransaction();
            $inspecteur = Inspecteur::create($request->all());

            $tmp = [];
            $password = Str::random(10);
            $tmp['password'] = $password;


            $user = User::create(array(
                'email' => $request->email,
                'prenom' => $request->prenom,
                'nom' => $request->nom,
                'telephone' => $request->telephone,
                'password' => bcrypt($password)
            ));


            $tmp['email'] = $user->email;
            $tmp['nom'] = $user->nom;


            $user->assignRole(config('constants.roles.ia'));
            $user->markEmailAsVerified();


            Log::info($tmp);

            Mail::to($user->email)->send(new CodeAccesInspecteurGenerated($tmp));

            DB::commit();

            return redirect()->route('inspecteur.index')
                ->withMessage('L\'inspecteur a été créé avec succès.');
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
        }
    }


    public function show($id)
    {
        $inspecteur = Inspecteur::findOrFail($id);
        $user = User::where('prenom', 'like', $inspecteur->prenom)->first();
        
        return view('inspecteur.show', compact('inspecteur', 'user', 'id'));
    }

    public function edit($id)
    {
        $inspecteur = Inspecteur::findOrFail($id);

        $ias = Ia::where('nom', 'like', '%nom%')->get();
        $iefs = Ief::where('nom', 'like', '%nom%')->get();
        $users = User::where('email', 'like', '%email%')->get();
       
        return view('inspecteur.edit', compact('inspecteur', 'ias', 'iefs', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'specialite',
            'ia_id',
			'ief_id',
          
        ]);

        $inspecteur = Inspecteur::findOrFail($id);
        $inspecteur->update($request->only([
            'nom',
            'prenom',
            'email',
            'telephone',
          'chefInspection',
            'specialite',
            'ia_id',
			'ief_id',
			'user_id',
           
        ]));

        return redirect()->route('inspecteur.index')
            ->withMessage('L\'inspecteur a été mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $inspecteur = Inspecteur::findOrFail($id);
        $inspecteur->update(['isDeleted' => true]);

        Mail::to($inspecteur->email)->send(new SuppressionAccesInspecteur(['nom' => $inspecteur->nom]));

        return redirect()->route('inspecteur.index')
            ->withMessage('L\'inspecteur a été supprimée avec succès.');
    }
}
