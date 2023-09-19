<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $fillable = [
        'title_ar',
        'title_en',
        'image',
        'desc_ar',
        'desc_en',
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
            return asset('uploads/category') . '/' . $image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'category_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/category/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }

    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'box_category', 'category_id', 'box_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'box_products', 'category_id', 'product_id');
    }


}