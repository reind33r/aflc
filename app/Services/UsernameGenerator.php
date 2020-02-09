<?php

namespace App\Services;

use App\Models\User;

use function Rap2hpoutre\ConvertAccentCharacters\convert_accent_characters;

class UsernameGenerator {
    public static function usernameFromString($string) {
        $username = convert_accent_characters($string);
        $i = 1;

        while (User::where('username', $username)->exists()) {
            $username = $string . $i;
            $i++;
        }

        return $username;
    }

    public static function usernameFromName($first_name, $last_name) {
        return UsernameGenerator::usernameFromString(mb_strtolower(mb_substr($first_name, 0, 1) . $last_name));
    }
}