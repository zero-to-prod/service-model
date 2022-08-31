<?php

namespace App\Models;

use App\Schemas\ContactSchema;
use ZeroToProd\ServiceModel\Model;

class Contact extends Model
{
    protected string $schema = ContactSchema::class;
}