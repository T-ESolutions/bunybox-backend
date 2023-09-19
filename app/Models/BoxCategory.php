<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        "box_id",
        "category_id",
    ];

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
