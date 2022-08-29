<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\NullCast;

class Attribute
{
    public function __construct(
        public mixed $value,
        public AttributeType $type = AttributeType::null,
        public string $cast = NullCast::class
    ) {
    }
}