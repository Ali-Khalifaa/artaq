<?php

namespace App\Models;

use App\Traits\SearchFilterTrait;
use App\Traits\TranslationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CircleType extends Model
{
    use HasFactory,SoftDeletes , TranslationsTrait,SearchFilterTrait;

    protected $guarded = ['id'];

    protected $table = "circle_types";

    public function circles()
    {
        return $this->hasMany(Circle::class);
    }

}
