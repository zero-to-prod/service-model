<?php

namespace App\Casts;

use ZeroToProd\ServiceModel\CastsAttributes;

class TitleCast implements CastsAttributes
{
    public function get($value): string
    {
        return strtoupper($value);
    }

    public function set($value): string
    {
        return strtoupper($value);
    }
}