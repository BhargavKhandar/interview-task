<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'manufactuer',
        'product_type',
        'price',
        'km',
        'month',
        'vehicle_type'
    ];
}
