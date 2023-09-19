<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftBox extends Model
{
    use HasFactory;

    protected $fillable = [
        "gift_id",
        "box_id",
    ];

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id');
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }
}
