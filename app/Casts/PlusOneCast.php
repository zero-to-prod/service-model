<?php

namespace App\Casts;

use ZeroToProd\ServiceModel\CastsAttribute;

class PlusOneCast implements CastsAttribute
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