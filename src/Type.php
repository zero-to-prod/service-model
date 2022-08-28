<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\NullCast;

class Type
{
    public function __construct(
        public mixed $value,
        public DataType $type = DataType::null,
        public string $cast = NullCast::class
    ) {
    }
}