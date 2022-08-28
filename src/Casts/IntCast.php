<?php

namespace ZeroToProd\ServiceModel\Casts;

use ZeroToProd\ServiceModel\CastsAttribute;

class IntCast implements CastsAttribute
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