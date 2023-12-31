<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected static function booted()
    {
        if (request()->segment(3) == "save-sizes-data") {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('active', 1);
            });
        }
    }

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
        "slider_image_ar",
        "slider_image_en",
        "hint_ar",
        "hint_en",
        "active",
    ];


    protected $appends = ['title', 'desc', 'box_categories_ids', 'slider_image', 'hint'];


    public function getHintAttribute()
    {
        if (\app()->getLocale() == "ar") {
            return $this->hint_ar;
        } else {
            return $this->hint_en;
        }
    }

    public function getSliderImageAttribute()
    {
        if (\app()->getLocale() == "ar") {
            return $this->slider_image_ar;
        } else {
            return $this->slider_image_en;
        }
    }

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
            $img_name = 'box_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/box/'), $img_name);
            $this->attributes['image'] = $img_name;
        } else {
            $this->attributes['image'] = $image;
        }
    }

    public function getSliderImageArAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/box') . '/' . $image;
        }
        return "";
    }

    public function setSliderImageArAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'slider_image_ar_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/box/'), $img_name);
            $this->attributes['slider_image_ar'] = $img_name;
        } else {
            $this->attributes['slider_image_ar'] = $image;
        }
    }

    public function getSliderImageEnAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/box') . '/' . $image;
        }
        return "";
    }

    public function setSliderImageEnAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'slider_image_en_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/box/'), $img_name);
            $this->attributes['slider_image_en'] = $img_name;
        } else {
            $this->attributes['slider_image_en'] = $image;
        }
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'box_categories', 'box_id', 'category_id');
    }

    public function categoriesByData($main_category_id, $filter_data)
    {

        return $this->categories()->with('products')
            ->whereHas('products', function ($q) use ($main_category_id, $filter_data) {

//                    ->whereHas('mainCategories', function ($q2) use ($main_category_id) {
//                    $q2->where('main_categories.id', $main_category_id);
//                })
                $q->where(function ($q_age) use ($filter_data) {
                    $q_age->where(function ($q_age2) use ($filter_data) {
                        $q_age2->where('min_age', '<=', $filter_data['age'])->where('max_age', '>=', $filter_data['age']);
                    })->orWhere(function ($q_age3) {
                        $q_age3->whereNull('min_age')->whereNull('max_age');
                    });
                })
                    ->where(function ($q_weight) use ($filter_data) {
                        $q_weight->where(function ($q_weight2) use ($filter_data) {
                            $q_weight2->where('min_weight', '<=', $filter_data['weight'])->where('max_weight', '>=', $filter_data['weight']);
                        })->orWhere(function ($q_weight3) {
                            $q_weight3->whereNull('min_weight')->whereNull('max_weight');
                        });
                    })
                    ->where(function ($q_height) use ($filter_data) {
                        $q_height->where(function ($q_height2) use ($filter_data) {
                            $q_height2->where('min_height', '<=', $filter_data['height'])->where('max_height', '>=', $filter_data['height']);
                        })->orWhere(function ($q_height3) {
                            $q_height3->whereNull('min_height')->whereNull('max_height');
                        });
                    })
                    ->where(function ($q_shoes) use ($filter_data) {
                        $q_shoes->where('shoes_size', $filter_data['shoes_size'])
                            ->orWhere('shoes_size', null);
                    })
                    ->where(function ($q_size) use ($filter_data) {
                        $q_size->where('size', $filter_data['size'])
                            ->orWhere('size', null);
                    });
            })->inRandomOrder()->get();
    }


    public function getBoxCategoriesIdsAttribute()
    {
        return $this->categories->pluck('id');
    }

    public function gifts()
    {
        return $this->belongsToMany(Gift::class, 'gift_boxes', 'box_id', 'gift_id');
    }

    public function offer_products()
    {
        return $this->belongsToMany(Product::class, 'box_products', 'box_id', 'product_id');
    }


}
