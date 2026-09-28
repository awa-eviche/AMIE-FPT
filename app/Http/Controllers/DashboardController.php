<?php

namespace App\Http\Controllers;

use App\Services\DashboardStats;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $annee = $request->integer('annee') ?: null;

        return view('dashboard', [
            'dashboard' => DashboardStats::forUser($request->user(), $annee),
        ]);
    }

    /**
     * Tableau de saisie des devoirs et compositions (national / IA), chargé après la
     * page car son calcul est le plus lourd du dashboard.
     */
    public function saisie(Request $request)
    {
        $saisie = DashboardStats::saisieForUser($request->user(), $request->integer('annee') ?: null);

        return response()->json([
            'html' => $saisie ? view('dashboard._saisie', ['saisie' => $saisie])->render() : null,
        ]);
    }
}
