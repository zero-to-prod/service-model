<?php

namespace App\Casts;

use ZeroToProd\ServiceModel\CastsAttributes;

class PlusOneCast implements CastsAttributes
{
    public function get($value): int
    {
        return (int)$value + 1;
    }

    public function set($value): int
    {
        return (int)$value;
    }
}