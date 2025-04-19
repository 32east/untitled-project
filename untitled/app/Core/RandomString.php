<?php

namespace App\Core;

use Random\RandomException;

class RandomString
{
    /**
     * @throws RandomException
     */
    static public function generate($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString = $randomString . $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
