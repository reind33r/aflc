<?php

function array_name_2_dotted($array_name) {
    return str_replace('[', '.', str_replace(']', '', $array_name));
}