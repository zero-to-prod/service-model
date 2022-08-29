<?php

namespace ZeroToProd\ServiceModel\Casts;

use DateTimeImmutable;
use Exception;
use ZeroToProd\ServiceModel\CastsAttributes;

class DatetimeImmutableCast implements CastsAttributes
{
    public function get($value): DateTimeImmutable
    {
        return $this->cast($value);
    }

    public function set($value): DateTimeImmutable
    {
        return $this->cast($value);
    }

    private function cast($value): DateTimeImmutable
    {
        if (is_a($value, DateTimeImmutable::class)) {
            return $value;
        }
        try {
            return new DateTimeImmutable($value);
        } catch (Exception) {
        }

        return new DateTimeImmutable;
    }
}