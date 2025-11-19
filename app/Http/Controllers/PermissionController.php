<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;

class PermissionController extends Controller
{
    protected $permRepository;
    const NB_ITEM = 15;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permRepository = $permissionRepository;
        $this->middleware('auth');
        $this->middleware('permission:gerer_administration');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $permissions = $this->permRepository->getPaginate(self::NB_ITEM);
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $permission = $this->permRepository->getById($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $this->permRepository->update($id, $request->all());
        return \redirect()->route('permissions.index')->withMessage("La permission " . $request->input('description') . " a été modifiée.");
    }

}
