<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\NullCast;

class Schema
{
    public array $attributes = [];

    public function registerAttribute(string $name, AttributeType $type = AttributeType::null, string $cast = NullCast::class): void
    {
        $this->attributes[$name] = new Attribute($name, $type, $cast);
    }
}