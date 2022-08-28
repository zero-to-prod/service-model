<?php

namespace ZeroToProd\ServiceModel\Casts;

use ZeroToProd\ServiceModel\CastsAttribute;

class NullCast implements CastsAttribute
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