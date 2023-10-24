<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftMainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        "gift_id",
        "main_category_id"
    ];

    protected $appends = [
        "main_category_ar"
    ];

    public function getMainCategoryArAttribute()
    {
        if($this->mainCategory())
            return $this->mainCategory()->first()->title_ar;
    }

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }
}
