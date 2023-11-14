<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'image',
        'desc_ar',
        'desc_en',
        'active'
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
            return asset('uploads/main_category') . '/' . $image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'category_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/main_category/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }

    public function boxes()
    {
        return $this->hasMany(Box::class, 'main_category_id');
    }

    public function gifts()
    {
        return $this->belongsToMany(Gift::class, 'gift_main_categories', 'main_category_id', 'gift_id');
    }
}
