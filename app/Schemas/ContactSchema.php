<?php

namespace App\Schemas;

use App\Casts\PlusOneCast;
use ZeroToProd\ServiceModel\AttributeType;
use ZeroToProd\ServiceModel\Schema;

class ContactSchema extends Schema
{
    public function __construct()
    {
        $this->registerAttribute('id', AttributeType::int);
        $this->registerAttribute('name', AttributeType::string);
    }
}