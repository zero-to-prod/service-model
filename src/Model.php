<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\DatetimeImmutableCast;
use ZeroToProd\ServiceModel\Casts\IntCast;
use ZeroToProd\ServiceModel\Casts\NullCast;
use ZeroToProd\ServiceModel\Casts\StringCast;

class Model
{
    protected array $attributes = [];
    protected string $schema = '';

    public function __construct(array $attributes = [], ?Schema $schema = null)
    {
        $this->registerAttributes($attributes, $this->getSchema($schema));
    }

    protected function registerAttributes(array $attributes, Schema $schema): void
    {
        /** @var Type $type */
        foreach ($schema->attributes as $name => $type) {
            // Do not permit unregistered attributes.
            if (! isset($attributes[$name])) {
                continue;
            }

            $typecast_class_name = $this->getTypecastClassName($type);
            $value = (new $typecast_class_name)->set($attributes[$name]);

            $this->addAttribute($name, $value, $type->type, $typecast_class_name);
        }
    }

    private function getTypecastDefaults(DataType $type): string
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

        $cast = $this->getTypecastClassName($type);

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

    private function addAttribute($name, $value, DataType $type, string $typecast_class_name): void
    {
        $this->attributes[$name] = new Type($value, $type, $typecast_class_name);
    }

    protected function getTypecastClassName(Type $type): string
    {
        $default_cast = $this->getTypecastDefaults($type->type);

        return $type->cast === NullCast::class ? $default_cast : $type->cast;
    }

    /**
     * If there is a schema defined on the model use it.
     * If there is a schema defined in the constructor, use it.
     * If there is no schema defined create an empty one.
     */
    protected function getSchema(?Schema $schema): mixed
    {
        if ($this->schema !== '') {
            $selected_schema = new $this->schema;
        } elseif ($schema !== null) {
            $selected_schema = $schema;
        } else {
            $selected_schema = new Schema;
        }

        return $selected_schema;
    }
}