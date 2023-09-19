<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $fillable = [
        "title_ar",
        "title_en",
        "image",
        "desc_ar",
        "desc_en",
        "price",
        "min_price",
        "max_price",
        "main_category_id",
        "is_offer",
        "offer_end_time",
        "offer_price",
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
            return asset('uploads/box') . '/' . $image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'category_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/box/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'box_category', 'box_id', 'category_id');
    }

    public function gifts()
    {
        return $this->belongsToMany(Gift::class, 'gift_boxes', 'box_id', 'gift_id');
    }
}
