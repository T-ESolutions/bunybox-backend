<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "title_ar",
        "title_en",
        "image",
        "desc_ar",
        "desc_en",
        "quantity",
        "buy_price",
        "sel_price",
        "category_id",
        "shoes_size",
        "size",
        "min_age",
        "max_age",
        "min_weight",
        "max_weight",
        "min_height",
        "max_height",
    ];

    protected $appends = ['title', 'desc'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function getDescAttribute()
    {
        if (\app()->getLocale() == "ar") {
            return $this->desc_ar;
        } else {
            return $this->desc_en;
        }
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/product') . '/' . $image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'category_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/product/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'box_products', 'product_id', 'category_id');
    }


    public function mainCategories()
    {
        return $this->belongsToMany(MainCategory::class, 'product_main_categories', 'product_id', 'main_category_id');
    }
}
