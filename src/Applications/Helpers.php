<?php


namespace App\Applications;


class Helpers
{
    public static function randomString($length = 10)
    {
        return substr(str_shuffle(md5(microtime())), 0, $length);
    }
}