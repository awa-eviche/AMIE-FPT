<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    public function create(Inscription $inscription)
    {
        return view('absences.create', compact('inscription'));
    }


public function store(Request $request)
{
    
    $inscriptionMap = $request->input('inscription_id', []);

    if (!is_array($inscriptionMap) || empty($inscriptionMap)) {
        return back()->with('error', "Aucun apprenant trouvé.")->withInput();
    }

    $rows = [];

    foreach (array_keys($inscriptionMap) as $inscriptionId) {

        $semestre = $request->input("semestre.$inscriptionId");
        $type     = $request->input("type.$inscriptionId");

        $hAbs = $request->input("nombre_heure_absence.$inscriptionId");
        $hRet = $request->input("nombre_heure_retard.$inscriptionId");

        $justifie    = (int) $request->input("justifie.$inscriptionId", 0);
        $nonjustifie = (int) $request->input("nonjustifie.$inscriptionId", 0);

        // ✅ si rien n'est rempli pour cet apprenant => on skip
        $active = ($semestre !== null && $semestre !== '')
               || ($type !== null && $type !== '')
               || ($hAbs !== null && $hAbs !== '')
               || ($hRet !== null && $hRet !== '')
               || $justifie === 1
               || $nonjustifie === 1;

        if (!$active) continue;

        // règles obligatoires si actif
        if (!in_array($semestre, ['1','2'], true)) {
            return back()->with('error', "Semestre invalide pour l’apprenant #$inscriptionId.")->withInput();
        }
        if (!in_array($type, ['absence','retard'], true)) {
            return back()->with('error', "Type invalide pour l’apprenant #$inscriptionId.")->withInput();
        }

        // exclusivité
        if ($justifie === 1 && $nonjustifie === 1) {
            return back()->with('error', "Coche une seule option (Justifiée OU Non justifiée) pour #$inscriptionId.")->withInput();
        }

        // heures selon type
        if ($type === 'absence') {
            if ($hAbs === null || $hAbs === '') {
                return back()->with('error', "Nombre d'heures d’absence obligatoire pour #$inscriptionId.")->withInput();
            }
            $hRet = null;
        } else {
            if ($hRet === null || $hRet === '') {
                return back()->with('error', "Nombre d'heures de retard obligatoire pour #$inscriptionId.")->withInput();
            }
            $hAbs = null;
        }

        $rows[] = [
            'inscription_id'       => (int) $inscriptionId,
            'semestre'             => (int) $semestre,
            'type'                 => $type,
            'nombre_heure_absence' => $hAbs !== null && $hAbs !== '' ? (float) $hAbs : null,
            'nombre_heure_retard'  => $hRet !== null && $hRet !== '' ? (float) $hRet : null,
            'justifie'             => $justifie ? 1 : 0,
            'nonjustifie'          => $nonjustifie ? 1 : 0,
            'created_at'           => now(),
            'updated_at'           => now(),
        ];
    }

    if (empty($rows)) {
        return back()->with('error', "Aucune ligne à enregistrer : déplie un apprenant et renseigne les champs.")->withInput();
    }

    DB::transaction(fn() => Absence::insert($rows));

    return back()->with('success', count($rows) . " absence(s)/retard(s) enregistrée(s).");
}

      public function show($inscription_id)
    {
        $inscription = Inscription::with('apprenant')->findOrFail($inscription_id);


       

       return back()->with('success', 'Absence modifiée avec succès.');

    }


       public function edit($id)
{
    $absence = Absence::findOrFail($id);
    $inscription = $absence->inscription; 
   return back()->with('success', 'Absence modifiée avec succès.');

}

public function update(Request $request, $id)
{
    $absence = Absence::findOrFail($id);

    // ✅ Validation de base
    $data = $request->validate([
        'semestre'             => 'required|in:1,2',
        'type'                 => 'required|in:absence,retard',

        'nombre_heure_absence' => 'nullable|numeric|min:0',
        'nombre_heure_retard'  => 'nullable|numeric|min:0',

        // si tu as ce champ en DB
        'date_absence'         => 'nullable|date',
    ]);

    // ✅ Exclusivité : Justifiée OU Non justifiée (checkbox)
    $justifieChecked    = $request->has('justifie');
    $nonJustifieChecked = $request->has('nonjustifie');

    if ($justifieChecked && $nonJustifieChecked) {
        return back()->with('error', 'Veuillez cocher une seule option : Justifiée OU Non justifiée.');
    }

    // ✅ Enregistrement des colonnes
    $data['justifie']    = $justifieChecked ? 1 : 0;
    $data['nonjustifie'] = $nonJustifieChecked ? 1 : 0;

    // ✅ Heures selon type
    if ($data['type'] === 'absence') {

        // obligatoire pour absence
        if ($request->input('nombre_heure_absence') === null || $request->input('nombre_heure_absence') === '') {
            return back()->with('error', "Nombre d'heures d'absence obligatoire.");
        }

        // on neutralise l’autre
        $data['nombre_heure_retard'] = null;

    } else { // retard

        // obligatoire pour retard
        if ($request->input('nombre_heure_retard') === null || $request->input('nombre_heure_retard') === '') {
            return back()->with('error', "Nombre d'heures de retard obligatoire.");
        }

        // on neutralise l’autre
        $data['nombre_heure_absence'] = null;
    }

    // ✅ Ne pas écraser date_absence si non envoyée
    if (! $request->filled('date_absence')) {
        unset($data['date_absence']);
    }

    $absence->update($data);

    return back()->with('success', 'Absence modifiée avec succès.');
}



}
