<?php

namespace ZeroToProd\ServiceModel\Casts;

use ZeroToProd\ServiceModel\CastsAttributes;

class NullCast implements CastsAttributes
{
    public function get($value): string
    {
        return $value;
    }

    public function set($value): string
    {
        return $value;
    }
}