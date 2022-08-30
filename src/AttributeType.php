<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\DatetimeImmutableCast;
use ZeroToProd\ServiceModel\Casts\IntCast;
use ZeroToProd\ServiceModel\Casts\NullCast;
use ZeroToProd\ServiceModel\Casts\StringCast;

enum AttributeType
{
    case null;
    case int;
    case string;
    case datetime_immutable;

    public function makeAttribute(Attribute $attribute): CastsAttributes
    {
        return new (
        $attribute->cast_classname === NullCast::class
            ? $attribute->type->getCastClassname()
            : $attribute->cast_classname
        );
    }

    public function getCastClassname(): string
    {
        return match ($this) {
            self::null => NullCast::class,
            self::int => IntCast::class,
            self::string => StringCast::class,
            self::datetime_immutable => DatetimeImmutableCast::class,
        };
    }
}