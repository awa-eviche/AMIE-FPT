<!DOCTYPE html>
<html>
<head>
    <title>Rapport d'évaluation</title>
</head>
<body>
    <h1>Rapport d'évaluation pour l'apprenant {{ optional($evaluation->inscription)->apprenant->nom ?? 'Non disponible' }} {{ optional($evaluation->inscription)->apprenant->prenom ?? 'Non disponible' }}</h1>
    <p>Semestre: {{ $evaluation->semestre }}</p>
    <p>Matière: {{ optional($evaluation->matiere)->nom ?? 'Non disponible' }}</p>
    <p>Coef: {{ $evaluation->coef }}</p>
    <p>Note CC: {{ $evaluation->note_cc }}</p>
    <p>Note Composition: {{ $evaluation->note_composition }}</p>
</body>
</html>
