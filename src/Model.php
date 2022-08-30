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
        if (! isset($schema->attributes)) {
            return;
        }

        /** @var Attribute $attribute */
        foreach ($schema->attributes as $name => $attribute) {
            // Do not permit unregistered attributes.
            if (! isset($attributes[$name])) {
                continue;
            }

            $cast  = $this->makeCast($attribute);
            $value = $cast->set($attributes[$name]);

            $this->registerAttribute($name, $value, $attribute->type, $cast::class);
        }
    }

    private function registerAttribute($name, $value, AttributeType $type, string $cast_class_name): void
    {
        $this->attributes[$name] = new Attribute($value, $type, $cast_class_name);
    }

    private function getDefaultCastFQNS(AttributeType $type): string
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

    public function toArray(): array
    {
        if (! isset($this->attributes)) {
            return [];
        }

        foreach ($this->attributes as $name => $value) {
            $array[$name] = $this->attributes[$name]->value;
        }

        return $array ?? [];
    }

    protected function makeCast(Attribute $attribute): CastsAttributes
    {
        return new (
        $attribute->cast === NullCast::class
            ? $this->getDefaultCastFQNS($attribute->type)
            : $attribute->cast
        );
    }
}