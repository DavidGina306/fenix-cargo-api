<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

class StatusQuote extends Enum
{
    const ENEBLADE = 'E';  // Corrected the constant name
    const DISABLED = 'D';
    const WAITING = 'W';   // Corrected the constant name
    const CANCELLED = 'C';
    const APPROVAL = 'A';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::ENEBLADE:  // Corrected the constant name
                return 'Eneblade';
            case self::DISABLED:
                return 'Disabled';
            case self::WAITING:   // Corrected the constant name
                return 'Waiting';
            case self::APPROVAL:
                return 'Approval';
            case self::CANCELLED:
                return 'Cancelled';
            default:
                return parent::getDescription($value);
        }
    }
}
