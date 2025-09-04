<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\SerialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Casts\Attribute;

class StudentParent extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable,SoftDeletes,HasApiTokens,SearchFilterTrait,SerialTrait;

    protected $guard_name = 'parents';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'phone',
        'otp_code',
        'code_expired_at',
        'image',
        'status',
        'code',
    ];

    protected $table = "parents";

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
        return 'parent.'.$this->id;
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'guardian_phone', 'phone');
    }


    // Automatically set code attribute only on create
    protected static function booted()
    {
        static::creating(function ($parent) {
            if (empty($parent->code)) {
                $parent->code = $parent->createSerialNumber(self::class, 'Parent');
            }
        });
    }

}
