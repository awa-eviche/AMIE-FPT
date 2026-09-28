<!DOCTYPE html>
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Liste des Filières</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a1a; margin: 20px; }
    h1 { font-size: 18px; text-align: center; margin-bottom: 4px; }
    .subtitle { text-align: center; font-size: 11px; color: #555; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    thead tr { background-color: #e87722; color: #fff; }
    th { padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
    td { padding: 7px 10px; font-size: 11px; border-bottom: 1px solid #e5e7eb; }
    tbody tr:nth-child(even) { background-color: #f9fafb; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; background-color: #fee2c8; color: #c04c00; }
    .footer { margin-top: 20px; font-size: 9px; color: #999; text-align: right; }
    .total { margin-top: 8px; font-weight: bold; font-size: 11px; }
</style>
</head>
<body>

<h1>Liste des Filières</h1>
<div class="subtitle">Édité le {{ date('d/m/Y') }}</div>

<table>
    <thead>
        <tr>
            <th style="width:5%">N°</th>
            <th style="width:55%">Libellé</th>
            <th style="width:40%">Secteur</th>
        </tr>
    </thead>
    <tbody>
        @forelse($filieres as $i => $filiere)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $filiere->nom }}</td>
            <td><span class="badge">{{ $filiere->secteur->libelle ?? '-' }}</span></td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align:center; color:#999; padding:16px;">Aucune filière trouvée.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="total">Total : {{ $filieres->count() }} filière(s)</div>

<div class="footer">Généré automatiquement — AMIE-FPT</div>

</body>
</html>
