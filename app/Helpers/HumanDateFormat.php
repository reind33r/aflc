<?php
namespace App\Helpers;

class HumanDateFormat {
    public static function format(\DateTime $date, $format='long', $time_format=false) {

        if($format == 'long') {
            $formatterDateFormat = \IntlDateFormatter::LONG;
        } elseif($format == 'full') {
            $formatterDateFormat = \IntlDateFormatter::FULL;
        } else {
            $formatterDateFormat = \IntlDateFormatter::SHORT;
        }

        if($time_format) {
            $formatterTimeFormat = \IntlDateFormatter::SHORT;
        } else {
            $formatterTimeFormat = \IntlDateFormatter::NONE;
        }

        $formatter = new \IntlDateFormatter('fr_FR', $formatterDateFormat, $formatterTimeFormat);

        return $formatter->format($date);
    }
}