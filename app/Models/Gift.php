<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
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
        "title_ar",
        "title_en",
        "image",
        "type",
        "money_amount",
        "money_out",
        "money_remain",
        'active'
    ];


    protected $appends = ['title'];

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "ar") {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }


    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/gift') . '/' . $image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'category_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/gift/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }

    public function moneyDetails()
    {
        return $this->hasMany(GiftMoneyDetail::class, 'gift_id');
    }

    public function mainCategories()
    {
        return $this->belongsToMany(MainCategory::class, 'gift_main_categories', 'gift_id', 'main_category_id');
    }

    public function mainCats()
    {
        return $this->hasMany(GiftMainCategory::class, 'gift_id');
    }

    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'gift_boxes', 'gift_id', 'box_id');
    }
}
