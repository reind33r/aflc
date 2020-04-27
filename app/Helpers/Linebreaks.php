<?php
namespace App\Helpers;

class Linebreaks {
    public static function format($text, $make_paragraphs=True) {
        $normalized = preg_replace('/\\r\\n|\\r/', "\n", $text);

        if($make_paragraphs) {
            $paras = preg_split('/(\n){2,}/', $normalized);

            foreach($paras as &$para) {
                $para = '<p>' . str_replace("\n", "<br>\n", $para) . '</p>';
            }
            unset($para);

            return implode("\n", $paras);
        } else {
            return preg_replace('/\n/', '<br>', $normalized);
        }
    }
}
