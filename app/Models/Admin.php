<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable,SoftDeletes,HasRoles,SearchFilterTrait;

    protected $guard_name = 'admin_api';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'phone',
        'status',
        'password',
    ];

    protected $table = "admins";

    protected $casts = ['created_at' => 'datetime:Y-m-d ( H:i )', 'updated_at' => 'datetime:Y-m-d ( H:i )'];

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

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.Models.Admin.'.$this->id;
    }

}
