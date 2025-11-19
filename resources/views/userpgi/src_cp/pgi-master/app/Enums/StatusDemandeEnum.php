<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


abstract class StatusDemandeEnum extends Enum
{
    const BROUILLON = 'brouillon';
    const COURS =  'en cours';
    const REJETE =  'rejeté';
    const ATTENTE =  'attente de complément';
    const AVIS_DEFAVORABLE =  'non_favorable';
    const AVIS_FAVORABLE =  'favorable';
    const VALIDE =  'validé';


    

}
