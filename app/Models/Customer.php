<?php

namespace App\Models;

use App\Schemas\CustomerSchema;
use ZeroToProd\ServiceModel\Model;

class Customer extends Model
{
    protected string $schema = CustomerSchema::class;
}