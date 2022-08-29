<?php

namespace App\Helpers;

class MoneyToDecimal
{
    public static function moneyToDecimal(string $value)
    {
        return str_replace(",", ".", str_replace(".", "", preg_replace("/([^0-9\\,.])/i", "", $value)));
    }
}
