<?php

namespace ZeroToProd\ServiceModel\Casts;

use ZeroToProd\ServiceModel\CastsAttribute;

class StringCast implements CastsAttribute
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