<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "main_category_id",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }
}
