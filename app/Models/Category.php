<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected static function booted()
    {
        if (request()->segment(1) == "api") {


            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('active', 1);
            });
        }
    }

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
        return $this->hasMany(Product::class, 'category_id');
    }

    public function randomProducts()
    {
        return $this->hasMany(Product::class, 'category_id')->inRandomOrder();
    }


    public function testProducts($product)
    {
        return  $product;
    }


}
