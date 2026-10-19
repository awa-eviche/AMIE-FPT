<?php

namespace App\Livewire\Etablissements;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Region;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;


class ListeEtablissement extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;

    public $selectedCommune;
    public $selectedDepartement;
    public $selectedRegion;

    public $departementList = [];
    public $communeList = [];



    function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0
        ]);
    }

    function next()
    {
        $this->startLimit += 10;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch()
    {
    }



    public function render()
    {
        $user = auth()->user();
        $isIa = $user->hasRole(config('constants.roles.ia')) || $this->isInspecteurSpecialite();
        $isIef = $user->hasRole(config('constants.roles.ief'));
    
        // IDs des départements de l'IA de l'utilisateur (si IA ou IS)
        $departementIdsIa = [];
        if ($isIa && $user->inspecteur?->ia_id) {
            $departementIdsIa = $user->inspecteur->ia->departements()->pluck('departements.id')->toArray();
        }
        $this->departementList = $departementIdsIa;
    
        // IDs des communes de l'IEF de l'utilisateur (si IEF)
        $communeIdsIef = [];
        if ($isIef && $user->inspecteur?->ief_id) {
            $communeIdsIef = $user->inspecteur->ief->communes()->pluck('communes.id')->toArray();
        }
        $this->communeList = $communeIdsIef;
    
        // === Listes de filtres restreintes au périmètre ===
        if ($isIa && !empty($departementIdsIa)) {
            // IA/IS → Régions + Départements + Communes de son IA
            $departements = Departement::whereIn('id', $departementIdsIa)->get();
            $regionIds = $departements->pluck('region_id')->unique()->toArray();
            $regions = Region::whereIn('id', $regionIds)->get();
            $communes = Commune::whereIn('departement_id', $departementIdsIa)->get();
        } elseif ($isIef && !empty($communeIdsIef)) {
            // IEF → Régions + Départements + Communes de son IEF
            $communes = Commune::whereIn('id', $communeIdsIef)->get();
            $departementIds = $communes->pluck('departement_id')->unique()->toArray();
            $departements = Departement::whereIn('id', $departementIds)->get();
            $regionIds = $departements->pluck('region_id')->unique()->toArray();
            $regions = Region::whereIn('id', $regionIds)->get();
        } else {
            // Superadmin / agent / etc. → tout
            $communes = Commune::all();
            $departements = Departement::all();
            $regions = Region::all();
        }
    
        // === Requête de base sur les établissements ===
        $query = Etablissement::with(['commune.departement.region'])
            ->where(function ($q) {
                $q->where("nom", "like", "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('sigle', 'like', "%{$this->search}%")
                  ->orWhere('reference', 'like', "%{$this->search}%");
            });
    
        // === Filtrage selon le rôle ===
        if ($isIa) {
            if ($this->selectedCommune) {
                $query->where('commune_id', $this->selectedCommune);
            }
            if (!empty($departementIdsIa)) {
                $query->whereHas('commune.departement', function ($q) use ($departementIdsIa) {
                    $q->whereIn('id', $departementIdsIa);
                });
            }
            if ($this->selectedRegion) {
                $query->whereHas('commune.departement.region', function ($q) {
                    $q->where('id', $this->selectedRegion);
                });
            }
        } elseif ($isIef) {
            if ($this->selectedCommune) {
                $query->where('commune_id', $this->selectedCommune);
            } elseif (!empty($communeIdsIef)) {
                $query->whereIn('commune_id', $communeIdsIef);
            }
            if ($this->selectedDepartement) {
                $query->whereHas('commune.departement', function ($q) {
                    $q->where('id', $this->selectedDepartement);
                });
            }
            if ($this->selectedRegion) {
                $query->whereHas('commune.departement.region', function ($q) {
                    $q->where('id', $this->selectedRegion);
                });
            }
        } else {
            // Superadmin / agent : filtres libres
            if ($this->selectedCommune) {
                $query->where("commune_id", $this->selectedCommune);
            } elseif ($this->selectedDepartement) {
                $query->whereHas('commune.departement', function ($q) {
                    $q->where('id', $this->selectedDepartement);
                });
            } elseif ($this->selectedRegion) {
                $query->whereHas('commune.departement.region', function ($q) {
                    $q->where('id', $this->selectedRegion);
                });
            }
        }
    
        $count = $query->count();
        $this->count = $count;
        if ($count == 0) $this->startLimit = 0;
    
        $etablissements = $query->orderBy('id', 'desc')
            ->offset($this->startLimit)
            ->limit(10)
            ->get();
    
        return view('livewire.etablissements.liste-etablissement', [
            "etablissements" => $etablissements,
            "departements"   => $departements,
            "communes"       => $communes,
            "regions"        => $regions,
            "count"          => $count,
            'isIa'           => $isIa,
            'isIef'          => $isIef,
        ]);
    }
    private function isInspecteurSpecialite(): bool
    {
        $user = auth()->user();
    
        if (!$user || !$user->inspecteur || !$user->inspecteur->ia_id) {
            return false;
        }
    
        // Cas 1 : rôle exact "is" (code ou name)
        if ($user->hasRole('is')) {
            return true;
        }
    
        // Cas 2 : rôle contenant "inspect" et "spécial"
        return $user->roles->contains(function ($role) {
            $text = strtolower(trim(($role->name ?? '') . ' ' . ($role->code ?? '') . ' ' . ($role->description ?? '')));
            return str_contains($text, 'inspect')
                && (str_contains($text, 'special') || str_contains($text, 'spécial'));
        });
    }
}
