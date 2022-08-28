<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\DatetimeImmutableCast;
use ZeroToProd\ServiceModel\Casts\IntCast;
use ZeroToProd\ServiceModel\Casts\NullCast;
use ZeroToProd\ServiceModel\Casts\StringCast;

class Model
{
    protected array $attributes;

    public function __construct(array $attributes = [], Schema $schema = new Schema)
    {
        $this->registerAttributes($attributes, $schema);
    }

    protected function registerAttributes(array $attributes, Schema $schema): void
    {
        /** @var Type $type */
        foreach ($schema->attributes as $name => $type) {
            if (! isset($attributes[$name])) {
                $this->attributes[$name] = null;
                continue;
            }

            $cast  = $this->getCast($type);
            $value = (new $cast)->set($attributes[$name]);

            $this->addAttribute($name, $value, $type->type, $cast);
        }
    }

    private function castDefaults(DataType $type): string
    {
        return match ($type) {
            DataType::null => NullCast::class,
            DataType::int => IntCast::class,
            DataType::string => StringCast::class,
            DataType::datetime_immutable => DatetimeImmutableCast::class,
        };
    }

    public function __get($name)
    {
        /** @var Type $type */
        $type = $this->attributes[$name] ?? null;
        if ($type === null) {
            return $type?->value;
        }

        $cast = $this->getCast($type);

        return (new $cast)->get($type->value);
    }

    public function __set($name, $value)
    {
        $this->addAttribute($name, $value, DataType::null, NullCast::class);
    }

    public function __isset($name)
    {
    }

    private function addAttribute($name, $value, DataType $type, string $cast): void
    {
        $this->attributes[$name] = new Type($value, $type, $cast);
    }

    /**
     * @param  \ZeroToProd\ServiceModel\Type  $type
     *
     * @return string
     */
    protected function getCast(Type $type): string
    {
        $default_cast = $this->castDefaults($type->type);

        return $type->cast === NullCast::class ? $default_cast : $type->cast;
    }
}