<?php
namespace App\Helpers;

class CurrencyFormat {
    public static function format($value, $currency='€') {
        if($currency == '€') {
            $eur = intdiv($value, 100);
            $cents = sprintf("%02d", $value % 100);

            return $eur.','.$cents.'€';
        }
    }
}