<?php

namespace App\Schemas;

use App\Casts\PlusOneCast;
use ZeroToProd\ServiceModel\AttributeType;
use ZeroToProd\ServiceModel\Schema;

class CustomerSchema extends Schema
{
    public function __construct()
    {
        $this->registerAttribute('id', AttributeType::int);
        $this->registerAttribute('name', AttributeType::string);
        $this->registerAttribute('due_date', AttributeType::datetime_immutable);
        $this->registerAttribute('created_at', AttributeType::datetime_immutable);
        $this->registerAttribute('updated_at', AttributeType::datetime_immutable);
    }
}