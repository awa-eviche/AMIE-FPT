<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MarriageStatus extends Enum
{
    const SINGLE = 'Célibataire';
    const MARRIED =  'Marié';
    const DIVORCED = 'Divorcé';
    const WIDOWED =  'Veuf';
}
