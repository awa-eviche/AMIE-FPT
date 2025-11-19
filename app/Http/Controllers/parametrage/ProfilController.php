<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class ProfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
      //  $this->middleware('permission:gerer_permission');
      //  $this->middleware(['role:superadmin|admin']);
    }
    
    public function index()
    {
        $roles = Role::all();
        return view('parametrage.profils.index', compact('roles'));
    }

    public function create()
    {
        return view('parametrage.profils.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'est_actif' => 'required'
        ]);

        Role::create($request->all());

        return redirect()->route('profil.index')
            ->with('success', 'Profil créé avec succès.');
    }

    public function show($id)
    {
        $role = Role::find($id);
        return view('parametrage.profils.show', compact('role'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('parametrage.profils.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'est_actif' => 'required'
        ]);

        $role = Role::find($id);
        $role->update($request->all());

        return redirect()->route('profil.index')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return redirect()->route('profil.index')
            ->with('success', 'Profil supprimé avec succès.');
    }
}
