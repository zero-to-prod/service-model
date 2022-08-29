<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\DatetimeImmutableCast;
use ZeroToProd\ServiceModel\Casts\IntCast;
use ZeroToProd\ServiceModel\Casts\NullCast;
use ZeroToProd\ServiceModel\Casts\StringCast;

class Model
{
    protected array $attributes;
    protected string $schema;

    public function __construct(array $attributes = [], Schema $schema = new Schema)
    {
        $this->registerAttributes($attributes, isset($this->schema) ? new $this->schema : $schema);
    }

    protected function registerAttributes(array $attributes, Schema $schema): void
    {
        /** @var Attribute $type */
        foreach ($schema->attributes as $name => $type) {
            // Do not permit unregistered attributes.
            if (! isset($attributes[$name])) {
                continue;
            }

            $attribute_cast = $this->makeCast($type);
            $value          = $attribute_cast->set($attributes[$name]);

            $this->registerAttribute($name, $value, $type->type, $attribute_cast::class);
        }
    }

    private function getCastClassname(AttributeType $type): string
    {
        return match ($type) {
            AttributeType::null => NullCast::class,
            AttributeType::int => IntCast::class,
            AttributeType::string => StringCast::class,
            AttributeType::datetime_immutable => DatetimeImmutableCast::class,
        };
    }

    public function __get($name)
    {
        /** @var Attribute $type */
        $type = $this->attributes[$name] ?? null;
        if ($type === null) {
            return $type?->value;
        }

        return $this->makeCast($type)->get($type->value);
    }

    public function __set($name, $value)
    {
        $this->registerAttribute($name, $value, AttributeType::null, NullCast::class);
    }

    public function __isset($name)
    {
    }

    public function toArray(): ?array
    {
        if (! isset($this->attributes)) {
            return null;
        }
        $array = [];
        foreach ($this->attributes as $name => $value) {
            $array[$name] = $this->attributes[$name]->value;
        }

        return $array;
    }

    private function registerAttribute($name, $value, AttributeType $type, string $cast_class_name): void
    {
        $this->attributes[$name] = new Attribute($value, $type, $cast_class_name);
    }

    protected function makeCast(Attribute $type): CastsAttributes
    {
        return new (
        $type->cast_classname === NullCast::class
            ? $this->getCastClassname($type->type)
            : $type->cast_classname
        );
    }
}