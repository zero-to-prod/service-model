<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\NullCast;

class Attribute
{
    public function __construct(
        public mixed $value,
        public readonly AttributeType $type = AttributeType::null,
        public readonly string $cast = NullCast::class
    ) {
    }
}