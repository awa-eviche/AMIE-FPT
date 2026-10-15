<?php

namespace App\Http\Controllers;

use App\Models\PersonnelEtablissement;
use App\Models\Etablissement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonnelMutationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAnyRole([
                'chef_etablissement', 'chef_de_travaux',
                'directeur_etude', 'surveillant', 'superadmin',
            ])) {
                abort(403);
            }
            return $next($request);
        });
    }

    // Liste
    public function index(Request $request)
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('superadmin');

        $query = PersonnelEtablissement::with(['user', 'etablissement'])
            ->where('actif', true);

        if (!$isSuperAdmin && $user->personnel) {
            $query->where('etablissement_id', $user->personnel->etablissement_id);
        }

        if ($request->filled('etablissement_id') && $isSuperAdmin) {
            $query->where('etablissement_id', $request->etablissement_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $personnels = $query->orderByDesc('date_debut')->paginate(15);

        $etablissements = $isSuperAdmin
            ? Etablissement::orderBy('nom')->get()
            : collect();

        return view('personnel.index-mutation', compact('personnels', 'etablissements', 'isSuperAdmin'));
    }

    // Formulaire
    public function create(PersonnelEtablissement $personnel)
    {
        if (!$personnel->actif) {
            return redirect()->route('personnel.muter.index')
                ->with('error', 'Ce personnel n\'a plus de séjour actif.');
        }

        $etablissements = Etablissement::orderBy('nom')->get();
        return view('personnel.muter', compact('personnel', 'etablissements'));
    }

    // Traitement
    public function store(Request $request, PersonnelEtablissement $personnel)
    {
        $validated = $request->validate([
            'nouveau_etablissement_id' => 'required|exists:etablissements,id',
            'date_mutation' => 'required|date',
            'fonction' => 'required|string|max:255',
            'specialite' => 'nullable|string|max:255',
            'motif' => 'nullable|string|max:500',
        ]);

        if (!$personnel->actif) {
            return back()->withErrors('Ce personnel n\'a plus de séjour actif.');
        }

        if ((int) $personnel->etablissement_id === (int) $validated['nouveau_etablissement_id']) {
            return back()->withErrors('Le nouvel établissement est identique à l\'actuel.');
        }

        DB::transaction(function () use ($validated, $personnel) {
            $personnel->update([
                'date_fin' => $validated['date_mutation'],
                'actif'    => false,
            ]);

            PersonnelEtablissement::create([
                'user_id'                     => $personnel->user_id,
                'etablissement_id'            => $validated['nouveau_etablissement_id'],
                'fonction'                    => $validated['fonction'],
                'specialite'                  => $validated['specialite'] ?? $personnel->specialite,
                'dernierDiplomeAcademique'    => $personnel->dernierDiplomeAcademique,
                'dernierDiplomeProfessionnel' => $personnel->dernierDiplomeProfessionnel,
                'interne'                     => $personnel->interne,
                'date_debut'                  => $validated['date_mutation'],
                'date_fin'                    => null,
                'actif'                       => true,
            ]);
        });

        return redirect()
            ->route('personnel.historique', $personnel->user_id)
            ->with('success', 'Personnel muté avec succès.');
    }

    // Historique
    public function historique($userId)
    {
        $user = User::with(['personnelHistorique.etablissement'])->findOrFail($userId);
        $historique = $user->personnelHistorique;

        return view('personnel.historique', compact('user', 'historique'));
    }


    public function historiqueIndex(Request $request)
{
    $user = Auth::user();
    $isSuperAdmin = $user->hasRole('superadmin');

    // Liste des personnels (actifs et historiques)
    $query = PersonnelEtablissement::with(['user', 'etablissement'])
        ->orderByDesc('date_debut');

    if (!$isSuperAdmin && $user->personnel) {
        $query->where('etablissement_id', $user->personnel->etablissement_id);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('user', function ($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%");
        });
    }

    $personnels = $query->paginate(20);

    return view('personnel.historique-index', compact('personnels', 'isSuperAdmin'));
}
}