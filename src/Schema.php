<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\NullCast;

class Schema
{
    public array $types = [];

    public function registerType(string $name, DataType $type = DataType::null, string $cast = NullCast::class): void
    {
        $this->types[$name] = new Type($name, $type, $cast);
    }
}