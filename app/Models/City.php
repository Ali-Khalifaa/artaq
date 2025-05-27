<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "cities";

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'city_id');
    }
}
