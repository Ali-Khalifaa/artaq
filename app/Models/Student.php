<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Student extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable,SoftDeletes,HasApiTokens,SearchFilterTrait;

    protected $guard_name = 'student_api';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'birth_date',
        'level_id',
        'phone',
        'guardian_phone',
        'memorization_type_id',
        'gender',
        'nationality_id',
        'country_id',
        'city_id',
        'memorization_amount_id',
        'image',
        'status',
        'password',
    ];

    protected $table = "students";

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getImageAttribute($value){
        return $value ? asset('upload/general/'.$value):asset('images/user.png');
    }

     protected function password(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => Hash::make($value),
        );
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.Models.User.'.$this->id;
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function memorizationType()
    {
        return $this->belongsTo(MemorizationType::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function memorizationAmount()
    {
        return $this->belongsTo(MemorizationAmount::class);
    }

}
