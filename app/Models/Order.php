<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "box_id",
        "address_data",
        "main_category_id",
        "status",
        "payment_status",
        "payment_method",
        "price",
        "shipping_cost",
        "total",
        "delivered_at",
        "is_offer",
        "gift_type",
        "gift_money",
        "gift_data",
        "transaction_id",
    ];

    protected $appends = ['gift_data_json'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id');
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }


    public function getAddressDataAttribute($value)
    {
        if ($value != null) {
            return json_decode($value);
        }
        return "";

    }

    public function getGiftDataJsonAttribute()
    {
        if ($this->attributes['gift_data'] != null) {
            return json_decode($this->attributes['gift_data']);
        }
        return "";

    }

//
    public function setAddressDataAttribute($address)
    {
        if (isset($address) && $address != null) {
            $this->attributes['address_data'] = json_encode($address);
        }
    }

}
