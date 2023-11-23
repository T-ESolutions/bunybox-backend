<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        "key",
        "value",
        "image",
    ];

    protected $hidden = ['created_at','updated_at'];

    public static function setMany($data)
    {
        foreach ($data as $key => $value) {
            Self::set($key, $value);
        }
    }

    public static function set($key, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        Self::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/setting') . '/' . $image;
        }
        return asset('defaults/default_image.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'setting_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/setting/'), $img_name);
            $this->attributes['image'] = $img_name;
        }else{
            $this->attributes['image'] = $image;
        }
    }
}
