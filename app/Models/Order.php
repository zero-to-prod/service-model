<?php

namespace App\Models;

use App\Schemas\OrderSchema;
use ZeroToProd\ServiceModel\Model;

class Order extends Model
{
    protected ?string $schema = OrderSchema::class;
}