<?php

namespace App\Schemas;

use App\Casts\PlusOneCast;
use ZeroToProd\ServiceModel\DataType;
use ZeroToProd\ServiceModel\Schema;

class OrderSchema extends Schema
{
    public function __construct()
    {
        $this->registerType('id', DataType::int);
        $this->registerType('plus_one', DataType::int, PlusOneCast::class);
        $this->registerType('name', DataType::string);
        $this->registerType('due_date', DataType::datetime_immutable);
        $this->registerType('created_at', DataType::datetime_immutable);
        $this->registerType('updated_at', DataType::datetime_immutable);
    }
}