<?php

namespace ZeroToProd\ServiceModel\Casts;

use ZeroToProd\ServiceModel\CastsAttributes;

class IntCast implements CastsAttributes
{
    public function get($value): int
    {
        return (int)$value;
    }

    public function set($value): int
    {
        return (int)$value;
    }
}