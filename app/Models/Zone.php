<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "coordinates",
        "status",
        "restaurant_wise_topic",
        "customer_wise_topic",
        "deliveryman_wise_topic",
        "type",
    ];
}
