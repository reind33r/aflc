<?php
namespace App\Helpers;

class PhoneFormat {
    public static function format($phone, $separator=' ') {
        return implode($separator, str_split($phone, 2));
    }
}