<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Apprenant;

class RegenererMatricules extends Command
{
    protected $signature = 'matricules:regenerer';
    protected $description = 'Régénère les matricules valides pour les apprenants TMPxxx';

    public function handle()
    {
        $apprenants = Apprenant::where('matricule', 'LIKE', 'TMP%')->get();

        $this->info("Nombre d'apprenants à corriger : " . $apprenants->count());

        $ordre = 1; // compteur local pour numéro d’ordre

        foreach ($apprenants as $apprenant) {
            try {
                $nouveauMatricule = $this->genererMatricule($apprenant, $ordre++);

                // S'assurer que le matricule est unique dans la base
                while (Apprenant::where('matricule', $nouveauMatricule)->exists()) {
                    $nouveauMatricule = $this->genererMatricule($apprenant, $ordre++);
                }

                $apprenant->matricule = $nouveauMatricule;
                $apprenant->save();

                $this->info("✅ Apprenant ID {$apprenant->id} corrigé : $nouveauMatricule");
            } catch (\Throwable $e) {
                $this->error("❌ Erreur avec ID {$apprenant->id} : " . $e->getMessage());
            }
        }

        $this->info("✅ Tous les matricules TMP ont été régénérés.");
    }

    private function genererMatricule($apprenant, $ordre)
    {
        $annee = date('Y');
        $annee1 = substr($annee, -2);

        // Gère 'homme', 'm', 'HOMME', etc.
        $sexe = match (strtolower($apprenant->sexe)) {
            'homme', 'm' => '1',
            'femme', 'f' => '2',
            default => throw new \Exception("Genre invalide pour ID {$apprenant->id}"),
        };

        $ordre = str_pad($ordre, 6, '0', STR_PAD_LEFT);
        $matriculeBase = $annee1 . $sexe . $ordre;

        $pairs = $impairs = 0;
        foreach (str_split($matriculeBase) as $i => $chiffre) {
            $chiffre = (int) $chiffre;
            if ($i % 2 == 0) {
                $pairs += $chiffre;
            } else {
                $impairs += $chiffre;
            }
        }

        $checksumIndex = abs($pairs - $impairs) % 26;
        $lettresAlphabet = range('A', 'Z');
        $checksumLettre = $lettresAlphabet[$checksumIndex];

        return $matriculeBase . $checksumLettre;
    }
}

