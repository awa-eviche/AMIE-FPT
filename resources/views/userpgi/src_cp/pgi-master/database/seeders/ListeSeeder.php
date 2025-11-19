<?php

namespace Database\Seeders;

use App\Models\Liste;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Liste::create(
            array(
                'libelle' => 'statut_juridique',
                'valeur' => 'GIE',

            ),
        );

        Liste::create(
            array(
                'libelle' => 'statut_juridique',
                'valeur' => 'Association individuelle et Autres',

            ),
        );


        Liste::create(
            array(
                'libelle' => 'type',
                'valeur' => 'Centre de Formation',

            ),
        );


        Liste::create(
            array(
                'libelle' => 'type',
                'valeur' => 'Lycée Technique',

            ),
        );


        Liste::create(
            array(
                'libelle' => 'type',
                'valeur' => 'Centre sectorielle',

            ),
        );


        Liste::create(
            array(
                'libelle' => 'type',
                'valeur' => 'Ecole de formation des formateurs',

            ),
        );


        Liste::create(
            array(
                'libelle' => 'statut',
                'valeur' => 'Privé',

            ),
        );

        
        Liste::create(
            array(
                'libelle' => 'statut',
                'valeur' => 'Public',

            ),
        );



    }
}
