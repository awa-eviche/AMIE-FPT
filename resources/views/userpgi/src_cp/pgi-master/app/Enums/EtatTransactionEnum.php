<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


abstract class EtatTransactionEnum extends Enum
{
    const COURS = 'en cours';
    const SIGNE =  'signé';
    const ANNULE =  'annulé';

}
