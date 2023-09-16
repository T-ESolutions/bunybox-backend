<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject

{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','about_ar','about_en','country_id','city_id','state_id','username','image','phone','fcm_token','country_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/clients_images') . '/' . $image;
        }
        return asset('defaults/user_default.png');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'user_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/clients_images/'), $img_name);
            $this->attributes['image'] = $img_name;
        }
    }
    public function getCoverAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/clients_images') . '/' . $image;
        }
        return asset('defaults/user_default.png');
    }

    public function setCoverAttribute($image)
    {
        if (is_file($image)) {
            $img_name = 'user_' . time() . random_int(0000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/clients_images/'), $img_name);
            $this->attributes['cover'] = $img_name;
        }
    }
    public function Country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    public function City(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function State(){
        return $this->belongsTo(State::class,'state_id');
    }

    public function Products(){
        return $this->HasMany(Product::class,'user_id');
    }

    public function Rates(){
        return $this->HasMany(Rate::class,'profile_id');
    }
    public function followers(){
        return $this->HasMany(Follower::class,'profile_id');
    }
    public function following(){
        return $this->HasMany(Follower::class,'user_id');
    }

}
