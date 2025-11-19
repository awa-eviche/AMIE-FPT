<?php

namespace App\Http\Controllers;

use App\Enums\Model;
use App\Enums\UserAction;
use App\Http\Requests\RoleRequest;
use App\Repositories\LogUserRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;


class RoleController extends Controller
{

    protected $roleRepository;
    protected $permRepository;
    protected $logUserRepository;
    const NB_ITEM = 15;

    public function __construct(RoleRepository $roleRepository,
                                PermissionRepository $permissionRepository,
                                LogUserRepository $logUserRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permRepository = $permissionRepository;
        $this->logUserRepository = $logUserRepository;
        $this->middleware('auth');
        $this->middleware('permission:gerer_administration');
        $this->middleware('permission:gerer_role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = $this->roleRepository->getPaginate(self::NB_ITEM);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permissions = $this->permRepository->getList();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $inputs = $request->all();
        $role = $this->roleRepository->store($inputs);
        //Logs
        $this->logUserRepository->store(['action' => UserAction::AddRole, 'model' => Model::Role, 'new_object' => json_encode($role)]);
        return \redirect()->route('roles.index')->withMessage("Le rôle " . $role->description . " a été créé.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->getById($id);
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->getById($id);
        $permissions = $this->permRepository->getList();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = $this->roleRepository->getById($id);
        $oldRole = clone $role;
        $this->roleRepository->update($role, $request->all());
        //Logs
        $this->logUserRepository->store(['action' => UserAction::UpdateRole, 'model' => Model::Role,
            'old_object' => json_encode($oldRole), 'new_object' => json_encode($this->roleRepository->getById($id))]);
        return \redirect()->route('roles.index')->withMessage("Le rôle " . $request->input('description') . " a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roleRepository->getById($id);
        if ($this->roleRepository->destroy($role)){
            //Logs
            $this->logUserRepository->store(['action' => UserAction::DeleteRole, 'model' => Model::Role,
                'old_object' => json_encode($role)]);
            return redirect()->back()->withMessage("La suppression est effective");
        }
        else
            return redirect()->back()->withErrors("Ce rôle ne peut être supprimé...");
    }

}
