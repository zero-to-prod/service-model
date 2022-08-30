<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\DatetimeImmutableCast;
use ZeroToProd\ServiceModel\Casts\IntCast;
use ZeroToProd\ServiceModel\Casts\NullCast;
use ZeroToProd\ServiceModel\Casts\StringCast;

class Model
{
    /**
     * @var array<int, Attribute>
     */
    protected array $attributes;
    protected string $schema;

    public function __construct(array $attributes = [], Schema $schema = new Schema)
    {
        $this->registerAttributes($attributes, isset($this->schema) ? new $this->schema : $schema);
    }

    protected function registerAttributes(array $attributes, Schema $schema): void
    {
        if ($schema->getAttributes() === []) {
            return;
        }

        foreach ($schema->getAttributes() as $name => $attribute) {
            // Do not permit unregistered attributes.
            if (! isset($attributes[$name])) {
                continue;
            }

            $cast = $this->makeCast($attribute);
            $value = $cast->set($attributes[$name]);

            $this->registerAttribute($name, $attribute->type, $cast::class, $value);
        }
    }

    public function registerAttribute(
        string $name,
        AttributeType $type = AttributeType::null,
        string $cast = NullCast::class,
        $value = null
    ): void {
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
        $attribute = $this->attributes[$name] ?? null;

        if ($attribute === null) {
            return null;
        }

        return $this->makeCast($attribute)->get($attribute->value);
    }

    public function __set($name, $value)
    {
        $attribute = $this->attributes[$name] ?? null;

        if ($attribute === null) {
            $this->registerAttribute($name, value: $value);
        } else {
            $this->attributes[$name] = new Attribute($value, $attribute->type, $attribute->cast);
        }

    }

    public function __isset($name)
    {
    }

    public function toArray(): array
    {
        if (! isset($this->attributes)) {
            return [];
        }

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