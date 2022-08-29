<?php

namespace App\Schemas;

use App\Casts\PlusOneCast;
use ZeroToProd\ServiceModel\DataType;
use ZeroToProd\ServiceModel\Schema;

class OrderSchema extends Schema
{
    public function __construct()
    {
        $this->registerAttribute('id', DataType::int);
        $this->registerAttribute('plus_one', DataType::int, PlusOneCast::class);
        $this->registerAttribute('name', DataType::string);
        $this->registerAttribute('due_date', DataType::datetime_immutable);
        $this->registerAttribute('created_at', DataType::datetime_immutable);
        $this->registerAttribute('updated_at', DataType::datetime_immutable);
    }
}