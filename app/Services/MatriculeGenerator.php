<?php
namespace App\Services;

use App\Models\Apprenant;

class MatriculeGenerator
{
    public static function genererMatricule(string $sexe)
    {
        $annee = date('Y');
        $annee1 = substr($annee, -2);

        $sexe = strtolower(trim($sexe));
        if (in_array($sexe, ['Homme', 'h', 'm'])) {
            $sexeCode = '1';
        } elseif (in_array($sexe, ['Femme', 'f'])) {
            $sexeCode = '2';
        } else {
            $sexeCode = '0'; // Valeur par défaut ou erreur
        }

        $lastID = Apprenant::max("id") ?? 0;
        $ordre = str_pad($lastID + 1, 5, '0', STR_PAD_LEFT);

        $concat = $annee1 . $sexeCode . $ordre;

        $valPair = [];
        $valImpair = [];

        foreach (str_split($concat) as $i => $chiffre) {
            $chiffre = (int) $chiffre;
            if ($i % 2 == 0) {
                $valPair[] = $chiffre;
            } else {
                $valImpair[] = $chiffre;
            }
        }

        $sommePair = array_sum($valPair);
        $sommeImpair = array_sum($valImpair);
        $checksum = $sommePair - $sommeImpair + 1;

        $lettresAlphabet = range('A', 'Z');
        if ($checksum < 0) {
            $checksumLettre = $lettresAlphabet[abs($checksum) % 26];
        } elseif ($checksum >= 26) {
            $checksumLettre = 'Z';
        } else {
            $checksumLettre = $lettresAlphabet[$checksum];
        }

        return $concat . $checksumLettre;
    }
}
