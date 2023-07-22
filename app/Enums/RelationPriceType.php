<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

class RelationPriceType extends Enum
{
    const PARTNER = 'P';
    const COMPANY = 'C';
    const FENIX = 'F';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::PARTNER:
                return 'Partern';
            case self::COMPANY:
                return 'Company';
            case self::FENIX:
                return 'Fenix';
            default:
                return parent::getDescription($value);
        }
    }
}
