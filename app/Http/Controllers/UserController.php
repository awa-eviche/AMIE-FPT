<?php

namespace App\Http\Controllers;

use App\Enums\Model;
use App\Enums\UserAction;
use App\Http\Requests\UserRequest;
use App\Mail\UserCreated;
use App\Mail\AccesCompteEtablissement;
use App\Repositories\LogUserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Utils\UploadUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;
use App\Services\ForumService;
use App\Models\PersonnelEtablissement;
use App\Models\Etablissement;
use App\Models\Ia;
use App\Models\Ief;
use Illuminate\Support\Facades\DB;
use App\Models\Inspecteur;

use Illuminate\Support\Str;

use App\Mail\UserResetPassword;








class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;
    protected $logUserRepository;
    protected $uploadUtil;
    protected $notificationService;
    protected $forumService;
    const NB_ITEM = 15;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        LogUserRepository $logUserRepository,
        UploadUtil $uploadUtil,
        NotificationService $notificationService,
        ForumService $forumService
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->logUserRepository = $logUserRepository;
        $this->uploadUtil = $uploadUtil;
        $this->notificationService = $notificationService;
        $this->forumService = $forumService;
        $this->middleware('auth');
        // $this->middleware('permission:gerer_administration');
        $this->middleware(['role:superadmin|admin'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $loggedUser = Auth::user();
        $except = [];
        $isDeletable = true;
        $idEtablissement = null;
        $users = [];
        $roleStats = [];
        $allowedRoles = [];
if ($loggedUser->hasRole('agent')) {
    return $this->redirectAgentToHisView($request);
}    
        // 🔐 Filtrage si chef d’établissement ou assistante
        if (
            $loggedUser->hasRole('chef_etablissement') ||
            $loggedUser->hasRole('assistante')
        )
         {
            if ($loggedUser->personnel && $loggedUser->personnel->etablissement_id) {
                $idEtablissement = $loggedUser->personnel->etablissement_id;
                $allowedRoles = [
                    'formateur', 'intendant', 'surveillant',
                    'directeur_etude', 'comptable_matiere',
                    'chef_de_travaux', 'assistante','gestionnaire','censeur'
                ];
            }
        }
    
        $selectedRole = $request->input('role');
    
        if (!empty($selectedRole)) {
            $users = $this->userRepository->getDataPaginateByRole($selectedRole, self::NB_ITEM, $idEtablissement);
        } elseif ($request->has('query')) {
            $users = $this->userRepository->getSearchPaginate($request->get('query'), self::NB_ITEM, $idEtablissement, $allowedRoles);
        } else {
            $users = $this->userRepository->getPaginate(self::NB_ITEM, $idEtablissement, $allowedRoles);
        }
    
        $roleStats = $this->userRepository->getStats($idEtablissement, $except, $allowedRoles);
    
        return view('admin.users.index', compact('users', 'roleStats', 'isDeletable', 'selectedRole'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
{
    // Récupérer l'utilisateur connecté
    $roles = $this->roleRepository->getList(Auth::user()); // Cette méthode gère maintenant les rôles selon le type d'utilisateur
    $ias = Ia::all();
    $iefs = Ief::all();

    // Passer les rôles à la vue
    return view('admin.users.create', compact('roles', 'ias', 'iefs'));
}


    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        $inputs = $request->all();
        //Avatar
        if ($request->hasFile('profile_photo_path')) {
            $inputs['profile_photo_path'] = $this->uploadUtil->traiterFile($request->file('profile_photo_path'));
        }

        $inputs['role_id'] = $inputs['roles'][0];
        $user = $this->userRepository->store($inputs);
        $role = $this->roleRepository->getById($inputs['roles'][0]);
        $users['user_id'] = $user->id;


        if (optional(auth()->user()->personnel)->etablissement_id != null) {
            $personnelEtablissement = PersonnelEtablissement::create(array(
                'fonction' => $inputs['fonction'] ?? null,
                'user_id' => $user->id,
                'interne' => $inputs['interne'] ?? null,
                'dernierDiplomeAcademique' => $inputs['dernierDiplomeAcademique'] ?? null,
                'dernierDiplomeProfessionnel' => $inputs['dernierDiplomeProfessionnel'] ?? null,
                'etablissement_id' => auth()->user()->personnel->etablissement_id
            ));
          
        }

        $inputs['ia'] != null || $inputs['ief'] != null ? Inspecteur::create(['ia_id' => $inputs['ia'] ?? null, 'ief_id' => $inputs['ief'] ?? null, 'user_id' => $user->id]) : null;

           //Email notification
        if (!$user)
        {
            DB::rollback();
            return \redirect()->back()->withErrors("Erreur lors de la création...");
        }
           
        //Logs
        $this->logUserRepository->store(['action' => UserAction::AddUser, 'model' => Model::User, 'new_object' => json_encode($user)]);
        Mail::to($user->email)->send(new UserCreated($user));

        $user->markEmailAsVerified();
        DB::commit();
        return \redirect()->route('users.index')->withMessage("L'utilisateur " . $user->identite . " a été créé.");
    }



    public function accessForum($id)
    {
        $user = $this->userRepository->getById($id);
        $username = $user->nom . '_'. $user->prenom . '_' .$user->telephone; 
        $data = ['email' => $user->email, 'password' => $user->password, 'username' => $username];
        $this->forumService->createForumAccount($data);
        return \redirect()->route('users.index')->withMessage("L'accès au forum de " . $user->identite . " a été créé.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->getById($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->getById($id);
        $roles = $this->roleRepository->getList(Auth::user());
        $personnelEtablissement = PersonnelEtablissement::where('user_id', $user->id)->first();
        if ($personnelEtablissement !== null) {
            // Assigner les diplômes à l'utilisateur
            $user->dernierDiplomeAcademique = $personnelEtablissement->dernierDiplomeAcademique;
            $user->dernierDiplomeProfessionnel = $personnelEtablissement->dernierDiplomeProfessionnel;
            $user->fonction = $personnelEtablissement->fonction;
            $user->interne = $personnelEtablissement->interne;
        }
        $ias = Ia::all();
		$iefs = Ief::all();
        return view('admin.users.edit', compact('user', 'roles', 'ias', 'iefs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->userRepository->getById($id);
        $oldUser = clone $user;
        $inputs = $request->all();
        //Avatar
        if ($request->hasFile('profile_photo_path')) {
            $inputs['profile_photo_path'] = $this->uploadUtil->traiterFile($request->file('profile_photo_path'));
            $oldFilename = $user->avatar;
        }
        $user = $this->userRepository->update($id, $inputs);

        if (!$user)
            return \redirect()->back()->withErrors("Erreur lors de la modification...");

        //Logs
        $this->logUserRepository->store([
            'action' => UserAction::UpdateUser, 'model' => Model::User,
            'old_object' => json_encode($oldUser), 'new_object' => json_encode($this->userRepository->getById($id))
        ]);
        //Suppression ancien avatar
        if (!empty($oldFilename))
            $this->uploadUtil->deleteFile($oldFilename);
        return \redirect()->route('users.index')->withMessage("L'utilisateur " . $request->input('prenom') . " " . $request->input('nom') . " a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->getById($id);
        if ($this->userRepository->forceDestroy($user)) {
            //Logs
            $this->logUserRepository->store([
                'action' => UserAction::DeleteUser, 'model' => Model::User,
                'old_object' => json_encode($user)
            ]);
            return redirect()->back()->withMessage("La suppression est effective");
        } else
            return redirect()->back()->withErrors("Cet utilisateur ne peut être supprimé...");
    }

    public function searchByRole($role)
    {
        $loggedUser = Auth::user();
        $except = [];
        $isDeletable = true;
        /* if (!$loggedUser->isAdmin()) {
            $except[] = config('constants.roles.admin');
            $isDeletable = false;
        }*/
        $users = $this->userRepository->getDataPaginateByRole($role, self::NB_ITEM);
        $roleStats = $this->userRepository->getStats($except);
        return view('admin.users.index', compact('users', 'roleStats', 'role', 'isDeletable'));
    }

    public function logs($userid = null)
    {
        $logs = [];
        $title = "Historique des actions des utilisateurs";
        $fromUser = false;
    
        // Récupérer l'email de l'utilisateur connecté
        $userEmail = auth()->user()->email;
    
        // Vérifier si l'utilisateur est un superadmin
        if (auth()->user()->profil && auth()->user()->profil->name === 'superadmin') {
            // Le superadmin peut voir tous les logs
            if ($userid == null) {
                $logs = $this->logUserRepository->getPaginate(self::NB_ITEM);
            } else {
                $logs = $this->logUserRepository->getPaginateByUser(self::NB_ITEM, $userid);
                $title = "Historique des actions de l'utilisateur";
                $fromUser = true;
            }
        } else {
            // Vérifier si l'utilisateur est un chef d'établissement
            $isChefEtablissement = auth()->user()->personnel && auth()->user()->personnel->fonction === 'Chef Etablissement';
    
            if ($isChefEtablissement) {
                // Si l'utilisateur est un chef d'établissement, il voit ses propres logs et ceux de son personnel
                // Récupérer tous les utilisateurs associés à l'établissement du chef d'établissement
                $etablissementId = auth()->user()->personnel->etablissement_id;
    
                // Récupérer les emails de tous les utilisateurs dans l'établissement
                $userEmails = \App\Models\User::whereHas('personnel', function($query) use ($etablissementId) {
                    $query->where('etablissement_id', $etablissementId);
                })->pluck('email')->toArray();
    
                // Ajouter l'email du chef d'établissement dans la liste
                $userEmails[] = $userEmail;
    
                // Récupérer tous les logs associés à ces utilisateurs
                $logs = $this->logUserRepository->getPaginateByUserEmails(self::NB_ITEM, $userEmails);
                $title = "Historique des actions de votre établissement";
                $fromUser = true;
            } else {
                // Pour les autres utilisateurs, récupérer uniquement leurs propres logs
                $logs = $this->logUserRepository->getPaginateByUser(self::NB_ITEM, $userEmail);
                $title = "Historique de vos actions";
                $fromUser = true;
            }
        }
    
        // Retourner la vue avec les logs
        return view('admin.users.index_logs', compact('logs', 'title', 'fromUser'));
    }

    public function detailLog($id)
    {
        $log = $this->logUserRepository->getById($id);
        return view('admin.users.show_logs', compact('log'));
    }

    public function resetPassword($id)
    {
        $user = $this->userRepository->getById($id);
    
        // Générer un nouveau mot de passe aléatoire
        $newPassword = Str::random(10);
        $user->password = bcrypt($newPassword);
        $user->save();
    
        // Envoyer l'email avec le nouveau mot de passe
        Mail::to($user->email)->send(new UserResetPassword($user, $newPassword));
    
        return redirect()->back()->withMessage(
            "Le mot de passe de " . $user->identite . " a été réinitialisé et envoyé par email."
        );
    }

    public function activation($id)
    {
        $user = $this->userRepository->getById($id);
        $oldUser = clone $user;
        $newUser = $this->userRepository->changeStatus($user);
        //Logs
        $this->logUserRepository->store([
            'action' => UserAction::ChangeStatusUser, 'model' => Model::User,
            'old_object' => json_encode($oldUser), 'new_object' => json_encode($newUser)
        ]);
        return redirect()->back()->withMessage("Le changement est effectif");
    }

    public function activationEtablissement($id, $action)
    {
      $users = $this->userRepository->getEtablissementInfoFromUser($id);
      Etablissement::find($id)->update(['is_active' => !$action]);
      foreach ($users as $user) {
        $this->userRepository->restrictAccess($user, $action);
        if($user->hasRole(config('constants.roles.chef_etablissement')))
        {
            Mail::to($user->personnel->etablissement->email)->send(new AccesCompteEtablissement(['nom' => $user->personnel->etablissement->sigle .' '. $user->personnel->etablissement->nom, 'action' => $action]));
        }
      }

     
      if($action == true)
      {
        return redirect()->back()->withMessage("L'établissement a été désactivé avec succès");
      }

      return redirect()->back()->withMessage("L'établissement a été activé avec succès");

    }

private function redirectAgentToHisView($request)
{
    // Récupérer l'établissement demandé via l'URL
    $idEtablissement = $request->get('etablissement');

    // Si aucun établissement demandé, fallback = celui de l'agent
    if (!$idEtablissement) {
        $idEtablissement = Auth::user()->personnel->etablissement_id;
    }

    // Rôles visibles
    $allowedRoles = [
        'formateur', 'intendant', 'surveillant',
        'directeur_etude', 'comptable_matiere',
        'chef_de_travaux', 'assistante', 'gestionnaire', 'censeur',
    ];

    // Filtres existants
    $selectedRole = $request->input('role');

    if ($selectedRole) {
        $users = $this->userRepository->getDataPaginateByRole($selectedRole, self::NB_ITEM, $idEtablissement);
    } elseif ($request->has('query')) {
        $users = $this->userRepository->getSearchPaginate($request->get('query'), self::NB_ITEM, $idEtablissement, $allowedRoles);
    } else {
        $users = $this->userRepository->getPaginate(self::NB_ITEM, $idEtablissement, $allowedRoles);
    }

    $roleStats = $this->userRepository->getStats($idEtablissement, [], $allowedRoles);

    return view('admin.users.index', compact('users', 'roleStats'))
        ->with('isDeletable', false)
        ->with('selectedRole', $selectedRole);
}




    
}



