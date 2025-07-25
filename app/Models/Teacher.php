<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use \App\Traits\SerialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Teacher extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable,SoftDeletes,HasApiTokens,SearchFilterTrait,SerialTrait;


    protected $guard_name = 'teacher_api';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'phone',
        'id_number',
        'gender',
        'admin_id',
        'nationality_id',
        'country_id',
        'city_id',
        'image',
        'status',
        'password',
        'birth_date',
        'email',
        'juz_count',
        'experience_years',
        'Quran_licenses',
        'salary',
        'cv',
        'code',
    ];

    protected $table = "teachers";

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

    public function getCvAttribute($value){
        return $value ? asset('upload/general/'.$value):null;
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
        return 'App.Models.Teacher.'.$this->id;
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
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

    public function qualifications()
    {
        return $this->hasMany(TeacherQualification::class, 'teacher_id');
    }

    public function circles()
    {
        return $this->belongsToMany(Circle::class, 'teacher_circles', 'teacher_id', 'circle_id');
    }

    // Automatically set code attribute only on create
    protected static function booted()
    {
        static::creating(function ($teacher) {
            if (empty($teacher->code)) {
                $teacher->code = $teacher->createSerialNumber(self::class, 'Teacher');
            }
        });
    }

}
