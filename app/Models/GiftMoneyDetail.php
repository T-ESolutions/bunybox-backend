<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftMoneyDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "gift_id",
        "amount",
        "is_selected",
    ];

    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }
}
