<?php

namespace App\Models;

use App\Schemas\OrderSchema;
use ZeroToProd\ServiceModel\Model;

class Order extends Model
{
    protected string $schema = OrderSchema::class;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'contacts');
    }
}