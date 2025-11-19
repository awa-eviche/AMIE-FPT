<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


class RegionController extends Controller
{
    
    protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository) {$this->logUserRepository = $logUserRepository;}
    public function index()
    {
        return view('regions.index');
    }

    public function create(Region $region)
    {

        return view('regions.create', compact('region'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'=> 'required|string|max:191',
            'libelle' => 'required|string|max:191',
        ]);
        $region = Region::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddRegion, 'model' => Model::Region, 'new_object' => json_encode($region)]);

        return redirect()->route('region.index')
                         ->withMessage('Région créée avec succès.');
    }

    public function show($id)
    {
        $region = Region::findOrFail($id);
        return view('regions.show', compact('region'));
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        return view('regions.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'code'=> 'required|string|max:191',
            'libelle' => 'required|string|max:191',
            
        ]);

        $region = Region::findOrFail($id);
        $region->update($request->only(['code',"libelle"]));

        return redirect()->route('region.index')
                         ->withMessage('Région mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->update(['isDeleted' => true]);
        $this->logUserRepository->store([
            'action' => UserAction::DeleteRegion, 'model' => Model::Region,
            'old_object' => json_encode($region)
        ]);

        return redirect()->route('region.index')
                         ->withMessage('Région supprimée avec succès.');
    }
}
