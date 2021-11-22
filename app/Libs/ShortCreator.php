<?php

namespace App\Libs;


class ShortCreator
{

    public static function create(string $timeDelta): string
    {
        return base_convert($timeDelta, 10, 35);
    }

    public static function parseLink(string $short, $bytes)
    {
        $table = self::prepareTableName(substr($short, 0, $bytes), $bytes);

        $shortLink = substr($short, $bytes);

        return [$table, $shortLink];
    }

    protected static function prepareTableName($table, $bytes)
    {

        $basestring = '';
        for ($i = 0; $i < $bytes; $i++) {
            if ($table[$i] != '0') {
                $basestring .= $table[$i];
            }
        }

        return $basestring;
    }

}
