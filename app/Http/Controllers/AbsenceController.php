<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Absence;

class AbsenceController extends Controller
{
    public function create(Inscription $inscription)
    {
        return view('absences.create', compact('inscription'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'date_absence' => 'required|date',
            'semestre' => 'required',

            'type' => 'required|in:absence,retard',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after_or_equal:heure_debut',
            'minutes_retard' => 'nullable|integer|min:0',
            'motif' => 'nullable|string|max:255',
            'justifie' => 'boolean',
        ]);

        if ($validated['type'] === 'absence' && $request->heure_debut && $request->heure_fin) {
            $start = strtotime($request->heure_debut);
            $end = strtotime($request->heure_fin);
            $validated['duree'] = round(($end - $start) / 60); // en minutes
        }

        Absence::create($validated);

        return redirect()->back()->with('success', 'Absence enregistrée avec succès.');
    }
      public function show($inscription_id)
    {
        $inscription = Inscription::with('apprenant')->findOrFail($inscription_id);

        // 🔸 Récupération des absences triées par date
        $absences = Absence::where('inscription_id', $inscription_id)
            ->orderBy('date_absence', 'desc')
            ->get();

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

    $validated = $request->validate([
        'date_absence' => 'required|date',
        'semestre' => 'required',
        'type' => 'required|in:absence,retard',
        'heure_debut' => 'nullable|date_format:H:i',
        'heure_fin' => 'nullable|date_format:H:i|after_or_equal:heure_debut',
        'minutes_retard' => 'nullable|integer|min:0',
        'motif' => 'nullable|string|max:255',
        'justifie' => 'boolean',
    ]);


    if ($validated['type'] === 'absence' && $request->heure_debut && $request->heure_fin) {
        $start = strtotime($request->heure_debut);
        $end = strtotime($request->heure_fin);
        $validated['duree'] = round(($end - $start) / 60); 
    }

    $absence->update($validated);

   return back()->with('success', 'Absence modifiée avec succès.');

}

}
