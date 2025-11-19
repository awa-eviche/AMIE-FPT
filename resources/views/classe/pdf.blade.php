<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des apprenants - {{ $classe->libelle }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
<h1 style="font-size:16px;">
    <span style="font-weight:bold;">Etablissement :</span>
    <span style="font-weight:normal;">{{ $classe->etablissement->sigle ?? $classe->etablissement->nom }}</span>
</h1>

<h2 style="font-size:14px;">
    <span style="font-weight:bold;">Année académique :</span>
    <span style="font-weight:normal;">{{ $anneeAcademique->code ?? '-' }}</span>
</h2>

<h2 style="font-size:14px;">
    <span style="font-weight:bold;">Classe :</span>
    <span style="font-weight:normal;">{{ $classe->libelle }}</span>
</h2>

   

    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom & Prénoms</th>
                <th>Date de naissance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscriptions as $inscription)
                <tr>
                    <td>{{ $inscription->apprenant->matricule ?? '-' }}</td>
                    <td>{{ $inscription->apprenant->nom ?? '-' }} {{ $inscription->apprenant->prenom ?? '' }}</td>
                    <td>{{ optional($inscription->apprenant)->date_naissance ? \Carbon\Carbon::parse($inscription->apprenant->date_naissance)->format('d-m-Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
