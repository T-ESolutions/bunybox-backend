<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        "box_id",
        "product_id",
    ];

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
