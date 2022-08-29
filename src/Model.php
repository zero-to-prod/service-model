<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\DatetimeImmutableCast;
use ZeroToProd\ServiceModel\Casts\IntCast;
use ZeroToProd\ServiceModel\Casts\NullCast;
use ZeroToProd\ServiceModel\Casts\StringCast;

class Model
{
    protected array $attributes = [];
    protected ?string $schema = null;

    public function __construct(array $attributes = [], ?Schema $schema = null)
    {
        $this->registerAttributes($attributes, $this->getSchema($schema));
    }

    protected function registerAttributes(array $attributes, Schema $schema): void
    {
        /** @var Type $type */
        foreach ($schema->types as $name => $type) {
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

    public function toArray(): ?array
    {
        if ($this->attributes === []) {
            return null;
        }
        $array = [];
        foreach ($this->attributes as $key => $value) {
            $array[$key] = $this->attributes[$key]->value;
        }

        return $array;
    }

    private function addAttribute($name, $value, DataType $type, string $cast): void
    {
        $this->attributes[$name] = new Type($value, $type, $cast);
    }

    protected function getCast(Type $type): string
    {
        $default_cast = $this->castDefaults($type->type);

        return $type->cast === NullCast::class ? $default_cast : $type->cast;
    }

    protected function getSchema(?Schema $schema): mixed
    {
        if ($this->schema !== null) {
            $selected_schema = new $this->schema;
        } elseif ($schema !== null) {
            $selected_schema = $schema;
        } else {
            $selected_schema = new Schema;
        }

        return $selected_schema;
    }
}