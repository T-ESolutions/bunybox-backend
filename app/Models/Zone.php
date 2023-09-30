<?php

namespace App\Models;

use App\Scopes\ZoneScope;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory,SpatialTrait;
    protected $guarded = [''];


    protected $casts = [
        'id'=>'integer',
        'status'=>'integer',
    ];

    protected $spatialFields = [
        'coordinates'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }
}
