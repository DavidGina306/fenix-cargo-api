<?php

namespace App\Helpers;

class GenderHelper
{
    public static function getGenderValue(string $value)
    {
        switch ($value) {
            case 'Masculino':
                return "M";
            case 'Feminino':
                return "F";
            default:
                return "O";
        }
    }
}
