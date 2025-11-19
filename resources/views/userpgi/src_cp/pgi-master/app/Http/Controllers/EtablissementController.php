<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\PersonnelEtablissement;
use App\Models\Liste;
use App\Models\User;
use App\Models\Commune;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeAccesEtablissementGenerated;
use App\Mail\SuppressionAccesEtablissement;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Str;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;
use App\Services\ForumService;




class EtablissementController extends Controller
{

    protected $logUserRepository;
    protected $userRepository;
    protected $forumService;
    public function __construct(UserRepository $userRepository, LogUserRepository $logUserRepository, ForumService $forumService)
    {
        $this->userRepository = $userRepository;
        $this->logUserRepository = $logUserRepository;
        $this->forumService = $forumService;

        $this->middleware('auth');

        //  $this->middleware('permission:visualiser_apprenant');
    }

    public function index()
    {
        return view('etablissements.index');
    }

    public function create(Etablissement $etablissement)
    {
        $statuts = Liste::where('libelle', 'like', config('constants.keys.statut'))->get();
        $statutJuridiques = Liste::where('libelle', 'like', config('constants.keys.statut_juridique'))->get();
        $types = Liste::where('libelle', 'like', config('constants.keys.type'))->get();
        $communes = Commune::where('isDeleted', false)->get();

        return view('etablissements.create', compact('etablissement', 'statuts', 'statutJuridiques', 'types', 'communes'));
    }

    public function store(Request $request)
    {

        try {

            /*   $request->validate([
                'telephone',
                'sigle',
                'email',
                'siteWeb',
                'adresse',
                // 'logo',
                'nom',
                'commune_id',
                'specifite',
                'dateAutOuv',
                'numAutOuv',
                'dateRecepisseDepot',
                'numRecipisse',
                'prenomResponsable',
                'nomResponsable',
                'reference',
                'dateCreation',
                'boitePostale',
              //  'type',
              //  'statutJuridique',
             //   "statut",
                ]);*/

            DB::beginTransaction();
            $etablissement = Etablissement::create($request->all());

            $tmp = [];
            $password = Str::random(10);
            $tmp['password'] = $password;


            $user = User::create(array(
                'email' => $request->email,
                'prenom' => $request->sigle,
                'nom' => $request->nom,
                'adresse' => $request->adresse,
                'lieu_naissance' => $request->dateAutOuv,
                'telephone' => $request->telephone,
                'password' => bcrypt($password)
            ));


            $tmp['email'] = $user->email;
            $tmp['nom'] = $user->nom;


            $personnelEtablissement = PersonnelEtablissement::create(array(
                'fonction' => 'Chef Etablissement',
                'user_id' => $user->id,
                'interne' => true,
                'etablissement_id' => $etablissement->id
            ));

            $user->assignRole(config('constants.roles.chef_etablissement'));
            $user->markEmailAsVerified();


            Log::info($tmp);

            Mail::to($user->email)->send(new CodeAccesEtablissementGenerated($tmp));
            $this->logUserRepository->store(['action' => UserAction::AddEtablissement, 'model' => Model::Etablissement, 'new_object' => json_encode($etablissement)]);

            DB::commit();

            return redirect()->route('etablissement.index')
                ->with('message', 'L\'établissement a été créé avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }


    public function sendAccountAcces($id)
    {

        try {
            DB::beginTransaction();
            $etablissement = Etablissement::find($id);
            $personnelEtablissements = PersonnelEtablissement::where('etablissement_id', $etablissement->id)->get();
            $tmp = [];
            $password = Str::random(10);
            $tmp['password'] = $password;
            if (count($personnelEtablissements) == 0) {
                $user = User::create(array(
                    'email' => $etablissement->email,
                    'nom' => $etablissement->nom,
                    'password' => bcrypt($password)
                ));

                $personnelEtablissement = PersonnelEtablissement::create(array(
                    'fonction' => 'Chef Etablissement',
                    'user_id' => $user->id,
                    'interne' => true,
                    'etablissement_id' => $etablissement->id
                ));


                $tmp['email'] = $user->email;
                $tmp['nom'] = $user->nom;

                $user->assignRole(config('constants.roles.chef_etablissement'));
                $user->markEmailAsVerified();
               
            } else {
                $personnel = $personnelEtablissements[0];
                
                $user = User::find($personnel['user_id']);
                $user->update(['password' => bcrypt($password)]);
                Log::info($user);
                $tmp['email'] = $user->email;
                $tmp['nom'] = $user->nom ?? "Responsable d\établissement";
               

            }
            Mail::to($user->email)->send(new CodeAccesEtablissementGenerated($tmp));
            DB::commit();
            return redirect()->route('etablissement.show', $id)->withMessage('Les accès ont été bien envoyé.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('etablissement.show', $id)->withError('Une erreur est survenue.');
        }
    }


    public function getAllPersonnel()
    {
        return view('etablissements.personnel');
    }

    public function getAllApprenant()
    {
        return view('etablissements.apprenant');
    }

    public function schoolInfo()
    {
        if (auth()->user()->can('visualiser_etablissement_info') && auth()->user()->personnel != null) {
            $etablissementId = auth()->user()->personnel->etablissement_id;

            $etablissement = $this->userRepository->getEtablissementInfoFromUser($etablissementId)[0]['personnel']['etablissement'];

            return view('etablissements.info', compact('etablissement'));
        }
    }

    public function show($id)
    {
        $etablissement = Etablissement::findOrFail($id);
        // $user = User::where('prenom', 'like', $etablissement->sigle)->first();
        // dd($user,$users);
        return view('etablissements.show', compact('etablissement', 'id'));
    }

    public function edit($id)
    {
        $etablissement = Etablissement::findOrFail($id);

        $statuts = Liste::where('libelle', 'like', config('constants.keys.statut'))->get();
        $statutJuridiques = Liste::where('libelle', 'like', config('constants.keys.statut_juridique'))->get();
        $types = Liste::where('libelle', 'like', config('constants.keys.type'))->get();
        $communes = Commune::where('isDeleted', false)->get();
        // dd(user);
        return view('etablissements.edit', compact('etablissement', 'statuts', 'statutJuridiques', 'types', 'communes'));
    }

    public function update(Request $request, $id)
    {

        Log::info($request->all);

        $request->validate([
            'telephone',
            'sigle',
            'email',
            'siteWeb',
            'adresse',
            'nom',
            'commune_id',
            'specifite',
            'dateAutOuv',
            'numAutOuv',
            'dateRecepisseDepot',
            'numRecipisse',
            'prenomResponsable',
            'nomResponsable',
            'reference',
            'dateCreation',
            'boitePostale',
            'type',
            'statutJuridique',
            "statut",
        ]);

        $etablissement = Etablissement::findOrFail($id);
        $etablissement->update($request->only([
            'telephone',
            'sigle',
            'email',
            'siteWeb',
            'adresse',
            'logo',
            'nom',
            'commune_id',
            'specifite',
            'dateAutOuv',
            'numAutOuv',
            'dateRecepisseDepot',
            'numRecipisse',
            'prenomResponsable',
            'nomResponsable',
            'reference',
            'dateCreation',
            'boitePostale',
            'type',
            'statutJuridique',
            "statut"
        ]));

        return redirect()->route('etablissement.index')
            ->with('success', 'L\'etablissement a été mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $etablissement = Etablissement::findOrFail($id);
        $etablissement->update(['isDeleted' => true]);
        $this->logUserRepository->store([
            'action' => UserAction::DeleteEtablissement, 'model' => Model::Etablissement,
            'old_object' => json_encode($etablissement)
        ]);

        Mail::to($etablissement->email)->send(new SuppressionAccesEtablissement(['nom' => $etablissement->sigle . ' ' . $etablissement->nom]));

        return redirect()->route('etablissement.index')
            ->with('success', 'L\établissement a été supprimée avec succès.');
    }
}
