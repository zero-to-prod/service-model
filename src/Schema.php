<?php

namespace ZeroToProd\ServiceModel;

use ZeroToProd\ServiceModel\Casts\NullCast;

class Schema
{
    /**
     * @var array<int, Attribute>
     */
    private array $attributes;

    public function registerAttribute(string $name, AttributeType $type = AttributeType::null, string $cast = NullCast::class, string $rename = null, string $alias = null): void
    {
        if($rename === null && $alias === null){
            $this->attributes[$name] = new Attribute($name, $type, $cast);
        }
        if($rename !== null && $alias === null) {
            $this->attributes[$name] = new Attribute($rename, $type, $cast);
        }

        if ($alias !== null && $rename === null) {
            $this->attributes[$name] = new Attribute($name, $type, $cast, $alias);
        }
    }

    /**
     * @return array<int, Attribute>
     */
    public function getAttributes(): array
    {
        return $this->attributes ?? [];
    }
}