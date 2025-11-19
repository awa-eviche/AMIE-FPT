<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


abstract class TypeNotification extends Enum
{
    const EMAIL = 'email';
    const SYSTEME =  'systeme';
    const SMS =  'sms';

}
