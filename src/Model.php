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

        /** @var string $key */
        /** @var Attribute $attribute */
        foreach ($schema->attributes as $key => $attribute) {
            // Do not permit unregistered attributes.
            if (! isset($attributes[$key])) {
                continue;
            }

            $cast  = $this->makeCast($attribute);
            $value = $cast->set($attributes[$key]);

            $this->registerAttribute($key, $value, $attribute->type, $cast::class);
        }
    }

    private function registerAttribute(string $name, $value, AttributeType $type, string $cast): void
    {
        $this->attributes[$name] = new Attribute($value, $type, $cast);
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
        /** @var Attribute $attribute */
        $attribute = $this->attributes[$name] ?? null;

        if ($attribute === null) {
            return $attribute?->value;
        }

        return $this->makeCast($attribute)->get($attribute->value);
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

        /** @var string $key */
        /** @var Attribute $attribute */
        foreach ($this->attributes as $key => $attribute) {
            $array[$key] = $this->attributes[$key]->value;
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