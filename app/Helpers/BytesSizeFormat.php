<?php
namespace App\Helpers;

class BytesSizeFormat {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array('bits', 'Ko', 'M', 'Go', 'To');

            return str_replace('.', ',', round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)]);
        } else {
            return $size;
        }
    }

}