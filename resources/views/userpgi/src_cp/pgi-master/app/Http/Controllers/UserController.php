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

        if(auth()->user()->hasRole(config('constants.roles.chef_etablissement')) && auth()->user()->personnel && auth()->user()->personnel->etablissement_id)
        {
            $idEtablissement = auth()->user()->personnel->etablissement_id ;
        }
       /* if (!$loggedUser->isAdmin()) {
          //  $except[] = config('constants.roles.admin');
            $isDeletable = false;
        }*/
        

        if ($request->has('query'))
            $users = $this->userRepository->getSearchPaginate($request->get('query'), self::NB_ITEM, $idEtablissement);
        else
            $users = $this->userRepository->getPaginate(self::NB_ITEM, $idEtablissement);
        
        $roleStats = $this->userRepository->getStats($idEtablissement, $except);

        return view('admin.users.index', compact('users', 'roleStats', 'isDeletable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = $this->roleRepository->getList(Auth::user());
        $ias = Ia::all();
		$iefs = Ief::all();
        return view('admin.users.create', compact('roles','ias','iefs'));
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
           $username = $user->nom . '_'. $user->prenom . '_' .$user->telephone;
           $data = ['email' => $user->email, 'password' => config('constants.password'), 'username' => $username];
           $status =  $this->forumService->createForumAccount($data);
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

        if ($userid == null) {
            $logs = $this->logUserRepository->getPaginate(self::NB_ITEM);
        } else {
            $logs = $this->logUserRepository->getPaginateByUser(self::NB_ITEM, $userid);
            $title = "Historique des actions de l'utilisateur";
            $fromUser = true;
        }

        return view('admin.users.index_logs', compact('logs', 'title', 'fromUser'));
    }

    public function detailLog($id)
    {
        $log = $this->logUserRepository->getById($id);
        return view('admin.users.show_logs', compact('log'));
    }

    public function resetPassword($id)
    {
        $this->userRepository->resetPassword($this->userRepository->getById($id));
        return redirect()->back()->withMessage("Le mot de passe a été réinitialisé !");
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



    
}



