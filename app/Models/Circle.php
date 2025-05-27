<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circle extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "circles";


    public function circleDurations()
    {
        return $this->hasMany(CircleDuration::class);
    }
    public function circleType()
    {
        return $this->belongsTo(CircleType::class);
    }

}
