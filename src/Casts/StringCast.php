<?php

namespace ZeroToProd\ServiceModel\Casts;

use ZeroToProd\ServiceModel\CastsAttributes;

class StringCast implements CastsAttributes
{
    public function get($value): string
    {
        return (string)$value;
    }

    public function set($value): string
    {
        return (string)$value;
    }
}